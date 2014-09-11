<?php

use Orm\Model;

class Model_Employer extends Model {

    protected static $_table_name = "employers";

    protected static $_properties = array(
        'id',
        'user_id',
        'province_id',
        'employer_name',
        'employer_desc',
        'employer_addr',
        'employer_tel',
        'employer_fax',
        'employer_email',
        'employer_website',
        'employer_photo',
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
        $val->add_field('employer_name', 'Employer Name', 'required|max_length[255]');
        $val->add_field('employer_addr', 'Address', 'required');
        $val->add_field('employer_tel', 'Tel', 'required|max_length[255]');
        $val->add_field('employer_email', 'E-Mail', 'required|max_length[255]');

        return $val;
    }

    public static function get_employer($user_id){

        $query = DB::select('*')->from('employers')
            ->where('user_id','=',$user_id)
            ->execute()->as_array();

        if($query) return $query[0];
        else return null;

    }

}
