<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
body {font-family:font-family: 'Times New Roman'; font-size:9pt; line-height:20px;}
@page {margin-top:1.5cm; margin-bottom: 1.5cm; margin-left: 2.5cm; margin-right: 2cm;}
.kolom .kiri{float: left; width:53px; padding:5px; border-right:1px solid #000;}
.kolom .kanan{float: right; width:218px; text-align:center; margin-right:5px;}
.sampel td{padding:5px;}
.sampel th{padding:10px;}
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
        <td>Perihal</td><td>:</td><td>Tanggapan Uji Absah</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">Kepada Yth.</td>
    </tr>
    <tr>
        <td colspan="3">Kepala <?php echo $header[0]['BBPOM_NAMA_PENGIRIM']; ?></td>
    </tr>
    <tr>
        <td colspan="3">di tempat</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">Menindaklanjuti surat permohonan uji absah nomor <b><?php echo $header[0]['NOMOR_SURAT_PENGANTAR']; ?></b> dari <b><?php echo $header[0]['BBPOM_NAMA_PENGIRIM']; ?></b> pada tanggal <b><?php echo $header[0]['TGL_SURAT_PENGANTAR']; ?></b>, maka dengan ini kami sampaikan tanggapan hasil uji TMS sebagai berikut :</td>
    </tr>
    </table>
</div>


<table class="sampel" width="100%" border="1" style="border-collapse: collapse;">
        <tr>
            <th>Data Sampel</th>
            <th>Tanggapan</th>
        </tr>
        <tr>
            <td width="50%">                    
                    Kode Sampel : <b><?php echo $header[0]['KODE_SAMPEL']; ?></b> <br>
                    Nama Sampel : <b><?php echo $header[0]['NAMA_SAMPEL']; ?></b> <br>
                    Nomor Registrasi : <b><?php echo $header[0]['NOMOR_REGISTRASI']; ?></b> <br>
                    Pabrik : <b><?php echo $header[0]['PABRIK']; ?></b> <br>
                    No Batch : <b><?php echo $header[0]['NO_BETS']; ?></b> <br>               
            </td>
            <td><b><?php echo $header[0]['TANGGAPAN']; ?></b></td>          
        </tr>
    </table>


    <div style="height:5px;">&nbsp;</div>
    <table width="100%">
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
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td width="60%">&nbsp;</td><td ><table ><tr><td align="center">Kepala <?php echo $header[0]['BBPOM_NAMA_TUJUAN']; ?></td></tr><tr><td><br><br><br><br></td></tr><tr><td align="center" ><?php echo $header[0]['NAMA_KEPALA_BALAI']; ?><br><?php echo $header[0]['NIP_KEPALA_BALAI']; ?></td></tr></table></td>
        </tr>
    </table>
   