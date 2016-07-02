<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGIRIMAN SAMPEL</a></div>
                <div class="accCntnt">
                <h2 class="small garis">Surat Permintaan Uji</h2>
                <form name="fkirim_sampel" id="fkirim_sampel" method="post" action="<?php echo site_url(); ?>/post/spu/set_spu/save" autocomplete="off">
                <table class="form_tabel">
                    <tr><td class="td_left">Tanggal Surat</td><td class="td_right"><input type="text" name="PERMINTAAN_UJI[TANGGAL]" class="sdate" rel="required" /></td></tr>
                    <tr><td class="td_left">Komoditi</td><td class="td_right"><?php echo $sess[0]['KLASIFIKASIS']; ?></td></tr>
                    <tr><td class="td_left">Anggaran</td><td class="td_right"><?php echo $sess[0]['ANGGARANS']; ?></td></tr>
                    <tr><td class="td_left">Asal Sampling</td><td class="td_right"><?php echo $sess[0]['ASAL']; ?></td></tr>
                    <tr><td class="td_left">Bulan Anggaran</td><td class="td_right"><?php echo $sess[0]['BULAN']; ?></td></tr>
                </table>
                <input type="hidden" name="KODE" value="<?php echo $arrid; ?>" />
                <input type="hidden" name="PERMINTAAN_UJI[ANGGARAN]" value="<?php echo $sess[0]['ANGGARAN']; ?>" />
                <input type="hidden" name="PERMINTAAN_UJI[KLASIFIKASI]" value="<?php echo $sess[0]['KLASIFIKASI']; ?>" />
                <input type="hidden" name="PERMINTAAN_UJI[ASAL_SAMPLING]" value="<?php echo $sess[0]['ASAL_SAMPLING']; ?>" />
                </form>
                <div style="height:5px;">&nbsp;</div>
                <h2 class="small garis">Data Sampel</h2>
                <table class="tabelajax">
                <tr class="head"><th>No</th><th>Kode Sampel</th><th>Nama Sampel</th><th>Jumlah Sampel</th><th>Kimia</th><th>Mikro</th><th>Sisa</th></tr>
               <?php 
               $jml = count($sess);
               $z = 0;
               $no = 1;
               if($jml > 0){
                   for($i=0; $i<$jml; $i++){
                       ?>
                       <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $sess[$i]['KODE_SAMPEL']; ?></td>
                            <td><?php echo $sess[$i]['NAMA_SAMPEL']; ?></td>
                            <td><?php echo $sess[$i]['JUMLAH_SAMPEL']; ?></td>
                            <td><?php echo $sess[$i]['JUMLAH_KIMIA']; ?></td>
                            <td><?php echo $sess[$i]['JUMLAH_MIKRO']; ?></td>
                            <td><?php echo $sess[$i]['SISA']; ?></td>
                       <?php
                       $no++;
                   }
               }else{
                   ?>
                   <tr><td colspan="6">Data Tidak Ditemukan</td></tr>
                   <?php
               }
               ?>
            </table>
            
            <div style="height:15px;">&nbsp;</div>
            <div style="padding-left:5px;"><a href="#" class="button save" onclick="create_spu('#fkirim_sampel','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="close_popup();"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
            <div style="height:15px;">&nbsp;</div>
            </div>
        </div>
    </div>
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