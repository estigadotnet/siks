<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T003_kelas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T003_kelas_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't003_kelas?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't003_kelas?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't003_kelas'; ///index.html';'
            $config['first_url'] = base_url() . 't003_kelas'; ///index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T003_kelas_model->total_rows($q);
        $t003_kelas = $this->T003_kelas_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't003_kelas_data' => $t003_kelas,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array(
              "title" => "Kelas"),
            "title" => "Kelas",
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t003_kelas/t003_kelas_list', $data);
    }

    public function read($id)
    {
        $row = $this->T003_kelas_model->get_by_id($id);
        if ($row) {
            $data = array(
            		'idkelas' => $row->idkelas,
            		'kelas' => $row->kelas,
            		'idguru' => $row->idguru,
                "namaguru" => $row->namaguru,
                "head" => array(
                  "title" => "Kelas"),
                "title" => "Kelas",
            );
            $this->load->view('t003_kelas/t003_kelas_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t003_kelas'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t003_kelas/create_action'),
      	    'idkelas' => set_value('idkelas'),
      	    'kelas' => set_value('kelas'),
      	    'idguru' => set_value('idguru'),
            "head" => array(
              "title" => "Kelas"),
            "title" => "Kelas",
            "dataGuru" => $this->T003_kelas_model->getGuru(),
      	);
        $this->load->view('t003_kelas/t003_kelas_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kelas' => $this->input->post('kelas',TRUE),
                'idguru' => $this->input->post('idguru',TRUE),
      	    );

            $this->T003_kelas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t003_kelas'));
        }
    }

    public function update($id)
    {
        $row = $this->T003_kelas_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t003_kelas/update_action'),
                'idkelas' => set_value('idkelas', $row->idkelas),
                'kelas' => set_value('kelas', $row->kelas),
                'idguru' => set_value('idguru', $row->idguru),
                "head" => array(
                  "title" => "Kelas"),
                "title" => "Kelas",
                "dataGuru" => $this->T003_kelas_model->getGuru(),
            );
            $this->load->view('t003_kelas/t003_kelas_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t003_kelas'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idkelas', TRUE));
        } else {
            $data = array(
                'kelas' => $this->input->post('kelas',TRUE),
                'idguru' => $this->input->post('idguru',TRUE),
            );

            $this->T003_kelas_model->update($this->input->post('idkelas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t003_kelas'));
        }
    }

    public function delete($id)
    {
        $row = $this->T003_kelas_model->get_by_id($id);

        if ($row) {
            $this->T003_kelas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t003_kelas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t003_kelas'));
        }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('kelas', 'kelas', 'trim|required');
      	$this->form_validation->set_rules('idguru', 'idguru', 'trim|required');

      	$this->form_validation->set_rules('idkelas', 'idkelas', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t003_kelas.xls";
        $judul = "t003_kelas";
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
      	xlsWriteLabel($tablehead, $kolomhead++, "Kelas");
      	xlsWriteLabel($tablehead, $kolomhead++, "Idguru");

      	foreach ($this->T003_kelas_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->kelas);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->idguru);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t003_kelas.doc");

        $data = array(
            't003_kelas_data' => $this->T003_kelas_model->get_all(),
            'start' => 0
        );

        $this->load->view('t003_kelas/t003_kelas_doc',$data);
    }

}

/* End of file T003_kelas.php */
/* Location: ./application/controllers/T003_kelas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-19 06:41:35 */
/* http://harviacode.com */
