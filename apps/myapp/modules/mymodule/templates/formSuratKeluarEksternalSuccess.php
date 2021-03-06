<?php 

$connection = Propel::getConnection();
$query_one = "SELECT KD_BIDANG FROM `oasys_bidang`";
$statement = $connection->prepareStatement($query_one);
$data_one = $statement->executeQuery();

$query_two = "SELECT KD_BIDANG, KATEGORI FROM `oasys_bidang` NATURAL JOIN `oasys_kategori`";
$statement = $connection->prepareStatement($query_two);
$data_two = $statement->executeQuery();

$connection = Propel::getConnection();
$query = "SELECT KD_INSTITUSI, NAMA_INSTITUSI FROM `oasys_institusi`";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

$query_t = "SELECT KD_INSTITUSI, KD_JS FROM `oasys_institusi` NATURAL JOIN `oasys_jabatan_struktural`";
$statement = $connection->prepareStatement($query_t);
$data_t = $statement->executeQuery();
?>

<html>
	<head>
	  <?php echo use_javascript('oasys_js/action_eksternal.js') ?>
      <?php echo use_javascript('oasys_js/DynamicOptionList.js') ?>
	  
	  <script type="text/javascript">

	  	var makeModel = new DynamicOptionList("bidang", "kategori", "klasifikasi");

	    <?php foreach ($data_one as $a){ ?>
	    makeModel.forValue("<?php $kd_bidang = $data_one->getString('KD_BIDANG'); echo $kd_bidang; ?>").
	    <?php 
	    $query_three = "SELECT KATEGORI FROM `oasys_kategori` WHERE KD_BIDANG = '".$kd_bidang."'";
	    $statement = $connection->prepareStatement($query_three);
	    $data_three = $statement->executeQuery();?>
	    addOptions(<?php foreach ($data_three as $b) { ?>"<?php $kategori = $data_three->getString('KATEGORI'); echo $kategori; ?>",<?php } ?>"");
	    <?php } ?>

	    <?php foreach ($data_two as $a){ ?>
	    makeModel.forValue("<?php echo $data_two->getString('KD_BIDANG'); ?>").forValue("<?php $kategori = $data_two->getString('KATEGORI'); echo $kategori; ?>").
		<?php 
		$query_four = "SELECT CONCAT(KD_KLASIFIKASI, ' - ', KLASIFIKASI) AS `KLS`, KD_KLASIFIKASI FROM `oasys_klasifikasi` WHERE KATEGORI = '".$kategori."'";
		$statement = $connection->prepareStatement($query_four);
		$data_four = $statement->executeQuery();
		?>
	    addOptionsTextValue(<?php foreach ($data_four as $a){ ?>"<?php echo $data_four->getString('KLS'); ?>", "<?php echo $data_four->getString('KD_KLASIFIKASI'); ?>", <?php } ?>"","");
	    <?php } ?>
	    
	  </script>
	  
	  <script type="text/javascript">
 	 	$().ready(function() {	 	 	  	 		
   		  $('#add_kepada').click(function() {
   			var kepada = $('#input_kepada').val();
   			$('#input_kepada').val("");
    	    return !$('<option value="'+ kepada +'" selected="selected">'+ kepada +'</option>').remove().appendTo('#kepada');
   		  });
   		  $('#remove_kepada').click(function() {
    	    return !$('#kepada option:selected').remove().appendTo('#select5');
  		  });
   		  $('#add_tembusan').click(function(){		
   			var tembusan = $('#input_tembusan').val();
   			$('#input_tembusan').val("");
    	    return !$('<option value="'+ tembusan +'" selected="selected">'+ tembusan +'</option>').remove().appendTo('#tembusan');
   		  });
   		  $('#remove_tembusan').click(function() {
    	    return !$('#tembusan option:selected').remove().appendTo('#select6');
  		  });
   		  $('#add_email').click(function(){		
     		var email = $('#input_email').val();
     		$('#input_email').val("");
      	    return !$('<option value="'+ email +'" selected="selected">'+ email +'</option>').remove().appendTo('#email');
     		  });
     	  $('#remove_email').click(function() {
      	    return !$('#email option:selected').remove().appendTo('#select6');
    	  });
  		});
	  </script>
	</head>
	<body onload="initDynamicOptionLists();">
	  <h3>Surat Keluar Eksternal</h3>
	  <form name="formSuratKeluarEksternal" method="post" enctype="multipart/form-data">
	    <table>
	      <tr>
      		<td><label for="tanggal_surat">Tanggal Surat</label></td>
      		<td>:</td>
      		<td><?php echo input_date_tag('tanggal_surat', '', 'rich=true') ?></td>
    	  </tr>
    	  <tr>
		    <td><label for="sifat_surat">Sifat Surat</label></td>
		    <td>:</td>
		    <td>
		      <?php echo select_tag('sifat_surat', options_for_select(array(
		      	'Umum' => 'UMUM',
		      	'Rahasia' => 'RHS',
  				'Rahasia Pribadi' => 'RHS-PRB', 				
			  ), 'Umum')) ?>
		    </td>
		  </tr>
    	  <tr>
      		<td><label for="nomor_surat">Nomor Surat</label></td>
      		<td>:</td>
      		<td>
      		  <select name="bidang">
				<?php foreach ($data_one as $a){ ?>
      		    <option value='<?php echo $data_one->getString('KD_BIDANG'); ?>'><?php echo $data_one->getString('KD_BIDANG'); ?></option></br>
			    <?php } ?>
			  </select>
			  <select name="kategori">
				<script language="JavaScript">makeModel.printOptions("kategori");</script>
			  </select>
			  <select name="klasifikasi">
			    <script language="JavaScript">makeModel.printOptions("klasifikasi");</script>
			  </select>
			  <a target="_blank" href="daftarTataNaskah">Lihat</a>
      		</td>
    	  </tr>
    	  <tr>
      		<td><label for="perihal">Perihal</label></td>
      		<td>:</td>
      		<td><?php echo input_tag('perihal', '', 'size=50') ?></td>
    	  </tr>
    	  <tr>
      		<td><label for="kepada">Kepada</label></td>
      		<td>:</td>
      		<td>
      		  <input type="text" name="input_kepada" id="input_kepada" />
      		  <input type="button" name="add_kepada" id="add_kepada" value="Add" />
      		</td>
    	  </tr>
    	  <tr>
    	    <td></td>
    	    <td></td>
    	    <td>
    	      <select multiple="multiple" name="kepada[]" id="kepada"></select>
    	      <input type="button" name="remove_kepada" id="remove_kepada" value="Remove" />
    	    </td>
    	  </tr>
    	  <tr>
      		<td><label for="tembusan">Tembusan</label></td>
      		<td>:</td>
     		<td>
     		  <input type="text" name="input_tembusan" id="input_tembusan" />
      		  <input type="button" name="add_tembusan" id="add_tembusan" value="Add" />
     		</td>
    	  </tr>
    	  <tr>
    	    <td></td>
    	    <td></td>
    	    <td>
    	      <select multiple="multiple" name="tembusan[]" id="tembusan"></select>
    	      <input type="button" name="remove_tembusan" id="remove_tembusan" value="Remove" />
    	    </td>
    	  </tr>
    	  <tr>
      		<td><label for="alamat">Alamat</label></td>
      		<td>:</td>
      		<td><?php echo input_tag('alamat', '', 'size=50') ?></td>
    	  </tr>
    	  <tr>
      		<td><label for="email">Email</label></td>
      		<td>:</td>
      		<td>
      		  <input type="text" name="input_email" id="input_email" />
      		  <input type="button" name="add_email" id="add_email" value="Add" />
      		</td>
    	  </tr>
    	  <tr>
    	    <td></td>
    	    <td></td>
    	    <td>
    	      <select multiple="multiple" name="email[]" id="email" ></select>
    	      <input type="button" name="remove_email" id="remove_email"  value="Remove" />
    	    </td>
    	  </tr>
    	  <tr>
      		<td valign="top"><label for="isi_surat">Isi Surat</label></td>
      		<td valign="top">:</td>
      		<td><textarea id="isi_surat" name="isi_surat" style="width:100%"></textarea></td>
      	  </tr>  
    	  <tr>
      		<td><label for="lampiran">Lampiran</label></td>
      		<td>:</td>
      		<td><?php echo input_file_tag('lampiran') ?></td>
    	  </tr>
    	  <tr>
    	    <td></td>
    	    <td></td>
      		<td colspan="2"><input type="button" name="kirim" value="Kirim" onclick="Kirim();" /><input type="button" name="simpan" value="Simpan" onclick="Simpan();" /><input type="button" name="verifikasi" value="Verifikasi" onclick="Verifikasi();" /></td>
    	  </tr>
		</table>
	  </form>
	</body>
</html>