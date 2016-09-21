<?php

$connection = Propel::getConnection();
$query_one = "SELECT KD_SURAT, NOMOR_SURAT, PERIHAL, TANGGAL FROM `oasys_surat_keluar_eksternal` WHERE NIP = '".$_SESSION['nip']."' ORDER BY TANGGAL DESC";
$statement = $connection->prepareStatement($query_one);
$data_one = $statement->executeQuery();

?>

<html>
	<head>
	  <script type="text/javascript">
	    $(document).ready(function(){
		  $('#myTable').dataTable({
			"bJQueryUI": true,
			"sPaginationType":"full_numbers"
		  });
		}); 
	  </script>
	</head>
	<body>
	  <h3>Daftar Surat Keluar Eksternal</h3>
	  <table id="myTable" class="display" cellpadding="0" cellspacing="0" border="0" style="width:100%"> 
	   <thead>
	    <tr>
		  <th>Nomor Surat</th>
		  <th>Perihal</th>
		  <th>Tanggal</th>
		  <th>Waktu</th>
		  <th>Lihat</th>
	    </tr>
	   </thead>
	   <tbody>
	  <?php foreach ($data_one as $a){ ?>
	    <tr>
		  <td><?php echo str_replace('@', '/', $data_one->getString('NOMOR_SURAT')) ?></td>
		  <td><?php echo $data_one->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data_one->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data_one->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><a target="_blank" href="viewSuratKeluarEksternal?kd_surat=<?php echo $data_one->getString('KD_SURAT') ?>">Lihat</a></td>
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>