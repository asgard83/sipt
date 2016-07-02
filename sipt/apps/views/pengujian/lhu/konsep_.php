<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);
$act = FALSE;
if($sess['UJI_KIMIA'] == 1 && $sess['UJI_MIKRO'] == 1){
	if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
		$act = TRUE;
	}
}else if($sess['UJI_KIMIA'] == 1 && $sess['UJI_MIKRO'] == 0){
	if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
		$act = TRUE;
	}
}else if($sess['UJI_KIMIA'] == 0 && $sess['UJI_MIKRO'] == 1){
	if($this->newsession->userdata('SESS_TIPE_BBPOM') == 'A'){
		if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
			$act = TRUE;
		}
	}else{
		if(in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
			$act = TRUE;
		}
	}
}
?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAPORAN HASIL UJI</a></div>
      <div class="accCntnt">
        <form name="fkonsep" id="fkonsep" method="post" action="<?php echo $action; ?>" autocomplete="off">
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
              <td class="td_left bold">Jumlah Sampel</td>
              <td class="td_right">@
                <?php
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_MIKRO'];
							}
							?>
                <?php echo $sess['SATUAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Mulai Pengujian</td>
              <td class="td_right"><?php 
			  $arrmin = explode("-",$tanggaluji[0]['MINTGL']); 
			  echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0];
			  ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Selesai Pengujian</td>
              <td class="td_right"><?php 
			  $arrmax = explode("-",$tanggaluji[0]['MAXTGL']); 
			  echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0];
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
          <table id="list-sampel" width="100%">
            <thead>
				<tr>
				  <?php
				  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $act && $stts == "40204" && strlen($sess['KODE_RUJUKAN']) == 0){
				  ?>
                  <th width="14">&nbsp;</th> <!--<input type="checkbox" title="Pilih semua data" id="chk_sampel_all" />-->
                  <?php
				  }
				  ?>
              <th>Jenis Uji</th>
              <th>Uji yang dilakukan</th>
              <th>Hasil</th>
              <th>Syarat</th>
              <th>Metode</th>
              <th>Pustaka</th>
              <th>Hasil Parameter</th>
              <th>LCP</th>
				  <th>Mampu Uji</th>
            </tr>
			</thead>
			<tbody>
            <?php
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								?>
            <tr id="<?php echo $parameter[$x]['UJI_ID']; ?>">
              <?php
			  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $act && $stts == "40204" && strlen($sess['KODE_RUJUKAN']) == 0){
			  ?>
              <td><input type="checkbox" class="chk_rujukan"  name="chk_uji[]" value="<?php echo $parameter[$x]['UJI_ID']; ?>" /></td>
              <?php
			  }
			  ?>
              <td><?php echo $parameter[$x]['JENIS_UJI']; ?></td>
              <td><?php
			  if(($stts == "30203" || $stts == "40204") && in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
				  if($parameter[$x]['UJI_MAMPU'] == "Ya"){
			  ?>
                <a href="javascript:;" class="koreksi-konsep" url="<?php echo site_url(); ?>/get/pengujian/get_koreksi_params" id="<?php echo $parameter[$x]["UJI_ID"]; ?>"><?php echo $parameter[$x]['PARAMETER_UJI']; ?></a>
                <?php
			  }else{
				  echo $parameter[$x]['PARAMETER_UJI'];
				  }
			  }else{
				  echo $parameter[$x]['PARAMETER_UJI'];
				  
			  }
			  ?></td>
              <td><div><?php echo $parameter[$x]['HASIL']; ?></div>
                <div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
              <td><?php echo $parameter[$x]['SYARAT']; ?></td>
              <td><?php echo $parameter[$x]['METODE']; ?></td>
              <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
              <td><?php echo $parameter[$x]['HASIL_PARAMETER']; ?></td>
              <td><?php
								if(strlen(trim($parameter[$x]['LCP'])) > 0){
									?>
                <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a>
                <?php
								}else{
									?>
                Tidak melampirkan LCP
                <?php
								}
								?></td>
			  
			  <td><?php echo $parameter[$x]['UJI_MAMPU']; ?></td>
            </tr>
            <?php
							}
						}
					?>
			</tbody>		
          </table>
          <?php
		  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
		  ?>
          <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
            <p><b>Keterangan :</b></p>
            <p>- Untuk melakukan koreksi hasil pengujian, silahkan klik pada masing-masing nama parameter uji</p>
            <p>- Untuk menentukan parameter uji yang akan dirujuk, klik pada checkbox masing-masing parameter uji</p>
          </div>
          <?php
		  }
		  ?>
          <div style="height:5px;">&nbsp;</div>
          <table class="form_tabel">
            <?php
			if($stts == "30203"){
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Kimia Fisika
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Kimia</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_KIMIA]',$hasil,$sess['HASIL_KIMIA'],'class="stext" title="Kesimpulan sampel kimia" id="hasil" rel="required"'); ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Mikro</td>
              <td class="td_right"><?php echo $sess['HASIL_MIKRO']; ?></td>
            </tr>
            <?php
				}
				
				if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){#Bidang Mikrobiologi
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Kimia</td>
              <td class="td_right"><?php echo $sess['HASIL_KIMIA']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Mikro</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_MIKRO]',$hasil,$sess['HASIL_MIKRO'],'class="stext" title="Kesimpulan sampel mikro" id="hasil" rel="required"'); ?></td>
            </tr>
            <?php
				}
				
			}else{
				if((in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))) & (in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))){#Bidang Kimia Fisika
					if($sess['UJI_KIMIA'] == 1 && $sess['UJI_MIKRO'] == 0){
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Kimia</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_KIMIA]',$hasil,$sess['HASIL_KIMIA'],'class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
            </tr>
            <?php
					}else if($sess['UJI_KIMIA'] == 1 && $sess['UJI_MIKRO'] == 1){
						?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Kimia</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_KIMIA]',$hasil,$sess['HASIL_KIMIA'],'class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Mikro</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_MIKRO]',$hasil,$sess['HASIL_MIKRO'],'class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
            </tr>
            <?php
					}else if($sess['UJI_MIKRO'] == 1 && $sess['UJI_KIMIA'] == 0 ){
						?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Mikro</td>
              <td class="td_right"><?php echo form_dropdown('SAMPEL[HASIL_MIKRO]',$hasil,$sess['HASIL_MIKRO'],'class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
            </tr>
            <?php
					}
				}else{
					
					if($sess['UJI_KIMIA'] == 1){
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Kimia</td>
              <td class="td_right"><?php echo $sess['HASIL_KIMIA']; ?></td>
            </tr>
            <?php
					}
					
					if($sess['UJI_MIKRO'] == 1){
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Mikro</td>
              <td class="td_right"><?php echo $sess['HASIL_MIKRO']; ?></td>
            </tr>
            <?php
					}
					
					if(trim($sess['HASIL_SAMPEL']) != ""){
								?>
            <tr>
              <td class="td_left bold">Kesimpulan Uji Sampel</td>
              <td class="td_right"><?php echo $sess['HASIL_SAMPEL']; ?></td>
            </tr>
            <?php
					}
					
				}
					
			}
			?>
            <tr>
              <td class="td_left bold">&nbsp;</td>
              <td class="td_right"><?php //echo $rowcp[0]['CATATAN']; ?></td>
            </tr>
          </table>
          <table class="form_tabel">
            <?php
					if($act && ($stts == "30203" || $stts == "40204")){
					?>
            <tr>
              <td class="td_left bold">Kesimpulan Akhir Sampel</td>
              <td class="td_right"><?php echo form_dropdown('HASIL_SAMPEL',$hasil,$sess['HASIL_SAMPEL'],'class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
            </tr>
            <?php
					}
					?>
			<tr>
              <td class="td_left bold">Jumlah Sampel</td>
              <td class="td_right"><input type="text" name="JUMLAH_SAMPEL" value="<?= $sess['SISA']+$sess['SISA_MIKRO']+$sess['SISA_KIMIA']; ?>"></td>
            </tr>
			<?php
			if($stts == "40204" && strlen($sess['KODE_RUJUKAN']) == 0){
		    ?>
			<tr>
			  <td class="td_left bold" colspan="2">
					 <div style="height:5px;">&nbsp;</div>
					  <h2 class="small garis">Parameter Uji Yang Akan Dirujuk</h2>
					  <table class="listtemuan" width="100%">
						<thead>
              <tr id="jmlnya" style="display:none">                
                <th colspan='4'>Jumlah sampel : <strong style="color:red"><?= $sess['JUMLAH_SAMPEL']; ?></strong><br>
                  Sisa Kimia : <strong style="color:orange"><?= $sess['SISA_KIMIA']; ?></strong><br>
                  Sisa Mikro : <strong style="color:orange"><?= $sess['SISA_MIKRO']; ?></strong><br>
                  Total Sisa Sampel : <strong style="color:green"><?= $sess['SISA']+$sess['SISA_MIKRO']+$sess['SISA_KIMIA']; ?></strong><br>
                </th>
              </tr>
						  <tr>
							<th width="60">Jenis Uji</th>
							<th width="180">Uji Yang Dilakukan</th>							
						    <th width="65">Lingkup Pengujian</th>
							<th width="65">BBPOM/BPOM Tujuan</th>
						  </tr>
						</thead>
						<tbody id="draft-rujukan">
						</tbody>
					  </table>
					  <div style="height:10px;"></div>
			  </td>
			</tr>
            <?php
			}
			?>
            <tr class="rujukan" style="display:none">
              <td class="td_left bold">Catatan</td>
              <td class="td_right"><textarea class="stext catatan" id="catatan_rujukan" name="CATATAN" title="Catatan"></textarea></td>
            </tr>
          </table>
          
          <?php
		  if(strlen(trim($sess['KODE_RUJUKAN'])) > 1){
			  ?>
              <input type="hidden" name="KODE_RUJUKAN" value="<?= $sess['KODE_RUJUKAN']; ?>" >
              <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
              <p>Sampel ini merupakan sampel rujukan untuk sampel <b> <?= $sess['UR_KODE_RUJUKAN']; ?></b></p>
              </div>
              <?php
			  $jml = count($capafile);
			  if($jml > 0){
				  ?>
                  <table class="form_tabel">
                  <?php
				  $noindex = 1;
				  for($no=0;$no<$jml;$no++){
					  ?>
                      <tr>
                        <td class="td_left bold">Lampiran CAPA <?= $noindex; ?></td>
                        <td class="td_right"><a href="<?= base_url().'files/CAPA/'.$capafile[$no]['KODE_SAMPEL'].'/'.$capafile[$no]['CAPA_FILE']; ?>" target="_blank">Download Lampiran</a></td>
                      <tr>
                      <?php
					  $noindex++;
				  }
				  ?>
          </table>
          <?php
					}
			  
		  }
					?>
          
          <div style="height:5px;">&nbsp;</div>
          <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_cp/<?php echo $cp_id; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Catatan Pengujian (
            <?= $jml_log; ?>
            )</a></h2>
          <div id="detail_log"></div>
          <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
          <input type="hidden" name="CP_ID" value="<?php echo $cp_id; ?>" />
        </form>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;">
      <?php
		if($act && $stts == "30203"){
		?>
      <a href="#" class="button check" onclick="fpost('#fkonsep','',''); return false;"><span><span class="icon"></span>&nbsp; Proses Konsep Pelaporan&nbsp;</span></a>&nbsp;
      <?php
		}else if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')) && $act && $stts == "40204"){ 
		?>
      <a href="#" class="button download" onclick="fpost('#fkonsep','',''); return false;"><span><span class="icon"></span>&nbsp; Kirim Ke Kepala Balai &nbsp;</span></a>
      <?php
		}else{
			?>
      <a href="#" class="button download" id="clhu" url="<?php echo site_url(); ?>/topdf/lhu/prints/<?php echo $cp_id; ?>.<?php echo $sess['KODE_SAMPEL']; ?>.<?php echo $stts; ?>" onclick="blank_($(this)); return false;"><span><span class="icon"></span>&nbsp; Cetak LHU &nbsp;</span></a>
      <?php
		}
		?>
      &nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </div>
