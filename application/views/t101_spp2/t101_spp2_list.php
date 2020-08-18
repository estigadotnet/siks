<!-- <!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">T101_spp2 List</h2> -->
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

        <div class="row" style="margin-bottom: 10px">
          <!-- <div class="col-md-4">
                <?php //echo anchor(site_url('t101_spp2/create'),'Create', 'class="btn btn-primary"'); ?>
            </div> -->
            <!-- <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php //echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div> -->
            <!-- <div class="col-md-1 text-right">
            </div> -->
            <!-- <div class="col-md-3 text-right"> -->
            <div class="col">
                <form action="<?php echo site_url('t101_spp2/ubah_spp_siswa'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <label class="control-label" for="nis">NIS / Nama Siswa : &nbsp;</label>
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">&nbsp;
                        <span class="input-group-btn">
                            <?php
                                if ($q <> '')
                                {
                                    ?>
                                    &nbsp;<a href="<?php echo site_url('t101_spp2/ubah_spp_siswa'); ?>" class="btn btn-default">Reset</a>&nbsp;
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <?php if ($q <> '') { ?>
        <table class="table table-bordered" style="margin-bottom: 10px">
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
            </tr><?php
            foreach ($t101_spp2_data as $t101_spp2)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
      <td><?php echo $t101_spp2->nis ?></td>
      <td><?php echo $t101_spp2->namasiswa ?></td>
      <td><?php echo $t101_spp2->kelas ?></td>
      <td><?php echo $t101_spp2->tahunajaran ?></td>
			<td><?php echo $t101_spp2->byrspp ?></td>
			<td><?php echo $t101_spp2->byrcatering ?></td>
			<td><?php echo $t101_spp2->byrworksheet ?></td>
			<td style="text-align:left" >
				<?php
				// echo anchor(site_url('t101_spp2/read/'.$t101_spp2->idspp),'Read');
				// echo ' | ';
				echo anchor(site_url('t101_spp2/update/'.$t101_spp2->idspp),'Update');
				// echo ' | ';
				// echo anchor(site_url('t101_spp2/delete/'.$t101_spp2->idspp),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('t101_spp2/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('t101_spp2/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
        <?php } ?>
    <!-- </body>
</html> -->

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
