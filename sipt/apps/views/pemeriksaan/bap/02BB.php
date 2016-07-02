<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {
font-family:font-family: "Times New Roman";
	font-size:10pt;
}
@page {
margin-top: 2.5cm;
margin-bottom: 2.5cm;
margin-left: 2.5cm;
margin-right: 2.5cm;
}
h2.judulbap {
	font-size:14pt;
	font-weight:bold;
	text-decoration:underline;
}
table td {
	vertical-align:top;
	text-align:justify;
}
table.tb_temuan {
	font-size:8pt;
	border-collapse:collapse;
	width:100%;
	padding:5px;
}
table.tb_temuan tr.header th {
	border-collapse:collapse;
	text-align:left;
	padding:5px;
	border:1px solid #000;
	height:35px;
	vertical-align:top;
}
table.tb_temuan td {
	padding:5px;
	vertical-align:top;
	border:1px solid #000;
}
table.form_tabel {
	font-size:8pt;
	border-collapse:collapse;
	border-spacing:0;
	width:100%;
	padding:5px;
}
table.form_tabel td {
	padding:5px;
	vertical-align:top;
	border:1px solid #000;
}
table.form_tabel td.isi {
	font-weight:bold;
}
table.form_tabel td.td_no {
	width:20px;
}
table.form_tabel td.td_aspek {
	width:600px;
}
h2.small {
	font-size:9pt;
	font-weight:bold;
}
</style>
<div style="text-align:center;">
  <div><img src="<?php echo base_url(); ?>images/logobpom_.jpg" /></div>
  <div>
    <h2 class="judulbap">BERITA ACARA PEMERIKSAAN</h2>
  </div>
</div>
<div style="height:5px;">&nbsp;</div>
<div style="text-align:justify;">Pada hari ini <?php echo $hari; ?> tanggal <?php echo $awal_periksa; ?> kami yang bertanda tangan di bawah ini :</div>
<div style="height:5px;">&nbsp;</div>
<table width="100%">
  <?php 
$jml_petugas = count($petugas);
$no = 1;
for($z=0; $z<$jml_petugas; $z++){ ?>
  <tr>
    <td width="20"><?php echo $no; ?>.</td>
    <td width="120">Nama</td>
    <td width="20">:</td>
    <td><?php echo $petugas[$z]['NAMA_PETUGAS']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>NIP</td>
    <td>:</td>
    <td><?php echo $petugas[$z]['NIP']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jabatan</td>
    <td>:</td>
    <td><?php echo $petugas[$z]['JABATAN']; ?></td>
  </tr>
  <?php 
$no++;
} ?>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify">Berdasarkan surat tugas dari Kepala <?php echo ucwords(strtolower($petugas[0]['BADAN'])); ?> Nomor : <?php echo $petugas[0]['NOMOR_SURAT']; ?> tanggal <?php echo $petugas[0]['TANGGAL_SURAT']; ?> telah melakukan pemeriksaan terhadap : </div>
<div style="height:20px;"></div>
<table width="100%">
  <tr>
    <td width="200">Nama Sarana</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_SARANA']; ?></td>
  </tr>
  <tr>
    <td width="200">Alamat</td>
    <td width="20">:</td>
    <td><?php echo $sess['ALAMAT_1']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Pemilik / Pimpinan Usaha</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_PIMPINAN']; ?></td>
  </tr>
</table>
<div style="height:20px;"></div>
<div style="text-align:justify;">Adapun hasil pemeriksaan sebagaimana tersebut terlampir. </div>
<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dapat dipergunakan sebagaimana mestinya. </div>
<div style="height:40px;"></div>
<table style="width:100%">
  <tr>
    <td style="width:50%;">Mengetahui,</td>
    <td style="width:50%;">Yang membuat Berita Acara</td>
  </tr>
  <tr>
    <td height="150">Penanggung Jawab,</td>
    <td><table width="100%">
        <?php 
    $jml = count($petugas);
    $no = 1;
    for($x=0; $x<$jml; $x++){ ?>
        <tr>
          <td width="20"><?php echo $no; ?>.</td>
          <td><?php echo $petugas[$x]['NAMA_PETUGAS']; ?></td>
        </tr>
        <?php 
    $no++;
    } ?>
      </table></td>
  </tr>
  <tr>
    <td><?php echo $sess['PENANGGUNG_JAWAB'] == "" ? $sess['NAMA_PIMPINAN'] : $sess['PENANGGUNG_JAWAB']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<pagebreak />
