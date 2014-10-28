<?php
class Model_JobTag extends \Orm\Model {

    protected static $_table_name = "jobs_tags";

    protected static $_properties = array(
        'id',
        'job_id',
        'tag_name',
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

    public static function get_tag($job_id,$tag_name){

        if(!$job_id) return null;
        if(!strlen($tag_name)) return null;

        $query = DB::select('*')->from('jobs_tags')
            ->where('job_id','=',$job_id)
            ->and_where('tag_name','=',$tag_name)
            ->execute()->as_array();

        if(count($query)) return Model_JobTag::find($query[0]['id']);
        else return null;

    }

    public static function get_tags($query = ""){

        $tags = DB::select('tag_name')->distinct()->from('jobs_tags');

        if(strlen($query))
            $tags = $tags->where('tag_name','LIKE','%'.$query.'%');

        $tags = $tags->order_by('tag_name','asc')
            ->execute()->as_array();

        $result = array();

        foreach($tags as $tag){
            $result[] = $tag['tag_name'];
        }

        return $result;

    }

    public static function get_tags_by_job($job_id){

        if(!$job_id) return null;

        $query = DB::select('*')->from('jobs_tags')
            ->where('job_id','=',$job_id)
            ->execute()->as_array();

        $result = array();

        foreach($query as $q){
            $result[] = $q['tag_name'];
        }

        return $result;

    }

}