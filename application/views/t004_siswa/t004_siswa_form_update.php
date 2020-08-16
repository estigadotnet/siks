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

          <form action="<?php echo $action; ?>" method="post" class="mb-2">
            <div class="form-group">
                <label for="varchar">NIS <?php echo form_error('nis') ?></label>
                <input type="text" class="form-control" name="nis" id="nis" placeholder="NIS" value="<?php echo $nis; ?>" />
            </div>
            <div class="form-group">
                <label for="varchar">Nama Siswa <?php echo form_error('namasiswa') ?></label>
                <input type="text" class="form-control" name="namasiswa" id="namasiswa" placeholder="Nama Siswa" value="<?php echo $namasiswa; ?>" />
            </div>
            <div class="form-group">
                <label for="int">Kelas <?php echo form_error('idkelas') ?></label>
                <!-- <input type="text" class="form-control" name="idkelas" id="idkelas" placeholder="Idkelas" value="<?php echo $idkelas; ?>" /> -->
                <select class="form-control" name="idkelas" id="idkelas">
                  <?php foreach($dataKelas as $r) { ?>
                  <option value="<?php echo $r->idkelas; ?>" <?php echo ($r->idkelas == $idkelas ? " selected " : ""); ?>><?php echo $r->kelas; ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="varchar">Tahun Ajaran <?php echo form_error('tahunajaran') ?></label>
                <input type="text" class="form-control" name="tahunajaran" id="tahunajaran" placeholder="Tahun Ajaran" value="<?php echo $tahunajaran; ?>" readonly />
            </div>
            <div class="form-group">
                <!-- <label for="int">SPP <?php echo form_error('byrspp') ?></label> -->
                <input type="hidden" class="form-control" name="byrspp" id="byrspp" placeholder="SPP" value="<?php echo $byrspp; ?>" />
            </div>
            <div class="form-group">
                <!-- <label for="int">Catering <?php echo form_error('byrcatering') ?></label> -->
                <input type="hidden" class="form-control" name="byrcatering" id="byrcatering" placeholder="Catering" value="<?php echo $byrcatering; ?>" />
            </div>
            <div class="form-group">
                <!-- <label for="int">Worksheet <?php echo form_error('byrworksheet') ?></label> -->
                <input type="hidden" class="form-control" name="byrworksheet" id="byrworksheet" placeholder="Worksheet" value="<?php echo $byrworksheet; ?>" />
            </div>

            <!-- data non rutin -->
            <?php foreach ($dataNonRutin as $r): ?>
              <div class="form-group">
                  <!-- <label for="int"><?php echo $r->jenis; ?> </label> -->
                  <input type="hidden" class="form-control" name="<?php echo 'nominal'.$r->id; ?>" id="<?php echo 'nominal'.$r->id; ?>" placeholder="Nominal" value="<?php eval('echo $nominal'.$r->id.';'); ?>" <?php echo $readOnly; ?> />
              </div>
            <?php endforeach; ?>

            <div class="form-group">
              <input type="hidden" name="idsiswa" value="<?php echo $idsiswa; ?>" />
        	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        	    <a href="<?php echo site_url('t004_siswa') ?>" class="btn btn-default">Cancel</a>
            </div>
          </form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
