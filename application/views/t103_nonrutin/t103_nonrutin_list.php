<!doctype html>
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
        <h2 style="margin-top:0px">T103_nonrutin List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('t103_nonrutin/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('t103_nonrutin/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('t103_nonrutin'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idsiswa</th>
		<th>Nobayar</th>
		<th>Tglbayar</th>
		<th>Idjenis</th>
		<th>Nominal</th>
		<th>Bayar</th>
		<th>Sisa</th>
		<th>Idadmin</th>
		<th>Action</th>
            </tr><?php
            foreach ($t103_nonrutin_data as $t103_nonrutin)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $t103_nonrutin->idsiswa ?></td>
			<td><?php echo $t103_nonrutin->nobayar ?></td>
			<td><?php echo $t103_nonrutin->tglbayar ?></td>
			<td><?php echo $t103_nonrutin->idjenis ?></td>
			<td><?php echo $t103_nonrutin->nominal ?></td>
			<td><?php echo $t103_nonrutin->bayar ?></td>
			<td><?php echo $t103_nonrutin->sisa ?></td>
			<td><?php echo $t103_nonrutin->idadmin ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('t103_nonrutin/read/'.$t103_nonrutin->idnonrutin),'Read'); 
				echo ' | '; 
				echo anchor(site_url('t103_nonrutin/update/'.$t103_nonrutin->idnonrutin),'Update'); 
				echo ' | '; 
				echo anchor(site_url('t103_nonrutin/delete/'.$t103_nonrutin->idnonrutin),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
		<?php echo anchor(site_url('t103_nonrutin/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('t103_nonrutin/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>