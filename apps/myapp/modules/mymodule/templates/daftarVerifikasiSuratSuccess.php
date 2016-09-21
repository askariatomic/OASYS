<?php 

$connection = Propel::getConnection();
$query = "SELECT t2.KD_STATUS, t1.KD_VERIFIKASI, t1.NIP, t1.NOMOR_SURAT, t1.PERIHAL, t1.TANGGAL 
FROM `oasys_verifikasi` AS `t1` INNER JOIN `oasys_kepada_verifikasi` AS `t2`
ON t1.KD_VERIFIKASI = t2.KD_VERIFIKASI
WHERE t2.KEPADA = '".$_SESSION['nip']."' ORDER BY t1.TANGGAL DESC";
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
	  <h3>Daftar Verifikasi</h3>
	  <table id="myTable" class="display" cellpadding="0" cellspacing="0" border="0" style="width:100%">
	   <thead>
	    <tr>
	      <th>Status</th>
	      <th>Dari</th>
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
	      <td align="center">
	      <?php 
	      $kd_status = $data->getString('KD_STATUS');
	      
	      if ($kd_status == 'unread'){ ?>
	        <img src="/images/oasys_images/unread.png" />
	      <?php }else{ ?>
	        <img src="/images/oasys_images/read.png" />
	      <?php } ?>
	      </td>
		  <td>
		  <?php 
		  
		  $nip = $data->getString('NIP');
		  $query_two = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$nip."'";
		  $statement = $connection->prepareStatement($query_two);
		  $data_two = $statement->executeQuery();
		  
		  foreach ($data_two as $a)
		  {
		  	echo $data_two->getString('NAMA');
		  }
		  
		  ?>
		  </td>
		  <td><?php echo str_replace('@', '/', $data->getString('NOMOR_SURAT')); ?></td>
		  <td><?php echo $data->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><a href="viewVerifikasiSurat?kd_verifikasi=<?php echo $data->getString('KD_VERIFIKASI') ?>">Lihat</a></td>
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>