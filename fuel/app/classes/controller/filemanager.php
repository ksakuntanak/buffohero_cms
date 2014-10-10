<?php

class Controller_Filemanager extends Controller_Common
{
    private $_dir = 'uploads';

    public function before()
    {
        parent::before();

        $this->theme = \Theme::instance();
        $this->theme->set_template('home');

        $this->theme->get_template()->set_global('title', "BuffoHero CMS", false);
        $this->theme->get_template()->set_global('current_menu', "File Manager", false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการไฟล์", false);
        $this->theme->set_partial('sidebar', 'common/sidebar');
    }

    public function action_index()
    {
        $error = '';
        try {

            $uploads_folder = '/var/www/html/'.$this->_dir;
            $all_folder = \Fuel\Core\File::read_dir($uploads_folder, 1);

        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $this->theme->set_partial('content', 'filemanager/index')
            ->set('all_folder', $all_folder)
            ->set('message',$error)
        ;
    }

    public function action_folder($folder = null,$sub= null)
    {

        is_null($folder) and \Fuel\Core\Response::redirect_back();
        $error = '';
        $model = null;

        try {

            $uploads_folder = '/var/www/html/'.$this->_dir.'/' . $folder .'/'.$sub;
            $all = \Fuel\Core\File::read_dir($uploads_folder, 0);

        } catch (Exception $e) {
            $error = $e->getMessage();
            die($error);
        }

        $this->theme->set_partial('content', 'filemanager/folder')
            ->set('all', $all)
            ->set('folder', $folder)
            ->set('sub',$sub)
            ->set('message',$error)
        ;
    }

    public function action_upload($folder,$sub=null)
    {
        if (\Fuel\Core\Input::method() == 'POST') {
            try {

                \Fuel\Core\DB::start_transaction();
                $val = Model_Filemanager::validate('create');
                if ($val->run()) {

                    $config = array(
                        'path' => "/var/www/html/".$this->_dir."/".$folder."/".$sub . DS,
                        'ext_whitelist' => array('jpg', 'jpeg', 'png'),
                        'file_chmod' => 0777,
                        'auto_rename' => true,
                        'overwrite' => true,
                        'randomize' => true,
                        'create_path' => true
                    );

                    Upload::process($config);
                    $img = '';
                    if (Upload::is_valid()) {

                        Upload::save();

                        $img = Upload::get_files()[0];

                    }

                    if(!\Fuel\Core\Input::post('id')){
                        $file = Model_Filemanager::forge(array(
                            'folder'=>$folder,
                            'key'=>Input::post('key'),
                            'value'=>$img['saved_as'],
                            'photographer'=>\Fuel\Core\Input::post('photographer'),
                            'price'=>\Fuel\Core\Input::post('price'),
                            'usage'=>\Fuel\Core\Input::post('usage'),
                            'source'=>\Fuel\Core\Input::post('source')
                        ));
                    }else{
                        $file = Model_Filemanager::find_by_id(\Fuel\Core\Input::post('id'));

                        if($img==''){
                            $img = $file->value;
                        }

                        if($file){
                            $file->set(array(
                                'folder'=>$folder,
                                'key'=>Input::post('key'),
                                'value'=>$img,
                                'photographer'=>\Fuel\Core\Input::post('photographer'),
                                'price'=>\Fuel\Core\Input::post('price'),
                                'usage'=>\Fuel\Core\Input::post('usage'),
                                'source'=>\Fuel\Core\Input::post('source')
                            ));
                        }else{
                            throw new Exception('File not found!');
                        }
                    }

                    if($file and $file->save())
                    {
                        DB::commit_transaction();
                        \Fuel\Core\Session::set_flash('success','Upload success');
                    }else{
                        throw new Exception('Cannot save into database!');
                    }
                } else {
                    throw new Exception($val->show_errors());
                }
            } catch (Exception $e) {
                DB::rollback_transaction();
                \Fuel\Core\Session::set_flash('error', $e->getMessage());
            }
        }

        \Fuel\Core\Response::redirect(\Fuel\Core\Uri::create('filemanager/folder/' . $folder));
    }

    public function action_create($what=null){

        is_null($what) and \Fuel\Core\Response::redirect('filemanager');

        try{
           if(\Fuel\Core\Input::method()=='POST'){

               if($what=='dir'){
                   $dir = \Fuel\Core\File::create_dir('/var/www/html/'.$this->_dir.'/',\Fuel\Core\Input::post('dir_name'),0777);
                   if($dir){
                       \Fuel\Core\Response::redirect('filemanager');
                   }
               }
           }
        }catch (Exception $e){
            die($e->getMessage());
        }

        \Fuel\Core\Response::redirect('filemanager');
    }

    public function after($response)
    {
        if (empty($response) or  !$response instanceof Response) {
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

    // 1900*1080
    // thumb = fixed [300x150]

}