<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <title>E-Office Telkom University</title>
  <link rel="shortcut icon" href="/favicon.ico" />
  <script type="text/javascript" src="/js/oasys_js/tinymcpuk/tiny_mce.js"></script> 
  <?php echo javascript_include_tag('oasys_js/jquery-1.7.2.min') ?>
  <script type="text/javascript" src="/js/oasys_js/data_tables/media/js/jquery.dataTables.js"></script>
  <style type="text/css">
    @import "/js/oasys_js/data_tables/media/css/demo_table_jui.css";
    @import "/js/oasys_js/data_tables/media/css/jui_themes/smoothness/jquery-ui-1.8.21.custom.css";
  </style>
  <?php echo javascript_include_tag('oasys_js/accordion') ?>
  <?php echo javascript_include_tag('oasys_js/tiny_mcpuk') ?>
  <script src="/js/oasys_js/jquery.PrintArea.js_4.js"></script>
  <script src="/js/oasys_js/core.js"></script>
  <?php echo stylesheet_tag('oasys_css/oasys') ?>
</head>
<body>
  <div id="container">
    <div id=header>
      <div id="title"><img src="/images/oasys_images/ypt.png" alt="Politeknik Telkom" /></div>
    </div>
    <div id="menus">
      <div id="menu">
        <div id="name"><?php echo $_SESSION['nama']; ?></div>
        <div id="separated">|</div>
        <div id="logout"><?php echo link_to('Keluar', 'mymodule/formLogin') ?></a></div>
        <div id="date"><?php setlocale(LC_ALL, 'IND'); $date = strftime("%A, %d %B %Y"); echo $date; ?></div>
      </div>
    </div>
    <div id="contents">
      <div id="sidebar">
        <div class="title_bar">Menu</div>
        <div class=border_title></div>
		  <ul id="accordion">
		    <li>
			  <a href="#">Buat Baru</a>
			    <ul>
				  <li><?php echo link_to('Internal', 'mymodule/formSuratKeluarInternal') ?></li>
				  <li><?php echo link_to('Eksternal', 'mymodule/formSuratKeluarEksternal') ?></li>
				  <li><?php echo link_to('Verifikasi', 'mymodule/formVerifikasi') ?></li>
			    </ul>
			</li>
			<li>
			  <a href="#">Kotak Masuk</a>
				<ul>
				  <li><?php echo link_to('Internal', 'mymodule/daftarSuratMasukInternal') ?></li>
				  <li><?php echo link_to('Eksternal', 'mymodule/daftarSuratMasukEksternal') ?></li>
				  <li><?php echo link_to('Disposisi', 'mymodule/daftarDisposisiSurat') ?></li>
				  <li><?php echo link_to('Verifikasi', 'mymodule/daftarVerifikasiSurat') ?></li> 
			    </ul>
			</li>
			<li>
			  <a href="#">Terkirim</a>
			    <ul>
				  <li><?php echo link_to('Internal', 'mymodule/daftarSuratKeluarInternal') ?></li>
				  <li><?php echo link_to('Eksternal', 'mymodule/daftarSuratKeluarEksternal') ?></li>
				  <li><?php echo link_to('Disposisi', 'mymodule/daftarTerkirimDisposisiSurat') ?></li>
				  <li><?php echo link_to('Verifikasi', 'mymodule/daftarTerkirimVerifikasiSurat') ?></li>
				</ul>
			</li>				
			<li>
			  <a href="#">Konsep Surat</a>
				<ul>
				  <li><?php echo link_to('Internal', 'mymodule/daftarKonsepSuratKeluarInternal') ?></li>
				  <li><?php echo link_to('Eksternal', 'mymodule/daftarKonsepSuratKeluarEksternal') ?></li>
				</ul>
			</li>
			<li>
			  <a href="#">Eksternal</a>
				<ul>
				  <li><?php echo link_to('Masukkan Data', 'mymodule/formSuratMasukEksternal') ?></li>
				  <li><?php echo link_to('Lihat Data', 'mymodule/daftarTerkirimSuratMasukEksternal') ?></li> 
			    </ul>
			</li>
			<li>
			  <a href="#">Kalender</a>
			    <ul>
				  <li><?php echo link_to('Jadwal', 'mymodule/jadwalKegiatan') ?></li>
				</ul>
		    </li>
		    <li>
			  <a href="#">Arsip</a>
				<ul>
				  <li><?php echo link_to('Masukkan Data', 'mymodule/FormArsip') ?></li>
				  <li><?php echo link_to('Lihat Data', 'mymodule/daftarArsip') ?></li> 
			    </ul>
			</li>				
	    </ul>
  	  </div>
	  <div id="content">
	    <div class="title_bar">E-Office Yayasan Pendidikan Telkom</div>
        <div class=border_title></div>
        <div id="content_sf_content">
          <?php echo $sf_data->getRaw('sf_content') ?>
        </div>
      </div>
    </div>
    <div id="footer">Copyright &#169; 2012 - Muhammad Askari - All rights reserved</div>
  </div>
</body>
</html>