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
	<tr><td><?php echo $sess['NAMA_PIMPINAN']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak />

<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa :</b></p>
<table width="100%">
<tr><td width="200">Nama Sarana</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
<tr><td width="200">Alamat</td><td width="20">:</td><td><?php if(trim($sess['ALAMAT_1']) != "" && $sess['ALAMAT_1'] != "-"){ ?>
<ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Telepon</td><td width="20">:</td><td><?php if(trim($sess['TELEPON']) != "" && $sess['TELEPON'] != "-"){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Nama Pemilik</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td width="200">Izin Usaha</td><td width="20">:</td><td><?php echo $sess['IZIN_PERUSAHAAN']; ?></td></tr>
<tr><td width="200">Izin Perdagangan</td><td width="20">:</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
<tr><td width="200">Golongan Sarana</td><td width="20">:</td><td><?php echo $sess['GOLONGAN_SARANA']; ?></td></tr>
<tr><td width="200">Jumlah Karyawan</td><td width="20">:</td><td><?php echo $sess['JUMLAH_KARYAWAN']; ?>&nbsp;Orang</td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
	<tr><td width="200">Tanggal Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Hasil Pemeriksaan</b></p>
<table width="100%">
<tr><td width="200">Hasil Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['HASIL']; ?></td></tr>
<tr><td width="200">Saran</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['REKOMENDASI'])); ?></td></tr>
<tr><td width="200">Kesimpulan</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KESIMPULAN'])); ?></td></tr>
<tr><td width="200">Hasil Temuan diluar Aspek Penilaian</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])); ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Tindak Lanjut</b></p>
<table width="100%">
	<tr><td width="200">Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess["TINDAKAN"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul><?php } ?></td></tr>
    <tr><td width="200">CAPA</td><td>:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CAPA'])); ?></td></tr>
</table>

<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran II</b></p>
<p>Checklist Aspek Penilaian</p>
<h2 class="small">GRUP A : Pimpinan</h2>
<table id="pointa" class="form_tabel">
    <tr id="a1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Kerja sama dengan pemeriksa</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[0]:''; ?></td></tr>
</table>

<h2 class="small">GRUP B : Sanitasi</h2>
<table id="pointb" class="form_tabel">
    <tr id="b1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Kebersihan</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[1]:''; ?></td></tr>
    <tr id="b2">
      <td class="atas">2.</td>
      <td class="atas">Tempat sampah</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[2]:''; ?></td>
      </tr>
    <tr id="b3">
      <td class="atas">3. </td>
      <td class="atas">Toilet</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[3]:''; ?></td>
      </tr>
    <tr id="b4">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup B</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[0]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP C : Infestasi </h2>
<table id="pointc" class="form_tabel">
    <tr id="c1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Binatang pengerat</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[4]:''; ?></td></tr>
    <tr id="c2">
      <td class="atas">2.</td>
      <td class="atas">Serangga</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[5]:''; ?></td>
      </tr>
    <tr id="c3">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup C</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[1]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP D : Bangunan / Ruangan</h2>
<table id="pointd" class="form_tabel">
    <tr id="d1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Konstruksi</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[6]:''; ?></td></tr>
    <tr id="d2">
      <td class="atas">2.</td>
      <td class="atas">Pencegahan binatang pengerat</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[7]:''; ?></td>
      </tr>
    <tr id="d3">
      <td class="atas">3.</td>
      <td class="atas">Pemeliharaan serangga</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[8]:''; ?></td>
      </tr>
    <tr id="d4">
      <td class="atas">4.</td>
      <td class="atas">Pemeliharaan</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[9]:''; ?></td>
      </tr>
    <tr id="d4">
    	<td class="atas">5.</td>
    	<td class="atas">Keteraturan</td>
    	<td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[10]:''; ?></td>
    </tr>  
    <tr id="d5">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup D</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[2]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP E : Perlengkapan Peragaan</h2>
<table id="pointe" class="form_tabel">
    <tr id="e1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Tata letak produk</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[11]:''; ?></td></tr>
    <tr id="e2">
      <td class="atas">2.</td>
      <td class="atas">Lemari penyimpanan</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[12]:''; ?></td>
      </tr>
    <tr id="e3">
      <td class="atas">3.</td>
      <td class="atas">Lemari pendingin</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[13]:''; ?></td>
      </tr>
    <tr id="e4">
      <td class="atas">4.</td>
      <td class="atas">Kontrol lemari pendingin</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[14]:''; ?></td>
      </tr>
    <tr id="e5">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup E</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[3]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP F : Gudang Biasa</h2>
