<?php

class Controller_Services_Images extends \Fuel\Core\Controller_Rest{

    private $_response = array(
        'result'=>false,
        'data'=>null,
        'message'=>''
    );

    public function get_image(){
        try{
            if(\Fuel\Core\Input::get('image')){
                $model = Model_Filemanager::find('last',array(
                    'where'=>array(
                        'key'=>\Fuel\Core\Input::get('image')
                    )
                ));

                if($model){
                    $v = $model;
                    $data = array(
                        'id'=>$v->id,
                        'key'=>$v->key,
                        'value'=>$v->value,
                        'photographer'=>$v->photographer,
                        'price'=>$v->price,
                        'usage'=>$v->usage,
                        'source'=>$v->source
                    );
                    $this->_response['result'] = true;
                    $this->_response['data'] = $data;

                }else{
                    throw new Exception('Image not found.');
                }
            }else{
                throw new Exception('Parameter image not given');
            }
        }catch (Exception $e){
            $this->_response['message'] = $e->getMessage();
        }

        return $this->response($this->_response);
    }



}