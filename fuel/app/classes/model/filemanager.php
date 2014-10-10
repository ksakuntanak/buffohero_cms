<?php

use Orm\Model;

class Model_Filemanager extends Model {

    protected static $_table_name = "filemanager";

    protected static $_properties = array(
        'id',
        'folder',
        'key',
        'value',
        'photographer',
        'price',
        'usage',
        'source',
        'forge',
        'created_at',
        'updated_at',
        'deleted_at'
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

        $val->add_field('key', 'Name', 'required|max_length[255]');
        #$val->add_field('value', 'Name', 'required|max_length[255]');

        return $val;

    }

}
