<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnsarana" class="judul"></div>
<div class="content">

<div id="accordion">
    <h2 class="current">Surat Tugas Pemeriksaan Sarana</h2>
<form name="fpemeriksaan_" id="fpemeriksaan_" method="post" action="<?php echo $act; ?>" autocomplete="off">
<table>
	<tr>
    	<td>
        	<table>
            	<tbody id="tb_surat">
                <?php
                $jmldata = 0;
				$nomor = array();
                $jmldata = count($nomor);
                if($jmldata==0){
                    $jmldata = 1;
                    $nomor[] = "";
                }
                $i = 0;
				do{
				?>
            	<tr class="urut<?php echo $i; ?>"><td width="150">Nomor Surat Tugas</td><td><input type="text" class="stext" name="SURAT[NOMOR][]" id="stugas_" rel="required" val="<?php echo $nomor[$i]; ?>" title="Di isi dengan nomor surat tugas inspeksi / pemeriksaan"/>&nbsp;
				<?php
                if($i==0){
                ?>
                    <a href="#" class="addnomor" periksa="urut" terakhir="<?php echo $jmldata; ?>"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah Nomor Surat Tugas (jika surat tugas lebih dari satu)" /></a>
                <?php
                }else{
                ?>
                    <a href="#" class="min" onclick="$('.urut<?php echo  $i; ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus Surat Tugas" /></a>
                <?php
                }
                ?>
                </td></tr>
                <tr class="urut<?php echo $i; ?>">
                    <td>Tanggal Surat Tugas</td><td><input type="text" class="sdate" name="SURAT[TANGGAL][]" rel="required" val="<?php echo $nomor[$i]; ?>" id="tgltugas<?php echo $i; ?>" title="Tanggal Surat Tugas"/></td>
                </tr>
                <tr class="urut<?php echo $i; ?>">
                  <td class="atas">Unit / Balai Besar / Balai</td>
                  <td><input type="text" class="stext" readonly="readonly" value="<?php echo $this->newsession->userdata('SESS_MBBPOM'); ?>" name="BBPOM[MBBPOM_ID][]" val="<?php echo $nomor[$i]; ?>" title="Balai Besar / Balai POM" /><input type="hidden" name="BBPOM[BBPOM_ID][]" value="<?php echo $this->newsession->userdata('SESS_BBPOM_ID'); ?>" id="bpomid" /></td>
                </tr>
                <tr class="urut<?php echo $i; ?>">
                  <td class="atas">Petugas</td>
                  <td><input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." /></td>
                </tr>
                <tr class="urut<?php echo $i; ?>">
                  <td class="atas">&nbsp;</td>
                  <td><ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul></td>
                </tr>
                <?php 
                $i++;
                }while($i<$jmldata)
                ?>
                </tbody>
            </table>
        </td>
        
        <td width="10">&nbsp;</td>
        
        <td class="atas">
        	<table>
                <tr>
                  <td class="atas">Nama Sarana</td>
                  <td><input type="text" class="stext" name="saranaid_" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" value="<?php echo $saranaid_; ?>" rel="required"/><input type="hidden" name="saranaidval_" id="saranaidval_" value="<?php echo $saranaidval_; ?>" />&nbsp;&nbsp;&nbsp;<a href="#" id="browse" url="<?php echo $browse; ?>" onclick="PopupCenter('#browse'); return false;" judul="Master_Data_Sarana" lebar="900" tinggi="480"><img src="<?php echo base_url(); ?>images/info.png" align="top" title="Tampilkan data sarana" style="border:none;" /></a>
                  </td>
                </tr>          
                <tr>
                    <td width="150">Jenis Sarana</td><td><?php echo form_dropdown('media_', $media, '', 'id="media_" class="stext" rel="required" title="Pilih Jenis Sarana"', $disinput); ?>
                    </td>
                </tr>
                <tr>
                    <td class="atas">Jenis Klasifikasi</td><td><?php echo  form_dropdown('klasifikasi[]', $klasifikasi, $selklasifikasi, 'id="klasifikasi_id" class="stext" rel="required" title="Pilih Klasifikasi Sarana"'); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
    <div style="padding-left:5px; padding-bottom:10px;"><a href="#" class="button save" onclick="fpost('#fpemeriksaan_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>

