<?php

/**
 * mymodule actions.
 *
 * @package    myproject
 * @subpackage mymodule
 * @author     Muhammad Askari
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class mymoduleActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    //$this->forward('default', 'module');
    $this->setLayout('layout');
  }
  
  public function executeFormLogin()
  {
    session_destroy();
    $this->setLayout('login_layout');
  }
  
  public function executeCheckLogin()
  {
  	$username = $this->getRequestParameter('username');
  	$password = $this->getRequestParameter('password');
  	 
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_akun_pegawai` WHERE NIP = '".$username."' AND PASSWORD = '".$password."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	 
  	foreach ($data_a as $a)
  	{
      $nip = $data_a->getString('NIP');
  	  $pass = $data_a->getString('PASSWORD');			
  	}
  	 
  	if(!empty($nip) && !empty($pass))
  	{
  	  $_SESSION['nip'] = $nip;
  	  
  	  $query_b = "SELECT t1.KD_INSTITUSI, t1.NAMA_JABATAN, t1.UNIT, t2.KD_JA, t3.NAMA 
		  		  FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2` 
		  		  ON t1.KD_JS = t2.KD_JS
		  		  INNER JOIN `oasys_pegawai` AS `t3`
		  		  ON t2.NIP = t3.NIP WHERE t3.NIP = '".$nip."'";
  	  $statement_b = $connection->prepareStatement($query_b);
  	  $data_b = $statement_b->executeQuery();
  	  
  	  foreach ($data_b as $a)
  	  {
  	  	$kd_institusi = $data_b->getString('KD_INSTITUSI');
  	  	$nama_jabatan = $data_b->getString('NAMA_JABATAN');
  	  	$unit = $data_b->getString('UNIT');
  	  	$kd_ja = $data_b->getString('KD_JA');
  	  	$nama = $data_b->getString('NAMA');
  	  }
  	  
  	  $_SESSION['kd_institusi'] = $kd_institusi;
  	  $_SESSION['nama_jabatan'] = $nama_jabatan;
  	  $_SESSION['unit'] = $unit;
  	  $_SESSION['kd_ja'] = $kd_ja;
  	  $_SESSION['nama'] = $nama;
  	  
  	  $this->redirect('mymodule/index');
  	}
  	else
  	{
  	  $this->redirect('mymodule/formLogin');
  	}
  }
  
  public function executeDaftarTerkirimVerifikasiSurat()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarVerifikasiSurat()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeFormVerifikasi()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsVerifikasiSurat()
  {
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$klasifikasi = $this->getRequestParameter('klasifikasi');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_verifikasi';
  
  	$connection = Propel::getConnection();
  	
  	$this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  
  	$query_a = "INSERT INTO `oasys_verifikasi` (KD_VERIFIKASI, NIP, TANGGAL, TANGGAL_SURAT, SIFAT_SURAT, NOMOR_SURAT, PERIHAL, ISI_SURAT, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$tanggal_surat', '$sifat_surat', '/' '$klasifikasi' '/' '".$_SESSION['unit']."' '/' '12', '$perihal', '$isi_surat', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT KD_VERIFIKASI FROM `oasys_verifikasi` WHERE NOMOR_SURAT = '/' '".$klasifikasi."' '/' '".$_SESSION['unit']."' '/' '12'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kd_verifikasi = $data_b->getString('KD_VERIFIKASI');
  	}
  	
  	if (count($temp_kepada) > 0)
  	{
  	  foreach ($temp_kepada as $kepada)
  	  {
  		$query_c = "INSERT INTO `oasys_kepada_verifikasi` (KD_KEPADA_VERIFIKASI, KD_STATUS, KD_VERIFIKASI, KEPADA) VALUES ('', 'unread', '$kd_verifikasi', '$kepada')";
  		$statement_c = $connection->prepareStatement($query_c);
  		$data_c = $statement_c->executeUpdate();
  	  }
  	}
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarTerkirimVerifikasiSurat');
  	}
  	else
  	{
  	  
  	}
  }
  
  public function executeViewTerkirimVerifikasiSurat()
  {
  	$this->setLayout('clear');
  	
  	$connection = Propel::getConnection();
  	
  	$kd_verifikasi = $this->getRequestParameter('kd_verifikasi');
  	$query_a = "SELECT * FROM `oasys_verifikasi` WHERE KD_VERIFIKASI = '".$kd_verifikasi."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
    
  	foreach ($data_a as $a)
  	{
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeViewVerifikasiSurat()
  {
  	$this->setLayout('oasys_layout');
  	
  	$kd_verifikasi = $this->getRequestParameter('kd_verifikasi');
    
  	$connection = Propel::getConnection();	
  	$query_a = "UPDATE `oasys_kepada_verifikasi` SET KD_STATUS = 'read' WHERE KD_VERIFIKASI = '".$kd_verifikasi."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT * FROM `oasys_verifikasi` WHERE KD_VERIFIKASI = '".$kd_verifikasi."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  
  	foreach ($data_b as $a)
  	{
  	  $tanggal_surat = $data_b->getString('TANGGAL_SURAT');
  	  $nomor_surat = $data_b->getString('NOMOR_SURAT');
  	  $nip= $data_b->getString('NIP');
  	  $perihal = $data_b->getString('PERIHAL');
  	  $isi_surat = $data_b->getString('ISI_SURAT');
  	  $nama_file = $data_b->getString('NAMA_FILE');
  	  $direktori_file = $data_b->getString('DIREKTORI_FILE');
  	}
  
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['dari'] = $nip;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
   	}
  }
  
  public function executeFormSuratKeluarInternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarSuratKeluarInternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarSuratMasukInternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsSuratKeluarInternal()
  {
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$klasifikasi = $this->getRequestParameter('klasifikasi');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$temp_tembusan = $this->getRequestParameter('tembusan');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_surat_keluar_internal';
  	 	 
  	$connection = Propel::getConnection();
  	$query_a = "DELETE FROM `oasys_kepada_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	 
  	$query_b = "DELETE FROM `oasys_tembusan_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	 
  	$query_c = "DELETE FROM `oasys_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeUpdate();
  	
  	if ($tipe_file != "application/pdf")
  	{
  	?>
  	  <script>
    	alert("Lampiran harus dalam format .pdf");
    	history.back();
	  </script>
	<?php
  	}
  	else
  	{
  	  $this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  	  
  	  $query_a = "SELECT MAX(NOMOR) AS NOMOR FROM `oasys_surat_internal` WHERE KD_INSTITUSI = '".$_SESSION['kd_institusi']."'";
  	  $statement_a = $connection->prepareStatement($query_a);
  	  $data_a = $statement_a->executeQuery();
  	  
  	  foreach ($data_a as $a)
  	  {
  	  	$temp_nomor = $data_a->getString('NOMOR');
  	  }
  	  
  	  $nomor = $temp_nomor + 1;
  	  
  	  $query_b= "INSERT INTO `oasys_surat_internal` (KD_SURAT, NIP, TANGGAL, TANGGAL_SURAT, SIFAT_SURAT, NOMOR, KD_INSTITUSI, NOMOR_SURAT, PERIHAL, ISI_SURAT, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$tanggal_surat', '$sifat_surat', '$nomor', '".$_SESSION['kd_institusi']."', '$nomor' '/' '$klasifikasi' '/' '".$_SESSION['unit']."' '/' '12', '$perihal', '$isi_surat', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	  $statement_b = $connection->prepareStatement($query_b);
  	  $data_b = $statement_b->executeUpdate();
  		 
  	  $query_c= "SELECT KD_SURAT FROM `oasys_surat_internal` WHERE NOMOR_SURAT = '".$nomor."' '/' '".$klasifikasi."' '/' '".$_SESSION['unit']."' '/' '12'";
  	  $statement_c = $connection->prepareStatement($query_c);
      $data_c = $statement_c->executeQuery();
  		
  	  foreach ($data_c as $a)
  	  {
  		$kd_surat = $data_c->getString('KD_SURAT');
  	  }
  	
  	  if (count($temp_kepada) > 0)
  	  {
  	    foreach ($temp_kepada as $kepada)
  		{
  		  $query_d = "INSERT INTO `oasys_kepada_surat_internal` (KD_KEPADA_SURAT_INTERNAL, KD_STATUS, KD_SURAT, KEPADA) VALUES ('', 'unread', '$kd_surat', '$kepada')";
  		  $statement_d = $connection->prepareStatement($query_d);
  		  $data_d = $statement_d->executeUpdate();
  		  
  		  $query = "SELECT TELEPON, EMAIL FROM `pegawai` WHERE NIP = '".$kepada."'";
  		  $statement = $connection->prepareStatement($query);
  		  $data = $statement->executeQuery();
  		  
  		  foreach ($data as $a)
  		  {
  		  	$telepon = $data->getString('TELEPON');
  		  	$email = $data->getString('EMAIL');
  		  }
  		}
  	  }
  		
  	  if (count($temp_tembusan) > 0)
  	  {
  		foreach ($temp_tembusan as $tembusan)
  		{
  		  $query_e = "INSERT INTO `oasys_tembusan_surat_internal` (KD_TEMBUSAN_SURAT_INTERNAL, KD_STATUS, KD_SURAT, TEMBUSAN) VALUES ('', 'unread', '$kd_surat', '$tembusan')";
  		  $statement_e = $connection->prepareStatement($query_e);
  		  $data_e = $statement_e->executeUpdate();
  		  
  		  $query = "SELECT TELEPON, EMAIL FROM `pegawai` WHERE NIP = '".$tembusan."'";
  		  $statement = $connection->prepareStatement($query);
  		  $data = $statement->executeQuery();
  		  
  		  foreach ($data as $a)
  		  {
  		  	$telepon = $data->getString('TELEPON');
  		  	$email = $data->getString('EMAIL');
  		  }
  		}
  	  }
  		
  	  if ($query_b)
  	  {
  		$this->redirect('mymodule/daftarSuratKeluarInternal');
  	  }
  	  else
  	  {
  	    		
  	  } 
  	}
  }
  
  public function executeViewSuratKeluarInternal()
  {
  	$this->setLayout('clear');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection(); 	
  	  	
  	$query_a = "SELECT * FROM `oasys_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  
  	foreach ($data_a as $a)
  	{
  	  $dari = $data_a->getString('NIP');
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	 
    $_SESSION['dari'] = $dari;
    $_SESSION['tanggal'] = $tanggal;
    $_SESSION['tanggal_surat'] = $tanggal_surat;
  	$_SESSION['sifat_surat'] = $sifat_surat;
  	$_SESSION['nomor_surat'] = $nomor_surat;
  	$_SESSION['perihal'] = $perihal;
  	$_SESSION['isi_surat'] = $isi_surat;
  	$_SESSION['nama_file'] = $nama_file;
  	$_SESSION['direktori_file'] = $direktori_file;
  	
  	$query_b = "SELECT KEPADA FROM `oasys_kepada_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kepada = $data_b->getString('KEPADA');
  	}
  	
  	$_SESSION['kepada'] = $kepada;
  	
  	$query_c = "SELECT TEMBUSAN FROM `oasys_tembusan_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeQuery();
  	 
  	foreach ($data_c as $a)
  	{
  	  $tembusan = $data_c->getString('TEMBUSAN');
  	}
  	
  	if (!empty($tembusan))
  	{
  	  $_SESSION['tembusan'] = $tembusan;
  	}
  	
  }
  
  public function executeViewSuratMasukInternal()
  {
  	$this->setLayout('clear');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$nip = $this->getRequestParameter('nip');
  	 
  	$connection = Propel::getConnection();
  	$query_a = "UPDATE `oasys_kepada_surat_internal` SET KD_STATUS = 'read' WHERE KD_SURAT = '".$kd_surat."' AND KEPADA = '".$nip."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "UPDATE `oasys_tembusan_surat_internal` SET KD_STATUS = 'read' WHERE KD_SURAT = '".$kd_surat."' AND TEMBUSAN = '".$nip."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	
  	$query_c = "SELECT * FROM `oasys_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c= $statement_c->executeQuery();
  	 
  	foreach ($data_c as $a)
  	{
  	  $kd_surat = $data_c->getString('KD_SURAT');
  	  $dari = $data_c->getString('NIP');
  	  $tanggal = $data_c->getString('TANGGAL');
  	  $tanggal_surat = $data_c->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_c->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_c->getString('NOMOR_SURAT');
  	  $perihal = $data_c->getString('PERIHAL');
  	  $isi_surat = $data_c->getString('ISI_SURAT');
  	  $nama_file = $data_c->getString('NAMA_FILE');
  	  $direktori_file = $data_c->getString('DIREKTORI_FILE');
  	}
  
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  	
  	$query_d = "SELECT KEPADA FROM `oasys_kepada_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_d = $connection->prepareStatement($query_d);
  	$data_d= $statement_d->executeQuery();
  	
  	foreach ($data_d as $a)
  	{
  	  $kepada = $data_d->getString('KEPADA');
  	}
  	
    $_SESSION['kepada'] = $kepada;
    
    $query_e = "SELECT TEMBUSAN FROM `oasys_tembusan_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
    $statement_e = $connection->prepareStatement($query_e);
    $data_e = $statement_e->executeQuery();
    
    foreach ($data_e as $a)
    {
      $tembusan = $data_e->getString('TEMBUSAN');
    }
     
    if (!empty($tembusan))
    {
      $_SESSION['tembusan'] = $tembusan;
    }
  }
  
  public function executeFormDisposisiSuratInternal()
  {
  	$this->setLayout('oasys_layout');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	
  	foreach ($data_a as $a)
  	{
  	  $temp_dari = $data_a->getString('NIP');
  	  	
  	  $query_b = "SELECT NAMA_JABATAN FROM `oasys_jabatan_struktural` AS `t1` INNER JOIN `oasys_jabatan_struktural_pegawai` AS `t2` 
	  	    	  ON t1.KD_JS = t2.KD_JS
	  	    	  INNER JOIN `oasys_pegawai` AS `t3`
	  	   		  ON t2.NIP = t3.NIP
	  	    	  WHERE t3.NIP = '".$temp_dari."'";
	  $statement_b = $connection->prepareStatement($query_b);
	  $data_b = $statement_b->executeQuery();
	  	    
	  foreach ($data_b as $a)
	  {
	   	$dari = $data_b->getString('NAMA_JABATAN');
	  }
  			
  	  $tanggal_masuk = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $ukuran_file = $data_a->getString('UKURAN_FILE');
  	  $tipe_file = $data_a->getString('TIPE_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	
  	if(!empty($nomor_surat) && !empty($kd_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal_masuk'] = $tanggal_masuk;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['ukuran_file'] = $ukuran_file;
  	  $_SESSION['tipe_file'] = $tipe_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeDaftarKonsepSuratKeluarInternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsKonsepSuratKeluarInternal()
  {
  	
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$klasifikasi = $this->getRequestParameter('klasifikasi');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$temp_tembusan = $this->getRequestParameter('tembusan');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_konsep_surat_internal';
  	
  	$this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  	
  	$connection = Propel::getConnection(); 	
  	$query_a = "INSERT INTO `oasys_konsep_surat_internal` (KD_SURAT, NIP, TANGGAL, TANGGAL_SURAT, SIFAT_SURAT, NOMOR_SURAT, PERIHAL, ISI_SURAT, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$tanggal_surat', '$sifat_surat', '/' '$klasifikasi' '/' '".$_SESSION['unit']."' '/' '12', '$perihal', '$isi_surat', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT KD_SURAT FROM `oasys_konsep_surat_internal` WHERE NOMOR_SURAT = '/' '".$klasifikasi."' '/' '".$_SESSION['unit']."' '/' '12'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kd_surat = $data_b->getString('KD_SURAT');
  	}
  	
  	if (count($temp_kepada) > 0)
  	{
  	  foreach ($temp_kepada as $kepada)
  	  {
  	    $query_c = "INSERT INTO `oasys_kepada_konsep_surat_internal` (KD_KEPADA_KONSEP_SURAT_INTERNAL, KD_SURAT, KEPADA) VALUES ('', '$kd_surat', '$kepada')";
  	    $statement_c = $connection->prepareStatement($query_c);
  	    $data_c = $statement_c->executeUpdate();
  	  }
  	}
  	
  	if (count($temp_tembusan) > 0)
  	{
  	  foreach ($temp_tembusan as $tembusan)
  	  {
  	    $query_d = "INSERT INTO `oasys_tembusan_konsep_surat_internal` (KD_TEMBUSAN_KONSEP_SURAT_INTERNAL, KD_SURAT, TEMBUSAN) VALUES ('', '$kd_surat', '$tembusan')";
  	    $statement_d = $connection->prepareStatement($query_d);
  	    $data_d = $statement_d->executeUpdate();
  	  }
  	}
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarKonsepSuratKeluarInternal');
  	}
  	else
  	{
  	  
  	}
  }
  
  public function executeViewKonsepSuratKeluarInternal()
  {
  	$this->setLayout('oasys_layout');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	
  	foreach ($data_a as $a)
  	{
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_a->getString('NOMOR_SURAT'));
  	  $perihal = $data_a->getString('PERIHAL');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function  executeDelKonsepSuratKeluarInternal()
  {
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "DELETE FROM `oasys_kepada_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "DELETE FROM `oasys_tembusan_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	
  	$query_c = "DELETE FROM `oasys_konsep_surat_internal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeQuery();
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarKonsepSuratKeluarInternal');
  	}
  	else
  	{
  			
  	}
  }
  
  public function executeUpdKonsepSuratKeluarInternal()
  {
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "UPDATE `oasys_konsep_surat_internal` SET ISI_SURAT = '".$isi_surat."' WHERE KD_SURAT = '".$kd_surat."' ";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	if ($query_a)
  	{
  	  $this->redirect('mymodule/daftarKonsepSuratKeluarInternal');
  	}
  	else
  	{
  			
  	}
  }
  
  public function executeFormSuratKeluarEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarSuratKeluarEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsSuratKeluarEksternal()
  { 
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$klasifikasi = $this->getRequestParameter('klasifikasi');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$temp_tembusan = $this->getRequestParameter('tembusan');
  	$temp_email = $this->getRequestParameter('email');
  	$alamat = $this->getRequestParameter('alamat');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_konsep_surat_eksternal';
  
  	$connection = Propel::getConnection();
  	$query_a = "DELETE FROM `oasys_kepada_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	 
  	$query_b = "DELETE FROM `oasys_tembusan_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	 
  	$query_c = "DELETE FROM `oasys_email_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeUpdate();
  	 
  	$query_d = "DELETE FROM `oasys_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_d = $connection->prepareStatement($query_d);
  	$data_d = $statement_d->executeUpdate();
  	 
  	if ($tipe_file != "application/pdf")
  	{
  	?>
  	  <script type="text/javascript">
  	   	alert("Lampiran harus dalam format .pdf");
  	   	history.back();
  	  </script>
  	<?php 
  	}
  	else
  	{
  	  $this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  	  
  	  $query_a = "SELECT MAX(NOMOR) AS NOMOR FROM `oasys_surat_keluar_eksternal` WHERE KD_INSTITUSI = '".$_SESSION['kd_institusi']."'";
  	  $statement_a = $connection->prepareStatement($query_a);
  	  $data_a = $statement_a->executeQuery();
  	  
  	  foreach ($data_a as $a)
  	  {
  		$temp_nomor = $data_a->getString('NOMOR');
  	  }
  		
  	  $nomor = $temp_nomor + 1;
  		
  	  $query_b = "INSERT INTO `oasys_surat_keluar_eksternal` (KD_SURAT, NIP, TANGGAL, TANGGAL_SURAT, SIFAT_SURAT, NOMOR, KD_INSTITUSI, NOMOR_SURAT, PERIHAL, ALAMAT, ISI_SURAT, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$tanggal_surat', '$sifat_surat', '$nomor', '".$_SESSION['kd_institusi']."', '$nomor' '/' '$klasifikasi' '/' '".$_SESSION['unit']."' '/' '12', '$perihal', '$alamat', '$isi_surat', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	  $statement_b = $connection->prepareStatement($query_b);
  	  $data_b = $statement_b->executeUpdate();
  		
  	  $query_c = "SELECT KD_SURAT FROM `oasys_surat_keluar_eksternal` WHERE NOMOR_SURAT = '".$nomor."' '/' '".$klasifikasi."' '/' '".$_SESSION['unit']."' '/' '12'";
  	  $statement_c = $connection->prepareStatement($query_c);
  	  $data_c = $statement_c->executeQuery();
  		
  	  foreach ($data_c as $a)
  	  {
  		$kd_surat = $data_c->getString('KD_SURAT');
  	  }
  		
  	  if (count($temp_kepada) > 0)
  	  {
  		foreach ($temp_kepada as $kepada)
  		{
  		  $query_d = "INSERT INTO `oasys_kepada_surat_keluar_eksternal` (KD_KEPADA_SURAT_KELUAR_EKSTERNAL, KD_SURAT, KEPADA) VALUES ('', '$kd_surat', '$kepada')";
  		  $statement_d = $connection->prepareStatement($query_d);
  	      $data_d = $statement_d->executeUpdate();
  		}
  	  }
  	
  	  if (count($temp_tembusan) > 0)
  	  {
  		foreach ($temp_tembusan as $tembusan)
  		{
  		  $query_e = "INSERT INTO `oasys_tembusan_surat_keluar_eksternal` (KD_TEMBUSAN_SURAT_KELUAR_EKSTERNAL, KD_SURAT, TEMBUSAN) VALUES ('', '$kd_surat', '$tembusan')";
  		  $statement_e = $connection->prepareStatement($query_e);
  		  $data_e = $statement_e->executeUpdate();
  		}
  	  }
  		
  	  if (count($temp_email) > 0)
  	  {
  		foreach ($temp_email as $email)
  		{
  		  $query_f = "INSERT INTO `oasys_email_surat_keluar_eksternal` (KD_EMAIL_SURAT_KELUAR_EKSTERNAL, KD_SURAT, EMAIL) VALUES ('', '$kd_surat', '$email')";
  		  $statement_f = $connection->prepareStatement($query_f);
  	      $data_f = $statement_f->executeUpdate();
  		}
  	  }
  		
  	  if ($query_f)
  	  {
  		$this->redirect('mymodule/daftarSuratKeluarEksternal');
  	  }
  	  else
  	  {
  				
  	  }
  	}
  }
  
  public function executeViewSuratKeluarEksternal()
  {
  	$this->setLayout('clear');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  
  	foreach ($data_a as $a)
  	{
  	  $dari = $data_a->getString('NIP');
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $alamat = $data_a->getString('ALAMAT');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  
  	if(!empty($nomor_surat))
  	{
      $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['alamat'] = $alamat;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
   	}
   	
   	$query_b = "SELECT KEPADA FROM `oasys_kepada_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
   	$statement_b = $connection->prepareStatement($query_b);
   	$data_b = $statement_b->executeQuery();
   	
   	foreach ($data_b as $b)
   	{
   	  $kepada = $data_b->getString('KEPADA');
   	}
   	
   	if(!empty($nomor_surat))
   	{
   	  $_SESSION['kepada'] = $kepada;
   	}
  }
  
  public function executeDaftarKonsepSuratKeluarEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsKonsepSuratKeluarEksternal()
  {
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$klasifikasi = $this->getRequestParameter('klasifikasi');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$temp_tembusan = $this->getRequestParameter('tembusan');
  	$temp_email = $this->getRequestParameter('email');
  	$alamat = $this->getRequestParameter('alamat');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_konsep_surat_eksternal';
  	 
  	$this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  	
  	$connection = Propel::getConnection();
  	$query_a = "INSERT INTO `oasys_konsep_surat_keluar_eksternal` (KD_SURAT, NIP, TANGGAL, TANGGAL_SURAT, SIFAT_SURAT, NOMOR_SURAT, PERIHAL, ALAMAT, ISI_SURAT, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$tanggal_surat', '$sifat_surat', '/' '$klasifikasi' '/' '".$_SESSION['unit']."' '/' '12', '$perihal', '$alamat', '$isi_surat', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT KD_SURAT FROM `oasys_konsep_surat_keluar_eksternal` WHERE NOMOR_SURAT = '/' '".$klasifikasi."' '/' '".$_SESSION['unit']."' '/' '12'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kd_surat = $data_b->getString('KD_SURAT');
  	}
  	
  	if (count($temp_kepada) > 0)
  	{
  	  foreach ($temp_kepada as $kepada)
  	  {
  		$query_c = "INSERT INTO `oasys_kepada_konsep_surat_keluar_eksternal` (KD_KEPADA_KONSEP_SURAT_KELUAR_EKSTERNAL, KD_SURAT, KEPADA) VALUES ('', '$kd_surat', '$kepada')";
  		$statement_c = $connection->prepareStatement($query_c);
  		$data_c = $statement_c->executeUpdate();
  	  }
  	}
  	
  	if (count($temp_tembusan) > 0)
  	{
  	  foreach ($temp_tembusan as $tembusan)
  	  {
  		$query_d = "INSERT INTO `oasys_tembusan_konsep_surat_keluar_eksternal` (KD_TEMBUSAN_KONSEP_SURAT_KELUAR_EKSTERNAL, KD_SURAT, TEMBUSAN) VALUES ('', '$kd_surat', '$tembusan')";
  		$statement_d = $connection->prepareStatement($query_d);
  		$data_d = $statement_d->executeUpdate();
  	  }
  	}
  	
  	if (count($temp_email) > 0)
  	{
  	  foreach ($temp_email as $email)
  	  {
  		$query_e = "INSERT INTO `oasys_email_konsep_surat_keluar_eksternal` (KD_EMAIL_KONSEP_SURAT_KELUAR_EKSTERNAL, KD_SURAT, EMAIL) VALUES ('', '$kd_surat', '$email')";
  		$statement_e = $connection->prepareStatement($query_e);
  		$data_e = $statement_e->executeUpdate();
  	  }
  	}
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarKonsepSuratKeluarEksternal');
  	}
  	else
  	{
  	  
  	}
  }
  
  public function executeViewKonsepSuratKeluarEksternal()
  {
  	$this->setLayout('oasys_layout');

  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	
  	foreach ($data_a as $a)
  	{
  	  $kd_surat = $data_a->getString('KD_SURAT');
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_a->getString('NOMOR_SURAT'));
  	  $perihal = $data_a->getString('PERIHAL');
  	  $alamat = $data_a->getString('ALAMAT');
  	  $isi_surat = $data_a->getString('ISI_SURAT');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['alamat'] = $alamat;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeDelKonsepSuratKeluarEksternal()
  {
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "DELETE FROM `oasys_kepada_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "DELETE FROM `oasys_tembusan_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	
  	$query_c = "DELETE FROM `oasys_email_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeUpdate();
  	
  	$query_d = "DELETE FROM `oasys_konsep_surat_keluar_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_d = $connection->prepareStatement($query_d);
  	$data_d = $statement_d->executeUpdate();
  	
  	if ($query_d)
  	{
  	  $this->redirect('mymodule/daftarKonsepSuratKeluarEksternal');
  	}
  	else
  	{
  			
  	}
  }
  
  public function executeUpdKonsepSuratEksternal()
  {
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$perihal = $this->getRequestParameter('perihal');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	
  	$query_a = "UPDATE `oasys_konsep_surat_keluar_eksternal` SET TANGGAL_SURAT = '".$tanggal_surat."', SIFAT_SURAT = '".$sifat_surat."', PERIHAL = '".$perihal."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  }
  
  public function executeFormSuratMasukEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarTerkirimSuratMasukEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeDaftarSuratMasukEksternal()
  {
  	$this->setLayout('oasys_layout');
  }
  
  public function executeInsSuratMasukEksternal()
  {
  	
  	$dari = $this->getRequestParameter('dari');
  	$alamat = $this->getRequestParameter('alamat');
  	$tanggal_diterima = $this->getRequestParameter('tanggal_diterima');
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$nomor_surat = $this->getRequestParameter('nomor_surat');
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$temp_tembusan = $this->getRequestParameter('tembusan');
  	$komentar = $this->getRequestParameter('komentar');
  	$nama_file = $this->getRequest()->getFileName('lampiran');
  	$ukuran_file = $this->getRequest()->getFileSize('lampiran');
  	$tipe_file = $this->getRequest()->getFileType('lampiran');
  	$direktori_file = 'uploads/lampiran_surat_masuk_eksternal';
  	
  	if ($tipe_file != "application/pdf")
  	{ 
  	?>
  	  <script type="text/javascript">
  	   	alert("Lampiran harus dalam format .pdf");
  	   	history.back();
  	  </script>
  	<?php 
  	}
  	else
  	{
  	  $this->getRequest()->moveFile('lampiran', $direktori_file.'/'.$nama_file);
  		 
  	  $connection = Propel::getConnection();
  	  $query_a = "INSERT INTO `oasys_surat_masuk_eksternal` (KD_SURAT, NIP, TANGGAL, DARI, ALAMAT, TANGGAL_DITERIMA, TANGGAL_SURAT, SIFAT_SURAT, NOMOR_SURAT, PERIHAL, KOMENTAR, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '".$_SESSION['nip']."', NOW(), '$dari', '$alamat', '$tanggal_diterima', '$tanggal_surat', '$sifat_surat', '$nomor_surat', '$perihal', '$komentar', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	  $statement_a = $connection->prepareStatement($query_a);
  	  $data_a = $statement_a->executeUpdate();
  		
  	  $query_b = "SELECT KD_SURAT FROM `oasys_surat_masuk_eksternal` WHERE NOMOR_SURAT = '".$nomor_surat."'";
  	  $statement_b = $connection->prepareStatement($query_b);
  	  $data_b = $statement_b->executeQuery();
  		 
  	  foreach ($data_b as $a)
  	  {
  		$kd_surat = $data_b->getString('KD_SURAT');
  	  }
  		
  	  if (count($temp_kepada) > 0)
  	  {
  		foreach ($temp_kepada as $kepada)
  		{
  		  $query_c = "INSERT INTO `oasys_kepada_surat_masuk_eksternal` (KD_KEPADA_SURAT_MASUK_EKSTERNAL, KD_STATUS, KD_SURAT, KEPADA) VALUES ('', 'unread', '$kd_surat', '$kepada')";
  		  $statement_c = $connection->prepareStatement($query_c);
  		  $data_c = $statement_c->executeUpdate();
  		  
  		  $query = "SELECT TELEPON, EMAIL FROM `pegawai` WHERE NIP = '".$kepada."'";
  		  $statement = $connection->prepareStatement($query);
  		  $data = $statement->executeQuery();
  		  
  		  foreach ($data as $a)
  		  {
  		  	$telepon = $data->getString('TELEPON');
  		  	$email = $data->getString('EMAIL');
  		  }
  		}
  	  }
  		
  	  if (count($temp_tembusan) > 0)
  	  {
  		foreach ($temp_tembusan as $tembusan)
  		{
  		  $query_d = "INSERT INTO `oasys_tembusan_surat_masuk_eksternal` (KD_TEMBUSAN_SURAT_MASUK_EKSTERNAL, KD_STATUS, KD_SURAT, TEMBUSAN) VALUES ('', 'unread', '$kd_surat', '$tembusan')";
          $statement_d = $connection->prepareStatement($query_d);
  		  $data_d = $statement_d->executeUpdate();
  		  
  		  $query = "SELECT TELEPON, EMAIL FROM `pegawai` WHERE NIP = '".$tembusan."'";
  		  $statement = $connection->prepareStatement($query);
  		  $data = $statement->executeQuery();
  		  
  		  foreach ($data as $a)
  		  {
  		  	$telepon = $data->getString('TELEPON');
  		  	$email = $data->getString('EMAIL');
  		  }
  		}
  	  }
  		
  	  if ($query_c)
  	  {
  		$this->redirect('mymodule/daftarTerkirimSuratMasukEksternal');
  	  }
  	  else
  	  {
  		
  	  }
  	}
  }
  
  public function executeViewTerkirimSuratMasukEksternal()
  {
  	$this->setLayout('clear');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_surat_masuk_eksternal` WHERE KD_SURAT = '".$kd_surat."' ";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  
  	foreach ($data_a as $a)
  	{
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $dari = $data_a->getString('DARI');
  	  $alamat = $data_a->getString('ALAMAT');
  	  $tanggal_diterima = $data_a->getString('TANGGAL_DITERIMA');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_a->getString('NOMOR_SURAT'));
  	  $perihal = $data_a->getString('PERIHAL');
  	  $komentar = $data_a->getString('KOMENTAR');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	 
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['alamat'] = $alamat;
  	  $_SESSION['tanggal_diterima'] = $tanggal_diterima;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['komentar'] = $komentar;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeViewSuratMasukEksternal()
  {
  	$this->setLayout('clear');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$nip = $this->getRequestParameter('nip');
  	 
  	$connection = Propel::getConnection();
  	$query_a = "UPDATE `oasys_kepada_surat_masuk_eksternal` SET KD_STATUS = 'read' WHERE KD_SURAT = '".$kd_surat."' AND KEPADA = '".$nip."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "UPDATE `oasys_tembusan_surat_masuk_eksternal` SET KD_STATUS = 'read' WHERE KD_SURAT = '".$kd_surat."' AND TEMBUSAN = '".$nip."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	
  	$query_c = "SELECT * FROM `oasys_surat_masuk_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeQuery();
  	 
  	foreach ($data_c as $a)
  	{
  	  $tanggal = $data_c->getString('TANGGAL');
  	  $dari = $data_c->getString('DARI');
  	  $alamat = $data_c->getString('ALAMAT');
  	  $tanggal_diterima = $data_c->getString('TANGGAL_DITERIMA');
  	  $tanggal_surat = $data_c->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_c->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_c->getString('NOMOR_SURAT'));
  	  $perihal = $data_c->getString('PERIHAL');
  	  $komentar = $data_c->getString('KOMENTAR');
  	  $nama_file = $data_c->getString('NAMA_FILE');
  	  $direktori_file = $data_c->getString('DIREKTORI_FILE');
  	}
  	 
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['alamat'] = $alamat;
  	  $_SESSION['tanggal_diterima'] = $tanggal_diterima;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['komentar'] = $komentar;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeFormDisposisiSuratMasukEksternal()
  {
  	$this->setLayout('oasys_layout');
  	
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_surat_masuk_eksternal` WHERE KD_SURAT = '".$kd_surat."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	 
  	foreach ($data_a as $a)
  	{
  	  $dari = $data_a->getString('DARI');
  	  $tanggal_masuk = $data_a->getString('TANGGAL');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $komentar = $data_a->getString('KOMENTAR');
  	  $nama_file = $data_a->getString('NAMA_FILE');
  	  $ukuran_file = $data_a->getString('UKURAN_FILE');
  	  $tipe_file = $data_a->getString('TIPE_FILE');
  	  $direktori_file = $data_a->getString('DIREKTORI_FILE');
  	}
  	 
  	if(!empty($nomor_surat) && !empty($kd_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal_masuk'] = $tanggal_masuk;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['pesan'] = $komentar;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['ukuran_file'] = $ukuran_file;
  	  $_SESSION['tipe_file'] = $tipe_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeFormDisposisiSurat()
  {
  	$this->setLayout('oasys_layout');
  	
  	$no_surat_disposisi = $this->getRequestParameter('nomor_surat');
  	 
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_disposisi` WHERE NOMOR_SURAT = '".$no_surat_disposisi."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  	 
  	foreach ($data_a as $a)
  	{
  	  $kd_surat = $data_a->getString('KD_SURAT');
  	  $temp_dari = $data_a->getString('NIP');
  	  
  	  $query_b = "SELECT NAMA FROM `oasys_pegawai` WHERE NIP = '".$temp_dari."'";
  	  $statement_b = $connection->prepareStatement($query_b);
  	  $data_b = $statement_b->executeQuery();
  	  
  	  foreach ($data_b as $a)
  	  {
  	  	$dari = $data_b->getString('NAMA');
  	  }
  	  
  	  $tanggal_masuk = $data_b->getString('TANGGAL');
  	  $tanggal_surat = $data_b->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_b->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_b->getString('NOMOR_SURAT'));
  	  $perihal = $data_b->getString('PERIHAL');
  	  $pesan = $data_b->getString('ISI_SURAT');
  	  $nama_file = $data_b->getString('NAMA_FILE');
  	  $direktori_file = $data_b->getString('DIREKTORI_FILE');
  	}
  	 
  	if(!empty($nomor_surat) && !empty($kd_surat))
  	{
  	  $_SESSION['kd_surat'] = $kd_surat;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal_masuk'] = $tanggal_masuk;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['pesan'] = $pesan;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeDaftarTerkirimDisposisiSurat()
  {
    $this->setLayout('oasys_layout');
  }
  
  public function executeDaftarDisposisiSurat()
  {
    $this->setLayout('oasys_layout');
  }
  
  public function executeInsDisposisiSurat()
  {
  	$kd_surat = $this->getRequestParameter('kd_surat');
  	$dari = $this->getRequestParameter('dari');
  	$tanggal_masuk = $this->getRequestParameter('tanggal_masuk');
  	$tanggal_surat = $this->getRequestParameter('tanggal_surat');
  	$sifat_surat = $this->getRequestParameter('sifat_surat');
  	$temp_nomor_surat = $this->getRequestParameter('nomor_surat');
  	$nomor_surat = str_replace('/', '@', $temp_nomor_surat);
  	$perihal = $this->getRequestParameter('perihal');
  	$temp_kepada = $this->getRequestParameter('kepada');
  	$isi_surat = $this->getRequestParameter('isi_surat');
  	$komentar = $this->getRequestParameter('komentar');
  	$nama_file = $this->getRequestParameter('nama_file');
  	$ukuran_file = $this->getRequestParameter('ukuran_file');
  	$tipe_file = $this->getRequestParameter('tipe_file');
  	$direktori_file = $this->getRequestParameter('direktori_file');
  
  	$connection = Propel::getConnection();
  	$query_a = "INSERT INTO `oasys_disposisi` (KD_DISPOSISI, KD_SURAT, NIP, TANGGAL, DARI, TANGGAL_MASUK, TANGGAL_SURAT, SIFAT_SURAT, NOMOR_SURAT, PERIHAL, ISI_SURAT, KOMENTAR, NAMA_FILE, UKURAN_FILE, TIPE_FILE, DIREKTORI_FILE) VALUES ('', '$kd_surat', '".$_SESSION['nip']."', NOW(), '$dari', '$tanggal_masuk', '$tanggal_surat', '$sifat_surat', '$nomor_surat', '$perihal', '$isi_surat', '$komentar', '$nama_file', '$ukuran_file', '$tipe_file', '$direktori_file')";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT KD_DISPOSISI FROM `oasys_disposisi` WHERE NOMOR_SURAT = '".$nomor_surat."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kd_disposisi = $data_b->getString('KD_DISPOSISI');
  	}
  	
  	if (count($temp_kepada) > 0)
  	{
  	  foreach ($temp_kepada as $kepada)
  	  {
  		$query_c = "INSERT INTO `oasys_kepada_disposisi` (KD_KEPADA_DISPOSISI, KD_STATUS, KD_DISPOSISI, KEPADA) VALUES ('', 'unread', '$kd_disposisi', '$kepada')";
  		$statement_c = $connection->prepareStatement($query_c);
  		$data_c = $statement_c->executeUpdate();
  		
  		$query = "SELECT TELEPON, EMAIL FROM `pegawai` WHERE NIP = '".$kepada."'";
  		$statement = $connection->prepareStatement($query);
  		$data = $statement->executeQuery();
  		
  		foreach ($data as $a)
  		{
  			$telepon = $data->getString('TELEPON');
  			$email = $data->getString('EMAIL');
  		}
  	  }
  	}
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarTerkirimDisposisiSurat');
  	}
  	else
  	{
  	  
  	}
  }
  
  public function executeViewTerkirimDisposisiSurat()
  {
  	$this->setLayout('clear');
  	
  	$kd_disposisi = $this->getRequestParameter('kd_disposisi');
  
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_disposisi` WHERE KD_DISPOSISI = '".$kd_disposisi."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  
  	foreach ($data_a as $a)
  	{
  	  $pengirim = $data_a->getString('NIP');
  	  $tanggal = $data_a->getString('TANGGAL');
  	  $dari = $data_a->getString('DARI');
  	  $tanggal_masuk = $data_a->getString('TANGGAL_MASUK');
  	  $tanggal_surat = $data_a->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_a->getString('SIFAT_SURAT');
  	  $nomor_surat = $data_a->getString('NOMOR_SURAT');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $komentar = $data_a->getString('KOMENTAR');
  	}
  	 
  	if(!empty($nomor_surat) && !empty($kepada))
  	{
  	  $_SESSION['pengirim'] = $pengirim;
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal_masuk'] = $tanggal_masuk;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['komentar'] = $komentar;
  	}
  }
  
  public function executeViewDisposisiSurat()
  {
  	$this->setLayout('clear');
  	
  	$kd_disposisi = $this->getRequestParameter('kd_disposisi');
  
  	$connection = Propel::getConnection();
  	$query_a = "UPDATE `oasys_kepada_disposisi` SET KD_STATUS = 'read' WHERE KD_DISPOSISI = '".$kd_disposisi."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT * FROM `oasys_disposisi` WHERE KD_DISPOSISI = '".$kd_disposisi."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  
  	foreach ($data_b as $a)
  	{
  	  $tanggal = $data_b->getString('TANGGAL');
  	  $dari = $data_b->getString('DARI');
  	  $tanggal_masuk = $data_b->getString('TANGGAL_MASUK');
  	  $tanggal_surat = $data_b->getString('TANGGAL_SURAT');
  	  $sifat_surat = $data_b->getString('SIFAT_SURAT');
  	  $nomor_surat = str_replace('@', '/', $data_b->getString('NOMOR_SURAT'));
  	  $perihal = $data_b->getString('PERIHAL');
  	  $isi_surat = $data_b->getString('ISI_SURAT');
  	  $nama_file = $data_b->getString('NAMA_FILE');
  	  $direktori_file = $data_b->getString('DIREKTORI_FILE');
  	}
  
  	if(!empty($nomor_surat))
  	{
  	  $_SESSION['tanggal'] = $tanggal;
  	  $_SESSION['dari'] = $dari;
  	  $_SESSION['tanggal_masuk'] = $tanggal_masuk;
  	  $_SESSION['tanggal_surat'] = $tanggal_surat;
  	  $_SESSION['sifat_surat'] = $sifat_surat;
  	  $_SESSION['nomor_surat'] = $nomor_surat;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['isi_surat'] = $isi_surat;
  	  $_SESSION['nama_file'] = $nama_file;
  	  $_SESSION['direktori_file'] = $direktori_file;
  	}
  }
  
  public function executeFormArsip()
  {
    $this->setLayout('oasys_layout');
  }
  
  public function executeDaftarArsip()
  {
    $this->setLayout('oasys_layout');
  }
  
  public function executeDelArsip()
  {
  	$kd_arsip = $this->getRequestParameter('kd_arsip');
  	
  	$connection = Propel::getConnection();
  	$query_a = "DELETE FROM `oasys_letak_arsip` WHERE KD_ARSIP = '".$kd_arsip."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	 
  	$query_b = "DELETE FROM `oasys_arsip` WHERE KD_ARSIP = '".$kd_arsip."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeUpdate();
  	
  	if ($query_b)
  	{
  		$this->redirect('mymodule/daftarArsip');
  	}
  	else
  	{
  			
  	}
  }
  
  public function executeInsArsip()
  {
  	$tanggal = $this->getRequestParameter('tanggal');
  	$nomor_dokumen = $this->getRequestParameter('nomor_dokumen');
  	$perihal = $this->getRequestParameter('perihal');
  	$kepada = $this->getRequestParameter('kepada');
  	$institusi = $this->getRequestParameter('institusi');
  	$alamat = $this->getRequestParameter('alamat');  	
  	$jenis_dokumen = $this->getRequestParameter('jenis_dokumen');
  	$jumlah_dokumen = $this->getRequestParameter('jumlah_dokumen');
  	$nama_dokumen = $this->getRequest()->getFileName('dokumen');
  	$ukuran_dokumen = $this->getRequest()->getFileSize('dokumen');
  	$tipe_dokumen = $this->getRequest()->getFileType('dokumen');
  	$direktori_dokumen = 'uploads/dokumen_arsip';
  	$tanggal_masuk_dokumen = $this->getRequestParameter('tanggal_masuk_dokumen');
  	$tanggal_retensi = $this->getRequestParameter('tanggal_retensi');
  	$lemari = $this->getRequestParameter('lemari');
  	$rak = $this->getRequestParameter('rak');
  	$folder = $this->getRequestParameter('folder');
  	$map = $this->getRequestParameter('map');
  	$posisi = $this->getRequestParameter('posisi');
  	
  	$this->getRequest()->moveFile('dokumen', $direktori_dokumen.'/'.$nama_dokumen);
  	
  	$connection = Propel::getConnection();
  	$query_a = "INSERT INTO `oasys_arsip` (KD_ARSIP, NOMOR_DOKUMEN, NIP, TANGGAL, PERIHAL, KEPADA, INSTITUSI, ALAMAT, KD_JENIS_DOKUMEN, JUMLAH_DOKUMEN, NAMA_DOKUMEN, UKURAN_DOKUMEN, TIPE_DOKUMEN, DIREKTORI_DOKUMEN, TANGGAL_MASUK_DOKUMEN, TANGGAL_RETENSI) VALUES ('' ,'$nomor_dokumen', '".$_SESSION['nip']."', '$tanggal', '$perihal', '$kepada', '$institusi', '$alamat', '$jenis_dokumen', '$jumlah_dokumen', '$nama_dokumen', '$ukuran_dokumen', '$tipe_dokumen', '$direktori_dokumen', '$tanggal_masuk_dokumen', '$tanggal_retensi')";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeUpdate();
  	
  	$query_b = "SELECT KD_ARSIP FROM `oasys_arsip` WHERE NOMOR_DOKUMEN = '".$nomor_dokumen."' AND TANGGAL = '".$tanggal."'";
  	$statement_b = $connection->prepareStatement($query_b);
  	$data_b = $statement_b->executeQuery();
  	
  	foreach ($data_b as $a)
  	{
  	  $kd_arsip = $data_b->getString('KD_ARSIP');
  	}
  	
  	$query_c = "INSERT INTO `oasys_letak_arsip` (KD_LETAK, KD_ARSIP, LEMARI, RAK, FOLDER, MAP, POSISI) VALUES ('', '$kd_arsip', '$lemari', '$rak', '$folder', '$map', '$posisi')";
  	$statement_c = $connection->prepareStatement($query_c);
  	$data_c = $statement_c->executeUpdate();
  	
  	if ($query_c)
  	{
  	  $this->redirect('mymodule/daftarArsip');
  	}
  	else
  	{
  	    	
  	}
  }
  
  public function executeViewArsip()
  {
  	$this->setLayout('clear');
  	
  	$kd_arsip = $this->getRequestParameter('kd_arsip');
  
  	$connection = Propel::getConnection();
  	$query_a = "SELECT * FROM `oasys_arsip` WHERE KD_ARSIP = '".$kd_arsip."'";
  	$statement_a = $connection->prepareStatement($query_a);
  	$data_a = $statement_a->executeQuery();
  
  	foreach ($data_a as $a)
  	{
  	  $nomor_dokumen = $data_a->getString('NOMOR_DOKUMEN');
  	  $perihal = $data_a->getString('PERIHAL');
  	  $kepada = $data_a->getString('KEPADA');
  	  $institusi = $data_a->getString('INSTITUSI');
  	  $alamat = $data_a->getString('ALAMAT');
  	  $nama_dokumen= $data_a->getString('NAMA_DOKUMEN');
  	  $direktori_dokumen= $data_a->getString('DIREKTORI_DOKUMEN');
  	}
  
  	if(!empty($nomor_dokumen))
  	{
  	  $_SESSION['kd_arsip'] = $kd_arsip;
  	  $_SESSION['nomor_dokumen'] = $nomor_dokumen;
  	  $_SESSION['perihal'] = $perihal;
  	  $_SESSION['kepada'] = $kepada;
  	  $_SESSION['institusi'] = $institusi;
  	  $_SESSION['alamat'] = $alamat;
  	  $_SESSION['nama_dokumen'] = $nama_dokumen;
  	  $_SESSION['direktori_dokumen'] = $direktori_dokumen;
  	}
  }
  
  public function executeDaftarPegawai()
  {
  	
  }
  
  public function executeDaftarTataNaskah()
  {
  	
  }
}