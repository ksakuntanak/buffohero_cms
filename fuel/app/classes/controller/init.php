<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bommortal
 * Date: 1/31/14 AD
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */

class Controller_Init extends \Fuel\Core\Controller
{
    protected $_get;
    protected $_post;
    protected $_data;
    protected $_result;
    protected $_options;
    protected $_response;
    protected $_user_info;

    public function before()
    {
        parent::before();

        // Check Auth
        if (!\Auth\Auth::check()) {
            \Fuel\Core\Response::redirect('auth');
        }

        /*
        *  Theme Set
        */
        $this->theme = \Theme::instance();
        $this->theme->set_template('index');

        /*
         * Breadcrumb
         */
        // $this->_breadcrumb = Breadcrumb::create_links();

        if (Session::get('lang')) {
            $this->_lang = Session::get('lang');
        }

        if (Input::method() == 'GET') {
            $this->_get = Input::get();
        }

        if (Input::method() == 'POST') {
            $this->_post = Input::post();
        }

        $this->initialized();


    }

    protected  function initialized()
    {
        $this->_result = false;
        $this->_data = array();
        $this->_options = array();

        $this->_response = array(
            'result' => $this->_result,
            'data' => $this->_data,
            'options' => $this->_options
        );

        $this->_user_info = $this->_user_info();

        if(Session::get('lang')==''){
            Session::set('lang','en');
        }

    }


    /**
     * @return array
     *
     */
    private function _user_info()
    {
        $group = \Auth\Auth::instance()->get_groups();


        $data = array(
            'id' => \Auth\Auth::instance()->get('id'),
            'username' => \Auth\Auth::instance()->get_screen_name(),
            'email' => \Auth\Auth::instance()->get_email()
        );

        return $data;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function _response($options = array())
    {

        $this->_response = array(
            'result' => $this->_result,
            'data' => $this->_data,
            'options' => $this->_options
        );

        return $this->_response;

    }

    private function has_access($group)
    {

    }


    public function action_index()
    {
        $this->theme->set_partial('content','metro/index')->set('title','test');
    }


    public function after($response)
    {
        // If no response object was returned by the action,
        if (empty($response) or  ! $response instanceof Response)
        {
            // render the defined template
            $response = \Response::forge(\Theme::instance()->render());
        }

        return parent::after($response);
    }
}