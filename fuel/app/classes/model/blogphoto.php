<?php

use Orm\Model;

class Model_BlogPhoto extends Model {

    protected static $_table_name = "blogs_photos";

    protected static $_properties = array(
        'id',
        'blog_id',
        'photo_file_name',
        'created_at',
        'updated_at'
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => false,
        ),
    );

    public static function validate($factory) {

        $val = Validation::forge($factory);

        return $val;

    }

    public static function get_blog_photos($blog_id){

        if(!$blog_id) return null;

        $result = DB::select('*')->from('blogs_photos')
            ->where('blog_id','=',$blog_id)
            ->execute()->as_array();

        return $result;

    }

}
