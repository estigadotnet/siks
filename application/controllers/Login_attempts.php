<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_attempts extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_attempts_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'login_attempts/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'login_attempts/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'login_attempts/index.html';
            $config['first_url'] = base_url() . 'login_attempts/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Login_attempts_model->total_rows($q);
        $login_attempts = $this->Login_attempts_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'login_attempts_data' => $login_attempts,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('login_attempts/login_attempts_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Login_attempts_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'ip_address' => $row->ip_address,
		'login' => $row->login,
		'time' => $row->time,
	    );
            $this->load->view('login_attempts/login_attempts_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('login_attempts'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('login_attempts/create_action'),
	    'id' => set_value('id'),
	    'ip_address' => set_value('ip_address'),
	    'login' => set_value('login'),
	    'time' => set_value('time'),
	);
        $this->load->view('login_attempts/login_attempts_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'ip_address' => $this->input->post('ip_address',TRUE),
		'login' => $this->input->post('login',TRUE),
		'time' => $this->input->post('time',TRUE),
	    );

            $this->Login_attempts_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('login_attempts'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Login_attempts_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('login_attempts/update_action'),
		'id' => set_value('id', $row->id),
		'ip_address' => set_value('ip_address', $row->ip_address),
		'login' => set_value('login', $row->login),
		'time' => set_value('time', $row->time),
	    );
            $this->load->view('login_attempts/login_attempts_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('login_attempts'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'ip_address' => $this->input->post('ip_address',TRUE),
		'login' => $this->input->post('login',TRUE),
		'time' => $this->input->post('time',TRUE),
	    );

            $this->Login_attempts_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('login_attempts'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Login_attempts_model->get_by_id($id);

        if ($row) {
            $this->Login_attempts_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('login_attempts'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('login_attempts'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('ip_address', 'ip address', 'trim|required');
	$this->form_validation->set_rules('login', 'login', 'trim|required');
	$this->form_validation->set_rules('time', 'time', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "login_attempts.xls";
        $judul = "login_attempts";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Ip Address");
	xlsWriteLabel($tablehead, $kolomhead++, "Login");
	xlsWriteLabel($tablehead, $kolomhead++, "Time");

	foreach ($this->Login_attempts_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ip_address);
	    xlsWriteLabel($tablebody, $kolombody++, $data->login);
	    xlsWriteNumber($tablebody, $kolombody++, $data->time);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=login_attempts.doc");

        $data = array(
            'login_attempts_data' => $this->Login_attempts_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('login_attempts/login_attempts_doc',$data);
    }

}

/* End of file Login_attempts.php */
/* Location: ./application/controllers/Login_attempts.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-18 08:58:46 */
/* http://harviacode.com */