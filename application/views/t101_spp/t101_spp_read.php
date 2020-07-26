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
        <h2 style="margin-top:0px">T101_spp Read</h2>
        <table class="table">
	    <tr><td>Idsiswa</td><td><?php echo $idsiswa; ?></td></tr>
	    <tr><td>Jatuhtempo</td><td><?php echo $jatuhtempo; ?></td></tr>
	    <tr><td>Bulan</td><td><?php echo $bulan; ?></td></tr>
	    <tr><td>Nobayar</td><td><?php echo $nobayar; ?></td></tr>
	    <tr><td>Tglbayar</td><td><?php echo $tglbayar; ?></td></tr>
	    <tr><td>Byrspp</td><td><?php echo $byrspp; ?></td></tr>
	    <tr><td>Byrcatering</td><td><?php echo $byrcatering; ?></td></tr>
	    <tr><td>Byrworksheet</td><td><?php echo $byrworksheet; ?></td></tr>
	    <tr><td>Ket</td><td><?php echo $ket; ?></td></tr>
	    <tr><td>Idadmin</td><td><?php echo $idadmin; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('t101_spp') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>