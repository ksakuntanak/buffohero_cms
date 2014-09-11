<?php
class Model_User extends \Orm\Model
{
    protected static $_properties = array(
        'id',
        'username',
        'password',
        'email',
        'profile_fields',
        'group',
        'last_login',
        'login_hash',
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
        $val->add_field('username', 'Username', 'required|max_length[255]');
        $val->add_field('email', 'E-Mail', 'required|max_length[255]');

        return $val;
    }

}