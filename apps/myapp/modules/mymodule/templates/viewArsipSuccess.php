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
	  <table>
	    <tr>
	  	  <td><label for="nomor_dokumen">Nomor Dokumen</label></td>
	  	  <td>:</td>
	  	  <td><?php echo str_replace('@', '/', $_SESSION['nomor_dokumen']); ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="perihal">Perihal</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['perihal']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="kepada">Kepada</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['kepada']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="institusi">Institusi</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['institusi']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="alamat">Alamat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['alamat']; ?></td>
	    </tr>
	    <tr>
	      <td></td>
	      <td></td>
	      <td><input type="button" value="Hapus" onclick="window.location.href='http://localhost:8181/myapp_dev.php/mymodule/delArsip?kd_arsip=<?php echo $_SESSION['kd_arsip']; ?>'"></td>
	    </tr>
	  </table>
	  <div id="pdf">
	    <object data="/<?php echo $_SESSION['direktori_dokumen']; ?>/<?php echo $_SESSION['nama_dokumen']; ?>" type="application/pdf" width="100%" height="100%"></object>
	  </div>
	</body>
</html>