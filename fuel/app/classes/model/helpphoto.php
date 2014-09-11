<?php

use Orm\Model;

class Model_HelpPhoto extends Model {

    protected static $_table_name = "helps_photos";

    protected static $_properties = array(
        'id',
        'help_id',
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

    public static function get_help_photos($help_id){

        if(!$help_id) return null;

        $result = DB::select('*')->from('helps_photos')
            ->where('help_id','=',$help_id)
            ->execute()->as_array();

        return $result;

    }

}
