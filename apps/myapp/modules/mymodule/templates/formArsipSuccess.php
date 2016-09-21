<?php

$connection = Propel::getConnection();
$query = "SELECT KD_JENIS_DOKUMEN FROM `oasys_jenis_dokumen`";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();


?>

<html>
	<head>
	  <script type="text/javascript" src="/js/oasys_js/validate.js"></script>
	  <link rel="stylesheet" type="text/css"></link>
	  <style type="text/css">
	  #formArsip input.error{  
    	background: #f8dbdb;  
    	border-color: #e77776;  
	  }
	  
	  #formArsip span.error{  
    	color: #e46c6e;
      }
      
      #formArsip span{  
    	margin-left: 10px;  
    	color: #b1b1b1;  
    	font-size: 11px;  
    	font-style: italic;
      }
	  </style>
	</head>
	<body>
	  <h3>Arsip</h3>
	  <form method="post" id="formArsip" action="insArsip" enctype="multipart/form-data">
	    <table>
	      <tr>
		    <td><label for="tanggal">Tanggal</label></td>
		    <td>:</td>
		    <td><?php echo input_date_tag('tanggal', '', 'rich=true') ?></td>
		  </tr>
	      <tr>
		    <td><label for="nomor_dokumen">Nomor Dokumen</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('nomor_dokumen', '', 'size=50') ?></td>
		    <td><span id="info_nomor_dokumen"></span></td>
		  </tr>
		  <tr>
		    <td><label for="perihal">Perihal</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('perihal', '', 'size=50') ?></td>
		    <td><span id="info_perihal"></span></td>
		  </tr>
		  <tr>
		    <td><label for="kepada">Kepada</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('kepada', '', 'size=50') ?></td>
		    <td><span id="info_kepada"></span></td>
		  </tr>
		  <tr>
		    <td><label for="institusi">Institusi</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('institusi', '', 'size=50') ?></td>
		    <td><span id="info_institusi"></span></td>
		  </tr>
		  <tr>
		    <td><label for="alamat">Alamat</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('alamat', '', 'size=50') ?></td>
		    <td><span id="info_alamat"></span></td>
		  </tr>
		  <tr>
		    <td><label for="jenis_dokumen">Jenis Dokumen</label></td>
		    <td>:</td>
		    <td>
		      <select name="jenis_dokumen">
				<?php foreach ($data as $a){ ?>
      		    <option value='<?php echo $data->getString('KD_JENIS_DOKUMEN'); ?>'><?php echo $data->getString('KD_JENIS_DOKUMEN'); ?></option></br>
			    <?php } ?>
			  </select>
		    </td>
		  </tr>
		  <tr>
		    <td><label for="jumlah_dokumen">Jumlah Dokumen</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('jumlah_dokumen', '', 'size=50') ?></td>
		    <td><span id="info_jumlah_dokumen"></span></td>
		  </tr>
		  <tr>
		    <td><label for="dokumen">Dokumen</label></td>
		    <td>:</td>
		    <td><?php echo input_file_tag('dokumen') ?></td>
		  </tr>
		  <tr>
		    <td><label for="tanggal_masuk_dokumen">Tanggal Masuk Dokumen</label></td>
		    <td>:</td>
		    <td><?php echo input_date_tag('tanggal_masuk_dokumen', '', 'rich=true') ?></td>
		  </tr>
		  <tr>
		    <td><label for="tanggal_retensi">Tanggal Retensi</label></td>
		    <td>:</td>
		    <td><?php echo input_date_tag('tanggal_retensi', '', 'rich=true') ?></td>
		  </tr>
		  <tr>
		    <td><label for="lemari">Lemari</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('lemari', '', 'size=50') ?></td>
		    <td><span id="info_lemari"></span></td>
		  </tr>
		  <tr>
		    <td><label for="rak">Rak</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('rak', '', 'size=50') ?></td>
		    <td><span id="info_rak"></span></td>
		  </tr>
		  <tr>
		    <td><label for="folder">Folder</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('folder', '', 'size=50') ?></td>
		    <td><span id="info_folder"></span></td>
		  </tr>
		  <tr>
		    <td><label for="map">Map</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('map', '', 'size=50') ?></td>
		    <td><span id="info_map"></span></td>
		  </tr>
		  <tr>
		    <td><label for="posisi">Posisi</label></td>
		    <td>:</td>
		    <td><?php echo input_tag('posisi', '', 'size=50') ?></td>
		    <td><span id="info_posisi"></span></td>
		  </tr>
		  <tr>
      		<td colspan="2"><?php echo submit_tag('Kirim') ?></td>
		  </tr>
	    </table>
	  </form>
	</body>
</html>