<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: "Times New Roman"; font-size:10pt;}
@page {margin-top: 2.5cm; margin-bottom: 2.5cm; margin-left: 2.5cm; margin-right: 2.5cm;}
h2.judulbap{font-size:14pt; font-weight:bold; text-decoration:underline;}
table td{vertical-align:top; text-align:justify;}
table.tb_temuan{font-size:8pt; border-collapse:collapse; border-spacing:0; width:100%; padding:5px;}
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
<pagebreak>
<p><b>Lampiran I</b></p>
<p><b>Sarana yang diperiksa : </b></p>
<table width="100%">
	<tr><td width="200">Nama Toko Obat</td><td width="20">:</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
	<tr><td width="200">Alamat</td><td width="20">:</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
	<tr><td width="200">Telepon</td><td width="20">:</td><td><?php if(trim($sess["TELEPON"]) != "") { ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?></ul><?php } ?></td></tr>
	<tr><td width="200">Nomor Izin</td><td width="20">:</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
	<tr><td width="200">Tanggal Izin</td><td width="20">:</td><td><?php echo $sess['TANGGAL_IZIN']; ?></td></tr>
	<tr><td width="200">Nama Pemilik / Pimpinan</td><td width="20">:</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
	<tr><td width="200">Nama Penanggung Jawab</td><td width="20">:</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
	<tr><td width="200">No. SIK</td><td width="20">:</td><td><?php echo $sess['NO_SIK']; ?></td></tr>
</table>
<div style="height:5px;"></div>
<p><b>Informasi Pemeriksaan</b></p>
<table width="100%">
	<tr><td width="200">Tanggal Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp; <?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
	<tr><td width="200">Tujuan Pemeriksaan</td><td width="20">:</td><td><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
</table>

<p><b>Hasil Pemeriksaan</b></p>
<table width="100%">
<tr><td width="200">Hasil Kesimpulan</td><td width="20">:</td><td><?php echo $sess['UR_HASIL']; ?></td></tr>
<tr><td>Kesimpulan Detil Pelanggaran</td><td width="20">:</td><td>
<ul style="list-style-type:decimal; padding-left:20px;">
    <li>Jumlah Pelanggaran Minor : <b><?php echo $sess['MINOR']; ?></b></li>
    <li>Jumlah Pelanggaran Major : <b><?php echo $sess['MAJOR']; ?></b></li>
    <li>Jumlah Pelanggaran Critical : <b><?php echo $sess['CRITICAL']; ?></b></li>
</ul>
</td></tr>
<tr><td>Hasil Temuan</td><td width="20">:</td><td>
<?php if(trim($sess['HASIL_TEMUAN']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $temuan = explode("___", $sess['HASIL_TEMUAN']); echo "<li>".join("</li><li>", $temuan)."</li>"; ?></ul><?php } ?>
</td></tr>
<tr><td>Hasil Temuan diluar Aspek Penilaian</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['HASIL_TEMUAN_LAIN'])); ?></td></tr>
<tr><td>Catatan Hasil Pemeriksaan</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['CATATAN_HASIL_PEMERIKSAAN'])); ?></td></tr>
</table>

<?php
if(in_array($sess['BBPOM_ID'], $this->config->item('cfg_unit'))){
}else{
	?>
    <p><b>Tindakan Balai</b></p>
<table width="100%">
<tr><td width="200">Saran Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess['TINDAK_LANJUT_BALAI']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_balai= explode("#", $sess['TINDAK_LANJUT_BALAI']); echo "<li>".join("</li><li>", $tl_balai)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td>Detail Tindak Lanjut</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETAIL_TINDAK_LANJUT_BALAI'])); ?></td></tr>
</table>

    <?php
}
?>


