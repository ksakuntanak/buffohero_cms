<?php
class Controller_Employee extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";

        $data['employees'] = Model_Employee::get_employees($page);

        $data['page'] = $page;
        $data['total_page'] = ceil($data['employees']['total']/20);

        $config = array(
            'pagination_url' => "",
            'total_items'    => $data['employees']['total'],
            'per_page'       => 20,
            'uri_segment'    => 2,
            'current_page'   => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Employees");
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'employee/index')->set($data);

    }

    public function action_view($id = null) {

        is_null($id) and Response::redirect('employee');

        $employee = Model_Employee::get_employee($id);

        $data['employee'] = $employee;

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces('th'));

        $this->theme->get_template()->set_global('current_menu', "Employees");
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee'), 'active' => false),
            array('title' => "View", 'icon' => "fa-eye", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'employee/view')->set($data);

    }
    
    /* create - edit */
    public function action_create() {

        try {

            if(Input::method() == 'POST'){


                $val = Model_Employee::validate('edit');

                $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
                $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');

                $file = Input::file('employee_photo_file');

                $error = false;

                if ($val->run()) {

                    $employee_photo = "";

                    if($file['size'] > 0){

                        $allowList = array(".jpg",".png");

                        $ext = substr($file['name'],strrpos($file['name'],"."));

                        if(!in_array($ext,$allowList)){
                            Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                            $error = true;
                        }

                        $path = realpath(DOCROOT."/../../uploads/profile_photo/employee/").DS;

                        $filename = md5($file['name']);

                        if(@copy($file['tmp_name'],$path.$filename."-o".$ext)){

                            $employee_photo = $filename.$ext;

                            /* cropped, default, and retina images */
                            if($ext === ".jpg") $image = imagecreatefromjpeg($path.$filename."-o".$ext);
                            else if($ext === ".png") $image = imagecreatefrompng($path.$filename."-o".$ext);

                            $width = imagesx($image);
                            $height = imagesy($image);

                            $photo_width = Input::post('photo_width')?Input::post('photo_width'):$width;
                            $photo_height = Input::post('photo_height')?Input::post('photo_height'):$height;

                            $default_image = imagecreatetruecolor(360,360);
                            $black = imagecolorallocate($default_image,0,0,0);
                            imagecolortransparent($default_image,$black);
                            imagecopyresized($default_image,$image,0,0,0,0,360,360,$photo_width,$photo_height);
                            if($ext === ".jpg") imagejpeg($default_image,$path.$filename.$ext);
                            else if($ext === ".png") imagepng($default_image,$path.$filename.$ext);

                            $retina_image = imagecreatetruecolor(720,720);
                            $black = imagecolorallocate($retina_image,0,0,0);
                            imagecolortransparent($retina_image,$black);
                            imagecopyresized($retina_image,$image,0,0,0,0,720,720,$photo_width,$photo_height);
                            if($ext === ".jpg") imagejpeg($retina_image,$path.$filename."@2x".$ext);
                            else if($ext === ".png") imagepng($retina_image,$path.$filename."@2x".$ext);

                        }

                    }

                    if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                        Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                        $error = true;
                    }

                    if(!$error) {

                        $user = Model_User::get_user_by_email(Input::post('username'));

                        if(!$user){

                            $user = Model_User::forge(array(
                                'username' => Input::post('username'),
                                'password' => Auth::instance()->hash_password(Input::post('password')),
                                'email' => Input::post('username'),
                                'group' => 1,
                                'profile_fields' => "",
                                'last_login' => 0,
                                'login_hash' => "",
                                'created_at' => time()
                            ));

                            $user->save();

                        }

                        $employee = Model_Employee::forge(array(
                            'user_id' => $user->id,
                            'employee_title' => "",
                            'employee_other_title' => "",
                            'employee_firstname' => Input::post('employee_firstname'),
                            'employee_lastname' => Input::post('employee_lastname'),
                            'employee_nickname' => Input::post('employee_nickname'),
                            'employee_display_name' => Input::post('employee_display_name'),
                            'employee_display_position' => Input::post('employee_display_position'),
                            'employee_gender' => Input::post('employee_gender'),
                            'employee_nationality' => "",
                            'employee_other_nationality' => "",
                            'employee_bdate' => Input::post('employee_bdate'),
                            'employee_addr' => Input::post('employee_addr'),
                            'province_id' => Input::post('province_id'),
                            'employee_zipcode' => "",
                            'employee_country' => "",
                            'employee_phone' => Input::post('employee_phone'),
                            'employee_email' => Input::post('employee_email'),
                            'employee_website' => Input::post('employee_website'),
                            'employee_facebook' => Input::post('employee_facebook'),
                            'employee_twitter' => Input::post('employee_twitter'),
                            'employee_gplus' => Input::post('employee_gplus'),
                            'employee_weight' => Input::post('employee_weight'),
                            'employee_height' => Input::post('employee_height'),
                            'employee_prefer' => Input::post('employee_prefer'),
                            'employee_about' => Input::post('employee_about'),
                            'employee_skills' => "",
                            'employee_photo' => $employee_photo,
                            'employee_is_featured' => 0,
                            'employee_is_active' => 1,
                            'created_at' => time()
                        ));

                        if ($employee->save()) {

                            $custom = Model_EmployeeCustom::forge(array(
                                'employee_id' => $employee->id,
                                'layout' => "default",
                                'theme' => "default",
                                'display_name_font' => "Philosopher",
                                'display_name_font_size' => 26,
                                'display_name_font_color' => "rgba(255,255,255,0.8)",
                                'display_position_font' => "Philosopher",
                                'display_position_font_color' => "rgba(255,255,255,0.8)",
                                'social_link_badges_color' => "rgba(255,255,255,0.8)",
                                'wallpaper' => "",
                                'working_status' => 0,
                                'resume_published' => 1,
                                'portfolio_published' => 1,
                                'created_at' => time()
                            ));

                            $custom->save();

                            Session::set_flash('success', 'Updated employee #'.$employee->id);
                            Response::redirect('employee');

                        } else {
                            Session::set_flash('error', 'Could not update employee #'.$employee->id);
                        }

                    }

                } else {

                    $msg = '<ul>';

                    foreach ($val->error() as $field => $error){
                        $msg .= '<li>'.$error->get_message().'</li>';
                    }

                    $msg .= '</ul>';

                    Session::set_flash('error', $msg);

                }

            }

            $this->theme->set_template('edit');

            $this->theme->get_template()->set('current_menu', "Employees");
            $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");

            $this->theme->get_template()->set('breadcrumb', array(
                array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
                array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee/index'), 'active' => false),
                array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
            ));

            $this->theme->get_template()->set_global('menu',"create",false);

            $this->theme->set_partial('sidebar','common/sidebar');
            $this->theme->set_partial('left', 'employee/create');

            $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);

        } catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function action_edit($id = null) {

        is_null($id) and Response::redirect('employee');

        $employee = Model_Employee::find($id);

        if (!$employee) {
            Session::set_flash('error', 'Could not find employee #'.$id);
            Response::redirect('employee');
        }

        if($employee->user_id){
            $user = Model_User::find($employee->user_id);
            $custom = Model_EmployeeCustom::get_employee_custom($employee->id);
        } else {
            $user = null;
            $custom = null;
        }

        if(Input::method() == 'POST'){

            $val = Model_Employee::validate('edit');

            if($user && strlen(Input::post('password'))){
                $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
                $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');
            }

            $file = Input::file('employee_photo_file');

            $error = false;

            if ($val->run()) {

                $employee_photo = "";

                if($file['size'] > 0){

                    $allowList = array(".jpg",".png");

                    $ext = substr($file['name'],strrpos($file['name'],"."));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $path = realpath(DOCROOT."/../../uploads/profile_photo/employee/").DS;

                    $filename = md5($file['name']);

                    if(@copy($file['tmp_name'],$path.$filename."-o".$ext)){

                        $employee_photo = $filename.$ext;

                        /* cropped, default, and retina images */
                        if($ext === ".jpg") $image = imagecreatefromjpeg($path.$filename."-o".$ext);
                        else if($ext === ".png") $image = imagecreatefrompng($path.$filename."-o".$ext);

                        $width = imagesx($image);
                        $height = imagesy($image);

                        $photo_width = Input::post('photo_width')?Input::post('photo_width'):$width;
                        $photo_height = Input::post('photo_height')?Input::post('photo_height'):$height;

                        $default_image = imagecreatetruecolor(360,360);
                        $black = imagecolorallocate($default_image,0,0,0);
                        imagecolortransparent($default_image,$black);
                        imagecopyresized($default_image,$image,0,0,0,0,360,360,$photo_width,$photo_height);
                        if($ext === ".jpg") imagejpeg($default_image,$path.$filename.$ext);
                        else if($ext === ".png") imagepng($default_image,$path.$filename.$ext);

                        $retina_image = imagecreatetruecolor(720,720);
                        $black = imagecolorallocate($retina_image,0,0,0);
                        imagecolortransparent($retina_image,$black);
                        imagecopyresized($retina_image,$image,0,0,0,0,720,720,$photo_width,$photo_height);
                        if($ext === ".jpg") imagejpeg($retina_image,$path.$filename."@2x".$ext);
                        else if($ext === ".png") imagepng($retina_image,$path.$filename."@2x".$ext);

                    }

                }

                if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                    Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                    $error = true;
                }

                if(!$error) {

                    if($user){

                        if(strlen(Input::post('password')))
                            $user->password = Auth::instance()->hash_password(Input::post('password'));

                        $user->save();

                    }

                    $employee->employee_firstname = Input::post('employee_firstname');
                    $employee->employee_lastname = Input::post('employee_lastname');
                    $employee->employee_nickname = Input::post('employee_nickname');
                    $employee->employee_display_name = Input::post('employee_display_name');
                    $employee->employee_display_position = Input::post('employee_display_position');
                    $employee->employee_gender = Input::post('employee_gender');
                    $employee->employee_bdate = Input::post('employee_bdate');
                    $employee->employee_addr = Input::post('employee_addr');
                    $employee->province_id = Input::post('province_id');
                    $employee->employee_phone = Input::post('employee_phone');
                    $employee->employee_email = Input::post('employee_email');
                    $employee->employee_website = Input::post('employee_website');
                    $employee->employee_facebook = Input::post('employee_facebook');
                    $employee->employee_twitter = Input::post('employee_twitter');
                    $employee->employee_gplus = Input::post('employee_gplus');
                    $employee->employee_weight = Input::post('employee_weight');
                    $employee->employee_height = Input::post('employee_height');
                    $employee->employee_prefer = Input::post('employee_prefer');
                    $employee->employee_about = Input::post('employee_about');

                    if(strlen($employee_photo)) $employee->employee_photo = $employee_photo;

                    $employee->employee_is_active = Input::post('employee_is_active');

                    if ($employee->save()) {

                        $custom->working_status = Input::post('working_status');
                        $custom->resume_published = Input::post('resume_published');
                        $custom->portfolio_published = Input::post('portfolio_published');

                        $custom->save();

                        Session::set_flash('success', 'Updated employee #' . $id);
                        Response::redirect('employee');

                    } else {

                        Session::set_flash('error', 'Could not update employee #' . $id);

                    }

                }

            } else {

                $employee->employee_firstname = Input::post('employee_firstname');
                $employee->employee_lastname = Input::post('employee_lastname');
                $employee->employee_nickname = Input::post('employee_nickname');
                $employee->employee_display_name = Input::post('employee_display_name');
                $employee->employee_display_position = Input::post('employee_display_position');
                $employee->employee_gender = Input::post('employee_gender');
                $employee->employee_bdate = Input::post('employee_bdate');
                $employee->employee_addr = Input::post('employee_addr');
                $employee->province_id = Input::post('province_id');
                $employee->employee_phone = Input::post('employee_phone');
                $employee->employee_email = Input::post('employee_email');
                $employee->employee_website = Input::post('employee_website');
                $employee->employee_facebook = Input::post('employee_facebook');
                $employee->employee_twitter = Input::post('employee_twitter');
                $employee->employee_gplus = Input::post('employee_gplus');
                $employee->employee_weight = Input::post('employee_weight');
                $employee->employee_height = Input::post('employee_height');
                $employee->employee_prefer = Input::post('employee_prefer');
                $employee->employee_about = Input::post('employee_about');
                $employee->employee_is_active = Input::post('employee_is_active');

                $msg = '<ul>';

                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }

                $msg .= '</ul>';

                Session::set_flash('error', $msg);

            }

        }

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('employee', $employee, false);
        $this->theme->get_template()->set_global('user', $user, false);
        $this->theme->get_template()->set_global('custom', $custom, false);

        $this->theme->get_template()->set('current_menu', "Employees");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('menu',"edit",false);

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('left', 'employee/edit');

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);

    }
    /* */

    public function action_portfolio($id = null) {

        is_null($id) and Response::redirect('employee');

        $employee = Model_Employee::get_employee($id);

        $data['employee'] = $employee;

        $portfolios = Model_Portfolio::get_portfolios($id);

        $data['portfolios'] = $portfolios;

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces('th'));

        $this->theme->get_template()->set_global('current_menu', "Employees");
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee'), 'active' => false),
            array('title' => "Portfolios", 'icon' => "fa-picture-o", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'employee/portfolio')->set($data);

    }

    public function action_delete($id = null) {

        is_null($id) and Response::redirect('employee');

        if ($employee = Model_Employee::find($id)) {

            $user = Model_User::find($employee->user_id);

            // delete all user's record
            DB::query("DELETE FROM buff_jobs_views WHERE user_id = ".$employee->user_id)->execute();

            DB::query("DELETE FROM buff_expects WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_experiences WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_portfolios WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_schools WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_skills WHERE employee_id = ".$id)->execute();

            DB::query("DELETE FROM buff_employees_customs WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_employees_favorites WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_employees_picks WHERE employee_id = ".$id)->execute();

            DB::query("DELETE FROM buff_jobs_applys WHERE employee_id = ".$id)->execute();
            DB::query("DELETE FROM buff_jobs_favorites WHERE employee_id = ".$id)->execute();

            // delete user
            $user->delete();

            // delete employee
            $employee->delete();

            Session::set_flash('success', 'Deleted employee #' . $id);

        } else {
            Session::set_flash('error', 'Could not delete employee #' . $id);
        }

        Response::redirect('employee');

    }

    public function action_staffPicks(){

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";

        $data['employees'] = Model_EmployeePick::get_staff_picks($page);

        $data['page'] = $page;
        $data['total_page'] = ceil($data['employees']['total']/20);

        $config = array(
            'pagination_url' => "",
            'total_items'    => $data['employees']['total'],
            'per_page'       => 20,
            'uri_segment'    => 2,
            'current_page'   => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Employees");
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee'), 'active' => false),
            array('title' => "Staff Picks", 'icon' => "fa-star", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'employee/staff_picks')->set($data);

    }

    public function action_addStaffPick($id){

        is_null($id) and Response::redirect('employee');

        $employee = Model_Employee::find($id);

        if(Input::method() == "POST"){

            try {

                $file = Input::file('pick_photo_file');

                $config = array(
                    'path' => "/var/www/html/uploads/staffpick_cover/",
                    'ext_whitelist' => array('jpg', 'jpeg', 'png'),
                    'file_chmod' => 0777,
                    'auto_rename' => true,
                    'overwrite' => true,
                    'randomize' => true,
                    'create_path' => true
                );

                Upload::process($config);

                if (Upload::is_valid()) {

                    Upload::save();

                    $pick_photo = Upload::get_files()[0];

                    $pick = Model_EmployeePick::forge(array(
                        'employee_id' => Input::post('employee_id'),
                        'pick_type' => Input::post('pick_type'),
                        'pick_date' => Input::post('pick_date'),
                        'pick_photo' => $pick_photo?$pick_photo['saved_as']:"",
                        'pick_is_active' => Input::post('pick_is_active'),
                        'created_at' => time()
                    ));

                    if($pick && $pick->save()){

                        $titles = Input::post('skill_title');
                        $levels = Input::post('skill_level');

                        foreach($titles as $key => $val){

                            if(!strlen($val)) continue;

                            $skill = Model_EmployeePickSkill::forge(array(
                                'pick_id' => $pick->id,
                                'skill_title' => $val,
                                'skill_level' => $levels[$key],
                                'created_at' => time()
                            ));

                            $skill->save();

                        }

                        Session::set_flash('success', 'Added employee #'.$id.' to Staff Picks.');
                        Response::redirect('employee/staffPicks');

                    } else {
                        Session::set_flash('error', 'Could not save employee pick.');
                    }

                }

            } catch(Exception $e){
                die($e->getMessage());
            }

        }

        $data['employee'] = $employee;

        $skills = Model_Skill::get_computer_skills($id);
        $data['skills'] = $skills;

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('employee', $employee, false);
        $this->theme->get_template()->set_global('skills', $skills, false);

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces('th'));

        $this->theme->get_template()->set_global('current_menu', "Employees");
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "fa-users", 'link' => Uri::create('employee'), 'active' => false),
            array('title' => "Add Staff Pick", 'icon' => "fa-plus", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'employee/add_staff_pick')->set($data);

    }

    public function action_deleteStaffPick($id = null) {

        is_null($id) and Response::redirect('employee/staffPicks');

        if ($pick = Model_EmployeePick::find($id)) {

            $pick->delete();

            Session::set_flash('success', 'Deleted Staff Pick #' . $id);

        } else {
            Session::set_flash('error', 'Could not delete Staff Pick #' . $id);
        }

        Response::redirect('employee/staffPicks');

    }

    public function action_deletePortfolio($id = null) {

        try {

        is_null($id) and Response::redirect('employee');

        if ($portfolio = Model_Portfolio::find($id)) {

            $employee_id = $portfolio->employee_id;

            $portfolio->delete();

            Session::set_flash('success', 'Deleted Portfolio #' . $id);

            Response::redirect('employee/portfolio/'.$employee_id);

        } else {

            Session::set_flash('error', 'Could not delete Portfolio #' . $id);

            Response::redirect('employee');

        }

        } catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
