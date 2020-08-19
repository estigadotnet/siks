<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T101_spp extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T101_spp_model');
        $this->load->library('form_validation');
        $this->load->model('T004_siswa_model');
        $this->load->model('T003_kelas_model');
    }


    // cetak tunggakan ke xls
    public function tunggakan_tgl_xls()
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
      $dataByr = $this->T101_spp_model->get_data_tunggakan_tgl($tglByr1, $tglByr2);
      $data = array(
        "aDataByr" => $dataByr,
        "tgl1"     => $tglByr1,
        "tgl2"     => $tglByr2
      );
      $this->load->view("t101_spp/t101_spp_tunggakan_tgl_xls", $data);
    }


    // cetak tunggakan ke layar
    public function tunggakan_tgl()
    {
      $q        = urldecode($this->input->post('q', TRUE));
      $tgl1     = "";
      $tgl2     = "";
      $t101_spp = 0;

      if ($q <> '') {
        $tglInput1 = substr($q, 0, 10);
        $tglInput2 = substr($q, 13, 10);
        $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
        $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
        //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
        $t101_spp = $this->T101_spp_model->get_data_tunggakan_tgl($tgl1, $tgl2);
        if ($t101_spp == 0) $q = "";
      }

      $data = array(
        "q"             => $q,
        't101_spp_data' => $t101_spp,
        "tgl1"          => $tgl1,
        "tgl2"          => $tgl2,
        "head"          => array("title" => "Laporan Tunggakan SPP"),
        "title"         => "Laporan Tunggakan SPP",
      );

      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->view("t101_spp/t101_spp_tunggakan_tgl", $data);
    }


    // tunggakan berdasarkan nis
    public function tunggakan_nis()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['per_page'] = 1000;
        $config['page_query_string'] = TRUE;

        $dataSiswa = 0;

        if ($q <> '') {
            $config['base_url'] = base_url() . 't101_spp/tunggakan_nis?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't101_spp/tunggakan_nis?q=' . urlencode($q);
            $config['total_rows'] = $this->T101_spp_model->total_rows_nis_tunggakan($q);
            $t101_spp = $this->T101_spp_model->get_limit_data_nis_tunggakan($config['per_page'], $start, $q);
            $dataSiswa = $this->T101_spp_model->getSiswa($q);
            if ($t101_spp == 0) $q = "";
        } else {
            $config['base_url'] = base_url() . 't101_spp';
            $config['first_url'] = base_url() . 't101_spp';
            $config['total_rows'] = $this->T101_spp_model->total_rows($q);
            $t101_spp = $this->T101_spp_model->get_limit_data($config['per_page'], $start, $q);
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            "dataSiswa" => $dataSiswa,
            't101_spp_data' => $t101_spp,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array(
              "title" => "Tunggakan SPP Siswa"),
            "title" => "Tunggakan SPP Siswa",
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t101_spp/t101_spp_tunggakan_nis', $data);
    }


    // ubah spp2
    function ubah_spp2() {
      // check login
      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $idkelas = $this->input->post("idkelas", true);

      // ambil dan periksa tahun Ajaran
      $tahunajaran = $this->session->userdata("tahunajaran");
      $tahunSekarang = date("Y");
      $bulanSekarang = date("m");
      if ($bulanSekarang >= 7 and $bulanSekarang <= 12) {
        // check data tahun ajaran substr(x, 0, 4)
        // contoh :: 2020/2021
        // yang dicheck :: 2020
        if (substr($tahunajaran, 0, 4) <> $tahunSekarang) {
          $this->session->set_flashdata('message', 'Mohon ubah Tahun Ajaran terlebih dahulu !');
        }
      }
      else {
        // check data tahun ajaran substr(x, 5, 4)
        // contoh :: 2020/2021
        // yang dicheck :: 2021
        if (substr($tahunajaran, 5, 4) <> $tahunSekarang) {
          $this->session->set_flashdata('message', 'Mohon ubah Tahun Ajaran terlebih dahulu !');
        }
      }

      // ambil kelas
      $this->load->model('T003_kelas_model');
      $dataKelas = $this->T003_kelas_model->get_all_in_siswa();

      // ambil bulan
      $bulanIndo = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'Nopember',
        '12' => 'Desember'
      );
      $awalTempo = substr($this->session->userdata("tahunajaran"), 0, 4) . "-07-01";
      for ($i = 0; $i < 12; $i++) {
        $jatuhTempo = date("Y-m-d", strtotime("+$i month", strtotime($awalTempo)));
        $aBulan[$i] = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));
      }

      // definisikan jenis
      $aJenis = array(
        "byrspp"       => "SPP",
        "byrcatering"  => "Catering",
        "byrworksheet" => "Worksheet"
      );

      $data = array(
        "tahunajaran" => $tahunajaran,
        "dataKelas"   => $dataKelas,
        "aBulan"      => $aBulan,
        "aJenis"      => $aJenis,
        "idkelas"     => set_value("idkelas", $idkelas),
        "head"        => array("title" => "Ubah SPP per Kelas"),
        "title"       => "Ubah SPP per Kelas",
      );
      $this->load->view("t101_spp/t101_spp_ubah_spp2", $data);
    }


    // ubah spp2 action
    function ubah_spp2_action() {
      $data = array(
        "idkelas" => $this->input->post("idkelas", true),
        'bulan'   => $this->input->post('bulan',TRUE),
        "jenis"   => $this->input->post("jenis", true),
        "nominal" => $this->input->post("nominal", true),
      );
      $this->T101_spp_model->update_ubah_spp2($data);
      redirect(site_url('t101_spp/ubah_spp2'));
    }


    // ubah spp
    function ubah_spp() {

      // check login
      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $idkelas = $this->input->post("idkelas", true);

      // ambil dan periksa tahun Ajaran
      $tahunajaran = $this->session->userdata("tahunajaran");
      $tahunSekarang = date("Y");
      $bulanSekarang = date("m");
      if ($bulanSekarang >= 7 and $bulanSekarang <= 12) {
        // check data tahun ajaran substr(x, 0, 4)
        // contoh :: 2020/2021
        // yang dicheck :: 2020
        if (substr($tahunajaran, 0, 4) <> $tahunSekarang) {
          $this->session->set_flashdata('message', 'Mohon ubah Tahun Ajaran terlebih dahulu !');
        }
      }
      else {
        // check data tahun ajaran substr(x, 5, 4)
        // contoh :: 2020/2021
        // yang dicheck :: 2021
        if (substr($tahunajaran, 5, 4) <> $tahunSekarang) {
          $this->session->set_flashdata('message', 'Mohon ubah Tahun Ajaran terlebih dahulu !');
        }
      }

      // ambil kelas
      $this->load->model('T003_kelas_model');
      $dataKelas = $this->T003_kelas_model->get_all();

      // ambil data spp berdasarkan Idkelas
      $dataSpp = 0;
      if ($idkelas <> "") {
        $dataSpp = $this->T101_spp_model->get_data_spp($idkelas);
        $this->session->unset_userdata("message");
        if (!$dataSpp) $this->session->set_flashdata("message", "Tidak ada data Pembayaran SPP");
      }

      $data = array(
        "tahunajaran" => $tahunajaran,
        "dataKelas"   => $dataKelas,
        "dataSpp"     => $dataSpp,
        "idkelas"     => set_value("idkelas", $idkelas),
        "head"        => array("title" => "Ubah Nominal SPP"),
        "title"       => "Ubah Nominal SPP",
      );
      $this->load->view("t101_spp/t101_spp_ubah_spp", $data);
    }


    // index
    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $q2 = urldecode($this->input->get('q2', TRUE));
        $start = intval($this->input->get('start'));

        $config['per_page'] = 10000000;
        $config['page_query_string'] = TRUE;

        $dataSiswa = 0;
        $t004_siswa = 0;

        if ($q <> '' or $q2 <> '') {
            $config['base_url'] = base_url() . 't101_spp?q=' . urlencode($q) . '&q2=' . urlencode($q2);
            $config['first_url'] = base_url() . 't101_spp?q=' . urlencode($q) . '&q2=' . urlencode($q2);
            $config['total_rows'] = $this->T101_spp_model->total_rows_nis($q);
            $t101_spp             = $this->T101_spp_model->get_limit_data_nis($config['per_page'], $start, $q);
            $dataSiswa            = $this->T101_spp_model->getSiswa($q);
            $t004_siswa = $this->T004_siswa_model->get_list_siswa($q, $q2);
            if ($t101_spp == 0)
            {
              $q = "";
            }
            if ($t004_siswa == 0)
            {
              $q2 = '';
            }
        } else {
            $config['base_url'] = base_url() . 't101_spp';
            $config['first_url'] = base_url() . 't101_spp';
            $config['total_rows'] = $this->T101_spp_model->total_rows($q);
            $t101_spp = $this->T101_spp_model->get_limit_data($config['per_page'], $start, $q);
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            "dataSiswa" => $dataSiswa,
            't101_spp_data' => $t101_spp,
            'q' => $q,
            'q2' => $q2,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array("title" => "Pembayaran SPP"),
            "title" => "Pembayaran SPP",
            't004_siswa_data' => $t004_siswa,
          );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t101_spp/t101_spp_list', $data);
    }


    // cetak bukti pembayaran
    public function cetak()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $q = urldecode($this->input->get('q', TRUE));
        $dataSiswa = $this->T101_spp_model->getSiswa($q);
        $idSpp = urldecode($this->input->get('idSpp', TRUE));
        $aSpp = $this->T101_spp_model->get_by_id($idSpp);
        $aSiswa = $this->T101_spp_model->getSiswa($q);
        $data = array(
          "aSpp" => $aSpp,
          "aSiswa" => $aSiswa
        );
        $this->load->view("t101_spp/t101_spp_invoice", $data);
    }


    // cetak laporan ke layar
    public function laporan()
    {
      $q        = urldecode($this->input->post('q', TRUE));
      $tgl1     = "";
      $tgl2     = "";
      $t101_spp = 0;

      if ($q <> '') {
        $tglInput1 = substr($q, 0, 10);
        $tglInput2 = substr($q, 13, 10);
        $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
        $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
        //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
        $t101_spp = $this->T101_spp_model->get_data_laporan($tgl1, $tgl2);
        if ($t101_spp == 0) $q = "";
      }

      $data = array(
        "q"             => $q,
        't101_spp_data' => $t101_spp,
        "tgl1"          => $tgl1,
        "tgl2"          => $tgl2,
        "head"          => array("title" => "Laporan Pembayaran SPP"),
        "title"         => "Laporan Pembayaran SPP",
      );

      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->view("t101_spp/t101_spp_laporan", $data);
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
      $dataByr = $this->T101_spp_model->get_data_laporan($tglByr1, $tglByr2);
      $data = array(
        "aDataByr" => $dataByr,
        "tgl1"     => $tglByr1,
        "tgl2"     => $tglByr2
      );
      $this->load->view("t101_spp/t101_spp_laporan_xls", $data);
    }


    // proses pembayaran spp
    public function bayar($idSpp, $q, $start)
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        //membuat nomor bayar
        $today = date("ymd");
        $data = $this->T101_spp_model->getMaxNoBayar($idSpp);
        $lastNoBayar = $data['last'];
        $lastNoUrut = substr($lastNoBayar, 6, 4);
        $nextNoUrut = $lastNoUrut + 1;
        $nextNoBayar = $today.sprintf('%04s', $nextNoUrut);

        //tanggal Bayar
        $tglBayar = date('Y-m-d');

        //id admin
        //$admin = $_SESSION['id'];
        $admin = $this->session->userdata("user_id");
        $this->T101_spp_model->bayar($nextNoBayar, $tglBayar, $admin, $idSpp);
        //mysqli_query($konek, "Update spp SET nobayar='$nextNoBayar',tglbayar='$tglBayar',ket='LUNAS',idadmin='$admin' WHERE idspp='$idspp'");
        redirect("t101_spp?q=".$q);
    }


    // read
    public function read($id)
    {
        $row = $this->T101_spp_model->get_by_id($id);
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
            $this->load->view('t101_spp/t101_spp_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp'));
        }
    }


    // create
    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('t101_spp/create_action'),
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
        $this->load->view('t101_spp/t101_spp_form', $data);
    }


    // create action
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
            $this->T101_spp_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t101_spp'));
        }
    }


    // update
    public function update($id, $q, $tahunajaran,$tahunajaran2)
    {
        $row = $this->T101_spp_model->get_by_id_object($id);
        $dataSiswa = $this->T101_spp_model->getSiswa_2($q, null, $id, $tahunajaran, $tahunajaran2);
        $row_bulan2 = $this->T101_spp_model->get_bulan2($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t101_spp/update_action'),
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
                "head" => array("title" => "Ubah SPP per Siswa"),
                "title" => "Ubah SPP per Siswa",
                'dataSiswa' => $dataSiswa,
                'q' => $q,
                'row_bulan2' => $row_bulan2,
            );
            $this->load->view('t101_spp/t101_spp_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp/ubah_spp_siswa'));
        }
    }


    // update action
    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idspp', TRUE), $this->input->post('q', TRUE));
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
            // $this->T101_spp_model->update($this->input->post('idspp', TRUE), $data);
            $this->T101_spp_model->update2($this->input->post('idspp', TRUE), $data, $this->input->post('bulan2'), true);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t101_spp/index?q='.$this->input->post('q', true)));
        }
    }


    // delete
    public function delete($id)
    {
        $row = $this->T101_spp_model->get_by_id($id);

        if ($row) {
            $this->T101_spp_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t101_spp'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp'));
        }
    }


    // rules
    public function _rules()
    {
      	// $this->form_validation->set_rules('idsiswa', 'idsiswa', 'trim|required');
      	// $this->form_validation->set_rules('jatuhtempo', 'jatuhtempo', 'trim|required');
      	// $this->form_validation->set_rules('bulan', 'bulan', 'trim|required');
      	// $this->form_validation->set_rules('nobayar', 'nobayar', 'trim|required');
      	// $this->form_validation->set_rules('tglbayar', 'tglbayar', 'trim|required');
      	$this->form_validation->set_rules('byrspp', 'byrspp', 'trim|required');
      	$this->form_validation->set_rules('byrcatering', 'byrcatering', 'trim|required');
      	$this->form_validation->set_rules('byrworksheet', 'byrworksheet', 'trim|required');
      	// $this->form_validation->set_rules('ket', 'ket', 'trim|required');
      	// $this->form_validation->set_rules('idadmin', 'idadmin', 'trim|required');

      	$this->form_validation->set_rules('idspp', 'idspp', 'trim');
      	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    // excel
    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t101_spp.xls";
        $judul = "t101_spp";
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

      	foreach ($this->T101_spp_model->get_all() as $data) {
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


    // word
    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t101_spp.doc");

        $data = array(
            't101_spp_data' => $this->T101_spp_model->get_all(),
            'start' => 0
        );

        $this->load->view('t101_spp/t101_spp_doc',$data);
    }

    // ubah spp per siswa
    function ubah_spp_siswa_lama()
    {
      $q = urldecode($this->input->get('q', TRUE));
      $q2 = urldecode($this->input->get('q2', TRUE));
      $start = intval($this->input->get('start'));

      $config['per_page'] = 10000000;
      $config['page_query_string'] = TRUE;

      $dataSiswa = 0;
      $t004_siswa = 0;

      if ($q <> '' or $q2 <> '') {
          $config['base_url'] = base_url() . 't101_spp/ubah_spp_siswa?q=' . urlencode($q) . '&q2=' . urlencode($q2);
          $config['first_url'] = base_url() . 't101_spp/ubah_spp_siswa?q=' . urlencode($q) . '&q2=' . urlencode($q2);
          $config['total_rows'] = $this->T101_spp_model->total_rows_nis($q);
          $t101_spp             = $this->T101_spp_model->get_limit_data_nis($config['per_page'], $start, $q);
          $dataSiswa            = $this->T101_spp_model->getSiswa($q);
          $t004_siswa = $this->T004_siswa_model->get_list_siswa($q, $q2);
          if ($t101_spp == 0)
          {
            $q = "";
          }
          if ($t004_siswa == 0)
          {
            $q2 = '';
          }
      } else {
          $config['base_url'] = base_url() . 't101_spp/ubah_spp_siswa';
          $config['first_url'] = base_url() . 't101_spp/ubah_spp_siswa';
          $config['total_rows'] = $this->T101_spp_model->total_rows($q);
          $t101_spp = $this->T101_spp_model->get_limit_data($config['per_page'], $start, $q);
      }

      $this->load->library('pagination');
      $this->pagination->initialize($config);

      $data = array(
          "dataSiswa" => $dataSiswa,
          't101_spp_data' => $t101_spp,
          'q' => $q,
          'q2' => $q2,
          'pagination' => $this->pagination->create_links(),
          'total_rows' => $config['total_rows'],
          'start' => $start,
          "head" => array("title" => "Ubah SPP per Siswa"),
          "title" => "Ubah SPP per Siswa",
          't004_siswa_data' => $t004_siswa,
        );

      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->view('t101_spp/t101_spp_list_2', $data);
    }

    public function ubah_spp_siswa()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 't101_spp/ubah_spp_siswa?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't101_spp/ubah_spp_siswa?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 't101_spp/ubah_spp_siswa';
            $config['first_url'] = base_url() . 't101_spp/ubah_spp_siswa';
        }

        $config['per_page'] = 10000000;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->T101_spp_model->total_rows_2($q);
        $t101_spp = $this->T101_spp_model->get_limit_data_2($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            't101_spp_data' => $t101_spp,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            "head" => array("title" => "Ubah SPP per Siswa"),
            "title" => "Ubah SPP per Siswa",
        );
        $this->load->view('t101_spp/t101_spp_list_3', $data);
    }

    // update versi 2
    public function update_2($idsiswa) // $id = idspp
    {
        $row = $this->T101_spp_model->get_by_idsiswa($idsiswa);
        $data_siswa = $this->T004_siswa_model->get_by_id($idsiswa); // echo pre($data_siswa);
        $row_bulan2 = $this->T101_spp_model->get_bulan_2($idsiswa);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('t101_spp/update_2_action'),
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
                "head" => array("title" => "Ubah SPP per Siswa"),
                "title" => "Ubah SPP per Siswa",
                'data_siswa' => $data_siswa,
                //'q' => $q,
                'row_bulan2' => $row_bulan2,
            );
            $this->load->view('t101_spp/t101_spp_form_2', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t101_spp/ubah_spp_siswa'));
        }
    }

    // update action versi 2
    public function update_2_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idspp', TRUE), $this->input->post('q', TRUE));
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
            // $this->T101_spp_model->update($this->input->post('idspp', TRUE), $data);
            $this->T101_spp_model->update2($data, $this->input->post('bulan2'), true);
            $this->session->set_flashdata('message', 'Update Record Success');
            // redirect(site_url('t101_spp/index?q='.$this->input->post('q', true)));
            redirect(site_url('t101_spp/ubah_spp_siswa'));
        }
    }

    public function tunggak_kelas()
    {
      $q        = urldecode($this->input->post('q', TRUE));
      $idkelas  = $this->input->post("idkelas", true);
      $tgl1     = "";
      $tgl2     = "";
      $t101_spp = 0;

      if ($q <> '') {
        $tglInput1 = substr($q, 0, 10);
        $tglInput2 = substr($q, 13, 10);
        $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
        $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
        //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
        $t101_spp = $this->T101_spp_model->get_data_tunggakan_kelas($tgl1, $tgl2, $idkelas);
        if ($t101_spp == 0) $q = "";
      }

      $data_kelas = $this->T003_kelas_model->get_all();
      $kelas = $this->T003_kelas_model->get_by_id($idkelas);
      $data = array(
        // "tahunajaran" => $tahunajaran,
        // "dataKelas"   => $dataKelas,
        // "aBulan"      => $aBulan,
        // "aJenis"      => $aJenis,
        // "idkelas"     => set_value("idkelas", $idkelas),
        "q"             => $q,
        't101_spp_data' => $t101_spp,
        "tgl1"          => $tgl1,
        "tgl2"          => $tgl2,
        "head"          => array("title" => "Tunggakan SPP per Kelas"),
        "title"         => "Tunggakan SPP per Kelas",
        'data_kelas'    => $data_kelas,
        'idkelas'       => $idkelas,
        'kelas'         => $kelas,
      );
      $this->load->view('t101_spp/t101_spp_tunggak_kelas', $data);
    }

    // cetak tunggakan kelas ke xls
    public function tunggak_kelas_xls()
    {
      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      // echo $this->input->post('tglBayar',TRUE);
      $tgl  = urldecode($this->input->get('tglBayar', TRUE));
      $idkelas  = urldecode($this->input->get("idkelas", true));
      $tgl1 = substr($tgl, 0, 10);
      $tgl2 = substr($tgl, 13, 10);
      $tglByr1 = substr($tgl1, 6, 4) . "-" . substr($tgl1, 0, 2) . "-" . substr($tgl1, 3, 2);
      $tglByr2 = substr($tgl2, 6, 4) . "-" . substr($tgl2, 0, 2) . "-" . substr($tgl2, 3, 2);
      $dataByr = $this->T101_spp_model->get_data_tunggakan_kelas($tglByr1, $tglByr2, $idkelas);
      $kelas = $this->T003_kelas_model->get_by_id($idkelas);
      $data = array(
        "aDataByr" => $dataByr,
        "tgl1"     => $tglByr1,
        "tgl2"     => $tglByr2,
        'kelas'    => $kelas,
      );
      $this->load->view("t101_spp/t101_spp_tgk_kls_xls", $data);
    }

}

/* End of file T101_spp.php */
/* Location: ./application/controllers/T101_spp.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-21 09:29:18 */
/* http://harviacode.com */
