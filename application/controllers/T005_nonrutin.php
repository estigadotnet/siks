<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T005_nonrutin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T005_nonrutin_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't005_nonrutin/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't005_nonrutin/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't005_nonrutin/index.html';
            $config['first_url'] = base_url() . 't005_nonrutin/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T005_nonrutin_model->total_rows($q);
        $t005_nonrutin = $this->T005_nonrutin_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't005_nonrutin_data' => $t005_nonrutin,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array("title" => "Daftar Pembayaran Non-Rutin"),
            "title" => "Daftar Pembayaran Non-Rutin",
          );
        $this->load->view('t005_nonrutin/t005_nonrutin_list', $data);
    }

    public function read($id)
    {
        $row = $this->T005_nonrutin_model->get_by_id($id);
        if ($row) {
            $data = array(
            		'id' => $row->id,
            		'Jenis' => $row->Jenis,
                "head" => array("title" => "Daftar Pembayaran Non-Rutin"),
                "title" => "Daftar Pembayaran Non-Rutin",
              );
            $this->load->view('t005_nonrutin/t005_nonrutin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t005_nonrutin'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t005_nonrutin/create_action'),
      	    'id' => set_value('id'),
      	    'Jenis' => set_value('Jenis'),
            "head" => array("title" => "Daftar Pembayaran Non-Rutin"),
            "title" => "Daftar Pembayaran Non-Rutin",
          );
        $this->load->view('t005_nonrutin/t005_nonrutin_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'Jenis' => $this->input->post('Jenis',TRUE),
              );
            $this->T005_nonrutin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t005_nonrutin'));
        }
    }

    public function update($id)
    {
        $row = $this->T005_nonrutin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t005_nonrutin/update_action'),
            		'id' => set_value('id', $row->id),
            		'Jenis' => set_value('Jenis', $row->Jenis),
                "head" => array("title" => "Daftar Pembayaran Non-Rutin"),
                "title" => "Daftar Pembayaran Non-Rutin",
              );
            $this->load->view('t005_nonrutin/t005_nonrutin_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t005_nonrutin'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'Jenis' => $this->input->post('Jenis',TRUE),
              );
            $this->T005_nonrutin_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t005_nonrutin'));
        }
    }

    public function delete($id)
    {
        $row = $this->T005_nonrutin_model->get_by_id($id);

        if ($row) {
            $this->T005_nonrutin_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t005_nonrutin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t005_nonrutin'));
        }
    }

    public function _rules()
    {
      	$this->form_validation->set_rules('Jenis', 'jenis', 'trim|required');

      	$this->form_validation->set_rules('id', 'id', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t005_nonrutin.xls";
        $judul = "t005_nonrutin";
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
      	xlsWriteLabel($tablehead, $kolomhead++, "Jenis");

      	foreach ($this->T005_nonrutin_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->Jenis);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t005_nonrutin.doc");

        $data = array(
            't005_nonrutin_data' => $this->T005_nonrutin_model->get_all(),
            'start' => 0
        );

        $this->load->view('t005_nonrutin/t005_nonrutin_doc',$data);
    }

}

/* End of file T005_nonrutin.php */
/* Location: ./application/controllers/T005_nonrutin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-28 23:40:03 */
/* http://harviacode.com */
