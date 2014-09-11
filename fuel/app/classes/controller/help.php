<?php

class Controller_Help extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";

        if (strlen($query)) {
            $data['helps'] = DB::select('*')->from('helps')
                ->where('help_title','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        } else {
            $data['helps'] = DB::select('*')->from('helps')
                ->limit(30)->offset(($page-1)*30)
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

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Helps", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการเนื้อหาในเมนูช่วยเหลือทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Helps", 'icon' => "fa-question-circle", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);

        $cats = Model_HelpCategory::get_help_categories();
        $this->theme->get_template()->set_global('cats',$cats,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'help/index')->set($data);

    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $val = Model_Help::validate('create');

            if ($val->run()) {

                $help = Model_Help::forge(array(
                    'cat_id' => Input::post('cat_id'),
                    'help_title_th' => Input::post('help_title_th'),
                    'help_title_en' => Input::post('help_title_en'),
                    'help_detail_th' => Input::post('help_detail_th'),
                    'help_detail_en' => Input::post('help_detail_en'),
                    'help_is_active' => Input::post('help_is_active'),
                    'created_at' => time()
                ));

                if ($help and $help->save()){
                    Session::set_flash('success', 'Added help #' . $help->id . '.');
                    Session::set_flash('error', '');
                    Response::redirect('help/edit/'.$help->id);
                } else {
                    Session::set_flash('success', '');
                    Session::set_flash('error', 'Could not save help.');
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

        $this->theme->get_template()->set_global('current_menu', "Helps", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการเนื้อหาในเมนูช่วยเหลือทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Helps", 'icon' => "fa-question-circle", 'link' => Uri::create('help/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $cats = Model_HelpCategory::get_help_categories();
        $this->theme->get_template()->set_global('cats', $cats, false);

        $this->theme->get_template()->set_global('mode', "create", false);

        $this->theme->get_template()->set('page_specific_js', "form_help.js");

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'help/create');

    }

    public function action_edit($id = null) {

        is_null($id) and Response::redirect('help');

        $this->theme->set_template('edit');

        $this->theme->get_template()->set_global('current_menu', "Helps", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการเนื้อหาในเมนูช่วยเหลือทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Helps", 'icon' => "fa-question-circle", 'link' => Uri::create('help/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('mode', "edit", false);

        if (!$help = Model_Help::find($id)) {
            Session::set_flash('error', 'Could not find help #' . $id);
            Response::redirect('help');
        }

        if(Input::method() == 'POST') {

            if(Input::post('action') == "edit_help") {

                $val = Model_Help::validate('edit');

                if ($val->run()) {

                    $help->cat_id = Input::post('cat_id');

                    $help->help_title_th = Input::post('help_title_th');
                    $help->help_title_en = Input::post('help_title_en');

                    $help->help_detail_th = Input::post('help_detail_th');
                    $help->help_detail_en = Input::post('help_detail_en');

                    $help->help_is_active = Input::post('help_is_active');

                    if ($help->save()) {
                        Session::set_flash('success', 'อัพเดตข้อมูลหัวข้อช่วยเหลือ #'.$id.' เรียบร้อยแล้ว');
                    } else {
                        Session::set_flash('error', 'Could not update help #' . $id);
                    }

                } else {

                    $msg = '<ul>';

                    foreach ($val->error() as $field => $error){
                        $msg .= '<li>'.$error->get_message().'</li>';
                    }
                    $msg .= '</ul>';
                    Session::set_flash('error', $msg);

                }

            } else if(Input::post('action') == "upload_photos") {

                $files = Input::file('help_photo_file');

                $photos = array();

                $allowList = array(".jpeg", ".jpg", ".png");

                $error = false;

                $path = realpath(DOCROOT."/../../uploads/help_photo/").DS;

                for($i = 0; $i < 5; $i++){

                    if($files['size'][$i] > 0){

                        $ext = strtolower(substr($files['name'][$i],strrpos($files['name'][$i],".")));

                        if(!in_array($ext,$allowList)){
                            Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                            $error = true;
                            break;
                        }

                        $filename = md5(time()+$i).$ext;

                        if(@copy($files['tmp_name'][$i],$path.$filename)){
                            $photos[$i] = $filename;
                        } else {
                            Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                            $error = true;
                            break;
                        }

                    }

                }

                if(!$error){

                    foreach($photos as $p){

                        $helpphoto = Model_HelpPhoto::forge(array(
                            'help_id' => Input::post('help_id'),
                            'photo_file_name' => $p,
                            'created_at' => time()
                        ));

                        $helpphoto->save();

                    }

                }

            } else if(Input::post('action') == "delete_photo") {

                $helpphoto = Model_HelpPhoto::find(Input::post('photo_id'));

                $path = realpath(DOCROOT."/../../uploads/help_photo/").DS;

                @unlink($path.$helpphoto->photo_file_name);

                $helpphoto->delete();

            }

        }

        $data['photos'] = Model_HelpPhoto::get_help_photos($id);

        $this->theme->get_template()->set_global('help', $help, false);

        $cats = Model_HelpCategory::get_help_categories();
        $this->theme->get_template()->set_global('cats', $cats, false);

        $this->theme->get_template()->set_global('path', "http://www.buffohero.com/uploads/help_photo/", false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->get_template()->set('page_specific_js', "form_help.js");

        $this->theme->set_partial('left', 'help/edit');
        $this->theme->set_partial('right', 'help/_imageupload')->set($data);

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('help');
        if ($help = Model_Help::find($id)) {
            $help->delete();
            Session::set_flash('success', 'Deleted help #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete help #' . $id);
        }
        Response::redirect('help');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
