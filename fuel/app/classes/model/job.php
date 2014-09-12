<?php

use Orm\Model;

class Model_Job extends Model {

    protected static $_table_name = "jobs";

    protected static $_properties = array(
        'id',
        'ref_no',
        'employer_id',
        'job_title',
        'job_type',
        'cat_id',
        'subcat_id',
        'job_desc',
        'job_position',
        'job_areas',
        'job_qualifications',
        'job_skills',
        'job_tags',
        'job_welfare',
        'job_salary',
        'job_salary_negotiable',
        'job_budget',
        'job_budget_type',
        'job_prize',
        'job_attachment',
        'job_is_featured',
        'job_is_urgent',
        'job_is_active',
        'job_is_paid',
        'created_at',
        'expired_at',
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
        $val->add_field('cat_id', 'Category', 'required');
        return $val;
    }

    public static function get_jobs($page,$query = ""){

        $select = DB::select('*')->from('jobs');

        if(strlen($query))
            $select = $select->where('job_title','LIKE','%'.$query.'%');

        $select = $select->order_by('created_at','desc')
            ->limit(30)->offset(($page-1)*30)
            ->execute()->as_array();

        $result = array(
            'total' => DB::count_last_query(),
            'rows' => array()
        );

        foreach($select as $s){

            $employer = Model_Employer::find($s['employer_id']);

            $row = $s;
            $row['employer_name'] = $employer->employer_name;

            $result['rows'][] = $row;

        }

        return $result;

    }

}
