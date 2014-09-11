<?php
class Model_Money extends \Orm\Model {

    protected static $_table_name = "moneys";

    protected static $_properties = array(
        'id',
        'user_id',
        'title',
        'value',
        'status',
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

        $val->add_field('value', 'Buff Value', 'required|is_numeric');

        return $val;

    }

    public static function get_current_money($user_id){
        $query = DB::query("SELECT SUM(value) AS total FROM buff_moneys WHERE user_id = ".$user_id." AND status = 1")
            ->execute()->as_array();
        return count($query)?$query[0]['total']:0;
    }

}