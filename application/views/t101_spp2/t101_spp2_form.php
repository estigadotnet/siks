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
        <h2 style="margin-top:0px">T101_spp2 <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Idsiswa <?php echo form_error('idsiswa') ?></label>
            <input type="text" class="form-control" name="idsiswa" id="idsiswa" placeholder="Idsiswa" value="<?php echo $idsiswa; ?>" />
        </div>
	    <div class="form-group">
            <label for="date">Jatuhtempo <?php echo form_error('jatuhtempo') ?></label>
            <input type="text" class="form-control" name="jatuhtempo" id="jatuhtempo" placeholder="Jatuhtempo" value="<?php echo $jatuhtempo; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Bulan <?php echo form_error('bulan') ?></label>
            <input type="text" class="form-control" name="bulan" id="bulan" placeholder="Bulan" value="<?php echo $bulan; ?>" />
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
            <label for="int">Byrspp <?php echo form_error('byrspp') ?></label>
            <input type="text" class="form-control" name="byrspp" id="byrspp" placeholder="Byrspp" value="<?php echo $byrspp; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Byrcatering <?php echo form_error('byrcatering') ?></label>
            <input type="text" class="form-control" name="byrcatering" id="byrcatering" placeholder="Byrcatering" value="<?php echo $byrcatering; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Byrworksheet <?php echo form_error('byrworksheet') ?></label>
            <input type="text" class="form-control" name="byrworksheet" id="byrworksheet" placeholder="Byrworksheet" value="<?php echo $byrworksheet; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Ket <?php echo form_error('ket') ?></label>
            <input type="text" class="form-control" name="ket" id="ket" placeholder="Ket" value="<?php echo $ket; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Idadmin <?php echo form_error('idadmin') ?></label>
            <input type="text" class="form-control" name="idadmin" id="idadmin" placeholder="Idadmin" value="<?php echo $idadmin; ?>" />
        </div>
	    <input type="hidden" name="idspp" value="<?php echo $idspp; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('t101_spp2') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>