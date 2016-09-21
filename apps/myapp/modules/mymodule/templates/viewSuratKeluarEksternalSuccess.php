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
	  <div id="area">
	    <table>
	      <tr>
	  	    <td><label for="nomor_surat">Nomor</label></td>
	  	    <td>:</td>
	  	    <td><?php echo $_SESSION['nomor_surat']; ?></td>
	      </tr>
	      <tr>
	  	    <td><label for="perihal">Perihal</label></td>
	  	    <td>:</td>
	  	    <td><?php echo $_SESSION['perihal']; ?></td>
	      </tr>
	    </table><br>
	    <table>
		  <tr>
	  	    <td><?php setlocale(LC_ALL, 'IND'); echo strftime('Bandung, %d %B %Y', strtotime($_SESSION['tanggal_surat'])); ?></td>
	  	  </tr>
	    </table><br>
	    <table>
	      <tr>
	        <td>Kepada Yth.</td>
	      </tr>
	      <tr>
	        <td><?php echo $_SESSION['kepada']; ?></td>
	      </tr>
	      <tr>
	        <td><?php echo $_SESSION['alamat']; ?></td>
	      </tr>
	    </table><br><br>
	    <table>
	      <tr>
	  	    <td><?php echo $_SESSION['isi_surat']; ?></td>
	      </tr>
	    </table><br><br>
	    <table>
	      <tr>
	        <td>Hormat kami,</td>
	      </tr>
	    </table><br><br>
	    <table>
	      <tr>
	        <td>
	        <?php
	   
	        $connection = Propel::getConnection();
	        $query_a = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$_SESSION['dari']."'";
	        $statement_a = $connection->prepareStatement($query_a);
	        $data_a = $statement_a->executeQuery();
	   
	        foreach ($data_a as $a)
	        {
	          echo $data_a->getString('NAMA');
	        }
	   
	        ?>
	        </td>
	      </tr>
	      <tr>
	        <td>
	        <?php 
	   
	    	$query_b = "SELECT NAMA_JABATAN FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2`
	    				ON t1.KD_JS = t2.KD_JS
	    				INNER JOIN `oasys_pegawai` AS `t3`
	    				ON t2.NIP = t3.NIP
	    				WHERE t3.NIP = '".$_SESSION['dari']."'";
	    	$statement_b = $connection->prepareStatement($query_b);
	    	$data_b = $statement_b->executeQuery();
	   
	    	foreach ($data_b as $a)
	    	{
	   	  	  echo $data_b->getString('NAMA_JABATAN');
	    	}
	   
	   		?>
	        </td>
	      </tr>
	    </table>
	  </div>
	  <a href="#" class="print" rel="area">Print</a>
	  <div id="pdf">
	    <object data="/<?php echo $_SESSION['direktori_file']; ?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	  </div>
	</body>
</html>