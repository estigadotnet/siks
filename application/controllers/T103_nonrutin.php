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
        $this->load->model("T005_nonrutin_model");
        $this->load->model("T004_siswa_model");
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['per_page'] = 12;
        $config['page_query_string'] = TRUE;

        $dataSiswa    = 0;
        $dataSiswaTA  = 0;
        $dataNonRutin = 0;

        if ($q <> '') {
            $config['base_url'] = base_url() . 't103_nonrutin/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't103_nonrutin/index.html?q=' . urlencode($q);
            $config['total_rows'] = $this->T103_nonrutin_model->total_rows_nis($q);
            $t103_nonrutin = $this->T103_nonrutin_model->get_limit_data_nis($config['per_page'], $start, $q);
            $dataSiswa = $this->T103_nonrutin_model->getSiswa($q); //echo "<pre>"; print_r($dataSiswa); echo "</pre>";
            $dataSiswaTA = $this->T103_nonrutin_model->getSiswaTA($q); //echo "<pre>"; print_r($dataSiswaTA); echo "</pre>";
            if ($t103_nonrutin == 0) $q = "";
            $dataNonRutin = $this->T005_nonrutin_model->get_all(); //echo "<pre>"; print_r($dataNonRutin); echo "</pre>";
        } else {
            $config['base_url'] = base_url() . 't103_nonrutin/index.html';
            $config['first_url'] = base_url() . 't103_nonrutin/index.html';
            $config['total_rows'] = $this->T103_nonrutin_model->total_rows($q);
            $t103_nonrutin = $this->T103_nonrutin_model->get_limit_data($config['per_page'], $start, $q);
        }

        // $config['per_page'] = 10;
        // $config['page_query_string'] = TRUE;
        // $config['total_rows'] = $this->T103_nonrutin_model->total_rows($q);
        // $t103_nonrutin = $this->T103_nonrutin_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't103_nonrutin_data' => $t103_nonrutin,
            'q'                  => $q,
            'pagination'         => $this->pagination->create_links(),
            'total_rows'         => $config['total_rows'],
            'start'              => $start,
            "head"               => array("title" => "Pembayaran Non-Rutin"),
            "title"              => "Pembayaran Non-Rutin",
            "dataSiswa"          => $dataSiswa,
            "dataSiswaTA"        => $dataSiswaTA,
            "dataNonRutin"       => $dataNonRutin,
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

    public function create($q)
    {
      // ambil data siswa: idsiswa dan tahun ajaran
      $dataSiswa = $this->T004_siswa_model->getAllByNis($q); //echo "<pre>"; print_r($dataSiswa); echo "</pre>";
      foreach ($dataSiswa as $r) {
        // code...
        $aSiswa[$r->idsiswa] = $r->tahunajaran;
      } //echo "<pre>"; print_r($aSiswa); echo "</pre>";

      // ambil jenis non rutin
      $dataNonRutin = $this->T005_nonrutin_model->get_all(); //echo "<pre>"; print_r($dataNonRutin); echo "</pre>";
      foreach ($dataNonRutin as $r) {
        // code...
        $aNonRutin[$r->id] = $r->Jenis;
      } //echo "<pre>"; print_r($aNonRutin); echo "</pre>";

      //membuat nomor bayar
      $today = date("ymd");
      $data = $this->T103_nonrutin_model->getMaxNoBayar();
      $lastNoBayar = $data['last'];
      $lastNoUrut = substr($lastNoBayar, 6, 4);
      $nextNoUrut = $lastNoUrut + 1;
      $nextNoBayar = $today.sprintf('%04s', $nextNoUrut);

      //tanggal Bayar
      $tglBayar = date('Y-m-d');

      $data = array(
        'button'     => 'Create',
        'action'     => site_url('t103_nonrutin/create_action'),
  	    'idnonrutin' => set_value('idnonrutin'),
  	    'idsiswa'    => set_value('idsiswa'),
  	    'nobayar'    => set_value('nobayar', $nextNoBayar),
  	    'tglbayar'   => set_value('tglbayar', $tglBayar),
  	    'idjenis'    => set_value('idjenis'),
  	    'nominal'    => set_value('nominal', 0),
  	    'bayar'      => set_value('bayar'),
  	    //'sisa'       => set_value('sisa'),
  	    //'idadmin'    => set_value('idadmin'),
        "head"       => array("title" => "Pembayaran Non-Rutin"),
        "title"      => "Pembayaran Non-Rutin",
        "aSiswa"     => $aSiswa,
        "aNonRutin"  => $aNonRutin,
        "q"          => $q,
        "readOnly"   => "readonly",
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
          		'nominal' => 0,
          		'bayar' => $this->input->post('bayar',TRUE),
          		'sisa' => 0,
          		'idadmin' => $this->session->userdata("user_id"),
            );

            $q = $this->input->post('q', true);

            $this->T103_nonrutin_model->insert($data);
            $this->T103_nonrutin_model->hitungSisa($data["idsiswa"], $data["idjenis"]);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t103_nonrutin/index?q='.$q));
        }
    }

    public function update($id, $q)
    {
        // ambil data siswa: idsiswa dan tahun ajaran
        $dataSiswa = $this->T004_siswa_model->getAllByNis($q); //echo "<pre>"; print_r($dataSiswa); echo "</pre>";
        foreach ($dataSiswa as $r) {
          // code...
          $aSiswa[$r->idsiswa] = $r->tahunajaran;
        } //echo "<pre>"; print_r($aSiswa); echo "</pre>";

        // ambil jenis non rutin
        $dataNonRutin = $this->T005_nonrutin_model->get_all(); //echo "<pre>"; print_r($dataNonRutin); echo "</pre>";
        foreach ($dataNonRutin as $r) {
          // code...
          $aNonRutin[$r->id] = $r->Jenis;
        } //echo "<pre>"; print_r($aNonRutin); echo "</pre>";

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
        		//'sisa' => set_value('sisa', $row->sisa),
        		//'idadmin' => set_value('idadmin', $row->idadmin),
            "head"       => array("title" => "Pembayaran Non-Rutin"),
            "title"      => "Pembayaran Non-Rutin",
            "aSiswa"     => $aSiswa,
            "aNonRutin"  => $aNonRutin,
            "q"          => $q,
            "readOnly"   => "",
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
          		'idadmin' => $this->session->userdata("user_id"),
            );

            $q = $this->input->post('q', true);

            $this->T103_nonrutin_model->update($this->input->post('idnonrutin', TRUE), $data);
            $this->T103_nonrutin_model->hitungSisa($data["idsiswa"], $data["idjenis"]);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t103_nonrutin/index?q='.$q));
        }
    }

    public function delete($id, $q)
    {
        $row = $this->T103_nonrutin_model->get_by_id($id);

        if ($row) {
            $this->T103_nonrutin_model->delete($id);
            $this->T103_nonrutin_model->hitungSisa($row->idsiswa, $row->idjenis);
            $this->session->set_flashdata('message', 'Delete Record Success');

            redirect(site_url('t103_nonrutin/index?q='.$q));
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
	// $this->form_validation->set_rules('nominal', 'nominal', 'trim|required');
	$this->form_validation->set_rules('bayar', 'bayar', 'trim|required');
	// $this->form_validation->set_rules('sisa', 'sisa', 'trim|required');
	// $this->form_validation->set_rules('idadmin', 'idadmin', 'trim|required');

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

    // cetak bukti pembayaran
    public function cetak()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $q = urldecode($this->input->get('q', TRUE));
        //$dataSiswa = $this->T103_nonrutin_model->getSiswa($q);
        $idNonRutin = urldecode($this->input->get('idNonRutin', TRUE));
        $aNonRutin = $this->T103_nonrutin_model->get_by_id($idNonRutin); //echo "<pre>"; print_r($aNonRutin); echo "</pre>";
        $aJenisNonRutin = $this->T005_nonrutin_model->get_by_id($aNonRutin->idjenis); //echo "<pre>"; print_r($aJenisNonRutin); echo "</pre>";
        $aSiswa = $this->T103_nonrutin_model->getSiswa($q);
        $aAllNonRutin = $this->T103_nonrutin_model->getAllById($idNonRutin);
        $data = array(
          "aNonRutin"      => $aNonRutin,
          "aSiswa"         => $aSiswa,
          "aJenisNonRutin" => $aJenisNonRutin,
          "aAllNonRutin"   => $aAllNonRutin,
        );
        $this->load->view("t103_nonrutin/t103_nonrutin_invoice", $data);
    }

    // cetak laporan ke layar
    public function laporan()
    {
      $q             = urldecode($this->input->post('q', TRUE));
      $tgl1          = "";
      $tgl2          = "";
      $t103_nonrutin = 0;

      if ($q <> '') {
        $tglInput1 = substr($q, 0, 10);
        $tglInput2 = substr($q, 13, 10);
        $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
        $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
        //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
        $t103_nonrutin = $this->T103_nonrutin_model->get_data_laporan($tgl1, $tgl2);
        if ($t103_nonrutin == 0) $q = "";
      }

      $data = array(
        "q"             => $q,
        't103_nonrutin_data' => $t103_nonrutin,
        "tgl1"          => $tgl1,
        "tgl2"          => $tgl2,
        "head"          => array("title" => "Laporan Pembayaran Non-Rutin"),
        "title"         => "Laporan Pembayaran Non-Rutin",
      );

      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->view("t103_nonrutin/t103_nonrutin_laporan", $data);
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
      $dataByr = $this->T103_nonrutin_model->get_data_laporan($tglByr1, $tglByr2);
      $data = array(
        "aDataByr" => $dataByr,
        "tgl1"     => $tglByr1,
        "tgl2"     => $tglByr2
      );
      $this->load->view("t103_nonrutin/t103_nonrutin_laporan_xls", $data);
    }

}

/* End of file T103_nonrutin.php */
/* Location: ./application/controllers/T103_nonrutin.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-29 01:40:20 */
/* http://harviacode.com */
