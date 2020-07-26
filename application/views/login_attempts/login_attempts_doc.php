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
        <h2>Login_attempts List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Ip Address</th>
		<th>Login</th>
		<th>Time</th>
		
            </tr><?php
            foreach ($login_attempts_data as $login_attempts)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $login_attempts->ip_address ?></td>
		      <td><?php echo $login_attempts->login ?></td>
		      <td><?php echo $login_attempts->time ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>