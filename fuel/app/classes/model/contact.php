<?php
class Model_Contact extends \Orm\Model {

    protected static $_table_name = "contacts";

    protected static $_properties = array(
        'id',
        'email',
        'subject',
        'message',
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

        $val->add_field('email', 'E-Mail', 'required|valid_email');
        $val->add_field('subject', 'Subject', 'required|max_length[255]');
        $val->add_field('message', 'Message', 'required');

        $val->set_message('required', 'Please enter :label.');
        $val->set_message('valid_email', 'Please enter :label in a correct format.');

        return $val;

    }

}