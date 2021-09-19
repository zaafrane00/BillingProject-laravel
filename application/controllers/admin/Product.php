<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends Home_Controller {

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
        $data = array();
        $data['page_title'] = 'Products';      
        $data['page'] = 'Product';   
        $data['product'] = FALSE;
        $data['products'] = $this->admin_model->get_by_user('products');
        $data['taxes'] = $this->admin_model->get_by_user('tax');
        $data['income_category'] = $this->admin_model->get_product_categories($type=1);
        $data['expense_category'] = $this->admin_model->get_product_categories($type=2);
        $data['main_content'] = $this->load->view('admin/user/products',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
        if($_POST)
        {   
            $id = $this->input->post('id', true);
            
            //validate inputs
            $this->form_validation->set_rules('name', "Product", 'required|max_length[100]');
            $this->form_validation->set_rules('price', "Price", 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect(base_url('admin/product'));
            } else {

                if(!empty($this->input->post('is_sell', true))){
                    $is_sell = 1;
                    $income_category = $this->input->post('income_category', true);
                }else{
                    $is_sell = 0;
                    $income_category = $this->input->post('income_category', true);
                }

                if(!empty($this->input->post('is_buy', true))){
                    $is_buy = 1;
                    $expense_category = $this->input->post('expense_category', true);
                }else{
                    $is_buy = 0;
                    $expense_category = $this->input->post('expense_category', true);
                }
               
                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'price' => $this->input->post('price', true),
                    'is_sell' => $is_sell,
                    'income_category' => $income_category,
                    'is_buy' => $is_buy,
                    'expense_category' => $expense_category,
                    'details' => $this->input->post('details')
                );
                $data = $this->security->xss_clean($data);
                
                if ($id != '') {
                    $this->admin_model->delete_tax($id, 'product_tax');
                    $this->admin_model->edit_option($data, $id, 'products');
                    $this->session->set_flashdata('msg', trans('msg-updated')); 
                } else {
                    $id = $this->admin_model->insert($data, 'products');
                    $this->session->set_flashdata('msg', trans('msg-inserted')); 
                }

                redirect(base_url('admin/product'));

            }
        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['taxes'] = $this->admin_model->get_by_user('tax');
        $data['selected_tax'] = $this->admin_model->get_tax_by_product($id);
        $data['product'] = $this->admin_model->select_option($id, 'products');
        $data['income_category'] = $this->admin_model->get_product_categories($type=1);
        $data['expense_category'] = $this->admin_model->get_product_categories($type=2);
        $data['main_content'] = $this->load->view('admin/user/products',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function delete($id)
    {
        $this->admin_model->delete($id,'products'); 
        echo json_encode(array('st' => 1));
    }

}
	

