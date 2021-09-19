<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Home_Controller 
{

    public function __construct()
    {
        parent::__construct();
    }

    // load Login view Page
    public function login()
    {
        $data = array();
        $data['page_title'] = 'Login';
        $data['page'] = 'Auth';
        $this->load->view('login', $data);
    }

    //register
    public function register()
    {   
        if (empty($_GET['trial'])) {
            $this->session->unset_userdata('trial');
        }else{
            $this->session->set_userdata('trial', 'trial');
        }
        
        $data = array();
        $data['page_title'] = 'Register';
        $data['page'] = 'Auth';
        $data['countries'] = $this->admin_model->select_asc('country');
        $data['business'] = $this->admin_model->select_asc('business_category');
        $data['packages'] = $this->admin_model->select_asc('package');
        $data['features'] = $this->admin_model->select_asc('package_features');
        $data['main_content'] = $this->load->view('register', $data, TRUE);
        $this->load->view('index', $data);
    }


    // login
    public function log()
    {

        if($_POST){ 

            // check valid user 
            $user = $this->auth_model->validate_user();

            if (empty($user)) {
                echo json_encode(array('st'=>0));
                exit();
            }
            if (!empty($user) && $user->status == 0) {
                // account pending
                echo json_encode(array('st'=>2));
                exit();
            }
            if (!empty($user) && $user->status == 2) {
                // account suspend
                echo json_encode(array('st'=>3));
                exit();
            }
            
            if ($user->role == 'user') {
                if (!empty($user) && $user->email_verified == 0 && $this->settings->enable_email_verify == 1) {
                    // email verify
                    echo json_encode(array('st'=>4));
                    exit();
                }
            }

            // if valid
            if(password_verify($this->input->post('password'), $user->password)){
               
                $data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'slug' => $user->slug,
                    'thumb' => $user->thumb,
                    'email' =>$user->email,
                    'role' =>$user->role,
                    'logged_in' => TRUE
                );
                $data = $this->security->xss_clean($data);
                $this->session->set_userdata($data); 

                // success notification 
                if ($user->role == 'user') {
                    $url = base_url('admin/dashboard/business');
                } else {
                    $url = base_url('admin/dashboard');
                }
                
                echo json_encode(array('st'=>1,'url'=> $url));
            }else{ 
                // if not user not valid
                echo json_encode(array('st'=>0));
            }
            
        }else{
            $this->load->view('auth',$data);
        }
    }



    // register new user
    public function register_user()
    {
        
        if($_POST){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', "Email", 'required');
            $this->form_validation->set_rules('password', "Password", 'trim|required|min_length[4]|max_length[46]');

            // If validation false show error message using ajax
            if($this->form_validation->run() == FALSE){
                $data = array();
                $data['errors'] = validation_errors();
                $str = $data['errors'];
                echo json_encode(array('st'=>0,'msg'=>$str));
                exit();
            }else{

                $mail =  strtolower(trim($this->input->post('email', true)));
                $email = $this->auth_model->check_email($mail);
                
                if ($this->session->userdata('trial') == 'trial') {
                    $user_type = 'trial';
                    $trial_expire = date('Y-m-d', strtotime('+'.$this->settings->trial_days .' days'));
                }else{
                    $user_type = 'registered';
                    $trial_expire = date('Y-m-d');
                }

                // if email already exist
                if ($email){
                    echo json_encode(array('st'=>2));
                    exit();
                } else {

                    //check reCAPTCHA status
                    if (!$this->recaptcha_verify_request()) {
                        echo json_encode(array('st'=>3));
                        exit();
                    } else {
                    
                        $hash = md5(rand(0,1000));
                        $data=array(
                            'name' => $this->input->post('name', true),
                            'user_name' => str_slug($this->input->post('name', true)),
                            'slug' => str_slug($this->input->post('name', true)),
                            'email' => $this->input->post('email', true),
                            'verify_code' => $hash,
                            'thumb' => 'assets/front/img/avatar.png',
                            'password' => hash_password($this->input->post('password', true)),
                            'role' => 'user',
                            'account_type' => 'pro',
                            'user_type' => $user_type,
                            'trial_expire' => $trial_expire,
                            'status' => 1,
                            'created_at' => my_date_now()
                        );
                        $data = $this->security->xss_clean($data);
                        $id = $this->common_model->insert($data, 'users');

                        $user = $this->auth_model->validate_id(md5($id));
                        $data = array(
                            'id' => $user->id,
                            'name' => $user->name,
                            'role' => $user->role,
                            'thumb' =>$user->thumb,
                            'email' => $user->email,
                            'logged_in' => true
                        );
                        $this->session->set_userdata($data);

                        //send email verify link
                        if ($this->settings->enable_email_verify == 1) {
                            $link = base_url('verify?code='.$hash.'&user='.md5($id));
                            $subject = $this->settings->site_name.' Email Verification';
                            $msg = 'Hello '.$user->name.', Click the below link to complete your email verification.<br>'.$link;
                            $this->email_model->send_email($this->input->post('email'), $subject, $msg);
                        }

                        echo json_encode(array('st'=>1));
                        exit();
                    }
                }

            }
        }

    }


    public function resend_mail(){
        $hash = md5(rand(0,1000));
        $link = base_url('verify?code='.$hash.'&user='.md5(user()->id));
        $subject = $this->settings->site_name.' Email Verification';
        $msg = 'Click the below link to complete your email verification.<br>'.$link;
        $response = $this->email_model->send_email(user()->email, $subject, $msg);
        if ($response == true) {
            echo json_encode(array('st'=>1));
        } else {
            echo json_encode(array('st'=>2));
        }
    }

    
    //register business
    public function register_business()
    {
        if($_POST){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', "Business Name", 'required');
            $this->form_validation->set_rules('country', "Country", 'required');
            
            if ($this->session->userdata('trial') == 'trial') {
                $status = 3;
            }else{
                $status = 1;
            }

            // If validation false show error message using ajax
            if($this->form_validation->run() == FALSE){
                $data = array();
                $data['errors'] = validation_errors();
                $str = $data['errors'];
                echo json_encode(array('st'=>0,'msg'=>$str));
                exit();
            }else{
                $ubid = random_string('numeric',5);
                $data=array(
                    'user_id' => user()->id,
                    'uid' => $ubid,
                    'is_autoload_amount' => 0,
                    'name' => $this->input->post('name', true),
                    'slug' => str_slug($this->input->post('name', true)),
                    'country' => $this->input->post('country', true),
                    'category' => $this->input->post('category', true),
                    'is_primary' => 1
                );
                $data = $this->security->xss_clean($data);
                $this->common_model->insert($data, 'business');
                echo json_encode(array('st'=> $status));
                exit();
            }
        }
    }

    //add package
    public function add_package($id, $billing_type)
    {
        $package = $this->common_model->get_by_id($id, 'package');
        $uid = random_string('numeric',5);
        
        if($billing_type =='monthly'):
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

        if (number_format($amount, 0) == 0):
            $status = 'verified';
        else:
            $status = 'pending';
        endif;

        //create payment
        $pay_data=array(
            'user_id' => user()->id,
            'puid' => $uid,
            'package' => $id,
            'amount' => $amount,
            'billing_type' => $billing_type,
            'status' => $status,
            'created_at' => my_date_now(),
            'expire_on' => $expire_on
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $this->common_model->insert($pay_data, 'payment');
        
        if (number_format($amount, 0) == 0):
            $url = base_url('admin/dashboard/business');
        else:
            if ($this->settings->enable_paypal == 1) {
                $url = base_url('auth/purchase');
            } else {
                $url = base_url('admin/dashboard/business');
            }
        endif;
        echo json_encode(array('st'=>1, 'url' => $url));
    }


    //purchase
    public function purchase()
    {   
        $data = array();
        $data['page_title'] = 'Payment';
        $data['page'] = 'Auth';
        $data['payment'] = $this->common_model->get_user_payment();
        $data['payment_id'] = $data['payment']->puid;
        $data['package'] = $this->common_model->get_package_by_id($data['payment']->package);
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);
    }

    //verify email
    public function verify_email()
    {   
        $data = array();
        if (isset($_GET['code']) && isset($_GET['user'])) {
            $user = $this->auth_model->validate_id($_GET['user']);
            if ($user->verify_code == $_GET['code']) {
                $data['code'] = $_GET['code'];

                $edit_data=array(
                    'email_verified' => 1
                );
                $this->common_model->update($edit_data, $user->id, 'users');
            } else {
                $data['code'] = 'invalid';
            }
        }else{
            $data['code'] = '';
        }
        $data['page_title'] = 'Verify Account';
        $data['page'] = 'Auth';
        $data['main_content'] = $this->load->view('verify_email', $data, TRUE);
        $this->load->view('index', $data);
    }

    //payment success
    public function payment_success($payment_id)
    {   
        $payment = $this->common_model->get_payment($payment_id);
        $data = array(
            'status' => 'verified'
        );
        $data = $this->security->xss_clean($data);

        $user_data = array(
            'status' => 1
        );
        $user_data = $this->security->xss_clean($user_data);

        if (!empty($payment)) {
            $this->common_model->edit_option($user_data, $payment->user_id,'users');
            $this->common_model->edit_option($data, $payment->id, 'payment');
        }
        $data['success_msg'] = 'Success';
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);

    }

    //payment cancel
    public function payment_cancel($payment_id)
    {   
        $payment = $this->common_model->get_payment($payment_id);
        $data = array(
            'status' => 'pending'
        );
        $data = $this->security->xss_clean($data);
        if (!empty($payment)) {
            $this->common_model->edit_option($data, $payment->id, 'payment');
        }
        $data['error_msg'] = 'Error';
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);
    }

    //stripe payment
    public function stripe_payment()
    {

        $id = $this->input->post('package_id');
        $package = $this->common_model->get_by_id($id, 'package');
        $puid = random_string('numeric',5);
        $billing_type = $this->input->post('billing_type');
        
        if($billing_type =='monthly'):
            if (settings()->enable_discount == 1){
                $amount = get_discount($package->monthly_price, $package->dis_month); 
            }else{
                $amount = round($package->price); 
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
        
        require_once('application/libraries/stripe-php/init.php');
        \Stripe\Stripe::setApiKey(settings()->secret_key);
        
        try {
            $charge = \Stripe\Charge::create ([
                "amount" => $amount*100,
                "currency" => settings()->currency,
                "source" => $this->input->post('stripeToken'),
                "description" => "Payment from ".settings()->site_name 
            ]);
            $chargeJson = $charge->jsonSerialize();
            
            $amount                  = $chargeJson['amount']/100;
            $balance_transaction     = $chargeJson['balance_transaction'];
            $currency                = $chargeJson['currency'];
            $status                  = $chargeJson['status'];
        }catch(Exception $e) { 
            $error = $e->getMessage(); 
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

        if($status == 'succeeded'){$status = 'verified';}else{$status = 'pending';};

        $pay_data=array(
            'user_id' => user()->id,
            'puid' => $puid,
            'package' => $id,
            'amount' => $amount,
            'billing_type' => $billing_type,
            'status' => $status,
            'created_at' => my_date_now(),
            'expire_on' => $expire_on
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $result = $this->common_model->insert($pay_data, 'payment');

        if($result):  
            redirect(base_url('payment-success/'.$puid));
        else:
            redirect(base_url('payment-cancel/'.$puid));
        endif;
    }



    
    // Recover forgot password 
    public function forgot_password()
    {
        if (check_auth()) {
            redirect(base_url());
        }

        $mail =  strtolower(trim($this->input->post('email',true))); 
        $valid = $this->auth_model->check_email($mail);
        $random_number = random_string('numeric',4);
        $random_pass = hash_password($random_number);
        if ($valid) {
           
           foreach($valid as $row){
                $data['email'] = $row->email;
                $data['name'] = $row->name;
                $data['password'] = $random_number;
                $user_id = $row->id;
                $this->send_recovery_mail($data);

                $user_data = array('password' => $random_pass);
                $this->common_model->edit_option($user_data, $user_id, 'users');
                
                $url = base_url('login');
                echo json_encode(array('st'=>1, 'url' => $url));
            }

        } else {
            echo json_encode(array('st'=>2));
        }
        
    }

    //send reset code to user email
    public function send_recovery_mail($user)
    {
        $data = array();
        $data['name'] = $user['name'];
        $data['password'] = $user['password'];
        $data['email'] = $user['email'];
        $subject = 'Password Recovery';
        $msg = 'Hello '.$user['name'].'<br> We have reset your password, Please use this <b>'.$user['password'].'</b> code to login your account';
        $this->email_model->send_email($user['email'], $subject, $msg);
    }

    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('msg', 'Logout Successfully');
        redirect(base_url('auth/login'));
    }

}