<?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?>
<p><b>Tindakan Pusat</b></p>
<table width="100%">
<tr><td width="200">Tindak Lanjut</td><td width="20">:</td><td><?php if(trim($sess['TINDAK_LANJUT_PUSAT']) != ""){ ?><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tl_pusat = explode("#", $sess['TINDAK_LANJUT_PUSAT']); echo "<li>".join("</li><li>", $tl_pusat)."</li>"; ?></ul><?php } ?></td></tr>
<tr><td>Detail Tindak Lanjut</td><td width="20">:</td><td><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['DETIL_TINDAK_LANJUT_PUSAT'])); ?></td></tr>
</table>
<?php } ?>

<?php
if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin"){#Tujuan Pemeriksaan Rutin
	if($sess['HASIL'] == "TMK"){#Jika hasil TMK 
		?>
        <pagebreak sheet-size="330mm 210mm" />
        <p><b>Lampiran II</b></p>
        <p>Checklist Aspek Penilaian</p>
        <h2 class="small">1. Profil Sarana</h2>
          <table class="form_tabel" group="1. Profil Sarana">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
            <tr id="point1suba" y="Nama dan alamat toko obat sesuai Surat Izin toko obat." t="Nama dan alamat toko obat tidak sesuai Surat Izin toko obat.">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah nama dan alamat toko obat sesuai Surat Izin toko obat?</td><td class="td_kritis">Tingkat Kekritisan (C)</td><td class="td_kritis"><?php echo $aspek_penilaian[0]; ?></td>
            </tr>
            <tr id="point1subb" y="Asisten Apoteker sesuai izin." t="Asisten Apoteker tidak sesuai izin.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">apakah Asisten Apoteker sesuai izin?</td><td class="td_kritis">Tingkat Kekritisan (C)</td><td class="td_kritis"><?php echo $aspek_penilaian[1]; ?></td>
            </tr>
            <tr id="point1subc" y="Memiliki papan nama yang mencantumkan izin, 'Toko Obat Berizin' dan tulisan 'tidak menerima resep dokter'" t="Tidak memiliki papan nama yang mencantumkan izin, 'Toko Obat Berizin' dan tulisan 'tidak menerima resep dokter'">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah memiliki papan nama yang mencantumkan izin, &quot;Toko Obat Berizin&quot; dan tulisan &quot;tidak menerima resep dokter&quot;? </td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[2]; ?></td>
            </tr>
            <tr id="point1subd" y="Selama jam buka toko obat terdapat tenaga teknis kefarmasian." t="Selama jam buka toko obat tidak terdapat tenaga teknis kefarmasian.">
                <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah selama jam buka toko obat terdapat tenaga teknis kefarmasian?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[3]; ?></td>
            </tr>
            <tr id="point1sube" y="Memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat/toko obat) terbaru." t="Tidak memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat/toko obat) terbaru.">
              <td align="right" class="atas">e.&nbsp;</td>
              <td class="td_aspek">Apakah memiliki buku standar dan peraturan perundang-undangan (FI, UU Psikotropika, UU Narkotika, UU Kesehatan, Perundang-undangan di bidang obat/toko obat) terbaru?</td>
              <td class="td_kritis">Tingkat Kekritisan (M)</td>
              <td class="td_kritis"><?php echo $aspek_penilaian[4]; ?></td>
              </tr>
            <tr id="point1subf" y="Izin toko obat masih berlaku." t="Izin toko obat tidak berlaku.">
              <td class="td_no">f.&nbsp;</td>
              <td class="td_aspek">Apakah izin toko obat masih berlaku?</td>
              <td class="td_kritis">Tingkat Kekritisan (M)</td>
              <td class="td_kritis"><?php echo $aspek_penilaian[5]; ?></td>
              </tr>
        </table>
        <h2 class="small">2. Bangunan dan Peralatan </h2>                  
        <table class="form_tabel" group="2. Bangunan dan Peralatan">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point2suba" y="Kebersihan dan kerapian bangunan dijaga serta dipelihara." t="Kebersihan dan kerapian bangunan tidak dijaga serta tidak dipelihara.">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah kebersihan dan kerapian bangunan dijaga serta dipelihara?</td>
                <td class="td_kritis">Tingkat Kekritisan (m)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[6]; ?></td>
            </tr>
            <tr id="point2subb" y="Ventilasi dan penerangan di ruangan memadai." t="Ventilasi dan penerangan di ruangan tidak memadai.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah ventilasi dan penerangan di ruangan memadai? </td>
                <td class="td_kritis">Tingkat Kekritisan (m)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[7]; ?></td>
            </tr>
            <tr id="point2subc" y="Mempunyai ruang penyimpanan yang memadai sesuai dengan kriteria penyimpanan obat." t="Ruang penyimpanan tidak memadai dan tidak sesuai dengan kriteria penyimpanan obat.">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah mempunyai ruang penyimpanan yang memadai sesuai dengan kriteria penyimpanan obat?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[8]; ?></td>
            </tr>
            <tr id="point2subd" y="Dilengkapi dengan alat pemadam kebakaran." t="Tidak dilengkapi dengan alat pemadam kebakaran.">
                <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah dilengkapi dengan alat pemadam kebakaran?</td>
                <td class="td_kritis">Tingkat Kekritisan (m)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[9]; ?></td>
            </tr>
        </table>
        <h2 class="small">3. Pengadaan</h2>                  
        <table class="form_tabel" group="3. Pengadaan">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point3suba" y="Pengadaan dari sumber resmi dan menggunakan surat pesanan." t="Pengadaan tidak berasal dari sumber resmi dan tidak menggunakan surat pesanan.">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah pengadaan dari sumber resmi dan menggunakan surat pesanan?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[10]; ?></td>
            </tr>
            <tr id="point3subb" y="Surat pesanan diarsipkan berdasarkan nomor urut dan tanggal pemesanan." t="Surat pesanan tidak diarsipkan berdasarkan nomor urut dan tanggal pemesanan.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah surat pesanan diarsipkan berdasarkan nomor urut dan tanggal pemesanan?</td>
                <td class="td_kritis">Tingkat Kekritisan (m)</td><td class="td_kritis"><?php echo $aspek_penilaian[11]; ?></td>
            </tr>
            <tr id="point3subc" y="Faktur atau bukti pembelian, diarsipkan berdasarkan tanggal penerimaan oleh AA dan atau bagian administrasi." t="Faktur atau bukti pembelian, tidak diarsipkan berdasarkan tanggal penerimaan oleh AA dan atau bagian administrasi.">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah faktur atau bukti pembelian, diarsipkan berdasarkan tanggal penerimaan oleh AA dan atau bagian administrasi?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td><td class="td_kritis"><?php echo $aspek_penilaian[12]; ?></td>
            </tr>
        </table>
        <h2 class="small">4. Penerimaan dan Penyimpanan</h2>                  
        <table class="form_tabel" group="4. Penerimaan dan Penyimpanan">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point4suba" y="Tenaga teknis kefarmasian menandatangani faktur pembelian pada saat barang diterima" t="Tenaga teknis kefarmasian tidak menandatangani faktur pembelian pada saat barang diterima.">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah tenaga teknis kefarmasian menandatangani faktur pembelian pada saat barang diterima?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[13]; ?></td>
            </tr>
            <tr id="point4subb" t="Setiap penerimaan barang tidak dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik." y="Setiap penerimaan barang dilakukan pemeriksaan terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dilakukan pemeriksaan dan penelitian terhadap barang tersebut meliputi :  nomor izin edar, nomor bets, tanggal kadaluarsa, kebenaran kemasan, mutu produk secara fisik</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[14]; ?></td>
            </tr>
            <tr id="point4subc" y="Setiap penerimaan barang dicatat pada kartu stok dan catatan penerimaan. (manual atau elektronik)" t="Setiap penerimaan barang tidak dicatat pada kartu stok dan catatan penerimaan. (manual atau elektronik)">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah setiap penerimaan barang dicatat pada kartu stok dan catatan penerimaan? (manual atau elektronik)</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[15]; ?></td>
            </tr>
            <tr id="point4subd" y="Pengisian kartu stok dan catatan penerimaan sesuai dengan ketentuan CDOB. (manual atau elektronik)" t="Pengisian kartu stok dan catatan tidak sesuai dengan penerimaan dengan ketentuan CDOB. (manual atau elektronik)">
                <td class="td_no">d.&nbsp;</td><td class="td_aspek">Apakah pengisian kartu stok dan catatan penerimaan sesuai dengan ketentuan CDOB? (manual atau elektronik)</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[16]; ?></td>
            </tr>
            
            <tr id="point4sube" y="Pengeluaran obat berdasarkan sistem first in first out / first exp first out." t="Pengeluaran obat tidak berdasarkan sistem first in first out / first exp first out.">
                <td class="td_no">e.&nbsp;</td><td class="td_aspek">Apakah pengeluaran obat berdasarkan sistem first in first out / first exp first out ? </td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[17]; ?></td>
            </tr>
            <tr id="point4subf" y="Obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya." t="Obat disimpan pada kondisi tidak sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya.">
                <td class="td_no">f.&nbsp;</td><td class="td_aspek">Apakah obat disimpan pada kondisi sesuai dengan yang tercantum dalam kemasan obat serta terpisah dari komoditi lainnya?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[18]; ?></td>
            </tr>
            <tr id="point4subg" y="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci." t="Obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan tidak diinventarisir, tidak dipisahkan penyimpanannya dan tidak terkunci.">
                <td class="td_no">g.&nbsp;</td><td class="td_aspek">Apakah obat yang mendekati kadaluarsa, telah kadaluarsa, mengalami kerusakan kemasan, tutup atau yang diduga kemungkinan mengalami kontaminasi dan yang akan dimusnahkan diinventarisir, dipisahkan penyimpanannya dan terkunci?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[19]; ?></td>
            </tr>
            <tr id="point4subh" y="Jumlah dalam kartu stok sesuai dengan jumlah fisik." t="Jumlah dalam kartu stok tidak sesuai dengan jumlah fisik.">
                <td class="td_no">h.&nbsp;</td><td class="td_aspek">Apakah jumlah dalam kartu stok sesuai dengan jumlah fisik?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[20]; ?></td>
            </tr>
        </table>
        <h2 class="small">5. Penjualan</h2>                  
        <table class="form_tabel" group="5. Penjualan">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point5suba" y="Menjual obat sesuai ketentuan." t="Menjual obat tidak sesuai ketentuan.">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah menjual obat sesuai ketentuan?</td>
                <td class="td_kritis">Tingkat Kekritisan (C)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[21]; ?></td>
            </tr>
            <tr id="point5subb" y="Obat yang dijual dikontrol oleh tenaga teknis kefarmasian." t="Obat yang dijual tidak dikontrol oleh tenaga teknis kefarmasian.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah obat yang dijual dikontrol oleh tenaga teknis kefarmasian? </td>
                <td class="td_kritis">Tingkat Kekritisan (C)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[22]; ?></td>
            </tr>
            <tr id="point5subc" y="Obat-obat yang disalurkan adalah obat-obat yang terdaftar" t="Obat-obat yang disalurkan adalah obat-obat yang tidak terdaftar">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah  obat-obat yang disalurkan adalah obat-obat yang terdaftar?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[23]; ?></td>
            </tr>
        </table>
        <h2 class="small">6. Penanganan Produk Kembalian dan Kadaluarsa</h2>
          <table class="form_tabel" group="6. Penanganan Produk Kembalian dan Kadaluarsa">
            <tr><td class="td_no isi">&nbsp;</td><td class="td_aspek isi">ASPEK DAN DETAIL</td><td class="td_kritis isi">TINGKAT KEKRITISAN</td><td class="td_kriteria isi">YA / TIDAK / NA</td></tr>
<tr id="point6suba" y="Setelah menerima informasi recall dari distributor, toko obat segera menghentikan penjualan dan mengembalikan ke distributor." t="Setelah menerima informasi recall dari distributor, toko obat tidak segera menghentikan penjualan dan mengembalikan ke distributor">
                <td class="td_no">a.&nbsp;</td><td class="td_aspek">Apakah setelah menerima informasi recall dari distributor, toko obat segera menghentikan penjualan dan mengembalikan ke distributor? </td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[24]; ?></td>
            </tr>
            <tr id="point6subb" y="Pengembalian obat ke distributor disertai dengan faktur pembelian." t="Pengembalian obat ke distributor tidak disertai dengan faktur pembelian.">
                <td class="td_no">b.&nbsp;</td><td class="td_aspek">Apakah pengembalian obat ke distributor disertai dengan faktur pembelian?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[25]; ?></td>
            </tr>
            <tr id="point6subc" y="Obat yang telah kadaluarsa disimpan terpisah dengan obat layak jual." t="Obat yang telah kadaluarsa tidak disimpan terpisah dengan obat layak jual.">
                <td class="td_no">c.&nbsp;</td><td class="td_aspek">Apakah obat yang telah kadaluarsa disimpan terpisah dengan obat layak jual?</td>
                <td class="td_kritis">Tingkat Kekritisan (M)</td>
                <td class="td_kritis"><?php echo $aspek_penilaian[26]; ?></td>
            </tr>
        </table>
        <?php
	}
	
}else{#Tujuan Pemeriksaan Kasus
	?>
	<p><b>Lampiran II</b></p>
    <p>Tujuan Pemeriksaan Kasus</p>
    <h2 class="small">A. PROFIL SARANA DAN ORGANISASI</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_A'])); ?></div>
    <h2 class="small">B. PERSONALIA</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_B'])); ?></div>
    <h2 class="small">C. GUDANG DAN PERLENGKAPAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_C'])); ?></div>
    <h2 class="small">D. PENGADAAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_D'])); ?></div>
    <h2 class="small">E. PENYIMPANAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_E'])); ?></div>
    <h2 class="small">F. PENDISTRIBUSIAN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_F'])); ?></div>
    <h2 class="small">G. DOKUMENTASI</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_G'])); ?></div>
    <h2 class="small">H. LAIN-LAIN</h2>
    <div><?php echo preg_replace('/[^(\x20-\x7F)]*/','',html_entity_decode($sess['KASUS_POINT_H'])); ?></div>
    <?php
}
?>

