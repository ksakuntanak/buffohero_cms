<?php

class Controller_Blog extends Controller_Common {

    public function before() {
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $page = Input::get('page')?Input::get('page'):1;
        $query = Input::get('query')?Input::get('query'):"";
        
        if (strlen($query)) {
            $data['blogs'] = DB::select('*')->from('blogs')
                ->where('blog_title','LIKE','%'.$query.'%')
                ->limit(30)->offset(($page-1)*30)
                ->execute()->as_array();
        } else {
            $data['blogs'] = DB::select('*')->from('blogs')
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

        $cats = Model_Category::get_categories();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Blogs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการบล็อกทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Blogs", 'icon' => "fa-rss", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('query',$query,false);
        $this->theme->get_template()->set_global('cats',$cats,false);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'blog/index')->set($data);

    }

    public function action_create() {

        if (Input::method() == 'POST') {

            $file = Input::file('blog_cover_photo_file');

            $val = Model_Blog::validate('create');

            if ($val->run()) {

                $allowList = array(".jpeg", ".jpg", ".png");

                $error = false;

                $path = realpath(DOCROOT."/../../uploads/blog_cover/").DS;

                $blog_cover_photo = "";

                if($file['size'] > 0){

                    $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                    if(!in_array($ext,$allowList)){
                        Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                        $error = true;
                    }

                    $filename = md5(time()).$ext;

                    if(@copy($file['tmp_name'],$path.$filename)){
                        $blog_cover_photo = $filename;
                    } else {
                        Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                        $error = true;
                    }

                }

                if(!$error){

                    $blog = Model_Blog::forge(array(
                        'blog_title' => Input::post('blog_title'),
                        'blog_short_detail' => Input::post('blog_short_detail'),
                        'blog_detail' => Input::post('blog_detail'),
                        'blog_cover_photo' => $blog_cover_photo,
                        'blog_published' => Input::post('blog_published'),
                        'created_at' => time(),
                        'published_at' => (Input::post('blog_published')==1)?time():0
                    ));

                    if ($blog and $blog->save()){
                        Session::set_flash('success', 'Added blog #' . $blog->id . '.');
                        Response::redirect('blog/edit/'.$blog->id);
                    } else {
                        Session::set_flash('error', 'Could not save blog.');
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

        $this->theme->get_template()->set_global('current_menu', "Blogs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการบล็อกทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Blogs", 'icon' => "fa-rss", 'link' => Uri::create('blog/index'), 'active' => false),
            array('title' => "Create", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('mode', "create", false);

        $this->theme->get_template()->set('page_specific_js', "form_blog.js");

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('left', 'blog/create');

    }

    public function action_edit($id = null) {

        is_null($id) and Response::redirect('blog');

        $this->theme->set_template('edit');
        $this->theme->get_template()->set_global('current_menu', "Blogs", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการบล็อกทั้งหมดในระบบ", false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Blogs", 'icon' => "fa-rss", 'link' => Uri::create('blog/index'), 'active' => false),
            array('title' => "Edit", 'icon' => "", 'link' => "", 'active' => true)
        ));

        $this->theme->get_template()->set_global('mode', "edit", false);

        if (!$blog = Model_Blog::find($id)) {
            Session::set_flash('error', 'Could not find blog #' . $id);
            Response::redirect('blog');
        }

        if(Input::method() == 'POST') {

            if(Input::post('action') == "edit_blog") {

                $file = Input::file('blog_cover_photo_file');

                $val = Model_Blog::validate('edit');

                if ($val->run()) {

                    $allowList = array(".jpeg", ".jpg", ".png");

                    $error = false;

                    $path = realpath(DOCROOT."/../../uploads/blog_cover/").DS;

                    $blog_cover_photo = "";

                    if($file['size'] > 0){

                        $ext = strtolower(substr($file['name'],strrpos($file['name'],".")));

                        if(!in_array($ext,$allowList)){
                            Session::set_flash('error', 'ชนิดของไฟล์ภาพไม่ถูกต้อง');
                            $error = true;
                        }

                        if(strlen($blog->blog_cover_photo)){
                            @unlink($path.$blog->blog_cover_photo);
                        }

                        $filename = md5(time()).$ext;

                        if(@copy($file['tmp_name'],$path.$filename)){
                            $blog_cover_photo = $filename;
                        } else {
                            Session::set_flash('error', 'ไม่สามารถอัพโหลดไฟล์ภาพได้ โปรดลองใหม่อีกครั้ง');
                            $error = true;
                        }

                    }

                    if(!$error){

                        $blog->blog_title = Input::post('blog_title');
                        $blog->blog_short_detail = Input::post('blog_short_detail');
                        $blog->blog_detail = Input::post('blog_detail');

                        if(strlen($blog_cover_photo)) $blog->blog_cover_photo = $blog_cover_photo;

                        $blog->blog_published = Input::post('blog_published');

                        if($blog->published_at == 0 && Input::post('blog_published') == 1) $blog->published_at = time();

                        if ($blog->save()) {
                            Session::set_flash('success', 'อัพเดตข้อมูลบล็อก #'.$id.' เรียบร้อยแล้ว');
                        } else {
                            Session::set_flash('error', 'Could not update blog #' . $id);
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

            } else if(Input::post('action') == "upload_photos") {

                /*print "<pre>";
                print_r(Input::post());
                print_r(Input::file());
                print "</pre>";
                exit();*/

                $files = Input::file('blog_photo_file');

                $photos = array();

                $allowList = array(".jpeg", ".jpg", ".png");

                $error = false;

                $path = realpath(DOCROOT."/../../uploads/blog_photo/").DS;

                /*print_r($path);
                exit();*/

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

                        $blogphoto = Model_BlogPhoto::forge(array(
                            'blog_id' => Input::post('blog_id'),
                            'photo_file_name' => $p,
                            'created_at' => time()
                        ));

                        $blogphoto->save();

                    }

                }

            } else if(Input::post('action') == "delete_photo") {

                $blogphoto = Model_BlogPhoto::find(Input::post('photo_id'));

                $path = realpath(DOCROOT."/../../uploads/blog_photo/").DS;

                @unlink($path.$blogphoto->photo_file_name);

                $blogphoto->delete();

            }

        }

        $data['photos'] = Model_BlogPhoto::get_blog_photos($id);

        $this->theme->get_template()->set_global('blog', $blog, false);

        $this->theme->get_template()->set_global('path', "http://www.buffohero.com/uploads/blog_photo/", false);
        
        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->get_template()->set('page_specific_js', "form_blog.js");

        $this->theme->set_partial('left', 'blog/edit');
        $this->theme->set_partial('right', 'blog/_imageupload')->set($data);

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('blog');
        if ($blog = Model_Blog::find($id)) {
            $blog->delete();
            Session::set_flash('success', 'Deleted blog #' . $id);
        } else {
            Session::set_flash('error', 'Could not delete blog #' . $id);
        }
        Response::redirect('blog');
    }

    public function after($response) {
        if (empty($response) or !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}
