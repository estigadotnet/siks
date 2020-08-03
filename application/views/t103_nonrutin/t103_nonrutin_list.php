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
              <form method="get" action="<?php echo site_url('t103_nonrutin/index'); ?>" class="form-horizontal">

              	<div class="form-group">
              		<label class="control-label col-sm-1" for="nis">NIS :</label>
            			<div class="input-group">
            				<input type="text" class="form-control" name="q" placeholder="Masukkan NIS" value="<?php echo $q; ?>">
            			</div>
              	</div>

                <div class="form-group">
              		<div class="input-group">
              			<button type="submit" class="btn btn-primary">Cari Siswa</button>
                    <?php if ($q <> '') { ?>
                    &nbsp;<a href="<?php echo site_url('t103_nonrutin'); ?>" class="btn btn-default">Reset</a>
                    <?php } ?>
              		</div>
              	</div>

              </form>
            </div>
          </div>

          <?php if ($q <> '') { ?>
          <hr/>
        	<div class="page-header">
        		<h3>Biodata Siswa</h3>
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

          <div class="row">
            <div class="col-md-4 mb-2">
              <?php echo anchor(site_url('t103_nonrutin/create/'.$q),'Bayar', 'class="btn btn-primary btn-sm"'); ?>
            </div>
          </div>
          <table class="table-sm table-bordered" style="margin-bottom: 10px">
            <tr>
              <th>No</th>
            	<!-- <th>Idsiswa</th> -->
              <th>Tahun Ajaran</th>
              <th>Kelas</th>
            	<th>No. Bayar</th>
            	<th>Tgl. Bayar</th>
            	<!-- <th>Idjenis</th> -->
              <th>Jenis</th>
            	<th>Nominal</th>
            	<th>Bayar</th>
            	<th>Sisa</th>
            	<th>Action</th>
            </tr>
            <?php foreach ($dataNonRutin as $r) {
              // code...
              $aNonRutin[$r->id] = $r->Jenis;
            }
            //echo "<pre>"; print_r($aNonRutin); echo "</pre>";
            ?>
            <?php foreach ($t103_nonrutin_data as $t103_nonrutin) { ?>
            <tr>
        			<td width="5%"><?php echo ++$start ?></td>
        			<!-- <td><?php //echo $t103_nonrutin->idsiswa ?></td> -->
              <td><?php echo $dataSiswaTA[$t103_nonrutin->idsiswa][0] ?></td>
              <td><?php echo $dataSiswaTA[$t103_nonrutin->idsiswa][1] ?></td>
        			<td><?php echo $t103_nonrutin->nobayar ?></td>
        			<!-- <td><?php //echo $t103_nonrutin->tglbayar ?></td> -->
              <td><?php echo ($t103_nonrutin->nobayar == "" ? "" : date_format(date_create($t103_nonrutin->tglbayar), "d-m-Y")) ?></td>
        			<!-- <td><?php //echo $t103_nonrutin->idjenis ?></td> -->
              <td><?php echo $aNonRutin[$t103_nonrutin->idjenis] ?></td>
        			<td align="right"><?php echo number_format($t103_nonrutin->nominal) ?></td>
        			<td align="right"><?php echo number_format($t103_nonrutin->bayar) ?></td>
        			<td align="right"><?php echo number_format($t103_nonrutin->sisa) ?></td>
        			<td style="text-align:left" width="18.5%">
        				<?php
                echo anchor(site_url('t103_nonrutin/update/'.$t103_nonrutin->idnonrutin.'/'.$q), 'Update', 'class="btn btn-primary btn-sm"'); echo "&nbsp;";
        				echo anchor(site_url('t103_nonrutin/delete/'.$t103_nonrutin->idnonrutin.'/'.$q), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure ?\')" class="btn btn-primary btn-sm"'); echo "&nbsp;";
                if ($t103_nonrutin->bayar <> 0) {
                  echo anchor(site_url('t103_nonrutin/cetak?idNonRutin='.$t103_nonrutin->idnonrutin."&q=".$q), 'Cetak', "class='btn btn-info btn-sm' target='blank'"); echo "&nbsp;";
                }
        				// echo anchor(site_url('t103_nonrutin/read/'.$t103_nonrutin->idnonrutin),'Read');
        				// echo ' | ';
        				// echo anchor(site_url('t103_nonrutin/update/'.$t103_nonrutin->idnonrutin),'Update');
        				// echo ' | ';
        				// echo anchor(site_url('t103_nonrutin/delete/'.$t103_nonrutin->idnonrutin),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
        				?>
        			</td>
  		      </tr>
            <?php } ?>
          </table>

          <div class="row">
            <div class="col-md-6">
              <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
          		<?php echo anchor(site_url('t103_nonrutin/excel'), 'Excel', 'class="btn btn-primary"'); ?>
          		<?php echo anchor(site_url('t103_nonrutin/word'), 'Word', 'class="btn btn-primary"'); ?>
	          </div>
            <div class="col-md-6 text-right">
              <?php echo $pagination ?>
            </div>
          </div>

          <?php } ?>

        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("template/foot"); ?>
    <?php $this->load->view("template/js"); ?>
