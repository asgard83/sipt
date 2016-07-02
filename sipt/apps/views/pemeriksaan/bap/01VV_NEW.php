<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:10pt; border-collapse:collapse; width:100%; padding:5px;}
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
<tr><td width="200">Nama Pemilik / Pimpinan</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
<tr><td width="200">Penanggung Jawab</td><td width="20">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
<tr><td width="200">Status Sarana</td><td width="20">:</td><td><?php echo $sess['UR_STATUS_SARANA']; ?></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td colspan="3">Informasi Pemeriksaan</td></tr>
<tr>
<td>Tanggal Pemeriksaan</td>
<td>:</td>
<td><?php echo $sess['AWAL_PERIKSA']; ?> &nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td>
</tr>
<tr>
<td>Tujuan Pemeriksaan</td>
<td>:</td>
<td><?php echo  $sess['TUJUAN_PEMERIKSAAN']; ?></td>
</tr>
<tr id="row-catatan" <?php echo array_key_exists('STATUS_SARANA', $sess) ? ($sess['STATUS_SARANA'] <> 0 ? 'style="display:none;"' : '') : 'style="display:none;"'?>>
<td>Catatan</td>
<td>:</td>
<td><?php echo $sess['CATATAN']; ?></td>
</tr>
</table>
<p><b>Jenis Pangan</b></p>
<table class="tb_temuan" width="100%">
  <thead>
    <tr class="header">
      <th width="400">Jenis Pangan</th>
      <th width="150">No. PIRT</th>
      <th width="250">Status</th>
    </tr>
  </thead>
  <tbody id="tbodypirt">
    <?php
    $jml = count($jenis_pangan);
    if($jml > 0){
        for($i = 0; $i < $jml; $i++){
            ?>
            <tr>
              <td style="border:1px solid #000;"><?php echo $jenis_pangan[$i]['JENIS_PANGAN']; ?></td>
              <td style="border:1px solid #000;"><?php echo $jenis_pangan[$i]['NO_PIRT']; ?></td>
              <td style="border:1px solid #000;"><?php echo $jenis_pangan[$i]['STATUS']; ?></td>
            </tr>
            <?php
            }
        }
        ?>
  </tbody>
</table>
<p><b>Aspek Penilaian</b></p>
<h2 class="small">A - LOKASI DAN LINGKUNGAN PRODUKSI</h2>
<table id="pointa" class="form_tabel" group="GRUP A" isgroup="pointa">
  <tr id="a1">
    <td class="atas" width="12">1.</td>
    <td class="atas" width="600">Lokasi dan lingkungan IRTP tidak terawat, kotor dan berdebu</td>
    <td class="atas"><?php echo $aspek_penilaian[0]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[0] : ""; ?></td>
  </tr>
</table>
<h2 class="small">B - BANGUNAN DAN FASILITAS</h2>
<table id="pointb" class="form_tabel" group="GRUP B" isgroup="pointb">
  <tr id="b2">
    <td class="atas" width="12">2.</td>
    <td class="atas" width="600">Ruang produksi sempit, sukar dibersihkan dan digunakan untuk memproduksi produk selain pangan</td>
    <td class="atas"><?php echo $aspek_penilaian[1]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[1] : ""; ?></td>
  </tr>
  <tr id="b3">
    <td class="atas" width="12">3.</td>
    <td class="atas" width="600">Lantai, dinding, dan langit-langit, tidak terawat, kotor, berdebu dan atau berlendir</td>
    <td class="atas"><?php echo $aspek_penilaian[2]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[2] : ""; ?></td>
  </tr>
  <tr id="b4">
    <td class="atas" width="12">4.</td>
    <td class="atas" width="600">Ventilasi, pintu, dan jendela tidak terawat, kotor dan berdebu</td>
    <td class="atas"><?php echo $aspek_penilaian[3]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[3] : ""; ?></td>
  </tr>
