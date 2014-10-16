<?php

class Controller_Employer extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        try {

        $page = Input::get('page')?Input::get('page'):1;

        $data['employers'] = Model_Employer::get_employers($page);

        $data['page'] = $page;
        $data['total_page'] = ceil($data['employers']['total']/30);

        $config = array(
            'pagination_url' => "",
            'total_items' => $data['employers']['total'],
            'per_page' => 30,
            'uri_segment' => 2,
            'current_page' => $page
        );

        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $this->theme->set_template('index');
        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "fa-building-o", 'link' => "", 'active' => true)
        ));

        // $this->theme->get_template()->set_global('query',$query,false);

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('content', 'employer/index')->set($data);

        } catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function action_create() {

        try {

        if(Input::method() == 'POST'){


            $val = Model_Employer::validate('edit');

            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');

            $file = Input::file('employer_photo_file');

            $error = false;

            if ($val->run()) {

                $employer_photo = "";

                if($file['size'] > 0){

                    $allowList = array(".gif", ".jpeg", ".jpg", ".png");

                    $ext = substr($file['name'],strrpos($file['name'],"."));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $path = realpath(DOCROOT."/../../uploads/profile_photo/employer/").DS;

                    $filename = md5($file['name']).$ext;

                    if(strlen(Input::post('employer_photo_file'))){
                        @unlink($path.Input::post('employer_photo_file'));
                    }

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $employer_photo = $filename;
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

                    $employer = Model_Employer::forge(array(
                        'user_id' => $user->id,
                        'employer_name' => Input::post('employer_name'),
                        'employer_desc' => Input::post('employer_desc'),
                        'employer_addr' => Input::post('employer_addr'),
                        'province_id' => Input::post('province_id'),
                        'employer_tel' => Input::post('employer_tel'),
                        'employer_fax' => Input::post('employer_fax'),
                        'employer_email' => Input::post('employer_email'),
                        'employer_website' => Input::post('employer_website'),
                        'employer_photo' => $employer_photo,
                        'employer_is_active' => 1,
                        'created_at' => time()
                    ));

                    if ($employer->save()) {
                        Session::set_flash('success', 'Updated employer #'.$employer->id);
                        Response::redirect('employer');
                    } else {
                        Session::set_flash('error', 'Could not update employer #'.$employer->id);
                    }

                }

            } else {

                /*$employer->username = $val->validated('username');
                $employer->employer_name = $val->validated('employer_name');
                $employer->employer_desc = $val->validated('employer_desc');
                $employer->employer_addr = $val->validated('employer_addr');
                $employer->employer_tel = $val->validated('employer_tel');
                $employer->employer_fax = $val->validated('employer_fax');
                $employer->employer_email = $val->validated('employer_email');
                $employer->employer_website = $val->validated('employer_website');*/

                $msg = '<ul>';

                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }

                $msg .= '</ul>';

                Session::set_flash('error', $msg);

            }

        }

        $this->theme->set_template('edit');

        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "fa-building-o", 'link' => Uri::create('employer/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('menu',"create",false);

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('left', 'employer/create');

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);

        } catch(Exception $e){
            die($e->getMessage());
        }

    }

    public function action_edit($id = null) {

        is_null($id) and Response::redirect('employer');

        $employer = Model_Employer::find($id);

        if (!$employer) {
            Session::set_flash('error', 'Could not find employer #'.$id);
            Response::redirect('employer');
        }

        if($employer->user_id)
            $user = Model_User::find($employer->user_id);
        else
            $user = null;

        if(Input::method() == 'POST'){

            //print_r(Input::post()); exit();

            $val = Model_Employer::validate('edit');

            if($user && strlen(Input::post('password'))){
                $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
                $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');
            }

            $file = Input::file('employer_photo_file');

            $error = false;

            if ($val->run()) {

                $employer_photo = "";

                if($file['size'] > 0){

                    $allowList = array(".gif", ".jpeg", ".jpg", ".png");

                    $ext = substr($file['name'],strrpos($file['name'],"."));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $path = realpath(DOCROOT."/../../uploads/profile_photo/employer/").DS;

                    $filename = md5($file['name']).$ext;

                    if(strlen(Input::post('employer_photo_file'))){
                        @unlink($path.Input::post('employer_photo_file'));
                    }

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $employer_photo = $filename;
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

                    $employer->employer_name = Input::post('employer_name');
                    $employer->employer_desc = Input::post('employer_desc');
                    $employer->employer_addr = Input::post('employer_addr');
                    $employer->province_id = Input::post('province_id');
                    $employer->employer_tel = Input::post('employer_tel');
                    $employer->employer_fax = Input::post('employer_fax');
                    $employer->employer_email = Input::post('employer_email');
                    $employer->employer_website = Input::post('employer_website');
                    $employer->employer_is_active = Input::post('employer_is_active');

                    if(strlen($employer_photo)) $employer->employer_photo = $employer_photo;

                    if ($employer->save()) {

                        Session::set_flash('success', 'Updated employer #' . $id);
                        Response::redirect('employer');

                    } else {

                        Session::set_flash('error', 'Could not update employer #' . $id);

                    }

                }

            } else {

                $employer->username = $val->validated('username');
                $employer->employer_name = $val->validated('employer_name');
                $employer->employer_desc = $val->validated('employer_desc');
                $employer->employer_addr = $val->validated('employer_addr');
                $employer->employer_tel = $val->validated('employer_tel');
                $employer->employer_fax = $val->validated('employer_fax');
                $employer->employer_email = $val->validated('employer_email');
                $employer->employer_website = $val->validated('employer_website');

                $msg = '<ul>';

                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }

                $msg .= '</ul>';

                Session::set_flash('error', $msg);

            }

        }

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('employer', $employer, false);
        $this->theme->get_template()->set_global('user', $user, false);

        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "fa-building-o", 'link' => Uri::create('employer/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('menu',"edit",false);

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('left', 'employer/edit');

        $this->theme->get_template()->set_global('provinces', Model_Province::get_provinces("th"), false);

    }

    public function action_delete($id = null) {

        try {

        is_null($id) and Response::redirect('employer');

        if ($employer = Model_Employer::find($id)) {

            $user = Model_User::find($employer->user_id);

            // delete all user's record
            DB::query("DELETE FROM buff_resume_views WHERE employer_id = ".$id)->execute();

            DB::query("DELETE FROM buff_jobs WHERE employer_id = ".$id)->execute();

            // delete user
            $user->delete();

            // delete employer
            $employer->delete();

            Session::set_flash('success', 'Deleted employer #' . $id);

        } else {
            Session::set_flash('error', 'Could not delete employer #' . $id);
        }

        Response::redirect('employer');

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
