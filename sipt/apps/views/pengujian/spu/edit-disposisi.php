<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
$jml = count($kabid);
?>

<form name="fedit-mt" id="fedit-disposisi" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <table class="form_tabel">
    <tr>
      <td class="td_left"><b>Nomor Surat Permintaan Uji</b></td>
      <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Tanggal Surat Permintaan Uji</b></td>
      <td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Nomor Surat Perintah</b></td>
      <td class="td_right"><?php echo $sess['NOMOR_SP']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Tanggal Surat Perintah</b></td>
      <td class="td_right"><?php echo $sess['TANGGAL_PERINTAH']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Kode Sampel</b></td>
      <td class="td_right"><?php echo $sess['KODE']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Nama Sampel</b></td>
      <td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Komoditi</b></td>
      <td class="td_right"><?php echo $sess['KOMODITI']; ?></td>
    </tr>
    <tr>
      <td class="td_left"><b>Manajer Teknis</b></td>
      <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
    </tr>
    <tr id="row-mt" style="display:none;">
      <td class="td_left"><b>Manajer Teknis  Pengganti</b></td>
      <td class="td_right"><?php echo form_dropdown('USER_ID',$arrmt,'','class="stext" style="width:600px;" id="cbmt" title="Pilih Manager Teknis" rel="required"'); ?></td>
    </tr>
    <tr>
      <td colspan="2"><div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
          <p>Jika terjadi kesalahan dalam disposisi manajer teknis, admin balai bisa melakukan disposisi ulang atau mengupdate data manajer teknis penerima disposisi tanpa harus melakukan pembuatan surat penyerahan sampel. Dan semua transkasi data dalam perubahan disposisi ini akan tercatat dalam sistem</p>
          <hr />
          <p>
            <input type="checkbox" id="chk-edit-disposisi" />
            &nbsp;Setuju dengan pernyataan di atas?</p>
        </div></td>
    </tr>
  </table>
  <div style="height:10px;">&nbsp;</div>
  <?php
	if($jml > 0){
	?>
  <div style="padding-left:5px;"><a href="javascript:;" id="btn-editdisposisi" style="display:none;" class="button save" onclick="save_dispo('#fedit-disposisi'); return false;"><span><span class="icon"></span>&nbsp; Update &nbsp;</span></a></div>
  <?php
	}
	?>
  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" readonly="readonly"  />
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" readonly="readonly"  />
  <input type="hidden" name="USER_IDX" value="<?php echo $sess['USER_ID']; ?>" readonly="readonly"  />
</form>
<script type="text/javascript">
$(document).ready(function(e) {
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("#chk-edit-disposisi").change(function(e){
        if($(this).is(":checked")){
			jConfirm('Apakah anda yakin akan melakukan perubahan data yang dimaksud?', 'SIPT Versi 1.0', function(ojan){
				if(ojan==true){
					$("tr#row-mt").css("display","");
					$("#btn-editdisposisi").css("display","");
				}else{
					$("#chk-edit-disposisi").removeAttr("checked","");
					$("#cbmt").val('');
					return false;
				}
			});
		}else{
			$("#chk-edit-disposisi").removeAttr("checked","");
			$("tr#row-mt").css("display","none");
			$("#cbmt").val('');
			$("#btn-editdisposisi").css("display","none");
		}
    });
	
});
function save_dispo(formid){
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
		jConfirm('Apakah anda yakin dengan data yang Anda isikan ?', 'SIPT Versi 1.0', function(ojance){
			if(ojance==true){
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
			}else{
				return false;
			}
		});
	} 
	return false;
}
</script> 