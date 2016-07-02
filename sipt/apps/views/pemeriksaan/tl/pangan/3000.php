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
</style>
<table <?php if($ispdf) echo 'width="100%"'; else echo 'class="detil" width="100%"'; ?>>
  <tr>
    <td width="14%">Nomor</td>
    <td width="3%">:</td>
    <td width="47%"><?php echo $sess['SURAT TL']; ?></td>
    <td width="36%" align="right"><?php echo $sess['TEMPAT']; ?>, <?php echo $sess['TANGGAL TL']; ?></td>
  </tr>
  <tr>
    <td>Lampiran</td>
    <td>:</td>
    <td colspan="2"><?php echo $sess['LAMPIRAN']; ?></td>
  </tr>
  <tr>
    <td>Perihal</td>
    <td>:</td>
    <td><?php echo $sess['PERIHAL SURAT']; ?></td>
    <td></td>
  </tr>
</table>
<div style="height:30px;"></div>
Kepada Yth.<br>
Pimpinan <?php echo $sess['NAMA_SARANA']; ?><br>
<?php echo $sess['ALAMAT_1']; ?><br>
<div style="height:30px;"></div>
<div style="text-align:justify">Sehubungan pemeriksaan sarana produksi oleh <?php echo $sess['BBPOM']; ?> pada tanggal <?php echo $sess['AWAL']; ?> s/d <?php echo $sess['AKHIR']; ?>, terhadap perusahaan Saudara, ditemukan penyimpangan sebagai berikut :</div>
<div style="text-align:justify;"><b>I. Penyimpangan Administratif </b>
<?php if(trim($sess['ADMINISTRATIF']) == ""){ ?> <br /> - <?php }else{ ?> <br /> <?php echo $sess['ADMINISTRATIF']; }?></div>
<div style="text-align:justify;"><b>II. Penyimpangan Fisik</b><?php if(trim($sess['FISIK']) == ""){?><br /> - <?php }else{ ?> <br /> <?php echo $sess['FISIK'];} ?></div>
<div style="text-align:justify;"><b>III. Penyimpangan Operasional</b><?php if(trim($sess['OPERASIONAL']) == ""){ ?> <br /> - <?php }else{ ?> <br /> <?php echo $sess['OPERASIONAL'];} ?></div>
<div style="text-align:justify; padding-bottom:10px;"><b>IV. Penyimpangan Lain-Lain </b> <?php if(trim($sess['LAINLAIN']) == ""){ ?> <br /> - <?php }else{ ?> <br /> <?php echo $sess['LAINLAIN'];} ?></div>
<div style="text-align:justify; padding-bottom:10px;">Penyimpangan tersebut merupakan pelanggaran terhadap ketentuan sebagai berikut : </div>
<div style="text-align:justify;">
<?php
$jmldata = count($jml_point);
$i = 0;
do{
	?>
  <div style="text-align:justify; padding-bottom:5px; margin-left:27px;"><?php echo $jml_point[$i]; ?></div>
  <div style="text-align:justify; padding-bottom:5px; margin-left:41px;"><?php echo $pelanggaran[$i]; ?></div>
    <?php
	$i++;
}while($i<$jmldata);
?>
</div>
<div style="text-align:justify;">Terhadap pelanggaran tersebut sesuai dengan ketentuan pada : </div>
<div style="text-align:justify;"><?php echo $sess['KETENTUAN']; ?></div>
<div style="text-align:justify;">Berdasarkan hal tersebut di atas, Saudara diberikan <b><?php echo $sess['TINDAKAN']; ?></b>, untuk melakukan hal-hal sebagai berikut : </div>
<div style="text-align:justify;"><?php echo $sess['KETERANGAN']; ?></div>
<div style="padding-bottom:30px;">Demikian,  agar dilaksanakan.</div>
<div style="height:20px;"></div>
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
<?php }else{ ?>
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
	
<div>
Tembusan : <br>
<?php echo $sess['TEMBUSAN']; ?>
</div>

