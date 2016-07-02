<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<style>
	.editable{display:none;}
</style>
<form name="fheadersampel" id="fheadersampel" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="SAMPEL[KODE_SAMPEL]" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
  <table class="form_tabel">
    <tr>
      <td class="td_left bold">Kode Sampel</td>
      <td class="td_right"><?php echo $sess['KODE']; ?></td>
    </tr>
    <tr>
      <td class="td_left bold">Nama Sampel</td>
      <td class="td_right"><span class="view"><?php echo $sess['NAMA_SAMPEL']; ?></span><span class="editable"><input type="text" class="stext" title="Nama Sampel" value="<?php echo $sess['NAMA_SAMPEL']; ?>" name="SAMPEL[NAMA_SAMPEL]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Tempat Sampling</td>
      <td class="td_right"><div><span class="view"><?php echo $sess['TEMPAT_SAMPLING']; ?></span><span class="editable"><input type="text" class="stext" title="TEMPAT_SAMPLING" value="<?php echo $sess['TEMPAT_SAMPLING']; ?>" name="SAMPEL[TEMPAT_SAMPLING]" /></span></div>
        <div><span class="view"><?php echo $sess['ALAMAT_SAMPLING']; ?></span><span class="editable"><input type="text" class="stext" title="Alamat Sampling" value="<?php echo $sess['ALAMAT_SAMPLING']; ?>" name="SAMPEL[ALAMAT_SAMPLING]" /></span></div></td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Sampling</td>
      <td class="td_right">
	  <span class="view"><?php echo $sess['TANGGAL_SAMPLING']; ?></span><span class="editable"><input type="text" class="sdate" title="Tanggal Sampling" value="<?php echo $sess['TANGGAL_SAMPLING']; ?>" name="SAMPEL[TANGGAL_SAMPLING]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Nama Pabrik</td>
      <td class="td_right"><span class="view"><?php echo $sess['PABRIK']; ?></span><span class="editable"><input type="text" class="stext" title="Nama Pabrik" value="<?php echo $sess['PABRIK']; ?>" name="SAMPEL[PABRIK]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Nomor Registrasi</td>
      <td class="td_right"><span class="view"><?php echo $sess['NOMOR_REGISTRASI']; ?></span><span class="editable"><input type="text" class="stext" title="Nomor Registrasi" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" name="SAMPEL[NOMOR_REGISTRASI]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">No. Bets / Lot</td>
      <td class="td_right"><span class="view"><?php echo $sess['NO_BETS']; ?></span><span class="editable"><input type="text" class="sel_penyimpangan" title="No. Bets / Lot" value="<?php echo $sess['NO_BETS']; ?>" name="SAMPEL[NO_BETS]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Kadaluarsa</td>
      <td class="td_right"><span class="view"><?php echo $sess['KETERANGAN_ED']; ?></span><span class="editable"><input type="text" class="sdate" title="Keterangan Expire Date" value="<?php echo $sess['KETERANGAN_ED']; ?>" name="SAMPEL[KETERANGAN_ED]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Kemasan / Netto</td>
      <td class="td_right"><span class="view"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></span><span class="editable"><input type="text" class="stext" title="Kemasan" value="<?php echo $sess['KEMASAN']; ?>" name="SAMPEL[KEMASAN]" /><input type="text" class="sel_header" title="Netto" value="<?php echo $sess['NETTO']; ?>" name="SAMPEL[NETTO]" /></span></td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Mulai Pengujian</td>
      <td class="td_right">
      <?php $arrmin = explode("-",$tanggaluji[0]['MINTGL']); ?>
	  <span class="view"><?php echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0]; ?></span><span class="editable"><input type="text" class="sdate" title="Tanggal Mulai Uji" value="<?php  echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0]; ?>" /></span>
      </td>
    </tr>
    <tr>
      <td class="td_left bold">Tanggal Selesai Pengujian</td>
      <td class="td_right"><?php $arrmax = explode("-",$sess['AKHIR_UJI']);?>
      <span class="view"><?php echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0] ?></span><span class="editable"><input type="text" class="sdate" title="Tanggal Mulai Uji" value="<?php  echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0]; ?>" name="SAMPEL[AKHIR_UJI]" /></span>
      </td>
    </tr>
    <tr>
    	<td class="td_left bold" colspan="2"><div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;"><input type="checkbox" id="chk_edit" />&nbsp;<b>Edit Header Data Sampling</b></div></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save editable" onclick="save_edit('#fheadersampel'); return false;" id="btnupdate"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</form>
<script type="text/javascript">
$(document).ready(function(){
	$(".editable").hide();
	$(".sdate").datepicker();
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$("#chk_edit").change(function(e){
        if($(this).is(":checked")){
			$(".editable").show();
			$(".view").hide();
		}else{
			$(".editable").hide();
			$(".view").show();
		}
		return false;
    });

});

function save_edit(formid){
	var jumlah = 0; 
	$(':input[rel=required]:not(:image, submit, button)', formid).each(function(){
		if($(this).val() == "" || $(this).val() == null){ 
			$(this).css('background-color','#FBE3E4'); 
			$(this).css('border','1px solid #F00'); 
			jumlah++;
		}
	}); 
	if(jumlah>0){
		jAlert('Maaf, ada ' + jumlah + ' kolom yang harus diisi', 'SIPT Versi 1.0');
		return false;
	}else{
		$.ajax({
			type: "POST", 
			url: $(formid).attr('action') + '/ajax', 
			data: $(formid).serialize(),
			error: function(){ 
				jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
			}, 
			beforeSend: function(){
				jLoadingOpen('','SIPT Versi 1.0');
			}, 
			complete: function(){ 
				jLoadingClose();
			},
			success: function(data){
				if(data.search("MSG")>=0){
					arrdata = data.split('#');
					if(arrdata[1]=="YES"){
						jAlert(arrdata[2],'SIPT Versi 1.0');
						if(arrdata.length>3){
							setTimeout(function(){location.reload(true);}, 1000);
							return false;
						}
					}else{
						jAlert(arrdata[2],'SIPT Versi 1.0');
					}
				}else{
					jAlert(arrdata[2],'SIPT Versi 1.0');
				}
				return false;  
			} 
		}); 
	} 
	return false;
}
</script> 