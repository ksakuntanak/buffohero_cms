<?php

use Orm\Model;

class Model_Help extends Model {

    protected static $_table_name = "helps";

    protected static $_properties = array(
        'id',
        'cat_id',
        'help_title_en',
        'help_title_th',
        'help_detail_en',
        'help_detail_th',
        'help_is_active',
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

        $val->add_field('cat_id', 'Help Category', 'required|max_length[255]');
        $val->add_field('help_title_en', 'Help Title (EN)', 'required|max_length[255]');
        $val->add_field('help_title_th', 'Help Title (TH)', 'required|max_length[255]');

        return $val;

    }

}
