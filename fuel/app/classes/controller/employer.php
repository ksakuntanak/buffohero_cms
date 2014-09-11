<?php

class Controller_Employer extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index($page = 1, $query = "") {

        if (strlen($query)) {
            $data['employers'] = DB::select('*')->from('employers')->where('employer_name','LIKE','%'.$query.'%')->execute()->as_array();
        } else {
            $data['employers'] = DB::select('*')->from('employers')->execute()->as_array();
        }

        $data['page'] = $page;

        $config = array(
            'pagination_url' => Uri::create('employer/index/'),
            'total_items'    => Model_Employer::count(),
            'per_page'       => 30,
            'uri_segment'    => 4
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $this->theme->set_template('index');
        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "eicon-vcard", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('query',$query,false);

        $this->theme->set_partial('content', 'employer/index')->set($data);
    }

    public function action_view($id = null) {
        is_null($id) and Response::redirect('employer');

        if (!$data['employer'] = Model_Employer::find($id)) {
            Session::set_flash('error', 'Could not find employer #' . $id);
            Response::redirect('employer');
        }

        $this->template->title = "Employer";
        $this->template->content = View::forge('employer/view', $data);
    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $file = Input::file('employer_logo');

            $val = Model_Employer::validate('create');

            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');

            $error = false;

            if ($val->run()) {

                $allowList = array(".gif", ".jpeg", ".jpg", ".png");

                $ext = substr($file['name'],strrpos($file['name'],"."));

                if(!in_array($ext,$allowList)){
                    Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                    $error = true;
                }

                if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                    Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                    $error = true;
                }

                if(!$error) {

                    $path = DOCROOT.'uploads'.DS;

                    $filename = md5($file['name']).$ext;

                    $employer_logo_file = "";

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $employer_logo_file = $filename;
                    } else {
                        $employer_logo_file = "";
                    }

                    /*$config = array(
                        'path' => DOCROOT.DS.'uploads',
                        'randomize' => true,
                        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    );

                    Upload::process($config);

                    // if a valid file is passed than the function will save, or if its not empty
                    if (Upload::is_valid()){
                        Upload::save();
                        $value = Upload::get_files();
                        $employer_logo_file = $value[0]['saved_as'];
                    } else {
                        $employer_logo_file = "";
                    }*/

                    $created_date = date('Y-m-d H:i:s');

                    $employer = Model_Employer::forge(array(
                        'username' => Input::post('username'),
                        'password' => Auth::instance()->hash_password(Input::post('password')),
                        'email' => Input::post('employer_email'),
                        'employer_name' => Input::post('employer_name'),
                        'employer_desc' => Input::post('employer_desc'),
                        'employer_addr' => Input::post('employer_addr'),
                        'employer_tel' => Input::post('employer_tel'),
                        'employer_fax' => Input::post('employer_fax'),
                        'employer_email' => Input::post('employer_email'),
                        'employer_website' => Input::post('employer_website'),
                        'employer_logo_file' => $employer_logo_file,
                        'created_date' => $created_date,
                        'last_login' => Input::post('last_login'),
                        'login_hash' => Input::post('login_hash')
                    ));

                    if ($employer and $employer->save()){
                        Session::set_flash('success', 'Added employer #' . $employer->id . '.');
                        Response::redirect('employer');
                    } else {
                        Session::set_flash('error', 'Could not save employer.');
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
        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "eicon-vcard", 'link' => Uri::create('employer/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('menu',"create",false);
        $this->theme->set_partial('left', 'employer/create');
    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('employer');

        $this->theme->set_template('edit');
        $this->theme->get_template()->set('current_menu', "Employers");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้ว่าจ้างทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employers", 'icon' => "eicon-vcard", 'link' => Uri::create('employer/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        if (!$employer = Model_Employer::find($id)) {
            Session::set_flash('error', 'Could not find employer #' . $id);
            Response::redirect('employer');
        }

        $val = Model_Employer::validate('edit');

        if(strlen(Input::post('password'))){
            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');
        }

        $file = Input::file('employer_logo');

        $error = false;

        if ($val->run()) {

            if(strlen($file['name'])){

                $allowList = array(".gif", ".jpeg", ".jpg", ".png");

                $ext = substr($file['name'],strrpos($file['name'],"."));

                if(!in_array($ext,$allowList)){
                    Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                    $error = true;
                }

            }

            if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                $error = true;
            }

            if(!$error) {

                $employer_logo_file = Input::post('employer_logo_file');

                if(strlen($file['name'])){

                    $path = DOCROOT.'uploads'.DS;

                    $filename = md5($file['name']).$ext;

                    if(strlen(Input::post('employer_logo_file'))){
                        @unlink($path.Input::post('employer_logo_file'));
                    }

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $employer_logo_file = $filename;
                    }

                }

                /*$config = array(
                    'path' => DOCROOT.DS.'uploads',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );

                $upload = \Fuel\Core\Upload::instance();

                $upload->process($config);

                // if a valid file is passed than the function will save, or if its not empty
                if ($upload->is_valid()){
                    $upload->save();
                    $value = $upload->get_files();
                    $employer_logo_file = $value[0]['saved_as'];
                } else {
                    $employer_logo_file = "";
                }*/

                $employer->username = Input::post('username');
                if(strlen(Input::post('password'))) $employer->password = Auth::instance()->hash_password(Input::post('password'));
                $employer->email = Input::post('employer_email');
                $employer->employer_name = Input::post('employer_name');
                $employer->employer_desc = Input::post('employer_desc');
                $employer->employer_addr = Input::post('employer_addr');
                $employer->employer_tel = Input::post('employer_tel');
                $employer->employer_fax = Input::post('employer_fax');
                $employer->employer_email = Input::post('employer_email');
                $employer->employer_website = Input::post('employer_website');
                $employer->employer_logo_file = $employer_logo_file;
                $employer->created_date = Input::post('created_date');
                $employer->last_login = Input::post('last_login');
                $employer->login_hash = Input::post('login_hash');

                if ($employer->save()) {
                    Session::set_flash('success', 'Updated employer #' . $id);
                    Response::redirect('employer');
                } else {
                    Session::set_flash('error', 'Could not update employer #' . $id);
                }

            }

        } else {
            if (Input::method() == 'POST') {
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
            $this->theme->get_template()->set_global('employer', $employer, false);
        }
        $this->theme->get_template()->set_global('menu',"edit",false);
        $this->theme->set_partial('left', 'employer/edit');
    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('employer');
        if ($employer = Model_Employer::find($id)) {
            $employer->delete();
            Session::set_flash('success', 'Deleted employer #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete employer #' . $id);
        }
        Response::redirect('employer');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
