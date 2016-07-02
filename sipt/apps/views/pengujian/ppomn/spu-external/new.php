<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <form name="fspupemdik" id="fspupemdik" method="post" action="<?php echo $act; ?>" autocomplete="off">
	<input type="hidden" name="KODE_SAMPEL" value="<?php echo $arrid; ?>" />
	<input type="hidden" name="ANGGARAN" value="<?php echo $row[0]['ANGGARAN']; ?>" />
	<input type="hidden" name="ASAL_SAMPEL" value="<?php echo $row[0]['ASAL_SAMPEL']; ?>" />
	<input type="hidden" name="KOMODITI" value="<?php echo $row[0]['KOMODITI']; ?>" />
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERMINTAAN UJI</a></div>
            <div class="collapse">
                <div class="accCntnt">
                    <h2 class="small garis">Surat Permintaan Uji Baru</h2>
					<table class="form_tabel">
						<tr><td class="td_left">Tanggal Surat</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Permintaan Uji" name="SPU[TANGGAL]" rel="required" /></td></tr>
						<tr><td class="td_left">Komoditi</td><td class="td_right"><?php echo $row[0]['UR_KOMODITI']; ?></td></tr>
						<tr><td class="td_left">Asal Sampel</td><td class="td_right"><?php echo $row[0]['UR_ASAL_SAMPEL']; ?></td></tr>
                        <tr><td class="td_left">Segel Sampel</td><td class="td_right"><?php echo form_dropdown('SEGEL',$segel,'','class="stext" title="Pilih salah satu, segel sampel" rel="required"'); ?></td></tr>
                        <tr><td class="td_left">Label Sampel</td><td class="td_right"><?php echo form_dropdown('LABEL',$label_sampel,'','class="stext" title="Pilih salah satu, label sampel" rel="required"'); ?></td></tr>
					</table>
					<h2 class="small garis">Detil Data Sampel</h2>
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
								<td><?= $row[$i]['NAMA_SAMPEL']; ?><br /><?= $row[$i]['KODE SAMPEL'];?></td>
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

                </div>
            </div>
        </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="create_spu('#fspupemdik','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="javascript:void(0);" class="button reload" onclick="close_popup();"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
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