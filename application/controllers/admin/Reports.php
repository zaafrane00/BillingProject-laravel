<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Home_Controller {

	public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
    }
    
    public function index()
    {
        $data =array();        
        $data['page_title'] = 'Reports';
        $data['customers'] = $this->admin_model->get_by_user('customers');
        $data['vendors'] = $this->admin_model->get_by_user('vendors');
        $data['categories'] = $this->admin_model->get_by_user('categories');

        $data['reports'] = '';
        $data['main_content'] = $this->load->view('admin/user/reports', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function generate()
    {
        $data =array();
        $data['customers'] = $this->admin_model->get_by_user('customers');
        $data['vendors'] = $this->admin_model->get_by_user('vendors');
        if (isset($_GET['report_types']) && $_GET['report_types'] == 3) {
            $data['reports'] = $this->admin_model->get_user_expense_reports();
            $data['page_title'] = 'Expense Reports';
        } else {
            $data['reports'] = $this->admin_model->get_user_reports();
            $data['page_title'] = 'Income Reports';
        }
        //echo "<pre>"; print_r($data['reports']); exit();
        $data['main_content'] = $this->load->view('admin/user/reports', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    

    public function change_password()
    {
        $data = array();
        $data['page_title'] = 'Change Password';
        $data['main_content'] = $this->load->view('admin/change_password', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

}