function Simpan()
{
  document.viewKonsepSuratKeluarEksternal.action = "updKonsepSuratKeluarEksternal";
  document.viewKonsepSuratKeluarEksternal.submit();           
  return true;
}

function Kirim()
{
  document.viewKonsepSuratKeluarEksternal.action = "insSuratKeluarEksternal";
  document.viewKonsepSuratKeluarEksternal.submit();           
  return true;	
}