<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T002_guru extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T002_guru_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't002_guru?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't002_guru?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't002_guru'; ///index.html';
            $config['first_url'] = base_url() . 't002_guru'; ///index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T002_guru_model->total_rows($q);
        $t002_guru = $this->T002_guru_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
          't002_guru_data' => $t002_guru,
          'q' => $q,
          'pagination' => $this->pagination->create_links(),
          'total_rows' => $config['total_rows'],
          'start' => $start,
          "head" => array(
            "title" => "Wali Kelas"
          ),
          "title" => "Wali Kelas",
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t002_guru/t002_guru_list', $data);
    }

    public function read($id)
    {
        $row = $this->T002_guru_model->get_by_id($id);
        if ($row) {
            $data = array(
              'idguru' => $row->idguru,
              'namaguru' => $row->namaguru,
              "head" => array(
                "title" => "Wali Kelas"
              ),
              "title" => "Wali Kelas",
            );
            $this->load->view('t002_guru/t002_guru_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t002_guru'));
        }
    }

    public function create()
    {
        $data = array(
          'button' => 'Create',
          'action' => site_url('t002_guru/create_action'),
          'idguru' => set_value('idguru'),
          'namaguru' => set_value('namaguru'),
          "head" => array(
            "title" => "Wali Kelas"
          ),
          "title" => "Wali Kelas",
        );
        $this->load->view('t002_guru/t002_guru_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
              'namaguru' => $this->input->post('namaguru',TRUE),
            );

            $this->T002_guru_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t002_guru'));
        }
    }

    public function update($id)
    {
        $row = $this->T002_guru_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t002_guru/update_action'),
                'idguru' => set_value('idguru', $row->idguru),
                'namaguru' => set_value('namaguru', $row->namaguru),
                "head" => array(
                  "title" => "Wali Kelas"
                ),
                "title" => "Wali Kelas",
            );
            $this->load->view('t002_guru/t002_guru_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t002_guru'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idguru', TRUE));
        } else {
            $data = array(
              'namaguru' => $this->input->post('namaguru',TRUE),
            );

            $this->T002_guru_model->update($this->input->post('idguru', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t002_guru'));
        }
    }

    public function delete($id)
    {
        $row = $this->T002_guru_model->get_by_id($id);

        if ($row) {
            $this->T002_guru_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t002_guru'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t002_guru'));
        }
    }

    public function _rules()
    {
      $this->form_validation->set_rules('namaguru', 'namaguru', 'trim|required');

      $this->form_validation->set_rules('idguru', 'idguru', 'trim');
      $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t002_guru.xls";
        $judul = "t002_guru";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Namaguru");

        foreach ($this->T002_guru_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->namaguru);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t002_guru.doc");

        $data = array(
            't002_guru_data' => $this->T002_guru_model->get_all(),
            'start' => 0
        );

        $this->load->view('t002_guru/t002_guru_doc',$data);
    }

}

/* End of file T002_guru.php */
/* Location: ./application/controllers/T002_guru.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-19 02:03:48 */
/* http://harviacode.com */
