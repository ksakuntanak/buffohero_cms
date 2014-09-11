<?php
class Model_PaymentConfirm extends \Orm\Model {

    protected static $_table_name = "payments_confirms";

    protected static $_properties = array(
        'id',
        'payment_id',
        'transfer_to_account',
        'transfer_amount',
        'transfer_datetime',
        'attachment',
        'remark',
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

        $val->add_field('transfer_to_account', 'Transferred to Account', 'required');
        $val->add_field('transfer_amount', 'Transferred Amount', 'required|is_numeric');
        $val->add_field('transfer_date', 'Transferred Date', 'required|valid_date');
        $val->add_field('transfer_time', 'Transferred Time', 'required');

        $val->set_message('is_numeric',"Please enter :label as a number.");

        return $val;

    }

    public static function get_payment_confirm($payment_id){

        if(!$payment_id) return null;

        $query = DB::select('*')->from('payments_confirms')
            ->where('payment_id','=',$payment_id)
            ->execute()->as_array();

        if(count($query)) return $query[0];
        else return null;

    }

}