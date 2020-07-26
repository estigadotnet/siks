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
              <label for="varchar">Kelas <?php echo form_error('kelas') ?></label>
              <input type="text" class="form-control" name="kelas" id="kelas" placeholder="Kelas" value="<?php echo $kelas; ?>" />
            </div>
            <!-- <div class="form-group">
              <label for="int">Idguru <?php echo form_error('idguru') ?></label>
              <input type="text" class="form-control" name="idguru" id="idguru" placeholder="Idguru" value="<?php echo $idguru; ?>" />
            </div> -->
            <div class="form-group">
              <label for="int">Wali Kelas <?php echo form_error('idguru') ?></label>
              <!-- <input type="text" class="form-control" name="idguru" id="idguru" placeholder="Idguru" value="<?php echo $idguru; ?>" /> -->
              <select class="form-control" name="idguru" id="idguru">
                <?php foreach($dataGuru as $r) { ?>
                <option value="<?php echo $r->idguru; ?>" <?php echo ($r->idguru == $idguru ? " selected " : ""); ?>><?php echo $r->namaguru; ?></option>
              <?php } ?>
              </select>
            </div>
      	    <input type="hidden" name="idkelas" value="<?php echo $idkelas; ?>" />
      	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
      	    <a href="<?php echo site_url('t003_kelas') ?>" class="btn btn-default">Cancel</a>
          </form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
