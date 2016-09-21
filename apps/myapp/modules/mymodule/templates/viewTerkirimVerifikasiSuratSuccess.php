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
	  	  <td><label for="tanggal">Tanggal</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['tanggal']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="waktu">Waktu</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['tanggal']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="nomor_surat">Nomor Surat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['nomor_surat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="perihal">Perihal</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['perihal']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for=""></label></td>
	  	  <td></td>
	  	  <td><?php echo $_SESSION['isi_surat']; ?></td>
	    </tr>
	  </table>
	  <div id="pdf">
	    <object data="/<?php echo $_SESSION['direktori_file']; ?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	  </div>
	</body>
</html>