<?php if($sess['JUMLAH_TEMUAN'] != 0) { ?>
<pagebreak sheet-size="330mm 210mm" />
<p><b>Lampiran III </b></p>
<p>Temuan Produk</p>
<table class="tb_temuan">
<tr class="header"><th>Detil Produk</th><th>Detil Perusahaan</th><th>Temuan</th><th>Tindakan</th><th>Keterangan</th></tr>
<?php
if($sess['JUMLAH_TEMUAN'] != 0){
	for($i=0; $i<count($temuan_produk); $i++){
		?>
		<tr><td>Nama Produk : <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>Nama Pabrik : <?php echo $temuan_produk[$i]['NAMA_PABRIK']; ?><br>Negara Asal : <?php echo $temuan_produk[$i]['NEGARA_ASAL']; ?><br>Kemasan : <?php echo $temuan_produk[$i]['KEMASAN']; ?><br>NIE : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?><br>No. Lot / Bets : <?php echo $temuan_produk[$i]['NO_BATCH']; ?><br>Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?></td><td>Produsen : <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>Pendaftar : <?php echo $temuan_produk[$i]['PEMILIK']; ?><br />Alamat : <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?></td><td>Kategori Temuan : <?php echo $temuan_produk[$i]['KATEGORI']; ?><br>Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?></td><td><?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?></td><td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?></td></tr>
		<?php
	}
}else{
	$temuan_produk = "";
} ?>                  
</table>
<?php } ?>


