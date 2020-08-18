<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>T101_spp2 List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idsiswa</th>
		<th>Jatuhtempo</th>
		<th>Bulan</th>
		<th>Nobayar</th>
		<th>Tglbayar</th>
		<th>Byrspp</th>
		<th>Byrcatering</th>
		<th>Byrworksheet</th>
		<th>Ket</th>
		<th>Idadmin</th>
		
            </tr><?php
            foreach ($t101_spp2_data as $t101_spp2)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $t101_spp2->idsiswa ?></td>
		      <td><?php echo $t101_spp2->jatuhtempo ?></td>
		      <td><?php echo $t101_spp2->bulan ?></td>
		      <td><?php echo $t101_spp2->nobayar ?></td>
		      <td><?php echo $t101_spp2->tglbayar ?></td>
		      <td><?php echo $t101_spp2->byrspp ?></td>
		      <td><?php echo $t101_spp2->byrcatering ?></td>
		      <td><?php echo $t101_spp2->byrworksheet ?></td>
		      <td><?php echo $t101_spp2->ket ?></td>
		      <td><?php echo $t101_spp2->idadmin ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>