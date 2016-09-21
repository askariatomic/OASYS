<?php 

$connection = Propel::getConnection();
$query_one = "SELECT KD_INSTITUSI, NAMA_INSTITUSI FROM `oasys_institusi`";
$statement = $connection->prepareStatement($query_one);
$data_one = $statement->executeQuery();

$query_two = "SELECT KD_INSTITUSI, KD_JS FROM `oasys_institusi` NATURAL JOIN `oasys_jabatan_struktural`";
$statement = $connection->prepareStatement($query_two);
$data_two = $statement->executeQuery();

?>

<html>
	<head>
	  <?php use_javascript('oasys_js/DynamicOptionList.js'); ?>
	  <script type="text/javascript">
	    var makeModel = new DynamicOptionList("k_institusi", "k_jabatan", "k_nip");
	    makeModel.addDependentFields("t_institusi", "t_jabatan", "t_nip");

	    <?php foreach ($data_one as $a){ ?>
	    makeModel.forValue("<?php $kd_institusi = $data_one->getString('KD_INSTITUSI'); echo $kd_institusi; ?>").
	    <?php 
	  	$query_three = "SELECT KD_JS FROM `oasys_jabatan_struktural` WHERE KD_INSTITUSI = '".$kd_institusi."'";
	  	$statement = $connection->prepareStatement($query_three);
	  	$data_three = $statement->executeQuery();?>
	    addOptions(<?php foreach ($data_three as $a) { ?>"<?php $kd_jabatan = $data_three->getString('KD_JS'); echo $kd_jabatan; ?>",<?php } ?>"");
        <?php } ?>

        <?php foreach ($data_two as $a){ ?>
          
        makeModel.forValue("<?php $kd_institusi = $data_two->getString('KD_INSTITUSI'); echo $kd_institusi; ?>").forValue("<?php $kd_jabatan = $data_two->getString('KD_JS'); echo $kd_jabatan; ?>").
        <?php 
        $query_four = "SELECT NIP, NAMA FROM `oasys_jabatan_struktural_pegawai` NATURAL JOIN `oasys_pegawai` WHERE KD_JS = '".$kd_jabatan."'";
        $statement = $connection->prepareStatement($query_four);
        $data_four = $statement->executeQuery();?>
        addOptionsTextValue(<?php foreach ($data_four as $a) { ?>"<?php echo $data_four->getString('NAMA'); ?>", "<?php echo $data_four->getString('NIP'); ?>", <?php } ?>"","");
        <?php } ?>
	  </script>
	  <script type="text/javascript">
 	 	$().ready(function() {
   		  $('#add_kepada').click(function() {
    		return !$('#select_kepada option:selected').remove().appendTo('#kepada');
   		  });
   		  
   		  $('#remove_kepada').click(function() {
    		return !$('#kepada option:selected').remove().appendTo('#select1');
   		  });
   		  
    	  $('#add_tembusan').click(function() {
        	return !$('#select_tembusan option:selected').remove().appendTo('#tembusan');
       	  });
       	  
       	  $('#remove_tembusan').click(function() {
        	return !$('#tembusan option:selected').remove().appendTo('#select3');
  		  });
        });
 	  </script>
	</head>
	<body onload="initDynamicOptionLists();">
	  <h3>Surat Masuk Eksternal</h3>
	  <?php echo form_tag('mymodule/insSuratMasukEksternal', 'multipart=true') ?> 
	    <table>
          <tr>
            <td><label for="dari">Dari</label></td>
            <td>:</td>
            <td><?php echo input_tag('dari', '', 'size=50') ?></td>
          </tr>
          <tr>
      		<td><label for="alamat">Alamat</label></td>
      		<td>:</td>
      		<td><?php echo input_tag('alamat', '', 'size=50') ?></td>
    	  </tr>
          <tr>
      		<td><label for="tanggal_diterima">Tanggal Diterima</label></td>
      		<td>:</td>
      		<td><?php echo input_date_tag('tanggal_diterima', '', 'rich=true') ?></td>
    	  </tr>
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
      		<td><?php echo input_tag('nomor_surat', '', 'size=50') ?></td>
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
      		</td>
    	  </tr>
    	  <tr>
	        <td></td>
    	    <td></td>
    	    <td><select multiple="multiple" name="kepada[]" id="kepada"></select><input type="button" id="remove_kepada" value="Remove" /></td>
	      </tr>
    	  <tr>
      		<td><label for="tembusan">Tembusan</label></td>
      		<td>:</td>
      		<td>
      		  <select name="t_institusi">
      		  <?php foreach ($data_one as $a){ ?>
      		    <option value='<?php echo $data_one->getString('KD_INSTITUSI'); ?>'><?php echo $data_one->getString('KD_INSTITUSI'); ?></option></br>
			  <?php } ?>
			  </select>
      		  <select name="t_jabatan">
      		    <script language="JavaScript">makeModel.printOptions("JABATAN")</script>
      		  </select>
      		  <select name="t_nip" id="select_tembusan">
      		    <script language="JavaScript">makeModel.printOptions("NIP")</script>
      		  </select>
      		  <input type="button" id="add_tembusan" value="Add" />
      		</td>
    	  </tr>
    	  <tr>
		    <td></td>
    	    <td></td>
    	    <td><select multiple="multiple" name="tembusan[]" id="tembusan"></select><input type="button" id="remove_tembusan" value="Remove"/></td>
		  </tr>
    	  <tr>
      		<td valign="top"><label for="komentar">Komentar</label></td>
      		<td valign="top">:</td>
      		<td><textarea id="komentar" name="komentar" style="width:100%"></textarea></td>
    	  </tr>
    	  <tr>
      		<td><label for="lampiran">Lampiran</label></td>
      		<td>:</td>
      		<td><?php echo input_file_tag('lampiran') ?></td>
    	  </tr>
    	  <tr>
      		<td colspan="2"><?php echo submit_tag('Kirim') ?></td>
		  </tr>
	    </table>
	  </form>
	</body>
</html>