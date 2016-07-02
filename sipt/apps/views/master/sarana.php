<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#prop_id").autocomplete($("#prop_id").attr('url'), {width: 244, selectFirst: false});
	$("#prop_id").result(function(event, data, formatted){
		if(data){
			$(this).val(data[2]);
			$("#propinsi").val(data[1]);
			$("#kota_id").attr("readonly", "");
			$("#kota_id").autocomplete($("#kota_id").attr('url') + $("#propinsi").val(), {width: 244, selectFirst: false});
			$("#kota_id").result(function(event, data, formatted){
				if(data){
					$("#kota_id").val(data[2]);
					$("#kota").val(data[1]);			  
				}
			});
		}
	});
	
	$("#nama_sarana").change(function(){
		var nama = ReplaceAll($(this).val()," ","_");
		var jns = $("#nm_jns").val();
		var kunci = nama + '-' +jns;
		if(nama.length > 3){
			$.get($(this).attr("url")+ kunci,function(hasil){
				if(hasil=="Tersedia"){
					$("#hs_sarana").hide();
					$("#tb_hasil").html('<div style=\"padding-top:5px; padding-bottom:5px; color:#3c7faf; margin-left:5px;\">Nama Sarana Tersedia</b></div>');
				}else{
					$("#hs_sarana").show();
					$("#tb_hasil").html(hasil);
					$("#nama_sarana").focus();
				}
			});
		}
	});
	
	<?php if($this->newsession->userdata('SESS_BBPOM_ID') != "00") { ?>
	$("#kota_id").autocomplete($("#kota_id").attr('url') + $("#propinsi").val(), {width: 244, selectFirst: false});
	$("#kota_id").result(function(event, data, formatted){
		if(data){
			$("#kota_id").val(data[2]);
			$("#kota").val(data[1]);			  
		}
	});
	<?php } ?>
	
});
function seljenis(jenis){
	if(jenis==""){
		return false;
	}else{
		if(jenis == "02BB"){
			$("#status_bb").css("display","");
			$("#sttsbb").attr("rel","required");
			$("#keterangan").html('');
		}else{
			if(jenis == "01JJ"){
				$("#keterangan").html('Format penulisan npwp tidak menggunakan .(titik) atau - (minus) . Contoh : 123456789012345');
			}else{
				$("#keterangan").html('');
			}
			$("#status_bb").css("display","none");
			$("#sttsbb").removeAttr("required");
		}
		$('#load_jenis').load($('#jenis').attr('url') + jenis);
	}
	return false;
}
</script> 
<div id="judulmsarana" class="judul"></div>
<div class="content">
<form action="<?php echo $act; ?>" method="post" autocomplete="off" id="m_sarana">
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><b>Data Umum Sarana</b></div>
        <div class="collapse">
                <div class="accCntnt">
                <table class="form_tabel">
                  <tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('SARANA[JENIS_SARANA]', $jenis, $sess['JENIS_SARANA'],'class="stext" id="jenis" rel="required" url="'.site_url().'/load/master/get_jenis_sarana/" title="Pilih Jenis Sarana" onchange="seljenis($(this).val());"', $disinput); ?></td></tr>
					<tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo form_dropdown('NAMA', $nama, str_replace(' ','',$sel_nama[1]), 'class="stext" title="Pilih salah satu" style="width:100px;" id="nm_jns"'); ?>&nbsp;<input name="NAMA_SARANA" type="text" class="stext" rel="required" title="Nama Sarana" value="<?php echo $sel_nama[0]; ?>" style="width:137px;" id="nama_sarana" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_sarana/" /></td></tr>
		<tr id="status_bb" <?php echo $sess['JENIS_SARANA'] == "02BB" ? '' : 'style="display:none;"';?>><td class="td_left">Status Sarana</td><td class="td_right"><?php echo form_dropdown('SARANA[SARANA_BB]',$sarana_bb,$sess['SARANA_BB'],'class="stext" title="Status Sarana (PT B2, DT B2, IT B2 dll)" id="sttsbb"'); ?></td></tr>
		<tr id="hs_sarana" style="display:none;"><td colspan="3"><div id="tb_hasil"></div></td></tr>
                    <tr><td class="td_left">NPWP</td><td class="td_right"><input name="SARANA[NPWP]" type="text" class="stext" title="NPWP maksimal panjang karakter 15 digit" value="<?php echo $sess['NPWP']; ?>" id="npwp_perusahaan" onkeyup="numericOnly($(this));" maxlength="15" rel="required" />&nbsp;<span id="keterangan"></span></td></tr>
                </table>
                <div id="load_jenis" style="margin-left:2px;"><?php echo $load_jenis; ?></div>
                </div>
		</div>
        <div style="padding:10px;"></div><div><a href="#" class="button save" onclick="fpost('#m_sarana','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $save; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a></div>

    </div>
</div>
<input type="hidden" name="ID" value="<?php echo $id; ?>" />
</form>
</div>




