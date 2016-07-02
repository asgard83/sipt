<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function(){
	$(function() {
		$("#waktusampling_").datepicker();
		$("#waktuterima_").datepicker();
		$("#waktuexpired_").datepicker();
	});	
	numericOnly("#ujiulang_");
	numericOnly("#netto_");
	numericOnly("#jumlahsampel_");
	numericOnly("#harga_");
	
	$("#klasifikasi_").autocomplete($("#klasifikasi_").attr('url'), {width: 244, selectFirst: false});
	$("#klasifikasi_").result(function(event, data, formatted){
		if(data){
			$(this).val(data[2]);
			$("#kkid_").val(data[1]);
			$('#pengirim_').focus();
		}
	});
	
	$("#produk_").autocomplete($("#produk_").attr('url'), {width: 244, selectFirst: false});
	$("#produk_").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#namaproduk_").val(data[2]);
			$("#kategori_").val(data[3]);
			$("#nomorreg_").val(data[4]);
			$("#namasarana_").val(data[5]);
			$("#klasifikasi_").focus();			
		}
	});
});

</script>
<div id="judulmsampel" class="judul"></div>
<div class="content">
<form name="fsampel_" id="fsampel_" method="post" action="<?php echo $act; ?>" autocomplete="off">
<div class="kotak">
<div class="spjudul">KLASIFIKASI KATEGORI PRODUK</div>
<table cellpadding="1" cellspacing="1">
<tr>
<td class="atas" width="130">Uji Ulang</td><td class="atasnya"><input type="text" name="ujiulang_" id="ujiulang_" class="sdate" rel="required" value="<?php echo $ujiulang_;?>" /></td><td width="30">&nbsp;</td>
<td class="atas" width="130">&nbsp;</td><td>
</td>
</tr>
<tr>
  <td class="atas">Produk ID</td>
  <td class="atasnya"><input type="text" name="produk_" id="produk_" url="<?php echo site_url(); ?>/autocomplete/produk" class="stext" rel="required" value="<?php echo $produk_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Klasifikasi Kategori</td>
  <td class="atasnya"><input type="text" name="klasifikasi_" id="klasifikasi_" url="<?php echo site_url(); ?>/autocomplete/kategori" class="stext" rel="required" value="<?php echo $klasifikasi_ ;?>" /><input type="hidden" name="kkid_" id="kkid_" value="<?php echo $kkid_; ?>" /></td>
</tr>
<tr>
  <td width="130">Nama Produk</td>
  <td><input type="text" name="namaproduk_" id="namaproduk_" class="stext" value="<?php echo $namaproduk_; ?>" /></td>
  <td width="30">&nbsp;</td>
  <td width="130">Nomor Registrasi</td>
  <td><input type="text" name="nomorreg_" id="nomorreg_" class="stext" value="<?php echo $nomorreg_; ?>" />
<tr>
  <td>Kategori Produk</td>
  <td><input type="text" name="kategori_" id="kategori_" class="stext" value="<?php echo $kategori_; ?>" /></td>
  <td>&nbsp;</td>
  <td>Nama Sarana</td> 
  <td><input type="text" name="namasarana_" id="namasarana_"  class="stext" value="<?php echo $namasarana_; ?>" /></td>
  </tr>
</table>
</div>
<div class="kotak">
<div class="spjudul">INFORMASI SAMPEL</div>
<table cellpadding="1" cellspacing="1">
<tr>
<td class="atas" width="130">Pengirim</td><td class="atasnya"><input type="text" name="pengirim_" id="pengirim_" class="stext" rel="required" value="<?php echo $pengirim_;?>" /></td><td width="30">&nbsp;</td><td class="atas" width="130">Waktu Sampel</td><td class="atasnya"><input type="text" name="waktusampling_" id="waktusampling_" class="sdate" rel="required" value="<?php echo $waktusampling_ ;?>" /></td>
</tr>
<tr>
  <td class="atas">Tempat Sampel</td>
  <td class="atasnya"><input type="text" name="tempatsampling_" id="tempatsampling_" class="stext" rel="required" value="<?php echo $tempatsampling_;?>" /></td>
  <td>&nbsp;</td>
  <td rowspan="2" class="atas">Alamat Sampel</td>
  <td rowspan="2" class="atasnya"><textarea name="alamatsampling_" id="alamatsampling_" class="stext" rel="required"><?php echo $alamatsampling_; ?></textarea></td>
