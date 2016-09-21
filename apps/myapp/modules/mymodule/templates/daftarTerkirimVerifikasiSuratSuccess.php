<?php 

$connection = Propel::getConnection();
$query = "SELECT KD_VERIFIKASI, NOMOR_SURAT, PERIHAL, TANGGAL FROM `oasys_verifikasi` WHERE NIP = '".$_SESSION['nip']."' ORDER BY TANGGAL DESC";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

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
	  <h3>Daftar Terkirim Verifikasi</h3>
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
	  <?php foreach ($data as $a){ ?>
	    <tr>  
		  <td><?php echo str_replace('@', '/', $data->getString('NOMOR_SURAT')); ?></td>
		  <td><?php echo $data->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><a target="_blank" href="viewTerkirimVerifikasiSurat?kd_verifikasi=<?php echo $data->getString('KD_VERIFIKASI') ?>">Lihat</a></td>
	    </tr>
	  <?php } ?>
       </tbody>
	  </table>
	</body>
</html>