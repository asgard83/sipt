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
.sampel th{padding: 15px;}
.sampel td{padding: 10px;}
</style>
<div style="padding-top:30px;padding-bottom:20px" >
    <table style="border:0;" width="100%">
    <tr >
        <td colspan="3" align="right"><?php echo $header[0]['KOTA']; ?>, <?php echo $header[0]['CREATE_DATE']; ?></td>
    </tr>
    <tr>
        <td width='15%'>Nomor</td><td width='5px'>:</td><td><?php echo $header[0]['NOMOR_SURAT']; ?></td>
    </tr>
    <tr>
        <td>Lampiran</td><td>:</td><td>1 berkas</td>
    </tr>
    <tr>
        <td>Perihal</td><td>:</td><td>Permohonan Uji Rujuk</td>
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
        <td colspan="3">Sehubungan dengan pengujian yang tidak dapat dilakukan di <b><?php echo $header[0]['BBPOM_NAMA_PENGIRIM']; ?></b>, bersama ini kami kirimkan sampel dengan rincian sebagai berikut :</td>
    </tr>
    </table>
</div>

<?php 
//$jml = count($sess);
$z = 0;
//for($i=0; $i<$jml; $i++){
	?>
    <table class="sampel" width="100%" border="1" style="border-collapse: collapse;">
        <tr>
            <th>No</th>
            <th>Kode Sampel</th>
            <th>Nama Sampel</th>
            <th>Pabrik</th>
            <th>No. Batch</th>
        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center"><b><?php echo $header[0]['KODE_SAMPEL']; ?></b></td>
            <td><b><?php echo $header[0]['NAMA_SAMPEL']; ?></b></td>
            <td><b><?php echo $header[0]['PABRIK']; ?></b></td>
            <td align="center"><b><?php echo $header[0]['NO_BETS']; ?></b></td>
        </tr>
    </table>
    
    <div style="height:5px;">&nbsp;</div>
    <table width="100%">
        <tr>
            <td colspan="2">Kami mohon untuk dilakukan uji di laboratorium <b><?php echo $header[0]['BBPOM_NAMA_TUJUAN']; ?></b>.</td>
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
   