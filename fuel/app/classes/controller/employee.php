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
            array('title' => "Employees", 'icon' => "eicon-users", 'link' => "", 'active' => true)
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
            array('title' => "Employees", 'icon' => "eicon-users", 'link' => Uri::create('employee'), 'active' => false),
            array('title' => "View", 'icon' => "fa-eye", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'employee/view')->set($data);

    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $val = Model_Employee::validate('create');

            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');

            if(Input::post('employee_title') == "other") $val->add_field('employee_other_title', 'คำนำหน้าอื่นๆ', 'required|max_length[255]');

            if(Input::post('employee_nationality') == "other") $val->add_field('employee_other_nationality', 'สัญชาติอื่นๆ', 'required|max_length[255]');

            $error = false;

            if ($val->run()) {

                if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                    Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                    $error = true;
                }

                if(!count(Input::post('employee_keywords'))){
                    Session::set_flash('error', 'กรุณาระบุสาขางานที่สนใจอย่างน้อย 1 อย่าง');
                    $error = true;
                }

                if(!$error) {

                    $created_date = date('Y-m-d H:i:s');

                    $employee = Model_Employee::forge(array(
                        'username' => Input::post('username'),
                        'password' => Auth::instance()->hash_password(Input::post('password')),
                        'email' => Input::post('username'),
                        'group' => 1,
                        'employee_title' => Input::post('employee_title'),
                        'employee_other_title' => Input::post('employee_other_title'),
                        'employee_first_name' => Input::post('employee_first_name'),
                        'employee_last_name' => Input::post('employee_last_name'),
                        'employee_gender' => Input::post('employee_gender'),
                        'employee_nationality' => Input::post('employee_nationality'),
                        'employee_other_nationality' => Input::post('employee_other_nationality'),
                        'employee_bdate' => Input::post('employee_bdate'),
                        'employee_addr' => Input::post('employee_addr'),
                        'employee_country' => Input::post('employee_country'),
                        'employee_mobile' => Input::post('employee_mobile'),
                        'employee_phone' => Input::post('employee_phone'),
                        'employee_weight' => Input::post('employee_weight'),
                        'employee_height' => Input::post('employee_height'),
                        'employee_job_type' => Input::post('employee_job_type'),
                        'employee_keywords' => implode(",",Input::post('employee_keywords')),
                        'employee_about' => Input::post('employee_about'),
                        'employee_skills' => Input::post('employee_skills'),
                        'created_date' => $created_date,
                        'last_login' => Input::post('last_login'),
                        'login_hash' => Input::post('login_hash')
                    ));

                    if ($employee and $employee->save()){
                        Session::set_flash('success', 'Added employee #' . $employee->id . '.');
                        Response::redirect('employee');
                    } else {
                        Session::set_flash('error', 'Could not save employee.');
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
        $this->theme->get_template()->set('page_specific_js', "form_employee.js");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "eicon-users", 'link' => Uri::create('employee/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('countries',Controller_Common::get_countries(),false);
        $this->theme->get_template()->set_global('cats',Model_Employee::get_job_cats(),false);
        $this->theme->get_template()->set_global('menu',"create",false);
        $this->theme->set_partial('left', 'employee/create');

    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('employee');

        $this->theme->set_template('edit');
        $this->theme->get_template()->set('current_menu', "Employees");
        $this->theme->get_template()->set('current_menu_desc', "จัดการผู้ใช้งานที่เป็นผู้หางานทั้งหมดในระบบ");
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Employees", 'icon' => "eicon-users", 'link' => Uri::create('employee/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        if (!$employee = Model_Employee::find($id)) {
            Session::set_flash('error', 'Could not find employee #' . $id);
            Response::redirect('employee');
        }

        /*if (Input::method() == 'POST') {
            $data = Input::post();
            print_r($data);
            exit();
        }*/

        $val = Model_Employee::validate('edit');

        if(strlen(Input::post('password'))){
            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');
        }

        if(Input::post('employee_title') == "other") $val->add_field('employee_other_title', 'คำนำหน้าอื่นๆ', 'required|max_length[255]');

        if(Input::post('employee_nationality') == "other") $val->add_field('employee_other_nationality', 'สัญชาติอื่นๆ', 'required|max_length[255]');

        $error = false;

        if ($val->run()) {

            if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                Session::set_flash('error', 'กรุณากรอก Password ทั้งสองช่องให้ตรงกัน');
                $error = true;
            }

            if(!count(Input::post('employee_keywords'))){
                Session::set_flash('error', 'กรุณาระบุสาขางานที่สนใจอย่างน้อย 1 อย่าง');
                $error = true;
            }

            if(!$error) {

                $employee->username = Input::post('username');
                if(strlen(Input::post('password'))) $employee->password = Auth::instance()->hash_password(Input::post('password'));
                $employee->email = Input::post('username');
                $employee->group = 1;
                $employee->employee_title = Input::post('employee_title');
                $employee->employee_other_title = Input::post('employee_other_title');
                $employee->employee_first_name = Input::post('employee_first_name');
                $employee->employee_last_name = Input::post('employee_last_name');
                $employee->employee_gender = Input::post('employee_gender');
                $employee->employee_nationality = Input::post('employee_nationality');
                $employee->employee_other_nationality = Input::post('employee_other_nationality');
                $employee->employee_bdate = Input::post('employee_bdate');
                $employee->employee_addr = Input::post('employee_addr');
                $employee->employee_country = Input::post('employee_country');
                $employee->employee_mobile = Input::post('employee_mobile');
                $employee->employee_phone = Input::post('employee_phone');
                $employee->employee_weight = Input::post('employee_weight');
                $employee->employee_height = Input::post('employee_height');
                $employee->employee_job_type = Input::post('employee_job_type');
                $employee->employee_keywords = implode(",",Input::post('employee_keywords'));
                $employee->employee_about = Input::post('employee_about');
                $employee->employee_skills = Input::post('employee_skills');
                $employee->created_date = Input::post('created_date');
                $employee->last_login = Input::post('last_login');
                $employee->login_hash = Input::post('login_hash');

                if ($employee->save()) {
                    Session::set_flash('success', 'Updated employee #' . $id);
                    Response::redirect('employee');
                } else {
                    Session::set_flash('error', 'Could not update employee #' . $id);
                }

            }

        } else {

            if (Input::method() == 'POST') {

                $employee->username = $val->validated('username');
                $employee->employee_title = $val->validated('employee_title');
                $employee->employee_other_title = $val->validated('employee_other_title');
                $employee->employee_first_name = $val->validated('employee_first_name');
                $employee->employee_last_name = $val->validated('employee_last_name');
                $employee->employee_gender = $val->validated('employee_gender');
                $employee->employee_nationality = $val->validated('employee_nationality');
                $employee->employee_other_nationality = $val->validated('employee_other_nationality');
                $employee->employee_bdate = $val->validated('employee_bdate');
                $employee->employee_weight = $val->validated('employee_weight');
                $employee->employee_height = $val->validated('employee_height');
                $employee->employee_addr = $val->validated('employee_addr');
                $employee->employee_country = $val->validated('employee_country');
                $employee->employee_mobile = $val->validated('employee_mobile');
                $employee->employee_phone = $val->validated('employee_phone');
                $employee->employee_job_type = $val->validated('employee_job_type');
                $employee->employee_keywords = implode(",",Input::post('employee_keywords'));
                $employee->employee_about = $val->validated('employee_about');
                $employee->employee_skills = $val->validated('employee_skills');

                $msg = '<ul>';
                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }
                $msg .= '</ul>';

                Session::set_flash('error', $msg);

            }

            $this->theme->get_template()->set_global('employee', $employee, false);

        }
        $this->theme->get_template()->set_global('countries',Controller_Common::get_countries(),false);
        $this->theme->get_template()->set_global('cats',Model_Employee::get_job_cats(),false);
        $this->theme->get_template()->set_global('menu',"edit",false);
        $this->theme->set_partial('left', 'employee/edit');
    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('employee');
        if ($employee = Model_Employee::find($id)) {
            $employee->delete();
            Session::set_flash('success', 'Deleted employee #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete employee #' . $id);
        }
        Response::redirect('employee');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
