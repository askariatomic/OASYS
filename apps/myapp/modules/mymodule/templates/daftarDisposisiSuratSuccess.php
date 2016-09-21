<?php 

$connection = Propel::getConnection();
$query = "SELECT t1.KD_DISPOSISI, t1.NIP, t1.NOMOR_SURAT, t1.PERIHAL, t1.TANGGAL, t2.KD_STATUS
FROM `oasys_disposisi` AS `t1` INNER JOIN `oasys_kepada_disposisi` AS `t2`
ON t1.KD_DISPOSISI= t2.KD_DISPOSISI
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
	  <h3>Daftar Disposisi</h3>
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
		  <td><?php echo $data->getString('NIP'); ?></td>
		  <td><?php echo str_replace('@', '/', $data->getString('NOMOR_SURAT')); ?></td>
		  <td><?php echo $data->getString('PERIHAL'); ?></td>
		  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($data->getString('TANGGAL'))); ?></td>
		  <td><?php echo $data->getDate('TANGGAL', 'H:i:s'); ?></td>
		  <td><?php echo link_to('Lihat','mymodule/viewDisposisiSurat?kd_disposisi='.$data->getString('KD_DISPOSISI')); ?></td>
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>