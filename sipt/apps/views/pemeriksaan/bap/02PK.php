<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; width:100%; padding:5px;}
table.tb_temuan tr.header th{border-collapse:collapse; text-align:left; padding:5px; border:1px solid #000; height:35px; vertical-align:top;}
table.tb_temuan td{padding:5px;vertical-align:top; border:1px solid #000;}
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
	<tr><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak />

<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa :</b></p>
<table width="100%">
<tr><td width="200">Nama Sarana Distribusi / Toko</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
<tr><td width="200">Alamat Kantor</td><td width="20">:</td><td><?php if(trim($sess['ALAMAT_1']) != "" && $sess['ALAMAT_1'] != "-"){ ?>
<ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Alamat Gudang</td><td width="20">:</td><td><?php if(trim($sess['ALAMAT_2']) != "" && $sess['ALAMAT_2'] != "-"){ ?><ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Telepon</td><td width="20">:</td><td><?php if(trim($sess['TELEPON']) != "" && $sess['TELEPON'] != "-"){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Nama Pimpinan</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td width="200">Nama Penanggung Jawab</td><td width="20">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
	<tr><td width="200">Tanggal Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
	<tr><td width="200">Tujuan Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Hasil Pemeriksaan</b></p>
<table width="100%">
<tr><td width="200">Hasil Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['HASIL']; ?></td></tr>
<?php if($sess["HASIL"] == "TMK") { ?>
<tr><td width="200">Detil Hasil Pemeriksaan</td><td>:</td><td><?php if(trim($sess["DETIL_HASIL"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $detil_hasil = explode("#", $sess['DETIL_HASIL']); echo "<li>".join("</li><li>", $detil_hasil)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200" <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>>Detil Kesimpulan TMK</td><td>:</td><td><?php echo $sess['KESIMPULAN_DETIL_TMK']; ?></td></tr>
<?php }else if($ses["HASIL"] == "MK") { ?>
<tr><td width="200">Catatan</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN'])); ?></td></tr>
<?php }else { ?>
<tr><td width="200">Catatan</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN'])); ?></td></tr>
<?php } ?>
<tr><td width="200">Hasil Temuan diluar Aspek Penilaian</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])); ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Tindak Lanjut</b></p>
<table width="100%">
	<tr><td width="200">Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess["TINDAK_LANJUT_BALAI"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tl_balai = explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul><?php } ?></td></tr>
    <tr><td width="200">Saran Tindak Lanjut</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['SARAN_TL'])); ?></td></tr>
</table>

<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran II</b></p>
<p>Checklist Aspek Penilaian</p>
<h2 class="small">I. Klasifikasi</h2>
<table class="form_tabel">
    <tr><td width="10"></td>
      <td width="405" class="isi">1.1. Bertindak sebagai</td>
      <td class="atas"><?php echo $sess['KLASIFIKASI_PEMERIKSAAN']; ?></td>
      </tr>
</table>

<h2 class="small">II. Administrasi</h2>

<div <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Importir obat tradisional dan / atau suplemen makanan" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan obat tradisional dan / atau suplemen makanan melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?> class="importir">
<table class="form_tabel">
    <tr><td width="10"></td>
      <td colspan="2" class="isi">&bull; Bertindak sebagai importir</td>
      <td class="atas" width="75">&nbsp;</td>
      <td class="atas">&nbsp;</td>
      </tr>
    <tr id="F02OT_point21a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Memiliki surat penunjukan dari produsen di luar negeri</td>
      <td class="atas"><?php echo $aspek_check[0]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[0]; ?></td>
      </tr>
    <tr id="F02OT_point21b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Memiliki Angka Pengelan Impor (API)</td>
      <td class="atas"><?php echo $aspek_check[1]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[1]; ?></td>
      </tr>
    <tr id="F02OT_point21c">
      <td></td>
      <td class="atas">c.</td>
      <td class="atas">Memiliki Surat Keterangan Impor (SKI)</td>
      <td class="atas"><?php echo $aspek_check[2]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[2]; ?></td>
      </tr>
    <tr id="F02OT_point21d">
      <td></td>
      <td class="atas">d.</td>
      <td class="atas">Memiliki Dokumen Persetujuan Pendaftaran</td>
      <td class="atas"><?php echo $aspek_check[3]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[3]; ?></td>
      </tr>
    <tr id="F02OT_point21e">
      <td></td>
      <td class="atas">e.</td>
      <td class="atas">Memiliki faktur / bon penjualan</td>
      <td class="atas"><?php echo $aspek_check[4]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[4]; ?></td>
      </tr>
    <tr id="F02OT_point21f">
      <td></td>
      <td class="atas">f.</td>
      <td class="atas">Ada pencatatan pemasukan dan penjualan dalam kartu stock</td>
      <td class="atas"><?php echo $aspek_check[5]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[5]; ?></td>
      </tr>
</table>
</div>

<div class="badan" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Badan Usaha" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan obat tradisional dan / atau suplemen makanan melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?>>
<table class="form_tabel">
    <tr>
      <td width="10"></td>
      <td colspan="4" class="isi">&bull; Bertindak  Badan Usaha sebagai Pendaftar</td>
      </tr>
    <tr id="F02OT_point22a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Memiliki  surat perjanjian kontrak produksi</td>
      <td class="atas" width="75"><?php echo $aspek_check[6]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[6]; ?></td>
      </tr>
    <tr id="F02OT_point22b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Memiliki Dokumen Persetujuan Pendaftaran</td>                  
      <td class="atas"><?php echo $aspek_check[7]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[7]; ?></td>

      </tr>
    <tr id="F02OT_point22c">
      <td></td>
      <td class="atas">c.</td>
      <td class="atas">Memiliki faktur pembelian / pesanan</td>                  
      <td class="atas"><?php echo $aspek_check[8]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[8]; ?></td>

      </tr>
    <tr id="F02OT_point22d">
      <td></td>
      <td class="atas">d.</td>
      <td class="atas">Mengeluarkan faktur / bon penjualan</td>
      <td class="atas"><?php echo $aspek_check[9]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[9]; ?></td>
      </tr>
    <tr id="F02OT_point22e">
      <td></td>
      <td class="atas">e.</td>
      <td class="atas">Ada pencatatan pemasukan dan penjualan dalam kartu stock</td>
      <td class="atas"><?php echo $aspek_check[10]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[10]; ?></td>
      </tr>
</table>

</div>

<div class="distributor" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Distribusi" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Distributor" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Agen" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Stokist MLM" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Pengobatan Tradisional atau alternatif" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Toko Obat / Swalayan" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Depot jamu / pengecer" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Lain-Lain"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?>>
<table class="form_tabel">
    <tr>
      <td width="10"></td>
      <td colspan="2" class="isi">&bull; Bertindak sebagai Distribusi</td>
      <td class="atas" width="75">&nbsp;</td>
      <td class="atas">&nbsp;</td>
      </tr>
    <tr id="F02OT_point23a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Memiliki  izin sarana yang sesuai</td>
      <td class="atas"><?php echo $aspek_check[11]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[11]; ?></td>
      </tr>
    <tr id="F02OT_point23b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Memiliki  faktur pembelian </td>
      <td class="atas"><?php echo $aspek_check[12]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[12]; ?></td>
      </tr>
    <tr id="F02OT_point23c">
      <td></td>
      <td class="atas">c.</td>
      <td class="atas">Mengeluarkan  bon penjualan </td>
      <td class="atas"><?php echo $aspek_check[13]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[13]; ?></td>
      </tr>
    <tr id="F02OT_point23d">
      <td></td>
      <td class="atas">d.</td>
      <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
      <td class="atas"><?php echo $aspek_check[14]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[14]; ?></td>
      </tr>
</table>
</div>
<h2 class="small">III. Penyimpanan</h2>
<div class="F02OT_gudang">
<table class="form_tabel">
    <tr><td width="10"></td>
      <td colspan="2" class="isi">3.1. Tempat  penyimpanan</td>
      <td class="atas">&nbsp;</td>
  </tr>
    <tr>
      <td></td>
      <td width="20">a.</td>
      <td width="385">Memiliki  gudang</td>
      <td class="atas"><?php echo $aspek_check[15]; ?></td>
  </tr>
</table>
</div>

<div class="detail_gudang" <?php if(is_array($aspek_check)){ if($aspek_check[15] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
<table class="form_tabel">
    <tr id="F02OT_gudang_detail1">
      <td width="10"></td>
      <td width="20">&nbsp;</td>
      <td width="385">- Memiliki gudang pada alamat yang sama</td>
      <td class="atas" width="75"><?php echo $aspek_check[16]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[15]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail2">
      <td></td>
      <td>&nbsp;</td>
      <td>- Memiliki  gudang pada alamat lain</td>
      <td class="atas"><?php echo $aspek_check[17]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[16]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail3">
      <td></td>
      <td>&nbsp;</td>
      <td>- Memiliki  gudang yang memenuhi syarat</td>
      <td class="atas"><?php echo $aspek_check[18]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[17]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail4">
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;1.&nbsp;Kebersihan</td>
      <td class="atas"><?php echo $aspek_check[19]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[18]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail5">
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;2.&nbsp;Terhindar  dari binatang pengerat</td>
      <td class="atas"><?php echo $aspek_check[20]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[19]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail6">
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;3.&nbsp;Dilengkapi  pendingin udara untuk produk tertentu </td>
      <td class="atas"><?php echo $aspek_check[21]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[20]; ?></td>
  </tr>
    <tr id="F02OT_gudang_detail7">
      <td></td>
      <td>&nbsp;</td>
      <td>&nbsp;&nbsp;4.&nbsp;Terhindar  dari kebocoran</td>
      <td class="atas"><?php echo $aspek_check[22]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[21]; ?></td>
  </tr>
</table>
</div>

<div class="F02OT_display_produk">
<table class="form_tabel">
    <tr>
      <td width="10"></td>
      <td width="20">b.</td>
      <td width="385">Tempat  display produk</td>
      <td class="atas"><?php echo $aspek_check[23]; ?></td>
  </tr>
</table>
</div>

<div class="detail_display" <?php if(is_array($aspek_check)){ if($aspek_check[23] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
<table class="form_tabel">
    <tr id="F02OT_display_produk_detail1">
      <td width="10"></td>
      <td width="20">&nbsp;</td>
      <td width="385">- Lemari / tempat tertutup</td>
      <td class="atas" width="75"><?php echo $aspek_check[24]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[22]; ?></td>
      </tr>
    <tr id="F02OT_display_produk_detail2">
      <td></td>
      <td>&nbsp;</td>
      <td>- Rak</td>
      <td class="atas"><?php echo $aspek_check[25]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[23]; ?></td>
      </tr>
    <tr id="F02OT_display_produk_detail3">
      <td></td>
      <td>&nbsp;</td>
      <td>- Lain-lain</td>
      <td class="atas"><?php echo $aspek_check[26]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[24]; ?></td>
      </tr>
</table>
</div>


<div class="F02OT_display_produk1">
<table class="form_tabel">
    <tr>
      <td width="10"></td>
      <td width="20">c.</td>
      <td width="385">Tempat display produk memenuhi syarat</td>
      <td class="atas"><?php echo $aspek_check[27]; ?></td>
      </tr>
</table>
</div>

<div class="detail_syarat" <?php if(is_array($aspek_check)){ if($aspek_check[27] == "Ya"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
<table class="form_tabel">
    <tr id="F02OT_display_produk1_detail1">
      <td width="10"></td>
      <td width="20">&nbsp;</td>
      <td width="385">1. Kebersihan</td>
      <td class="atas" width="75"><?php echo $aspek_check[28]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[25]; ?></td>
      </tr>
    <tr id="F02OT_display_produk1_detail2">
      <td></td>
      <td>&nbsp;</td>
      <td>2. Terhindar  dari binatang pengerat</td>
      <td class="atas"><?php echo $aspek_check[29]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[26]; ?></td>
      </tr>
    <tr id="F02OT_display_produk1_detail3">
      <td></td>
      <td>&nbsp;</td>
      <td>3. Dilengkapi  pendingin udara untuk produk tertentu</td>
      <td class="atas"><?php echo $aspek_check[30]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[27]; ?></td>
      </tr>
    <tr id="F02OT_display_produk1_detail4">
      <td></td>
      <td>&nbsp;</td>
      <td>4. Terhindar  dari kebocoran</td>
      <td class="atas"><?php echo $aspek_check[31]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[28]; ?></td>
      </tr>
</table>
</div>

<div class="F02OT_penyimpanan">
<table class="form_tabel">
    <tr>
      <td></td>
      <td colspan="2" class="isi">3.2. Cara  penyimpanan/penyusunan</td>
      <td class="atas" width="75">&nbsp;</td>
      <td class="atas">&nbsp;</td>
      </tr>
    <tr id="F02OT_point321">
      <td width="10"></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Khusus/  tersendiri</td>
      <td class="atas"><?php echo $aspek_check[32]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[29]; ?></td>
      </tr>
    <tr id="F02OT_point322">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Cara  meletakkan produk teratur</td>
      <td class="atas"><?php echo $aspek_check[33]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[30]; ?></td>
      </tr>
    <tr id="F02OT_point323">
      <td class="atas"></td>
      <td class="atas">c.</td>
      <td class="atas">Mengikuti sistem FIFO</td>
      <td class="atas"><?php echo $aspek_check[34]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[31]; ?></td>
      </tr>
    <tr id="F02OT_point324">
      <td></td>
      <td class="atas">d.</td>
      <td class="atas">Mengikuti  sistem FEFO</td>
      <td class="atas"><?php echo $aspek_check[35]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[32]; ?></td>
      </tr>
    <tr id="F02OT_point325">
      <td></td>
      <td class="atas">e.</td>
      <td class="atas">Bercampur  dengan produk  lain</td>
      <td class="atas"><?php echo $aspek_check[36]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[33]; ?></td>
      </tr>
    <tr id="F02OT_point326">
      <td></td>
      <td class="atas">f.</td>
      <td class="atas">Bercampur  dengan barang lain</td>
      <td class="atas"><?php echo $aspek_check[37]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[34]; ?></td>
      </tr>
</table>
</div>


<?php if($sess['JUMLAH_TEMUAN'] != 0) { ?>
<pagebreak />
<p><b>Lampiran III </b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
    <tr class="header"><th>Detil Produk Komplemen</th><th>Nama<br />Perusahaan</th><th>Kategori<br />Temuan</th><th>Jenis <br /> Pelanggaran</th><th>Harga Total</th><th>Keterangan<br />(sumber perolehan)</th></tr>
  <?php
  if($sess['JUMLAH_TEMUAN'] != 0){
	  for($i=0; $i<count($temuan_produk); $i++){
		  ?>
		  <tr><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br />Klasifikasi : <?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?><br />No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Batch :<?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire :<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?><br>Netto : <?php echo $temuan_produk[$i]['NETTO']; ?><br>Jenis Satuan : <?php echo $temuan_produk[$i]['SATUAN']; ?><br />Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br><?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td><?php echo $temuan_produk[$i]['KATEGORI']; ?></td><td><?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br />Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
		<?php
	  }
  }else{
	  $temuan_produk = "";
  }
  ?>
</table>
<?php } ?>
