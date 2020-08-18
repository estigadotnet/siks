<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T101_spp2 extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T101_spp2_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't101_spp2/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't101_spp2/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't101_spp2/index.html';
            $config['first_url'] = base_url() . 't101_spp2/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T101_spp2_model->total_rows($q);
        $t101_spp2 = $this->T101_spp2_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't101_spp2_data' => $t101_spp2,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('t101_spp2/t101_spp2_list', $data);
    }

    public function read($id)
    {
        $row = $this->T101_spp2_model->get_by_id($id);
        if ($row) {
            $data = array(
		'idspp' => $row->idspp,
		'idsiswa' => $row->idsiswa,
		'jatuhtempo' => $row->jatuhtempo,
		'bulan' => $row->bulan,
		'nobayar' => $row->nobayar,
		'tglbayar' => $row->tglbayar,
		'byrspp' => $row->byrspp,
		'byrcatering' => $row->byrcatering,
		'byrworksheet' => $row->byrworksheet,
		'ket' => $row->ket,
		'idadmin' => $row->idadmin,
	    );
            $this->load->view('t101_spp2/t101_spp2_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp2'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t101_spp2/create_action'),
	    'idspp' => set_value('idspp'),
	    'idsiswa' => set_value('idsiswa'),
	    'jatuhtempo' => set_value('jatuhtempo'),
	    'bulan' => set_value('bulan'),
	    'nobayar' => set_value('nobayar'),
	    'tglbayar' => set_value('tglbayar'),
	    'byrspp' => set_value('byrspp'),
	    'byrcatering' => set_value('byrcatering'),
	    'byrworksheet' => set_value('byrworksheet'),
	    'ket' => set_value('ket'),
	    'idadmin' => set_value('idadmin'),
	);
        $this->load->view('t101_spp2/t101_spp2_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'idsiswa' => $this->input->post('idsiswa',TRUE),
		'jatuhtempo' => $this->input->post('jatuhtempo',TRUE),
		'bulan' => $this->input->post('bulan',TRUE),
		'nobayar' => $this->input->post('nobayar',TRUE),
		'tglbayar' => $this->input->post('tglbayar',TRUE),
		'byrspp' => $this->input->post('byrspp',TRUE),
		'byrcatering' => $this->input->post('byrcatering',TRUE),
		'byrworksheet' => $this->input->post('byrworksheet',TRUE),
		'ket' => $this->input->post('ket',TRUE),
		'idadmin' => $this->input->post('idadmin',TRUE),
	    );

            $this->T101_spp2_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t101_spp2'));
        }
    }

    public function update($id)
    {
        $row = $this->T101_spp2_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t101_spp2/update_action'),
		'idspp' => set_value('idspp', $row->idspp),
		'idsiswa' => set_value('idsiswa', $row->idsiswa),
		'jatuhtempo' => set_value('jatuhtempo', $row->jatuhtempo),
		'bulan' => set_value('bulan', $row->bulan),
		'nobayar' => set_value('nobayar', $row->nobayar),
		'tglbayar' => set_value('tglbayar', $row->tglbayar),
		'byrspp' => set_value('byrspp', $row->byrspp),
		'byrcatering' => set_value('byrcatering', $row->byrcatering),
		'byrworksheet' => set_value('byrworksheet', $row->byrworksheet),
		'ket' => set_value('ket', $row->ket),
		'idadmin' => set_value('idadmin', $row->idadmin),
	    );
            $this->load->view('t101_spp2/t101_spp2_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp2'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idspp', TRUE));
        } else {
            $data = array(
		'idsiswa' => $this->input->post('idsiswa',TRUE),
		'jatuhtempo' => $this->input->post('jatuhtempo',TRUE),
		'bulan' => $this->input->post('bulan',TRUE),
		'nobayar' => $this->input->post('nobayar',TRUE),
		'tglbayar' => $this->input->post('tglbayar',TRUE),
		'byrspp' => $this->input->post('byrspp',TRUE),
		'byrcatering' => $this->input->post('byrcatering',TRUE),
		'byrworksheet' => $this->input->post('byrworksheet',TRUE),
		'ket' => $this->input->post('ket',TRUE),
		'idadmin' => $this->input->post('idadmin',TRUE),
	    );

            $this->T101_spp2_model->update($this->input->post('idspp', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t101_spp2'));
        }
    }

    public function delete($id)
    {
        $row = $this->T101_spp2_model->get_by_id($id);

        if ($row) {
            $this->T101_spp2_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t101_spp2'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp2'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('idsiswa', 'idsiswa', 'trim|required');
	$this->form_validation->set_rules('jatuhtempo', 'jatuhtempo', 'trim|required');
	$this->form_validation->set_rules('bulan', 'bulan', 'trim|required');
	$this->form_validation->set_rules('nobayar', 'nobayar', 'trim|required');
	$this->form_validation->set_rules('tglbayar', 'tglbayar', 'trim|required');
	$this->form_validation->set_rules('byrspp', 'byrspp', 'trim|required');
	$this->form_validation->set_rules('byrcatering', 'byrcatering', 'trim|required');
	$this->form_validation->set_rules('byrworksheet', 'byrworksheet', 'trim|required');
	$this->form_validation->set_rules('ket', 'ket', 'trim|required');
	$this->form_validation->set_rules('idadmin', 'idadmin', 'trim|required');

	$this->form_validation->set_rules('idspp', 'idspp', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t101_spp2.xls";
        $judul = "t101_spp2";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Jatuhtempo");
	xlsWriteLabel($tablehead, $kolomhead++, "Bulan");
	xlsWriteLabel($tablehead, $kolomhead++, "Nobayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Tglbayar");
	xlsWriteLabel($tablehead, $kolomhead++, "Byrspp");
	xlsWriteLabel($tablehead, $kolomhead++, "Byrcatering");
	xlsWriteLabel($tablehead, $kolomhead++, "Byrworksheet");
	xlsWriteLabel($tablehead, $kolomhead++, "Ket");
	xlsWriteLabel($tablehead, $kolomhead++, "Idadmin");

	foreach ($this->T101_spp2_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->idsiswa);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jatuhtempo);
	    xlsWriteLabel($tablebody, $kolombody++, $data->bulan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nobayar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tglbayar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->byrspp);
	    xlsWriteNumber($tablebody, $kolombody++, $data->byrcatering);
	    xlsWriteNumber($tablebody, $kolombody++, $data->byrworksheet);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ket);
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
        header("Content-Disposition: attachment;Filename=t101_spp2.doc");

        $data = array(
            't101_spp2_data' => $this->T101_spp2_model->get_all(),
            'start' => 0
        );

        $this->load->view('t101_spp2/t101_spp2_doc',$data);
    }


    public function ubah_spp_siswa()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't101_spp2/ubah_spp_siswa?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't101_spp2/ubah_spp_siswa?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't101_spp2/ubah_spp_siswa';
            $config['first_url'] = base_url() . 't101_spp2/ubah_spp_siswa';
        }

        $config['per_page'] = 10000000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T101_spp2_model->total_rows_2($q);
        $t101_spp2 = $this->T101_spp2_model->get_limit_data_2($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't101_spp2_data' => $t101_spp2,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array("title" => "Ubah SPP per Siswa"),
            "title" => "Ubah SPP per Siswa",
        );
        $this->load->view('t101_spp2/t101_spp2_list', $data);
    }

}

/* End of file T101_spp2.php */
/* Location: ./application/controllers/T101_spp2.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-08-18 18:31:54 */
/* http://harviacode.com */
