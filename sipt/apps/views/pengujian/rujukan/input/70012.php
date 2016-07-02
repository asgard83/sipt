<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">
    <h2 class="small garis">Penyerahan Sampel Ke Bidang Pengujian</h2>
    <table class="listtemuan" width="100%">
      <thead>
        <tr>
          <th width="100px;">Kode Sampel <br> (Rujukan)</th>
          <th width="100px;">Kode Sampel <br> (Baru)</th>
          <th width="75px;">Bidang Uji</th>
          <th width="400px;">Parameter Uji</th>
          <th>Manajer Teknis</th>
        </tr>
      </thead>
      <?php
      $jml = count($data);
      if($jml > 0){
      for($i = 0; $i < $jml; $i++){
      ?>
      <tr>
        <td><?= $data[$i]['KODE_SAMPEL_ASAL']; ?></td>
        <td><?= $data[$i]['KODE_SAMPEL_BARU']; ?></td>
        <td><?= $data[$i]['BIDANG_UJI']; ?></td>
        <td><?= $data[$i]['PARAMETER_UJI']; ?></td>
        <td><?php echo form_dropdown('RUJUKAN[USER_ID][]',$mt,'','class="stext" style="width:400px;" title="Pilih salah satu manajer teknis" rel="required"'); ?><input type="hidden" name="RUJUKAN[UJI_ID][]" value="<?= $data[$i]['UJI_ID']; ?>"></td>
      </tr>
      <?php
      }
      }
      ?>
    </table>
    <input type="hidden" name="KODE_SAMPEL_BARU" value="<?= $newkode; ?>" readonly>
    <input type="hidden" id="jml_asal" value="<?= $jml_sampel; ?>" nam="SAMPEL[JUMLAH_SAMPEL]" readonly>
    <div style="height:10px;">&nbsp;</div>
  </td>
</tr>
<tr>
  <td class="td_left">Jumlah Sampel Dikirim Ke Kimia</td>
  <td class="td_right"><input type="checkbox" name="lab[]" class="chklab" id="kimia" onchange="check_uji('#kimia', '#jml_kimia');" value="K" />
  &nbsp;Kimia&nbsp;
  <input type="text" class="scode jml" title="Pengujian Kimia" id="jml_kimia" value="0" name="SAMPEL[JUMLAH_KIMIA]" readonly="readonly"  onkeyup="numericOnly($(this))"/></td>
</tr>
<tr>
  <td class="td_left">Jumlah Sampel Dikirim Ke Mikro</td>
  <td class="td_right"><input type="checkbox" class="chklab" name="lab[]" id="mikro" onchange="check_uji('#mikro', '#jml_mikro');" value="M" />
  &nbsp;Mikro&nbsp;
  <input type="text" class="scode jml" title="Pengujian Mikro" name="SAMPEL[JUMLAH_MIKRO]" readonly="readonly" id="jml_mikro" value="0" onkeyup="numericOnly($(this))" /></td>
</tr>
<tr>
  <td class="td_left">Sisa Sampel</td>
  <td class="td_right"><input type="text" class="scode" id="sisa" title="Sisa (retain) sampel " name="SAMPEL[SISA]" readonly value="0" onkeyup="numericOnly($(this))" /></td>
</tr>
<tr>
  <td colspan="2" style="height:5px;">&nbsp;</td>
</tr>
<tr>
  <td class="td_left">Tanggal Terima di TPS</td>
  <td class="td_right"><?= $row[0]['TGLTERIMA']; ?></td>
</tr>
<tr>
  <td class="td_left">Petugas Penerima</td>
  <td class="td_right"><?= $row[0]['PETUGAS_PENERIMA']; ?></td>
</tr>
<tr>
  <td class="td_left">Verifikator</td>
  <td class="td_right"><?= $row[0]['VERIFIKATOR']; ?></td>
</tr>
<tr>
  <td class="td_left">Tanggal Verifikasi</td>
  <td class="td_right"><?= $row[0]['TGLVERIFIKASI']; ?></td>
</tr>
<tr>
  <td class="td_left">Tanggal Surat Perintah</td>
  <td class="td_right"><input type="text" class="sdate" rel="required" name="TANGGAL_PERINTAH" title="Tanggal surat perintah" /></td>
</tr>
<script>
$(document).ready(function(){
  $("#btn-proses").hide();
  $('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', minDate: new Date()});
  $("#jml_kimia").change(function(){

    var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());

    if($("#jml_asal").val() == "" || parseFloat($("#jml_asal").val()) == 0) return false;

    sisa = parseFloat($("#jml_asal").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));    

    if(parseFloat($("#jml_kimia").val()) + sisa > parseFloat($("#jml_asal").val())){

      jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')

      $("#jml_kimia").focus();

    }

    if(jml > parseFloat($("#jml_asal").val())){

      jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')

      $("#jml_kimia").focus();

      $("#jml_kimia").val('0');

      sisa = parseFloat($("#jml_asal").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));

    }

    if(sisa < 0) sisa = 0;

    $("#sisa").val(parseFloat(sisa).toFixed(2));
    if(parseFloat($("#jml_kimia").val()) > 0)
    {
      $("#btn-proses").show();
    }else{
      $("#btn-proses").hide();
    }
  });

  $("#jml_mikro").change(function(){

    var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());

    if($("#jml_asal").val() == "" || parseFloat($("#jml_asal").val()) == 0) return false;

    sisa = parseFloat($("#jml_asal").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));

    if(parseFloat($("#jml_mikro").val()) + sisa > parseFloat($("#jml_asal").val())){

      jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')

      $("#jml_mikro").focus();

    }

    if(jml > parseFloat($("#jml_asal").val())){

      jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')

      $("#jml_mikro").focus();

      $("#jml_mikro").val('0');

      sisa = parseFloat($("#jml_asal").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));

    }

    if(sisa < 0) sisa = 0;

    $("#sisa").val(parseFloat(sisa).toFixed(2));

    if(parseFloat($("#jml_mikro").val()) > 0)
    {
      $("#btn-proses").show();
    }else{
      $("#btn-proses").hide();
    }
  }); 

});
function check_uji(obj, next){
  var jml = $("#jml_asal").val();
  if($(obj).is(':checked')){
    if(jml > 0){
      $(next).attr("readonly", "");
      $(next).focus();
    }
  }else{
    $(next).attr("readonly", "readonly");
    $(next).val('0');
    $("#btn-proses").hide();
  }
  sisa = parseInt($("#jml_asal").val()) - (parseInt($("#jml_kimia").val()) + parseInt($("#jml_mikro").val()));
  $("#sisa").val(parseInt(sisa));
}
</script>