<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_admin()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Payment Settings';      
        $data['page'] = 'Payment';   
        $data['settings'] = $this->admin_model->get('settings');
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['packages'] = $this->admin_model->select_asc('package');
        $data['users'] = $this->admin_model->get_users();
        $data['main_content'] = $this->load->view('admin/payment_settings',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    //update settings
    public function update(){

        if ($_POST) {
            
            if(!empty($this->input->post('paypal_payment'))){$paypal_payment = $this->input->post('paypal_payment', true);}
            else{$paypal_payment = 0;}

            if(!empty($this->input->post('stripe_payment'))){$stripe_payment = $this->input->post('stripe_payment', true);}
            else{$stripe_payment = 0;}
            
            $data = array(
                'currency' => $this->input->post('currency', true),
                'paypal_mode' => $this->input->post('paypal_mode', true),
                'paypal_email' => $this->input->post('paypal_email', true),
                'publish_key' => $this->input->post('publish_key', true),
                'secret_key' => $this->input->post('secret_key', true),
                'paypal_payment' => $paypal_payment,
                'stripe_payment' => $stripe_payment 
            );
            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, 1, 'settings');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function offline_payment()
    {	
        if($_POST)
        {   
            $package = $this->common_model->get_by_id($this->input->post('package'), 'package');
            $payment = $this->common_model->check_user_payment($this->input->post('user'));


            if($this->input->post('billing_type') =='monthly'):
                if (settings()->enable_discount == 1){
                    $amount = get_discount($package->monthly_price, $package->dis_month); 
                }else{
                    $amount = round($package->monthly_price); 
                }
                $expire_on = date('Y-m-d', strtotime('+1 month'));
            else:
                if (settings()->enable_discount == 1){
                    $amount = get_discount($package->price, $package->dis_year); 
                }else{
                    $amount = round($package->price); 
                }
                $expire_on = date('Y-m-d', strtotime('+12 month'));
            endif;

            //validate inputs
            $this->form_validation->set_rules('user', "User", 'required');
            $this->form_validation->set_rules('package', "Package", 'required');
            $this->form_validation->set_rules('status', "Payment status", 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect(base_url('admin/payment'));
            } else {
                
                $data=array(
                    'user_id' => $this->input->post('user', true),
                    'puid' => random_string('numeric',5),
                    'package' => $this->input->post('package', true),
                    'billing_type' => $this->input->post('billing_type', true),
                    'amount' => $amount,
                    'status' => $this->input->post('status', true),
                    'created_at' => my_date_now(),
                    'expire_on' => $expire_on
                );
                $data = $this->security->xss_clean($data);

                if (empty($payment)) {
                    $this->admin_model->insert($data, 'payment');

                    $user_data = array(
                        'user_type' => 'registered'      
                    );
                    $user_data = $this->security->xss_clean($user_data);
                    $this->admin_model->edit_option($user_data, $this->input->post('user'), 'users');

                } else {
                    $this->admin_model->update_payment($data, $this->input->post('user'), 'payment');
                }

                $this->session->set_flashdata('msg', trans('payment-added-successfully')); 
                redirect(base_url('admin/Payment'));

            }
        }      
        
    }

}
	

