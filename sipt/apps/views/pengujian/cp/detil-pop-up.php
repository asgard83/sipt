<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<form name="feditcp" id="feditcp" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
  <input type="hidden" name="CP_ID" value="<?php echo $sess['CP_ID']; ?>" />
<h2 style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf;">Detil Catatan Pengujian</h2>
<table class="form_tabel">
  <tr>
    <td class="td_left bold">BB / BBPOM</td>
    <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Kode Sampel</td>
    <td class="td_right"><?php echo $sess['UR_KODE']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Hasil</td>
    <td class="td_right"><?php echo $sess['HASIL']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Catatan</td>
    <td class="td_right"><?php echo $sess['CATATAN']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Manager Teknis</td>
    <td class="td_right"><?php echo $sess['MT']; ?>
      <div style="font-size:10px;"><?php echo $sess['JABATAN_MT']; ?></div></td>
  </tr>
  <tr id="trmt" style="display:none;">
    <td class="td_left bold">Manager Teknis Pengganti</td>
    <td class="td_right"><?php echo form_dropdown('MT',$arrmt,'','class="stext" id="mt_edit" title="Daftar Nama Manager Teknis"'); ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Catatan Pengujian Di buat Oleh</td>
    <td class="td_right"><?php echo $sess['PENYELIA']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Nomor Catatan Pengujian</td>
    <td class="td_right"><?php echo $sess['CP_ID']; ?></td>
  </tr>
  <tr>
    <td class="td_left bold">Diperiksa Oleh</td>
    <td class="td_right"><?php echo $sess['VERIFIKATOR']; ?>
      <div style="font-size:10px;"><?php echo $sess['JABATAN_VERIFIKATOR']; ?></div></td>
  </tr>
  <tr style="display:none;">
      <td class="td_left bold" colspan="2"><div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
          <input type="checkbox" id="chk_edit" />
          &nbsp;<b>Edit Manager Teknis</b></div></td>
    </tr>
</table>
<div style="height:5px;">&nbsp;</div>
<h2 style="font-weight: bold; padding-bottom: 10px; border-bottom: 1px solid #ededed; font-size: 1em; color:#3c7faf;">Data Laporan Hasil Pengujian</h2>
<table class="listtemuan" width="100%" id="draft-parameter">
  <thead>
    <tr>
      <th width="200">Nomor LHU</th>
      <th>Manager Teknis</th>
    </tr>
  </thead>
  <tbody>
    <?php
  $jml = count($lhu);
  if($jml > 0){
	  for($x = 0; $x < $jml; $x++){
		  ?>
    <tr>
      <td><?php echo $lhu[$x]['UR_LHU']; ?></td>
      <td><?php echo $lhu[$x]['NAMA_USER']; ?></td>
    </tr>
    <?php
	  }
  }else{
	  ?>
    <tr>
      <td colspan="2">Tidak ada data LHU</td>
    </tr>
    <?php
  }
  ?>
  </tbody>
</table>
<div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button save editable" onclick="save_edit('#feditcp'); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a></div>
<div style="padding:5px;">&nbsp;</div>
</form>

<script>
	$(document).ready(function(){
		$("table.form_tabel tr:even").css("background-color", "#f0f0f0");
		$("table.form_tabel tr:odd").css("background-color", "#fff");
		$(".editable").css("display","none");
		$("#chk_edit").change(function(e){
			if($(this).is(":checked")){
				$("#trmt").css("display","");
				$(".editable").css("display","");
				$("#mt_edit").attr("rel","required");
			}else{
				$("#trmt").css("display","none");
				$("#mt_edit").removeAttr("rel");
				$(".editable").css("display","none");
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