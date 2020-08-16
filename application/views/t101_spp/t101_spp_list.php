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
            <div class="col">
              <form method="get" action="<?php echo site_url('t101_spp/index'); ?>" class="form-horizontal">

                <div class="form-group">
              		<label class="control-label" for="nis">NIS :</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="q" placeholder="Masukkan NIS" value="<?php echo $q; ?>">
            			</div>
              	</div>

                <div class="form-group">
              		<label class="control-label" for="nis">Nama Siswa :</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="q2" placeholder="Masukkan Nama Siswa" value="<?php echo $q2; ?>">
            			</div>
              	</div>

                <div class="form-group">
              		<div class="input-group">
              			<button type="submit" class="btn btn-primary">Cari Siswa</button>
                    <?php //echo 'q: '.$q.' q2: '.$q2; ?>
                    <?php //if ($q <> '' or $q2 <> '') { ?>
                    <?php //if ($t004_siswa_data <> 0) { ?>
                    &nbsp;<a href="<?php echo site_url('t101_spp'); ?>" class="btn btn-default">Reset</a>
                    <?php //} ?>
              		</div>
              	</div>



              </form>
            </div>
          </div>

          <?php if ($q == '' and $t004_siswa_data <> 0) { ?>

          <hr>
          <table class="table-sm table-bordered" style="margin-bottom: 10px">
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Tahun Ajaran</th>
              <th>SPP</th>
              <th>Catering</th>
              <th>Worksheet</th>
              <th>Action</th>
            </tr>
            <?php
            $start = 0;
            foreach ($t004_siswa_data as $t004_siswa)
            {
            ?>
            <tr>
              <td width="2%"><?php echo ++$start ?></td>
              <td><?php echo $t004_siswa->nis ?></td>
              <td><?php echo $t004_siswa->namasiswa ?></td>
              <td><?php echo $t004_siswa->kelas ?></td>
              <td><?php echo $t004_siswa->tahunajaran ?></td>
              <td><?php echo $t004_siswa->byrspp ?></td>
              <td><?php echo $t004_siswa->byrcatering ?></td>
              <td><?php echo $t004_siswa->byrworksheet ?></td>
              <td style="text-align:left" width="15%">
                <?php
                echo anchor(site_url('t101_spp/index?q='.$t004_siswa->nis),'Proses');
                ?>
              </td>
            </tr>
            <?php } ?>
          </table>

          <?php } ?>
          <?php if ($q <> '') { ?>

          <hr/>
        	<div class="page-header">
        		<h4>Biodata Siswa</h4>
        	</div>
          <div class="table-responsive-sm">
          	<table class="table table-sm">
          		<tr>
          			<td width="200">NIS</td>
          			<td width="30">:</td>
          			<td><?php echo $dataSiswa[0]["nis"]; ?></td>
          		</tr>
          		<tr>
          			<td width="200">Nama Siswa</td>
          			<td width="30">:</td>
          			<td><?php echo $dataSiswa[0]["namasiswa"]; ?></td>
          		</tr>
          		<tr>
          			<td width="200">Kelas</td>
          			<td width="30">:</td>
          			<td><?php echo $dataSiswa[0]["kelas"]; ?></td>
          		</tr>
          		<tr>
          			<td width="200">Tahun Ajaran</td>
          			<td width="30">:</td>
          			<td><?php echo $dataSiswa[0]["tahunajaran"]; ?></td>
          		</tr>
          		<tr><td width="200"></td>
          			<td width="30"></td>
          			<td></td></tr>
          	</table>
          </div>

        	<div class="page-header">
        		<h4>Tagihan SPP Siswa</h4>
        	</div>
          <table class="table-sm table-bordered table-sm" style="margin-bottom: 10px">
            <tr>
              <th>No</th>
          		<!-- <th>Idsiswa</th> -->
              <th>Bulan</th>
          		<th>Jatuh Tempo</th>
          		<th>No. Bayar</th>
          		<th>Tgl. Bayar</th>
          		<th>SPP</th>
          		<th>Catering</th>
          		<th>Worksheet</th>
          		<th>Keterangan</th>
          		<th>Bayar</th>
            </tr>
            <?php foreach ($t101_spp_data as $t101_spp) { ?>
            <tr>
        			<td width="80px"><?php echo ++$start ?></td>
        			<!-- <td><?php //echo $t101_spp->idsiswa ?></td> -->
              <td><?php echo $t101_spp->bulan ?></td>
        			<td><?php echo date_format(date_create($t101_spp->jatuhtempo), "d-m-Y") ?></td>
        			<td><?php echo $t101_spp->nobayar ?></td>
        			<td><?php echo ($t101_spp->nobayar == "" ? "" : date_format(date_create($t101_spp->tglbayar), "d-m-Y")) ?></td>
        			<td align="right"><?php echo number_format($t101_spp->byrspp) ?></td>
        			<td align="right"><?php echo number_format($t101_spp->byrcatering) ?></td>
        			<td align="right"><?php echo number_format($t101_spp->byrworksheet) ?></td>
        			<td><?php echo $t101_spp->ket ?></td>
              <td align="left">
              <?php if ($t101_spp->nobayar == '') { ?>
						  <a href='<?php echo site_url('t101_spp/bayar/'.$t101_spp->idspp."/".$q."/".$start); ?>' class='btn btn-warning btn-sm'>Bayar</a>
              <!-- |
              <a href='<?php echo site_url('t101_spp/update/'.$t101_spp->idspp."/".$q); ?>' class='btn btn-warning btn-sm'>Update</a> -->
              <?php } else { ?>
						  <a href='<?php echo site_url('t101_spp/cetak?idSpp='.$t101_spp->idspp."&q=".$q); ?>' class='btn btn-info btn-sm' target='blank'>Cetak</a>
              <?php } ?>
              </td>
        		</tr>
            <?php } ?>
          </table>
          <div class="row">
            <div class="col-md-6">
              <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
          		<?php echo anchor(site_url('t101_spp/excel'), 'Excel', 'class="btn btn-primary"'); ?>
          		<?php echo anchor(site_url('t101_spp/word'), 'Word', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
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
