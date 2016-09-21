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

$query_nine = "SELECT KEPADA FROM `oasys_kepada_konsep_surat_internal` WHERE KD_SURAT = '".$_SESSION['kd_surat']."'";
$statement = $connection->prepareStatement($query_nine);
$data_nine = $statement->executeQuery();

$query_ten = "SELECT TEMBUSAN FROM `oasys_tembusan_konsep_surat_internal` WHERE KD_SURAT = '".$_SESSION['kd_surat']."'";
$statement = $connection->prepareStatement($query_ten);
$data_ten = $statement->executeQuery();
?>

<html>
	<head>
	  <?php echo use_javascript('oasys_js/action_konsep_internal.js') ?>
	  <?php echo use_javascript('oasys_js/pdfobject.js') ?>
	  <?php echo use_javascript('oasys_js/DynamicOptionList.js') ?>
	  <style type="text/css">
	  #pdf
	  {
	    height: 700px;
	  }
	  </style>
	  
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
	    makeModel.addDependentFields("t_institusi", "t_jabatan", "t_nip");

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
        $query_eight = "SELECT nip, nama FROM `oasys_jabatan_struktural_pegawai` NATURAL JOIN `oasys_pegawai` WHERE KD_JS = '".$kd_jabatan."' AND nip NOT IN ('".$_SESSION['nip']."')";
        $statement = $connection->prepareStatement($query_eight);
        $data_eight = $statement->executeQuery();
        ?>
        addOptionsTextValue(<?php foreach ($data_eight as $a) { ?>"<?php echo $data_eight->getString('nama'); ?>", "<?php echo $data_eight->getString('nip'); ?>", <?php } ?>"","");

        <?php } ?>   
	  </script>
	  
	  <script type="text/javascript">
 	 	$().ready(function() {
 	      $('#add_pengirim').click(function() {
 	        return !$('#select_pengirim option:selected').remove().appendTo('#pengirim');
 	      });
 	    		  
 	      $('#remove_pengirim').click(function() {
 	        return !$('#pengirim option:selected').remove().appendTo('#select4');
 	   	  });
 	 	 	
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
	 <form name="viewKonsepSuratKeluarInternal" method="post" enctype="multipart/form-data">
	  <table>
	  	<tr>
      	  <td></td>
      	  <td></td>
      	  <td><?php echo input_hidden_tag('kd_surat', $_SESSION['kd_surat'], 'size=50') ?></td>
    	</tr>
	    <tr>
	  	  <td><label for="tanggal_surat">Tanggal Surat</label></td>
	  	  <td>:</td>
	  	  <td><?php echo input_date_tag('tanggal_surat', $_SESSION['tanggal'], 'rich=true') ?></td>
	    </tr>
	    <tr>
		  <td><label for="sifat_surat">Sifat Surat</label></td>
		  <td>:</td>
		  <td>
		    <?php echo select_tag('sifat_surat', options_for_select(array(
		      'Umum' => 'UMUM',
		      'Rahasia' => 'RHS',
  			  'Rahasia Pribadi' => 'RHS-PRB',  				
			), $_SESSION['sifat_surat'])) ?>
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
	  	  <td><?php echo input_tag('perihal', $_SESSION['perihal'], 'size=50') ?></td>
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
    	  <td>
    	    <select multiple="multiple" name="kepada[]" id="kepada">
    	    <?php foreach ($data_nine as $a){ ?>
    	      <option value='<?php $kpd = $data_nine->getString('KEPADA'); echo $kpd;?>' selected="selected">
    	       <?php 
    	       $query_eleven = "SELECT nama FROM oasys_pegawai WHERE nip = '".$kpd."'";
    	       $statement = $connection->prepareStatement($query_eleven);
    	       $data_eleven = $statement->executeQuery();
    	       
    	       foreach ($data_eleven as $a){
    	         echo $data_eleven->getString('nama');
    	       }
    	       ?>
    	      </option>
    	    <?php } ?>
    	    </select><input type="button" id="remove_kepada" value="Remove" />
    	  </td>
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
      		<a target="_blank" href="daftarPegawai">Lihat</a>
		  </td>
		</tr>
		<tr>
		  <td></td>
    	  <td></td>
    	  <td>
    	    <select multiple="multiple" name="tembusan[]" id="tembusan">
    	    <?php foreach ($data_ten as $a){ ?>
    	      <option value="<?php $tmb = $data_ten->getString('TEMBUSAN'); echo $tmb; ?>" selected="selected">
    	        <?php 
    	        $query_twelve = "SELECT NAMA FROM oasys_pegawai WHERE NIP = '".$tmb."'";
    	        $statement = $connection->prepareStatement($query_twelve);
    	        $data_twelve = $statement->executeQuery();
    	       
    	        foreach ($data_twelve as $a){
    	          echo $data_twelve->getString('NAMA');
    	        }
    	        ?>
    	      </option>
    	    <?php } ?>
    	    </select><input type="button"  id="remove_tembusan" value="Remove" />
		</tr>
	    <tr>
	  	  <td><label for="pesan">Isi Surat</label></td>
	  	  <td>:</td>
	  	  <td><textarea id="isi_surat" name="isi_surat" style="width:100%"><?php echo $_SESSION['isi_surat']; ?></textarea></td>
	    </tr>
	    <tr>
	      <td></td>
	      <td></td>
	      <td><input type="button" name="kirim" value="Kirim" onclick="Kirim();" />
	      <input type="button" value="Hapus" onclick="window.location.href='http://localhost:8181/myapp_dev.php/mymodule/delKonsepSuratKeluarInternal?kd_surat=<?php echo $_SESSION['kd_surat']; ?>'"></td>
	    </tr>
	    <tr>
      	  <td><label for="lampiran">Lampiran</label></td>
      	  <td>:</td>
      	  <td><?php echo input_file_tag('lampiran') ?></td>
    	</tr>
	  </table>
	 </form>
	</body>
</html>