<?php

use Orm\Model;

class Model_Employee extends Model {

    protected static $_properties = array(
        'id',
        'user_id',
        'employee_title',
        'employee_other_title',
        'employee_firstname',
        'employee_lastname',
        'employee_nickname',
        'employee_display_name',
        'employee_display_position',
        'employee_gender',
        'employee_nationality',
        'employee_other_nationality',
        'employee_bdate',
        'employee_addr',
        'province_id',
        'employee_zipcode',
        'employee_country',
        'employee_phone',
        'employee_email',
        'employee_website',
        'employee_facebook',
        'employee_twitter',
        'employee_gplus',
        'employee_weight',
        'employee_height',
        'employee_prefer',
        'employee_about',
        'employee_skills',
        'employee_photo',
        'employee_is_featured',
        'employee_is_active',
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
        $val->add_field('employee_display_name', 'ชื่อโปรไฟล์', 'required|max_length[255]');
        $val->add_field('employee_firstname', 'ชื่อ', 'required|max_length[255]');
        $val->add_field('employee_lastname', 'นามสกุล', 'required|max_length[255]');
        $val->add_field('employee_gender', 'เพศ', 'required');
        // $val->add_field('employee_bdate', 'วันเดือนปีเกิด', 'required');
        $val->add_field('province_id', 'จังหวัด', 'required');
        $val->add_field('employee_phone', 'หมายเลขโทรศัพท์', 'required|max_length[255]');
        $val->add_field('employee_email', 'อีเมล', 'required|max_length[255]|valid_email');
        $val->add_field('employee_prefer', 'ประเภทงานที่สนใจ', 'required');;

        return $val;

    }

    public static function get_job_cats(){
        $query = DB::query('SELECT * FROM buff_jobs_categories')->execute()->as_array('jcat_id','jcat_title');
        return array_merge($query);
    }

    public static function get_employees($page = 1){

        $query = DB::select('employees.*','users.username','users.last_login','users.fb_login')->from('employees')
            ->join('users','inner')
            ->on('employees.user_id','=','users.id')
            ->order_by('users.last_login','desc')
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

    public static function get_employee($id){

        $query = DB::select('employees.*','users.username','users.last_login','users.fb_login')->from('employees')
            ->join('users','inner')
            ->on('employees.user_id','=','users.id')
            ->where('employees.id','=',$id)
            ->execute()->as_array();

        if(count($query)) {

            $result = $query[0];

            $result['custom'] = Model_EmployeeCustom::get_employee_custom($id);

            $result['expect'] = Model_Expect::get_expects($id);
            $result['experience'] = Model_Experience::get_experience($id);
            $result['school'] = Model_School::get_schools($id);

            $result['comp_skills'] = Model_Skill::get_computer_skills($id);
            $result['lang_skills'] = Model_Skill::get_language_skills($id);
            $result['other_skills'] = Model_Skill::get_other_skills($id);

            return $result;

        } else return null;

    }

}
