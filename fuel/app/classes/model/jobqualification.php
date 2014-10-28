<?php
class Model_JobQualification extends \Orm\Model {

    protected static $_table_name = "jobs_qualifications";

    protected static $_properties = array(
        'id',
        'job_id',
        'qualification_title',
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

    public static function get_qualification($job_id,$qualification_title){

        if(!$job_id) return null;
        if(!strlen($qualification_title)) return null;

        $query = DB::select('*')->from('jobs_qualifications')
            ->where('job_id','=',$job_id)
            ->and_where('qualification_title','=',$qualification_title)
            ->execute()->as_array();

        if(count($query)) return Model_JobSkill::find($query[0]['id']);
        else return null;

    }

    public static function get_qualifications($job_id,$implode = false){

        if(!$job_id) return null;

        $query = DB::select('*')->from('jobs_qualifications')
            ->where('job_id','=',$job_id)
            ->execute()->as_array();

        $result = array();

        foreach($query as $q){
            $result[] = $q['qualification_title'];
        }

        if($implode) return implode(",",$result);
        else return $result;

    }

    public static function get_all_qualifications($query = ""){

        $quals = DB::select('qualification_title')->distinct()->from('jobs_qualifications');

        if(strlen($query))
            $quals = $quals->where('qualification_title','LIKE','%'.$query.'%');

        $quals = $quals->execute()->as_array();

        $result = array();

        foreach($quals as $q){
            $result[] = $q['qualification_title'];
        }

        return $result;

    }

}