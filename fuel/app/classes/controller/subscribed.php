<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bommortal
 * Date: 3/3/14 AD
 * Time: 5:58 PM
 * To change this template use File | Settings | File Templates.
 */

class Controller_subscribed extends Controller {


    public function action_index()
    {
        if(Input::method()=='POST')
        {

        }

        echo View::forge('unsubscribe');
        exit;
    }

}