</table>
<h2 class="small">C - PERALATAN PRODUKSI</h2>
<table id="pointc" class="form_tabel" group="GRUP C" isgroup="pointc">
  <tr id="c5">
    <td class="atas" width="12">5.</td>
    <td class="atas" width="600">Permukaan yang kontak langsung dengan pangan berkarat dan kotor</td>
    <td class="atas"><?php echo $aspek_penilaian[4]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[4] : ""; ?></td>
  </tr>
  <tr id="c6">
    <td class="atas" width="12">6.</td>
    <td class="atas" width="600">Peralatan tidak dipelihara, dalam keadaan kotor dan tidak menjamin efektifnya sanitasi</td>
    <td class="atas"><?php echo $aspek_penilaian[5]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[5] : ""; ?></td>
  </tr>
  <tr id="c7">
    <td class="atas" width="12">7.</td>
    <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang berat bersih / isi bersih tidak tersedia atau tidak teliti.</td>
    <td class="atas"><?php echo $aspek_penilaian[6]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[6] : ""; ?></td>
  </tr>
</table>
<h2 class="small">D - SUPLAI AIR ATAU SARANA PENYEDIAAN AIR </h2>
<table id="pointd" class="form_tabel" group="GRUP D" isgroup="pointd">
  <tr id="d8">
    <td class="atas" width="12">8.</td>
    <td class="atas" width="600">Air bersih tidak tersedia dalam jumlah yang cukup untuk memenuhi seluruh kebutuhan produksi</td>
    <td class="atas"><?php echo $aspek_penilaian[7]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[7] : ""; ?></td>
  </tr>
  <tr id="d9">
    <td class="atas" width="12">9.</td>
    <td class="atas" width="600">Air berasal dari suplai yang tidak bersih</td>
    <td class="atas"><?php echo $aspek_penilaian[8]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[8] : ""; ?></td>
  </tr>
</table>
<h2 class="small">E - FASILITAS DAN KEGIATAN HIGIENE DAN SANITASI </h2>
<table id="pointe" class="form_tabel" group="GRUP E" isgroup="pointe">
  <tr id="e10">
    <td class="atas" width="12">10.</td>
    <td class="atas" width="600">Sarana untuk pembersihan / pencucian bahan pangan, peralatan, perlengkapan dan bangunan tidak tersedia dan tidak terawat dengan baik.</td>
    <td class="atas"><?php echo $aspek_penilaian[9]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[9] : ""; ?></td>
  </tr>
  <tr id="e11">
    <td class="atas" width="12">11.</td>
    <td class="atas" width="600">Tidak tersedia sarana cuci tangan lengkap dengan sabun dan alat pengering tangan.</td>
    <td class="atas"><?php echo $aspek_penilaian[10]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[10] : ""; ?></td>
  </tr>
  <tr id="e12">
    <td class="atas" width="12">12.</td>
    <td class="atas" width="600">Sarana toilet/jamban kotor tidak terawat dan terbuka ke ruang produksi.</td>
    <td class="atas"><?php echo $aspek_penilaian[11]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[11] : ""; ?></td>
  </tr>
  <tr id="e13">
    <td class="atas" width="12">13.</td>
    <td class="atas" width="600">Tidak tersedia tempat pembuangan sampah tertutup.</td>
    <td class="atas"><?php echo $aspek_penilaian[12]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[12] : ""; ?></td>
  </tr>
