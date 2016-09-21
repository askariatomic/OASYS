<?php

$connection = Propel::getConnection();
$query ="SELECT COUNT(KD_STATUS) AS JML_KEPADA_SURAT_MASUK_INTERNAL
		 FROM `oasys_kepada_surat_internal`
		 WHERE KEPADA='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
  $jml_kepada_surat_masuk_internal = $data->getString('JML_KEPADA_SURAT_MASUK_INTERNAL');
}

$query ="SELECT COUNT(KD_STATUS) AS JML_TEMBUSAN_SURAT_MASUK_INTERNAL
		 FROM `oasys_tembusan_surat_internal`
		 WHERE TEMBUSAN='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
  $jml_tembusan_surat_masuk_internal = $data->getString('JML_TEMBUSAN_SURAT_MASUK_INTERNAL');
}

$connection = Propel::getConnection();
$query ="SELECT COUNT(KD_STATUS) AS JML_KEPADA_SURAT_MASUK_EKSTERNAL
		 FROM `oasys_kepada_surat_masuk_eksternal`
		 WHERE KEPADA='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
	$jml_kepada_surat_masuk_eksternal = $data->getString('JML_KEPADA_SURAT_MASUK_EKSTERNAL');
}

$query ="SELECT COUNT(KD_STATUS) AS JML_TEMBUSAN_SURAT_MASUK_EKSTERNAL
		 FROM `oasys_tembusan_surat_masuk_eksternal`
		 WHERE TEMBUSAN='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
	$jml_tembusan_surat_masuk_eksternal = $data->getString('JML_TEMBUSAN_SURAT_MASUK_EKSTERNAL');
}

$query ="SELECT COUNT(KD_STATUS) AS JML_VERIFIKASI
FROM `oasys_kepada_verifikasi`
WHERE KEPADA='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
	$jml_verifikasi = $data->getString('JML_VERIFIKASI');
}

$query ="SELECT COUNT(KD_STATUS) AS JML_DISPOSISI
		 FROM `oasys_kepada_disposisi`
		 WHERE KEPADA='".$_SESSION['nip']."' AND KD_STATUS='unread' ";
$statement = $connection->prepareStatement($query);
$data = $statement->executeQuery();

foreach ($data as $a)
{
  $jml_disposisi = $data->getString('JML_DISPOSISI');
}

?>
<html>
	<head></head>
	<body>
	  <table>
	    <td>Internal: <?php echo $jml_kepada_surat_masuk_internal+$jml_kepada_surat_masuk_internal; ?></td>
	    <td>Eksternal: <?php echo $jml_tembusan_surat_masuk_eksternal+$jml_kepada_surat_masuk_eksternal; ?></td>
	    <td>Disposisi: <?php echo $jml_disposisi; ?></td>
	    <td>Verifikasi: <?php echo $jml_verifikasi; ?></td>
	  </table>
	</body>
</html>