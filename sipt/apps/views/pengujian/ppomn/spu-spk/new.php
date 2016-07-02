<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fkonsepspk" id="fkonsepspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <input type="hidden" name="KODE_SAMPEL" value="<?php echo $arrid; ?>" />
    <input type="hidden" name="ANGGARAN" value="<?php echo $row[0]['ANGGARAN']; ?>" />
    <input type="hidden" name="ASAL_SAMPEL" value="<?php echo $row[0]['ASAL_SAMPEL']; ?>" />
    <input type="hidden" name="KOMODITI" value="<?php echo $row[0]['KOMODITI']; ?>" />
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">Konsep SPU</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Draft Konsep SPU Baru</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Surat</td>
                <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Permintaan Uji" name="SPU[TANGGAL]" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php echo $row[0]['UR_KOMODITI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Asal Sampel</td>
                <td class="td_right"><?php echo $row[0]['UR_ASAL_SAMPEL']; ?></td>
              </tr>
            </table>
            <?php /*?><h2 class="small garis">Bidang Pengujian</h2>
            <table class="form_tabel" id="tbbidang">
              <tr id="0">
                <td class="td_left">Bidang Tujuan</td>
                <td class="td_right"><div>
                    <div class="bidang-uji" style="padding-bottom:5px;"> <?php echo form_dropdown('BIDANG', $bidang, '', 'class="stext bidang" rel="required" title="Pilih salah satu Bidang Pengujian"'); ?>&nbsp;
                      <input type="text" class="stext kabid" title="Kepala Bidang Pengujian" id="ackabid0" rel="required" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_penyelia/4/" />
                      <input type="hidden" name="USER_ID[]" id="kabid0" />
                      &nbsp;<a href="#" class="addbidang"><img src="<?php echo base_url(); ?>images/add.png" title="Klik disini jika sampel akan dikirim lebih dari satu bidang" style="border:none" /></a></div>
                  </div></td>
              </tr>
            </table><?php */?>
            <h2 class="small garis">Data Sampel</h2>
            <table class="tabelajax">
              <tr class="head">
                <th width="31%" rowspan="2">Sampel</th>
                <th width="8%" rowspan="2">Komoditi</th>
                <th colspan="4">Jumlah &amp; Satuan </th>
                <th width="10%" rowspan="2">Jenis Uji </th>
              </tr>
              <tr class="head">
                <th width="5%">Jumlah</th>
                <th width="3%">K</th>
                <th width="3%">M</th>
                <th width="6%">Satuan</th>
              </tr>
              <?php
			  $jml = count($row);
			  if($jml > 0){
				  for($i=0; $i<$jml; $i++){
				  ?>
              <tr>
                <td><div>
                    <?= $row[$i]['NAMA_SAMPEL']; ?>
                  </div>
                  <div>
                    <?= $row[$i]['KODE SAMPEL'];?>
                  </div></td>
                <td><?= $row[$i]['UR_KOMODITI']; ?></td>
                <td><?= $row[$i]['JUMLAH_SAMPEL']; ?></td>
                <td><?= $row[$i]['JUMLAH_KIMIA']; ?></td>
                <td><?= $row[$i]['JUMLAH_MIKRO']; ?></td>
                <td><?= $row[$i]['SATUAN']; ?></td>
                <td><?= $row[$i]['JENIS UJI']; ?></td>
              </tr>
              <?php
				  }
			  }else{
			  ?>
              <tr>
                <td colspan="7">Data Tidak Ditemukan. Silahkan periksa kembali data daftar sampel</td>
              </tr>
              <?php
			  }
			  ?>
            </table>
            <div style="height:10px;">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="create_spu('#fkonsepspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="javascript:void(0);" class="button reload" onclick="close_popup();"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$('input, select, textarea').focus(function(){
		$(this).css('background-color','#FFF');
		$(this).css('border','1px solid #dddddd');
	});
	$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
	$("table.form_tabel tr:odd").css("background-color", "#fff");
	$('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
	
	$(".bidang").change(function(){
		var val = $(this).val();
		if(val==""){
			return false;
		}else{
			var ke = $(this).closest("tr").attr("id");
			$("#ackabid"+ke+"").val('');
			$("#kabid"+ke+"").val('');
			$("input.kabid").autocomplete($("#ackabid"+ke+"").attr("url") + val , {width: 244, selectFirst: false});
			$("input.kabid").result(function(event, data, formatted){
				if(data){
					var ke = $(this).closest("tr").attr("id");
					$(this).val(data[2]);
					$("#kabid"+ke+"").val(data[1]);
					$(this).focus();
				}
			});
		}
		return false;
	});
	$(".addbidang").live("click", function(){
		var leng = $("#tbbidang tr").length;
		var str = '<tr id="'+(leng+1)+'"><td class="td_left">&nbsp;</td><td class="td_right"><div><div class="bidang-uji" style="padding-bottom:5px;"> <?php echo str_replace(chr(10), '', form_dropdown('BIDANG', $bidang, '', 'class="stext bidang" rel="required" title="Pilih salah satu Bidang Pengujian"')); ?>&nbsp;&nbsp;<input type="text" class="stext kabid" title="Kepala Bidang Pengujian" id="ackabid'+(leng+1)+'" rel="required" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_penyelia/4/" /><input type="hidden" name="USER_ID[]" id="kabid'+(leng+1)+'" />&nbsp;&nbsp;<a href="#" class="delbidang"><img src="<?php echo base_url(); ?>images/cancel.png" title="Klik disini untuk membatalkan tujuan bidang pengujian" style="border:none" /></a></div></div></td></tr>';
		$("#tbbidang").append(str);
		$(".bidang").change(function(){
			var val = $(this).val();
			if(val==""){
				return false;
			}else{
				$("#ackabid"+(leng+1)+"").val('');
				$("#kabid"+(leng+1)+"").val('');
				$("input.kabid").autocomplete($("#ackabid"+(leng+1)+"").attr("url") + val , {width: 244, selectFirst: false});
				$("input.kabid").result(function(event, data, formatted){
					if(data){
						$(this).val(data[2]);
						$("#kabid"+(leng+1)+"").val(data[1]);
						$(this).focus();
					}
				});
			}
		});
		return false
	});
	$(".delbidang").live("click", function(){
		var id = $(this).closest("tr").attr("id");
		$("#"+id).remove();
		return false;
	});
});
function create_spu(formid){
	var jumlah = 0; 
	$(':input[rel=required]:not(:image, submit, button)', formid).each(function(){
		if($(this).val() == "" || $(this).val() == null){ 
			$(this).css('background-color','#FBE3E4'); 
			$(this).css('border','1px solid #F00'); 
			jumlah++;
		}
	}); 
	if(jumlah>0){
		jAlert('Maaf, ada '+jumlah+' kolom yang harus diisi', 'SIPT Versi 1.0'); 
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
					}else{
						jAlert(arrdata[2],'SIPT Versi 1.0');
					}
					$.alerts._hidePopup();
					if(arrdata.length>3){
						setTimeout(function(){location.href = arrdata[3];}, 2000);
						return false;
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