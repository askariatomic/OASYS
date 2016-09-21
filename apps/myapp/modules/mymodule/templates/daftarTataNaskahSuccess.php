<?php 
  
$connection = Propel::getConnection();
$query = "SELECT t1.BIDANG, t2.KATEGORI, t3.KD_KLASIFIKASI, t3.KLASIFIKASI
		  FROM `oasys_bidang` AS `t1` INNER JOIN `oasys_kategori` AS `t2`
		  ON t1.KD_BIDANG = t2.KD_BIDANG
  		  INNER JOIN `oasys_klasifikasi` AS `t3`
		  ON t2.KATEGORI = t3.KATEGORI";
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
	  <table id="myTable" class="display" cellpadding="0" cellspacing="0" border="0" style="width:100%">
	   <thead>
	    <tr>
		  <th>Bidang</th>
		  <th>Kategori</th>
		  <th>Kode Klasifikasi</th>
		  <th>Klasifikasi</th>
	    </tr>
	   </thead>
	   <tbody>
	  <?php foreach ($data as $a){ ?>
	    <tr>
		  <td><?php echo $data->getString('BIDANG'); ?></td>
		  <td><?php echo $data->getString('KATEGORI'); ?></td>
		  <td><?php echo $data->getString('KD_KLASIFIKASI'); ?></td>
		  <td><?php echo $data->getString('KLASIFIKASI'); ?></td>		  
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>