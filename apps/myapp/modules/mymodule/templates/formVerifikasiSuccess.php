<?php 

$connection = Propel::getConnection();
$query_one = "SELECT KD_INSTITUSI, NAMA_INSTITUSI FROM `oasys_institusi`";
$statement = $connection->prepareStatement($query_one);
$data_one = $statement->executeQuery();

$query_two = "SELECT KD_INSTITUSI, KD_JS FROM `oasys_institusi` NATURAL JOIN `oasys_jabatan_struktural`";
$statement = $connection->prepareStatement($query_two);
$data_two = $statement->executeQuery();

$query_three = "SELECT KD_BIDANG FROM `oasys_bidang`";
$statement = $connection->prepareStatement($query_three);
$data_three = $statement->executeQuery();

$query_four = "SELECT KD_BIDANG, KATEGORI FROM `oasys_bidang` NATURAL JOIN `oasys_kategori`";
$statement = $connection->prepareStatement($query_four);
$data_four = $statement->executeQuery();

?>

<html>
	<head>
	  <?php echo javascript_include_tag('oasys_js/action_internal') ?>
	  <?php echo javascript_include_tag('oasys_js/DynamicOptionList') ?>
	  
	  <script type="text/javascript">
	  	var makeModel = new DynamicOptionList("bidang", "kategori", "klasifikasi");

	    <?php foreach ($data_three as $a){ ?>
	    makeModel.forValue("<?php $kd_bidang = $data_three->getString('KD_BIDANG'); echo $kd_bidang; ?>").
	    <?php 
	    $query_five = "SELECT KATEGORI FROM `oasys_kategori` WHERE KD_BIDANG = '".$kd_bidang."'";
	    $statement = $connection->prepareStatement($query_five);
	    $data_five = $statement->executeQuery();?>
	    addOptions(<?php foreach ($data_five as $a) { ?>"<?php $kategori = $data_five->getString('KATEGORI'); echo $kategori; ?>",<?php } ?>"");
	    <?php } ?>

	    <?php foreach ($data_four as $a){ ?>
	    makeModel.forValue("<?php echo $data_four->getString('KD_BIDANG'); ?>").forValue("<?php $kategori = $data_four->getString('KATEGORI'); echo $kategori; ?>").
	    <?php 
		$query_six = "SELECT KD_KLASIFIKASI FROM `oasys_klasifikasi` WHERE KATEGORI = '".$kategori."'";
		$statement = $connection->prepareStatement($query_six);
		$data_six = $statement->executeQuery();
		?>
	    addOptions(<?php foreach ($data_six as $a){ ?>"<?php echo $data_six->getString('KD_KLASIFIKASI'); ?>",<?php } ?>"");
	    <?php } ?>
	  </script>
	  
	  <script type="text/javascript">
	    var makeModel = new DynamicOptionList("k_institusi", "k_jabatan", "k_nip");

	    <?php foreach ($data_one as $a){ ?>
	    makeModel.forValue("<?php $kd_institusi = $data_one->getString('KD_INSTITUSI'); echo $kd_institusi; ?>").
	    <?php 
	  	$query_seven = "SELECT KD_JS FROM `oasys_jabatan_struktural` WHERE KD_INSTITUSI = '".$kd_institusi."'";
	  	$statement = $connection->prepareStatement($query_seven);
	  	$data_seven = $statement->executeQuery();?>
	    addOptions(<?php foreach ($data_seven as $a) { ?>"<?php $kd_jabatan = $data_seven->getString('KD_JS'); echo $kd_jabatan; ?>",<?php } ?>"");
        <?php } ?>

        <?php foreach ($data_two as $a){ ?>
          
        makeModel.forValue("<?php $kd_institusi = $data_two->getString('KD_INSTITUSI'); echo $kd_institusi; ?>").forValue("<?php $kd_jabatan = $data_two->getString('KD_JS'); echo $kd_jabatan; ?>").
        <?php 
        $query_eight = "SELECT NIP, NAMA FROM `oasys_jabatan_struktural_pegawai` NATURAL JOIN `oasys_pegawai` WHERE KD_JS = '".$kd_jabatan."'";
        $statement = $connection->prepareStatement($query_eight);
        $data_eight = $statement->executeQuery();
        ?>
        addOptionsTextValue(<?php foreach ($data_eight as $a) { ?>"<?php echo $data_eight->getString('NAMA'); ?>", "<?php echo $data_eight->getString('NIP'); ?>", <?php } ?>"","");

        <?php } ?>   
	  </script>
	  
	  <script type="text/javascript">
 	 	$().ready(function() {	 	 	
   		  $('#add_kepada').click(function() {
    	    return !$('#select_kepada option:selected').remove().appendTo('#kepada');
   		  });
   		  
   		  $('#remove_kepada').click(function() {
    	    return !$('#kepada option:selected').remove().appendTo('#select5');
  		  });
  		  
   		  $('#add_tembusan').click(function() {
    	    return !$('#select_tembusan option:selected').remove().appendTo('#tembusan');
   		  });
   		  
   		  $('#remove_tembusan').click(function() {
    	    return !$('#tembusan option:selected').remove().appendTo('#select6');
  		  });
  		});
	  </script>
	</head>
	<body onload="initDynamicOptionLists();">
	  <h3>Verifikasi Surat</h3>
      <form name="formSuratKeluarInternal" method="post" enctype="multipart/form-data">
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
				<?php foreach ($data_three as $a){ ?>
      		    <option value='<?php echo $data_three->getString('KD_BIDANG'); ?>'><?php echo $data_three->getString('KD_BIDANG'); ?></option></br>
			    <?php } ?>
			  </select>
			  <select name="kategori">
				<script language="JavaScript">makeModel.printOptions("kategori")</script>
			  </select>
			  <select name="klasifikasi">
			    <script language="JavaScript">makeModel.printOptions("klasifikasi")</script>
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
      		  <select name="k_institusi">
      		  <?php foreach ($data_one as $a){ ?>
      		    <option value='<?php echo $data_one->getString('KD_INSTITUSI'); ?>'><?php echo $data_one->getString('KD_INSTITUSI'); ?></option></br>
			  <?php } ?>
			  </select>
      		  <select name="k_jabatan">
      		    <script language="JavaScript">makeModel.printOptions("JABATAN")</script>
      		  </select>
      		  <select name="k_nip" id="select_kepada">
      		    <script language="JavaScript">makeModel.printOptions("NIP")</script>
      		  </select>
      		  <input type="button" id="add_kepada" value="Add" />
      		  <a target="_blank" href="daftarPegawai">Lihat</a>	
      		</td>
	      </tr>
	      <tr>
	        <td></td>
    	    <td></td>
    	    <td><select multiple="multiple" name="kepada[]" id="kepada"></select><input type="button" id="remove_kepada" value="Remove" /></td>
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
		    <td><input type="button" name="verifikasi" value="Verifikasi" onclick="Verifikasi();" /></td>
		  </tr>
		</table>
	  </form>
	</body>
</html>