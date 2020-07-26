<?php $this->load->view("template/head", $head); ?>
<?php $this->load->view("template/topbar"); ?>
<?php $this->load->view("template/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?php echo ($q == "" ? $title : ""); ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $title; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <!-- container fluid -->
        <div class="container-fluid">

          <?php if ($q == "") { ?>
          <div class="row">
            <div class="col">
              <form method="post" action="<?php echo site_url('mutasi/laporan'); ?>" class="form-horizontal">

              	<!-- <div class="form-group">
              		<label class="control-label col-sm-1" for="nis">NIS :</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="q" placeholder="Masukkan NIS" value="<?php //echo $q; ?>">
            			</div>
              	</div> -->

                <div class="form-group">
                  <label>Tanggal Mutasi</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation" name="q">
                  </div>
                </div>

                <div class="form-group">
              		<div class="input-group">
              			<button type="submit" class="btn btn-primary">Proses</button>
              		</div>
              	</div>

              </form>
            </div>
          </div>
          <?php } else { ?>
            <h3 align="center">LAPORAN MUTASI REKENING BANK<br/><?php echo $this->session->userdata("namasekolah"); ?></h3>
            <hr/>
            <p align="center">Periode &nbsp;&nbsp;&nbsp;<?php echo date_format(date_create($tgl1), "d-m-Y") . " &nbsp;&nbsp;&nbsp;s.d.&nbsp;&nbsp;&nbsp; " . date_format(date_create($tgl2), "d-m-Y"); ?></p>
            <table width="100%" border="1" cellspacing="0" cellpadding="4">
              <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Saldo</th>
              </tr>
              <?php
                //$sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
                $no = 1;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                //while($d=mysqli_fetch_array($sqlBayar)){
                foreach($mutasi_data as $d) {
                  echo "<tr>
                    <td align='right'>$no</td>
                    <td>".date_format(date_create($d["tgl"]), "d-m-Y")."</td>
                    <td>$d[keterangan]</td>
                    <td align='right'>".number_format($d["debet"])."</td>
                    <td align='right'>".number_format($d["kredit"])."</td>";
                    $total3 += $d['debet'] - $d["kredit"];
                  echo "
                    <td align='right'>".number_format($total3)."</td>
                  </tr>";
                  $no++;
                  $total1 +=$d['debet'];
                  $total2 +=$d['kredit'];
                  //$total3 +=$d['saldo'];
                }
              ?>
              <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="right"><b><?php echo number_format($total1); ?></b></td>
                <td align="right"><b><?php echo number_format($total2); ?></b></td>
                <td align="right"><b>&nbsp;</b></td>
              </tr>
            </table>
            <table>
              <tr>
                <td></td>
                <td width="200px">
                  <p>Bojonegoro, <?php echo date('d-m-Y'); ?><br/>
                  Petugas</p>
                  <br/>
                  <br/>
                  <p>____________________</p>
                </td>
              </tr>
            </table>

            <div class="no-print">
              <a href="#" class="no-print" onclick="window.print();">Print Laporan</a> |
            <a href="<?php echo site_url(); ?>mutasi/laporan_xls?tglBayar=<?php echo $q; ?>" class="no-print" target="_blank">Export to Excel</a>
            </div>
          <?php } ?>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php $this->load->view("template/foot"); ?>
<?php $this->load->view("template/js"); ?>
