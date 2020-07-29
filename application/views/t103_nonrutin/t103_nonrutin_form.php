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
        <h2 style="margin-top:0px">T103_nonrutin <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Idsiswa <?php echo form_error('idsiswa') ?></label>
            <input type="text" class="form-control" name="idsiswa" id="idsiswa" placeholder="Idsiswa" value="<?php echo $idsiswa; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nobayar <?php echo form_error('nobayar') ?></label>
            <input type="text" class="form-control" name="nobayar" id="nobayar" placeholder="Nobayar" value="<?php echo $nobayar; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Tglbayar <?php echo form_error('tglbayar') ?></label>
            <input type="text" class="form-control" name="tglbayar" id="tglbayar" placeholder="Tglbayar" value="<?php echo $tglbayar; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Idjenis <?php echo form_error('idjenis') ?></label>
            <input type="text" class="form-control" name="idjenis" id="idjenis" placeholder="Idjenis" value="<?php echo $idjenis; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Nominal <?php echo form_error('nominal') ?></label>
            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Nominal" value="<?php echo $nominal; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Bayar <?php echo form_error('bayar') ?></label>
            <input type="text" class="form-control" name="bayar" id="bayar" placeholder="Bayar" value="<?php echo $bayar; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Sisa <?php echo form_error('sisa') ?></label>
            <input type="text" class="form-control" name="sisa" id="sisa" placeholder="Sisa" value="<?php echo $sisa; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Idadmin <?php echo form_error('idadmin') ?></label>
            <input type="text" class="form-control" name="idadmin" id="idadmin" placeholder="Idadmin" value="<?php echo $idadmin; ?>" />
        </div>
	    <input type="hidden" name="idnonrutin" value="<?php echo $idnonrutin; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('t103_nonrutin') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>