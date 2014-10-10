<?php
class Model_EmployeePick extends \Orm\Model {

    protected static $_table_name = "employees_picks";

    protected static $_properties = array(
        'id',
        'employee_id',
        'pick_type',
        'pick_date',
        'pick_photo',
        'pick_is_active',
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

    public static function get_employee_pick($employee_id){

        $custom = DB::select('*')->from('employees_picks')
            ->where('employee_id',"=",$employee_id)
            ->execute()->as_array();

        if(count($custom)) return $custom[0];
        else return null;

    }

    public static function get_staff_picks($page = 1){

        $query = DB::select('employees_picks.*','employees.employee_display_name')->from('employees_picks')
            ->join('employees','inner')
            ->on('employees_picks.employee_id','=','employees.id')
            ->order_by('pick_date','desc')
            ->limit(20)->offset(($page-1)*20)
            ->execute()->as_array();

        $total = DB::count_last_query();

        $result = array(
            'total' => $total,
            'first' => ($total>0)?(($page-1)*20+1):0,
            'last' => ($page*20 <= $total)?($page*20):$total,
            'rows' => array()
        );

        foreach($query as $q){
            $result['rows'][] = $q;
        }

        return $result;

    }

}