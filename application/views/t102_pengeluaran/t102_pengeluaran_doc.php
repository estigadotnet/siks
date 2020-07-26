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
        <h2>T102_pengeluaran List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl</th>
		<th>Nobuk</th>
		<th>Keterangan</th>
		<th>Jumlah</th>
		
            </tr><?php
            foreach ($t102_pengeluaran_data as $t102_pengeluaran)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $t102_pengeluaran->tgl ?></td>
		      <td><?php echo $t102_pengeluaran->nobuk ?></td>
		      <td><?php echo $t102_pengeluaran->keterangan ?></td>
		      <td><?php echo $t102_pengeluaran->jumlah ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>