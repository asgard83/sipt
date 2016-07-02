<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">

<div class="adCntnr">
    <div class="acco2">
    	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT TINDAK LANJUT SARANA</a></div>
              <div class="collapse">
                  <div class="accCntnt">
                  <h2 class="small garis">Surat Tindak Lanjut Sarana</h2>
                  <div style="height:5px;"></div>
                  <?php  if($istable){ echo $tabel; } ?>
                  <div style="height:5px;"></div>
                  <?php if($hide){ ?>
                  <form name="ftl" id="ftl" method="post" action="<?php echo $act; ?>" autocomplete="off" enctype="multipart/form-data"> 
                  <table class="form_tabel">
					<tr><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('TL[JENIS_SARANA_ID]',$jenis,$sel_jenis,'class="stext" rel="required" title="Jenis sarana yang diperiksa"',$disinput); ?></td></tr>                  
                  	<tr><td class="td_left">Nomor Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="stext" name="TL[NOMOR_SURAT]" value="<?php echo $sess['NOMOR_SURAT']; ?>" rel="required" title="Nomor Surat Tindak Lanjut" /></td></tr>
                  	<tr><td class="td_left">Tanggal Surat Tindak Lanjut</td><td class="td_right"><input type="text" class="sdate" name="TL[TANGGAL_SURAT]" value="<?php echo $sess['TANGGAL_SURAT']; ?>" rel="required" title="Tanggal Tindak Lanjut" id="tgltugas_" /></td></tr>
                    
                  	<tr><td class="td_left">Lampiran</td><td class="td_right"><input type="text" class="stext" name="TL[LAMPIRAN]" value="<?php echo $sess['LAMPIRAN']; ?>" rel="required" title="Lampiran surat"/></td></tr>
                    </table>
                    <div id="jenis_"><?php echo $load_jenis; ?></div>
                    <table class="form_tabel">
                  	<tr><td class="td_left">Dikeluarkan di </td><td class="td_right"><input type="text" class="stext" name="TL[TEMPAT_TTD]" value="<?php echo $sess['TEMPAT_TTD']; ?>" rel="required" title="Tempat Surat di Terbitkan"/></td></tr>
                  	<tr><td class="td_left">Pejabat Penanda Tangan</td><td class="td_right">
                    <?php echo form_dropdown('TL[PEJABAT_TTD]',$pejabat,$sess['PEJABAT_TTD'],'class="stext" id="pejabat" rel="required" title="Pejabat Penanda Tangan Surat"'); ?></td></tr>
                  	<tr><td class="td_left">Tembusan</td><td class="td_right"><textarea class="stext chk" name="TL[TEMBUSAN]" title="Tembusan Surat"><?php echo $sess['TEMBUSAN']; ?></textarea></td></tr>
                  </table>
                  <input type="hidden" name="PERIKSA_ID" value="<?php echo $periksa_id; ?>" />
                  <input type="hidden" name="SURAT_ID" value="<?php echo $surat_id; ?>" />
                  <input type="hidden" name="URL" value="<?php echo $url_; ?>" />
                  </form>
				  <?php } ?>
                  <a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a>&nbsp;
                  <?php if($hide){ ?>
                  <a href="#" class="button save" onclick="fpost('#ftl','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $simpan; ?> &nbsp;</span></a>&nbsp;
                  <?php }else{ ?>
                  <?php /*?><a href="#" class="button outbox" url="<?php echo $url_surat; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp;Preview Surat&nbsp;</span></a>&nbsp;<?php */?>
                  <?php } ?>
                  <a href="#" class="button comment" url="<?php echo $url_preview; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Data Pemeriksaan &nbsp;</span></a></div>
                  </div> 

          </div><!-- End Informasi Pemeriksaan !-->
    </div><!-- End Accordian !-->
</div>
<div id="clear_fix"></div>
<div>


</div>

<script type="text/javascript">
	$(document).ready(function(){
		create_ck("textarea.chk",505)        
		$("#NAMA_PEJABAT").autocomplete($("#NAMA_PEJABAT").attr('url'), {width: 244, selectFirst: false});
		$("#NAMA_PEJABAT").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#USER_ID").val(data[1]);
			}
		});
    });
</script>

