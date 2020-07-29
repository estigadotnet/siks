<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T103_nonrutin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T103_nonrutin_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 't103_nonrutin/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't103_nonrutin/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't103_nonrutin/index.html';
            $config['first_url'] = base_url() . 't103_nonrutin/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T103_nonrutin_model->total_rows($q);
        $t103_nonrutin = $this->T103_nonrutin_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't103_nonrutin_data' => $t103_nonrutin,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('t103_nonrutin/t103_nonrutin_list', $data);
    }

    public function read($id) 
    {
        $row = $this->T103_nonrutin_model->get_by_id($id);
        if ($row) {
            $data = array(
		'idnonrutin' => $row->idnonrutin,
		'idsiswa' => $row->idsiswa,
		'nobayar' => $row->nobayar,
		'tglbayar' => $row->tglbayar,
		'idjenis' => $row->idjenis,
		'nominal' => $row->nominal,
		'bayar' => $row->bayar,
		'sisa' => $row->sisa,
		'idadmin' => $row->idadmin,
	    );
            $this->load->view('t103_nonrutin/t103_nonrutin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t103_nonrutin'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t103_nonrutin/create_action'),
	    'idnonrutin' => set_value('idnonrutin'),
	    'idsiswa' => set_value('idsiswa'),
	    'nobayar' => set_value('nobayar'),
	    'tglbayar' => set_value('tglbayar'),
	    'idjenis' => set_value('idjenis'),
	    'nominal' => set_value('nominal'),
	    'bayar' => set_value('bayar'),
	    'sisa' => set_value('sisa'),
	    'idadmin' => set_value('idadmin'),
	);
        $this->load->view('t103_nonrutin/t103_nonrutin_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'idsiswa' => $this->input->post('idsiswa',TRUE),
		'nobayar' => $this->input->post('nobayar',TRUE),
		'tglbayar' => $this->input->post('tglbayar',TRUE),
		'idjenis' => $this->input->post('idjenis',TRUE),
		'nominal' => $this->input->post('nominal',TRUE),
		'bayar' => $this->input->post('bayar',TRUE),
		'sisa' => $this->input->post('sisa',TRUE),
		'idadmin' => $this->input->post('idadmin',TRUE),
	    );

            $this->T103_nonrutin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t103_nonrutin'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->T103_nonrutin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t103_nonrutin/update_action'),
		'idnonrutin' => set_value('idnonrutin', $row->idnonrutin),
		'idsiswa' => set_value('idsiswa', $row->idsiswa),
		'nobayar' => set_value('nobayar', $row->nobayar),
		'tglbayar' => set_value('tglbayar', $row->tglbayar),
		'idjenis' => set_value('idjenis', $row->idjenis),
		'nominal' => set_value('nominal', $row->nominal),
		'bayar' => set_value('bayar', $row->bayar),
		'sisa' => set_value('sisa', $row->sisa),
		'idadmin' => set_value('idadmin', $row->idadmin),
	    );
            $this->load->view('t103_nonrutin/t103_nonrutin_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t103_nonrutin'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idnonrutin', TRUE));
        } else {
            $data = array(
		'idsiswa' => $this->input->post('idsiswa',TRUE),
		'nobayar' => $this->input->post('nobayar',TRUE),
		'tglbayar' => $this->input->post('tglbayar',TRUE),
		'idjenis' => $this->input->post('idjenis',TRUE),
		'nominal' => $this->input->post('nominal',TRUE),
		'bayar' => $this->input->post('bayar',TRUE),
		'sisa' => $this->input->post('sisa',TRUE),
		'idadmin' => $this->input->post('idadmin',TRUE),
	    );

            $this->T103_nonrutin_model->update($this->input->post('idnonrutin', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t103_nonrutin'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->T103_nonrutin_model->get_by_id($id);

        if ($row) {
            $this->T103_nonrutin_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t103_nonrutin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t103_nonrutin'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('idsiswa', 'idsiswa', 'trim|required');
	$this->form_validation->set_rules('nobayar', 'nobayar', 'trim|required');
	$this->form_validation->set_rules('tglbayar', 'tglbayar', 'trim|required');
	$this->form_validation->set_rules('idjenis', 'idjenis', 'trim|required');
	$this->form_validation->set_rules('nominal', 'nominal', 'trim|required');
	$this->form_validation->set_rules('bayar', 'bayar', 'trim|required');
	$this->form_validation->set_rules('sisa', 'sisa', 'trim|required');
	$this->form_validation->set_rules('idadmin', 'idadmin', 'trim|required');

	$this->form_validation->set_rules('idnonrutin', 'idnonrutin', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t103_nonrutin.xls";
        $judul = "t103_nonrutin";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Idsiswa");
	xlsWriteLabel($tablehead, $kolomhead++, "Nobayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Tglbayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Idjenis");
	xlsWriteLabel($tablehead, $kolomhead++, "Nominal");
	xlsWriteLabel($tablehead, $kolomhead++, "Bayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Sisa");
	xlsWriteLabel($tablehead, $kolomhead++, "Idadmin");

	foreach ($this->T103_nonrutin_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->idsiswa);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nobayar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tglbayar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->idjenis);
	    xlsWriteNumber($tablebody, $kolombody++, $data->nominal);
	    xlsWriteNumber($tablebody, $kolombody++, $data->bayar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->sisa);
	    xlsWriteNumber($tablebody, $kolombody++, $data->idadmin);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t103_nonrutin.doc");

        $data = array(
            't103_nonrutin_data' => $this->T103_nonrutin_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('t103_nonrutin/t103_nonrutin_doc',$data);
    }

}

/* End of file T103_nonrutin.php */
/* Location: ./application/controllers/T103_nonrutin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-29 01:40:20 */
/* http://harviacode.com */