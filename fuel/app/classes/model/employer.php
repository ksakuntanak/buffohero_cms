<?php

use Orm\Model;

class Model_Employer extends Model {

    protected static $_table_name = "employers";

    protected static $_properties = array(
        'id',
        'user_id',
        'employer_name',
        'employer_desc',
        'employer_addr',
        'province_id',
        'employer_tel',
        'employer_fax',
        'employer_email',
        'employer_website',
        'employer_photo',
        'employer_is_active',
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

        $val->add_field('employer_name', 'Employer Name', 'required|max_length[255]');
        $val->add_field('employer_tel', 'Tel', 'required|max_length[255]');
        $val->add_field('employer_email', 'E-Mail', 'required|max_length[255]');
        $val->add_field('province_id', 'Province', 'required');

        return $val;
    }

    public static function get_employers($page = 1){

        $query = DB::select('employers.*','users.username','users.last_login','users.fb_login')->from('employers')
            ->join('users','inner')
            ->on('employers.user_id','=','users.id')
            ->order_by('users.last_login','desc')
            ->limit(30)->offset(($page-1)*30)
            ->execute()->as_array();

        $total = DB::count_last_query();

        $result = array(
            'total' => $total,
            'first' => ($total>0)?(($page-1)*30+1):0,
            'last' => ($page*30 <= $total)?($page*30):$total,
            'rows' => array()
        );

        foreach($query as $q){
            $result['rows'][] = $q;
        }

        return $result;

    }

    public static function get_employers_for_dropdown(){

        $query = DB::select('employers.*','users.username','users.last_login','users.fb_login')->from('employers')
            ->join('users','inner')
            ->on('employers.user_id','=','users.id')
            ->order_by('employers.employer_name','desc')
            ->execute()->as_array('id','employer_name');

        return $query;

    }

    public static function get_employer($user_id){

        $query = DB::select('*')->from('employers')
            ->where('user_id','=',$user_id)
            ->execute()->as_array();

        if($query) return $query[0];
        else return null;

    }

}
