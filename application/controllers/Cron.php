<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    //expire payments
    public function expire_payments()
    {   
        check_recurring_payments();
        $this->admin_model->check_expire_recurring_invoices();
        $payments = $this->common_model->get_expire_payments();
        $trial_users = $this->common_model->get_trial_users();

        foreach ($payments as $payment) {
            $data = array(
                'status' => 'expire'
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->update($data, $payment->id, 'payment');
        }

        //check trial expire users
        foreach ($trial_users as $user) {
            $user_data = array(
                'status' => 2,
                'trial_expire' => '0000-00-00'
            );
            $user_data = $this->security->xss_clean($user_data);
            $this->common_model->update($user_data, $user->id, 'users');
        }
    }

}