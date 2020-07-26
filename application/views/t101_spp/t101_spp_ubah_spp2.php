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

              <form method="post" action="<?php echo site_url('t101_spp/ubah_spp2_action'); ?>" class="form-horizontal">

              	<div class="form-group">
              		<label for="tahunajaran">Tahun Ajaran</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="tahunajaran" placeholder="Tahun Ajaran" value="<?php echo $tahunajaran; ?>" readonly>
            			</div>
              	</div>

                <div class="form-group">
                  <label for="kelas">Kelas <?php echo form_error('idkelas') ?></label>
                  <select class="form-control" name="idkelas" id="idkelas">
                    <?php foreach($dataKelas as $r) { ?>
                    <option value="<?php echo $r->idkelas; ?>" <?php echo ($r->idkelas == $idkelas ? " selected " : ""); ?>><?php echo $r->kelas; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="bulan">Bulan</label>
                  <select class="form-control" name="bulan" id="bulan">
                    <?php for ($i = 0; $i < 12; $i++) { ?>
                    <option value="<?php echo $aBulan[$i]; ?>"><?php echo $aBulan[$i]; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="jenis">Jenis</label>
                  <select class="form-control" name="jenis" id="jenis">
                    <!-- <?php //for ($i = 0; $i < count($aJenis); $i++) { ?> -->
                    <?php foreach ($aJenis as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
              		<label for="nominal">Nominal</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="nominal" placeholder="Nominal" value="">
            			</div>
              	</div>

                <div class="form-group">
              		<div class="input-group">
                    <?php if ($this->session->userdata('message') == '') { ?>
              			<button type="submit" class="btn btn-primary">Proses</button>
                    <?php } ?>
              		</div>
              	</div>

              </form>

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
