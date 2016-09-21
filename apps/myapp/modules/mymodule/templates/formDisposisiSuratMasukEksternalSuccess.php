<?php 

$connection = Propel::getConnection();
$query_one = "SELECT kd_institusi, nama_institusi FROM `oasys_institusi`";
$statement = $connection->prepareStatement($query_one);
$data_one = $statement->executeQuery();

$query_two = "SELECT kd_institusi, kd_js FROM `oasys_institusi` NATURAL JOIN `oasys_jabatan_struktural`";
$statement = $connection->prepareStatement($query_two);
$data_two = $statement->executeQuery();

?>

<html>
	<head>
	  <?php echo javascript_include_tag('oasys_js/pdfobject') ?>
	  <style type="text/css">
	  #pdf
	  {
	    height: 700px;
	  }
	  </style>
	  <?php echo javascript_include_tag('oasys_js/DynamicOptionList') ?>
	  <script type="text/javascript">

	    var makeModel = new DynamicOptionList("k_institusi", "k_jabatan", "k_nip");

	    <?php foreach ($data_one as $a){ ?>
	    makeModel.forValue("<?php $kd_institusi = $data_one->getString('kd_institusi'); echo $kd_institusi; ?>").
	    <?php 
	  	$query_three = "SELECT kd_js FROM `oasys_jabatan_struktural` WHERE kd_institusi = '".$kd_institusi."'";
	  	$statement = $connection->prepareStatement($query_three);
	  	$data_three = $statement->executeQuery();
	  	?>
	    addOptions(<?php foreach ($data_three as $b) { ?>"<?php $kd_jabatan = $data_three->getString('kd_js'); echo $kd_jabatan; ?>",<?php } ?>"");
        <?php } ?>

        <?php foreach ($data_two as $a){ ?>
        makeModel.forValue("<?php $kd_institusi = $data_two->getString('kd_institusi'); echo $kd_institusi; ?>").forValue("<?php $kd_jabatan = $data_two->getString('kd_js'); echo $kd_jabatan; ?>").
        <?php 
        $query_four = "SELECT nip, nama FROM `oasys_jabatan_struktural_pegawai` NATURAL JOIN `oasys_pegawai` WHERE kd_js = '".$kd_jabatan."' AND kd_ja > '".$_SESSION['kd_ja']."' AND nip NOT IN ('".$_SESSION['nip']."')";
        $statement = $connection->prepareStatement($query_four);
        $data_four = $statement->executeQuery();
        ?>
        addOptionsTextValue(<?php foreach ($data_four as $a) { ?>"<?php echo $data_four->getString('nama'); ?>", "<?php echo $data_four->getString('nip'); ?>", <?php } ?>"","");

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
        });
 	  </script>
	</head>
	<body onload="initDynamicOptionLists();">
	  <?php echo form_tag('mymodule/insDisposisiSurat', 'multipart=true') ?>  
		<table>
		  <tr>
	        <td></td>
	        <td></td>
	        <td><?php echo input_hidden_tag('kd_surat', $_SESSION['kd_surat'], 'size=50') ?></td>
	      </tr>
		  <tr>
	        <td><label for="dari">Dari</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['dari']; echo input_hidden_tag('dari', $_SESSION['dari'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td><label for="tanggal_masuk">Tanggal Masuk</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['tanggal_masuk']; echo input_hidden_tag('tanggal_masuk', $_SESSION['tanggal_masuk'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td><label for="tanggal_surat">Tanggal Surat</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['tanggal_surat']; echo input_hidden_tag('tanggal_surat', $_SESSION['tanggal_surat'], 'size=50'); ?></td>
	      </tr>
	      <tr>
	        <td><label for="sifat_surat">Sifat Surat</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['sifat_surat']; echo input_hidden_tag('sifat_surat', $_SESSION['sifat_surat'], 'size=50'); ?></td>
	      </tr>
	      <tr>
	        <td><label for="nomor_surat">Nomor Surat</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['nomor_surat']; echo input_hidden_tag('nomor_surat', $_SESSION['nomor_surat'], 'size=50'); ?></td>
	      </tr>
	      <tr>
	        <td><label for="perihal">Perihal</label></td>
	        <td>:</td>
	        <td><?php echo $_SESSION['perihal']; echo input_hidden_tag('perihal', $_SESSION['perihal'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td valign="top"><label for="komentar">Komentar</label></td>
	        <td valign="top">:</td>
	        <td><textarea id="komentar" name="komentar" style="width:100%"></textarea></td>
	      </tr>
	      <tr>
	      	<td><label for="kepada">Kepada</label></td>
	      	<td>:</td>
	      	<td>
	      	  <select name="k_institusi">
      		  <?php foreach ($data_one as $a){ ?>
      		    <option value='<?php echo $data_one->getString('kd_institusi'); ?>'><?php echo $data_one->getString('kd_institusi'); ?></option></br>
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
	        <td></td>
	        <td></td>
	        <td><?php echo input_hidden_tag('nama_file', $_SESSION['nama_file'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td></td>
	        <td></td>
	        <td><?php echo input_hidden_tag('ukuran_file', $_SESSION['ukuran_file'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td></td>
	        <td></td>
	        <td><?php echo input_hidden_tag('tipe_file', $_SESSION['tipe_file'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td></td>
	        <td></td>
	        <td><?php echo input_hidden_tag('direktori_file', $_SESSION['direktori_file'], 'size=50') ?></td>
	      </tr>
	      <tr>
	        <td colspan="2"><?php echo submit_tag('Kirim') ?></td>
	      </tr>
		</table>
		<div id="pdf">
	      <object data="/<?php echo $_SESSION['direktori_file']; ?>/<?php echo $_SESSION['nama_file']; ?>" type="application/pdf" width="100%" height="100%"></object>
	    </div>
	  </form>
	</body>
</html>