<table id="pointf" class="form_tabel">
    <tr id="f1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Keteraturan</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[15]:''; ?></td></tr>
    <tr id="f2">
      <td class="atas">2.</td>
      <td class="atas">Pencegahan binatang pengerat</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[16]:''; ?></td>
      </tr>
    <tr id="f3">
      <td class="atas">3.</td>
      <td class="atas">Pencegahan serangga</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[17]:''; ?></td>
      </tr>
    <tr id="f4">
      <td class="atas">4.</td>
      <td class="atas">Ventilasi</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[18]:''; ?></td>
      </tr>
    <tr id="f5"> 
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup F</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[4]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP G : Gudang Dingin</h2>
<table id="pointg" class="form_tabel">
    <tr id="g1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Keteraturan</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[19]:''; ?></td></tr>
    <tr id="g2">
      <td class="atas">2.</td>
      <td class="atas">Kontrol suhu</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[20]:''; ?></td>
      </tr>
    <tr id="g3">
      <td class="atas">3.</td>
      <td class="atas">Pencegahan binatang pengerat</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[21]:''; ?></td>
      </tr>
    <tr id="g4">
      <td class="atas">4.</td>
      <td class="atas">Pencegahan serangga</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[22]:''; ?></td>
      </tr>
    <tr id="g5">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup G</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[5]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP H : Perlengkapan Administrasi</h2>
<table id="pointh" class="form_tabel">
    <tr id="h1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Keluar masuk barang</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[23]:''; ?></td></tr>
    <tr id="h2">
      <td class="atas">2.</td>
      <td class="atas">Faktur Pembelian</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[24]:''; ?></td>
      </tr>
    <tr id="h3">
      <td class="atas">3.</td>
      <td class="atas">Faktur Penjualan</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[25]:''; ?></td>
      </tr>
    <tr id="h4">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup H</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[6]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP I : Pengawasan Penanganan</h2>
<table id="pointi" class="form_tabel">
    <tr id="i1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Penggunaan insektisida / rodentisida</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[26]:''; ?></td></tr>
    <tr id="i2">
      <td class="atas">2.</td>
      <td class="atas">Mutu barang masuk</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[27]:''; ?></td>
      </tr>
    <tr id="i3">
      <td class="atas">3.</td>
      <td class="atas">Makanan rusak</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[28]:''; ?></td>
      </tr>
    <tr id="i4">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup I</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[7]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP J : Ketentuan Khusus</h2>
<table id="pointj" class="form_tabel">
    <tr id="j1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Lokasi</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[29]:''; ?></td></tr>
    <tr id="j2">
      <td class="atas">2.</td>
      <td class="atas">Izin minuman keras</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[30]:''; ?></td>
      </tr>
    <tr id="j3">
      <td class="atas">3.</td>
      <td class="atas">Tanda peringatan khusus</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[31]:''; ?></td>
      </tr>
    <tr id="j4">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup J</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[8]:''; ?></td>
      </tr>
</table>

<h2 class="small">GRUP K : Produk yang TMS</h2>
<table id="pointk" class="form_tabel">
    <tr id="k1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Bahan tambahan</td>
    <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[32]:''; ?></td></tr>
    <tr id="k2">
      <td class="atas">2.</td>
      <td class="atas">Makanan rusak</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[33]:''; ?></td>
      </tr>
    <tr id="k3">
      <td class="atas">3.</td>
      <td class="atas">Kedaluwarsa</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[34]:''; ?></td>
      </tr>
    <tr id="k4">
      <td class="atas">4.</td>
      <td class="atas">Label menyimpang</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[35]:''; ?></td>
      </tr>
    <tr id="k5">
      <td class="atas">5.</td>
      <td class="atas">Tanda khusus</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[36]:''; ?></td>
      </tr>
    <tr id="k6">
      <td class="atas">6.</td>
      <td class="atas">Minuman keras TIE</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[37]:''; ?></td>
      </tr>
    <tr id="k7">
      <td class="atas">7.</td>
      <td class="atas">Makanan tidak terdaftar</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[38]:''; ?></td>
      </tr>
    <tr id="k8">
      <td class="atas">8.</td>
      <td class="atas">Lain-lain : sebutkan</td>
      <td class="atas"><?php echo is_array($aspek_penilaian)?$aspek_penilaian[39]:''; ?></td>
      </tr>
    <tr id="k9">
      <td class="atas">&nbsp;</td>
      <td class="atas">Kesimpulan Grup K</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[9]:''; ?></td>
      </tr>
</table>   

<?php if($sess['JUMLAH_TEMUAN'] != 0) { ?>
<pagebreak />
<p><b>Lampiran III </b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
<tr class="header"><th>Produsen / Importir</th><th>Nama Produk</th><th>Detil Produk</th><th>Kategori Temuan</th></tr>
  <?php
  if($sess['JUMLAH_TEMUAN'] != 0){
      for($i=0; $i<count($temuan_produk); $i++){
          ?>
          <tr><td><?php echo $temuan_produk[$i]['PRODUSEN']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td>Registrasi Produk : <?php echo $temuan_produk[$i]['REGISTRASI']; ?><br>Nomor Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?><br>Jumlah Kemasan Terkecil : <?php echo $temuan_produk[$i]['KEMASAN'];?><br>Satuan : <?php echo $temuan_produk[$i]['SATUAN'];?><br>Perkiraan Harga Total : <?php echo $temuan_produk[$i]['HARGA'];?></td><td><?php echo $temuan_produk[$i]['KATEGORI'];?></td></tr>
          <?php
      }
  }else{
      ?>
      <tr><td colspan="4">Tidak ada temuan produk</td></tr>
      <?php
  }
  ?>
</table>
<?php } ?>
