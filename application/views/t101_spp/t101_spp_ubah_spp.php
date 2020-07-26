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
              <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
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

          <div class="row">
            <div class="col text-center">
              <div style="margin-top: 8px" id="message">
                  <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">

              <form method="post" action="<?php echo site_url('t101_spp/ubah_spp'); ?>" class="form-horizontal">

              	<div class="form-group">
              		<label for="tahunajaran">Tahun Ajaran</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="tahunajaran" placeholder="Tahun Ajaran" value="<?php echo $tahunajaran; ?>" readonly>
            			</div>
              	</div>

                <div class="form-group">
                  <label for="kelas">Kelas <?php echo form_error('idkelas') ?></label>
                  <!-- <input type="text" class="form-control" name="idkelas" id="idkelas" placeholder="Idkelas" value="<?php echo $idkelas; ?>" /> -->
                  <select class="form-control" name="idkelas" id="idkelas">
                    <?php foreach($dataKelas as $r) { ?>
                    <option value="<?php echo $r->idkelas; ?>" <?php echo ($r->idkelas == $idkelas ? " selected " : ""); ?>><?php echo $r->kelas; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
              		<div class="input-group">
                    <?php if ($this->session->userdata('message') == '' or $idkelas <> "") { ?>
              			<button type="submit" class="btn btn-primary">Proses</button>
                    <?php } ?>
              		</div>
              	</div>

              </form>

            </div>
          </div>

          <?php if ($idkelas <> '' and !empty($dataSpp)) { ?>

          <hr/>
        	<div class="page-header">
        		<h3>Data Nominal SPP Siswa</h3>
        	</div>
          <table class="table table-bordered table-sm" style="margin-bottom: 10px">
            <tr>
              <th>No</th>
              <th>Bulan</th>
          		<th>SPP</th>
          		<th>Catering</th>
          		<th>Worksheet</th>
          		<th>Action</th>
            </tr>
            <?php
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


            // $aSpp = get_object_vars($dataSpp);
            //$aSpp = (array) $dataSpp[0];
            // echo "<pre>"; print_r($dataSpp); echo "</pre>";

            $start = 0;
            for ($i = 0; $i < 12; $i++) {
              $jatuhTempo = date("Y-m-d", strtotime("+$i month", strtotime($awalTempo)));
              $bulan = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));
            ?>
            <tr>
        			<td width="80px"><?php echo ++$start ?></td>
              <td><?php echo $bulan ?></td>
        			<td align="right"><?php echo number_format($dataSpp[0]->byrspp) ?></td>
        			<td align="right"><?php echo number_format($dataSpp[0]->byrcatering) ?></td>
        			<td align="right"><?php echo number_format($dataSpp[0]->byrworksheet) ?></td>
              <td align="center">
						  <a href='<?php echo site_url('t101_spp/ubah_spp_action/'.$dataSpp[0]->idkelas."/".$start); ?>' class='btn btn-warning btn-sm'>Ubah</a>
              </td>
        		</tr>
            <?php
            }
            ?>


          </table>
          <?php } ?>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php $this->load->view("template/foot"); ?>
<?php $this->load->view("template/js"); ?>
