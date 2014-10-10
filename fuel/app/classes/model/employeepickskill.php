<?php
class Model_EmployeePickSkill extends \Orm\Model {

    protected static $_table_name = "employees_picks_skills";

    protected static $_properties = array(
        'id',
        'pick_id',
        'skill_title',
        'skill_level',
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

}