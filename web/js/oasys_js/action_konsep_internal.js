function Kirim()
{
  document.viewKonsepSuratKeluarInternal.action = "insSuratKeluarInternal";
  document.viewKonsepSuratKeluarInternal.submit();           
  return true;	
}

function Simpan()
{
  document.viewKonsepSuratKeluarInternal.action = "updKonsepSuratKeluarInternal";
  document.viewKonsepSuratKeluarInternal.submit();           
  return true;
}