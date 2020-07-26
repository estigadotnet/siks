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
                  <label for="date">Tgl <?php echo form_error('tgl') ?></label>
                  <input type="date" class="form-control" name="tgl" id="tgl" placeholder="Tgl" value="<?php echo $tgl; ?>" readonly />
              </div>
      	    <div class="form-group">
                  <label for="varchar">Nobuk <?php echo form_error('nobuk') ?></label>
                  <input type="text" class="form-control" name="nobuk" id="nobuk" placeholder="Nobuk" value="<?php echo $nobuk; ?>" readonly />
              </div>
      	    <div class="form-group">
                  <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
                  <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
              </div>
      	    <div class="form-group">
                  <label for="float">Jumlah <?php echo form_error('jumlah') ?></label>
                  <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" />
              </div>
      	    <input type="hidden" name="id" value="<?php echo $id; ?>" />
      	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
      	    <a href="<?php echo site_url('t102_pengeluaran') ?>" class="btn btn-default">Cancel</a>
      	  </form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
