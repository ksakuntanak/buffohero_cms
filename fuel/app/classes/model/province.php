<?php
class Model_Province extends \Orm\Model{

    protected static $_table_name = "provinces";

    protected static $_properties = array(
        'id',
        'name_en',
        'name_th'
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

    public static function get_provinces($lang = "en") {

        $query = DB::select('*')->from('provinces')->order_by('name_'.$lang,'asc')->execute()->as_array('id','name_'.$lang);
        return $query;

    }

}