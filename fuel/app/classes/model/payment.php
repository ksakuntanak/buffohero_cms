<?php
class Model_Payment extends \Orm\Model {

    protected static $_table_name = "payments";

    protected static $_properties = array(
        'id',
        'user_id',
        'ref_no',
        'buff_amount',
        'price',
        'payment_method',
        'status',
        'expired_at',
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

    public static function get_active_payments(){

        $query = DB::select('*')->from('payments')
            ->where('status','=',1)
            ->or_where('status','=',2)
            ->order_by('status','desc','created_at','desc')
            ->limit(20)->offset(0)
            ->execute()->as_array();

        $result = array();

        foreach($query as $q){

            $user = Model_User::find($q['user_id']);
            $employer = DB::select('*')->from('employers')
                ->where('user_id','=',$q['user_id'])
                ->execute()->as_array();

            $row = $q;
            $row['username'] = $user?$user->username:"";
            $row['employer_name'] = count($employer)?$employer[0]['employer_name']:"";

            $result[] = $row;

        }

        return $result;

    }

    public static function get_closed_payments(){

        $query = DB::select('*')->from('payments')
            ->where('status','=',0)
            ->or_where('status','=',3)
            ->order_by('created_at','desc','status','desc')
            ->limit(20)->offset(0)
            ->execute()->as_array();

        $result = array();

        foreach($query as $q){

            $user = Model_User::find($q['user_id']);
            $employer = DB::select('*')->from('employers')
                ->where('user_id','=',$q['user_id'])
                ->execute()->as_array();

            $row = $q;
            $row['username'] = $user?$user->username:"";
            $row['employer_name'] = count($employer)?$employer[0]['employer_name']:"";

            $result[] = $row;

        }

        return $result;

    }

}