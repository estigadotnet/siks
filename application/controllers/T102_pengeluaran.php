<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T102_pengeluaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T102_pengeluaran_model');
        $this->load->library('form_validation');
    }

    // cetak laporan ke xls
    public function laporan_xls()
    {
      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      // echo $this->input->post('tglBayar',TRUE);
      $tgl  = urldecode($this->input->get('tglBayar', TRUE));
      $tgl1 = substr($tgl, 0, 10);
      $tgl2 = substr($tgl, 13, 10);
      $tglByr1 = substr($tgl1, 6, 4) . "-" . substr($tgl1, 0, 2) . "-" . substr($tgl1, 3, 2);
      $tglByr2 = substr($tgl2, 6, 4) . "-" . substr($tgl2, 0, 2) . "-" . substr($tgl2, 3, 2);
      $dataByr = $this->T102_pengeluaran_model->get_data_laporan($tglByr1, $tglByr2);
      $data = array(
        "aDataByr" => $dataByr,
        "tgl1"     => $tglByr1,
        "tgl2"     => $tglByr2
      );
      $this->load->view("t102_pengeluaran/t102_pengeluaran_laporan_xls", $data);
    }

    // cetak laporan ke layar
    public function laporan()
    {
      $q        = urldecode($this->input->post('q', TRUE));
      $tgl1     = "";
      $tgl2     = "";
      $t102_pengeluaran = 0;

      if ($q <> '') {
        $tglInput1 = substr($q, 0, 10);
        $tglInput2 = substr($q, 13, 10);
        $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
        $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
        //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
        $t102_pengeluaran = $this->T102_pengeluaran_model->get_data_laporan($tgl1, $tgl2);
        if ($t102_pengeluaran == 0) $q = "";
      }

      $data = array(
        "q"             => $q,
        't102_pengeluaran_data' => $t102_pengeluaran,
        "tgl1"          => $tgl1,
        "tgl2"          => $tgl2,
        "head"          => array("title" => "Laporan Belanja Sekolah"),
        "title"         => "Laporan Belanja Sekolah",
      );

      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->view("t102_pengeluaran/t102_pengeluaran_laporan", $data);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't102_pengeluaran/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't102_pengeluaran/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't102_pengeluaran/index.html';
            $config['first_url'] = base_url() . 't102_pengeluaran/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T102_pengeluaran_model->total_rows($q);
        $t102_pengeluaran = $this->T102_pengeluaran_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't102_pengeluaran_data' => $t102_pengeluaran,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array(
              "title" => "Belanja Sekolah"
            ),
            "title" => "Belanja Sekolah",
        );
        $this->load->view('t102_pengeluaran/t102_pengeluaran_list', $data);
    }

    public function read($id)
    {
        $row = $this->T102_pengeluaran_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tgl' => $row->tgl,
		'nobuk' => $row->nobuk,
		'keterangan' => $row->keterangan,
		'jumlah' => $row->jumlah,
    "head" => array(
      "title" => "Belanja Sekolah"
    ),
    "title" => "Belanja Sekolah",
	    );
            $this->load->view('t102_pengeluaran/t102_pengeluaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t102_pengeluaran'));
        }
    }

    public function create()
    {
      //membuat nomor bukti pengekuaran baru
      // $today = date("ymd");
      // $query = mysqli_query($konek, "SELECT max(nobuk) AS last FROM pengeluaran WHERE nobuk LIKE '$today%'");
      // $data = mysqli_fetch_array($query);
      // $lastNobuk = $data['last'];
      // $lastNoUrut = substr($lastNobuk, 6, 4);
      // $nextNoUrut = $lastNoUrut + 1;
      // $nextNobuk = $today.sprintf('%04s', $nextNoUrut);
      $nextNobuk = $this->T102_pengeluaran_model->get_max_nobuk();

        $data = array(
            'button' => 'Create',
            'action' => site_url('t102_pengeluaran/create_action'),
	    'id' => set_value('id'),
	    'tgl' => set_value('tgl', date("Y-m-d")),
	    'nobuk' => set_value('nobuk', $nextNobuk),
	    'keterangan' => set_value('keterangan'),
	    'jumlah' => set_value('jumlah'),
      "head" => array(
        "title" => "Belanja Sekolah"
      ),
      "title" => "Belanja Sekolah",
	);
        $this->load->view('t102_pengeluaran/t102_pengeluaran_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tgl' => $this->input->post('tgl',TRUE),
		'nobuk' => $this->input->post('nobuk',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
	    );

            $this->T102_pengeluaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t102_pengeluaran'));
        }
    }

    public function update($id)
    {
        $row = $this->T102_pengeluaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t102_pengeluaran/update_action'),
		'id' => set_value('id', $row->id),
		'tgl' => set_value('tgl', $row->tgl),
		'nobuk' => set_value('nobuk', $row->nobuk),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'jumlah' => set_value('jumlah', $row->jumlah),
    "head" => array(
      "title" => "Belanja Sekolah"
    ),
    "title" => "Belanja Sekolah",
	    );
            $this->load->view('t102_pengeluaran/t102_pengeluaran_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t102_pengeluaran'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'tgl' => $this->input->post('tgl',TRUE),
		'nobuk' => $this->input->post('nobuk',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
	    );

            $this->T102_pengeluaran_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t102_pengeluaran'));
        }
    }

    public function delete($id)
    {
        $row = $this->T102_pengeluaran_model->get_by_id($id);

        if ($row) {
            $this->T102_pengeluaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t102_pengeluaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t102_pengeluaran'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
	$this->form_validation->set_rules('nobuk', 'nobuk', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t102_pengeluaran.xls";
        $judul = "t102_pengeluaran";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl");
	xlsWriteLabel($tablehead, $kolomhead++, "Nobuk");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jumlah");

	foreach ($this->T102_pengeluaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nobuk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jumlah);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t102_pengeluaran.doc");

        $data = array(
            't102_pengeluaran_data' => $this->T102_pengeluaran_model->get_all(),
            'start' => 0
        );

        $this->load->view('t102_pengeluaran/t102_pengeluaran_doc',$data);
    }

}

/* End of file T102_pengeluaran.php */
/* Location: ./application/controllers/T102_pengeluaran.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-26 00:54:42 */
/* http://harviacode.com */
