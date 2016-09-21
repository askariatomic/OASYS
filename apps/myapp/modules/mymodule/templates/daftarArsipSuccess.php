<?php 
  
$connection = Propel::getConnection();
$query_a = "SELECT KD_ARSIP, NOMOR_DOKUMEN, KEPADA, PERIHAL, TANGGAL FROM `oasys_arsip` ORDER BY TANGGAL DESC";
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
	  <h3>Daftar Arsip</h3>
	  <table id="myTable" class="display" cellpadding="0" cellspacing="0" border="0" style="width:100%">
	   <thead>
	    <tr>
		  <th>Kepada</th>
		  <th>Nomor Surat</th>
		  <th>Perihal</th>
		  <th>Tanggal</th>
		  <th>Lihat</th>
	    </tr>
	   </thead>
	   <tbody>
	  <?php foreach ($data_a as $a){ ?>
	    <tr>
		  <td><?php echo $data_a->getString('KEPADA'); ?></td>
		  <td><?php echo $data_a->getString('NOMOR_DOKUMEN'); ?></td>
		  <td><?php echo $data_a->getString('PERIHAL'); ?></td>
		  <td><?php echo $data_a->getDate('TANGGAL', 'd-M-Y'); ?></td>
		  <td><a target="_blank" href="viewArsip?kd_arsip=<?php echo $data_a->getString('KD_ARSIP'); ?>">Lihat</a></td>		  
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>