<?php
class Controller_Payment extends Controller_Common {

    public function before(){
        parent::before();
        $this->theme = \Theme::instance();
    }

    public function action_index() {

        $data['active_payments'] = Model_Payment::get_active_payments();
        $data['closed_payments'] = Model_Payment::get_closed_payments();

        $this->theme->set_template('index');

        $this->theme->get_template()->set_global('current_menu', "Payments",false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการรายการการชำระเงินของลูกค้าทั้งหมดในระบบ",false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Payments", 'icon' => "fa-barcode", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'payment/index')->set($data);
    }

    public function action_view($id) {

        if(!$id){
            Response::redirect('payments');
        }

        $payment = Model_Payment::find($id);

        if(!$payment){
            Response::redirect('payments');
        }

        $user = Model_User::find($payment->user_id);
        $employer = Model_Employer::get_employer($payment->user_id);

        $data['payment'] = $payment;
        $data['user'] = $user;
        $data['employer'] = $employer;

        $confirm = Model_PaymentConfirm::get_payment_confirm($id);

        $data['confirm'] = $confirm;

        $this->theme->set_template('view');

        $this->theme->get_template()->set_global('current_menu', "Payments",false);
        $this->theme->get_template()->set_global('current_menu_desc', "จัดการรายการการชำระเงินของลูกค้าทั้งหมดในระบบ",false);

        $this->theme->get_template()->set('breadcrumb', array(
            array('title' => "Home", 'icon' => "fa-home", 'link' => Uri::create('home'), 'active' => false),
            array('title' => "Payments", 'icon' => "fa-barcode", 'link' => Uri::create('payment'), 'active' => false),
            array('title' => "View", 'icon' => "fa-eye", 'link' => "", 'active' => true)
        ));

        $this->theme->set_partial('sidebar','common/sidebar');

        $this->theme->set_partial('content', 'payment/view')->set($data);

    }

    public function action_confirm($id = null) {

        is_null($id) and Response::redirect('payment');

        if ($payment = Model_Payment::find($id)) {

            $payment->status = 3;

            $payment->save();

            $money = Model_Money::forge(array(
                'user_id' => $payment->user_id,
                'title' => "buff_add",
                'value' => $payment->buff_amount,
                'status' => 1,
                'created_at' => time()
            ));

            $money->save();

            Session::set_flash('success', 'อนุมัติรายการชำระเงิน #'.$id." แล้ว");

        } else {

            Session::set_flash('error', 'ไม่สามารถอนุมัติรายการชำระเงิน #'.$id." ได้");

        }

        Response::redirect('payment');

    }

    public function action_cancel($id = null) {

        is_null($id) and Response::redirect('payment');

        if ($payment = Model_Payment::find($id)) {

            $payment->status = 0;

            $payment->save();

            Session::set_flash('success', 'ยกเลิกรายการชำระเงิน #'.$id." แล้ว");

        } else {

            Session::set_flash('error', 'ไม่สามารถยกเลิกรายการชำระเงิน #'.$id." ได้");

        }

        Response::redirect('payment');

    }

    public function action_delete($id = null) {
        is_null($id) and Response::redirect('payment');
        if ($payment = Model_Payment::find($id)) {
            $payment->delete();
            Session::set_flash('success', 'ลบรายการชำระเงิน #'.$id." แล้ว");
        } else {
            Session::set_flash('error', 'ไม่สามารถลบรายการชำระเงิน #'.$id." ได้");
        }
        Response::redirect('payment');
    }

    public function after($response){
        if (empty($response) or  ! $response instanceof Response){
            $response = \Response::forge(\Theme::instance()->render());
        }
        return parent::after($response);
    }

}