</table>
<h2 class="small">F - KESEHATAN DAN HIGIENE KARYAWAN </h2>
<table id="pointf" class="form_tabel" group="GRUP F" isgroup="pointf">
  <tr id="f14">
    <td class="atas" width="12">14.</td>
    <td class="atas" width="600">Karyawan di bagian produksi pangan ada yang tidak merawat kebersihan badannya dan atau ada yang sakit</td>
    <td class="atas"><?php echo $aspek_penilaian[13]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[13] : ""; ?></td>
  </tr>
  <tr id="f15">
    <td class="atas" width="12">15.</td>
    <td class="atas" width="600">Karyawan di bagian produksi pangan tidak mengenakan pakaian kerja dan / atau mengenakan perhiasan</td>
    <td class="atas"><?php echo $aspek_penilaian[14]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[14] : ""; ?></td>
  </tr>
  <tr id="f16">
    <td class="atas" width="12">16.</td>
    <td class="atas" width="600">Karyawan tidak mencuci tangan dengan bersih sewaktu memulai mengolah pangan, sesudah menangani bahan mentah, atau bahan/ alat yang kotor, dan sesudah ke luar dari toilet/jamban.</td>
    <td class="atas"><?php echo $aspek_penilaian[15]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[15] : ""; ?></td>
  </tr>
  <tr id="f17">
    <td class="atas" width="12">17.</td>
    <td class="atas" width="600">Karyawan bekerja dengan perilaku yang tidak baik (seperti makan dan minum) yang dapat mengakibatkan pencemaran produk pangan.</td>
    <td class="atas"><?php echo $aspek_penilaian[16] ;?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[16] : ""; ?></td>
  </tr>
  <tr id="f18">
    <td class="atas" width="12">18.</td>
    <td class="atas" width="600">Tidak ada Penanggungjawab higiene karyawan</td>
    <td class="atas"><?php echo $aspek_penilaian[17]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[17] : ""; ?></td>
  </tr>
</table>
<h2 class="small">G - PEMELIHARAAN DAN PROGRAM HIGIENE DAN SANITASI </h2>
<table id="pointg" class="form_tabel" group="GRUP G" isgroup="pointg">
  <tr id="g19">
    <td class="atas" width="12">19.</td>
    <td class="atas" width="600">Bahan kimia pencuci tidak ditangani dan digunakan sesuai prosedur, disimpan di dalam wadah tanpa label</td>
    <td class="atas"><?php echo $aspek_penilaian[18]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[18] : ""; ?></td>
  </tr>
  <tr id="g20">
    <td class="atas" width="12">20.</td>
    <td class="atas" width="600">Program higiene dan sanitasi tidak dilakukan secara berkala</td>
    <td class="atas"><?php echo $aspek_penilaian[19]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[19] : ""; ?></td>
  </tr>
  <tr id="g21">
    <td class="atas" width="12">21.</td>
    <td class="atas" width="600"> Hewan peliharaan terlihat berkeliaran di sekitar dan di dalam ruang produksi pangan.</td>
    <td class="atas"><?php echo $aspek_penilaian[20]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[20] : ""; ?></td>
  </tr>
  <tr id="g22">
    <td class="atas" width="12">22.</td>
    <td class="atas" width="600">Sampah di lingkungan dan di ruang produksi tidak segera dibuang.</td>
    <td class="atas"><?php echo $aspek_penilaian[21]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[21] : ""; ?></td>
  </tr>
</table>
<h2 class="small">H - PENYIMPANAN </h2>
<table id="pointh" class="form_tabel" group="GRUP H" isgroup="pointh">
  <tr id="g23">
    <td class="atas" width="12">23.</td>
    <td class="atas" width="600">Bahan pangan, bahan pengemas disimpan bersama-sama dengan produk akhir dalam satu ruangan penyimpanan yang kotor, lembab dan gelap dan diletakkan di lantai atau menempel ke dinding.</td>
    <td class="atas"><?php echo $aspek_penilaian[22]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[22] : ""; ?></td>
  </tr>
  <tr id="g24">
    <td class="atas" width="12">24.</td>
    <td class="atas" width="600">Peralatan yang bersih disimpan di tempat yang kotor.</td>
    <td class="atas"><?php echo $aspek_penilaian[23]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[23] : ""; ?></td>
  </tr>
