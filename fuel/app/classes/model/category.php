<?php

use Orm\Model;

class Model_Category extends Model {

    protected static $_table_name = "categories";

    protected static $_properties = array(
        'id',
        'cat_title_en',
        'cat_title_th'
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

    public static function get_categories(){

        $query = DB::select('*')->from('categories')
            ->order_by('cat_title_th','asc')
            ->execute()->as_array('id','cat_title_th');

        return $query;
    }

}