<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa :</b></p>
<table width="100%">
  <tr>
    <td colspan="3">Nama Sarana Distribusi/Ritel/Toko/Apotek/PBF</td>
  </tr>
  <tr>
    <td colspan="3"><b><?php echo $sess['NAMA_SARANA']; ?></b></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="200">Bertindak Sebagai</td>
    <td width="20">:</td>
    <td><?php echo $sess['SARANA_BB']; ?></td>
  </tr>
  <tr>
    <td width="200">Alamat Kantor</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:disc; padding-left:15px; margin:0;">
        <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Alamat Gudang</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:disc; padding-left:15px; margin:0;">
        <?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Telepon</td>
    <td width="20">:</td>
    <td><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
        <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
      </ul></td>
  </tr>
  <tr>
    <td width="200">Nomor Izin</td>
    <td width="20">:</td>
    <td><?php echo $sess['NOMOR_IZIN']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Pemilik / Pimpinan Usaha</td>
    <td width="20">:</td>
    <td><?php echo $sess['NAMA_PIMPINAN']; ?></td>
  </tr>
  <tr>
    <td width="200">Nama Penanggung Jawab</td>
    <td width="20">:</td>
    <td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
  </tr>
  <tr>
    <td width="200">Status Sarana</td>
    <td width="20">:</td>
    <td><?php echo $sess['STATUS_SARANA']; ?></td>
  </tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
  <tr>
    <td width="200">Tanggal Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td>
  </tr>
  <tr>
    <td width="200">Tujuan Pemeriksaan</td>
    <td width="20">:</td>
    <td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
  </tr>
</table>
<div style="height:5px;"></div>
<p><b>Hasil Pemeriksaan</b></p>
<table id="f02BB_tbhasil" width="100%">
  <tr>
    <td width="200">Hasil Pemeriksaan Balai</td>
    <td width="20">:</td>
    <td><?php echo $sess['HASIL']; ?></td>
  </tr>
  <tr>
    <td width="200">Detil Kesimpulan</td>
    <td width="20">:</td>
    <td><?php echo $sess['CATATAN']; ?></td>
  </tr>
</table>
<h2 class="small garis htmpbb" <?php echo array_key_exists('STTS_SARANA', $sess) && $sess['STTS_SARANA'] == '4' ? '' : 'style="display:none"'; ?>>Jenis Bahan Berbahaya</h2>
<table width="100%" id="tbltmpbb" <?php echo array_key_exists('STTS_SARANA', $sess) && $sess['STTS_SARANA'] == '4' ? '' : 'style="display:none"'; ?>>
  <tr>
    <td width="200">Jenis bahan berbahaya yang pernah di kelola</td>
    <td width="20">:</td>
    <td><?php echo str_replace("#","<br>",$sess['KELOLA_BB']); ?></td>
  </tr>
</table>
<h2 class="small">Tindak Lanjut</h2>
<table width="100%">
  <tr>
    <td width="200">Tindak lanjut</td>
    <td width="20">:</td>
    <td><?php echo join("<br>",$tindak_lanjut); ?></td>
  </tr>
  <tr id="tr_rekomendasi" <?php echo in_array('01', $arrtl) || in_array('02', $arrtl) || in_array('03', $arrtl) ? '' : 'style="display:none;"'; ?>>
    <td width="200">Rekomendasi</td>
    <td width="20">:</td>
    <td><?php echo $sess['REKOMENDASI']; ?></td>
  </tr>
  <tr id="tr_catatan" <?php echo (in_array('02', $arrtl) || in_array('03', $arrtl) || in_array('04', $arrtl)) ? '' : 'style="display:none;"'; ?>>
    <td width="200">Catatan</td>
    <td width="20">:</td>
    <td><?php echo $sess['KEBIJAKAN'] != "" ? $sess['KEBIJAKAN'] : '-'; ?></td>
  </tr>
  <tr id="tr_contoh" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
    <td width="200">Hasil Uji</td>
    <td width="20">:</td>
    <td><?php echo $sess['HASIL_UJI']; ?></td>
  </tr>
  <tr id="tr_kode_sampel" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
    <td width="200">Kode Sampel</td>
    <td width="20">:</td>
    <td><?php echo $sess['KODE_SAMPEL']; ?></td>
  </tr>
