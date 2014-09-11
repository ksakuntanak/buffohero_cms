<?php
class Controller_Home extends Controller_Common {
    
    public function before(){
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index(){

        $user_id = Session::get('cms_user_id');

        $this->theme->set_template('home');

        $this->theme->get_template()->set_global('title',"BuffoHero CMS",false);
        $this->theme->get_template()->set_global('current_menu',"Home",false);
        $this->theme->get_template()->set_global('current_menu_desc',"หน้าแรกของระบบ",false);

        $data['user'] = Model_User::find($user_id);

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content','home/index')->set($data);

    }
    
    public function after($response){
        if (empty($response) or  ! $response instanceof Response){
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }
    
}
