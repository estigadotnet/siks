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

}

/* End of file T103_nonrutin_model.php */
/* Location: ./application/models/T103_nonrutin_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-29 01:40:20 */
/* http://harviacode.com */
