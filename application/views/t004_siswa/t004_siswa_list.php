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
              <h1 class="m-0 text-dark"><?php echo $title . " " . $kelas; ?></h1>
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

          <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
              <?php echo anchor(site_url('t004_siswa/create'),'Create', 'class="btn btn-primary"'); ?>
              <?php if ($idkelas != "" and $jumRec > 0) { ?>
              <?php echo anchor(site_url('t004_siswa/naikkelas?idkelas='.$idkelas),'Naik Kelas', 'class="btn btn-primary"'); ?>
              <?php } ?>
            </div>
            <div class="col-md-4 text-center"><div style="margin-top: 8px" id="message"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></div></div>
            <div class="col-md-1 text-right"></div>
            <div class="col-md-3 text-right">
              <form action="<?php echo site_url('t004_siswa'); ?>" class="form-inline" method="get">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                  <span class="input-group-btn">
                    <?php
                    if ($q <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('t004_siswa'); ?>" class="btn btn-default">Reset</a>
                        <?php
                    }
                    ?>
                    <button class="btn btn-primary" type="submit">Search</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
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
              <?php foreach ($nonRutinData as $nonRutin) {
                // code...
                ?>
              <th><?php echo  $nonRutin->Jenis; ?></th>
                <?php
              } ?>
          		<th>Action</th>
            </tr>
            <?php foreach ($t004_siswa_data as $t004_siswa) { ?>
            <tr>
        			<td width="2%"><?php echo ++$start ?></td>
        			<td><?php echo $t004_siswa->nis ?></td>
        			<td><?php echo $t004_siswa->namasiswa ?></td>
        			<td><?php echo $t004_siswa->kelas ?></td>
        			<td><?php echo $t004_siswa->tahunajaran ?></td>
        			<td><?php echo $t004_siswa->byrspp ?></td>
        			<td><?php echo $t004_siswa->byrcatering ?></td>
        			<td><?php echo $t004_siswa->byrworksheet ?></td>
              <td><?php echo (substr($t004_siswa->kelas, 0, 1) == 1 ? $nonRutinTrans[$t004_siswa->idsiswa][1] : 0); ?></td>
              <?php for ($i = 2; $i <= count($nonRutinTrans[$t004_siswa->idsiswa]); $i++) {
                // code...
                ?>
              <td><?php echo (substr($t004_siswa->kelas, 0, 1) > 1 ? $nonRutinTrans[$t004_siswa->idsiswa][$i] : 0); ?></td>
                <?php
              } ?>
        			<td style="text-align:left" width="15%">
        				<?php
        				echo anchor(site_url('t004_siswa/read/'.$t004_siswa->idsiswa),'Read');
        				echo ' | ';
        				echo anchor(site_url('t004_siswa/update/'.$t004_siswa->idsiswa),'Update');
        				echo ' | ';
        				echo anchor(site_url('t004_siswa/delete/'.$t004_siswa->idsiswa),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
						    // echo ' | ';
        				// echo anchor(site_url('t101_spp/index?q='.$t004_siswa->nis),'Bayar');
        				?>
        			</td>
        		</tr>
            <?php } ?>
          </table>
          <div class="row">
            <div class="col-md-6">
              <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
          		<?php //echo anchor(site_url('t004_siswa/excel'), 'Excel', 'class="btn btn-primary"'); ?>
          		<?php //echo anchor(site_url('t004_siswa/word'), 'Word', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-6 text-right">
              <?php //echo $pagination ?>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
