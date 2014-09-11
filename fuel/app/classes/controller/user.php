<?php

class Controller_User extends Controller_Common {

    public function before(){
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";

        if (strlen($query)) {
            $data['users'] = DB::select('*')->from('users')
                ->where('group','=','100')
                ->and_where('username','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        } else {
            $data['users'] = DB::select('*')->from('users')
                ->where('group','=','100')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        }

        $total_rec = DB::count_last_query();

        $data['page'] = $page;
        $data['total_page'] = ceil($total_rec/30);

        $config = array(
            'pagination_url' => "",
            'total_items'    => $total_rec,
            'per_page'       => 30,
            'uri_segment'    => 2,
            'current_page'		 => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $groups = array(
            -1	=> 'Banned',
            0	=> 'Guests',
            1	=> 'Users',
            100	=> 'Administrators'
        );

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Users",false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งาน CMS ทั้งหมดในระบบ",false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Users", 'icon' => "fa-users", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('query',$query,false);
        $this->theme->get_template()->set_global('groups',$groups,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'user/index')->set($data);
    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $val = Model_User::validate('create');

            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');

            if ($val->run()) {

                if(Input::post('password') != Input::post('password_re')){
                    Session::set_flash('error', 'Password is not matched.');
                } else {

                    $user = Model_User::forge(array(
                        'username' => Input::post('username'),
                        'password' => Auth::instance()->hash_password(Input::post('password')),
                        'group' => Input::post('group'),
                        'email' => Input::post('email'),
                        'profile_fields' => Input::post('profile_fields'),
                        'last_login' => Input::post('last_login'),
                        'login_hash' => Input::post('login_hash')
                    ));

                    if ($user and $user->save()){
                        Session::set_flash('success', 'Added user #' . $user->id . '.');
                        Response::redirect('user');
                    } else {
                        Session::set_flash('error', 'Could not save user.');
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
        $this->theme->get_template()->set_global('current_menu', "Users", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งาน CMS ทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Users", 'icon' => "fa-users", 'link' => Uri::create('user/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('menu',"create",false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'user/create');

    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('user');

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('current_menu', "Users", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการผู้ใช้งาน CMS ทั้งหมดในระบบ", false)
        ;
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Users", 'icon' => "fa-users", 'link' => Uri::create('user/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        if (!$user = Model_User::find($id)) {
            Session::set_flash('error', 'Could not find user #' . $id);
            Response::redirect('user');
        }

        $val = Model_User::validate('edit');

        if(strlen(Input::post('password'))){
            $val->add_field('password', 'Password', 'required|min_length[8]|max_length[20]');
            $val->add_field('password_re', 'Re-type Password', 'required|min_length[8]|max_length[20]');
        }

        $val->set_message('required', 'The field :label is required.');

        if ($val->run()) {

            if(strlen(Input::post('password')) && Input::post('password') != Input::post('password_re')){
                Session::set_flash('error', 'Password is not matched.');
            } else {

                $user->username = Input::post('username');
                if(strlen(Input::post('password'))) $user->password = Auth::instance()->hash_password(Input::post('password'));
                $user->group = Input::post('group');
                $user->email = Input::post('email');
                $user->profile_fields = Input::post('profile_fields');
                $user->last_login = Input::post('last_login');
                $user->login_hash = Input::post('login_hash');

                if ($user->save()) {
                    Session::set_flash('success', 'Updated user #' . $id);
                    Response::redirect('user');
                } else {
                    Session::set_flash('error', 'Could not update user #' . $id);
                }

            }

        } else {
            if (Input::method() == 'POST') {
                $user->username = $val->validated('username');
                $user->password = $val->validated('password');
                $user->email = $val->validated('email');
                $msg = '<ul>';
                foreach ($val->error() as $field => $error){
                    $msg .= '<li>'.$error->get_message().'</li>';
                }
                $msg .= '</ul>';
                Session::set_flash('error', $msg);
            }
            $this->theme->get_template()->set_global('user', $user, false);
        }

        $this->theme->get_template()->set_global('menu',"edit",false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'user/edit');

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('user');
        if ($user = Model_User::find($id)) {
            $user->delete();
            Session::set_flash('success', 'Deleted user #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete user #' . $id);
        }
        Response::redirect('user');
    }

    public function action_login() {

        if (Session::get('cms_user_id')) {
            Response::redirect('home');
        }

        if (Input::method() == 'POST') {

            $auth = Auth::instance();

            if ($auth->login(Input::post('username'), Input::post('password'))) {

                $user = Auth::instance()->get_user_id();
                $user_id = $user[1];

                Session::set('cms_user_id',$user_id);

                Session::set_flash('success', 'You have logged in!');
                Response::redirect('home');

            } else {

                Session::set_flash('error', 'Invalid login credentials please try again  !');

            }
        }

        $this->theme->set_template('login');
        $this->theme->get_template()->set('title',"BuffoHero CMS");
        $this->theme->get_template()->set('current_menu',"Login");
        $this->theme->get_template()->set('current_menu_desc',"เข้าสู่ระบบ");

    }

    public function action_logout() {

        Session::set('cms_user_id',null);

        Auth::logout();

        Session::set_flash('success', 'You have been successfully logged out');
        Response::redirect('user/login');

    }

    public function after($response){
        if (empty($response) or  ! $response instanceof Response){
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}