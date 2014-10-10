<?php

class Controller_Images extends \Fuel\Core\Controller
{

    private $_dir = 'uploads';

    public function before()
    {
        parent::before();
    }

    public function action_file($folder = null, $size = null,$crop='no')
    {
        try {

            if (is_null($folder)) {
                throw new Exception('Folder name is not given!');
            }

            if (is_null($size)) {
                throw new Exception('Image file name is not given!');
            }

            if (!strpos($size, 'x')) {
                throw new Exception('Image size is not given!');
            }

            if (!\Fuel\Core\Input::get('image')) {
                throw new Exception('Image is not given!');
            }

            $file = \Fuel\Core\Input::get('image');

            /** @var  $upload_path */
            $upload_path = '/var/www/html/'.$this->_dir;

            /** @var  $file_path */
            $file_path = $folder . '/' . $file;

            /** @var  $real_path */
            $real_path = $upload_path . '/' . $file_path;

            /** @var  $new_name */
            $new_name = $size.'_'.$file;

            /** @var  $resize_path : Path for resize only */
            $resize_path = $upload_path.'/'.$folder.'/resize/';

            /** @var  $resize_file */
            $resize_file = $upload_path.'/'.$folder.'/resize/'.$new_name;

            /** @var  $crop_path : Path for crop only */
            $crop_path = $upload_path.'/'.$folder.'/crop/';

            /** @var  $crop_file */
            $crop_file = $upload_path.'/'.$folder.'/crop/'.$new_name;

            /** @var  $image */
            $image = \Fuel\Core\Image::forge(array(
                'driver'=>'gd',
                'bgcolor'=>null,
                'quality' => 100
            ));

            /** @var  $where_are_file */
            $where_are_file = '';

            /** @var  $where_are_path */
            $where_are_path = '';

            if($crop=='no'){
                $where_are_file = $resize_file;
                $where_are_path = $resize_path;
            }else{
                $where_are_file = $crop_file;
                $where_are_path = $crop_path;
            }

            if(!file_exists($where_are_file)){

                /**
                 *  Check if not dir then make it.
                 */
                if(!is_dir($where_are_path)){
                    if(!mkdir($where_are_path,0777)){
                        throw new Exception('Permission denied!');
                    }
                }

                /** @var  $size */
                $size = explode('x', $size);

                if($crop=='crop'){
                    /**
                     *  Chaining to crop_resize() function
                     */
                    $image
                        ->load($real_path)
                        ->crop_resize($size[0], $size[1])
                        ->save($where_are_file);

                }else{
                    /**
                     *  Chaining to resize() function
                     */
                    $image
                        ->load($real_path)
                        ->resize($size[0], $size[1], true, false)
                        ->save($where_are_file);
                }

                /**
                 *  Load file and output image.
                 */
                $image
                    ->load($where_are_file)
                    ->output();
            }else{
                /**
                 *  If file exist force output to show image.
                 */
                if(\Fuel\Core\Input::get('action')=='delete'){
                    if(\Auth\Auth::instance()->get('group')==100){
                        $model = Model_Filemanager::find_by_value($file);
                        if($model){
                            $model->deleted_at = time();
                            $model->value = null;
                            if($model->save())
                            {
                                \Fuel\Core\File::delete($where_are_file);
                                \Fuel\Core\File::delete($real_path);
                                \Fuel\Core\Response::redirect('filemanager/folder/'.$folder);
                            }else{
                                throw new Exception('Cannot delete in database!');
                            }
                        }else{
                            throw new Exception('Image not found!');
                        }
                    }else{
                        throw new Exception('You are not an Administrator!');
                    }
                }else{
                    $image
                        ->load($where_are_file)
                        ->output();
                }
            }
        } catch (Exception $e) {
            /** @var  $error */
            $error = '<ul>';
            $error .= '<li>'.$e->getLine().'</li>';
            $error .= '<li>'.$e->getFile().'</li>';
            $error .= '<li>'.$e->getMessage().'</li>';
            $error .= '</ul>';
            return $error;
        }

        exit;
    }

    public function action_remove($path){
        try{
            \Fuel\Core\File::delete_dir($path);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }





}