<?php
class Model_JobSkill extends \Orm\Model {

    protected static $_table_name = "jobs_skills";

    protected static $_properties = array(
        'id',
        'job_id',
        'skill_title',
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

    public static function get_skill($job_id,$skill_title){

        if(!$job_id) return null;
        if(!strlen($skill_title)) return null;

        $query = DB::select('*')->from('jobs_skills')
            ->where('job_id','=',$job_id)
            ->and_where('skill_title','=',$skill_title)
            ->execute()->as_array();

        if(count($query)) return Model_JobSkill::find($query[0]['id']);
        else return null;

    }

    public static function get_skills($job_id,$implode = false){

        if(!$job_id) return null;

        $query = DB::select('*')->from('jobs_skills')
            ->where('job_id','=',$job_id)
            ->execute()->as_array();

        $result = array();

        foreach($query as $q){
            $result[] = $q['skill_title'];
        }

        if($implode) return implode(",",$result);
        else return $result;

    }

    public static function get_all_skills($query = ""){

        $skills = DB::select('skill_title')->distinct()->from('jobs_skills');

        if(strlen($query))
            $skills = $skills->where('skill_title','LIKE','%'.$query.'%');

        $skills = $skills->execute()->as_array();

        $result = array();

        foreach($skills as $s){
            $result[] = $s['skill_title'];
        }

        return $result;

    }

}