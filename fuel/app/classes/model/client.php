<?php
class Model_Client extends \Orm\Model{

    protected static $_table_name = "clients";

    protected static $_properties = array(
        'id',
        'client_title',
        'client_url',
        'client_photo',
        'client_active',
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

        $val->add_field('client_title', 'Title', 'required|max_length[255]');
        $val->add_field('client_url', 'URL', 'required|max_length[255]|valid_url');

        return $val;

    }

}