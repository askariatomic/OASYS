function Kirim()
{
  document.formSuratKeluarEksternal.action = "insSuratKeluarEksternal";
  document.formSuratKeluarEksternal.submit();           
  return true;
}

function Simpan()
{
  document.formSuratKeluarEksternal.action = "insKonsepSuratKeluarEksternal";
  document.formSuratKeluarEksternal.submit();             
  return true;
}

function Verifikasi()
{
  document.formSuratKeluarEksternal.action = "insVerifikasiSurat";
  document.formSuratKeluarEksternal.submit();             
  return true;
}