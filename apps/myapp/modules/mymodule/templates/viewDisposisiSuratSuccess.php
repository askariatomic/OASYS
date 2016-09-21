<?php


?>

<html>
	<head>
	  <?php echo javascript_include_tag('pdfobject') ?>
	  <style type="text/css">
	  #pdf
	  {
	    height: 700px;
	  }
	  </style>
	</head>
	<body>
	 <h1>NOTA DINAS</h1>
	  <table>
	    <tr>
	  	  <td><label for="tanggal_surat">Tanggal | <i>Date</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['tanggal_surat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="nomor_surat">Nomor | <i>Number</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['nomor_surat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="dari">Dari | <i>From</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['dari']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="kepada">Kepada | <i>To</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['nip']; ?></td>
	    </tr>
	  </table>
	  <br>
	  <table>
	    <tr>
	  	  <td><?php echo $_SESSION['isi_surat']; ?></td>
	    </tr>
	    <tr>
	      <td></td>
	    </tr>
	  </table>
	  <br><br>
	  <p align="right">
	  <?php 	  	    
	    
	    foreach ($data_a as $a)
	  	{
	  	  echo $data_a->getString('NAMA_JABATAN');
	    } 
	    
	  ?>
	  </p>
	  <br><br>
	  <p align="right">
	    <?php 	  	    
	    
	    $connection = Propel::getConnection();
	    $query_d = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$_SESSION['dari']."'";
	    $statement_d = $connection->prepareStatement($query_d);
	    $data_d = $statement_d->executeQuery();
	    
	    foreach ($data_d as $a)
	    {
	      echo $data_d->getString('NAMA');
	    }
	    
	    ?>
	  <a href="#" class="print" rel="area">Print</a><input type="button" value="Disposisi" onclick="window.location.href='http://localhost:8181/myapp_dev.php/mymodule/formDisposisiSurat?nomor_surat=<?php echo str_replace('/', '@', $_SESSION['nomor_surat']) ?>'">
	 <div id="pdf">
	   <object data="/<?php echo $_SESSION['direktori_file'];?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	 </div>
	</body>
</html>