</form>			
</div>


</div>
<div id="clear_fix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$("input.operator").autocomplete($("input.operator").attr("url")+$("#bpomid").val(), {width: 244, selectFirst: false}); $("input.operator").result(function(event, data, formatted){ if(data){ $("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="BBPOM[NAMA][0][]" value="'+data[2]+'">&nbsp;<input type="hidden" name="USER_ID[0][]" value="'+data[1]+'"></li>'); $(this).val(''); $(this).focus(); } });
		
		$("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false}); $("#saranaid_").result(function(event, data, formatted){ if(data){ $(this).val(data[2]); $("#saranaidval_").val(data[1]); $("#media_").focus();} });
		
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		
		$('.addnomor').click(function(){ var nom = $(this).attr('terakhir'); var idtr = $(this).attr('periksa'); var cls = idtr + nom;
		  $("#tb_surat").append('<tr class= "' + cls + '"><td width="150">Nomor Surat Tugas</td><td><input type="text" class="stext" name="SURAT[NOMOR][]" id="stugas_" rel="required" title="Di isi dengan nomor surat tugas inspeksi / pemeriksaan"/>&nbsp;&nbsp;<a href="#" class="min" onclick="$(\'.' + cls + '\').remove();" ><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Surat Tugas" /></a></td></tr><tr class= "' + cls + '"><td>Tanggal Surat Tugas</td><td><input type="text" class="sdate" name="SURAT[TANGGAL][]" rel="required" id="tgltugas'+nom+'" title="Tanggal Surat Tugas"/></td></tr><tr class= "' + cls + '"><td class="atas">Unit / Balai Besar / Balai</td><td><input type="text" class="stext bbpomid" url="<?php echo site_url(); ?>/autocompletes/autocomplete/bbpomid" title="Balai Besar / Balai POM" ><input type="hidden" name="BBPOM[BBPOM_ID][]" id="bbpomid' + cls + '"><input type="hidden" name="BBPOM[MBBPOM_ID][]" id="mbbpomid' + cls + '"></td></tr><tr class= "' + cls + '"><td class="atas">Petugas</td><td><input type="text" class="stext op" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas."></td></tr><tr class= "' + cls + '"><td class="atas">&nbsp;</td><td><ul style="list-style:none; margin:0px; padding:0px;" id="' + cls + '"></ul></td></tr>'); $(this).attr('terakhir', parseInt(nom) + 1); $('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'}); $("input.bbpomid").autocomplete($("input.bbpomid").attr("url"), {width: 244, selectFirst: false}); $("input.bbpomid").result(function(event, data, formatted){ if(data){ $(this).val(data[2]); $("#bbpomid" + cls).val(data[1]); $("#mbbpomid" + cls).val(data[2]); $("input.op").autocomplete($("input.op").attr("url")+$("#bbpomid"+ cls).val(), {width: 244, selectFirst: false}); $("input.op").result(function(event, data, formatted){ if(data){ $("ul#"+cls).append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#'+cls+' li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="BBPOM[NAMA]['+nom+'][]" value="'+data[2]+'">&nbsp;<input type="hidden" name="USER_ID['+nom+'][]" value="'+data[1]+'"></li>'); $(this).val(''); $(this).focus(); } }); } }); $('select, textarea, input:not(:image, submit, checkbox, radio)').poshytip({className: 'tip-twitter',showTimeout: 1,alignTo: 'target',alignX: 'right',alignY: 'center',offsetX: 5,allowTipHover: false,fade: false,slide: false});
		});
		
		$("#media_").change(function(){ 
			var kunci = $(this).val(); 
			$.get('<?php echo site_url(); ?>/get/pemeriksaan/set_klasifikasi_sarana/' + kunci, function(hasil){ 
				hasil = hasil.replace(' ', ''); 
				if(hasil!=""){ 
					$('#klasifikasi_id').html(hasil); 
					if(hasil.search('005')>=0){
						$('#klasifikasi_id').attr('multiple','multiple'); 
						$("#klasifikasi_id option[value='']").remove();
					}else{
						$('#klasifikasi_id').attr('multiple',''); 
					}
				} 
			}); 
		});				
	});
</script>
