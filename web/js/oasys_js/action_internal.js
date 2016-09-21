function Kirim()
{
  document.formSuratKeluarInternal.action = "insSuratKeluarInternal";
  document.formSuratKeluarInternal.submit();           
  return true;
}

function Simpan()
{
  document.formSuratKeluarInternal.action = "insKonsepSuratKeluarInternal";
  document.formSuratKeluarInternal.submit();             
  return true;
}

function Kembali()
{
  document.verifikasiSurat.action = "insVerifikasiSurat";
  document.verifikasiSurat.submit();           
  return true;	
}

function Terus()
{
  document.verifikasiSurat.action = "insVerifikasiSurat";
  document.verifikasiSurat.submit();           
  return true;	
}