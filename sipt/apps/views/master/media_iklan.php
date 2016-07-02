<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
 function clearForm() {
  $("#namaMediaIklan").val("");
//  $("#provkotAlamat").val("");
//  $("#kabkotAlamat").val("");
 }
 $(document).ready(function() {
//  $("#provkotAlamat").change(function() {
//   var kunci = $(this).val();
//   if (kunci !== "")
//    $('#kabkotAlamat').attr("rel", "required");
//   else
//    $('#kabkotAlamat').attr("rel", "");
//   $.get('<?php echo site_url(); ?>/get/iklan_penandaan/set_provinsi/' + kunci, function(hasil) {
//    hasil = hasil.replace(' ', '');
//    if (hasil != "") {
//     $('#kabkotAlamat').html(hasil);
//    }
//   });
//  });
  $("#namaMediaIklan").keyup(function() {
   var jns = $("#jenis").val();
   if (jns == "") {
    jAlert("Silahkan isi jenis media terlebih dahulu", "SIPT Versi 1.0");
    $("#namaMediaIklan").val("");
   }
   var nama = ReplaceAll($(this).val(), " ", "");
   $.get($(this).attr("url") + jns + "/" + nama, function(hasil) {
    var result = $.trim(hasil);
    if (result === "<?php echo "Y"; ?>") {
     jAlert("Silahkan input nama media yang berbeda ", "SIPT Versi 1.0");
     $("#namaMediaIklan").val("");
    }
   });
  });
 });
</script>
<div id="" class="judul"></div>
<div class="content">
 <form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_media">
  <div class="adCntnr">
   <div class="acco2">

    <div class="expand"><b>Data Media Iklan</b></div>
    <div class="collapse">
     <div class="accCntnt">
      <table class="form_tabel">
       <tr><td class="td_left">Jenis Media</td><td class="td_right"><?php echo form_dropdown('MEDIA[JENIS_MEDIA]', $jenis, $sess['JENIS_MEDIA'], 'class="sjenis" id="jenis" rel="required" title="Jenis Media" onchange=clearForm();', ''); ?></td></tr>
       <tr><td class="td_left">Nama Media</td><td class="td_right"><input name="MEDIA[NAMA_MEDIA]" type="text" class="sjenis" rel="required" title="Nama Media" value="<?php echo $sel_nama[0]; ?>" style="width:137px;" id="namaMediaIklan" url="<?php echo site_url(); ?>/autocompletes/autocomplete/nama_media/" /></td></tr>
       <?php if (in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) || $this->newsession->userdata("SESS_BBPOM_ID") == "50") { ?>
        <!--<tr><td class="td_left">Provinsi</td><td class="td_right"><?php echo form_dropdown('MEDIA[PROPINSI]', $provinsi, $provinsiVal, 'style="width:153px" id="provkotAlamat" class="stext" title="Nama Provinsi Pengambilan Iklan" rel="required"'); ?></td></tr>-->
        <!--<tr><td class="td_left">Kota</td><td class="td_right"><?php echo form_dropdown('MEDIA[KOTA]', $kabupaten, $kabupatenVal, 'style="width:153px" id="kabkotAlamat" class="stext" title="Nama Kota Pengambilan Iklan" rel ="required"'); ?></td></tr>-->
       <?php } ?>
      </table>
     </div>
    </div>
    <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_media', '', '');
  return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this));
  return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

   </div>
  </div>
  <input type="hidden" name="ID" value="<?php echo $id; ?>" />
 </form>
</div>




