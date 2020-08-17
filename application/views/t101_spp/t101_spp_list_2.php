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
              <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <form method="get" action="<?php echo site_url('t101_spp/ubah_spp_siswa'); ?>" class="form-horizontal">

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
                    <?php //if ($q <> '' or $q2 <> '') { ?>
                    &nbsp;<a href="<?php echo site_url('t101_spp/ubah_spp_siswa'); ?>" class="btn btn-default">Reset</a>
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
                // echo anchor(site_url('t101_spp/index?q='.$t004_siswa->nis),'Update');
                echo anchor(site_url('t101_spp/update/'.$t004_siswa->idsiswa.'/'.$t004_siswa->nis.'/'.$t004_siswa->tahunajaran),'Update');
                ?>
              </td>
            </tr>
            <?php } ?>
          </table>

          <?php } ?>

          <?php if ($q <> '') { ?>
            <?php redirect('t101_spp/update/'.$t004_siswa_data[0]->idsiswa.'/'.$t004_siswa_data[0]->nis.'/'.$t004_siswa_data[0]->tahunajaran) ?>
          <?php } ?>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
