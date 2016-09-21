<?php 

$connection = Propel::getConnection();

$query = "(SELECT t1.KD_SURAT, t1.DARI, t1.NOMOR_SURAT, t1.PERIHAL, t1.TANGGAL, t2.KD_STATUS 
		  FROM `oasys_surat_masuk_eksternal` AS `t1` INNER JOIN `oasys_kepada_surat_masuk_eksternal` AS `t2`
		  ON t1.KD_SURAT = t2.KD_SURAT 
		  WHERE t2.KEPADA = '".$_SESSION['nip']."') UNION
		  (SELECT t3.KD_SURAT, t3.DARI, t3.NOMOR_SURAT, t3.PERIHAL, t3.TANGGAL, t4.KD_STATUS 
		  FROM `oasys_surat_masuk_eksternal` AS `t3` INNER JOIN
		  `oasys_tembusan_surat_masuk_eksternal` AS `t4`
		  ON t3.KD_SURAT = t4.KD_SURAT 
		  WHERE t4.TEMBUSAN = '".$_SESSION['nip']."')";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

?>

<html>
	<head>
	 <meta http-equiv="refresh" content="60" />
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
	  <h3>Daftar Surat Masuk Eksternal</h3>
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
		  <td><?php echo $data->getString('DARI'); ?></td>
		  <td><?php echo $data->getString('NOMOR_SURAT'); ?></td>
		  <td><?php echo $data->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><a target="_blank" href="viewSuratMasukEksternal?kd_surat=<?php echo $data->getString('KD_SURAT'); ?>&nip=<?php echo $_SESSION['nip']; ?>">Lihat</a></td> 
		</tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>