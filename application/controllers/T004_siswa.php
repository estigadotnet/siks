<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T004_siswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('T004_siswa_model');
        $this->load->library('form_validation');
        $this->load->model("T005_nonrutin_model");
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $idkelas = urldecode($this->input->get('idkelas', TRUE));

        $config['per_page'] = 1000000;
        $config['page_query_string'] = TRUE;
        // $config['total_rows'] = $this->T004_siswa_model->total_rows($q);

        $kelas = "";
        $jumRec = 0;

        if ($q <> '') {
            $config['base_url'] = base_url() . 't004_siswa?q=' . urlencode($q);
            $config['first_url'] = base_url() . 't004_siswa?q=' . urlencode($q);
            $config['total_rows'] = $this->T004_siswa_model->total_rows($q);
            $t004_siswa = $this->T004_siswa_model->get_limit_data($config['per_page'], $start, $q);
        } elseif ($idkelas <> '') {
            $config['base_url'] = base_url() . 't004_siswa?idkelas=' . urlencode($idkelas);
            $config['first_url'] = base_url() . 't004_siswa?idkelas=' . urlencode($idkelas);
            $config['total_rows'] = $this->T004_siswa_model->total_rows_idkelas($idkelas);
            $t004_siswa = $this->T004_siswa_model->get_limit_data_idkelas($config['per_page'], $start, $idkelas);
            $kelas = ($t004_siswa ? "Kelas " . $t004_siswa[0]->kelas : "");
            $jumRec = $config["total_rows"];
        } else {
            $config['base_url'] = base_url() . 't004_siswa';
            $config['first_url'] = base_url() . 't004_siswa';
            $config['total_rows'] = $this->T004_siswa_model->total_rows_where($q);
            $t004_siswa = $this->T004_siswa_model->get_limit_data_where($config['per_page'], $start, $q);
        }

        // $config['per_page'] = 10;
        // $config['page_query_string'] = TRUE;
        // $config['total_rows'] = $this->T004_siswa_model->total_rows($q);
        // $t004_siswa = $this->T004_siswa_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $this->load->model("T005_nonrutin_model");
        $nonRutinData = $this->T005_nonrutin_model->get_all();
        $this->load->model("T103_nonrutin_model");
        $nonRutinTrans = $this->T103_nonrutin_model->get_all(); //echo "<pre>"; print_r($nonRutinTrans); echo "</pre>";

        $data = array(
            't004_siswa_data' => $t004_siswa,
            'q'               => $q,
            "idkelas"         => $idkelas,
            'pagination'      => $this->pagination->create_links(),
            'total_rows'      => $config['total_rows'],
            'start'           => $start,
            "head"            => array("title" => "Siswa"),
            "title"           => "Siswa",
            "kelas"           => $kelas,
            "jumRec"          => $jumRec,
            "nonRutinData"    => $nonRutinData,
            "nonRutinTrans"   => $nonRutinTrans
        );

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }

        $this->load->view('t004_siswa/t004_siswa_list', $data);
    }

    public function read($id)
    {
        $dataNonRutin = 0;
        $row = $this->T004_siswa_model->get_by_id($id);
        $dataNonRutin = $this->T004_siswa_model->get_nonRutin_by_id($id);
        if ($row) {
            $data = array(
            		'idsiswa'      => $row->idsiswa,
            		'nis'          => $row->nis,
            		'namasiswa'    => $row->namasiswa,
            		'idkelas'      => $row->idkelas,
            		'tahunajaran'  => $row->tahunajaran,
            		'byrspp'       => $row->byrspp,
            		'byrcatering'  => $row->byrcatering,
            		'byrworksheet' => $row->byrworksheet,
                "head"         => array("title" => "Siswa"),
                "title"        => "Siswa",
                "kelas"        => $row->kelas,
                "dataNonRutin" => $dataNonRutin
            );
            $this->load->view('t004_siswa/t004_siswa_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t004_siswa'));
        }
    }

    public function create()
    {
        $dataNonRutin = $this->T004_siswa_model->getNonRutinAll();
        $data = array(
            'button'       => 'Create',
            'action'       => site_url('t004_siswa/create_action'),
      	    'idsiswa'      => set_value('idsiswa'),
      	    'nis'          => set_value('nis', $this->T004_siswa_model->getNewNIS()),
      	    'namasiswa'    => set_value('namasiswa'),
      	    'idkelas'      => set_value('idkelas'),
      	    'tahunajaran'  => set_value("tahunajaran", $this->session->userdata("tahunajaran")),
      	    'byrspp'       => set_value('byrspp'),
      	    'byrcatering'  => set_value('byrcatering'),
      	    'byrworksheet' => set_value('byrworksheet'),
            "head"         => array("title" => "Siswa"),
            "title"        => "Siswa",
            "dataKelas"    => $this->T004_siswa_model->getKelas(),
            "dataNonRutin" => $dataNonRutin,
            "readOnly"     => ""
      	);
        foreach ($dataNonRutin as $r) {
          // code menambahkan array data non rutin untuk form create dan update
          //array_push($data, "nominal".$r->id => set_value("nominal".$r->id));
          $data["nominal".$r->id] = set_value("nominal".$r->id);
        } //echo "<pre>"; print_r($data); echo "</pre>";
        $this->load->view('t004_siswa/t004_siswa_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            		'nis' => $this->input->post('nis',TRUE),
            		'namasiswa' => $this->input->post('namasiswa',TRUE),
            		'idkelas' => $this->input->post('idkelas',TRUE),
            		'tahunajaran' => $this->input->post('tahunajaran',TRUE),
            		'byrspp' => $this->input->post('byrspp',TRUE),
            		'byrcatering' => $this->input->post('byrcatering',TRUE),
            		'byrworksheet' => $this->input->post('byrworksheet',TRUE),
            );
            $dataInputNonRutin = array();
            $dataNonRutin = $this->T004_siswa_model->getNonRutinAll();
            foreach ($dataNonRutin as $r) {
              $dataInputNonRutin["nominal".$r->id] = $this->input->post("nominal".$r->id, true);
            }
            //$data["dataNonRutin"] = $dataNonRutin;
            $allArray = array(
              "data"              => $data,
              "dataNonRutin"      => $dataNonRutin,
              "dataInputNonRutin" => $dataInputNonRutin
            );

            //$this->T004_siswa_model->insert($data);
            $this->T004_siswa_model->insert($allArray);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('t004_siswa'));
        }
    }

    public function update($id)
    {
        $row = $this->T004_siswa_model->get_by_id($id);
        $dataNonRutin = $this->T004_siswa_model->get_nonRutin_by_id($id);
        // cek jumlah record data non-rutin setup
        $this->load->model("T005_nonrutin_model");
        $dataNonRutinSetup = $this->T005_nonrutin_model->get_all();
        $readOnly = "readonly";

        if ($row) {
            $data = array(
                'button'       => 'Update',
                'action'       => site_url('t004_siswa/update_action'),
            		'idsiswa'      => set_value('idsiswa', $row->idsiswa),
            		'nis'          => set_value('nis', $row->nis),
            		'namasiswa'    => set_value('namasiswa', $row->namasiswa),
            		'idkelas'      => set_value('idkelas', $row->idkelas),
            		'tahunajaran'  => set_value('tahunajaran', $row->tahunajaran),
            		'byrspp'       => set_value('byrspp', $row->byrspp),
            		'byrcatering'  => set_value('byrcatering', $row->byrcatering),
            		'byrworksheet' => set_value('byrworksheet', $row->byrworksheet),
                "head"         => array("title" => "Siswa"),
                "title"        => "Siswa",
                "dataKelas"    => $this->T004_siswa_model->getKelas(),
                "dataNonRutin" => $dataNonRutin,
                "readOnly"     => $readOnly
            );
            foreach ($dataNonRutin as $r) {
              $data["nominal".$r->id] = set_value("nominal".$r->id, $r->sisaterakhir);
            } //echo "<pre>"; print_r($data); echo "</pre>";
            // $this->load->view('t004_siswa/t004_siswa_form', $data);
            $this->load->view('t004_siswa/t004_siswa_form_update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t004_siswa'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('idsiswa', TRUE));
        } else {
            $data = array(
            		'nis' => $this->input->post('nis',TRUE),
            		'namasiswa' => $this->input->post('namasiswa',TRUE),
            		'idkelas' => $this->input->post('idkelas',TRUE),
            		'tahunajaran' => $this->input->post('tahunajaran',TRUE),
            		'byrspp' => $this->input->post('byrspp',TRUE),
            		'byrcatering' => $this->input->post('byrcatering',TRUE),
            		'byrworksheet' => $this->input->post('byrworksheet',TRUE),
            );

            $this->T004_siswa_model->update($this->input->post('idsiswa', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('t004_siswa'));
        }
    }

    public function delete($id)
    {
        $row = $this->T004_siswa_model->get_by_id($id);

        if ($row) {
            $this->T004_siswa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('t004_siswa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('t004_siswa'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nis', 'nis', 'trim|required');
        $this->form_validation->set_rules('namasiswa', 'namasiswa', 'trim|required');
        $this->form_validation->set_rules('idkelas', 'idkelas', 'trim|required');
        $this->form_validation->set_rules('tahunajaran', 'tahunajaran', 'trim|required');
        $this->form_validation->set_rules('byrspp', 'byrspp', 'trim|required');
        $this->form_validation->set_rules('byrcatering', 'byrcatering', 'trim|required');
        $this->form_validation->set_rules('byrworksheet', 'byrworksheet', 'trim|required');

        $this->form_validation->set_rules('idsiswa', 'idsiswa', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "t004_siswa.xls";
        $judul = "t004_siswa";
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
      	xlsWriteLabel($tablehead, $kolomhead++, "Nis");
      	xlsWriteLabel($tablehead, $kolomhead++, "Namasiswa");
      	xlsWriteLabel($tablehead, $kolomhead++, "Idkelas");
      	xlsWriteLabel($tablehead, $kolomhead++, "Tahunajaran");
      	xlsWriteLabel($tablehead, $kolomhead++, "Byrspp");
      	xlsWriteLabel($tablehead, $kolomhead++, "Byrcatering");
      	xlsWriteLabel($tablehead, $kolomhead++, "Byrworksheet");

      	foreach ($this->T004_siswa_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->nis);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->namasiswa);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->idkelas);
      	    xlsWriteLabel($tablebody, $kolombody++, $data->tahunajaran);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->byrspp);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->byrcatering);
      	    xlsWriteNumber($tablebody, $kolombody++, $data->byrworksheet);

      	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=t004_siswa.doc");

        $data = array(
            't004_siswa_data' => $this->T004_siswa_model->get_all(),
            'start' => 0
        );

        $this->load->view('t004_siswa/t004_siswa_doc',$data);
    }

    //
    public function naikkelas() {
      if (!$this->ion_auth->logged_in()) {
          redirect('/auth', 'refresh');
      }

      $this->load->model("T003_kelas_model");

      $idkelas = urldecode($this->input->get('idkelas', TRUE));
      $idkelasLama = $idkelas;
      $rskelas = $this->T003_kelas_model->get_by_id($idkelas);
      $kelasLama = $rskelas->kelas; //echo $kelasLama;

      $dataKelas = $this->T003_kelas_model->get_all();

      $this->load->model("T001_tahunajaran_model");
      $dataTahunajaran = $this->T001_tahunajaran_model->get_all();

      // $data = array(
      //     'button' => 'Create',
      //     'action' => site_url('t004_siswa/create_action'),
      //     'idsiswa' => set_value('idsiswa'),
      //     'nis' => set_value('nis', $this->T004_siswa_model->getNewNIS()),
      //     'namasiswa' => set_value('namasiswa'),
      //     'idkelas' => set_value('idkelas'),
      //     'tahunajaran' => set_value("tahunajaran", $this->session->userdata("tahunajaran")),
      //     'byrspp' => set_value('byrspp'),
      //     'byrcatering' => set_value('byrcatering'),
      //     'byrworksheet' => set_value('byrworksheet'),
      //     "head" => array(
      //       "title" => "Siswa"),
      //     "title" => "Siswa",
      //     "dataKelas" => $this->T004_siswa_model->getKelas(),
      // );

      //$dataNonRutin = $this->T005_nonrutin_model->get_all();
      $dataNonRutin = $this->T004_siswa_model->getNonRutinAll();

      $data = array(
        'action'          => site_url('t004_siswa/naikkelas_action'),
        "idkelasLama"     => $idkelasLama,
        "kelasLama"       => $kelasLama,
        "dataKelas"       => $dataKelas,
        "dataTahunajaran" => $dataTahunajaran,
        "head"            => array("title" => "Naik Kelas"),
        "title"           => "Naik Kelas",
        "dataNonRutin"    => $dataNonRutin,
        "readOnly"     => ""
      );
      foreach ($dataNonRutin as $r) {
        // code menambahkan array data non rutin untuk form create dan update
        //array_push($data, "nominal".$r->id => set_value("nominal".$r->id));
        $data["nominal".$r->id] = set_value("nominal".$r->id);
      } //echo "<pre>"; print_r($data); echo "</pre>";

      $this->load->view('t004_siswa/t004_siswa_naikkelas', $data);
    }

    //
    public function naikkelas_action() {
      $data = array(
        "idkelasLama"     => $this->input->post("idkelasLama", true),
        "tahunajaranLama" => $this->input->post("tahunajaranLama", true),
        "idkelasBaru"     => $this->input->post("idkelasBaru", true),
        "tahunajaranBaru" => $this->input->post("tahunajaranBaru", true),
        "spp"             => $this->input->post("spp", true),
  			"catering"        => $this->input->post("catering", true),
  			"worksheet"       => $this->input->post("worksheet", true),
  			"awalTempo"       => substr($this->input->post("tahunajaranBaru", true), 0, 4)."-07-01"
      );

      $dataInputNonRutin = array();
      $dataNonRutin = $this->T004_siswa_model->getNonRutinAll();
      foreach ($dataNonRutin as $r) {
        $dataInputNonRutin["nominal".$r->id] = $this->input->post("nominal".$r->id, true);
      }
      //$data["dataNonRutin"] = $dataNonRutin;
      $allArray = array(
        "data"              => $data,
        "dataNonRutin"      => $dataNonRutin,
        "dataInputNonRutin" => $dataInputNonRutin
      );

      //$this->T004_siswa_model->insert($data);
      //$this->T004_siswa_model->insert($allArray);

      //$this->T004_siswa_model->naikkelas($data);
      $this->T004_siswa_model->naikkelas($allArray);
      redirect(site_url('t004_siswa'));
    }

}

/* End of file T004_siswa.php */
/* Location: ./application/controllers/T004_siswa.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-19 11:27:20 */
/* http://harviacode.com */
