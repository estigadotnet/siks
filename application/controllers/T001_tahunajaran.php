<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T001_tahunajaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T001_tahunajaran_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't001_tahunajaran?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't001_tahunajaran?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't001_tahunajaran';
            $config['first_url'] = base_url() . 't001_tahunajaran';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T001_tahunajaran_model->total_rows($q);
        $t001_tahunajaran = $this->T001_tahunajaran_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't001_tahunajaran_data' => $t001_tahunajaran,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array(
              "title" => "Tahun Ajaran"
            ),
            "title" => "Tahun Ajaran",
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t001_tahunajaran/t001_tahunajaran_list', $data);
    }

    public function read($id)
    {
        $row = $this->T001_tahunajaran_model->get_by_id($id);
        if ($row) {
            $data = array(
          		'idtahunajaran' => $row->idtahunajaran,
          		'tahunajaran' => $row->tahunajaran,
              "saldoawal" => $row->saldoawal,
              "head" => array(
                "title" => "Tahun Ajaran"
              ),
              "title" => "Tahun Ajaran",
            );
            $this->load->view('t001_tahunajaran/t001_tahunajaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t001_tahunajaran'));
        }
    }

    public function create()
    {
        $data = array(
          'button' => 'Create',
          'action' => site_url('t001_tahunajaran/create_action'),
          'idtahunajaran' => set_value('idtahunajaran'),
          'tahunajaran' => set_value('tahunajaran'),
          "saldoawal" => set_value("saldoawal"),
          "head" => array(
            "title" => "Tahun Ajaran"
          ),
          "title" => "Tahun Ajaran",
        );
        $this->load->view('t001_tahunajaran/t001_tahunajaran_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'tahunajaran' => $this->input->post('tahunajaran',TRUE),
              "saldoawal" => $this->input->post("saldoawal", true),
            );

            $this->T001_tahunajaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t001_tahunajaran'));
        }
    }

    public function update($id)
    {
        $row = $this->T001_tahunajaran_model->get_by_id($id);

        if ($row) {
            $data = array(
              'button' => 'Update',
              'action' => site_url('t001_tahunajaran/update_action'),
              'idtahunajaran' => set_value('idtahunajaran', $row->idtahunajaran),
              'tahunajaran' => set_value('tahunajaran', $row->tahunajaran),
              "saldoawal" => set_value("saldoawal", $row->saldoawal),
              "head" => array(
                "title" => "Tahun Ajaran"
              ),
              "title" => "Tahun Ajaran",
            );
            $this->load->view('t001_tahunajaran/t001_tahunajaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t001_tahunajaran'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idtahunajaran', TRUE));
        } else {
            $data = array(
              'tahunajaran' => $this->input->post('tahunajaran',TRUE),
              "saldoawal" => $this->input->post("saldoawal", true),
            );

            $this->T001_tahunajaran_model->update($this->input->post('idtahunajaran', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t001_tahunajaran'));
        }
    }

    public function delete($id)
    {
        $row = $this->T001_tahunajaran_model->get_by_id($id);

        if ($row) {
            $this->T001_tahunajaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t001_tahunajaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t001_tahunajaran'));
        }
    }

    public function _rules()
    {
    	$this->form_validation->set_rules('tahunajaran', 'tahunajaran', 'trim|required');
      $this->form_validation->set_rules("saldoawal", "saldoawal", "trim|required");

    	$this->form_validation->set_rules('idtahunajaran', 'idtahunajaran', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t001_tahunajaran.xls";
        $judul = "t001_tahunajaran";
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
      	xlsWriteLabel($tablehead, $kolomhead++, "Tahun Ajaran");
        xlsWriteLabel($tablehead, $kolomhead++, "Saldo Awal");

      	foreach ($this->T001_tahunajaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->tahunajaran);
            xlsWriteLabel($tablebody, $kolombody++, $data->saldoawal);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t001_tahunajaran.doc");

        $data = array(
            't001_tahunajaran_data' => $this->T001_tahunajaran_model->get_all(),
            'start' => 0
        );

        $this->load->view('t001_tahunajaran/t001_tahunajaran_doc',$data);
    }

    public function activate($idtahunajaran) {
      $r = $this->T001_tahunajaran_model->get_by_id($idtahunajaran);
      $this->session->set_userdata("tahunajaran", $r->tahunajaran);
      redirect("t001_tahunajaran");
    }

}

/* End of file T001_tahunajaran.php */
/* Location: ./application/controllers/T001_tahunajaran.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-18 21:36:43 */
/* http://harviacode.com */
