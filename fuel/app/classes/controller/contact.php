<?php

class Controller_Contact extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";

        if (strlen($query)) {
            
            $data['contacts'] = DB::select('*')->from('contacts')
                ->where('subject','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->order_by('created_at','desc')
                ->execute()->as_array();
            
        } else {
            
            $data['contacts'] = DB::select('*')->from('contacts')
                ->limit(30)->offset(($page-1)*30)
                ->order_by('created_at','desc')
                ->execute()->as_array();
            
        }

        $total_rec = DB::count_last_query();

        $data['total_page'] = ceil($total_rec/30);
        $data['page'] = $page;

        $config = array(
            'pagination_url' => "",
            'total_items'    => $total_rec,
            'per_page'       => 30,
            'uri_segment'    => 2,
            'current_page' => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $cats = Model_Category::get_categories();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Contact", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการข้อความติดต่อเราในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Contact", 'icon' => "fa-envelope-o", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);
        $this->theme->get_template()->set_global('cats',$cats,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'contact/index')->set($data);

    }

    public function action_view($id = null) {

        is_null($id) and Response::redirect('contact');

        $contact = Model_Contact::find($id);

        $data['contact'] = $contact;

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Contact", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการข้อความติดต่อเราในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Contact", 'icon' => "fa-envelope-o", 'link' => Uri::create('contact'), 'active' => false),
            array('title' => "View", 'icon' => "fa-eye", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'contact/view')->set($data);

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('contact');
        if ($contact = Model_Contact::find($id)) {
            $contact->delete();
            Session::set_flash('success', 'Deleted contact #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete contact #' . $id);
        }
        Response::redirect('contact');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
