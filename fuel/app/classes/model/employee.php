<?php

use Orm\Model;

class Model_Employee extends Model {

    protected static $_properties = array(
        'id',
        'username',
        'password',
        'email',
        'group',
        'last_login',
        'login_hash',
        'profile_fields',
        'employee_title',
        'employee_other_title',
        'employee_first_name',
        'employee_last_name',
        'employee_nationality',
        'employee_other_nationality',
        'employee_gender',
        'employee_bdate',
        'employee_addr',
        'employee_country',
        'employee_mobile',
        'employee_phone',
        'employee_weight',
        'employee_height',
        'employee_job_type',
        'employee_keywords',
        'employee_about',
        'employee_skills',
        'created_date'
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
        $val->add_field('username', 'Username', 'required|max_length[255]|valid_email');
        $val->add_field('employee_title', 'คำนำหน้า', 'required');
        $val->add_field('employee_other_title', 'คำนำหน้าอื่นๆ', 'min_length[1]|max_length[255]');
        $val->add_field('employee_first_name', 'ชื่อ', 'required|max_length[255]');
        $val->add_field('employee_last_name', 'นามสกุล', 'required|max_length[255]');
        $val->add_field('employee_gender', 'เพศ', 'required');
        $val->add_field('employee_nationality', 'สัญชาติ', 'required');
        $val->add_field('employee_other_nationality', 'สัญชาติอื่นๆ', 'min_length[1]|max_length[255]');
        $val->add_field('employee_bdate', 'วันเดือนปีเกิด', 'required');
        $val->add_field('employee_addr', 'ที่อยู่', 'required');
        $val->add_field('employee_country', 'ประเทศ', 'required');
        $val->add_field('employee_mobile', 'หมายเลขโทรศัพท์มือถือ', 'required|max_length[255]');
        $val->add_field('employee_phone', 'หมายเลขโทรศัพท์บ้าน', 'min_length[1]|max_length[255]');
        $val->add_field('employee_job_type', 'ประเภทงานที่สนใจ', 'required');
        $val->add_field('employee_keywords', 'สาขางานที่สนใจ', 'required');
        $val->add_field('employee_about', 'เกี่ยวกับผู้หางาน', 'required');
        $val->add_field('employee_skills', 'ทักษะ / ความสามารถ', 'required');

        return $val;
    }

    public static function get_job_cats(){
        $query = DB::query('SELECT * FROM buff_jobs_categories')->execute()->as_array('jcat_id','jcat_title');
        return array_merge($query);
    }

    public static function get_employees($page = 1){

        $query = DB::select('employees.*','users.username','users.last_login')->from('employees')
            ->join('users','inner')
            ->on('employees.user_id','=','users.id')
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

        $query = DB::select('employees.*','users.username','users.last_login')->from('employees')
            ->join('users','inner')
            ->on('employees.user_id','=','users.id')
            ->where('employees.id','=',$id)
            ->execute()->as_array();

        if(count($query)) {

            $result = $query[0];

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
