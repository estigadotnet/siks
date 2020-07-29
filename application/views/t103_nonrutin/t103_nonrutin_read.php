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
        <h2 style="margin-top:0px">T103_nonrutin Read</h2>
        <table class="table">
	    <tr><td>Idsiswa</td><td><?php echo $idsiswa; ?></td></tr>
	    <tr><td>Nobayar</td><td><?php echo $nobayar; ?></td></tr>
	    <tr><td>Tglbayar</td><td><?php echo $tglbayar; ?></td></tr>
	    <tr><td>Idjenis</td><td><?php echo $idjenis; ?></td></tr>
	    <tr><td>Nominal</td><td><?php echo $nominal; ?></td></tr>
	    <tr><td>Bayar</td><td><?php echo $bayar; ?></td></tr>
	    <tr><td>Sisa</td><td><?php echo $sisa; ?></td></tr>
	    <tr><td>Idadmin</td><td><?php echo $idadmin; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('t103_nonrutin') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>