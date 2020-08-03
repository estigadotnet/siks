<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T103_nonrutin_model extends CI_Model
{

    public $table = 't103_nonrutin';
    public $id = 'idnonrutin';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_all() {
      //$this->db->order_by($this->id, $this->order);
      $this->db->order_by("idsiswa", "asc");
      $this->db->order_by("idjenis", "asc");
      $this->db->order_by("idnonrutin", "asc");
      $r = $this->db->get($this->table)->result();
      $aAll = array();
      $lewat = 1;
      foreach ($r as $row) {
        //$aAll[$row->idsiswa] = array($row->idjenis => $row->sisa);
        $aAll[$row->idsiswa][$row->idjenis] = $row->sisa;
      }
      return $aAll;
    }

    // get all
    function get_all_backup()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('idnonrutin', $q);
      	$this->db->or_like('idsiswa', $q);
      	$this->db->or_like('nobayar', $q);
      	$this->db->or_like('tglbayar', $q);
      	$this->db->or_like('idjenis', $q);
      	$this->db->or_like('nominal', $q);
      	$this->db->or_like('bayar', $q);
      	$this->db->or_like('sisa', $q);
      	$this->db->or_like('idadmin', $q);
      	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idnonrutin', $q);
      	$this->db->or_like('idsiswa', $q);
      	$this->db->or_like('nobayar', $q);
      	$this->db->or_like('tglbayar', $q);
      	$this->db->or_like('idjenis', $q);
      	$this->db->or_like('nominal', $q);
      	$this->db->or_like('bayar', $q);
      	$this->db->or_like('sisa', $q);
      	$this->db->or_like('idadmin', $q);
      	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
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

    // get total rows nis
    function total_rows_nis($q = NULL)
    {
        $s = "select idsiswa from t004_siswa where nis = '".$q."'";
        $query = $this->db->query($s);
        if ($query->num_rows() == 0) {
          //echo $query->num_rows();
          return 0;
        }
        $query = $this->db->query($s)->result();
        $aIdsiswa = array();
        foreach ($query as $row ) {
          $aIdsiswa[] = $row->idsiswa;
        }
        //echo "<pre>"; print_r($aIdsiswa); echo "</pre>";
        $this->db->where_in("idsiswa", $aIdsiswa);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search berdasarkan nis
    function get_limit_data_nis($limit, $start = 0, $q = NULL)
    {
        $s = "select idsiswa from t004_siswa where nis = '".$q."'";
        $query = $this->db->query($s);
        if ($query->num_rows() == 0) {
          //echo $query->num_rows();
          return 0;
        }
        $query = $this->db->query($s)->result();
        $aIdsiswa = array();
        foreach ($query as $row) {
          $aIdsiswa[] = $row->idsiswa;
        }

        //$this->db->order_by("jatuhtempo", "asc");
        // $this->db->like('idspp', $q);
        $this->db->order_by("idsiswa, idjenis, idnonrutin");
        $this->db->limit($limit, $start);
        $this->db->where_in("idsiswa", $aIdsiswa);
        return $this->db->get($this->table)->result();
    }

    //
    function getSiswa($nis)
    {
        $q = $this->db->query("select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis = '".$nis."' and tahunajaran = '".$this->session->userdata("tahunajaran")."'");
        return $q->result_array();
    }

    // ambil data tahun ajaran siswa
    function getSiswaTA($q) {
      $s = "select idsiswa, tahunajaran, kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis = '".$q."'";
      $query = $this->db->query($s);
      if ($query->num_rows() == 0) {
        //echo $query->num_rows();
        return 0;
      }
      $query = $this->db->query($s)->result();
      $aIdsiswaTA = array();
      foreach ($query as $row) {
        $aIdsiswaTA[$row->idsiswa] = array($row->tahunajaran, $row->kelas);
      }

      return $aIdsiswaTA;
    }

    //
    function getMaxNoBayar()
    {
        $today = date("ymd");
        $q = $this->db->query("select max(nobayar) as last from t103_nonrutin where nobayar like '$today%'");
        return $q->row_array();
    }

    // get all data by id
    function getAllById($idNonRutin) {
      $s = "select * from t103_nonrutin where idnonrutin = ".$idNonRutin."";
      $r = $this->db->query($s)->row();
      $s = "select * from t103_nonrutin where idsiswa = ".$r->idsiswa." and idjenis = ".$r->idjenis." order by idnonrutin";
      return $this->db->query($s)->result();
    }

    // hitung sisa
    function hitungSisa($idSiswa, $idJenis) {
      $nominal = 0;
      $bayar   = 0;
      $sisa    = 0;
      $s = "select * from t103_nonrutin where idsiswa = ".$idSiswa." and idjenis = ".$idJenis." order by idnonrutin";
      $rs = $this->db->query($s)->result();
      foreach ($rs as $r) {
        // code...
        $sisa += $r->nominal - $r->bayar;
        $s = "update t103_nonrutin set sisa = ".$sisa." where idnonrutin = ".$r->idnonrutin."";
        $this->db->query($s);
      }
    }

    //
    function get_data_laporan($tgl1, $tgl2)
    {
      // $sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
      $s = "select a.*, nis, namasiswa, kelas, jenis from t103_nonrutin a
        inner join t004_siswa b on a.idsiswa = b.idsiswa
        left join t003_kelas c on b.idkelas = c.idkelas
        left join t005_nonrutin d on a.idjenis = d.id
        where tglbayar between '$tgl1' AND '$tgl2' order by nobayar asc"; //echo $s;
      return $this->db->query($s)->result_array();
    }

}

/* End of file T103_nonrutin_model.php */
/* Location: ./application/models/T103_nonrutin_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-29 01:40:20 */
/* http://harviacode.com */
