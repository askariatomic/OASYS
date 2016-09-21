<?php 

$connection = Propel::getConnection();

$query_a = "(SELECT t1.KD_SURAT, t1.NIP, t1.NOMOR_SURAT, t1.PERIHAL, t1.TANGGAL, t2.KD_STATUS
			FROM `oasys_surat_internal` AS `t1` INNER JOIN `oasys_kepada_surat_internal` AS `t2` 
			ON t1.KD_SURAT = t2.KD_SURAT 
			WHERE t2.KEPADA = '".$_SESSION['nip']."') UNION
			(SELECT t3.KD_SURAT, t3.NIP, t3.NOMOR_SURAT, t3.PERIHAL, t3.TANGGAL, t4.KD_STATUS
			FROM `oasys_surat_internal` AS `t3` INNER JOIN `oasys_tembusan_surat_internal` AS `t4` 
			ON t3.KD_SURAT = t4.KD_SURAT 
			WHERE t4.TEMBUSAN = '".$_SESSION['nip']."')";
$statement_a = $connection->prepareStatement($query_a);
$data_a = $statement_a->executeQuery();

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
	  <h3>Daftar Surat Masuk Internal</h3>
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
	  <?php foreach ($data_a as $a){ ?>
		<tr>
		  <td align="center">
		  <?php 
		  $kd_status = $data_a->getString('KD_STATUS'); 
		  
		  if ($kd_status == 'unread'){ ?>
		    <img src="/images/oasys_images/unread.png" />
		  <?php }else{ ?>
		    <img src="/images/oasys_images/read.png" />
		  <?php } ?>
		  </td>
		  <td>
		  <?php 
		  
		  $pengirim = $data_a->getString('NIP'); 
		  $query_b = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$pengirim."'";
		  $statement_b = $connection->prepareStatement($query_b);
		  $data_b = $statement_b->executeQuery();
		  
		  foreach ($data_b as $a)
		  {
		  	echo $data_b->getString('NAMA');
		  }
		  
		  ?>
		  </td>
		  <td><?php echo str_replace('@', '/', $data_a->getString('NOMOR_SURAT')); ?></td>
		  <td><?php echo $data_a->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data_a->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data_a->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><a target="_blank" href="viewSuratMasukInternal?kd_surat=<?php echo $data_a->getString('KD_SURAT') ?>&nip=<?php echo $_SESSION['nip'] ?>">Lihat</a></td> 
		</tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>