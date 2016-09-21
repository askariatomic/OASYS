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
	  	  <td><label for="dari">Dari</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['dari']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="alamat">Alamat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['alamat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="tanggal_surat">Tanggal Surat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['tanggal_surat']; ?></td>
	    </tr>
	    <tr>
	  	  <td><label for="sifat_surat">Sifat Surat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['sifat_surat']; ?></td>
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
	  	  <td><label for="komentar">Komentar</label></td>
	  	  <td>:</td>
	  	  <td><?php echo $_SESSION['komentar']; ?></td>
	    </tr>
	  </table>
	  <div id="pdf">
	    <object data="/<?php echo $_SESSION['direktori_file']; ?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	  </div>
	</body>
</html>