</table>
<h2 class="small">I - PENGENDALIAN PROSES </h2>
<table id="pointi" class="form_tabel" group="GRUP I" isgroup="pointi">
  <tr id="i25">
    <td class="atas" width="12">25.</td>
    <td class="atas" width="600">IRTP tidak memiliki catatan; menggunakan bahan baku yang sudah rusak, bahan berbahaya, dan bahan tambahan pangan yang tidak sesuai dengan persyaratan penggunaannya.</td>
    <td class="atas"><?php echo $aspek_penilaian[24]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[24] : ""; ?></td>
  </tr>
  <tr id="i26">
    <td class="atas" width="12">26.</td>
    <td class="atas" width="600">IRTP tidak mempunyai atau tidak mengikuti bagan alir produksi pangan.</td>
    <td class="atas"><?php echo $aspek_penilaian[25]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[25] : ""; ?></td>
  </tr>
  <tr id="i27">
    <td class="atas" width="12">27.</td>
    <td class="atas" width="600">IRTP tidak menggunakan bahan kemasan khusus untuk pangan.</td>
    <td class="atas"><?php echo $aspek_penilaian[26]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[26] : ""; ?></td>
  </tr>
  <tr id="i28">
    <td class="atas" width="12">28.</td>
    <td class="atas" width="600">BTP tidak diberi penandaan dengan benar.</td>
    <td class="atas"><?php echo $aspek_penilaian[27]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[27] : ""; ?></td>
  </tr>
  <tr id="i29">
    <td class="atas" width="12">29.</td>
    <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang BTP tidak tersedia atau tidak teliti.</td>
    <td class="atas"><?php echo $aspek_penilaian[28]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[28] : ""; ?></td>
  </tr>
</table>
<h2 class="small">J - PELABELAN PANGAN </h2>
<table id="pointj" class="form_tabel" group="GRUP J" isgroup="pointj">
  <tr id="i30">
    <td class="atas" width="12">30.</td>
    <td class="atas" width="600">Label pangan tidak mencantumkan nama produk, daftar bahan yang digunakan, berat bersih/isi bersih, nama dan alamat IRTP, masa kedaluwarsa, kode produksi dan nomor P-IRT.</td>
    <td class="atas"><?php echo $aspek_penilaian[29]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[29] : ""; ?></td>
  </tr>
  <tr id="i31">
    <td class="atas" width="12">31.</td>
    <td class="atas" width="600">Label mencantumkan klaim kesehatan atau klaim gizi.</td>
    <td class="atas"><?php echo $aspek_penilaian[30]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[30] : ""; ?></td>
  </tr>
</table>
<h2 class="small">K - PENGAWASAN OLEH PENANGGUNG JAWAB </h2>
<table id="pointk" class="form_tabel" group="GRUP K" isgroup="pointk">
  <tr id="k32">
    <td class="atas" width="12">32.</td>
    <td class="atas" width="600">IRTP tidak mempunyai penanggung jawab yang memiliki Sertifikat Penyuluhan Keamanan Pangan (PKP)</td>
    <td class="atas"><?php echo $aspek_penilaian[31]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[31] : ""; ?></td>
  </tr>
  <tr id="k33">
    <td class="atas" width="12">33.</td>
    <td class="atas" width="600">IRTP tidak melakukan pengawasan internal secara rutin, termasuk monitoring dan tindakan koreksi</td>
    <td class="atas"><?php echo $aspek_penilaian[32]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[32] : ""; ?></td>
  </tr>
</table>
<h2 class="small">L - PENARIKAN PRODUK </h2>
<table id="pointl" class="form_tabel" group="GRUP L" isgroup="pointl">
  <tr id="l34">
    <td class="atas" width="12">34.</td>
    <td class="atas" width="600">Pemilik IRTP tidak melakukan penarikan produk pangan yang tidak aman</td>
    <td class="atas"><?php echo $aspek_penilaian[33]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[33] : ""; ?></td>
  </tr>
