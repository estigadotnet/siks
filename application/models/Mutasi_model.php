<?php
if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Mutasi_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  function get_data_laporan($tgl1, $tgl2) {

    $tahunajaran    = $this->session->userdata("tahunajaran");
    $tglawalperiode = substr($tahunajaran, 0, 4)."-07-01";
    $saldoawal      = 0;
    $tglsaldoawal   = date("Y-m-d", strtotime("-1 day", strtotime($tgl1)));

    // ambil saldo awal sesuai tahun ajaran
    $q = "select saldoawal from t001_tahunajaran where tahunajaran = '".$tahunajaran."'";
    $r = $this->db->query($q)->row();
    $saldoawal = $r->saldoawal;

    // ambil pembayaran sebelum tgl1
    $q = "select sum(byrspp) as totalspp from t101_spp where tglbayar >= '".$tglawalperiode."' and tglbayar < '".$tgl1."'";
    $r = $this->db->query($q)->row();
    $saldoawal += $r->totalspp;

    // ambil pembayaran non-rutin sebelum tgl1
    $q = "select sum(bayar) as totalnonrutin from t103_nonrutin where tglbayar >= '".$tglawalperiode."' and tglbayar < '".$tgl1."'";
    $r = $this->db->query($q)->row();
    $saldoawal += $r->totalnonrutin;

    // ambil pengeluaran sebelum tgl1
    $q = "select sum(jumlah) as totalbelanja from t102_pengeluaran where tgl >= '".$tglawalperiode."' and tgl < '".$tgl1."'";
    $r = $this->db->query($q)->row();
    $saldoawal -= $r->totalbelanja;

    // ambil transaksi pembayaran
    //$q = "select tglbayar, concat('No. Bayar: ',nobayar), byrspp, 0, 0 from t101_spp where tglbayar between '".$tgl1."' and '".$tgl2."'";

    $q = "
      select * from (
      select '".$tglsaldoawal."' as tgl, 'Saldo' as keterangan, ".$saldoawal." as debet, 0 as kredit, ".$saldoawal." as saldo
      union
      select tglbayar, concat('No. Bayar SPP: ',nobayar), byrspp, 0, 0 from t101_spp where tglbayar between '".$tgl1."' and '".$tgl2."'
      union
      select tglbayar, concat('No. Bayar Non-Rutin: ',nobayar), bayar, 0, 0 from t103_nonrutin where tglbayar between '".$tgl1."' and '".$tgl2."'
      union
      select tgl, concat('No. Bukti Pengeluaran: ', nobuk), 0, jumlah, 0 from t102_pengeluaran where tgl between '".$tgl1."' and '".$tgl2."'
      ) a
      order by tgl
    ";
    $r = $this->db->query($q)->result_array();

    return $r;
  }

}