</table>
<!------ Awal Detil Pemeriksaan !-->
<div id="dtl-pemeriksaan" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin" || $sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } ?>>
  <pagebreak />
  <p><b>Lampiran II</b></p>
  <p><b>Detil Pemeriksaan :</b></p>
  <div style="height:5px;"></div>
  <table class="form_tabel">
    <tr>
      <td width="20" class="atas">&nbsp;</td>
      <td width="385" class="atas">Jenis produk yang diperiksa</td>
      <td class="atas" colspan="2"><?php
		  $jml = count($jenis_produk);
		  if($jml > 0){
			$no = 1;
			for($i = 0; $i < $jml; $i++){
				echo $no.". ".$jenis_produk[$i]."<br>";
				$no++;
			}
		  }
		  ?></td>
    </tr>
  </table>
  <h2 class="small">I. Administrasi</h2>
  <table class="form_tabel">
    <tr id="f02BB_point1a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Memiliki izin sesuai</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[0]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[0] != '' ? $aspek_keterangan[0] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point1b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Memiliki faktur pembelian / tanda terima barang</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[1]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[1] != '' ? $aspek_keterangan[1] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point1c">
      <td></td>
      <td class="atas">c.</td>
      <td class="atas">Mengeluarkan bon penjualan/surat jalan barang</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[2]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[2] != '' ? $aspek_keterangan[2] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point1d">
      <td></td>
      <td class="atas">d.</td>
      <td class="atas">Ada pencatatan pemasukan dan pengeluaran barang</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[3]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[3] != '' ? $aspek_keterangan[3] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point1e">
      <td></td>
      <td class="atas">e.</td>
      <td class="atas">Ada pencatatan tujuan penggunaan bahan berbahaya oleh pembeli</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[4]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[4] != '' ? $aspek_keterangan[4] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point1f">
      <td></td>
      <td class="atas">f.</td>
      <td class="atas">Ada pencatatan identitas jelas dan alamat pembeli (untuk pembeli perorangan)</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[5]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[5] != '' ? $aspek_keterangan[5] : '-'; ?></td>
    </tr>
  </table>
  <h2 class="small">II. Kesesuain Pengadaan Bahan Berbahaya</h2>
  <table class="form_tabel">
    <tr id="f02BB_point2a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Sumber pengadaan sesuai dengan surat penunjukan</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[6]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[6] != '' ? $aspek_keterangan[6] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point2b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Pengadaan bahan berbahaya sesuai dengan Surat Izin Usaha Perdagangan Bahan Berbahaya yang dimiliki</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[7]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[7] != '' ? $aspek_keterangan[7] : '-'; ?></td>
    </tr>
  </table>
  <h2 class="small">III. Kesesuaian Penyaluran / Distribusi Bahan Berbahaya</h2>
  <table class="form_tabel">
    <tr id="f02BB_point3a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Penyaluran bahan berbahaya dilakukan hanya ke industri pengguna akhir bahan berbahaya atau instansi / lembaga pengguna akhir bahan berbahaya</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[8]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[8] != '' ? $aspek_keterangan[8] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point3b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Tidak melakukan menyalurkan ke perorangan tanpa identitas dan tujuan penggunaan jelas</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[9]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[9] != '' ? $aspek_keterangan[9] : '-'; ?></td>
    </tr>
  </table>
  <h2 class="small">IV. Pengemasan Ulang</h2>
  <table class="form_tabel">
    <tr id="f02BB_point4">
      <td></td>
      <td width="20" class="atas">&nbsp;</td>
      <td width="385" class="atas">Melakukan pengemasan ulang (<em>repacking</em>) bahan berbahaya</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[10]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[10] != '' ? $aspek_keterangan[10] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point4x">
      <td></td>
      <td width="20" class="atas">&nbsp;</td>
      <td width="385" class="atas">Lampiran file</td>
      <td class="atas sel_penyimpangan">&nbsp;</td>
      <td class="atas">&nbsp;</td>
      <td class="atas"><?php if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){ ?>
        <a href="<?php echo site_url(); ?>/download/lampiran/pemeriksaan/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>
        <?php } ?></td>
    </tr>
  </table>
  <h2 class="small">V. Pelaporan</h2>
  <table class="form_tabel">
    <tr id="f02BB_point6a">
      <td></td>
      <td width="20" class="atas">a.</td>
      <td width="385" class="atas">Muatan Laporan sesuai dengan ketentuan</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[11]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[11] != '' ? $aspek_keterangan[11] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point6b">
      <td></td>
      <td class="atas">b.</td>
      <td class="atas">Melakukan pelaporan berkala per triwulan</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[12]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[12] != '' ? $aspek_keterangan[12] : '-'; ?></td>
    </tr>
    <tr id="f02BB_point6c">
      <td></td>
      <td class="atas">c.</td>
      <td class="atas">Laporan dikirimkan ke Instansi yang dinyatakan sesuai dengan ketentuan</td>
      <td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
      <td class="atas"><?php echo $aspek_check[13]; ?></td>
      <td class="atas"><?php echo $aspek_keterangan[13] != '' ? $aspek_keterangan[13] : '-'; ?></td>
    </tr>
  </table>
  <pagebreak sheet-size="330mm 210mm" />
  <h2 class="small">Detil Pengadaan B2, Distribusi B2 dan Repacking B2</h2>
  <?php
	  $jml_pelaporan = count($pelaporan);
	  ?>
  <table class="tb_temuan">
    <tr class="header">
      <th>Bahan Berbahaya</th>
      <th colspan="2">Kemasan</th>
      <th colspan="3">Pengadaan</th>
      <th colspan="3">Distribusi</th>
    </tr>
    <tr class="header">
      <th>&nbsp;</th>
      <th>Ukuran</th>
      <th>Repacking</th>
      <th>Nama <br />Alamat Pemasok</th>
      <th>Status <br />Pemasok</th>
      <th>Ukuran <br />Kemasan</th>
      <th>Nama <br />Alamat Pembeli</th>
      <th>Jenis <br />Sarana</th>
      <th>Tujuan <br />Penggunaan</th>
    </tr>
    <?php
	if($jml_pelaporan > 0){
		for($z=0; $z < $jml_pelaporan; $z++){
	?>
    <tr>
      <td><?php echo $pelaporan[$z]['PRODUK_BB']; ?></td>
      <td><?php echo $pelaporan[$z]['KEMASAN']; ?></td>
      <td><?php echo $pelaporan[$z]['REPACKING']; ?></td>
      <td><?php echo $pelaporan[$z]['PENGADAAN_SARANA'].'<br />'.$pelaporan[$z]['PENGADAAN_ALAMAT'].'<br>'.$pelaporan[$z]['PENGADAAN_DAERAH_ID']; ?></td>
      <td><?php echo $pelaporan[$z]['PENGADAAN_STATUS']; ?></td>
      <td><?php echo $pelaporan[$z]['PENGADAAN_KEMASAN']; ?></td>
      <td><?php echo $pelaporan[$z]['DISTRIBUSI_SARANA'].'<br />'.$pelaporan[$z]['DISTRIBUSI_ALAMAT'].'<br>'.$pelaporan[$z]['DISTRIBUSI_DAERAH_ID']; ?></td>
      <td><?php echo $pelaporan[$z]['DISTRIBUSI_JENIS']; ?></td>
      <td><?php echo $pelaporan[$z]['DISTRIBUSI_TUJUAN']; ?></td>
    </tr>
    <?php
		}
	}else{
	?>
    <tr>
      <td colspan="9">Data tidak ditemukan</td>
    </tr>
    <?php
	}
	?>
  </table>
  <div style="height:5px;"></div>
