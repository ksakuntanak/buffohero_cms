<?php

use Orm\Model;

class Model_HelpCategory extends Model {

    protected static $_table_name = "helps_categories";

    protected static $_properties = array(
        'id',
        'cat_title_en',
        'cat_title_th',
        'cat_order',
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

    public static function get_help_categories(){

        $query = DB::select('*')->from('helps_categories')
            ->execute()->as_array('id','cat_title_en');

        return $query;

    }

}
