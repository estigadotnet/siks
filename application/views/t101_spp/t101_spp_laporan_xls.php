<?php
	// include "koneksi.php";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Pembayaran_Minu_Karakter.xls");
?>
	<h3 align="center">LAPORAN PEMBAYARAN SEKOLAH<br/><?php echo $this->session->userdata("namasekolah"); ?></h3>
  <p align="center">Periode : <?php echo date_format(date_create($tgl1), "d-m-Y") . " s.d.  " . date_format(date_create($tgl2), "d-m-Y"); ?></p>
	<table width="100%" border="1" cellspacing="0" cellpadding="4">
		<tr>
			<th>No.</th>
			<th>NIS</th>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>No. Bayar</th>
			<th>Tgl. Bayar</th>
			<th>Pembayaran Bulan</th>
			<th>Biaya SPP</th>
			<th>Biaya Catering</th>
			<th>Biaya Worksheet</th>
			<th>Keterangan</th>
		</tr>
		<?php
			//$sqlBayar = mysqli_query($konek, "SELECT spp.*,siswa.nis,siswa.namasiswa,b.kelas FROM spp INNER JOIN siswa ON spp.idsiswa=siswa.idsiswa left join walikelas b on siswa.idkelas = b.idkelas WHERE tglbayar BETWEEN '$_GET[tgl1]' AND '$_GET[tgl2]' ORDER BY nobayar ASC");
			$no = 1;
			$total1 = 0;
			$total2 = 0;
			$total3 = 0;
			// while($d=mysqli_fetch_array($sqlBayar)){
      foreach($aDataByr as $d) {
				echo "<tr>
					<td align='center'>$no</td>
					<td align='center'>$d[nis]</td>
					<td>$d[namasiswa]</td>
					<td align='center'>$d[kelas]</td>
					<td align='center'>$d[nobayar]</td>
					<td align='center'>".date_format(date_create($d["tglbayar"]), "d-m-Y")."</td>
					<td>$d[bulan]</td>
					<td align='right'>".number_format($d["byrspp"])."</td>
					<td align='right'>".number_format($d["byrcatering"])."</td>
					<td align='right'>".number_format($d["byrworksheet"])."</td>
					<td>$d[ket]</td>
				</tr>";
				$no++;
				$total1 +=$d['byrspp'];
				$total2 +=$d['byrcatering'];
				$total3 +=$d['byrworksheet'];
			}
		?>
		<tr>
			<td colspan="7" align="right">Total</td>
			<td align="right"><b><?php echo number_format($total1); ?></b></td>
			<td align="right"><b><?php echo number_format($total2); ?></b></td>
			<td align="right"><b><?php echo number_format($total3); ?></b></td>
			<td></td>
		</tr>
	</table>
	<table>
		<tr>
			<td></td>
			<td width="200px">
				<p>Bojonegoro, <?php echo date('d-m-Y'); ?><br/>
				Petugas</p>
				<br/>
				<br/>
				<p>____________________</p>
			</td>
		</tr>
	</table>
