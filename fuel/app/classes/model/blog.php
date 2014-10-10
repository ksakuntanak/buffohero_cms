<?php

use Orm\Model;

class Model_Blog extends Model {

    protected static $_table_name = "blogs";

    protected static $_properties = array(
        'id',
        'blog_title',
        'blog_short_detail',
        'blog_detail',
        'blog_cover_photo',
        'blog_featured',
        'blog_published',
        'created_at',
        'published_at',
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

        $val->add_field('blog_title', 'Blog Title', 'required|max_length[255]');

        return $val;

    }

    public static function get_blogs($page = 1, $query = ""){

        $rows = DB::select('*')->from('blogs')
            ->where('blog_featured','=',0);

        if(strlen($query))
            $rows = $rows->and_where('blog_title','LIKE','%'.$query.'%');

        $rows = $rows->limit(30)->offset(($page-1)*30)
            ->execute()->as_array();

        $total = DB::count_last_query();

        $result = array(
            'total' => $total,
            'rows' => $rows
        );

        return $result;

    }

    public static function get_featured_blogs(){

        $rows = DB::select('*')->from('blogs')
            ->where('blog_featured','=',1)
            ->limit(2)->offset(0)
            ->execute()->as_array();

        return $rows;

    }

}
