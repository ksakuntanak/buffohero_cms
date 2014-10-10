<?php

class Controller_News extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";
        
        if (strlen($query)) {
            $data['news'] = DB::select('*')->from('news')
                ->where('news_title','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->order_by('id','desc')
                ->execute()->as_array();
        } else {
            $data['news'] = DB::select('*')->from('news')
                ->limit(30)->offset(($page-1)*30)
                ->order_by('id','desc')
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

        $this->theme->get_template()->set_global('current_menu', "News", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการข่าวทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "News", 'icon' => "eicon-newspaper", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);
        $this->theme->get_template()->set_global('cats',$cats,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'news/index')->set($data);

    }

    public function action_create() {
        try{
            if (Input::method() == 'POST') {

                $file = Input::file('news_photo_file');

                $val = Model_News::validate('create');

                if ($val->run()) {

                    $config = array(
                        'path' => "/var/www/html/uploads/news_photo/",
                        'ext_whitelist' => array('jpg', 'jpeg', 'png'),
                        'file_chmod' => 0777,
                        'auto_rename' => true,
                        'overwrite' => true,
                        'randomize' => true,
                        'create_path' => true
                    );
                    //  $allowList = array(".jpeg", ".jpg", ".png");

                    //  $error = false;

                    //  $path = realpath(DOCROOT."/../../uploads/news_photo/").DS;

                    $news_photo = "";
                    Upload::process($config);

                    if (Upload::is_valid()) {

                        Upload::save();

                        $news_photo = Upload::get_files()[0];

                        $news = Model_News::forge(array(
                            'news_title' => Input::post('news_title'),
                            'news_short_detail' => Input::post('news_short_detail'),
                            'news_detail' => Input::post('news_detail'),
                            'news_photo' => $news_photo['saved_as'],
                            'news_published' => Input::post('news_published'),
                            'created_at' => time(),
                            'published_at' => (Input::post('news_published')==1)?time():0
                        ));

                        if ($news and $news->save()){
                            Session::set_flash('success', 'Added news #' . $news->id . '.');
                            Response::redirect('news/edit/'.$news->id);
                        } else {
                            Session::set_flash('error', 'Could not save news.');
                        }

                        if($file and $file->save())
                        {
                            DB::commit_transaction();
                            \Fuel\Core\Session::set_flash('success','Upload success');
                        }
                    }
                    /*if($file['size'] > 0){

                        $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                        if(!in_array($ext,$allowList)){
                            Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                            $error = true;
                        }

                        $filename = md5(time());

                        if(@copy($file['tmp_name'],$path.$filename.$ext)){

                            $news_photo = $filename.$ext;

                            /* small thumbnail */
                    #   parent::create_cropped_thumbnail($path.$filename.$ext,64,64,"-s");
                    #   parent::create_cropped_thumbnail($path.$filename.$ext,128,128,"-s@2x");
                    /* */

                    /* medium thumbnail */
                    #  parent::create_cropped_thumbnail($path.$filename.$ext,360,240,"-m");
                    #  parent::create_cropped_thumbnail($path.$filename.$ext,720,480,"-m@2x");
                    /*

                } else {
                    Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                    $error = true;
                }

            }*/

                    /*if(!$error){

                        $news = Model_News::forge(array(
                            'news_title' => Input::post('news_title'),
                            'news_short_detail' => Input::post('news_short_detail'),
                            'news_detail' => Input::post('news_detail'),
                            'news_photo' => $news_photo,
                            'news_published' => Input::post('news_published'),
                            'created_at' => time(),
                            'published_at' => (Input::post('news_published')==1)?time():0
                        ));

                        if ($news and $news->save()){
                            Session::set_flash('success', 'Added news #' . $news->id . '.');
                            Response::redirect('news/edit/'.$news->id);
                        } else {
                            Session::set_flash('error', 'Could not save news.');
                        }

                    }*/

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

            $this->theme->get_template()->set_global('current_menu', "News", false);
            $this->theme->get_template()->set_global('current_menu_desc', "จัดการข่าวทั้งหมดในระบบ", false);

            $this->theme->get_template()->set('breadcrumb', array(
                array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
                array('title' => "News", 'icon' => "eicon-newspaper", 'link' => Uri::create('news/index'), 'active' => false),
                array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
            ));

            $this->theme->get_template()->set_global('mode', "create", false);

            $this->theme->get_template()->set('page_specific_js', "form_news.js");

            $this->theme->set_partial('sidebar','common/sidebar');

            $this->theme->set_partial('left', 'news/create');

        }catch (Exception $e){
            die($e->getMessage());
        }

    }

    public function action_edit($id = null) {

        is_null($id) and Response::redirect('news');

        $this->theme->set_template('edit');
        $this->theme->get_template()->set_global('current_menu', "News", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการข่าวทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "News", 'icon' => "eicon-newspaper", 'link' => Uri::create('news/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('mode', "edit", false);

        if (!$news = Model_News::find($id)) {
            Session::set_flash('error', 'Could not find news #' . $id);
            Response::redirect('news');
        }

        if(Input::method() == 'POST') {

            $file = Input::file('news_photo_file');

            $val = Model_News::validate('edit');

            if ($val->run()) {

                $allowList = array(".jpeg", ".jpg", ".png");

                $error = false;

                $path = realpath(DOCROOT."/../../uploads/news_photo/").DS;

                $news_photo = "";

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    if(strlen($news->news_photo)){
                        @unlink($path.$news->news_photo);
                    }

                    $filename = md5(time());

                    if(@copy($file['tmp_name'],$path.$filename.$ext)){

                        $news_photo = $filename.$ext;

                        /* small thumbnail */
                        parent::create_cropped_thumbnail($path.$filename.$ext,64,64,"-s");
                        parent::create_cropped_thumbnail($path.$filename.$ext,128,128,"-s@2x");
                        /* */

                        /* medium thumbnail */
                        parent::create_cropped_thumbnail($path.$filename.$ext,360,240,"-m");
                        parent::create_cropped_thumbnail($path.$filename.$ext,720,480,"-m@2x");
                        /* */

                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }

                if(!$error){

                    if(strlen($news_photo) && strlen($news->news_photo)){

                        $old_ext = strtolower(substr($news->news_photo,strrpos($news->news_photo,".")));

                        $old_filename = substr($news->news_photo,0,strrpos($news->news_photo,"."));

                        @unlink($path.$old_filename.$old_ext);
                        @unlink($path.$old_filename."-s".$old_ext);
                        @unlink($path.$old_filename."-s@2x".$old_ext);
                        @unlink($path.$old_filename."-m".$old_ext);
                        @unlink($path.$old_filename."-m@2x".$old_ext);

                    }

                    $news->news_title = Input::post('news_title');
                    $news->news_short_detail = Input::post('news_short_detail');
                    $news->news_detail = Input::post('news_detail');

                    if(strlen($news_photo)) $news->news_photo = $news_photo;

                    $news->news_published = Input::post('news_published');

                    if($news->published_at == 0 && Input::post('news_published') == 1) $news->published_at = time();

                    if ($news->save()) {
                        Session::set_flash('success', 'อัพเดตข้อมูลข่าว #'.$id.' เรียบร้อยแล้ว');
                    } else {
                        Session::set_flash('error', 'Could not update news #' . $id);
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

        $this->theme->get_template()->set_global('news', $news, false);

        $this->theme->get_template()->set_global('path', "http://www.buffohero.com/uploads/news_photo/", false);
        
        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->get_template()->set('page_specific_js', "form_news.js");

        $this->theme->set_partial('left', 'news/edit');

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('news');
        if ($news = Model_News::find($id)) {
            $news->delete();
            Session::set_flash('success', 'Deleted news #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete news #' . $id);
        }
        Response::redirect('news');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