</tr>
<tr>
  <td class="atas">Kota Sampel</td>
  <td class="atasnya"><input type="text" name="kotasampling_" id="kotasampling_" class="stext" rel="required" value="<?php echo $kotasampling_ ;?>" /></td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td class="atas">Asal Sampel</td>
  <td class="atasnya"><input type="text" rel="required" name="asalsampel_" id="asalsampel_" class="stext" value="<?php echo $asalsampel_ ;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Waktu Terima</td>
  <td class="atasnya"><input type="text" rel="required" name="waktuterima_" id="waktuterima_" class="sdate" value="<?php echo $waktuterima_;?>" /></td>
</tr>
</table>
</div>
<div class="kotak">
<div class="spjudul">REGISTRASI SAMPEL</div>
<table cellpadding="1" cellspacing="1">
<tr>
<td class="atas" width="130">Nomor Registrasi</td><td class="atasnya"><input type="text" rel="required" name="nomorregsampel_" id="nomorregsampel_" class="stext" value="<?php echo $nomorregsampel_;?>" /></td><td width="30">&nbsp;</td><td class="atas" width="130">Nomor Bets</td><td class="atasnya"><input type="text" rel="required" name="nomorbets_" id="nomorbets_" class="stext" value="<?php echo $nomorbets_ ;?>" /></td>
</tr>
<tr>
  <td class="atas">Kode Produksi</td>
  <td class="atasnya"><input type="text" name="kodeproduksi_" id="kodeproduksi_" rel="required" class="stext" value="<?php echo $kodeproduksi_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Nomor Lab</td>
  <td class="atasnya"><input type="text" name="nomorlab_" id="nomorlab_" class="stext" rel="required" value="<?php echo $nomorlab_;?>" /></td>
</tr>
</table>
</div>
<div class="kotak">
<div class="spjudul">PENGUJIAN SAMPEL</div>
<table cellpadding="1" cellspacing="1">
<?php
if($this->uri->segment(4, "") == "edit" && $this->uri->segment(5, 0) > 0){
	
	?>
    <tr>
    <td class="atas" width="130">Pengujian Mikro</td><td class="atasnya"><input type="radio" name="pengmikro_[]" id="pengmikro_" <?php if($pengmikro_ == "1"){  echo "value='".$pengmikro_."' checked" ; }else{ echo "value='1'"; } ?> />&nbsp;Ya&nbsp;<input type="radio" name="pengmikro_[]" id="pengmikro_" <?php if($pengmikro_ == "0"){  echo "value='".$pengmikro_."' checked" ; }else{ echo "value='0'"; } ?> />&nbsp;Tidak</td><td width="30">&nbsp;</td><td class="atas" width="130">Pengujian Kimia Fisika</td><td class="atasnya"><input type="radio" name="pengkimfis_[]" id="pengkimfis_" <?php if($pengkimfis_ == "1"){  echo "value='".$pengkimfis_."' checked" ; }else{ echo "value='1'"; } ?>/>&nbsp;Ya&nbsp;<input type="radio" name="pengkimfis_[]" id="pengkimfis_" <?php if($pengkimfis_ == "0"){  echo "value='".$pengkimfis_."' checked" ; }else{ echo "value='0'"; } ?>/>&nbsp;Tidak</td>
    </tr>
    <tr>
      <td class="atas">Flag Mikro</td>
      <td class="atasnya"><input type="radio" name="flagmikro_[]" id="flagmikro_" <?php if($flagmikro_ == "1"){  echo "value='".$flagmikro_."' checked" ; }else{ echo "value='1'"; } ?>/>&nbsp;Ya&nbsp;<input type="radio" name="flagmikro_[]" id="flagmikro_" <?php if($flagmikro_ == "0"){  echo "value='".$flagmikro_."' checked" ; }else{ echo "value='0'"; } ?> />&nbsp;Tidak</td>
      <td>&nbsp;</td>
      <td class="atas">Flag Kimia Fisika</td>
      <td class="atasnya"><input type="radio" name="flagkimfis_[]" id="flagkimfis_" <?php if($flagkimfis_ == "1"){  echo "value='".$flagkimfis_."' checked" ; }else{ echo "value='1'"; } ?> />&nbsp;Ya&nbsp;<input type="radio" name="flagkimfis_[]" id="flagkimfis_" <?php if($flagkimfis_ == "0"){  echo "value='".$flagkimfis_."' checked" ; }else{ echo "value='0'"; } ?> />&nbsp;Tidak</td>
    </tr>
    <?php
}else{
	?>
    <tr>
    <td class="atas" width="130">Pengujian Mikro</td><td class="atasnya"><input type="radio" name="pengmikro_[]" id="pengmikro_" value="1" checked="checked" />&nbsp;Ya&nbsp;<input type="radio" name="pengmikro_[]" id="pengmikro_" value="0" />&nbsp;Tidak</td><td width="30">&nbsp;</td><td class="atas" width="130">Pengujian Kimia Fisika</td><td class="atasnya"><input type="radio" name="pengkimfis_[]" id="pengkimfis_" value="1" checked="checked"/>&nbsp;Ya&nbsp;<input type="radio" name="pengkimfis_[]" id="pengkimfis_" value="0"/>&nbsp;Tidak</td>
    </tr>
    <tr>
      <td class="atas">Flag Mikro</td>
      <td class="atasnya"><input type="radio" name="flagmikro_[]" id="flagmikro_" value="1" checked="checked" />&nbsp;Ya&nbsp;<input type="radio" name="flagmikro_[]" id="flagmikro_" value="0" />&nbsp;Tidak</td>
      <td>&nbsp;</td>
      <td class="atas">Flag Kimia Fisika</td>
      <td class="atasnya"><input type="radio" name="flagkimfis_[]" id="flagkimfis_" value="1" checked="checked" />&nbsp;Ya&nbsp;<input type="radio" name="flagkimfis_[]" id="flagkimfis_" value="0" />&nbsp;Tidak</td>
    </tr>
    <?php
}
?>
<tr>
  <td class="atas">Pengujian Label</td>
  <td class="atasnya"><input type="text" name="penglabel_" id="penglabel_" class="stext" rel="required" value="<?php echo $penglabel_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Flag Label</td>
  <td class="atasnya"><input type="text" name="flaglabel_" id="flaglabel_" class="stext" rel="required" value="<?php echo $flaglabel_;?>" /></td>
