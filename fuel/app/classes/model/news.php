<?php

use Orm\Model;

class Model_News extends Model {

    protected static $_table_name = "news";

    protected static $_properties = array(
        'id',
        'news_title',
        'news_short_detail',
        'news_detail',
        'news_photo',
        'news_published',
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

        $val->add_field('news_title', 'News Title', 'required|max_length[255]');

        return $val;

    }

}
