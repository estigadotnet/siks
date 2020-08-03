<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T000_sekolah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T000_sekolah_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't000_sekolah/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't000_sekolah/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't000_sekolah/index.html';
            $config['first_url'] = base_url() . 't000_sekolah/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T000_sekolah_model->total_rows($q);
        $t000_sekolah = $this->T000_sekolah_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't000_sekolah_data' => $t000_sekolah,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array(
              "title" => "Sekolah"
            ),
            "title" => "Sekolah",
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }
        
        $this->load->view('t000_sekolah/t000_sekolah_list', $data);
    }

    public function read($id)
    {
        $row = $this->T000_sekolah_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'kode' => $row->kode,
		'nama' => $row->nama,
    "head" => array(
      "title" => "Sekolah"
    ),
    "title" => "Sekolah",
	    );
            $this->load->view('t000_sekolah/t000_sekolah_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t000_sekolah'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t000_sekolah/create_action'),
	    'id' => set_value('id'),
	    'kode' => set_value('kode'),
	    'nama' => set_value('nama'),
      "head" => array(
        "title" => "Sekolah"
      ),
      "title" => "Sekolah",
	);
        $this->load->view('t000_sekolah/t000_sekolah_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'kode' => $this->input->post('kode',TRUE),
		'nama' => $this->input->post('nama',TRUE),
	    );

            $this->T000_sekolah_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t000_sekolah'));
        }
    }

    public function update($id)
    {
        $row = $this->T000_sekolah_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t000_sekolah/update_action'),
		'id' => set_value('id', $row->id),
		'kode' => set_value('kode', $row->kode),
		'nama' => set_value('nama', $row->nama),
    "head" => array(
      "title" => "Sekolah"
    ),
    "title" => "Sekolah",
	    );
            $this->load->view('t000_sekolah/t000_sekolah_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t000_sekolah'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'kode' => $this->input->post('kode',TRUE),
		'nama' => $this->input->post('nama',TRUE),
	    );

            $this->session->set_userdata("namasekolah", $this->input->post("nama", true));
            $this->T000_sekolah_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t000_sekolah'));
        }
    }

    public function delete($id)
    {
        $row = $this->T000_sekolah_model->get_by_id($id);

        if ($row) {
            $this->T000_sekolah_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t000_sekolah'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t000_sekolah'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('kode', 'kode', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t000_sekolah.xls";
        $judul = "t000_sekolah";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Kode");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");

	foreach ($this->T000_sekolah_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t000_sekolah.doc");

        $data = array(
            't000_sekolah_data' => $this->T000_sekolah_model->get_all(),
            'start' => 0
        );

        $this->load->view('t000_sekolah/t000_sekolah_doc',$data);
    }

}

/* End of file T000_sekolah.php */
/* Location: ./application/controllers/T000_sekolah.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-26 07:16:53 */
/* http://harviacode.com */
