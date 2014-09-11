<?php

class Controller_Client extends Controller_Common {

    public function before(){
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index($page = 1, $query = "") {

        if (strlen($query)) {
            $data['clients'] = DB::select('*')->from('clients')
                ->and_where('client_title','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        } else {
            $data['clients'] = DB::select('*')->from('clients')
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
            'current_page' => $page
        );
        $pagination = Pagination::forge('pagenav',$config);
        $data['pagination'] = $pagination->render();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('path', "http://www.buffohero.com/uploads/client_photo/",false);

        $this->theme->get_template()->set_global('current_menu', "Clients",false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการลูกค้าทั้งหมดในระบบ",false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Clients", 'icon' => "fa-smile-o", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('query',$query,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'client/index')->set($data);
    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $val = Model_Client::validate('create');

            if ($val->run()) {

                $file = Input::file('client_photo_file');

                $error = false;

                $allowList = array(".jpeg", ".jpg", ".png");

                $path = realpath(DOCROOT."/../../uploads/client_photo/").DS;

                $client_photo = "";

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time());

                    if(@copy($file['tmp_name'],$path.$filename.'-o'.$ext)){

                        $client_photo = $filename.$ext;

                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 330, 128);

                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }

                if(!$error){

                    $client = Model_Client::forge(array(
                        'client_title' => Input::post('client_title'),
                        'client_url' => Input::post('client_url'),
                        'client_photo' => $client_photo,
                        'client_active' => 1,
                        'created_at' => time()
                    ));

                    if ($client and $client->save()){
                        Session::set_flash('success', 'Added client #' . $client->id . '.');
                        Response::redirect('client');
                    } else {
                        Session::set_flash('error', 'Could not save client.');
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
        $this->theme->get_template()->set_global('current_menu', "Clients", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการลูกค้าทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Clients", 'icon' => "fa-smile-o", 'link' => Uri::create('client/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));
        $this->theme->get_template()->set_global('menu',"create",false);

        $this->theme->get_template()->set('page_specific_js', "form_client.js");

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('left', 'client/create');

    }

    public function action_edit($id = null) {
        is_null($id) and Response::redirect('client');

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('current_menu', "Clients", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการลูกค้าทั้งหมดในระบบ", false)
        ;
        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Clients", 'icon' => "fa-smile-o", 'link' => Uri::create('client/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        if (!$client = Model_Client::find($id)) {
            Session::set_flash('error', 'Could not find client #' . $id);
            Response::redirect('client');
        }

        if (Input::method() == 'POST') {

            $val = Model_Client::validate('edit');

            if ($val->run()) {

                $file = Input::file('client_photo_file');

                $error = false;

                $allowList = array(".jpeg", ".jpg", ".png");

                $path = realpath(DOCROOT."/../../uploads/client_photo/").DS;

                $client_photo = "";

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time());

                    if(@copy($file['tmp_name'],$path.$filename.'-o'.$ext)){

                        $client_photo = $filename.$ext;

                        parent::create_cropped_thumbnail($path.$filename."-o".$ext, 330, 128);

                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }

                if(!$error){

                    if(strlen($client_photo) && strlen($client->client_photo)){

                        $old_ext = strtolower(substr($client->client_photo,strrpos($client->client_photo,".")));

                        $old_filename = substr($client->client_photo,0,strrpos($client->client_photo,"."));

                        @unlink($path.$old_filename.$old_ext);
                        @unlink($path.$old_filename."-o".$old_ext);

                    }

                    $client->client_title = Input::post('client_title');
                    $client->client_url = Input::post('client_url');
                    if(strlen($client_photo)) $client->client_photo = $client_photo;
                    $client->client_active = Input::post('client_active');

                    if ($client->save()){
                        Session::set_flash('success', 'Added client #' . $client->id . '.');
                        Response::redirect('client');
                    } else {
                        Session::set_flash('error', 'Could not save client.');
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

        $this->theme->get_template()->set_global('client',$client,false);
        $this->theme->get_template()->set_global('menu',"edit",false);

        $this->theme->get_template()->set('page_specific_js', "form_client.js");

        $this->theme->set_partial('sidebar','common/sidebar');
        $this->theme->set_partial('left', 'client/edit');

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('client');
        if ($client = Model_Client::find($id)) {
            $client->delete();
            Session::set_flash('success', 'Deleted client #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete client #' . $id);
        }
        Response::redirect('client');
    }

    public function after($response){
        if (empty($response) or  ! $response instanceof Response){
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}