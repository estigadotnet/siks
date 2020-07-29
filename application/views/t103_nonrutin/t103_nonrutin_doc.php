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
        <h2>T103_nonrutin List</h2>
        <table class="word-table" style="margin-bottom: 10px">
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
		
            </tr><?php
            foreach ($t103_nonrutin_data as $t103_nonrutin)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $t103_nonrutin->idsiswa ?></td>
		      <td><?php echo $t103_nonrutin->nobayar ?></td>
		      <td><?php echo $t103_nonrutin->tglbayar ?></td>
		      <td><?php echo $t103_nonrutin->idjenis ?></td>
		      <td><?php echo $t103_nonrutin->nominal ?></td>
		      <td><?php echo $t103_nonrutin->bayar ?></td>
		      <td><?php echo $t103_nonrutin->sisa ?></td>
		      <td><?php echo $t103_nonrutin->idadmin ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>