<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana">Data Hasil Pengujian</div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA HASIL SAMPEL </a></div>
      <div class="accCntnt">
        <form name="feditparamtersampel" id="feditparamtersampel" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Kode Sampel</td>
              <td class="td_right"><?php echo $sess['KODE']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nama Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Pengirim Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tempat Sampling</td>
              <td class="td_right"><div><?php echo $sess['TEMPAT_SAMPLING']; ?></div>
                <div><?php echo $sess['ALAMAT_SAMPLING']; ?></div></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Sampling</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nomor Surat Permintaan Uji</td>
              <td class="td_right"><?php echo $sess['SPU']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Surat Permintaan Uji</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
            </tr>
          </table>
          <h2 class="small garis">&nbsp;</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Nama Pabrik</td>
              <td class="td_right"><?php echo $sess['PABRIK']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nomor Registrasi</td>
              <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">No. Bets / Lot</td>
              <td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Kadaluarsa</td>
              <td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Kemasan / Netto</td>
              <td class="td_right"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Jumlah</td>
              <td class="td_right"><?php
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_MIKRO'];
							}else{
								?>
                Jumlah Kimia : <?php echo $sess['JUMLAH_KIMIA']; ?> <?php echo $sess['SATUAN']; ?>, Jumlah Mikro : <?php echo $sess['JUMLAH_MIKRO']; 
							}
							?> <?php echo $sess['SATUAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Mulai Pengujian</td>
              <td class="td_right"><?php 
			  if(is_array($tanggaluji)){
			  $arrmin = explode("-",$tanggaluji[0]['MINTGL']);
			  echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0];
			  }else{
				  echo "Belum dilakukan pengujian";
			  }
			  ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Selesai Pengujian</td>
              <td class="td_right"><?php 
			  if(is_array($tanggaluji)){
			  $arrmax = explode("-",$tanggaluji[0]['MAXTGL']);
			  echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0];
			  }else{
				  echo "Belum dilakukan pengujian";
			  }
			  ?></td>
            </tr>
          </table>
          <h2 class="small garis">Hasil Pengujian</h2>
          <div style="height:5px;">&nbsp;</div>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Pemerian</td>
              <td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
            </tr>
          </table>
          <table class="tabelajax">
            <tr class="head">
              <th width="75">Jenis Uji</th>
              <th width="150">Uji yang dilakukan</th>
              <th width="150">Hasil</th>
              <th width="150">Syarat</th>
              <th width="150">Metode</th>
              <th width="150">Pustaka</th>
              <th width="50">LCP</th>
              <th width="100">Hasil Parameter</th>
            </tr>
            <?php
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								?>
            <tr id="<?php echo $parameter[$x]['UJI_ID']; ?>">
              <td><?php echo $parameter[$x]['JENIS_UJI']; ?></td>
              <td><?php echo $parameter[$x]['PARAMETER_UJI']; ?></td>
              <td><div><?php echo $parameter[$x]['HASIL']; ?></div>
                <div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
              <td><?php echo $parameter[$x]['SYARAT']; ?></td>
              <td><?php echo $parameter[$x]['METODE']; ?></td>
              <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
              <td><?php
			  if(strlen(trim($parameter[$x]['LCP'])) > 0){
				  ?>
                <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a><span class="editable" style="font-size:11px;"><br /><a href="javascript:;" class="hapus-lcp" spk="<?php echo $parameter[$x]['SPK_ID']; ?>" file="<?php echo $parameter[$x]['LCP']; ?>" url="<?php echo site_url(); ?>/get/pengujian/get_hapuslcp/">Hapus</a> atau <a href="javascript:;" class="reupload" kode="<?php echo $sess['KODE_SAMPEL']; ?>" uji="<?php echo $parameter[$x]['UJI_ID']; ?>" url="<?php echo site_url(); ?>/utility/uploads/set_relcp/<?php echo $sess['KODE_SAMPEL'];?>" spk="<?php echo $parameter[$x]['SPK_ID']; ?>">Reupload</a></span>
                <?php
			  }else{
				  ?>
                  <span class="view">Tidak Melampirkan LCP</span><span class="editable"><a href="javascript:;" class="reupload" kode="<?php echo $sess['KODE_SAMPEL']; ?>" uji="<?php echo $parameter[$x]['UJI_ID']; ?>" url="<?php echo site_url(); ?>/utility/uploads/set_relcp/<?php echo $sess['KODE_SAMPEL'];?>" spk="<?php echo $parameter[$x]['SPK_ID']; ?>">Reupload</a></span>
                  <?php
			  }
			  ?></td>
              <td><span class="view"><?php echo $parameter[$x]['HASIL_PARAMETER']; ?></span><span class="editable"><?php echo form_dropdown('PARAMETER[HASIL_PARAMETER][]', $hasil_param, $parameter[$x]['HASIL_PARAMETER'], 'class="stext" style="width:75px;" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?>&nbsp;<a href="javascript:void(0);" class="delparam" kode="<?php echo $sess['KODE_SAMPEL']; ?>" uji="<?php echo $parameter[$x]['UJI_ID']; ?>" url="<?php echo site_url(); ?>/get/pengujian/set_params/" spk="<?php echo $parameter[$x]['SPK_ID']; ?>"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data Parameter Uji" /></a><input type="hidden" name="PARAMETER[UJI_ID][]" value="<?php echo $parameter[$x]['UJI_ID']; ?>" /><input type="hidden" name="PARAMETER[SPK_ID][]" value="<?php echo $parameter[$x]['SPK_ID']; ?>" /></span></td>
            </tr>
            <?php
							}
						}
					?>
          </table>
          <h2 class="small garis">&nbsp;</h2>
          <table class="form_tabel">
            <?php
					if($sess['UJI_KIMIA'] == 1){
					?>
            <tr>
              <td class="td_left bold">Hasil Uji Kimia</td>
              <td class="td_right"><span class="view"><?php echo $sess['HASIL_KIMIA']; ?></span><span class="editable"><?php echo form_dropdown('SAMPEL[HASIL_KIMIA]', $hasil_sampel, $sess['HASIL_KIMIA'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?></span></td>
            </tr>
            <?php
					}
					?>
            <?php
					if($sess['UJI_MIKRO'] == 1){
					?>
            <tr>
              <td class="td_left bold">Hasil Uji Mikro</td>
              <td class="td_right"><span class="view"><?php echo $sess['HASIL_MIKRO']; ?></span><span class="editable"><?php echo form_dropdown('SAMPEL[HASIL_MIKRO]', $hasil_sampel, $sess['HASIL_MIKRO'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?></span></td>
            </tr>
            <?php
					}
					?>
            <tr>
              <td class="td_left bold">Hasil Sampel</td>
              <td class="td_right"><span class="view"><?php echo $sess['HASIL_SAMPEL']; ?></span><span class="editable"><?php echo form_dropdown('SAMPEL[HASIL_SAMPEL]', $hasil_sampel, $sess['HASIL_SAMPEL'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?></span></td>
            </tr>
            <tr>
              <td class="td_left bold">Hasil PPOMN</td>
              <td class="td_right"><?php echo $sess['HASIL_PPOMN']; ?></td>
            </tr>
            <?php
			if(strlen($sess['HASIL_SAMPEL']) > 0){
				?>
            <tr>
              <td class="td_left bold" colspan="2"><div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;"><input type="checkbox" id="chk_edit" />&nbsp;<b>Edit Data Hasil Pengujian</b></div></td>
            </tr>
                <?php
			}
			?>
          </table>
          <input type="hidden" name="KODE_SAMPEL" id="kode_sampel" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
        </form>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;">
    <a href="#" class="button save editable" id="button-proses" onclick="fpost('#feditparamtersampel','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan Perubahan &nbsp;</span></a>
      <?php
	  if(strlen($sess['HASIL_SAMPEL']) > 0){
	  ?>	
      <a href="#" class="button download" id="download-cp-lcp-lhu" url="<?php echo site_url(); ?>/topdf/sampel/rilis/cp-lcp-lhu/<?php echo $sess['KODE_SAMPEL']; ?>" onclick="blank_($(this)); return false;"><span><span class="icon"></span>&nbsp; Download LCP & LHU&nbsp;</span></a>&nbsp;
      <?php
	  }
      ?>
      <a href="javascript:;" onclick="javascript:history.back();" class="button reload"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </div>
</div>
<script>
$(document).ready(function(e){
	$("#cnt-reupload-lcp").css("display","none");
	$(".editable").css("display","none");
	$(".hapus-lcp").click(function(){
		var row = $(this).closest("tr").attr("id");
		var url = $(this).attr("url");
		var spk = $(this).attr("spk");
		var file = $(this).attr("file");
		jConfirm('Anda akan menghapus Lampiran CP / LCP terpilih? \n Harap diperhatikan, bahwa data yang telah dihapus tidak bisa dikembalkan lagi.', 'SIPT Versi 1.0', function(ojanx){
			if(ojanx == true){
				$.get(url + spk + '/' + row + '/' + $("#kode_sampel").val() + '/' + file, function(hasil){
					if(hasil){
						var arrdata = hasil.split("#");
						if(arrdata[1] == "YES"){
							$("tr#"+row+" td:nth-child(7)").html('<span class="view" style="display:none;">Tidak Melampirkan LCP</span><span class="editable"><a href="javascript:;" class="reupload">Reupload</a></span>');
						}else if(arrdata[1] == "NO"){
							jAlert(arrdata[2],'SIPT Versi 1.0');
							return false;
						}
					}
				});
			}else{
				return false;
			}
		});
    });
	$(".delparam").click(function(e) {
		var row = $(this).closest("tr").attr("id");
		var url = $(this).attr("url");
		var spk = $(this).attr("spk");
		var uji = $(this).attr("uji");
		jConfirm('Anda akan menghapus parameter uji terpilih? \n Harap diperhatikan, bahwa data yang telah dihapus tidak bisa dikembalkan lagi.', 'SIPT Versi 1.0', function(ojanx){
			if(ojanx == true){
				$.get(url + spk + '/' + uji + '/' + $("#kode_sampel").val(), function(hasil){
					if(hasil){
						var arrdata = hasil.split("#");
						if(arrdata[1] == "YES"){
							$("tr#"+row).remove();
						}else if(arrdata[1] == "NO"){
							jAlert(arrdata[2],'SIPT Versi 1.0');
							return false;
						}
					}
				});
			}else{
				return false;
			}
		});
    });
	$(".reupload").click(function(){
		var uji = $(this).attr("uji");
		var row = $(this).closest("tr").attr("id");
		var url = $(this).attr("url");
		var uji = $(this).attr("uji");
		var spk = $(this).attr("spk");
		var html  = '<div id="cnt-reupload-lcp" style="padding-bottom:10px;"><table class="form_tabel"><tr><td class="td_left">File Lampiran</td><td class="td_right"><input type="file" class="stext upload" allowed="xls-doc-xlsx-docx-pdf-rar-zip" ke = "'+row+'" url="'+url+'" id="fileToUpload_LCP'+uji+'" uji="'+uji+'" spk = "'+spk+'" title="File Lampiran Catatan Pengujian" name="userfile" onchange="set_lcp($(this)); return false;"/>&nbsp;<br>Tipe File : *.xls, *.xlsx, *.doc, *.docx, *.rar, *.zip, *.pdf</td></tr></table></div>';
		$(html).dialog({
			title: 'Upload ulang file LCP',
			width: 700,
			resizable: false,
			modal: true
		});
	});
    $("#chk_edit").change(function(e){
        if($(this).is(":checked")){
			$(".editable").css("display","");
			$(".view").css("display","none");
		}else{
			$(".editable").css("display","none");
			$(".view").css("display","");
		}
		return false;
    });
});
function set_lcp(element){
	var baris = $(element).attr("ke");
	$.ajaxFileUpload({
		url: $(element).attr("url")+'/'+$(element).attr("uji")+'/'+$(element).attr("spk")+'/'+$(element).attr("allowed"),
		secureuri: false,
		fileElementId: $(element).attr("id"),
		dataType: "json",
		success: function(data){
			var arrdata = data.msg.split("#");
			if(typeof(data.error) != "undefined"){
				if(data.error != ""){
					jAlert(data.error, "SIPT Versi 1.0 ");
				}else{
					$("tr#"+baris+" td:nth-child(7)").html("<a href=\"<?php echo base_url(); ?>files/LCP/"+arrdata[2]+"/"+arrdata[0]+"\" target=\"_blank\">LCP</a><span class=\"editable\" style=\"font-size:11px;\"><br /><a href=\"javascript:;\" class=\"hapus-lcp\" spk="+$(element).attr("spk")+" file="+arrdata[0]+" url=\"<?php echo site_url(); ?>/get/pengujian/get_hapuslcp/\">Hapus</a> atau <a href=\"javascript:;\" class=\"reupload\" kode=\""+arrdata[2]+"\" uji="+$(element).attr("uji")+" url=\"<?php echo site_url(); ?>/utility/uploads/set_relcp/"+arrdata[2]+"\">Reupload</a></span>");
					$("#cnt-reupload-lcp").dialog("close");
					return false;
				}
			}
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0 Beta");
		}
	});
	$(".hapus-lcp").click(function(){
		var row = $(this).closest("tr").attr("id");
		var url = $(this).attr("url");
		var spk = $(this).attr("spk");
		var file = $(this).attr("file");
		jConfirm('Anda akan menghapus Lampiran CP / LCP terpilih? \n Harap diperhatikan, bahwa data yang telah dihapus tidak bisa dikembalkan lagi.', 'SIPT Versi 1.0', function(ojanx){
			if(ojanx == true){
				$.get(url + spk + '/' + row + '/' + $("#kode_sampel").val() + '/' + file, function(hasil){
					if(hasil){
						var arrdata = hasil.split("#");
						if(arrdata[1] == "YES"){
							$("tr#"+row+" td:nth-child(7)").html('<span class="view" style="display:none;">Tidak Melampirkan LCP</span><span class="editable"><a href="javascript:;" class="reupload">Reupload</a></span>');
						}else if(arrdata[1] == "NO"){
							jAlert(arrdata[2],'SIPT Versi 1.0');
							return false;
						}
					}
				});
			}else{
				return false;
			}
		});
    });
	$(".reupload").click(function(){
		var uji = $(this).attr("uji");
		var row = $(this).closest("tr").attr("id");
		var url = $(this).attr("url");
		var html  = $("#cnt-reupload-lcp").html();
		$(html).dialog({
			title: 'Upload ulang file LCP',
			width: 700,
			resizable: false,
			modal: true
		});
	});

}
function blank_(obj){
	var url = $(obj).attr("url");
	window.open(url, '_blank');
	return false;
}

</script>