</tr>
<tr>
  <td class="atas">Jumlah Sampel</td>
  <td class="atasnya"><input type="text" name="jumlahsampel_" id="jumlahsampel_" class="sdate" rel="required" value="<?php echo $jumlahsampel_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Netto</td>
  <td class="atasnya"><input type="text" name="netto_" id="netto_" class="sdate" rel="required" value="<?php echo $netto_;?>" /></td>
</tr>
 <tr>
  <td class="atas">Satuan</td>
  <td class="atasnya"><input type="text" name="satuan_" id="satuan_" class="stext" rel="required" value="<?php echo $satuan_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Kemasan</td>
  <td class="atasnya"><input type="text" name="kemasan_" id="kemasan_" class="stext" rel="required" value="<?php echo $kemasan_;?>" /></td>
</tr>
<tr>
  <td class="atas">Harga</td>
  <td class="atasnya"><input type="text" name="harga_" id="harga_" class="sdate" rel="required" value="<?php echo $harga_;?>" /></td>
  <td>&nbsp;</td>
  <td class="atas">Waktu Expired</td>
  <td class="atasnya"><input type="text" name="waktuexpired_" id="waktuexpired_" class="sdate" rel="required" value="<?php echo $waktuexpired_;?>" /></td>
</tr>
</table>
</div>
<div><input type="submit" id="btncancel" class="cancelsampel" value="" url="<?php echo $urlback; ?>" />
<?php
if($this->uri->segment(4, "") == "edit" && $this->uri->segment(5, 0) > 0){
	?>
    <input type="submit" id="btnupdate" class="saveditsampel" value="" />  
    <?php
}else{
	?>
    <input type="submit" id="btnsave" class="savesampel" value="" />
    <?php
}
?>
</div>
</form>
</div>

<div id="juduldata" class="judul"></div>
<div class="content">
	<div class="data">
		&bull; Master Sampel - <a href="#"><?php echo $master_sampel; ?></a></div>
 </div>
<div id="clear_fix"></div>
