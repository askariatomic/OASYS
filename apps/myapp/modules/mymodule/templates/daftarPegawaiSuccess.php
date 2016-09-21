<?php 
  
$connection = Propel::getConnection();
$query = "SELECT t1.NAMA_INSTITUSI, t2.NAMA_JABATAN, t3.NIP, t4.NAMA 
		  FROM `oasys_institusi` AS `t1` INNER JOIN `oasys_jabatan_struktural` AS `t2` 
		  ON t1.KD_INSTITUSI = t2.KD_INSTITUSI
		  INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t3`
		  ON t2.KD_JS = t3.KD_JS
		  INNER JOIN `oasys_pegawai` AS `t4`
		  ON t3.NIP = t4.NIP";
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
		  <th>Institusi</th>
		  <th>Jabatan</th>
		  <th>NIP</th>
		  <th>Nama</th>
	    </tr>
	   </thead>
	   <tbody>
	  <?php foreach ($data as $a){ ?>
	    <tr>
		  <td><?php echo $data->getString('NAMA_INSTITUSI'); ?></td>
		  <td><?php echo $data->getString('NAMA_JABATAN'); ?></td>
		  <td><?php echo $data->getString('NIP'); ?></td>
		  <td><?php echo $data->getString('NAMA'); ?></td>		  
	    </tr>
	  <?php } ?>
	   </tbody>
	  </table>
	</body>
</html>