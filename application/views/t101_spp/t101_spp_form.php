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

          <form action="<?php echo $action; ?>" method="post">
  	    <div class="form-group">
              <!-- <label for="int">Idsiswa <?php echo form_error('idsiswa') ?></label> -->
              <input type="hidden" class="form-control" name="idsiswa" id="idsiswa" placeholder="Idsiswa" value="<?php echo $idsiswa; ?>" />
          </div>
  	    <div class="form-group">
              <!-- <label for="date">Jatuhtempo <?php echo form_error('jatuhtempo') ?></label> -->
              <input type="hidden" class="form-control" name="jatuhtempo" id="jatuhtempo" placeholder="Jatuhtempo" value="<?php echo $jatuhtempo; ?>" />
          </div>
  	    <div class="form-group">
              <!-- <label for="varchar">Bulan <?php echo form_error('bulan') ?></label> -->
              <input type="hidden" class="form-control" name="bulan" id="bulan" placeholder="Bulan" value="<?php echo $bulan; ?>" />
          </div>
  	    <div class="form-group">
              <!-- <label for="varchar">Nobayar <?php echo form_error('nobayar') ?></label> -->
              <input type="hidden" class="form-control" name="nobayar" id="nobayar" placeholder="Nobayar" value="<?php echo $nobayar; ?>" />
          </div>
  	    <div class="form-group">
              <!-- <label for="date">Tglbayar <?php echo form_error('tglbayar') ?></label> -->
              <input type="hidden" class="form-control" name="tglbayar" id="tglbayar" placeholder="Tglbayar" value="<?php echo $tglbayar; ?>" />
          </div>
          <div class="form-group">
          <div class="col-sm-6">
            <!-- Select multiple-->
            <div class="form-group">
              <label>Bulan</label>
              <select multiple class="form-control" name="bulan2[]" style="height: 200px;">
                <?php foreach ($row_bulan2 as $row) {
                  // code...
                ?>
                <option><?php echo $row->bulan; ?></option>
                <?php
                } ?>
                <!-- <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option> -->
              </select>
            </div>
          </div>
          </div>
  	    <div class="form-group">
              <label for="int">SPP <?php echo form_error('byrspp') ?></label>
              <input type="text" class="form-control" name="byrspp" id="byrspp" placeholder="Byrspp" value="<?php echo $byrspp; ?>" />
          </div>
  	    <div class="form-group">
              <label for="int">Catering <?php echo form_error('byrcatering') ?></label>
              <input type="text" class="form-control" name="byrcatering" id="byrcatering" placeholder="Byrcatering" value="<?php echo $byrcatering; ?>" />
          </div>
  	    <div class="form-group">
              <label for="int">Worksheet <?php echo form_error('byrworksheet') ?></label>
              <input type="text" class="form-control" name="byrworksheet" id="byrworksheet" placeholder="Byrworksheet" value="<?php echo $byrworksheet; ?>" />
          </div>
  	    <div class="form-group">
              <label for="varchar">Keterangan <?php echo form_error('ket') ?></label>
              <input type="text" class="form-control" name="ket" id="ket" placeholder="Keterangan" value="<?php echo $ket; ?>" />
          </div>
  	    <div class="form-group">
              <!-- <label for="int">Idadmin <?php echo form_error('idadmin') ?></label> -->
              <input type="hidden" class="form-control" name="idadmin" id="idadmin" placeholder="Idadmin" value="<?php echo $idadmin; ?>" />
          </div>
  	    <input type="hidden" name="idspp" value="<?php echo $idspp; ?>" />
        <input type="hidden" name="q" value="<?php echo $q; ?>" />
  	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
  	    <!-- <a href="<?php echo site_url('t101_spp/index?q='.$q) ?>" class="btn btn-default">Cancel</a> -->
        <a href="<?php echo site_url('t101_spp/ubah_spp_siswa') ?>" class="btn btn-default">Cancel</a>
  	</form>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
