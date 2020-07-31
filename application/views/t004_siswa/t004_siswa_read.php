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

          <table class="table">
        	    <tr><td>NIS</td><td><?php echo $nis; ?></td></tr>
        	    <tr><td>Nama Siswa</td><td><?php echo $namasiswa; ?></td></tr>
        	    <tr><td>Kelas</td><td><?php echo $kelas; ?></td></tr>
        	    <tr><td>Tahun Ajaran</td><td><?php echo $tahunajaran; ?></td></tr>
        	    <tr><td>SPP</td><td><?php echo $byrspp; ?></td></tr>
        	    <tr><td>Catering</td><td><?php echo $byrcatering; ?></td></tr>
        	    <tr><td>Worksheet</td><td><?php echo $byrworksheet; ?></td></tr>
              <?php foreach ($dataNonRutin as $r): ?>
              <tr><td><?php echo $r->jenis; ?></td><td><?php echo $r->sisaterakhir; ?></td></tr>
              <?php endforeach; ?>
        	    <tr><td></td><td><a href="<?php echo site_url('t004_siswa') ?>" class="btn btn-default">Cancel</a></td></tr>
        	</table>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
