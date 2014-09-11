<?php

use Orm\Model;

class Model_Subcategory extends Model {

    protected static $_table_name = "subcategories";

    protected static $_properties = array(
        'id',
        'cat_id',
        'subcat_title'
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

    public static function get_all_subcats(){

        $query = DB::select('*')->from('subcategories')
            ->order_by('cat_id','asc')
            ->execute()->as_array();

        $result = array();

        for($i = 0; $i < count($query); $i++){
            $result[$query[$i]['cat_id']][$query[$i]['id']] = $query[$i]['subcat_title_th'];
        }

        return $result;

    }

    public static function get_subcats_by_category($cat_id){

        $query = DB::select('*')->from('subcategories')
            ->where('cat_id','=',$cat_id)
            ->order_by('subcat_title_th','asc')
            ->execute()->as_array();

        $result = array();

        for($i = 0; $i < count($query); $i++){
            $result[$query[$i]['id']] = strtolower($query[$i]['subcat_title_th']);
        }

        return $result;

    }

}
