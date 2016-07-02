<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
{_header_}
<title>{_appname_}</title>
</head>
<body>
<div align="center" id="wrap">
	<div id="menubox"><!-- Menu box !-->
		<div id="menu-wrapper"> <!-- menu wrapper -->
			<ul id="menus">
				<!-- Start menu list!-->
				<li><a href="<?php echo base_url(); ?>" title="Home"> Home </a></li>
			    <!-- Start menu by role !-->

			    <?php
			    /**
			     * Menu untuk role admin piom
			     */
			    if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			    	?>
			    	<li><a href="#" title="Jenis Pelaporan"> Entri </a>
			    		<ul class="submenu">
			    			<li><a href="#" title="Pemeriksaan Sarana" class="hasChild"> Pemeriksaan Sarana </a>
			    				<ul class="submenu">
			    					 <li><a href="<?php echo site_url(); ?>/home/tracking/pemeriksaan" title="Pemeriksaan Sarana, Temuan Sarana"> Temuan Sarana </a></li>
			    					 <li><a href="<?php echo site_url(); ?>/home/tracking/produk" title="Pemeriksaan Sarana, Temuan Produk"> Temuan Produk </a></li>
			    				</ul>
			    			</li>
			    			<li><a href="#" title="Pengujian" class="hasChild"> Pengujian </a>
			    				<ul class="submenu">
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/sampling" title="Data Sampel"> Data Sampel</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/sampel-deleted" title="Data Sampel Dihapus"> Data Sampel Dihapus</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/rujukan-admin" title="Daftar Sampel Rujukan"> Sampel Rujukan</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/unggulan-admin" title="Daftar Sampel Unggulan"> Sampel Unggulan</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/spu" title="Transaksi Surat Permintaan Uji"> Permintaan Uji</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/sps" title="Transaksi Surat Penyerahan Sampel ke Bidang"> Penyerahan Sampel Ke Bidang</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/spk" title="Transaksi Surat Perintah Kerja"> Perintah Kerja</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/spp" title="Transaksi Surat Perintah Pengujian"> Perintah Pengujian</a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/tracking/cp" title="Transaksi Catatan Pengujian"> Catatan Pengujian</a></li>
			    					<li><a href="#" title="Hasil Pengujian Balai dan Terkirim ke Pusat" class="hasChild"> Hasil Pengujian</a>
				    					<ul>
				    						<li><a href="<?php echo site_url(); ?>/home/tracking/hasil-uji/balai">Masih Di Balai</a></li>
				    						<li><a href="<?php echo site_url(); ?>/home/tracking/hasil-uji/terkirim">Terkirim Ke Pusat</a></li>
				    					</ul>
			    					</li>
			    				</ul>
			    			</li>
			    			<li><a href="#" title="Pengawasan Iklan" class="hasChild">Pengawasan Iklan </a>
			    				<ul class="submenu">
			    					<li><a href="<?php echo site_url(); ?>/iklan/iklanController/monitoring" title="Pengawasan Iklan, Monitoring"> Monitoring Iklan </a></li>
			    				</ul>
			    			</li>
			    			<li><a href="#" title="Pengawasan Penandaan" class="hasChild"> Pengawasan Penandaan </a>
			    				<ul class="submenu">
			    					<li><a href="<?php echo site_url(); ?>/penandaan/penandaanController/monitoring" title="Pengawasan Penandaan, Monitoring"> Monitoring Penandaan </a></li>
			    				</ul>
			    			</li>
			    		</ul>
			    	</li>
			    	<li><a href="#" title="Report pemeriksaan, pengujian, penandaan dan pengawasan iklan"> Report </a>
			    	</li>
			    	<li><a href="#" title="Master data"> Master Data </a>
			    	</li>
			    	<?php
			    }
			    /**
			     * End menu role admin piom
			     */
			    ?>

			    <!-- Start menu by role !-->

			    <!-- Menu utility !-->	
			    <li><a href="#" title="Utility"> Utility </a>
			    	<ul class="submenu">
			    		<li><a href="<?php echo site_url(); ?>/home/utility/news" title="News Update Aplikasi"> News Update Aplikasi</a></li>
			    		<li><a href="#" title="Frequently Asked Questions" class="hasChild"> FAQ </a>
			    			<ul class="submenu">
			    				<li><a href="<?php echo site_url(); ?>/home/utility/faq/draft" title="Draft FAQ"> Draft FAQ </a></li>
			    				<li><a href="<?php echo site_url(); ?>/home/utility/faq/publish" title="FAQ"> FAQ </a></li>
			    				<?php 
			    				if (in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))) { 
			    					?>
			    					<li><a href="<?php echo site_url(); ?>/home/utility/faq/unpublish" title="Unpublish FAQ"> Unpublish FAQ </a></li>
			    					<li><a href="<?php echo site_url(); ?>/home/utility/faq/reference" title="Referensi FAQ"> Referensi FAQ </a></li>
			    					<?php
			    				}
			    				?>
			    			</ul>
			    		</li>
			    		<li><a href="#" class="hasChild">Download Center</a>
			    			<ul class="submenu">
			    				<li><a href="<?php echo site_url(); ?>/download/data/Juknis_Pemeriksaan_Sarana.pdf" title="Download Juknis Pemeriksaan Sarana">Juknis Pemeriksaan Sarana</a></li>
				                <li><a href="<?php echo site_url(); ?>/download/data/Juknis_Sampling_Pengujian_Versi_II_06032014.rar" title="Download Juknis Sampling dan Pengujian">Juknis Sampling dan Pengujian</a></li>
				                <li><a href="<?php echo site_url(); ?>/download/data/SIPT-OFFLINE.rar" title="Download SIPT Modul Offline (Sarana Distribusi)">SIPT Modul Offline</a></li>
				                <li><a href="<?php echo site_url(); ?>/download/data/UPLOAD_EXCEL.rar" title="Download Format Upload Temuan Produk dalam bentuk file excel">Format Upload Temuan Produk</a></li>
				                <li class="separator">&nbsp;</li>
				                <li><a href="<?php echo site_url(); ?>/download/data/Pedoman_Sampling_PT_dan_NAPZA_2015.rar" title="Update Kebijakan pada Pedoman Sampling PT dan NAPZA 2015">Perbedaan Prioritas Sampling 2014 dan 2015 Komoditi Obat</a></li>
				                <li><a href="<?php echo site_url(); ?>/download/data/Contact_Center.rar" title="Daftar Contact Person Admin Pusat">Contact Person</a></li>
			    			</ul>
			    		</li>
			    	</ul>
			    </li>
			    <!-- End menu utility !-->
				<li><a href="#" title="Profil"> Profil </a>
					<ul class="submenu">
						<li><a href="<?php echo site_url(); ?>/home/user/profil" title="Profil, Ubah Profil">Ubah Profil</a></li>
						<li><a href="<?php echo site_url(); ?>/home/user/password" title="Profil, Ubah Password">Ubah Password</a></li>
					</ul>
			    </li>
				<li><a href="<?php echo site_url(); ?>/home/logout" title="Keluar"> Keluar </a></li>
				<!-- End menu list !-->
			</ul>
		</div><!-- End menu wrapper !--> 
		<div id="welcomebox"><!-- Welcomebox !-->
			<div>Selamat Datang <b>{_name_}</b></div>
			<div id="info">
				<?php if ($this->newsession->userdata('SESS_BBPOM_ID') != "00") { ?>
				<div class="kiri">
					<div class="dropdown"><a href="#"> Notifikasi</a>
	            		<div>
	              		<ul id="notifall" url="<?php echo site_url(); ?>/load/utility/get_all"></ul>
	            		</div>
	          		</div>
	        	</div>
	        	<?php } ?>
	        	<div class="kanan">
	          		<ul id="news" class="tags green"></ul>
	        	</div>
	      	</div>
		</div><!-- End Welcomebox !-->
	</div><!-- End Menu Box !-->
	<div id="contentbox"> {_content_} </div><!-- Content App !-->
	<div class="footer"> <b>Sistem Informasi Pelaporan Terpadu</b> Versi 1.0<br />Copyright &copy; 2011 - BPOM </div><!-- Footer !-->
</div><!-- End Wrapper !-->
<div id="indicator">Memuat ...</div>
<div id="modal_pop"></div>
<!--<div id="pengumuman">!-->
<div id="pengumuman" style="display:none;">
  <marquee>
  Download <a href="<?php echo site_url(); ?>/download/data/Final_Book_Pedoman_Sampling_2015.rar">Pedoman Sampling Obat dan Makanan Tahun Anggaran 2015</a>. Untuk penambahan Parameter uji pada Komoditi Obat Prioritas Sampling 2015 bisa merujuk ke <a href="<?php echo site_url(); ?>/home/utility/faq/new/206" target="_blank">FAQ No. 206</a>. Dan untuk penambahan Parameter Uji Sampling 2014 seluruh komoditi bisa merujuk <a href="<?php echo site_url(); ?>/home/utility/faq/new/177" target="_blank">FAQ No. 177</a>
  </marquee>
</div>
<div id="privilage"></div>
</body>
</html>