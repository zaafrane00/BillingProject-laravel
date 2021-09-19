<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Readonly extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }
    

    public function export_pdf($id){

        $data = array();
        if (is_dir(APPPATH.'third_party/mpdf')) {
            $data['invoice'] = $this->admin_model->get_invoice_details($id);
            if($data['invoice']->type == 1){$type = 'Invoice';}else{$type = 'Estimate';};
            $data['page_title'] = $type.' Export';      
            $data['page'] = $type;

            //load the view and saved it into $html variable
            $html=$this->load->view('admin/user/export_file', $data, TRUE);

            //this the the PDF filename that user will get to download
            $pdfFilePath = "invoice.pdf";

            //load mPDF library
            $this->load->library('m_pdf');

            //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);

            //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D");
        }else{
            $this->load->view('admin/user/mpdf_info',$data);
        }
    }



    public function estimate($mode, $id)
    {
        $data = array();
        $data['mode'] = $mode;       
        if ($mode == 'preview') {   
            $data['link'] = $_SERVER['HTTP_REFERER'];
        } 
        $data['invoice'] = $this->admin_model->get_readonly_invoice($id);
        $data['page_title'] = 'Estimate preview'; 
        $data['page'] = 'Estimate';
        $this->load->view('admin/user/estimate_view',$data);
    }

    public function invoice($mode, $id)
    {
        $data = array();
        $data['invoice'] = $this->admin_model->get_readonly_invoice($id);
        $data['mode'] = $mode;   
        if ($mode == 'preview') {   
            $data['link'] = $_SERVER['HTTP_REFERER'];
        } 
        $data['page_title'] = 'Invoice preview';      
        $data['page'] = 'Invoice';
        $this->load->view('admin/user/invoice_view',$data);
    }

    public function inv(){

        $invoice = $this->admin_model->get_by_md5_id(md5(1), 'invoice');
        $data = array();
        if (isset($is_myself)) {
            $data['email_myself'] = $this->input->post('email_myself', true);
        } else {
            $data['email_myself'] = '';
        }

        $data['email_to'] = $this->input->post('email_to', true);
        $data['message'] = $this->input->post('message', true);
        $data['subject'] = $this->input->post('subject', true);
        $data['invoice'] = $invoice;
        $this->load->view('email_template/invoice',$data);
    }


    // not found page
    public function error_404()
    {
        $data['page_title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";
        $this->load->view('error_404');
    }


}