</div>
<div id="temuan-produk" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Penelusuran Jaringan"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } ?>>
  <pagebreak sheet-size="330mm 210mm" />
  <h2 class="small garis">Temuan Produk</h2>
  <div style="height:5px;"></div>
  <?php
  $jmlproduk = count($tmkproduk);
  ?>
  <table class="tb_temuan">
  	<tr class="header">
      <th>Bahan Berbahaya</th>
      <th>Nama Sarana</th>
      <th>Ukuran & <br /> Asal Bahan Berbahaya</th>
      <th>Sumber Pengadaan</th>
      <th>Cara Pembelian & <br />Status Produk</th>
    </tr>
    <?php
	if($jmlproduk > 0){
		for($y = 0; $y < $jmlproduk; $y++){
	?>
    <tr>
      <td><?php echo $tmkproduk[$y]['NAMA_BB']; ?></td>
      <td><?php echo $tmkproduk[$y]['NAMA_PERUSAHAAN'].'<br>'.$tmkproduk[$y]['ALAMAT_PERUSAHAAN'].'<br>'.$tmkproduk[$y]['TELEPON'].'</td><td>'.$tmkproduk[$y]['KEMASAN'].'<br />'.$tmkproduk[$y]['KLASIFIKASI_PRODUK']; ?></td>
      <td><?php echo $tmkproduk[$y]['SUMBER_PENGADAAN']; ?></td>
      <td><?php echo $tmkproduk[$y]['CARA_PEMBELIAN'].'<br />'.$tmkproduk[$y]['STATUS']; ?></td>
    </tr>
    
    <?php
		}
	}else{
	?>
    <tr>
      <td colspan="5">Data tidak ditemukan</td>
    </tr>
    <?php
	}
	?>
  </table>
  <!-- Temuan Produk !--> 
</div>
<!-- Akhir Detil Pemeriksaaan !-->