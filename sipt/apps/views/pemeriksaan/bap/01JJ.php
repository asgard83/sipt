<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px thin #000;}
table.form_tabel{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
table.form_tabel td{padding:5px;vertical-align:top; border:1px solid #000;}
table.form_tabel td.isi{font-weight:bold;}
table.form_tabel td.td_no{width:20px;}
table.form_tabel td.td_aspek{width:600px;}
h2.small{font-size:9pt; font-weight:bold;}
</style>
<div style="text-align:center;">
	<div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
	<div><h2 class="judulbap">BERITA ACARA PEMERIKSAAN</h2></div>
</div>

<div style="height:5px;">&nbsp;</div>
<div style="text-align:justify;">Pada hari ini <?php echo $hari; ?> tanggal <?php echo $awal_periksa; ?> kami yang bertanda tangan di bawah ini :</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
<?php 
$jml_petugas = count($petugas);
$no = 1;
for($z=0; $z<$jml_petugas; $z++){ ?>  
  <tr><td width="20"><?php echo $no; ?>.</td><td width="120">Nama</td><td width="20">:</td><td><?php echo $petugas[$z]['NAMA_PETUGAS']; ?></td></tr>
  <tr><td>&nbsp;</td><td>NIP</td><td>:</td><td><?php echo $petugas[$z]['NIP']; ?></td></tr>
  <tr><td>&nbsp;</td><td>Jabatan</td><td>:</td><td><?php echo $petugas[$z]['JABATAN']; ?></td></tr>
<?php 
$no++;
} ?>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify">Berdasarkan surat tugas dari Kepala <?php echo ucwords(strtolower($petugas[0]['BADAN'])); ?> Nomor : <?php echo $petugas[0]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[0]['TANGGAL_SURAT']; ?> telah melakukan pemeriksaan terhadap : </div>
<div style="height:20px;"></div>
<table width="100%">
	<tr><td width="200">Nama Sarana</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat</td><td width="20">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify;">Adapun hasil pemeriksaan sebagaimana tersebut terlampir. </div>
<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. </div>
<div style="height:40px;"></div>
<table style="width:100%">
	<tr><td style="width:50%;">Mengetahui,</td><td style="width:50%;">Yang membuat Berita Acara</td></tr>
	<tr><td height="150">Penanggung Jawab,</td><td>
    <table width="100%">
    <?php 
    $jml = count($petugas);
    $no = 1;
    for($x=0; $x<$jml; $x++){ ?>  
      <tr><td width="20"><?php echo $no; ?>.</td><td><?php echo $petugas[$x]['NAMA_PETUGAS']; ?></td></tr>
    <?php 
    $no++;
    } ?>
    </table></td></tr>
	<tr><td><?php echo $sess['PENANGGUNG_JAWAB_PABRIK']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak />

<p><b>Lampiran I</b></p>
<p><b>Data Umum Sarana :</b></p>
<table id="tbsarana" class="form_tabel">
<tr><td class="td_no">1.</td><td class="td_left">a. Nama Perusahaan</td><td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Nama Pemilik / Pimpinan</td><td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Maklon</td><td class="td_right">
<?php
if(is_array($sess)){
	$jml_maklon = count(explode("#", $sess['NAMA_MAKLON']));
	$nama_maklon = explode("#", $sess['NAMA_MAKLON']);
	$alamat_maklon = explode("#", $sess['ALAMAT_MAKLON']);
	?>
	<ul style="list-style:none; margin:0px; padding:0px;" id="list_maklon"><li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><?php echo str_replace("0|NAMA|",'',$nama_maklon[0]); ?>&nbsp;</div><div style="padding-bottom:3px;"><?php echo str_replace("0|ALAMAT|",'',$alamat_maklon[0]); ?></div></li>
	<?php
	for($i=1;$i<$jml_maklon; $i++){
		?>
		<li style="padding-bottom:3px;"><div style="padding-bottom:3px;"><?php echo str_replace($i."|NAMA|",'',$nama_maklon[$i]); ?></div><div style="padding-bottom:3px;"><?php echo str_replace($i."|ALAMAT|",'',$alamat_maklon[$i]); ?></div></li>
		<?php
	}
	?>
	</ul>
	<?php
}
?>
</td></tr>
<tr><td class="td_no">2.</td><td class="td_left">a. Alamat Kantor Pusat</td><td class="td_right"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo join("<br>", $alamat_1); ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Alamat Unit Pengolahan</td><td class="td_right"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo join("<br>", $alamat_2); ?></td></tr>
<tr><td class="td_no">3.</td><td class="td_left">a. Ijin Perusahaan</td><td class="td_right"><?php echo $sess['IZIN_PERUSAHAAN']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Jenis Perusahaan</td><td class="td_right"><?php echo $sess['JENIS_PERUSAHAAN']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Golongan Pabrik</td><td class="td_right"><?php echo $sess['GOLONGAN_PABRIK']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">d. Jumlah Karyawan</td><td class="td_right"><?php echo $sess['JUMLAH_KARYAWAN']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">e. Nama Pangan / Makanan</td><td class="td_right"><?php $nama_pangan = explode(";", $sess['NAMA_PANGAN']); echo join("<br>", $nama_pangan); ?></td></tr>
<tr><td class="td_no">4.</td><td class="td_left">Nomor Registrasi</td><td class="td_right"><?php $nomor_registrasi = explode(";", $sess['NOMOR_REGISTRASI']); echo join("<br>", $nomor_registrasi); ?></td></tr>
<tr><td class="td_no">5.</td><td class="td_left">a. Tahun Unit Pengolahan Didirikan</td><td class="td_right"><?php echo $sess['TAHUN_DIDIRIKAN']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Mulai Operasi</td><td class="td_right"><?php echo $sess['TAHUN_OPERASI']; ?></td></tr>
<tr><td class="td_no">6.</td><td class="td_left">Kapasitas Unit Pengolahan</td><td class="td_right"><?php echo $sess['KAPASITAS_PENGOLAHAN']; ?> ton / hari</td></tr>
<tr><td class="td_no">7.</td><td class="td_left">Produksi Rata - rata Per Hari</td><td class="td_right"><?php echo $sess['PRODUKSI_PER_HARI']; ?> ton / hari</td></tr>
<tr><td class="td_no">8.</td><td class="td_left">Jenis Produk Pangan dan Pemasaran</td><td class="td_right"></td></tr>
<tr><td class="td_no">9.</td><td class="td_left">Merk Produk</td><td class="td_right"><?php $merk_produk = explode(";", $sess['MERK_PRODUK']); echo join("<br>", $merk_produk); ?></td></tr>
<tr><td class="td_no">10.</td><td class="td_left">Jumlah Karyawan</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Tetap Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_TETAP_PRIA_OLAH']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_TETAP_WANITA_OLAH']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Tetap Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_TETAP_PRIA_ADM']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_TETAP_WANITA_ADM']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Harian Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_HARIAN_PRIA_OLAH']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_HARIAN_WANITA_OLAH']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Harian Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_HARIAN_PRIA_ADM']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_HARIAN_WANITA_ADM']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Borongan Pengolahan</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_PRIA_OLAH']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_WANITA_OLAH']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Karyawan Borongan Administrasi</td><td class="td_right">&bull;&nbsp;Pria&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_PRIA_ADM']; ?>&nbsp;&bull;&nbsp;Wanita&nbsp;<?php echo $sess['KARYAWAN_BORONGAN_WANITA_ADM']; ?></td></tr>
<tr><td class="td_no">11.</td><td class="td_left">Penanggung Jawab</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">a. Unit Pengolahan / Pabrik</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_PABRIK']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Produksi</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_PRODUKSI']; ?></td></tr>                
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Mutu</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_MUTU']; ?></td></tr>                
<tr><td class="td_no">&nbsp;</td><td class="td_left">d. Sanitasi dan Higiene</td><td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB_SANITASI']; ?></td></tr>
<tr><td class="td_no">12.</td><td class="td_left">Asal Bahan Baku</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">a. Hasil pemanenan dari perusahaan sendiri / anak perusahaan</td><td class="td_right"></td></tr>
<?php
if(is_array($sess)){
	$anak_perusahaan = explode("#", $sess['ANAK_PERUSAHAAN']);
	$jml_anak = explode(";" ,str_replace('NAMA|','',$anak_perusahaan[0]));
	$anak_satu = explode(";" ,str_replace('NAMA|','',$anak_perusahaan[0]));
	$jenis_satu = explode(";" ,str_replace('JENIS|','',$anak_perusahaan[1]));
	$alamat_satu = explode(";" ,str_replace('ALAMAT|','',$anak_perusahaan[2]));
	for($i=0;$i<count($jml_anak); $i++){
		?>
<tr><td class="td_no"><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_satu[$i]; ?></textarea></td></tr>
<tr><td class="td_no"><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_satu[$i]; ?></textarea></td></tr>
<tr><td class="td_no"><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_satu[$i]; ?></td></tr>
		  <?php
      }
	}
?>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Hasil Pembelian dari Perusahaan Lain</td><td class="td_right"></td></tr>
<?php
if(is_array($sess)){
	$perusahaan_lain = explode("#", $sess['PERUSAHAAN_LAIN']);
	$perusahaan_lain = explode("#", $sess['PERUSAHAAN_LAIN']);
	$jmpl = explode(";" ,str_replace('NAMA|','',$perusahaan_lain[0]));
	$anak_jmpl = explode(";" ,str_replace('NAMA|','',$perusahaan_lain[0]));
	$jenis_jmpl = explode(";" ,str_replace('JENIS|','',$perusahaan_lain[1]));
	$alamat_jmpl = explode(";" ,str_replace('ALAMAT|','',$perusahaan_lain[2]));
	for($i=0;$i<count($jmpl); $i++){
		?>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_jmpl[$i]; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_jmpl[$i]; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_jmp[$i]; ?></td></tr>
		<?php
	}
}
?>
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Hasil dari Pemasok / Supplier</td><td class="td_right"></td></tr>
<?php
if(is_array($sess)){
	$supplier = explode("#", $sess['SUPPLIER']);
	$jmspl = explode(";" ,str_replace('NAMA|','',$supplier[0]));
	$anak_smpl = explode(";" ,str_replace('NAMA|','',$supplier[0]));
	$jenis_smpl = explode(";" ,str_replace('JENIS|','',$supplier[1]));
	$alamat_smpl = explode(";" ,str_replace('ALAMAT|','',$supplier[2]));
	for($i=0;$i<count($jmspl); $i++){
	?>
	<tr><td class="td_no">&nbsp;</td><td class="td_left">Nama Perusahaan</td><td class="td_right"><?php echo $anak_smpl[$i]; ?></td></tr>
	<tr><td class="td_no">&nbsp;</td><td class="td_left">Jenis / Species bahan baku</td><td class="td_right"><?php echo $jenis_smpl[$i]; ?></td></tr>
	<tr><td class="td_no">&nbsp;</td><td class="td_left">Alamat</td><td class="td_right"><?php echo $alamat_smpl[$i]; ?></td></tr>
	<?php
	}
}
?>
<tr><td class="td_no">13.</td><td class="td_left">Es berasal dari (jika  proses produksi menggunakan es)</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">a. Produksi sendiri dengan kapasitas</td><td class="td_right"><?php echo $sess['KAPASITAS_ES']; ?>&nbsp;ton/hari</td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Pembelian dari</td><td class="td_right"><?php echo $sess['PEMBELIAN_ES']; ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Bentuk Es</td><td class="td_right"><?php $bentuk_es = explode(";", $sess['BENTUK_ES']); echo join("<br>", $bentuk_es); ?></td></tr>
<tr><td class="td_no">14.</td><td class="td_left">Kebutuhan es rata-rata per hari (kalo ada)</td><td class="td_right"><?php echo $sess['KEBUTUHAN_ES']; ?></td></tr>
<tr><td class="td_no">15.</td><td class="td_left">Suplai air berasal dari</td><td class="td_right">&nbsp;</td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">a. Air tanah yang di produksi / sendiri</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Kapasitas</td><td class="td_right">Kapasitas&nbsp;<?php echo $sess['KAPASITAS_AIR_TANAH']; ?>&nbsp;m<sup>3</sup>/hari</td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Perlakuan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tanah = explode(";", $sess['PERLAKUAN_AIR_TANAH']); echo "<li>".join("</li><li>", $tanah)."</li>"; ?></ul></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Air ledeng (dari Perusahaan Air Minum)</td><td class="td_right"></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Kapasitas</td><td class="td_right">Kapasitas&nbsp;<?php echo $sess['KAPASITAS_AIR_LEDENG']; ?>&nbsp;m<sup>3</sup>/hari</td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">Perlakuan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $ledeng = explode(";", $sess['PERLAKUAN_AIR_LEDENG']); echo "<li>".join("</li><li>", $ledeng)."</li>"; ?></ul></td></tr>
<tr><td class="td_no">16. </td><td class="td_left">Bahan Tambahan yang Digunakan</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $bahan_tambahan = explode(";", $sess['BAHAN_TAMBAHAN']); echo "<li>".join("</li><li>", $bahan_tambahan)."</li>"; ?></ul></td></tr>
<tr><td class="td_no">17. </td><td class="td_left">Sistem Pengawetan</td><td class="td_right"></td></tr>
<?php
if(is_array($sess)){
	$pengawetan = explode("#", $sess['PENGAWETAN']);
}
?>
<tr><td class="td_no">&nbsp;</td><td class="td_left">a. Pembekuan</td><td class="td_right"><?php echo str_replace('PEMBEKUAN|','',$pengawetan[0]); ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">b. Pendinginan</td><td class="td_right"><?php echo str_replace('PENDINGIN|','',$pengawetan[1]); ?></td></tr>              
<tr><td class="td_no">&nbsp;</td><td class="td_left">c. Pengalengan</td><td class="td_right"><?php echo str_replace('PENGALENGAN|','',$pengawetan[2]); ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">d. Pengeringan</td><td class="td_right"><?php echo str_replace('PENGERINGAN|','',$pengawetan[3]); ?></td></tr>
<tr><td class="td_no">&nbsp;</td><td class="td_left">e. Pengolahan lain</td><td class="td_right"><?php echo str_replace('PENGOLAHAN_LAIN|','',$pengawetan[4]); ?></td></tr>
</table>

