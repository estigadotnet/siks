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
        <h2>T004_siswa List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nis</th>
		<th>Namasiswa</th>
		<th>Idkelas</th>
		<th>Tahunajaran</th>
		<th>Byrspp</th>
		<th>Byrcatering</th>
		<th>Byrworksheet</th>
		
            </tr><?php
            foreach ($t004_siswa_data as $t004_siswa)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $t004_siswa->nis ?></td>
		      <td><?php echo $t004_siswa->namasiswa ?></td>
		      <td><?php echo $t004_siswa->idkelas ?></td>
		      <td><?php echo $t004_siswa->tahunajaran ?></td>
		      <td><?php echo $t004_siswa->byrspp ?></td>
		      <td><?php echo $t004_siswa->byrcatering ?></td>
		      <td><?php echo $t004_siswa->byrworksheet ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>