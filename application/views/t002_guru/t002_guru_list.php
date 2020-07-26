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
            <div class="col-md-4"><?php echo anchor(site_url('t002_guru/create'),'Create', 'class="btn btn-primary"'); ?></div>
            <div class="col-md-4 text-center"><div style="margin-top: 8px" id="message"><?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?></div></div>
            <div class="col-md-1 text-right"></div>
            <div class="col-md-3 text-right">
              <form action="<?php echo site_url('t002_guru'); ?>" class="form-inline" method="get">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                  <span class="input-group-btn">
                    <?php
                    if ($q <> '')
                    {
                    ?>
                    <a href="<?php echo site_url('t002_guru'); ?>" class="btn btn-default">Reset</a>
                    <?php
                    }
                    ?>
                    <button class="btn btn-primary" type="submit">Search</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
          <table class="table-sm table-bordered" style="margin-bottom: 10px">
            <tr>
              <th>No</th>
          		<th>Nama</th>
          		<th>Action</th>
            </tr>
            <?php
            foreach ($t002_guru_data as $t002_guru)
            {
            ?>
            <tr>
        			<td width="80px"><?php echo ++$start ?></td>
        			<td><?php echo $t002_guru->namaguru ?></td>
        			<td style="text-align:center" width="200px">
        				<?php
        				echo anchor(site_url('t002_guru/read/'.$t002_guru->idguru),'Read');
        				echo ' | ';
        				echo anchor(site_url('t002_guru/update/'.$t002_guru->idguru),'Update');
        				echo ' | ';
        				echo anchor(site_url('t002_guru/delete/'.$t002_guru->idguru),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
              <?php echo anchor(site_url('t002_guru/excel'), 'Excel', 'class="btn btn-primary"'); ?>
              <?php echo anchor(site_url('t002_guru/word'), 'Word', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-6 text-right">
              <?php echo $pagination ?>
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
