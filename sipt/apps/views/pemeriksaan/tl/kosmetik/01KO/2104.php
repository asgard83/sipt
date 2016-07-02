<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<style>
<?php if($ispdf){ ?>
	body {font-family:Georgia, "Times New Roman", font-size:12pt;}
	@page {margin-top: 3.5cm; margin-bottom: 3.5cm; margin-left: 2.3cm; margin-right: 2.3cm;}
	/*table{border-collapse:collapse; width:100%; font-size:12px; vertical-align:top;}*/
<?php }else{ ?>
	body {font-family: "lucida grande", Tahoma, verdana, arial, sans-serif; font-size:11px;}
	/*table{border-collapse:collapse; width:100%; font-size:11px; vertical-align:top;}*/
	table.detil table{border-collapse:collapse; width:100%; font-size:11px;}
<?php } ?>
	p{margin:0px; padding:0px;}
</style>
<table <?php if($ispdf) echo 'width="100%"'; else echo 'class="detil" width="100%"'; ?>>
  <tr>
    <td width="14%">Nomor</td>
    <td width="3%">:</td>
    <td width="47%"><?php echo $sess['SURAT TL']; ?></td>
    <td width="36%"><?php echo $sess['TEMPAT']; ?>, <?php echo $sess['TANGGAL TL']; ?></td>
  </tr>
  <tr>
    <td>Lampiran</td>
    <td>:</td>
    <td colspan="2"><?php echo $sess['LAMPIRAN']; ?></td>
  </tr>
  <tr>
    <td>Perihal</td>
    <td>:</td>
    <td colspan="2"><?php echo $sess['PERIHAL SURAT']; ?></td>
  </tr>
</table>
<div style="height:30px;"></div>
Kepada Yth <br />
Pimpinan dan Apoteker Penanggung Jawab <?php echo $sess['NAMA_SARANA']; ?><br />
<?php echo $sess['ALAMAT_1']; ?>
<div style="height:30px;"></div>
<?php if(count($kritikal) > 0 && count($major) > 0) { ?>
<div style="text-align:justify; padding-bottom:20px;">Berdasarkan hasil inspeksi yang dilakukan oleh <?php echo $sess['BBPOM']; ?> pada tanggal <?php echo $sess['TANGGAL']; ?>,  dengan ini kami beritahukan bahwa Industri Kosmetik Saudara telah melakukan penyimpangan dari ketentuan CPKB sesuai temuan sebagai berikut :</div>
<div style="padding-bottom:20px;">
	<ul>
    	<li style="list-style-type:disc;"><b>Temuan Kritikal</b></li>
            <ul style="list-style:none;">
            <?php 
            $currentkritikal = "";
            for($i=0; $i<count($kritikal); $i++){
                ?>
                <li><b>
                <?php
                if($kritikal[$i]['URAIAN'] != $currentkritikal){
                    echo $kritikal[$i]['URAIAN'];
                }
                $currentkritikal = $kritikal[$i]['URAIAN'];
                ?>
                </b><li>
                <li><?php echo $kritikal[$i]['TEMUAN_TEKS']; ?></li>
                <?php
            }
            ?>
            </ul>
    </ul>
    
	<ul>
    	<li style="list-style-type:disc;"><b>Temuan Mayor</b></li>
            <ul style="list-style:none;">
            <?php 
            $currentmajor = "";
            for($i=0; $i<count($major); $i++){
                ?>
                <li><b>
                <?php
                if($major[$i]['URAIAN'] != $currentmajor){
                    echo $major[$i]['URAIAN'];
                }
                $currentmajor = $major[$i]['URAIAN'];
                ?>
                </b><li>
                <li><?php echo $major[$i]['TEMUAN_TEKS']; ?></li>
                <?php
            }
            ?>
            </ul>
    </ul>
</div>
<?php } ?>

<div style="text-align:justify;">Adapun klasifikasi terhadap semua temuan inspeksi terangkum pada laporan inspeksi terlampir. </div>

<div style="text-align:justify">
Sehubungan dengan hal tersebut diatas, kami dengan ini memberikan <b><?php echo $sess['PERIHAL SURAT']; ?></b> kepada Industri Kosmetik <?php echo $sess['NAMA_SARANA']; ?>.
</div>

<div style="height:20px;"></div>
<div style="text-align:justify;">Selanjutya kami minta Saudara untuk segera membuat CAPA sesuai POM terlampir terhadap semua temuan inspeksi sesuai laporan inspeksi / hasil inspeksi <?php echo $sess['BBPOM']; ?> dalam jangka waktu 1 (dua) bulan sejak tanggal surat ini. CAPA dalam bentuk soft copy dan hard copy serta bukti perbaikan yang sudah dilakukan agar dilaporkan kepada kami dengan tembusan Kepala <?php echo $sess['BALAI']; ?>.
</div>

<div style="height:20px;"></div>
<div style="text-align:justify;">Apabila dalam waktu 1 (satu) bulan Saudara belum melaporkan CAPA dan bukti perbaikan, maka kami akan memberikan sanksi yang lebih keras sesuai dengan peraturan perudang-undangan yang berlaku</div>

<div style="height:20px;"></div>
<div style="text-align:justify;">Demikian agar dilaksankan dengan sebaik-baiknya.</div>


<div style="height:30px;"></div>
<?php if($ispdf){ ?>
<table width="100%">
   <tr>
    <td width="50%">&nbsp;</td>
    <td style="text-align:center"><?php echo $sess['JABATAN']; ?></td>
  </tr>
  <tr>
    <td width="50%" style="height:80px;">&nbsp;</td>
    <td style="text-align:center; height:80px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center; border-bottom:1px solid #000;"><?php echo $sess['NAMA TTD']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center">NIP : <?php echo $sess['NIP']; ?></td>
  </tr>
</table>
<?php } else{ ?>
<table class="detil" width="100%">
   <tr>
    <td width="50%">&nbsp;</td>
    <td style="text-align:center"><?php echo $sess['JABATAN']; ?></td>
  </tr>
  <tr>
    <td width="50%" style="height:80px;">&nbsp;</td>
    <td style="text-align:center; height:80px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;"><?php echo $sess['NAMA TTD']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center">NIP : <?php echo $sess['NIP']; ?></td>
  </tr>
</table>
<?php } ?>

<div style="height:30px;"></div>
<div>
Tembusan : <br>
<?php echo $sess['TEMBUSAN']; ?>
</div>

