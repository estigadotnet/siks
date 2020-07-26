<?php
if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Mutasi extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model("Mutasi_model");
  }

  // cetak laporan ke layar
  public function laporan()
  {
    $q        = urldecode($this->input->post('q', TRUE));
    $tgl1     = "";
    $tgl2     = "";
    $mutasi   = 0;

    if ($q <> '') {
      $tglInput1 = substr($q, 0, 10);
      $tglInput2 = substr($q, 13, 10);
      $tgl1 = substr($tglInput1, 6, 4) . "-" . substr($tglInput1, 0, 2) . "-" . substr($tglInput1, 3, 2);
      $tgl2 = substr($tglInput2, 6, 4) . "-" . substr($tglInput2, 0, 2) . "-" . substr($tglInput2, 3, 2);
      //$dataByr = $this->T101_spp_model->get_data_bayar($tglByr1, $tglByr2);
      $mutasi = $this->Mutasi_model->get_data_laporan($tgl1, $tgl2);
      if ($mutasi == 0) $q = "";
    }

    $data = array(
      "q"           => $q,
      "mutasi_data" => $mutasi,
      "tgl1"        => $tgl1,
      "tgl2"        => $tgl2,
      "head"        => array("title" => "Laporan Mutasi Rekening Bank"),
      "title"       => "Laporan Mutasi Rekening Bank",
    );

    if (!$this->ion_auth->logged_in()) {
        redirect('/auth', 'refresh');
    }

    $this->load->view("mutasi/mutasi_laporan", $data);
  }
}