<pagebreak />
<p><b>Lampiran II</b></p>
<p><b>Data Khusus Sarana :</b></p>
<table class="form_tabel">
<tr><td style="width:500px;">1. Apakah Unit Pengolahan sudah  mempunyai buku Panduan Mutu/HACCP <em>(HACCP  Plan)</em></td>
<td><?php echo str_replace('SATU|','',$khusus[0]); ?></td></tr>
</table>
                
<table class="form_tabel" id="khusus_seri_1" <?php if(str_replace('SATU|','',$khusus[0] )=='Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
<tr><td style="width:500px;">2. Apakah Unit Pengolahan sudah menerapkan Sistem HACCP ?</td><td><?php echo str_replace('DUA|','',$khusus[1]); ?></td></tr>
<tr id="khusus_seri_sub2" <?php if(str_replace('DUA|','',$khusus[1]) == 'Belum') echo 'style=""'; else echo 'style="display:none;"'; ?>><td style="width:500px;">apa alasannya Unit Pengolahan belum menerapkan Sistem HACCP ?</td><td><?php echo str_replace('DUA_BELUM|','',$khusus[2]); ?></td></tr>                
</table>
<table class="form_tabel" id="khusus_seri_2" <?php if(str_replace('DUA|','',$khusus[1]) == 'Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
<tr><td style="width:500px;">bagian/departemen apa saja yang terlibat ?</td><td><?php echo str_replace('DUA_SUDAH|','',$khusus[3]); ?></td></tr>
<tr><td style="width:500px;">3. Formulir-formulir apa  saja yang dibuat untuk <em>record keeping ?</em> Sebutkan!</td><td ><?php echo str_replace('TIGA|','',$khusus[4]);?></td></tr>
<tr><td style="width:500px;">4. Tindakan apa yang dilakukan  jika terjadi penyimpangan ?</td><td>&nbsp;</td></tr>
<tr><td style="width:500px;">a. Terhadap bahan baku ?</td><td><?php echo str_replace('EMPAT_A|','',$khusus[5]); ?></td></tr>
<tr><td style="width:500px;">b. Produk yang sedang  diolah ?</td><td class="atas"><?php echo str_replace('EMPAT_B|','',$khusus[6]); ?></td></tr>
<tr><td style="width:500px;">c. Produk akhir ?</td><td><?php echo str_replace('EMPAT_C|','',$khusus[7]); ?></td></tr>
<tr><td style="width:500px;">5. Kesulitan apa yang  dihadapi dalam penerapan sistem HACCP ?</td><td><?php echo str_replace('LIMA|','',$khusus[8]); ?></td></tr>
<tr><td style="width:500px;">6. Bimbingan apa yang  diperlukan dalam penerapan sistem HACCP  ?</td><td><?php echo str_replace('ENAM|','',$khusus[9]); ?></td></tr>
<tr><td style="width:500px;">7. Selama ini apakah sudah  mendapatkan pelatihan tentang sistem  HACCP ?</td><td><?php echo str_replace('TUJUH|','',$khusus[10]); ?></td>
</tr>
</table>
<table id="khusus_seri_3" class="form_tabel" <?php if(str_replace('TUJUH|','',$khusus[10]) == 'Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
<tr><td style="width:500px;">a. Siapa  penyelenggaranya dan kapan dilaksanakannya ?</td><td><?php echo str_replace('TUJUH_A|','',$khusus[11]); ?></td></tr>
<tr><td style="width:500px;">b. Siapa dan dari mana tenaga pelatihnya ?</td><td><?php echo str_replace('TUJUH_B|','',$khusus[12]); ?></td></tr>
<tr><td style="width:500px;">c. Berapa orang dan bagian  apa saja yang terlibat dalam pelatihan?</td><td><?php echo str_replace('TUJUH_C|','',$khusus[13]); ?></td></tr>
</table>

<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran III</b></p>
<p>Checklist Aspek Penilaian</p>
<table class="form_tabel">
  <tr><td width="20">&nbsp;</td><td width="400">ASPEK YANG DINILAI</td><td width="90">KRITERIA</td><td width="300">KETERANGAN / TANGGAL PERBAIKAN</td></tr>
<tr>
  <td width="20">a.</td>
  <td width="400">Pimpinan</td>
  <td width="90"><?php echo str_replace('0|','',$aspek_penilaian[0]); ?>
</td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point1_operasional">
  <td width="20">1.</td>
  <td width="400">Pimpinan tidak  mempunyai wawasan terhadap metode pengawasan modern (HACCP) dan tidak melaksanakannya dengan baik</td>
  <td width="90"><?php echo  str_replace('1|','',$aspek_penilaian[1]); ?></td>
  <td width="300"><?php echo str_replace('0|','',$aspek_keterangan[0]); ?></td>
</tr>
<tr id="point2_operasional">
  <td width="20">2.</td>
  <td width="400">Tidak berkeinginan bekerja sama  dengan Inspektur: a.l. tidak menerima Pengawas dengan sepenuh hati dan tidak  mau menunjukkan data. yang diperlukan oleh Inspektur.</td>
  <td width="90"><?php echo  str_replace('2|','',$aspek_penilaian[2]); ?></td>
  <td width="300"><?php echo str_replace('1|','',$aspek_keterangan[1]); ?></td>
</tr>

<tr>
  <td width="20">b.</td>
  <td width="400">Sanitasi dan Lingkungan :</td>
  <td class="atas isi"><?php echo  str_replace('3|','',$aspek_penilaian[3]); ?></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr id="point3_fisik">
  <td width="20">3.</td>
  <td width="400">Lingkungan tidak bebas dari  semak belukar/rumput liar.</td>     
  <td width="90"><?php echo  str_replace('4|','',$aspek_penilaian[4]); ?></td>
  <td width="300"><?php echo str_replace('2|','',$aspek_keterangan[2]); ?></td>
</tr>
<tr id="point4_fisik">
  <td width="20">4.</td>
  <td width="400">Lingkungan tidak bebas dari  sampah, dan barang-barang tak berguna diareal pabrik maupun di luarnya</td>            
  <td width="90"><?php echo  str_replace('5|','',$aspek_penilaian[5]); ?></td>
  <td width="300"><?php echo str_replace('3|','',$aspek_keterangan[3]); ?></td>
</tr>
<tr id="point5_fisik">
  <td width="20">5.</td>
  <td width="400">Tidak ada tempat  sampah disekitar lingkungan pabrik atau tempat sampah ada tetapi tdk dirawat  dgn baik</td>      
  <td width="90"><?php echo  str_replace('6|','',$aspek_penilaian[6]); ?></td>
  <td width="300"><?php echo str_replace('4|','',$aspek_keterangan[4]); ?></td>
</tr>
<tr id="point6_fisik">
  <td>6.</td>
  <td width="400">Bangunan yang digunakan untuk menaruh perlengkapan  tidak teratur, tidak terawat dan tidak mudah dibersihkan</td>  
  <td width="90"><?php echo  str_replace('7|','',$aspek_penilaian[7]); ?></td>
  <td width="300"><?php echo str_replace('5|','',$aspek_keterangan[5]); ?></td>
</tr>
<tr id="point7_fisik">
  <td>7.</td>
  <td width="400">Ada tempat  pemeliharaan hewan yang memungkinkan menjadi sumber kontaminasi</td>
  <td width="90"><?php echo  str_replace('8|','',$aspek_penilaian[8]); ?></td>
  <td width="300"><?php echo str_replace('6|','',$aspek_keterangan[6]); ?></td>
</tr>
<tr id="point8_fisik">
  <td>8.</td>
  <td width="400">Terdapat debu, asap, bau yang  berlebihan di jalanan, tempat parkir atau disekeliling pabrik.</td>      
  <td width="90"><?php echo  str_replace('9|','',$aspek_penilaian[9]); ?></td>
  <td width="300"><?php echo str_replace('7|','',$aspek_keterangan[7]); ?></td>
</tr>

<tr>
  <td width="20">c.</td>
  <td colspan="3">Sanitasi Lingkungan : Pembuangan / Limbah</td>
  </tr>

<tr>	
  <td>&nbsp;</td>
  <td width="400">Saluran Air / Air Hujan</td>
  <td class="atas isi"><?php echo  str_replace('10|','',$aspek_penilaian[10]); ?></td>
 <td width="300"></td>
  </tr>
<tr id="point9_fisik">
  <td width="20">9.</td>
  <td width="400">Sistem pembuangan limbah  cair/saluran disekitar lingkungan pabrik kurang baik:</td>   
  <td width="90"><?php echo  str_replace('11|','',$aspek_penilaian[11]); ?></td>
  <td width="300"><?php echo str_replace('8|','',$aspek_keterangan[8]); ?></td>
</tr>
<tr id="point10_fisik">
  <td>10.</td>
  <td width="400">Kapasitas  saluran di lingkungan pabrik tidak  mencukupi.</td>  
  <td width="90"><?php echo  str_replace('12|','',$aspek_penilaian[12]); ?></td>
  <td width="300"><?php echo str_replace('9|','',$aspek_keterangan[9]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Pembuangan Limbah : Cair, Padat,Sampah di sekitar lingkungan pabrik</td>
  <td class="atas isi"><?php echo  str_replace('13|','',$aspek_penilaian[13]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point11_fisik">
  <td width="20">11.</td>
  <td width="400">Limbah cair disekitar lingkungan tidak ditangani dengan  baik</td>    
  <td width="90"><?php echo  str_replace('14|','',$aspek_penilaian[14]); ?></td>
  <td width="300"><?php echo str_replace('10|','',$aspek_keterangan[10]); ?></td>
</tr>
<tr id="point12_fisik">
  <td>12.</td>
  <td width="400">Konstruksi tempat pembuangan  limbah tidak selayaknya.</td>   
  <td width="90"><?php echo  str_replace('15|','',$aspek_penilaian[15]); ?></td>
  <td width="300"><?php echo str_replace('11|','',$aspek_keterangan[11]); ?></td>
</tr>
<tr id="point13_fisik">
  <td>13.</td>
  <td width="400">Tempat/wadah sampah tidak ada  penutupnya.</td>       
  <td width="90"><?php echo  str_replace('16|','',$aspek_penilaian[16]); ?></td>
  <td width="300"><?php echo str_replace('12|','',$aspek_keterangan[12]); ?></td>
  </tr>
<tr>
  <td width="20">d.</td>
  <td width="400">Sanitasi Lingkungan:  Investasi Burung, Serangga atau binatang lain</td>
  <td width="90"><?php echo  str_replace('17|','',$aspek_penilaian[17]); ?></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr id="point14_fisik">
  <td>14.</td>
  <td width="400">Tidak ada pengendalian untuk  mencegah serangga, tikus dan binatang pengganggu lainnya dilingkungan pabrik.</td>       
  <td width="90"><?php echo  str_replace('18|','',$aspek_penilaian[18]); ?></td>           
  <td width="300"><?php echo str_replace('13|','',$aspek_keterangan[13]); ?></td>
</tr>
<tr id="point15_fisik">
  <td>15.</td>
  <td width="400">Pencegahan serangga, burung,  tikus dan binatang lain tidak efektif</td>     
  <td width="90"><?php echo  str_replace('19|','',$aspek_penilaian[19]); ?></td>
  <td width="300"><?php echo str_replace('14|','',$aspek_keterangan[14]); ?></td>
</tr>

<tr>
  <td width="20">e.</td>
  <td width="400">Pabrik Umum</td>
  <td class="atas isi"><?php echo  str_replace('20|','',$aspek_penilaian[20]); ?></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr id="point16_fisik">
  <td>16.</td>
  <td width="400">Rancang bangun, bahan-bahan  atau konstruksinya menghambat program sanitasi.</td>      
  <td width="90"><?php echo  str_replace('21|','',$aspek_penilaian[21]); ?></td>
  <td width="300"><?php echo str_replace('15|','',$aspek_keterangan[15]); ?></td>
</tr>
<tr id="point17_fisik">
  <td>17.</td>
  <td width="400">Rancang bangun tidak  sesuai dengan jenis pangan yang diproduksi</td>    
  <td width="90"><?php echo  str_replace('22|','',$aspek_penilaian[22]); ?></td>
  <td width="300"><?php echo str_replace('16|','',$aspek_keterangan[16]); ?></td>
</tr>
<tr id="point18_fisik">
  <td>18.</td>
  <td width="400">Luas pabrik tidak  sesuai dengan kapasitas produksi</td>      
  <td width="90"><?php echo  str_replace('23|','',$aspek_penilaian[23]); ?></td>
  <td width="300"><?php echo str_replace('17|','',$aspek_keterangan[17]); ?></td>
</tr>
<tr id="point19_fisik">
  <td>19.</td>
  <td width="400">Bangunan dalam keadaan tidak  terawat</td>   
  <td width="90"><?php echo  str_replace('24|','',$aspek_penilaian[24]); ?></td>
  <td width="300"><?php echo str_replace('18|','',$aspek_keterangan[18]); ?></td>
</tr>
<tr id="point20_fisik">
  <td>20.</td>
  <td width="400">Tidak ada fasilitas atau usaha  lain untuk mencegah binatang atau  serangga masuk kedalam pabrik  (Kisi-kisi, kasa penutup lubang angin, tirai udara<em>-air curtain, </em>tirai plastik atau tirai air-<em>water curtain)</em>, kalaupun ada tidak efektif</td>  
  <td width="90"><?php echo  str_replace('25|','',$aspek_penilaian[25]); ?></td>
  <td width="300"><?php echo str_replace('19|','',$aspek_keterangan[19]); ?></td>
</tr>
<tr id="point21_fisik">
  <td>21.</td>
  <td width="400">Tata ruang tidak sesuai alur  proses produsi</td>     
  <td width="90"><?php echo  str_replace('26|','',$aspek_penilaian[26]); ?></td>
  <td width="300"><?php echo str_replace('20|','',$aspek_keterangan[20]); ?></td>
</tr>
<tr id="point22_fisik">
  <td>22.</td>
  <td width="400">Tidak ada ruang  istirahat, jika ada tidak memenuhi persyaratan kesehatan</td>     
  <td width="90"><?php echo  str_replace('27|','',$aspek_penilaian[27]); ?></td>
  <td width="300"><?php echo str_replace('21|','',$aspek_keterangan[21]); ?></td>
</tr>

<tr>
  <td width="20">f.</td>
  <td width="400">Pabrik Ruang Pengolahan</td>
  <td class="atas isi"><?php echo  str_replace('28|','',$aspek_penilaian[28]); ?></td>
  <td width="300">&nbsp;</td>
  
</tr>
<tr id="point23_fisik">
  <td>23</td>
  <td width="400">Ruang pengolahan berhubungan  langsung/terbuka dengan tempat tinggal, garasi dan bengkel.</td> 
  <td width="90"><?php echo  str_replace('29|','',$aspek_penilaian[29]); ?></td>
  <td width="300"><?php echo str_replace('22|','',$aspek_keterangan[22]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Lantai</td>
  <td class="atas isi"><?php echo  str_replace('30|','',$aspek_penilaian[30]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point24_fisik">
  <td width="20">24.</td>
  <td width="400">Terbuat dari bahan  yang tidak mudah diperbaiki/dicuci atau rusak</td> 
  <td width="90"><?php echo  str_replace('31|','',$aspek_penilaian[31]); ?></td>
  <td width="300"><?php echo str_replace('23|','',$aspek_keterangan[23]); ?></td>
</tr>
<tr id="point25_fisik">
  <td>25.</td>
  <td width="400">Konstruksi tidak  sesuai persyaratan teknik sanitasi dan higiene (tidak rata,tidak kuat, retak  atau licin)</td>     
  <td width="90"><?php echo  str_replace('32|','',$aspek_penilaian[32]); ?></td>
  <td width="300"><?php echo str_replace('24|','',$aspek_keterangan[24]); ?></td>
</tr>
<tr id="point26_fisik">
  <td>26.</td>
  <td width="400">Pertemuan antara  lantai dan dinding tidak mudah dibersihkan (tidak ada lengkungan)</td>      
  <td width="90"><?php echo  str_replace('33|','',$aspek_penilaian[33]); ?></td>
  <td width="300"><?php echo str_replace('25|','',$aspek_keterangan[25]); ?></td>
</tr>
<tr id="point27_fisik">
  <td>27.</td>
  <td width="400">Kemiringan tidak sesuai.</td>        
  <td width="90"><?php echo  str_replace('34|','',$aspek_penilaian[34]); ?></td>
  <td width="300"><?php echo str_replace('26|','',$aspek_keterangan[26]); ?></td>
</tr>
<tr id="point28_fisik">
  <td>28.</td>
  <td width="400">Tidak kedap air</td>     
  <td width="90"><?php echo  str_replace('35|','',$aspek_penilaian[35]); ?></td>
  <td width="300"><?php echo str_replace('27|','',$aspek_keterangan[27]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Dinding</td>
  <td class="atas isi"><?php echo  str_replace('36|','',$aspek_penilaian[36]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point29_fisik">
  <td width="20">29.</td>
  <td width="400">Dinding tidak kedap  air sampai pada ketinggian minimal 1,70 m</td>     
  <td width="90"><?php echo  str_replace('37|','',$aspek_penilaian[37]); ?></td>
  <td width="300"><?php echo str_replace('28|','',$aspek_keterangan[28]); ?></td>
</tr>
<tr id="point30_fisik">
  <td>30.</td>
  <td width="400">Terbuat dari bahan  yang tidak mudah diperbaiki/dicuci</td>  
  <td width="90"><?php echo  str_replace('38|','',$aspek_penilaian[38]); ?></td>
  <td width="300"><?php echo str_replace('29|','',$aspek_keterangan[29]); ?></td>
</tr>
<tr id="point31_fisik">
  <td>31.</td>
  <td width="400">Konstruksi tidak  sesuai persyaratan teknik sanitasi dan higiene (tidak halus, tidak kuat,  retak, cat mudah mengelupas)</td>      
  <td width="90"><?php echo  str_replace('39|','',$aspek_penilaian[39]); ?></td>
  <td width="300"><?php echo str_replace('30|','',$aspek_keterangan[30]); ?></td>
</tr>
<tr id="point32_fisik">
  <td>32.</td>
  <td width="400">Pertemuan antara  dinding dan dinding tidak mudah dibersihkan (tidak ada lengkungan)</td>      
  <td width="90"><?php echo  str_replace('40|','',$aspek_penilaian[40]); ?></td>
  <td width="300"><?php echo str_replace('31|','',$aspek_keterangan[31]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Langit Langit</td>
  <td class="atas isi"><?php echo  str_replace('41|','',$aspek_penilaian[41]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point33_fisik">
  <td width="20">33.</td>
  <td width="400">Tidak ada  langit-langit atau plavon di tempat tertentu yang diperlukan</td>     
  <td width="90"><?php echo  str_replace('42|','',$aspek_penilaian[42]); ?></td>
  <td width="300"><?php echo str_replace('32|','',$aspek_keterangan[32]); ?></td>
</tr>
<tr id="point34_fisik">
  <td>34.</td>
  <td width="400">Langit langit /  plavon tidak bebas dari kemungkinan catnya mengelupas / rontok atau ada  kondensasi</td>      
  <td width="90"><?php echo  str_replace('43|','',$aspek_penilaian[43]); ?></td>
  <td width="300"><?php echo str_replace('33|','',$aspek_keterangan[33]); ?></td>
</tr>
<tr id="point35_fisik">
  <td>35.</td>
  <td width="400">Tidak kedap air dan  tidak mudah dibersihkan</td>   
  <td width="90"><?php echo  str_replace('44|','',$aspek_penilaian[44]); ?></td>
  <td width="300"><?php echo str_replace('34|','',$aspek_keterangan[34]); ?></td>
</tr>
<tr id="point36_fisik">
  <td>36.</td>
  <td width="400">Tidak rata , retak ,  bocor , berlubang</td>     
  <td width="90"><?php echo  str_replace('45|','',$aspek_penilaian[45]); ?></td>
  <td width="300"><?php echo str_replace('35|','',$aspek_keterangan[35]); ?></td>
</tr>
<tr id="point37_fisik">
  <td>37.</td>
  <td width="400">Ketinggian kurang  dari 2,40 m</td>   
  <td width="90"><?php echo  str_replace('46|','',$aspek_penilaian[46]); ?></td>
  <td width="300"><?php echo str_replace('36|','',$aspek_keterangan[36]); ?></td>
</tr>

<tr>
  <td width="20">g.</td>
  <td colspan="3">Fasilitas Pabrik</td>
  </tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Fasilitas cuci tangan dan kaki</td>
  <td class="atas isi"><?php echo  str_replace('47|','',$aspek_penilaian[47]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point38_fisik">
  <td width="20">38.</td>
  <td width="400">Tidak ada tempat cuci  tangan, maupun bak cuci kaki, kalau ada tidak mencukupi</td>     
  <td width="90"><?php echo  str_replace('48|','',$aspek_penilaian[48]); ?></td>
  <td width="300"><?php echo str_replace('37|','',$aspek_keterangan[37]) ?></td>
</tr>
<tr id="point39_fisik">
  <td>39.</td>
  <td width="400">Tempat cuci tangan  dan bak cuci kaki tidak mudah dijangkau atau tidak ditempatkan secara layak</td>       
  <td width="90"><?php echo  str_replace('49|','',$aspek_penilaian[49]); ?></td>
  <td width="300"><?php echo str_replace('38|','',$aspek_keterangan[38]); ?></td>
</tr>
<tr id="point40_fisik">
  <td>40.</td>
  <td width="400">Fasilitas pencucian  tidak disediakan <em>(sabun, pengering, dan  lain-lain)</em></td>     
  <td width="90"><?php echo  str_replace('50|','',$aspek_penilaian[50]); ?></td>
  <td width="300"><?php echo str_replace('39|','',$aspek_keterangan[39]); ?></td>
</tr>
<tr id="point41_fisik">
  <td>41.</td>
  <td width="400">Tidak ada peringatan  pencucian tangan sebelum bekerja atau setelah ke toilet</td>       
  <td width="90"><?php echo  str_replace('51|','',$aspek_penilaian[51]); ?></td>
  <td width="300"><?php echo str_replace('40|','',$aspek_keterangan[40]); ?></td>
</tr>
<tr id="point42_fisik">
  <td>42.</td>
  <td width="400">Peralatan pencucian  tangan tidak cukup/tidak lengkap</td>       
  <td width="90"><?php echo  str_replace('52|','',$aspek_penilaian[52]); ?></td>
  <td width="300"><?php echo str_replace('41|','',$aspek_keterangan[41]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Toilet / Urinior Karyawan</td>
  <td width=""><?php echo  str_replace('53|','',$aspek_penilaian[53]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point43_fisik">
  <td>43.</td>
  <td width="400">Tidak ada fasilitas/bahan  untuk pencucian seperti tisue, sabun (cair) dan pengering atau tidak ada  peringatan agar karyawan mencuci tangan mereka setelah menggunakan toilet</td>   
  <td width="90"><?php echo  str_replace('54|','',$aspek_penilaian[54]); ?></td>
  <td width="300"><?php echo str_replace('42|','',$aspek_keterangan[42]); ?></td>
</tr>
<tr id="point44_fisik">
  <td>44.</td>
  <td width="400">Peralatan toilet  tidak lengkap</td>     
  <td width="90"><?php echo  str_replace('55|','',$aspek_penilaian[55]); ?></td>
  <td width="300"><?php echo str_replace('43|','',$aspek_keterangan[43]); ?></td>
</tr>
<tr id="point45_fisik">
  <td>45.</td>
  <td width="400">Jumlah toilet tidak  mencukupi sebagaimana yang dipersyaratkan</td>  
  <td width="90"><?php echo  str_replace('56|','',$aspek_penilaian[56]); ?></td>
  <td><?php echo str_replace('44|','',$aspek_keterangan[44]); ?></td>
</tr>
<tr id="point46_fisik">
  <td>46.</td>
  <td width="400">Pintu toilet  berhubungan langsung dengan ruang pengolahan</td> 
  <td width="90"><?php echo  str_replace('57|','',$aspek_penilaian[57]); ?></td>
  <td width="300"><?php echo str_replace('45|','',$aspek_keterangan[45]); ?></td>
</tr>
<tr id="point47_fisik">
  <td>47.</td>
  <td width="400">Konstruksi toilet tidak  layak <em>(lantai</em>, <em>dinding, langit-langit, pintu, ventilasi, dll.)</em></td>     
  <td width="90"><?php echo  str_replace('58|','',$aspek_penilaian[58]); ?></td>
  <td width="300"><?php echo str_replace('46|','',$aspek_keterangan[46]); ?></td>
</tr>
<tr id="point48_fisik">
  <td>48.</td>
  <td width="400">Tidak dilengkapi  dengan saluran pembuangan</td>      
  <td width="90"><?php echo  str_replace('59|','',$aspek_penilaian[59]); ?></td>
  <td width="300"><?php echo str_replace('47|','',$aspek_keterangan[47]); ?></td>
</tr>
<tr id="point49_fisik">
  <td>49.</td>
  <td width="400">Toilet tidak terawat  atau digunakan untuk keperluan lain</td>   
  <td width="90"><?php echo  str_replace('60|','',$aspek_penilaian[60]); ?></td>
  <td width="300"><?php echo str_replace('48|','',$aspek_keterangan[48]); ?></td>
</tr>
<tr id="point50_fisik">
  <td>50.</td>
  <td width="400">Intensitas cahaya  penerangan tidak cukup, atau menyilaukan</td>       
  <td width="90"><?php echo  str_replace('61|','',$aspek_penilaian[61]); ?></td>
  <td width="300"><?php echo str_replace('49|','',$aspek_keterangan[49]); ?></td>
</tr>
<tr id="point51_fisik">
  <td height="29">51.</td>
  <td width="400">Lampu di ruang pengolahan, penyimpanan material dan  pengemasan tidak aman <em>(tanpa</em> <em>pelindung)</em></td>        
  <td width="90"><?php echo  str_replace('62|','',$aspek_penilaian[62]); ?></td>
  <td width="300"><?php echo str_replace('50|','',$aspek_keterangan[50]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Ventilasi</td>
  <td class="atas isi"><?php echo  str_replace('63|','',$aspek_penilaian[63]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point52_fisik">
  <td width="20">52.</td>
  <td width="400">Terjadi akumulasi  kondensasi di atas ruang pengolahan, pengemasan dan penyimpanan bahan </td>     
  <td width="90"><?php echo  str_replace('64|','',$aspek_penilaian[64]); ?></td>
  <td width="300"><?php echo str_replace('51|','',$aspek_keterangan[51]); ?></td>
</tr>
<tr id="point53_fisik">
  <td>53.</td>
  <td width="400">Terdapat kapang  (mold), asap dan bau yang mengganggu di ruang pengolahan</td>        
 <td width="90"><?php echo  str_replace('65|','',$aspek_penilaian[65]); ?></td>
  <td width="300"><?php echo str_replace('52|','',$aspek_keterangan[52]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">PPPK/Klinik/Fasilitas Keamanan Kerja</td>
  <td class="atas isi"><?php echo  str_replace('66|','',$aspek_penilaian[66]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point54_fisik">
  <td width="20">54.</td>
  <td width="400">Tak tersedia PPPK atau  fasilitas keamanan/kesehatan kerja (klinik) yang memadai</td>       
  <td width="30"><?php echo  str_replace('67|','',$aspek_penilaian[67]); ?></td>
  <td width="300"><?php echo str_replace('53|','',$aspek_keterangan[53]); ?></td>
</tr>
<tr id="point55_operasional">
  <td>55.</td>
  <td width="400">Fasilitas klinik  pabrik tidak digunakan untuk cek up rutin seluruh karyawan khususnya di bagian  produksi</td>     
  <td width="90"><?php echo  str_replace('68|','',$aspek_penilaian[68]); ?></td>
  <td width="300"><?php echo str_replace('54|','',$aspek_keterangan[54]); ?></td>
</tr>

<tr>
  <td width="20">h.</td>
  <td colspan="3">Pembuangan Limbah di Pabrik</td>
  </tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Sistem Pembuangan Limbah dalam pabrik (cair, sisa produk, pada/kering)</td>
  <td class="atas isi"><?php echo  str_replace('69|','',$aspek_penilaian[69]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point56_operasional">
  <td width="20">56.</td>
  <td width="400">Limbah cair tidak ditangani  dengan baik</td>      
  <td width="90"><?php echo  str_replace('70|','',$aspek_penilaian[70]); ?></td>
  <td width="300"><?php echo str_replace('55|','',$aspek_keterangan[55]); ?></td>
</tr>
<tr id="point57_operasional">
  <td>57.</td>
  <td width="400">Limbah produksi atau sisa-sisa produksi tidak  dikumpulkan dan tidak ditangani dengan baik</td>       
  <td width="90"><?php echo  str_replace('71|','',$aspek_penilaian[71]); ?></td>
  <td width="300"><?php echo str_replace('56|','',$aspek_keterangan[56]); ?></td>
</tr>
<tr id="point58_operasional">
  <td>58.</td>
  <td width="400">Limbah kering/padat  tidak ditangani dan dikumpulkan pada wadah yang baik dan mencukupi jumlahnya  untuk seluruh pabrik</td>     
  <td width="90"><?php echo  str_replace('72|','',$aspek_penilaian[72]); ?></td>
  <td width="300"><?php echo str_replace('57|','',$aspek_keterangan[57]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Tempat sampah dalam pabrik</td>
  <td class="atas isi"><?php echo  str_replace('73|','',$aspek_penilaian[73]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point59_fisik">
  <td width="20">59.</td>
  <td width="400">Konstruksi tempat  pembuangan limbah tidak selayaknya</td>      
  <td width="90"><?php echo  str_replace('74|','',$aspek_penilaian[74]); ?></td>
  <td width="300"><?php echo str_replace('58|','',$aspek_keterangan[58]); ?></td>
</tr>
<tr id="point60_fisik">
  <td>60.</td>
  <td width="400">Tempat/wadah sampah tidak ada penutupnya</td>    
  <td width="90"><?php echo  str_replace('75|','',$aspek_penilaian[75]); ?></td>
  <td width="300"><?php echo str_replace('59|','',$aspek_keterangan[59]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Saluran/Pembuangan dalam pabrik</td>
  <td class="atas isi"><?php echo  str_replace('76|','',$aspek_penilaian[76]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point61_operasional">
  <td width="20">61.</td>
  <td width="400">Sistem pembuangan  limbah cair/saluran dalam pabrik kurang  baik</td>
  <td width="90"><?php echo  str_replace('77|','',$aspek_penilaian[77]); ?></td>
  <td width="300"><?php echo str_replace('60|','',$aspek_keterangan[60]); ?></td>
</tr>
<tr id="point62_fisik">
  <td>62.</td>
  <td width="400">Kapasitas saluran  dalam pabrik tidak mencukupi</td> 
  <td width="90"><?php echo  str_replace('78|','',$aspek_penilaian[78]); ?></td>
  <td width="300"><?php echo str_replace('61|','',$aspek_keterangan[61]); ?></td>
</tr>
<tr id="point63_fisik">
  <td>63.</td>
  <td width="400">Dinding saluran air  tidak halus dan tidak kedap air</td>   
  <td width="90"><?php echo  str_replace('79|','',$aspek_penilaian[79]); ?></td>
  <td width="300"><?php echo str_replace('62|','',$aspek_keterangan[62]); ?></td>
</tr>
<tr id="point64_fisik">
  <td>64.</td>
  <td width="400">Saluran pembuangan  tidak tertutup dan tidak dilengkapi bak kontrol dan alirannya terhambat oleh  kotoran fisik</td>       
  <td width="90"><?php echo  str_replace('80|','',$aspek_penilaian[80]); ?></td>
  <td width="300"><?php echo str_replace('63|','',$aspek_keterangan[63]); ?></td>
</tr>
<tr id="point65_fisik">
  <td>65.</td>
  <td width="400">Tidak dilengkapi  dengan alat yang mempunyai katup untuk mencegah masuknya air ke dalam pabrik</td>       
  <td width="90"><?php echo  str_replace('81|','',$aspek_penilaian[81]); ?></td>
  <td width="300"><?php echo str_replace('64|','',$aspek_keterangan[64]); ?></td>
</tr>

<tr>
  <td width="20">i.</td>
  <td width="400">Operasional Sanitasi di Pabrik</td>
  <td class="atas isi"><?php echo  str_replace('82|','',$aspek_penilaian[82]); ?></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr>
  <td class="atas isi">&nbsp;</td>
  <td colspan="3">Program Sanitasi</td>
</tr>
<tr id="point66_operasional">
  <td>66.</td>
  <td width="400">Tidak ada program  sanitasi yang efektif di unit pengolahan</td>  
  <td width="90"><?php echo  str_replace('83|','',$aspek_penilaian[83]); ?></td>
  <td width="300"><?php echo str_replace('65|','',$aspek_keterangan[65]); ?></td>
</tr>
<tr id="point67_operasional">
  <td>67.</td>
  <td width="400">Kontrol sanitasi  tidak efektif melindungi produk dari kontaminasi.</td>     
  <td width="90"><?php echo  str_replace('84|','',$aspek_penilaian[84]); ?></td>
  <td width="300"><?php echo str_replace('66|','',$aspek_keterangan[66]); ?></td>
</tr>
<tr id="point68_operasional">
  <td>68.</td>
  <td width="400">Peralatan dan wadah  tidak dicuci dan disanitasi sebelum digunakan</td>      
  <td width="90"><?php echo  str_replace('85|','',$aspek_penilaian[85]); ?></td>
  <td width="300"><?php echo str_replace('67|','',$aspek_keterangan[67]); ?></td>
</tr>
<tr id="point69_operasional">
  <td>69.</td>
  <td width="400">Metode  pembersihan/pencucian tidak mencegah kontaminasi terhadap produk</td>      
  <td width="90"><?php echo  str_replace('86|','',$aspek_penilaian[86]); ?></td>
  <td width="300"><?php echo str_replace('68|','',$aspek_keterangan[68]); ?></td>
</tr>

<tr>
  <td width="20">j.</td>
  <td width="400">Binatang penggangu / serangga dalam pabrik</td>
  <td class="atas isi"><?php echo  str_replace('87|','',$aspek_penilaian[87]); ?></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr id="point70_fisik">
  <td>70.</td>
  <td width="400">Ruang dan tempat yang  digunakan untuk penerimaan, pengolahan dan penyimpanan bahan baku/produk akhir  tidak dipelihara kebersihan dan sanitasinya</td>
  <td width="90"><?php echo  str_replace('88|','',$aspek_penilaian[88]); ?></td>
  <td width="300"><?php echo str_replace('69|','',$aspek_keterangan[69]); ?></td>
</tr>
<tr id="point71_fisik">
  <td>71.</td>
  <td width="400">Tidak ada  pengendalian untuk mencegah masuknya serangga, tikus, dan binatang pengganggu  lainnya di dalam pabrik</td>      
  <td width="90"><?php echo  str_replace('89|','',$aspek_penilaian[89]); ?></td>
  <td width="300"><?php echo str_replace('70|','',$aspek_keterangan[70]); ?></td>
</tr>
<tr id="point72_fisik">
  <td>72.</td>
  <td width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif didalam pabrik</td>      
  <td width="90"><?php echo  str_replace('90|','',$aspek_penilaian[90]); ?></td>
  <td width="300"><?php echo str_replace('71|','',$aspek_keterangan[71]); ?></td>
</tr>
<tr id="point73_operasional">
  <td>73.</td>
  <td width="400">Binatang peliharaan  tidak dicegah masuk kedalam pabrik</td>  
  <td width="90"><?php echo  str_replace('91|','',$aspek_penilaian[91]); ?></td>
  <td width="300"><?php echo str_replace('72|','',$aspek_keterangan[72]); ?></td>
</tr>
<tr id="point74_operasional">
  <td>74.</td>
  <td width="400">Penggunaan obat pembasmi serangga, tikus, binatang  pengerat lain, serta kapang tidak  efektif (pestisida, insektisida, fungisida , bahan repellent)</td>     
  <td width="90"><?php echo  str_replace('92|','',$aspek_penilaian[92]); ?></td>
  <td width="300"><?php echo str_replace('73|','',$aspek_keterangan[73]); ?></td>
</tr>

<tr>
  <td width="20">k.</td>
  <td colspan="3">Peralatan Produksi</td>
  </tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Sanitasi</td>
  <td class="atas isi"><?php echo  str_replace('93|','',$aspek_penilaian[93]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point75_fisik">
  <td width="20">75.</td>
  <td width="400">Permukaan peralatan,  wadah dan alat-alat lain yang kontak dengan produk tidak dibuat dari bahan yang  sesuai seperti halus, tahan karat, tahan air dan tahan terhadap bahan kimia</td>        
  <td width="90"><?php echo  str_replace('94|','',$aspek_penilaian[94]); ?></td>
  <td width="300"><?php echo str_replace('74|','',$aspek_keterangan[74]); ?></td>
</tr>
<tr id="point76_fisik">
  <td>76.</td>
  <td width="400">Bahan yang terbuat  dari kayu tidak dilapisi dengan bahan yang tidak berbahaya dan/atau kedap air</td>       
  <td width="90"><?php echo  str_replace('95|','',$aspek_penilaian[95]); ?></td>
  <td width="300"><?php echo str_replace('75|','',$aspek_keterangan[75]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Desain</td>
  <td class="atas isi"><?php echo  str_replace('96|','',$aspek_penilaian[96]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point77_fisik">
  <td width="20">77.</td>
  <td width="400">Rancang bangun,  konstruksi dan penempatan peralatan serta wadah tidak menjamin sanitasi dan  tidak dapat dibersihkan secara efektif</td>  
  <td width="90"><?php echo str_replace('97|','',$aspek_penilaian[97]); ?></td>
  <td width="300"><?php echo str_replace('76|','',$aspek_keterangan[76]); ?></td>
</tr>
<tr id="point78_fisik">
  <td>78.</td>
  <td width="400">Peralatan dan wadah  yang masih digunakan tidak dirawat dengan baik.</td>       
  <td width="90"><?php echo  str_replace('98|','',$aspek_penilaian[98]); ?></td>
  <td width="300"><?php echo str_replace('77|','',$aspek_keterangan[77]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Peralatan tidak di pakai lagi</td>
  <td class="atas isi"><?php echo  str_replace('99|','',$aspek_penilaian[99]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point79_operasional">
  <td width="20">79.</td>
  <td width="400">Tidak ada program  pemantauan untuk membuang wadah dan peralatan yang sudah rusak/tidak digunakan</td>
  <td width="90"><?php echo  str_replace('100|','',$aspek_penilaian[100]); ?></td>
  <td width="300"><?php echo str_replace('78|','',$aspek_keterangan[78]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Kecukupan</td>
  <td class="atas isi"><?php echo  str_replace('101|','',$aspek_penilaian[101]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point80_fisik">
  <td width="20">80.</td>
  <td width="400">Peralatan  kebersihan tidak sesuai kapasitas produksi  atau tidak cukup tersedia</td>     
  <td width="90"><?php echo  str_replace('102|','',$aspek_penilaian[102]); ?></td>
  <td width="300"><?php echo str_replace('79|','',$aspek_keterangan[79]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Penyuci halaman peralatan</td>
  <td class="atas isi"><?php echo  str_replace('103|','',$aspek_penilaian[103]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point81_operasional">
  <td width="20">81.</td>
  <td width="400">Tidak dilakukan  penyucihamaan peralatan secara efektif</td>      
  <td width="90"><?php echo  str_replace('104|','',$aspek_penilaian[104]); ?></td>
  <td width="300"><?php echo str_replace('80|','',$aspek_keterangan[80]); ?></td>
</tr>

<tr>
  <td width="20">l.</td>
  <td colspan="3">Pasokan Air</td>
  </tr>
<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Sumber Air</td>
  <td class="atas isi"><?php echo  str_replace('105|','',$aspek_penilaian[105]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point82_fisik">
  <td width="20">82.</td>
  <td width="400">Pasokan air panas  atau dingin tidak cukup</td>   
  <td width="90"><?php echo  str_replace('106|','',$aspek_penilaian[106]); ?></td>
  <td width="300"><?php echo str_replace('81|','',$aspek_keterangan[81]); ?></td>
</tr>
<tr id="point83_fisik">
  <td>83.</td>
  <td width="400">Air tidak mudah dijangkau/disediakan</td>    
  <td width="90"><?php echo  str_replace('107|','',$aspek_penilaian[107]); ?></td>
  <td width="300"><?php echo str_replace('82|','',$aspek_keterangan[82]); ?></td>
</tr>
<tr id="point84_fisik">
  <td>84.</td>
  <td width="400">Air dapat  terkontaminasi, misalnya hubungan silang antara air kotor dengan air bersih,  sanitasi lingkungan</td>       
  <td width="90"><?php echo  str_replace('108|','',$aspek_penilaian[108]); ?></td>
  <td width="300"><?php echo str_replace('83|','',$aspek_keterangan[83]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">'Treatment' air</td>
  <td class="atas isi"><?php echo  str_replace('109|','',$aspek_penilaian[109]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point85_fisik">
  <td width="20">85.</td>
  <td width="400">Air baku tidak layak digunakan <em>(potable</em>), tidak dilakukan pengujian secara  berkala</td>       
  <td width="90"><?php echo  str_replace('110|','',$aspek_penilaian[110]); ?></td>
  <td width="300"><?php echo str_replace('84|','',$aspek_keterangan[84]); ?></td>
</tr>
<tr id="point86_operasional">
  <td>86.</td>
  <td width="400">Air tidak mendapat persetujuan  dari pihak berwenang untuk digunakan sebagai bahan untuk pengolahan (tidak ada  hasil uji)</td>      
  <td width="90"><?php echo  str_replace('111|','',$aspek_penilaian[111]); ?></td>
  <td width="300"><?php echo str_replace('85|','',$aspek_keterangan[85]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Es (apabila digunakan)</td>
  <td class="atas isi"><?php echo  str_replace('112|','',$aspek_penilaian[112]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point87_fisik">
  <td width="20">87.</td>
  <td width="400">Tidak terbuat dari air  yang memenuhi persyaratan <em>(potable)</em></td>         
  <td width="90"><?php echo  str_replace('113|','',$aspek_penilaian[113]); ?></td>
  <td width="300"><?php echo str_replace('86|','',$aspek_keterangan[86]); ?></td>
</tr>
<tr id="point88_fisik">
  <td>88.</td>
  <td width="400">Tidak dibuat dari air  yang telah diijinkan</td>           
  <td width="90"><?php echo  str_replace('114|','',$aspek_penilaian[114]); ?></td>
  <td width="300"><?php echo str_replace('87|','',$aspek_keterangan[87]); ?></td>
</tr>
<tr id="point89_fisik">
  <td>89.</td>
  <td width="400">Tidak dibuat, ditangani  dan digunakan sesuai persyaratan sanitasi</td>    
  <td width="90"><?php echo  str_replace('115|','',$aspek_penilaian[115]); ?></td>
  <td width="300"><?php echo str_replace('88|','',$aspek_keterangan[88]); ?></td>
</tr>
<tr id="point90_fisik">
  <td>90.</td>
  <td width="400">Digunakan kembali  untuk bahan baku  yang diproses berikutnya</td>    
  <td width="90"><?php echo  str_replace('116|','',$aspek_penilaian[116]); ?></td>
  <td width="300"><?php echo str_replace('89|','',$aspek_keterangan[89]); ?></td>
</tr>

<tr>
  <td width="20">m.</td>
  <td colspan="3">Sanitasi dan Higiene Karyawan</td>
  </tr>
<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Pembinaan Karyawan</td>
  <td class="atas isi"><?php echo  str_replace('117|','',$aspek_penilaian[117]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point91_operasional">
  <td width="20">91.</td>
  <td width="400">Manajemen unit  pengolahan tidak memiliki tidakan-tindakan efektif untuk mencegah karyawan yang  diketahui menghidap penyakit yang dapat mengkontaminasi produk <em>(luka, TBC, Hepatitis, Tipus dsb.)</em></td>     
  <td width="90"><?php echo  str_replace('118|','',$aspek_penilaian[118]); ?></td>
  <td width="300"><?php echo str_replace('90|','',$aspek_keterangan[90]); ?></td>
</tr>
<tr id="point92_operasional">
  <td>92.</td>
  <td width="400">Pelatihan pekerja  dalam hal sanitasi dan higiene tidak cukup</td>      
  <td width="90"><?php echo  str_replace('119|','',$aspek_penilaian[119]); ?></td>
  <td width="300"><?php echo str_replace('91|','',$aspek_keterangan[91]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Perilaku Karyawan</td>
  <td class="atas isi"><?php echo  str_replace('120|','',$aspek_penilaian[120]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point93_operasional">
  <td width="20">93.</td>
  <td width="400">Kebersihan karyawan  tidak dijaga dengan baik dan tidak memperhatikan aspek sanitasi dan higiene <em>(seperti pakaian kurang</em> <em>lengkap dan kotor, meludah di ruang</em> <em>pengolahan, merokok dan</em> <em>lain-lain)</em></td>      
  <td width="90"><?php echo  str_replace('121|','',$aspek_penilaian[121]); ?></td>
  <td width="300"><?php echo str_replace('92|','',$aspek_keterangan[92]); ?></td>
</tr>
<tr id="point94_operasional">
  <td>94.</td>
  <td width="400">Tindak-tanduk  karyawan tidak mampu mengurangi dan mencegah kontaminasi baik dari mikroba  maupun benda asing lainnya</td>    
  <td width="90"><?php echo  str_replace('122|','',$aspek_penilaian[122]); ?></td>
  <td width="300"><?php echo str_replace('93|','',$aspek_keterangan[93]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Sanitasi Karyawan</td>
  <td class="atas isi"><?php echo  str_replace('123|','',$aspek_penilaian[123]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point95_operasional">
  <td width="20">95.</td>
  <td width="400">Pakain kerja tidak  dipakai dengan benar dan tidak bersih</td>      
  <td width="90"><?php echo  str_replace('124|','',$aspek_penilaian[124]); ?></td>
  <td width="300"><?php echo str_replace('94|','',$aspek_keterangan[94]); ?></td>
</tr>
<tr id="point96_operasional">
  <td>96.</td>
  <td width="400">Tidak ada pengawasan  dalam sanitasi, pencucian tangan dan kaki sebelum masuk ruang pengolahan dan  setelah keluar dari toilet</td>        
  <td width="90"><?php echo  str_replace('125|','',$aspek_penilaian[125]); ?></td>
  <td width="300"><?php echo str_replace('95|','',$aspek_keterangan[95]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Sumber infeksi</td>
  <td class="atas isi"><?php echo  str_replace('126|','',$aspek_penilaian[126]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point97_operasional">
  <td width="20">97.</td>
  <td width="400">Karyawan tidak bebas  dari penyakit kulit, atau penyakit menular lainnya</td>   
  <td width="90"><?php echo  str_replace('127|','',$aspek_penilaian[127]); ?></td>
  <td width="300"><?php echo str_replace('96|','',$aspek_keterangan[96]); ?></td>
</tr>

<tr>
  <td width="20">n.</td>
  <td colspan="3">Gudang biasa (kering)</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Kontrol sanitasi</td>
  <td class="atas isi"><?php echo  str_replace('128|','',$aspek_penilaian[128]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point98_fisik">
  <td width="20">98.</td>
  <td width="400">Tidak menggunakan  tempat penyimpanan seperti pallet, lemari, kabinet rak dan lain-lain yang  dibutuhkan untuk mencegah kontaminasi.</td>  
  <td width="90"><?php echo  str_replace('129|','',$aspek_penilaian[129]); ?></td>
  <td  width="300"><?php echo str_replace('97|','',$aspek_keterangan[97]); ?></td>
</tr>
<tr id="point99_operasional">
  <td>99.</td>
  <td width="400">Metode penyimpanan  bahan berpeluang terjadinya kontaminasi</td>   
  <td width="90"><?php echo  str_replace('130|','',$aspek_penilaian[130]); ?></td>
  <td width="300"><?php echo str_replace('98|','',$aspek_keterangan[98]); ?></td>
</tr>
<tr id="point100_fisik">
  <td>100.</td>
  <td width="400">Fasilitas penyimpanan  tidak bersih, tidak saniter dan tidak dirawat dengan baik </td>      
  <td width="90"><?php echo  str_replace('131|','',$aspek_penilaian[131]); ?></td>
  <td width="300"><?php echo str_replace('99|','',$aspek_keterangan[99]); ?></td>
</tr>
<tr id="point101_operasional">
  <td>101.</td>
  <td width="400">Penempatan barang tidak teratur dan tidak  dipisah-pisahkan (Penyimpanan bahan pengemas  dan bahan-bahan lain: kimia, bahan berbahaya dll)</td>  
  <td width="90"><?php echo  str_replace('132|','',$aspek_penilaian[132]); ?></td>
  <td width="300"><?php echo str_replace('100|','',$aspek_keterangan[100]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Pencegahan serangga, tikus, dan binatang lain</td>
  <td class="atas isi"><?php echo  str_replace('133|','',$aspek_penilaian[133]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point102_operasional">
  <td width="20">102.</td>
  <td width="400">Tidak ada pengendalian  untuk mencegah serangga, tikus dan binatang pengganggu lainnya digudang</td>     
  <td width="90"><?php echo  str_replace('134|','',$aspek_penilaian[134]); ?></td>
  <td width="300"><?php echo str_replace('101|','',$aspek_keterangan[101]); ?></td>
</tr>
<tr id="point103_operasional">
  <td>103.</td>
  <td width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif</td>  
  <td width="90"><?php echo  str_replace('135|','',$aspek_penilaian[135]); ?></td>
  <td width="300"><?php echo str_replace('102|','',$aspek_keterangan[102]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Ventilasi</td>
  <td class="atas isi"><?php echo  str_replace('136|','',$aspek_penilaian[136]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point104_fisik">
  <td width="20">104.</td>
  <td width="400">Ventilasi tidak  berfungsi dengan baik</td>    
  <td width="90"><?php echo  str_replace('137|','',$aspek_penilaian[137]); ?></td>
  <td width="300"><?php echo str_replace('103|','',$aspek_keterangan[103]); ?></td>
</tr>

<tr>
  <td width="20">o.</td>
  <td colspan="3">Gudang  Beku, Dingin (apabila digunakan)</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td width="400">Kontrol sanitasi</td>
  <td class="atas isi"><?php echo  str_replace('138|','',$aspek_penilaian[138]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point105_fisik">
  <td width="20">105.</td>
  <td width="400">Metode penyimpanan  bahan-bahan berpeluang terjadinya  kontaminasi.</td>       
  <td width="90"><?php echo  str_replace('139|','',$aspek_penilaian[139]); ?></td>
  <td width="300"><?php echo str_replace('104|','',$aspek_keterangan[104]); ?></td>
</tr>
<tr id="point106_fisik">
  <td>106.</td>
  <td width="400">Fasilitas penyimpanan  tidak bersih, saniter dan tidak dirawat dengan baik </td>    
  <td width="90"><?php echo  str_replace('140|','',$aspek_penilaian[140]); ?></td>
  <td width="300"><?php echo str_replace('105|','',$aspek_keterangan[105]); ?></td>
</tr>
<tr id="point107_fisik">
  <td>107.</td>
  <td width="400">Tidak ada pemisahan  barang secara teratur</td>   
  <td width="90"><?php echo  str_replace('141|','',$aspek_penilaian[141]); ?></td>
  <td width="300"><?php echo str_replace('106|','',$aspek_keterangan[106]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Pencegahan serangga, tikus, dan binatang lain</td>
  <td class="atas isi"><?php echo  str_replace('142|','',$aspek_penilaian[142]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point108_fisik">
  <td width="20">108.</td>
  <td width="400">Tidak ada pengendalian untuk mencegah serangga,  digudang</td>      
  <td width="90"><?php echo  str_replace('143|','',$aspek_penilaian[143]); ?></td>
  <td width="300"><?php echo str_replace('107|','',$aspek_keterangan[107]); ?></td>
</tr>
<tr id="point109_operasional">
  <td>109.</td>
  <td width="400">Pencegahan serangga, tidak  efektif</td>       
  <td width="90"><?php echo  str_replace('144|','',$aspek_penilaian[144]); ?></td>
  <td width="300"><?php echo str_replace('108|','',$aspek_keterangan[108]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Kontrol suhu</td>
  <td class="atas isi"><?php echo  str_replace('145|','',$aspek_penilaian[145]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point110_fisik">
  <td width="20">110.</td>
  <td width="400">Produk beku tidak  terlindung dari peningkatan suhu</td>       
  <td width="90"><?php echo  str_replace('146|','',$aspek_penilaian[146]); ?></td>
  <td width="300"><?php echo str_replace('109|','',$aspek_keterangan[109]); ?></td>
</tr>
<tr id="point111_fisik">
  <td>111.</td>
  <td width="400">Ruang penyimpanan  tidak dilengkapi dengan kontrol suhu</td>       
  <td width="90"><?php echo  str_replace('147|','',$aspek_penilaian[147]); ?></td>
  <td width="300"><?php echo str_replace('110|','',$aspek_keterangan[110]); ?></td>
</tr>
<tr id="point112_fisik">
  <td>112.</td>
  <td width="400">Ada bahan yang  mengandung zat logam disimpan dengan produk</td>       
  <td width="90"><?php echo  str_replace('148|','',$aspek_penilaian[148]); ?></td>
  <td width="300"><?php echo str_replace('111|','',$aspek_keterangan[111]); ?></td>
</tr>
<tr id="point113_fisik">
  <td>113.</td>
  <td width="400">Ruang penyimpanan  produk tidak dioperasikan pada suhu yang dipersyaratkan</td>       
  <td width="90"><?php echo  str_replace('149|','',$aspek_penilaian[149]); ?></td>
  <td width="300"><?php echo str_replace('112|','',$aspek_keterangan[112]); ?></td>
</tr>

<tr>
  <td width="20">p.</td>
  <td colspan="3">Gudang kemasan produk</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Kontrol sanitasi</td>
  <td class="atas isi"><?php echo  str_replace('150|','',$aspek_penilaian[150]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point114_fisik">
  <td width="20">114.</td>
  <td width="400">Tidak menggunakan  tempat penyimpanan seperti pallet atau  rak dan lain-lain yang dibutuhkan untuk mencegah kontaminasi</td>       
  <td width="90"><?php echo  str_replace('151|','',$aspek_penilaian[151]); ?></td>
  <td width="300"><?php echo str_replace('113|','',$aspek_keterangan[113]); ?></td>
</tr>
<tr id="point115_operasional">
  <td>115.</td>
  <td width="400">Metode penyimpanan  bahan-bahan berpeluang terjadinya kontaminasi</td>    
  <td width="90"><?php echo  str_replace('152|','',$aspek_penilaian[152]); ?></td>
  <td width="300"><?php echo str_replace('114|','',$aspek_keterangan[114]); ?></td>
</tr>
<tr id="point116_fisik">
  <td>116.</td>
  <td width="400">Fasilitas penyimpanan  tidak bersih, tidak saniter dan tidak dirawat dengan baik </td>  
  <td width="90"><?php echo  str_replace('153|','',$aspek_penilaian[153]); ?></td>
  <td width="300"><?php echo str_replace('115|','',$aspek_keterangan[115]); ?></td>
</tr>
<tr id="point117_fisik">
  <td>117.</td>
  <td width="400">Wadah atau pengemas tidak disimpan pada tempat yang  bersih, rapi dan terlindung dari kontaminasi</td>     
  <td width="90"><?php echo  str_replace('154|','',$aspek_penilaian[154]); ?></td>
  <td width="300"><?php echo str_replace('116|','',$aspek_keterangan[116]); ?></td>
</tr>
<tr id="point118_fisik">
  <td>118.</td>
  <td width="400">Tidak terpisah pada  tempat khusus</td>  
  <td width="90"><?php echo  str_replace('155|','',$aspek_penilaian[155]); ?></td>
  <td width="300"><?php echo str_replace('117|','',$aspek_keterangan[117]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Pencegahan serangga, tikus, dan binatang lain</td>
  <td class="atas isi"><?php echo  str_replace('156|','',$aspek_penilaian[156]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point119_operasional">
  <td width="20">119.</td>
  <td width="400">Tidak ada  pengendalian untuk mencegah serangga,  tikus dan binatang pengganggu lainnya digudang</td>     
  <td width="90"><?php echo  str_replace('157|','',$aspek_penilaian[157]); ?></td>
  <td width="300"><?php echo str_replace('118|','',$aspek_keterangan[118]); ?></td>
</tr>
<tr id="point120_fisik">
  <td>120.</td>
  <td width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif</td> 
  <td width="90"><?php echo  str_replace('158|','',$aspek_penilaian[158]); ?></td>
  <td width="300"><?php echo str_replace('119|','',$aspek_keterangan[119]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Ventilasi</td>
  <td class="atas isi"><?php echo  str_replace('159|','',$aspek_penilaian[159]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point121_fisik">
  <td width="20">121.</td>
  <td width="400">Ventilasi tidak  berfungsi dengan baik</td>     
  <td width="90"><?php echo  str_replace('160|','',$aspek_penilaian[160]); ?></td>
  <td width="300"><?php echo str_replace('120|','',$aspek_keterangan[120]); ?></td>
</tr>

<tr>
  <td width="20">q.</td>
  <td width="400">Tindakan Pengawasan</td>
  <td></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td width="400">Bahan baku/mentah</td>
  <td class="atas isi"><?php echo  str_replace('161|','',$aspek_penilaian[161]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point122_operasional">
  <td>122.</td>
  <td width="400">Tidak dilakukan  pengujian mutu sebelum diolah</td>      
  <td width="90"><?php echo str_replace('162|','',$aspek_penilaian[162]); ?></td>
  <td width="300"><?php echo str_replace('121|','',$aspek_keterangan[121]); ?></td>
</tr>
<tr id="point123_operasional">
  <td>123.</td>
  <td width="400">Campuran bahan baku tidak disesuaikan  spesifikasi</td>    
  <td width="90"><?php echo  str_replace('162|','',$aspek_penilaian[162]); ?></td>
  <td width="300"><?php echo str_replace('122|','',$aspek_keterangan[122]); ?></td>
</tr>
<tr id="point124_operasional">
  <td>124.</td>
  <td width="400">Bahan Tambahan Pangan  tidak sesuai dengan peraturan</td> 
  <td width="90"><?php echo  str_replace('164|','',$aspek_penilaian[164]); ?></td>
  <td width="300"><?php echo str_replace('123|','',$aspek_keterangan[123]); ?></td>
</tr>
<tr id="point125_operasional">
  <td>125.</td>
  <td width="400">Proses Produksi tidak  dilakukan pengawasan setiap tahap</td>    
  <td width="90"><?php echo  str_replace('165|','',$aspek_penilaian[165]); ?></td>
  <td width="300"><?php echo str_replace('124|','',$aspek_keterangan[124]); ?></td>
</tr>
<tr id="point126_operasional">
  <td>126.</td>
  <td width="400">Produk akhir tidak  dilakukan pengujian mutu sebelum diedarkan</td>      
  <td width="90"><?php echo  str_replace('166|','',$aspek_penilaian[166]); ?></td>
  <td width="300"><?php echo str_replace('125|','',$aspek_keterangan[125]); ?></td>
</tr>
<tr id="point127_operasional">
  <td>127.</td>
  <td width="400">Penyimpanan bahan baku  dan produk akhir tidak dipisahkan</td>      
  <td width="90"><?php echo  str_replace('167|','',$aspek_penilaian[167]); ?></td>
  <td width="300"><?php echo str_replace('126|','',$aspek_keterangan[126]); ?></td>
</tr>
<tr id="point128_operasional">
  <td>128.</td>
  <td width="400">Penyimpanan dan  penyerahan tidak dilakukan secara FIFO</td>    
  <td width="90"><?php echo  str_replace('168|','',$aspek_penilaian[168]); ?></td>
  <td width="300"><?php echo str_replace('127|','',$aspek_keterangan[127]); ?></td>
</tr>

<tr>
  <td width="20">r.</td>
  <td width="400">Bahan mentah dan produk akhir</td>
  <td class="atas isi"></td>
  <td width="300">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Kontaminasi</td>
  <td class="atas isi"><?php echo  str_replace('169|','',$aspek_penilaian[169]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point129_operasional">
  <td>129.</td>
  <td width="400">Terindikasi adanya  kontaminan setelah dilakukan pengujian bahan mentah atau produk akhir</td>      
  <td width="90"><?php echo  str_replace('170|','',$aspek_penilaian[170]); ?></td>
  <td width="300"><?php echo str_replace('128|','',$aspek_keterangan[128]); ?></td>
</tr>
<tr id="point130_operasional">
  <td>130.</td>
  <td width="400">Teridikasi adanya  kemunduran mutu/deteriorasi/dekomposisi setelah dilakukan pengujian bahan  mentah dan produk akhir</td>     
  <td width="90"><?php echo str_replace('171|','',$aspek_penilaian[171]); ?></td>
  <td width="300"><?php echo str_replace('129|','',$aspek_keterangan[129]); ?></td>
</tr>
<tr id="point131_operasional">
  <td>131.</td>
  <td width="400">Terindikasi adanya  pencemaran fisik benda-benda asing setelah dilakukan pengujian bahan mentah dan  produk akhir</td>      
  <td width="90"><?php echo  str_replace('172|','',$aspek_penilaian[172]); ?></td>
  <td width="300"><?php echo str_replace('130|','',$aspek_keterangan[130]); ?></td>
</tr>
<tr id="point132_operasional">
  <td>132.</td>
  <td width="400">Penanganan,  Pengolahan, penyimpanan, pengangkutan dan pengemasan tidak dilakukan secara  higienis</td>       
  <td width="90"><?php echo  str_replace('173|','',$aspek_penilaian[173]); ?></td>
  <td width="300"><?php echo str_replace('131|','',$aspek_keterangan[131]); ?></td>
</tr>

<tr>
  <td width="20">s.</td>
  <td colspan="3">Hasil Uji</td>
  </tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Pengujian bahan baku dan produk akhir</td>
  <td class="atas isi"><?php echo  str_replace('174|','',$aspek_penilaian[174]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point133_operasional">
  <td width="20">133.</td>
  <td width="400">Tidak dilakukan  pengujian</td>     
  <td width="90"><?php echo  str_replace('175|','',$aspek_penilaian[175]); ?></td>
  <td width="300"><?php echo str_replace('132|','',$aspek_keterangan[132]); ?></td>
</tr>
<tr id="point134_fisik">
  <td>134.</td>
  <td width="400">Tidak memiliki  laboratorium yang sekurang-kurangnya dilengkapi dengan peralatan dan media  untuk pengujian organoleptik dan mikrobiologi</td>     
  <td width="90"><?php echo  str_replace('176|','',$aspek_penilaian[176]); ?></td>
  <td width="300"><?php echo str_replace('133|','',$aspek_keterangan[133]); ?></td>
</tr>
<tr id="point135_operasional">
  <td>135.</td>
  <td width="400">Jumlah tenaga  laboratorium tidak mencukupi dan atau kualifikasi tenaganya tidak memadai</td>  
  <td width="90"><?php echo str_replace('177|','',$aspek_penilaian[177]); ?></td>
  <td width="300"><?php echo str_replace('134|','',$aspek_keterangan[134]); ?></td>
</tr>
<tr id="point136_operasional">
  <td>136.</td>
  <td width="400">Tidak aktif  melaksanakan monitoring terhadap bahan baku,  bahan pembantu, kebersihan peralatan dan produk akhir</td>      
  <td width="90"><?php echo  str_replace('178|','',$aspek_penilaian[178]); ?></td>
  <td width="300"><?php echo str_replace('135|','',$aspek_keterangan[135]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Hasil Uji tidak memenuhi persyaratan</td>
  <td class="atas isi"><?php echo  str_replace('179|','',$aspek_penilaian[179]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point137_operasional">
  <td width="20">137.</td>
  <td width="400">Angka Lempeng Total  (ALT)</td>   
  <td width="90"><?php echo  str_replace('180|','',$aspek_penilaian[180]); ?></td>
  <td width="300"><?php echo str_replace('136|','',$aspek_keterangan[136]); ?></td>
</tr>
<tr id="point138_operasional">
  <td>138.</td>
  <td width="400">Staphyloccocci</td>
  <td width="90"><?php echo  str_replace('181|','',$aspek_penilaian[181]); ?></td>
  <td width="300"><?php echo str_replace('137|','',$aspek_keterangan[137]); ?></td>
</tr>
<tr id="point139_operasional">
  <td>139.</td>
  <td width="400">M.P.N. Coliform</td> 
  <td width="90"><?php echo  str_replace('182|','',$aspek_penilaian[182]); ?></td>
  <td width="300"><?php echo str_replace('138|','',$aspek_keterangan[138]); ?></td>
</tr>
<tr id="point140_operasional">
  <td>140.</td>
  <td width="400">Faecal Streptococci</td>   
  <td width="90"><?php echo  str_replace('183|','',$aspek_penilaian[183]); ?></td>
  <td width="300"><?php echo str_replace('139|','',$aspek_keterangan[139]); ?></td>
</tr>

<tr>
  <td width="20">t.</td>
  <td colspan="3">Tindakan pengawasan</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td width="400">Jaminan mutu</td>
  <td class="atas isi"><?php echo  str_replace('184|','',$aspek_penilaian[184]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point141_operasional">
  <td width="20">141.</td>
  <td width="400">Tidak dilakukan sistem jaminan  mutu pada keseluruhan proses (in-process)</td>            
  <td width="90"><?php echo str_replace('185|','',$aspek_penilaian[185]); ?></td>
  <td width="300"><?php echo str_replace('140|','',$aspek_keterangan[140]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Prosedur Pelacakan & Penarikan (Recall Procedure)</td>
  <td class="atas isi"><?php echo  str_replace('186|','',$aspek_penilaian[186]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point142_operasional">
  <td width="20">142.</td>
  <td width="400">Tidak dilakukan dengan  baik, teratur dan kontinu</td>            
  <td width="90"><?php echo  str_replace('187|','',$aspek_penilaian[187]); ?></td>
  <td width="300"><?php echo str_replace('141|','',$aspek_keterangan[141]); ?></td>
</tr>

<tr>
  <td width="20">u.</td>
  <td width="400">Sarana Pengolahan / Pengawetan</td>
  <td>&nbsp;</td>
  <td width="300">&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td width="400">Pendinginan, Pembekuan, Pengalengan, Pengeringan dan Pengolahan lainnya</td>
  <td class="atas isi"><?php echo  str_replace('188|','',$aspek_penilaian[188]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point143_fisik">
  <td>143.</td>
  <td width="400">Sarana  pengolahan/pengawetan tidak mencukupi</td>            
  <td width="90"><?php echo  str_replace('189|','',$aspek_penilaian[189]); ?></td>
  <td width="300"><?php echo str_replace('142|','',$aspek_keterangan[142]); ?></td>
</tr>
<tr id="point144_operasional">
  <td>144.</td>
  <td width="400">Suhu dan waktu pengolahan/ pengawetan tidak sesuai persyaratan</td>   
  <td width="90"><?php echo  str_replace('190|','',$aspek_penilaian[190]); ?></td>
  <td width="300"><?php echo str_replace('143|','',$aspek_keterangan[143]); ?></td>
</tr>

<tr>
  <td width="20">v.</td>
  <td colspan="3">Penggunaan bahan kimia</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td width="400">Insektisida/Rodentisida/peptisida</td>
  <td class="atas isi"><?php echo  str_replace('191|','',$aspek_penilaian[191]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point145_fisik">
  <td width="20">145.</td>
  <td width="400">Insektisida/rodentisida tidak sesuai persyaratan</td> 
  <td width="90"><?php echo  str_replace('192|','',$aspek_penilaian[192]); ?></td>
  <td width="300"><?php echo str_replace('144|','',$aspek_keterangan[144]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Bahan kimia/sanitizer/deterjen dll</td>
  <td class="atas isi"><?php echo  str_replace('193|','',$aspek_penilaian[193]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point146_fisik">
  <td width="20">146.</td>
  <td width="400">Bahan kimia tidak digunakan  sesuai metode yang dipersyaratkan</td>
  <td width="90"><?php echo  str_replace('194|','',$aspek_penilaian[194]); ?></td>
  <td width="300"><?php echo str_replace('145|','',$aspek_keterangan[145]); ?></td>
</tr>
<tr id="point147_fisik">
  <td>147.</td>
  <td width="400">Bahan kimia,  sanitizer dan bahan tambahan tidak diberi label dan disimpan dengan baik</td>     
  <td width="90"><?php echo  str_replace('195|','',$aspek_penilaian[195]); ?></td>
  <td width="300"><?php echo str_replace('146|','',$aspek_keterangan[146]); ?></td>
</tr>
<tr id="point148_fisik">
  <td>148.</td>
  <td width="400">Penggunaan bahan  kimia yang tidak diijinkan</td>
  <td width="90"><?php echo  str_replace('196|','',$aspek_penilaian[196]); ?></td>
  <td width="300"><?php echo str_replace('147|','',$aspek_keterangan[147]); ?></td>
</tr>

<tr>
  <td width="20">w.</td>
  <td colspan="3">Bahan, Penanganan dan Pengolahan</td>
  </tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Bahan baku</td>
  <td class="atas isi"><?php echo  str_replace('197|','',$aspek_penilaian[197]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point149_operasional">
  <td width="20">149.</td>
  <td width="400">Tidak sesuai dengan  standar sehingga membahayakan kesehatan manusia</td>      
  <td width="90"><?php echo  str_replace('198|','',$aspek_penilaian[198]); ?></td>
  <td width="300"><?php echo str_replace('148|','',$aspek_keterangan[148]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Bahan Tambahan</td>
  <td class="atas isi"><?php echo  str_replace('199|','',$aspek_penilaian[199]); ?></td>
  <td width="300">&nbsp;</td>
</tr>
<tr id="point150_operasional">
  <td width="20">150.</td>
  <td width="400">Tidak sesuai dengan standar dan pemakaiannya tidak sesuai dengan persyaratan</td>    
  <td width="90"><?php echo  str_replace('200|','',$aspek_penilaian[200]); ?></td>
  <td width="300"><?php echo str_replace('149|','',$aspek_keterangan[149]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td class="atas isi">Penanganan bahan baku</td>
  <td class="atas isi"><?php echo  str_replace('201|','',$aspek_penilaian[201]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point151_operasional">
  <td width="20">151.</td>
  <td width="400">Penerimaan bahan baku tidak dilakukan  dengan baik, dan tidak terlindung dari kontaminan atau pengaruh  lingkungan yang tidak sehat</td> 
  <td width="90"><?php echo  str_replace('202|','',$aspek_penilaian[202]); ?></td>
  <td width="300"><?php echo str_replace('150|','',$aspek_keterangan[150]); ?></td>
</tr>
<tr id="point152_operasional">
  <td>152.</td>
  <td width="400">Suhu produk yang  diolah di dalam ruang pengolahan tidak sesuai syarat</td>   
  <td width="90"><?php echo  str_replace('203|','',$aspek_penilaian[203]); ?></td>
  <td width="300"><?php echo str_replace('151|','',$aspek_keterangan[151]); ?></td>
</tr>
<tr id="point153_operasional">
  <td>153.</td>
  <td width="400">Bahan baku yang datang terlebih  dahulu tidak diproses lebih dahulu (Sistem FIFO)</td>       
  <td width="90"><?php echo  str_replace('204|','',$aspek_penilaian[204]); ?></td>
  <td width="300"><?php echo str_replace('152|','',$aspek_keterangan[152]); ?></td>
</tr>
<tr id="point154_operasional">
  <td>154.</td>
  <td width="400">Penanganan bahan baku ataupun produk dari  tahap satu ke tahap berikutnya tidak dilakukan secara hati-hati, higienes dan  saniter</td> 
  <td width="90"><?php echo  str_replace('205|','',$aspek_penilaian[205]); ?></td>
  <td width="300"><?php echo str_replace('153|','',$aspek_keterangan[153]); ?></td>
</tr>
<tr id="point155_operasional">
  <td>155.</td>
  <td width="400">Penanganan produk  yang sedang menunggu giliran untuk diproses tidak disimpan/dikumpulkan di  tempat yang saniter</td>   
  <td width="90"><?php echo  str_replace('206|','',$aspek_penilaian[206]); ?></td>
  <td width="300"><?php echo str_replace('154|','',$aspek_keterangan[154]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td width="400">Pengolahan</td>
  <td class="atas isi"><?php echo  str_replace('207|','',$aspek_penilaian[207]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point156_operasional">
  <td width="20">156.</td>
  <td width="400">Proses pengolahan/pengawetan dilakukan tidak sesuai dengan jenis produk dan suhu serta  waktunya tidak sesuai dengan persyaratan</td>     
  <td width="90"><?php echo  str_replace('208|','',$aspek_penilaian[208]); ?></td>
  <td width="300"><?php echo str_replace('155|','',$aspek_keterangan[155]); ?></td>
</tr>
<tr id="point157_operasional">
  <td>157.</td>
  <td width="400">Produk akhir tidak  mempunyai ukuran dan bentuk yang teratur</td> 
  <td width="90"><?php echo  str_replace('209|','',$aspek_penilaian[209]); ?></td>
  <td width="300"><?php echo str_replace('156|','',$aspek_keterangan[156]); ?></td>
</tr>
<tr id="point158_operasional">
  <td>158.</td>
  <td width="400">Sistem pemberian  etiket atau kode-kode tidak dilakukan pada waktu memproses bahan baku yang dapat membantu identifikasi produk</td>
  <td width="90"><?php echo  str_replace('210|','',$aspek_penilaian[210]); ?></td>
  <td width="300"><?php echo str_replace('157|','',$aspek_keterangan[157]); ?></td>
</tr>

<tr>
  <td>&nbsp;</td>
  <td>Pewadahan dan atau Pengemasan</td>
  <td class="atas isi"><?php echo  str_replace('211|','',$aspek_penilaian[211]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point159_operasional">
  <td width="20">159.</td>
  <td width="400">Produk akhir tidak  dikemas dan atau diwadahi dengan cepat, tepat dan saniter</td>  
  <td width="90"><?php echo  str_replace('212|','',$aspek_penilaian[212]); ?></td>
  <td width="300"><?php echo str_replace('158|','',$aspek_keterangan[158]); ?></td>
</tr>
<tr id="point160_operasional">
  <td>160.</td>
  <td width="400">Produk akhir tidak  diberi label yang memuat : jenis produk, nama perusahaan pembuat, ukuran, tipe, grade <em>(tingkatan mutu)</em>, tanggal kadaluwarsa, berat bersih, nama bahan tambahan makanan yang dipakai, kode produksi atau persyaratan lain</td>  
  <td width="90"><?php echo  str_replace('213|','',$aspek_penilaian[213]); ?></td>
  <td width="300"><?php echo str_replace('159|','',$aspek_keterangan[159]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Penyimpanan</td>
  <td class="atas isi"><?php echo  str_replace('214|','',$aspek_penilaian[214]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point161_operasional">
  <td width="20">161.</td>
  <td width="400">Produk akhir yang  disimpan dalam gudang tidak dipisah dengan barang lain</td>     
  <td width="90"><?php echo  str_replace('215|','',$aspek_penilaian[215]); ?></td>
  <td width="300"><?php echo str_replace('160|','',$aspek_keterangan[160]); ?></td>
</tr>
<tr id="point162_operasional">
  <td>162.</td>
  <td width="400">Susunan produk akhir  tidak memungkinkan mempengaruhi kondisi masing-masing kemasan dan tidak  memungkinkan produk akhir yang lebih lama disimpan dikeluarkan terlebih dahulu  (tidak mengikuti FIFO).</td>
  <td width="90"><?php echo str_replace('216|','',$aspek_penilaian[216]); ?></td>
  <td width="300"><?php echo str_replace('161|','',$aspek_keterangan[161]); ?></td>
</tr>

<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Penyimpanan bahan berbahaya</td>
  <td class="atas isi"><?php echo  str_replace('217|','',$aspek_penilaian[217]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point163_fisik">
  <td width="20">163.</td>
  <td width="400">Tidak tersendiri dan dapat terhindar dari hal-hal yang dapat membahayakan</td>     
  <td width="90"><?php echo  str_replace('218|','',$aspek_penilaian[218]); ?></td>
  <td width="300"><?php echo str_replace('162|','',$aspek_keterangan[162]); ?></td>
</tr>
<tr id="point164_fisik">
  <td>164.</td>
  <td width="400">Tidak ada tanda  peringatan</td>   
  <td width="90"><?php echo str_replace('219|','',$aspek_penilaian[219]); ?></td>
  <td width="300"><?php echo str_replace('163|','',$aspek_keterangan[163]); ?></td>
</tr>
<tr>
  <td width="20">&nbsp;</td>
  <td width="400">Pengangkutan dan Distribusi</td>
  <td class="atas isi"><?php echo str_replace('220|','',$aspek_penilaian[220]); ?></td>
  <td>&nbsp;</td>
</tr>
<tr id="point165_operasional">
  <td width="20">165.</td>
  <td width="400">Kendaraan <em>(kontainer)</em> yang dipakai untuk  mengangkut produk akhir tidak mampu mempertahankan kondisi/ keawetan yang  dipersyaratkan</td>     
  <td width="90"><?php echo  str_replace('221|','',$aspek_penilaian[221]); ?></td>
  <td width="300"><?php echo str_replace('164|','',$aspek_keterangan[164]); ?></td>
</tr>
<tr id="point166_operasional">
  <td>166.</td>
  <td width="400">Pembongkaran tidak  dilakukan dengan cepat, cermat dan terhindar dari pengaruh yang menyebabkan  kemunduran mutu</td>      
  <td width="90"><?php echo  str_replace('222|','',$aspek_penilaian[222]); ?></td>
  <td width="300"><?php echo str_replace('165|','',$aspek_keterangan[165]); ?></td>
</tr>
</table>


<pagebreak sheet-size="210mm 330mm" />
<p><b>Lampiran IV</b></p>
<h2 class="small garis">Hasil dan Penilaian</h2>  
<table class="form_tabel">
<tr><td colspan="2">1. Penyimpangan (<i>Deficiency</i>)</td></tr>
<tr><td class="td_left" style="margin-left:10px;">a. Penyimpangan Minor</td><td class="td_right"><?php echo $sess['JUMLAH_MINOR']; ?></td></tr>
<tr><td class="td_left" style="margin-left:10px;">b. Penyimpangan Mayor</td><td class="td_right"><?php echo $sess['JUMLAH_MAJOR']; ?></td></tr>
<tr><td class="td_left" style="margin-left:10px;">c. Penyimpangan Serius</td><td class="td_right"><?php echo $sess['JUMLAH_SERIUS']; ?></td></tr>
<tr><td class="td_left" style="margin-left:10px;">d. Penyimpangan Kritis</td><td class="td_right"><?php echo $sess['JUMLAH_KRITIS']; ?></td></tr>
<tr><td class="td_left">2. Tingkat Rating Unit Pengolahan</td><td class="td_right"><?php echo $sess['HASIL']; ?></td></tr>
</table>
<div style="height:10px;"></div>
<h2 class="small garis">Temuan dan Penyimpangan</h2>
<div style="page-break-inside:avoid;"><b>1. Penyimpangan Administratif</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['ADMINISTRATIF'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;">Perbaikan CAPA</div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['ADMINISTRATIF_PERBAIKAN'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;">Timeline</div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo $sess['ADMINISTRATIF_TIMELINE']; ?></div>
<div style="page-break-inside:avoid;"><b>2. Penyimpangan Fisik</b></div>
<div style="page-break-inside:avoid; margin-left:15px;"><ul><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['FISIK'])); ?></ul></div>
<div style="page-break-inside:avoid; margin-left:15px;"><b>Perbaikan CAPA<b></div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['FISIK_PERBAIKAN'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;"><b>Timeline</b></div>
<div style="page-break-inside:avoid; margin-left:15px;">
<?php if(trim($sess['FISIK_TIMELINE']) != ""){
	$arr_fsk = explode(";",$sess['FISIK_TIMELINE']);
	unset($arr_fsk[count($arr_fsk)-1]);
	foreach($arr_fsk as $val_fsk){
		$data_fsk = explode('|', $val_fsk);
		echo '<div>Timeline Point '.$data_fsk[0].'&nbsp; : '.$data_fsk[1].'</div>';
	}
} ?>
</div>
<div style="page-break-inside:avoid;"><b>3. Penyimpangan Operasional</b></div>
<div style="page-break-inside:avoid; margin-left:15px;"><ul><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['OPERASIONAL'])); ?></ul></div>
<div style="page-break-inside:avoid; margin-left:15px;"><b>Perbaikan CAPA<b></div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['OPERASIONAL_PERBAIKAN'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;"><b>Timeline</b></div>
<div style="page-break-inside:avoid; margin-left:15px;">
<?php if(trim($sess['OPERASIONAL_TIMELINE']) != ""){
	$arr_fsk = explode(";",$sess['OPERASIONAL_TIMELINE']);
	unset($arr_fsk[count($arr_fsk)-1]);
	foreach($arr_fsk as $val_fsk){
		$data_fsk = explode('|', $val_fsk);
		echo '<div>Timeline Point  '.$data_fsk[0].'&nbsp; : '.$data_fsk[1].'</div>';
	}
} ?>
</div>
<div style="page-break-inside:avoid;"><b>4. Penyimpangan Lain-lain</b></div>
<div style="page-break-inside:avoid;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['LAINLAIN'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;">Perbaikan CAPA</div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['LAINLAIN_PERBAIKAN'])); ?></div>
<div style="page-break-inside:avoid; margin-left:15px;">Timeline</div>
<div style="page-break-inside:avoid; margin-left:15px;"><?php echo $sess['ADMINISTRATIF_TIMELINE']; ?></div>