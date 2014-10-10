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

    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
