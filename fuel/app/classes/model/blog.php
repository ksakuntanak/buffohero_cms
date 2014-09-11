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

}
