<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T004_siswa_model extends CI_Model
{

    public $table = 't004_siswa';
    public $id = 'idsiswa'; public $orderBy = "idkelas, namasiswa";
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        // $this->db->order_by($this->id, $this->order);
        $this->db->order_by($this->orderBy, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        // $this->db->where("tahunajaran", $this->session->userdata("tahunajaran"));
        $this->db->where($this->id, $id);
        //return $this->db->get($this->table)->row();
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('idsiswa', $q);
      	$this->db->or_like('nis', $q);
      	$this->db->or_like('namasiswa', $q);
      	$this->db->or_like('t004_siswa.idkelas', $q);
      	$this->db->or_like('tahunajaran', $q);
      	$this->db->or_like('byrspp', $q);
      	$this->db->or_like('byrcatering', $q);
      	$this->db->or_like('byrworksheet', $q);
        $this->db->or_like('kelas', $q);
      	// $this->db->from($this->table);
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idsiswa', $q);
      	$this->db->or_like('nis', $q);
      	$this->db->or_like('namasiswa', $q);
      	$this->db->or_like('t004_siswa.idkelas', $q);
      	$this->db->or_like('tahunajaran', $q);
      	$this->db->or_like('byrspp', $q);
      	$this->db->or_like('byrcatering', $q);
      	$this->db->or_like('byrworksheet', $q);
        $this->db->or_like('kelas', $q);
      	$this->db->limit($limit, $start);
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        //return $this->db->get($this->table)->result();
        return $this->db->get()->result();
    }

    // insert data
    //function insert($data)
    function insert($allArray)
    {
        $data = $allArray["data"];
        $this->db->insert($this->table, $data);
        $idSiswa = $this->db->insert_id();

        // simpan 12 record ke tabel t101_spp
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
          $bulan = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));
          $dataSpp = array(
            "idsiswa"      => $idSiswa,
            "jatuhtempo"   => $jatuhTempo,
            "bulan"        => $bulan,
            "byrspp"       => $data["byrspp"],
            "byrcatering"  => $data["byrcatering"],
            "byrworksheet" => $data["byrworksheet"]
          );
          $this->db->insert("t101_spp", $dataSpp);
        }

        // simpan ke tabel non rutin transaksi
        foreach ($allArray["dataNonRutin"] as $r) {
          // code...
          $dataInsert = array(
            "idsiswa"  => $idSiswa,
            "nobayar"  => "",
            "tglbayar" => "0000-00-00",
            "idjenis"  => $r->id,
            "nominal"  => $allArray["dataInputNonRutin"]["nominal".$r->id],
            "bayar"    => 0,
            "sisa"     => $allArray["dataInputNonRutin"]["nominal".$r->id],
            "idadmin"  => 0
          );
          $this->db->insert("t103_nonrutin", $dataInsert);
        }
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // ambil data kelas untuk combo
    function getKelas() {
      return $this->db->query("select * from t003_kelas order by idkelas")->result();
    }

    // tentukan NIS terbaru
    function getNewNIS() {
      // cari nis terakhir
      $kodeSekolah = $this->session->userdata("kodesekolah");
      $s = "select nis from t004_siswa where left(nis,2) = '".$kodeSekolah."'
        and mid(nis,3,2) = '".substr($this->session->userdata("tahunajaran"),2,2)."' order by nis desc"; //echo $s;
      $q = $this->db->query($s);
      $jumRec = $q->num_rows();
      if ($jumRec > 0) {
        // sudah ada data
        $data = $q->row_array();
        $lastNis = $data["nis"];
        $lastNoUrut = substr($lastNis, 4, 4);
        $nextNoUrut = $lastNoUrut + 1;
        $nextNis = $kodeSekolah . substr($this->session->userdata("tahunajaran"),2,2) . sprintf('%04s', $nextNoUrut);
      }
      else {
        // belum ada data
        $nextNis = $kodeSekolah . substr($this->session->userdata("tahunajaran"),2,2) . "0001";
      }
      return $nextNis;
    }

    // get total rows
    function total_rows_where($q = NULL) {
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        $this->db->where("tahunajaran", $this->session->userdata("tahunajaran"));
        return $this->db->count_all_results();
    }

    // get total rows by idkelas
    function total_rows_idkelas($q = NULL) {
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        $this->db->where("t004_siswa.idkelas", $q);
        $this->db->where("tahunajaran", $this->session->userdata("tahunajaran"));
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_where($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
      	$this->db->limit($limit, $start);
        // tambahan
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        $this->db->where("tahunajaran", $this->session->userdata("tahunajaran"));
        return $this->db->get()->result();
    }

    // get data with idkelas
    function get_limit_data_idkelas($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
      	$this->db->limit($limit, $start);
        // tambahan
        $this->db->select("idsiswa, nis, namasiswa, t004_siswa.idkelas, tahunajaran, byrspp, byrcatering, byrworksheet, kelas");
        $this->db->from("t004_siswa");
        $this->db->join("t003_kelas", "t004_siswa.idkelas = t003_kelas.idkelas");
        $this->db->where("t004_siswa.idkelas", $q);
        $this->db->where("tahunajaran", $this->session->userdata("tahunajaran"));
        return $this->db->get()->result();
    }

    // insert data proses naik kelas
    function naikkelas($allArray) {

      $data = $allArray["data"];
      // $this->db->insert($this->table, $data);
      // $idSiswa = $this->db->insert_id();

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
      $idkelasBaru     = $data["idkelasBaru"];
      $tahunajaranBaru = $data["tahunajaranBaru"];
      $spp             = $data["spp"];
      $catering        = $data["catering"];
      $worksheet       = $data["worksheet"];
      $awalTempo       = $data["awalTempo"];
      $s = "
  			select
  				nis, namasiswa
  			from
  				t004_siswa
  			where
  				tahunajaran = '".$data["tahunajaranLama"]."'
  				and idkelas = '".$data["idkelasLama"]."'
  			order by
  				idkelas ASC";
			$q = $this->db->query($s)->result(); //mysqli_query($konek, $s);
      foreach ($q as $r) {
        $data = array(
          'nis' => $r->nis,
          'namasiswa' => $r->namasiswa,
          'idkelas' => $idkelasBaru,
          'tahunajaran' => $tahunajaranBaru,
          'byrspp' => $spp,
          'byrcatering' => $catering,
          'byrworksheet' => $worksheet,
        );

        $this->db->insert($this->table, $data);

        // simpan 12 record ke tabel t101_spp
        $idSiswa = $this->db->insert_id();
        $awalTempo = substr($tahunajaranBaru, 0, 4) . "-07-01";
        for ($i = 0; $i < 12; $i++) {
          $jatuhTempo = date("Y-m-d", strtotime("+$i month", strtotime($awalTempo)));
          $bulan = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));
          $dataSpp = array(
            "idsiswa"      => $idSiswa,
            "jatuhtempo"   => $jatuhTempo,
            "bulan"        => $bulan,
            "byrspp"       => $spp,
            "byrcatering"  => $catering,
            "byrworksheet" => $worksheet
          );
          $this->db->insert("t101_spp", $dataSpp);
        }

        // simpan ke tabel non-rutin transaksi
        // simpan ke tabel non rutin transaksi
        foreach ($allArray["dataNonRutin"] as $r) {
          // code...
          $dataInsert = array(
            "idsiswa"  => $idSiswa,
            "nobayar"  => "",
            "tglbayar" => "0000-00-00",
            "idjenis"  => $r->id,
            "nominal"  => $allArray["dataInputNonRutin"]["nominal".$r->id],
            "bayar"    => 0,
            "sisa"     => $allArray["dataInputNonRutin"]["nominal".$r->id],
            "idadmin"  => 0
          );
          $this->db->insert("t103_nonrutin", $dataInsert);
        }

      }

    }

    // insert data proses naik kelas
    function insert_naikkelas($data, $tahunajaranBaru)
    {
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
        $this->db->insert($this->table, $data);
        // simpan 12 record ke tabel t101_spp
        $idSiswa = $this->db->insert_id();
        $awalTempo = substr($tahunajaranBaru, 0, 4) . "-07-01";
        for ($i = 0; $i < 12; $i++) {
          $jatuhTempo = date("Y-m-d", strtotime("+$i month", strtotime($awalTempo)));
          $bulan = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));
          $dataSpp = array(
            "idsiswa"      => $idSiswa,
            "jatuhtempo"   => $jatuhTempo,
            "bulan"        => $bulan,
            "byrspp"       => $data["byrspp"],
            "byrcatering"  => $data["byrcatering"],
            "byrworksheet" => $data["byrworksheet"]
          );
          $this->db->insert("t101_spp", $dataSpp);
        }
    }

    // get data non rutin by idsiswa
    function get_NonRutin_by_id($id) {
      $s = "
        select
          a.idsiswa,
          b.idjenis,
          c.id,
          c.jenis,
          b.sisa,
          min(b.sisa) as sisaterakhir
        from
          t004_siswa a
          left join t103_nonrutin b on a.idsiswa = b.idsiswa
          left join t005_nonrutin c on b.idjenis = c.id
        where
          a.idsiswa = ".$id."
        group by
          b.idjenis
        ";
      return $this->db->query($s)->result();
    }

    // get data non rutin all
    function getNonRutinAll() {
      $s = "select id, jenis from t005_nonrutin order by id";
      return $this->db->query($s)->result();
    }

    // get data siswa by nis
    function getAllByNis($nis) {
      $s = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis = '".$nis."'";
      return $this->db->query($s)->result();
    }

    // get list siswa untuk list di pembayaran spp
    function get_list_siswa($nis = NULL, $namasiswa = NULL)
    {
      // $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where (nis like '%".$nis."%' or namasiswa like '%".$namasiswa."%') and tahunajaran = '".$this->session->userdata("tahunajaran")."'";
      if ($nis <> '')
      {
        $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis like '%".$nis."%'";
      }
      else if ($namasiswa <> '')
      {
        $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where namasiswa like '%".$namasiswa."%'";
      }
      else
      {
        $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis = '99999999'";
      }

      // echo $q; exit;
      return $this->db->query($q)->result();
    }

}

/* End of file T004_siswa_model.php */
/* Location: ./application/models/T004_siswa_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-19 11:27:20 */
/* http://harviacode.com */