</div>
<div id="ctn-koreksi-params"></div>
<script>
$(document).ready(function(){
	$(".koreksi-konsep").live("click", function(){
		$.get($(this).attr("url") + "/" + $(this).attr("id"), function(data){
			$("#ctn-koreksi-params").html(data); 
			$("#ctn-koreksi-params").dialog({ 
				title: 'Koreksi hasil data parameter uji', 
				width: 800, 
				resizable: false, 
				modal: true
			}); 
		});
	});
	$(".chk_rujukan").change(function(){		
		var chk = $("#list-sampel .chk_rujukan:checked").length;
		var clone = '';				
		if(chk == 0){
      $("#jmlnya").hide();
			$("#draft-rujukan").empty();
		}else{
				if($(this).is(':checked')){
          $("#jmlnya").show();          
					var tr = $(this).closest("tr").attr("id");
					var jenisuji = $("#"+tr+" td:nth-child(2)").text();
					var paramuji = $("#"+tr+" td:nth-child(3)").text();
						clone += '<tr id="anak'+tr+'">';					
						clone += '<td><input type="hidden" name="RUJUKAN[UJI_ID][]" value="' + tr + '" />'+jenisuji+'</td>';
						clone += '<td>'+paramuji+'</td>';
						clone += '<td><?php echo str_replace(chr(10),'',form_dropdown('RUJUKAN[LINGKUP_UJI][]',$lingkup_uji,'','class="stext" title="Lingkup Pengujian" rel="required" url="'.site_url().'/autocompletes/autocomplete/pom_rujukan/" onchange="get_bbpom(this);"')); ?></td>';
						clone += '<td><?php echo str_replace(chr(10),'',form_dropdown('RUJUKAN[BBPOM_ID][]',$bbpom,'','class="stext" title="Tujuan Rujukan" rel="required"')); ?></td>';
						clone += '</tr>';
						$("#draft-rujukan").append(clone);
				}else{
					var tr = $(this).closest("tr").attr("id");
					$("tbody#draft-rujukan #anak"+tr).remove();
				}
		}
		
		
	});
	$("#lingkup_uji").change(function(){
		var id = $(this).val();
		$.get($(this).attr('url') + id, function(hasil){
			$("#bbpom_tujuan").html(hasil);
		});
	});
});
function blank_(obj){
	var url = $(obj).attr("url");
	window.open(url, '_blank');
	return false;
}

function get_bbpom(obj){
	var $cb = $(obj);
	var $row = $cb.parent().parent();
	var $target = $("#"+$row.attr("id")+" td:nth-child(4)").children();
	$.get($cb.attr("url") + $cb.val(), function(hasil){
		$target.html(hasil);
	});
	return false;
}

</script>