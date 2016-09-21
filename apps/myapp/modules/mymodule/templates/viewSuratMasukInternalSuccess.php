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
	  <h1>NOTA DINAS</h1>
	  <table>
	    <tr>
	  	  <td><label for="tanggal_surat">Tanggal | <i>Date</i></label></td>
	  	  <td>:</td>
	  	  <td><?php setlocale(LC_ALL, 'IND'); echo strftime('%d %B %Y', strtotime($_SESSION['tanggal_surat'])); ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="nomor_surat">Nomor | <i>Number</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['nomor_surat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="dari">Dari | <i>From</i></label></td>
	  	  <td>:</td>
	  	  <td>
	  	    <?php
	  	    
	  	    $connection = Propel::getConnection();
	  	    $query_a = "SELECT NAMA_JABATAN FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2` 
	  	    			ON t1.KD_JS = t2.KD_JS
	  	    			INNER JOIN `oasys_pegawai` AS `t3`
	  	   				ON t2.NIP = t3.NIP
	  	    			WHERE t3.NIP = '".$_SESSION['dari']."'";
	  	    $statement_a = $connection->prepareStatement($query_a);
	  	    $data_a = $statement_a->executeQuery();
	  	    
	  	    foreach ($data_a as $a)
	  	    {
	  	      echo $data_a->getString('NAMA_JABATAN');
	  	    }
	  	    
	  	    ?>
	  	  </td>
	    </tr>
	    <tr>
	  	  <td><label for="kepada">Kepada | <i>To</i></label></td>
	  	  <td>:</td>
	  	  <td>
	  	    <?php 
	  	    
	  	    $query_b = "SELECT NAMA_JABATAN FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2`
	  	    ON t1.KD_JS = t2.KD_JS
	  	    INNER JOIN `oasys_pegawai` AS `t3`
	  	    ON t2.NIP = t3.NIP
	  	    WHERE t3.NIP = '".$_SESSION['kepada']."'";
	  	    $statement_b = $connection->prepareStatement($query_b);
	  	    $data_b = $statement_b->executeQuery();
	  	    
	  	    foreach ($data_b as $a)
	  	    {
	  	      echo $data_b->getString('NAMA_JABATAN');
	  	    }
	  	    
	  	    ?>
	  	  </td>
	    </tr>
	    <tr>
	  	  <td><label for="perihal">Perihal | <i>Subject</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['perihal']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="tembusan">Tembusan | <i>CC</i></label></td>
	  	  <td>:</td>
	  	  <td>
	  	    <?php 
	  	    
	  	    if (!empty($_SESSION['tembusan']))
	  	    {
	  	      $query_c = "SELECT NAMA_JABATAN FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2`
	  	      ON t1.KD_JS = t2.KD_JS
	  	      INNER JOIN `oasys_pegawai` AS `t3`
	  	      ON t2.NIP = t3.NIP
	  	      WHERE t3.NIP = '".$_SESSION['tembusan']."'";
	  	      $statement_c = $connection->prepareStatement($query_c);
	  	      $data_c = $statement_c->executeQuery();
	  	    
	  	      foreach ($data_c as $a)
	  	      {
	  	    	echo $data_c->getString('NAMA_JABATAN');
	  	      };
	  	    }
	  	    else
	  	    {
	  	      echo '-';
	  	    }
	  	    ?>
	  	  </td>
	    </tr>
	    <tr>
	  	  <td><label for="lampiran">Lampiran | <i>Attachment</i></label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['nama_file']; ?></td>
	    </tr>
	  </table>
	  <br>
	  <table>
	    <tr><td><?php echo $_SESSION['isi_surat']; ?></td></tr>
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
	    
	  $query_d = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$_SESSION['dari']."'";
	  $statement_d = $connection->prepareStatement($query_d);
	  $data_d = $statement_d->executeQuery();
	     
	  foreach ($data_d as $a)
	  {
	    echo $data_d->getString('NAMA');
	  }
	   
	  ?>
	 </p>
	 </div>
	 <br>
	 <a href="#" class="print" rel="area">Print</a>
	 <input type="button" value="Disposisi" onclick="window.location.href='http://localhost:8181/myapp_dev.php/mymodule/formDisposisiSuratInternal?kd_surat=<?php echo $_SESSION['kd_surat']; ?>'">
	 <div id="pdf">
	   <object data="/<?php echo $_SESSION['direktori_file']; ?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	 </div>
	</body>
</html>