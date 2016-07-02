<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: 'Times New Roman'; font-size:9pt; line-height:20px;}
@page {margin-top:1.5cm; margin-bottom: 1.5cm; margin-left: 2.5cm; margin-right: 2cm;}
table.form_tabel td{vertical-align:top; text-align:justify; padding:2px; font-size:8pt;}
table.form_tabel td.kotak{border-bottom:1px solid #505968;}
table.form_tabel td.bold{font-weight:bold; width:225px; vertical-align:top; font-size:9pt;}
table.form_tabel td.garis{vertical-align:top; border-bottom:1px solid #505968;padding-left:10px; padding-bottom:2px;}
table.form_tabel td.garisatas{vertical-align:top; border-top:1px solid #505968;padding-left:10px; padding-bottom:2px;}
.hideme{display:none;}
.kolom{width:300px; display:block; display:block;}
.kolom .kiri{float: left; width:53px; padding:5px; border-right:1px solid #000;}
.kolom .kanan{float: right; width:218px; text-align:center; margin-right:5px;}
</style>
<div style="padding-top:30px;padding-bottom:20px" >
    <table style="border:0;" width="100%">
    <tr >
        <td colspan="3" align="right"><?php echo $header[0]['KOTA']; ?>, <?php echo $header[0]['TGL_SRT']; ?></td>
    </tr>
    <tr>
        <td width='15%'>Nomor</td><td width='5px'>:</td><td><?php echo $header[0]['NOMOR_SURAT']; ?></td>
    </tr>
    <tr>
        <td>Lampiran</td><td>:</td><td>1 berkas</td>
    </tr>
    <tr>
        <td>Perihal</td><td>:</td><td>Permohonan Uji Absah</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">Kepada Yth.</td>
    </tr>
    <tr>
        <td colspan="3">Kepala <?php echo $header[0]['BBPOM_NAMA_TUJUAN']; ?></td>
    </tr>
    <tr>
        <td colspan="3">di tempat</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">Berdasarkan hasil pengujian <b><?php echo $header[0]['BBPOM_NAMA_PENGIRIM']; ?></b> pada <b><?php echo $header[0]['TGL_UJI']; ?></b>, ditemukan 1 (satu) item sampel <komoditi> yang tidak memenuhi syarat sebagai berikut :</td>
    </tr>
    </table>
</div>

<?php 
//$jml = count($sess);
$z = 0;
//for($i=0; $i<$jml; $i++){
	?>
    <table class="form_tabel" width="100%">
        <tr><td width="22%">Kode Sampel</td><td class="kotak" colspan="3"><b><?php echo $header[0]['KODE_SAMPEL']; ?></b></td></tr>
        <tr><td >Nama Sampel</td><td class="kotak" colspan="3"><b><?php echo $header[0]['NAMA_SAMPEL']; ?></b></td></tr>
        <tr><td >Nomor Registrasi</td><td class="kotak" colspan="3"><b><?php echo $header[0]['NOMOR_REGISTRASI']; ?></b></td></tr>
        <tr><td >Pabrik</td><td class="kotak" colspan="3"><b><?php echo $header[0]['PABRIK']; ?></b></td></tr>
        <tr><td >Importir</td><td class="kotak" colspan="3"><b><?php echo $header[0]['IMPORTIR']; ?></b></td></tr>
        <tr><td >Kemasan</td><td class="kotak" colspan="3"><b><?php echo $header[0]['KEMASAN']; ?></b></td></tr>
        <tr><td >No Batch</td><td class="kotak" colspan="3"><b><?php echo $header[0]['NO_BETS']; ?></b></td></tr>
        <tr><td >Tanggal Kedaluwarsa</td><td class="kotak" colspan="3"><b><?php echo $header[0]['KETERANGAN_ED']; ?></b></td></tr>
        <tr><td >Sampling</td><td class="kotak" colspan="3"><b><?php echo $header[0]['TGL_SAMPLING']. " / ".$header[0]['TEMPAT_SAMPLING']; ?></b></td></tr>
        <tr><td >Komposisi</td><td class="kotak" colspan="3"><b><?php echo $header[0]['KOMPOSISI']; ?></b></td></tr>
        <tr><td >Jumlah dikirim</td><td class="kotak" colspan="3"><b><?php echo $header[0]['JUMLAH_SAMPEL']. " ".$header[0]['SATUAN']; ?></b></td></tr>
        <tr><td >Hasil Uji</td><td class="kotak" colspan="3">
        <?php
        $jml = count($detil);
        for($i=0; $i<$jml; $i++){
            echo "<b>".$detil[$i]['parameter_uji']." : ".$detil[$i]['hasil_parameter']."<br> catatan :".$detil[$i]['catatan']."</b><br><br>";
        }?>        

        </td></tr>
    </table>
    <div style="height:5px;">&nbsp;</div>
    <table width="100%">
        <tr>
            <td colspan="2">Sehubungan dengan hal tersebut, kami mohon dilakukan uji absah di laboratorium <b><?php echo $header[0]['BBPOM_NAMA_TUJUAN']; ?></b>. Bersama ini kami lampirkan Laporan Hasil Uji dan CP/LCP.</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">Demikian, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="65%">&nbsp;</td><td ><table ><tr><td align="center">Kepala <?php echo $header[0]['BBPOM_NAMA_PENGIRIM']; ?></td></tr><tr><td><br><br><br><br></td></tr><tr><td align="center" ><?php echo $header[0]['NAMA_KEPALA_BALAI']; ?><br><?php echo $header[0]['NIP_KEPALA_BALAI']; ?></td></tr></table></td>
        </tr>
    </table>
   