</table>
<h2 class="small">M - PENCATATAN DAN DOKUMENTASI </h2>
<table id="pointm" class="form_tabel" group="GRUP M" isgroup="pointm">
  <tr id="m35">
    <td class="atas" width="12">35.</td>
    <td class="atas" width="600">IRTP tidak memiliki dokumen produksi</td>
    <td class="atas"><?php echo $aspek_penilaian[34]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[34] : ""; ?></td>
  </tr>
  <tr id="m36">
    <td class="atas" width="12">36.</td>
    <td class="atas" width="600">Dokumen produksi tidak mutakhir, tidak akurat, tidak tertelusur dan tidak disimpan selama 2 (dua) kali umur simpan produk pangan yang diproduksi.</td>
    <td class="atas"><?php echo $aspek_penilaian[35]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[35] : ""; ?></td>
  </tr>
</table>
<h2 class="small">N - PELATIHAN KARYAWAN</h2>
<table id="pointn" class="form_tabel" group="GRUP N" isgroup="pointn">
  <tr id="n36">
    <td class="atas" width="12">37.</td>
    <td class="atas" width="600">IRTP tidak memiliki program pelatihan keamanan pangan untuk karyawan.</td>
    <td class="atas"><?php echo $aspek_penilaian[36]; ?></td>
    <td class="atas"><?php echo is_array($element_periksa) ? $element_periksa[36] : ""; ?></td>
  </tr>
</table>
<h2 class="small">JUMLAH KETIDAK SESUAIAN</h2>
<table class="form_tabel">
  <tr>
    <td class="atas" width="12">&nbsp;</td>
    <td class="atas" width="600">Jumlah Ketidaksesuain KRITIS</td>
    <td class="atas"><?php echo array_key_exists('JML_KRITIS', $sess)?$sess['JML_KRITIS']:"0"; ?></td>
  </tr>
  <tr>
    <td class="atas" width="12">&nbsp;</td>
    <td class="atas" width="600">Jumlah Ketidaksesuain SERIUS</td>
    <td class="atas"><?php echo $sess['JML_SERIUS']; ?></td>
  </tr>
  <tr>
    <td class="atas" width="12">&nbsp;</td>
    <td class="atas" width="600">Jumlah Ketidaksesuain MAYOR</td>
    <td class="atas"><?php echo $sess['JML_MAJOR']; ?></td>
  </tr>
  <tr>
    <td class="atas" width="12">&nbsp;</td>
    <td class="atas" width="600">Jumlah Ketidaksesuain MINOR</td>
    <td class="atas"><?php echo $sess['JML_MINOR']; ?></td>
  </tr>
  <tr>
    <td class="atas" width="12">&nbsp;</td>
    <td class="atas" width="600">Level IRTP</td>
    <td class="atas"><?php echo $sess['LEVEL_IRTP']?></td>
  </tr>
</table>
<?php
if($sess['STATUS_SARANA']!="0"){
	?>
    <p><b>Rincian Ketidaksesuaian</b></p>
    <table class="tb_temuan" width="100%" style="font-size:13pt;">
      <thead>
        <tr>
          <th width="500">Ketidaksesuaian</th>
          <th width="75">Kriteria</th>
          <th width="300">Timeline</th>
        </tr>
      </thead>
      <tbody id="draft-penilaian">
        <?php
        $jml = count($rincian_ketidaksesuaian);
        if($jml > 0){
            for($i = 0; $i < $jml; $i++){
              ?>
        <tr id="<?php echo $rincian_ketidaksesuaian[$i]; ?>">
          <td width="570"><?php echo $rincian_ketidaksesuaian[$i]; ?></td>
          <td width="70"><?php echo $rincian_kriteria[$i]; ?></td>
          <td style="text-align:center;"><?php echo $rincian_timeline[$i]; ?></td>
        </tr>
        <?php
            }
        }
        ?>
      </tbody>
    </table>
    <?php
}
?>