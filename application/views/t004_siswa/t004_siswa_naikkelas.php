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

          <!-- <h3>Naik Kelas</h3> -->
          <form method="post" action="<?php echo site_url("t004_siswa/naikkelas_action"); ?>">
          	<input type="hidden" name="idkelasLama" value="<?php echo $idkelasLama; ?>">

          	<h6>dari Kelas & Tahun Ajaran</h6>
          	<div class="form-group">
          		<input type="text" class="form-control" name="kelasLama"  value="<?php echo $kelasLama; ?>" maxlength="40" readonly />
          	</div>
          	<div class="form-group">
          		<input type="text" class="form-control" name="tahunajaranLama"  value="<?php echo $this->session->userdata('tahunajaran'); ?>" maxlength="40" readonly />
          	</div>

            <p>&nbsp;</p>
          	<h6>ke Kelas & Tahun Ajaran</h6>

          	<div class="form-group">
          		<select class="form-control" name="idkelasBaru">
          			<option value="" selected>- Pilih Kelas -</option>
        				<?php foreach($dataKelas as $k) { ?>
        				<option value="<?php echo $k->idkelas; ?>"><?php echo $k->kelas; ?></option>
        				<?php } ?>
          		</select>
          	</div>

          	<div class="form-group">
          		<select class="form-control" name="tahunajaranBaru">
          			<option value="" selected>- Pilih Tahun Ajaran Baru -</option>
          				<?php foreach($dataTahunajaran as $t) { ?>
                    <?php if ($t->tahunajaran > $this->session->userdata("tahunajaran")) { ?>
            				<option value="<?php echo $t->tahunajaran; ?>"><?php echo $t->tahunajaran; ?></option>
                    <?php } ?>
          				<?php } ?>
          		</select>
          	</div>

          	<div class="form-group">
          		<label for="spp">Biaya SPP</label>
          		<input type="text" class="form-control" name="spp" maxlength="40" />
          	</div>

          	<div class="form-group">
          		<label for="catering">Biaya Catering</label>
          		<input type="text" class="form-control" name="catering" maxlength="40" />
          	</div>

          	<div class="form-group">
          		<label for="worksheet">Biaya Worksheet</label>
          		<input type="text" class="form-control" name="worksheet" maxlength="40" />
          	</div>

            <!-- data non rutin -->
            <?php foreach ($dataNonRutin as $r): ?>
              <div class="form-group">
                  <label for="int"><?php echo $r->jenis; ?> </label>
                  <input type="text" class="form-control" name="<?php echo 'nominal'.$r->id; ?>" id="<?php echo 'nominal'.$r->id; ?>" placeholder="Nominal" value="<?php eval('echo $nominal'.$r->id.';'); ?>" <?php echo $readOnly; ?> />
              </div>
            <?php endforeach; ?>

          	<button type="submit" class="btn btn-default">Proses</button>
          	<button type="button" class="btn btn-default" onclick="window.history.go(-1); return false;">Kembali</button>
          </form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
