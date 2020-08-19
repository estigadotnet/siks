<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T101_spp_model extends CI_Model
{

    public $table = 't101_spp';
    public $id = 'idspp';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row_array();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('idspp', $q);
      	$this->db->or_like('idsiswa', $q);
      	$this->db->or_like('jatuhtempo', $q);
      	$this->db->or_like('bulan', $q);
      	$this->db->or_like('nobayar', $q);
      	$this->db->or_like('tglbayar', $q);
      	$this->db->or_like('byrspp', $q);
      	$this->db->or_like('byrcatering', $q);
      	$this->db->or_like('byrworksheet', $q);
      	$this->db->or_like('ket', $q);
      	$this->db->or_like('idadmin', $q);
      	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idspp', $q);
      	$this->db->or_like('idsiswa', $q);
      	$this->db->or_like('jatuhtempo', $q);
      	$this->db->or_like('bulan', $q);
      	$this->db->or_like('nobayar', $q);
      	$this->db->or_like('tglbayar', $q);
      	$this->db->or_like('byrspp', $q);
      	$this->db->or_like('byrcatering', $q);
      	$this->db->or_like('byrworksheet', $q);
      	$this->db->or_like('ket', $q);
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

    //
    function getSiswa($nis = NULL)
    {
        $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where nis = '".$nis."'  and tahunajaran = '".$this->session->userdata("tahunajaran")."'";
        // $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where (nis = '".$nis."' or namasiswa = '".$namasiswa."') and idsiswa = '".$idsiswa."' and tahunajaran = '".$tahunajaran."/".$tahunajaran2."'";
        // echo $q; exit;
        $r = $this->db->query($q);
        return $r->result_array();
    }

    //
    function getSiswa_2($nis = NULL, $namasiswa = NULL, $idsiswa = NULL, $tahunajaran = NULL, $tahunajaran2 = NULL)
    {
        // $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where (nis = '".$nis."' or namasiswa = '".$namasiswa."') and idsiswa = '".$idsiswa."' and tahunajaran = '".$this->session->userdata("tahunajaran")."'";
        $q = "select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where (nis = '".$nis."' or namasiswa = '".$namasiswa."') and idsiswa = '".$idsiswa."' and tahunajaran = '".$tahunajaran."/".$tahunajaran2."'";
        // echo $q; exit;
        $r = $this->db->query($q);
        return $r->result_array();
    }

    //
    function getSiswaById($idSiswa)
    {
        $q = $this->db->query("select a.*, b.kelas from t004_siswa a left join t003_kelas b on a.idkelas = b.idkelas where idsiswa = '".$idSiswa."' and tahunajaran = '".$this->session->userdata("tahunajaran")."'");
        return $q->row();
    }

    //
    function getMaxNoBayar($idSpp)
    {
        $today = date("ymd");
        $q = $this->db->query("select max(nobayar) as last from t101_spp where nobayar like '$today%'");
        return $q->row_array();
    }

    //
    function bayar($nextNoBayar, $tglBayar, $admin, $idSpp)
    {
        //mysqli_query($konek, "Update spp SET nobayar='$nextNoBayar',tglbayar='$tglBayar',ket='LUNAS',idadmin='$admin' WHERE idspp='$idspp'");
        $s = "update t101_spp set nobayar = '$nextNoBayar', tglbayar = '$tglBayar', ket = 'LUNAS', idadmin = '$admin' where idspp = '$idSpp'";
        $this->db->query($s);
    }

    //
    function get_data_laporan($tgl1, $tgl2)
    {
      // $sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
      $s = "select a.*, nis, namasiswa, kelas from t101_spp a
        inner join t004_siswa b on a.idsiswa = b.idsiswa
        left join t003_kelas c on b.idkelas = c.idkelas
        where tglbayar between '$tgl1' AND '$tgl2' order by nobayar asc";
      return $this->db->query($s)->result_array();
    }

    //
    function get_data_tunggakan_tgl($tgl1, $tgl2)
    {
      // $sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
      $s = "select a.*, nis, namasiswa, kelas from t101_spp a
        inner join t004_siswa b on a.idsiswa = b.idsiswa
        left join t003_kelas c on b.idkelas = c.idkelas
        where jatuhtempo between '$tgl1' AND '$tgl2' and nobayar = '' order by nobayar asc";
      return $this->db->query($s)->result_array();
    }


    function get_data_ubah_spp() {
      $s = "";
    }


    function update_ubah_spp2($data) {
      // ambil data siswa
      $q = "
        select
          idsiswa
        from
          t004_siswa
        where
          idkelas = ".$data["idkelas"]."
          and tahunajaran = '".$this->session->userdata("tahunajaran")."'
      ";
      $r = $this->db->query($q)->result();
      foreach($r as $rs) {
        $q = "
          update
            t101_spp
          set
            ".$data["jenis"]." = ".$data["nominal"]."
          where
            idsiswa = ".$rs->idsiswa."
            and bulan = '".$data["bulan"]."'
            and nobayar = ''
            and ket = ''
        ";
        //echo $q."<br>";
        $this->db->query($q);
      }
    }


    function get_data_spp($idkelas) {
      $s = "
        select
          a.idkelas,
          b.idsiswa,
          c.idspp,
          c.bulan,
          c.byrspp,
          c.byrcatering,
          c.byrworksheet
        from
          t003_kelas a
          left join t004_siswa b on a.idkelas = b.idkelas
          left join t101_spp c on b.idsiswa = c.idsiswa
        where
          a.idkelas = ".$idkelas."
          and b.tahunajaran = ".$this->session->userdata("tahunajaran")."
          and c.nobayar = ''
        limit 1
      ";
      $s = "
        select
          c.idkelas,
          c.idsiswa,
          d.idspp,
          d.bulan,
          d.byrspp,
          d.byrcatering,
          d.byrworksheet
        from
          (select
            a.idkelas,
            b.idsiswa
          from
            t003_kelas a
            left join t004_siswa b on a.idkelas = b.idkelas
          where
            a.idkelas = ".$idkelas."
            and b.tahunajaran = '".$this->session->userdata("tahunajaran")."'
          limit 1) c
          left join t101_spp d on c.idsiswa = d.idsiswa
        where
          d.nobayar = ''
      ";
      $s = "
        select
          a.idkelas,
            a.kelas,
            b.idsiswa,
            b.byrspp,
            b.byrcatering,
            b.byrworksheet
        from
          t003_kelas a
            left join t004_siswa b on a.idkelas = b.idkelas
        where
          a.idkelas = ".$idkelas."
          and b.tahunajaran = '".$this->session->userdata("tahunajaran")."'
        group by
          a.idkelas
      ";
      //echo $s;
      return $this->db->query($s)->result();
    }

    // get total rows nis tunggakan
    function total_rows_nis_tunggakan($q = NULL)
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
        $this->db->where("nobayar", "");
        $this->db->from($this->table);
        return $this->db->count_all_results();
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

    // get data with limit and search berdasarkan nis tunggakan
    function get_limit_data_nis_tunggakan($limit, $start = 0, $q = NULL)
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

        $this->db->order_by("jatuhtempo", "asc");
        // $this->db->like('idspp', $q);
        $this->db->limit($limit, $start);
        $this->db->where_in("idsiswa", $aIdsiswa);
        $this->db->where("nobayar", "");
        return $this->db->get($this->table)->result();
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

        $this->db->order_by("jatuhtempo", "asc");
        // $this->db->like('idspp', $q);
        $this->db->limit($limit, $start);
        $this->db->where_in("idsiswa", $aIdsiswa);
        return $this->db->get($this->table)->result();
    }

    // get data by id (tipe object)
    function get_by_idsiswa($idsiswa)
    {
        // $this->db->where($this->id, $id);
        $this->db->where('idsiswa', $idsiswa);
        $this->db->where('nobayar', '');
        // $row = $this->db->get($this->table)->row();
        // echo $this->db->last_query(); exit;
        return $this->db->get($this->table)->row();
    }

    // get data yang belum bayar, untuk ubah spp per siswa sekaligus beberapa bulan
    function get_bulan_2($idsiswa)
    {
        $q = "SELECT * FROM `t101_spp` WHERE idsiswa = ".$idsiswa." and nobayar = '' order by idspp";
        return $this->db->query($q)->result();
    }

    // update data versi 2 => update spp per siswa
    function update2($data, $bulan2)
    {
        // $this->db->where($this->id, $id);
        // $this->db->update($this->table, $data);
        // echo pre($id);
        // echo pre($data);
        // echo pre($bulan2); //exit;
        foreach ($bulan2 as $bulan) {
          // code...
          $q = "update t101_spp set
            byrspp = ".$data["byrspp"].",
            byrcatering = ".$data["byrcatering"].",
            byrworksheet = ".$data["byrworksheet"]."
            where idsiswa = ".$data["idsiswa"]." and bulan = '".$bulan."'"; //echo $q; exit;
          $this->db->query($q);
        }
    }

    // get total rows
    function total_rows_2($q = NULL) {
        $this->db->select('t101_spp.*, nis, namasiswa, tahunajaran');
        $this->db->from($this->table);
        $this->db->join('t004_siswa', 't101_spp.idsiswa = t004_siswa.idsiswa', 'left');
        $this->db->where('nobayar', '');
        $this->db->like('nis', $q);
        $this->db->or_like('namasiswa', $q);
        $this->db->group_by('t101_spp.idsiswa');
        return $this->db->count_all_results();
    }

    // get data with limit and search, only nis and namasiswa
    function get_limit_data_2($limit, $start = 0, $q = NULL) {
        $query = "
          select
            a.*,
            b.nis,
            b.namasiswa,
            b.tahunajaran,
            c.kelas
          from
            t101_spp a
            left join t004_siswa b on a.idsiswa = b.idsiswa
            left join t003_kelas c on b.idkelas = c.idkelas
          where
            (nis like '%".$q."%' or namasiswa like '%".$q."%')
            and nobayar = ''
          group by
            a.idsiswa,
            b.tahunajaran
          order by
            b.nis,
            b.tahunajaran
          ";
        // return $this->db->query($query)->result();
        // $this->db->select('nobayar, idspp, t101_spp.idsiswa, nis, namasiswa, tahunajaran, t003_kelas.kelas, t101_spp.byrspp, t101_spp.byrcatering, t101_spp.byrworksheet');
        // $this->db->from($this->table);
        // $this->db->join('t004_siswa', 't101_spp.idsiswa = t004_siswa.idsiswa', 'left');
        // $this->db->join('t003_kelas', 't004_siswa.idkelas = t003_kelas.idkelas', 'left');
        // $this->db->where('nobayar', '');
        // $this->db->like('nis', $q);
        // $this->db->or_like('namasiswa', $q);
        // $this->db->group_by('t101_spp.idsiswa');
        // return $this->db->get()->result();
        return $this->db->query($query)->result();
    }

    function get_data_tunggakan_kelas($tgl1, $tgl2, $idkelas)
    {
      // $sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
      $s = "select a.*, nis, namasiswa, kelas from t101_spp a
        inner join t004_siswa b on a.idsiswa = b.idsiswa
        left join t003_kelas c on b.idkelas = c.idkelas
        where jatuhtempo between '$tgl1' AND '$tgl2' and nobayar = ''
        and b.idkelas = ".$idkelas."
        order by nobayar asc";
      return $this->db->query($s)->result_array();
    }

}

/* End of file T101_spp_model.php */
/* Location: ./application/models/T101_spp_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-07-21 09:29:18 */
/* http://harviacode.com */
