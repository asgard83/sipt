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
	<tr><td><?php echo $sess['NAMA_PIMPINAN']; ?></td><td>&nbsp;</td></tr>
</table>

<pagebreak />

<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa :</b></p>
<table width="100%">
<tr><td width="200">Nama Sarana Produksi</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
<tr><td width="200">Alamat</td><td width="20">:</td><td><?php if(trim($sess['ALAMAT_1']) != "" && $sess['ALAMAT_1'] != "-"){ ?>
<ul style="list-style-type:disc; padding-left:15px; margin:0;"><?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Telepon</td><td width="20">:</td><td><?php if(trim($sess['TELEPON']) != "" && $sess['TELEPON'] != "-"){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td width="200">Nama Pemilik / Pimpinan</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td width="200">Nomor Izin</td><td width="20">:</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
<tr><td width="200">Jumlah Karyawan</td><td width="20">:</td><td><?php echo $sess['JUMLAH_KARYAWAN']; ?></td></tr>
<tr><td width="200">Umur Bangunan</td><td width="20">:</td><td><?php echo $sess['UMUR_BANGUNAN']; ?></td></tr>
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
<tr><td width="200">Saran</td><td>:</td><td><?php echo $sess["REKOMENDASI"]; ?></td></tr>
<tr><td width="200">Kesimpulan</td><td>:</td><td><?php echo $sess["KESIMPULAN"]; ?></td></tr>
<tr><td width="200">Hasil Temuan diluar Aspek Penilaian</td><td>:</td><td><?php echo $sess["HASIL_TEMUAN_LAIN"]; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Tindak Lanjut</b></p>
<table width="100%">
	<tr><td width="200">Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess["TINDAKAN"]) != ""){ ?><ul style="list-style-type:decimal; padding-left:15px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul><?php } ?></td></tr>
    <tr><td width="200">CAPA</td><td>:</td><td><?php echo $sess['CAPA']; ?></td></tr>
</table>

<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran II</b></p>
<p>Checklist Aspek Penilaian</p>
<h2 class="small">GRUP A - Lingkungan Produksi</h2>
<table id="pointa" class="form_tabel">
    <tr id="a1"><td class="atas" width="12">1.</td><td class="atas" width="403">Semak</td><td class="atas"><?php echo $aspek_penilaian[0]; ?></td></tr>
    <tr id="a2">
      <td class="atas">2.</td>
      <td class="atas">Tempat Sampah</td>
      <td class="atas"><?php echo $aspek_penilaian[1]; ?></td>
      </tr>
    <tr id="a3">
      <td class="atas">3.</td>
      <td class="atas">Sampah</td>
      <td class="atas"><?php echo $aspek_penilaian[2]; ?></td>
      </tr>
    <tr id="a4">
      <td class="atas">4.</td>
      <td class="atas">Selokan</td>
      <td class="atas"><?php echo $aspek_penilaian[3]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td><td class="atas" width="403">Kesimpulan Grup A</td><td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[0]:""; ?></td></tr>
</table>

<h2 class="small">GRUP B - Bangunan dan Fasilitas</h2>
<table id="pointb" class="form_tabel">
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">B1 Ruang Produksi</td>
      </tr>
    <tr id="b1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Konstruksi Lantai</td><td class="atas"><?php echo $aspek_penilaian[4]; ?></td></tr>
    <tr id="b2">
      <td class="atas">2.</td>
      <td class="atas">Kebersihan Lantai</td>
      <td class="atas"><?php echo $aspek_penilaian[5]; ?></td>
      </tr>
    <tr id="b3">
      <td class="atas">3.</td>
      <td class="atas">Konstruksi Dinding</td>
      <td class="atas"><?php echo $aspek_penilaian[6]; ?></td>
      </tr>
    <tr id="b4">
      <td class="atas">4.</td>
      <td class="atas">Kebersihan Dinding</td>
      <td class="atas"><?php echo $aspek_penilaian[7]; ?></td>
      </tr>
    <tr id="b5">
      <td class="atas">5.</td>
      <td class="atas">Konstruksi Langit-langit</td>
      <td class="atas"><?php echo $aspek_penilaian[8]; ?></td>
      </tr>
    <tr id="b6">
      <td class="atas">6.</td>
      <td class="atas">Kebersihan Langit-langit</td>
      <td class="atas"><?php echo $aspek_penilaian[9]; ?></td>
      </tr>
    <tr id="b7">
      <td class="atas">7.</td>
      <td class="atas">Konstruksi Pintu, Jendela dan Lubang Angin</td>
      <td class="atas"><?php echo $aspek_penilaian[10]; ?></td>
      </tr>
    <tr id="b8">
      <td class="atas">8.</td>
      <td class="atas">Kebersihan Pintu, Jendela dan Lubang Angin</td>
      <td class="atas"><?php echo $aspek_penilaian[11]; ?></td>
      </tr>
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">B2 Kelengkapan Ruang Produksi</td>
      </tr>
    <tr id="b9">
      <td class="atas">1.</td>
      <td class="atas">Penerangan</td>
      <td class="atas"><?php echo $aspek_penilaian[12]; ?></td>
      </tr>
    <tr id="b10">
      <td class="atas">2.</td>
      <td class="atas">PPPK</td>
      <td class="atas"><?php echo $aspek_penilaian[13]; ?></td>
      </tr>
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">B3 Tempat Penyimpanan</td>
      </tr>
    <tr id="b11">
      <td class="atas">1.</td>
      <td class="atas">Tempat Penyimpanan bahan dan produk</td>
      <td class="atas"><?php echo $aspek_penilaian[14]; ?></td>
      </tr>
    <tr id="b12">
      <td class="atas">2.</td>
      <td class="atas">Tempat penyimpanan bahan bukan pangan</td>
      <td class="atas"><?php echo $aspek_penilaian[15]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td><td class="atas" width="403">Kesimpulan Grup B</td><td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[1]:""; ?></td></tr>
</table>

<h2 class="small">GRUP C - Peralatan Produksi</h2>
<table id="pointc" class="form_tabel">
    <tr id="c1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Konstruksi</td><td class="atas"><?php echo $aspek_penilaian[16]; ?></td></tr>
    <tr id="c2">
      <td class="atas">2.</td>
      <td class="atas">Tata Letak</td>
      <td class="atas"><?php echo $aspek_penilaian[17]; ?></td>
      </tr>
    <tr id="c3">
      <td class="atas">3.</td>
      <td class="atas">Kebersihan</td>
      <td class="atas"><?php echo $aspek_penilaian[18]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup C</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[2]:""; ?></td></tr>
</table>


<h2 class="small">GRUP D - Suplai Air</h2>
<table id="pointd" class="form_tabel">
    <tr id="d1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Sumber Air</td><td class="atas"><?php echo $aspek_penilaian[19]; ?></td></tr>
    <tr id="d2">
      <td class="atas">2.</td>
      <td class="atas">Pengguna Air</td>
      <td class="atas"><?php echo $aspek_penilaian[20]; ?></td>
      </tr>
    <tr id="d3">
      <td class="atas">3.</td>
      <td class="atas">Air yang Kontak Langsung dengan Pangan</td>
      <td class="atas"><?php echo $aspek_penilaian[21]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup D</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[3]:""; ?></td></tr>
</table>

<h2 class="small">GRUP E - Fasilitas dan Kegiatan Higiene dan Sanitasi</h2>
<table id="pointe" class="form_tabel">
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">E1 Alat Cuci / Pembersih</td>
      </tr>
    <tr id="e1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Ketersediaan Alat</td>
    <td class="atas"><?php echo $aspek_penilaian[22]; ?></td></tr>
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">E2 Fasilitas Higiene Karyawan</td>
      </tr>
    <tr id="e2">
      <td class="atas">1.</td>
      <td class="atas">Tempat Cuci Tangan</td>
      <td class="atas"><?php echo $aspek_penilaian[23]; ?></td>
      </tr>
    <tr id="e3">
      <td class="atas">2.</td>
      <td class="atas">Jamban / Toilet</td>
      <td class="atas"><?php echo $aspek_penilaian[24]; ?></td>
      </tr>
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">E3 Kegiatan Higiene dan Sanitasi</td>
      </tr>
    <tr id="e4">
      <td class="atas">1.</td>
      <td class="atas">Penanggung Jawab</td>
      <td class="atas"><?php echo $aspek_penilaian[25]; ?></td>
      </tr>
    <tr id="e5">
      <td class="atas">2.</td>
      <td class="atas">Penggunaan Deterjen dan Desinfektan</td>
      <td class="atas"><?php echo $aspek_penilaian[26]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup E</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[4]:""; ?></td></tr>
</table>

<h2 class="small">GRUP F - Pengendalian Hama</h2>
<table id="pointf" class="form_tabel">
    <tr id="f1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Hewan Peliharaan</td>
    <td class="atas"><?php echo $aspek_penilaian[27]; ?></td></tr>
    <tr id="f2">
      <td class="atas">2.</td>
      <td class="atas">Pencegahan Masuknya Hama</td>
      <td class="atas"><?php echo $aspek_penilaian[28]; ?></td>
      </tr>
    <tr id="f3">
      <td class="atas">3.</td>
      <td class="atas">Pemberantasan Hama</td>
      <td class="atas"><?php echo $aspek_penilaian[29]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup F</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[5]:""; ?></td></tr>
</table>



<h2 class="small">GRUP G - Kesehatan dan Higiene Karyawan</h2>
<table id="pointg" class="form_tabel">
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">G1 Kesehatan Karyawan</td>
      </tr>
    <tr id="g1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Pemeriksaan Kesehatan</td>
    <td class="atas"><?php echo $aspek_penilaian[30]; ?></td></tr>
    <tr id="g2">
      <td class="atas" width="12">2.</td>
    <td class="atas" width="403">Kesehatan Karyawan</td>
    <td class="atas"><?php echo $aspek_penilaian[31]; ?></td></tr>

    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">G2 Kebersihan Karyawan</td>
      </tr>
    <tr id="g3">
      <td class="atas">1.</td>
      <td class="atas">Kebersihan Badan</td>
      <td class="atas"><?php echo $aspek_penilaian[32]; ?></td>
      </tr>
    <tr id="g4">
      <td class="atas">2.</td>
      <td class="atas">Kebersihan Pakaian / Perlengkapan Kerja</td>
      <td class="atas"><?php echo $aspek_penilaian[33]; ?></td>
      </tr>
    <tr id="g5">
      <td class="atas">3.</td>
      <td class="atas">Kebersihan Tangan</td>
      <td class="atas"><?php echo $aspek_penilaian[34]; ?></td>
      </tr>
    <tr id="g6">
      <td class="atas">4.</td>
      <td class="atas">Perawatan Luka</td>
      <td class="atas"><?php echo $aspek_penilaian[35]; ?></td>
      </tr>
    <tr id="subjudul">
      <td colspan="3" class="atas spjudul">G3 Kebiasaan Karyawan</td>
      </tr>
    <tr id="g7">
      <td class="atas">1.</td>
      <td class="atas">Perilaku Karyawan</td>
      <td class="atas"><?php echo $aspek_penilaian[36]; ?></td>
      </tr>
    <tr id="g8">
      <td class="atas">2.</td>
      <td class="atas">Perhiasan dan Asesoris Lainnya</td>
      <td class="atas"><?php echo $aspek_penilaian[37]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup G</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[6]:""; ?></td></tr>
</table>

<h2 class="small">GRUP H - Pengendalian Proses</h2>
<table id="pointh" class="form_tabel">
    <tr id="h_1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Penetapan Spesifikasi Bahan Baku</td>
    <td class="atas"><?php echo $aspek_penilaian[38]; ?></td></tr>
    <tr id="h_2">
      <td class="atas">2.</td>
      <td class="atas">Penetapan Komposisi dan Formulasi Bahan</td>
      <td class="atas"><?php echo $aspek_penilaian[39]; ?></td>
      </tr>
    <tr id="h_3">
      <td class="atas">3.</td>
      <td class="atas">Penetapan cara Produksi yang Baku</td>
      <td class="atas"><?php echo $aspek_penilaian[40]; ?></td>
      </tr>
    <tr id="h_4">
      <td class="atas">4. </td>
      <td class="atas">Penetapan Spesifikasi Keamanan</td>
      <td class="atas"><?php echo $aspek_penilaian[41]; ?></td>
      </tr>
    <tr id="h_5">
      <td class="atas">5. </td>
      <td class="atas">Penetapan Tanggal Kadaluarsa dan Kode Produksi</td>
      <td class="atas"><?php echo $aspek_penilaian[42]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup H</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[7]:""; ?></td></tr>
</table>

<h2 class="small">GRUP I - Label Pangan</h2>
<table id="pointi" class="form_tabel">
    <tr id="i1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Persyaratan Label</td>
    <td class="atas"><?php echo $aspek_penilaian[43]; ?></td></tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup I</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[8]:""; ?></td></tr>
</table>

<h2 class="small">GRUP J - PENYIMPANAN</h2>
<table id="pointj" class="form_tabel">
    <tr id="j1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Penyimpanan Bahan dan Produk</td>
    <td class="atas"><?php echo $aspek_penilaian[44]; ?></td></tr>
    <tr id="j2">
      <td class="atas">2.</td>
      <td class="atas">Tata Cara Penyimpanan</td>
      <td class="atas"><?php echo $aspek_penilaian[45]; ?></td>
      </tr>
    <tr id="j3">
      <td class="atas">3.</td>
      <td class="atas">Penyimpanan Bahan Berbahaya</td>
      <td class="atas"><?php echo $aspek_penilaian[46]; ?></td>
      </tr>
    <tr id="j4">
      <td class="atas">4. </td>
      <td class="atas">Penyimpanan Label dan Kemasan</td>
      <td class="atas"><?php echo $aspek_penilaian[47]; ?></td>
      </tr>
    <tr id="j5">
      <td class="atas">5. </td>
      <td class="atas">Penyimpanan Peralatan</td>
      <td class="atas"><?php echo $aspek_penilaian[48]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup J</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[9]:""; ?></td></tr>
</table>

<h2 class="small">GRUP K - Manajemen Pengawasan</h2>
<table id="pointk" class="form_tabel">
    <tr id="k1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Penanggung Jawab</td>
    <td class="atas"><?php echo $aspek_penilaian[49]; ?></td></tr>
    <tr id="k2">
      <td class="atas">2.</td>
      <td class="atas">Pengawasan</td>
      <td class="atas"><?php echo $aspek_penilaian[50]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup K</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[10]:""; ?></td></tr>
</table>

<h2 class="small">GRUP L - Pencatatan dan Dokumentasi</h2>
<table id="pointl" class="form_tabel">
    <tr id="l1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Pencatatan dan Dokumentasi</td>
    <td class="atas"><?php echo $aspek_penilaian[51]; ?></td></tr>
    <tr id="l2">
      <td class="atas">2.</td>
      <td class="atas">Penyimpanan Catatan dan Dokumentasi</td>
      <td class="atas"><?php echo $aspek_penilaian[52]; ?></td>
      </tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup L</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[11]:""; ?></td></tr>
</table>

<h2 class="small">GRUP M - Pelatihan Karyawan</h2>
<table id="pointm" class="form_tabel">
    <tr id="m1"><td class="atas" width="12">1.</td>
    <td class="atas" width="403">Pengetahuan Karyawan</td>
    <td class="atas"><?php echo $aspek_penilaian[53]; ?></td></tr>
</table>
<table class="form_tabel">
    <tr><td class="atas" width="12">&nbsp;&nbsp;&nbsp;</td>
      <td class="atas" width="403">Kesimpulan Grup M</td>
      <td class="atas"><?php echo is_array($kesimpulan_grup)?$kesimpulan_grup[12]:""; ?></td></tr>
</table> 
