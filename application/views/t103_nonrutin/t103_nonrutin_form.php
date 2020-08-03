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

        <form action="<?php echo $action; ?>" method="post">
          <div class="form-group">
              <label for="int">Tahun Ajaran <?php echo form_error('idsiswa') ?></label>
              <!-- <input type="text" class="form-control" name="idkelas" id="idkelas" placeholder="Idkelas" value="<?php //echo $idkelas; ?>" /> -->
              <select class="form-control" name="idsiswa" id="idsiswa">
                <?php foreach($aSiswa as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php echo ($key == $idsiswa ? " selected " : ""); ?>><?php echo $value; ?></option>
              <?php } ?>
              </select>
          </div>
          <!-- <div class="form-group">
            <label for="int">Idsiswa <?php //echo form_error('idsiswa') ?></label>
            <input type="text" class="form-control" name="idsiswa" id="idsiswa" placeholder="Idsiswa" value="<?php //echo $idsiswa; ?>" />
          </div> -->
    	    <div class="form-group">
            <label for="varchar">No. Bayar <?php echo form_error('nobayar') ?></label>
            <input type="text" class="form-control" name="nobayar" id="nobayar" placeholder="Nobayar" value="<?php echo $nobayar; ?>" readonly />
          </div>
    	    <div class="form-group">
            <label for="date">Tgl. Bayar <?php echo form_error('tglbayar') ?></label>
            <input type="text" class="form-control" name="tglbayar" id="tglbayar" placeholder="Tglbayar" value="<?php echo $tglbayar; ?>" readonly />
          </div>
          <div class="form-group">
              <label for="int">Jenis <?php echo form_error('idjenis') ?></label>
              <!-- <input type="text" class="form-control" name="idkelas" id="idkelas" placeholder="Idkelas" value="<?php //echo $idkelas; ?>" /> -->
              <select class="form-control" name="idjenis" id="idjenis">
                <?php foreach($aNonRutin as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php echo ($key == $idjenis ? " selected " : ""); ?>><?php echo $value; ?></option>
              <?php } ?>
              </select>
          </div>
    	    <!-- <div class="form-group">
            <label for="int">Idjenis <?php //echo form_error('idjenis') ?></label>
            <input type="text" class="form-control" name="idjenis" id="idjenis" placeholder="Idjenis" value="<?php //echo $idjenis; ?>" />
          </div> -->
          <div class="form-group">
            <label for="int">Nominal <?php echo form_error('nominal') ?></label>
            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal" value="<?php echo $nominal; ?>" <?php echo $readOnly; ?> />
          </div>
          <div class="form-group">
            <label for="int">Bayar <?php echo form_error('bayar') ?></label>
            <input type="text" class="form-control" name="bayar" id="bayar" placeholder="Bayar" value="<?php echo $bayar; ?>" />
          </div>
          <!-- <div class="form-group">
            <label for="int">Sisa <?php //echo form_error('sisa') ?></label>
            <input type="text" class="form-control" name="sisa" id="sisa" placeholder="Sisa" value="<?php //echo $sisa; ?>" />
          </div> -->
          <!-- <div class="form-group">
            <label for="int">Idadmin <?php //echo form_error('idadmin') ?></label>
            <input type="text" class="form-control" name="idadmin" id="idadmin" placeholder="Idadmin" value="<?php //echo $idadmin; ?>" />
          </div> -->
    	    <input type="hidden" name="idnonrutin" value="<?php echo $idnonrutin; ?>" />
          <input type="hidden" name="q" value="<?php echo $q ?>">
    	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
    	    <a href="<?php echo site_url('t103_nonrutin/index?q='.$q) ?>" class="btn btn-default">Cancel</a>
        </form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
