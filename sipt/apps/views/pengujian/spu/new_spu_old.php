<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI SAMPLING</a></div>
                <div class="accCntnt">
                    <h2 class="small garis">Data Sampling</h2>
                    <table class="form_tabel">
                        <tr><td class="td_left">Anggaran Sampling</td><td class="td_right"><?php echo $anggaran; ?></td></tr>
                        <tr><td class="td_left">Nomor Surat Tugas</td><td class="td_right"><?php echo $surat_tugas; ?></td></tr>
                        <tr><td class="td_left">Tanggal Surat Tugas</td><td class="td_right"><?php echo $tanggal_surat; ?></td></tr>
                        <tr><td class="td_left">Asal Sampling</td><td class="td_right"><?php echo $asal; ?></td></tr>
                        <tr><td class="td_left">Tujuan Sampling</td><td class="td_right"><?php echo $tujuan; ?></td></tr>
                        <tr><td class="td_left">Tanggal Sampling</td><td class="td_right"><?php echo $tanggal_awal; ?>&nbsp;&nbsp;sampai dengan&nbsp;&nbsp;<?php echo $tanggal_akhir; ?></td></tr>
                        <tr><td class="td_left">Petugas</td><td class="td_right">
						<?php 
						$jml = count($petugas);
						if($jml > 0){
							foreach($petugas as $p){
								echo "<p>&bull; &nbsp;". $p."</p>";
							}
						}else{
							echo "-";
						}
						?>
                        </td></tr>
                    </table>
            </div><!-- Akhir Informasi Pemeriksaan Sampel !-->
            
            <div style="height:5px;">&nbsp;</div>
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGIRIM</a></div>
                <div class="accCntnt">
                	<div <?php echo $anggaran_sampling == "05" ? 'style="display:none;"' : ''; ?> class="pihak-3-swasta-pemerintah">
                        <h2 class="small garis">Data Pengirim Sampel</h2>
                        <table class="form_tabel">
                            <tr><td class="td_left">Nama Pengirim</td><td class="td_right"><?php echo $pengirim; ?></td></tr>
                            <tr><td class="td_left">NIP</td><td class="td_right"><?php echo $nip; ?></td></tr>
                        </table>
                    </div>
                    
                    <div class="biaya-pihak-ke-3" <?php echo $anggaran_sampling == "05" || $anggaran_sampling == "06" || $anggaran_sampling == "07" ? '' : 'style="display:none;"'; ?>>
                      <table class="form_tabel">
                          <tr><td class="td_left">Biaya</td><td class="td_right"><?php echo $biaya; ?></td></tr>                        
                          <tr><td class="td_left">No. Resi Bank</td><td class="td_right"><?php echo $no_resi_bank; ?></tr>
                          <tr><td class="td_left">Tanggal Resi Bank</td><td class="td_right"><?php echo $tanggal_resi_bank; ?></td></tr>
                      </table>
                    </div>
            </div><!-- Akhir Informasi Pengirim!-->
            
            <div style="height:5px;">&nbsp;</div>
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA SAMPLING</a></div>
                <div class="accCntnt">
            	<h2 class="small garis">Lampiran Detail Data Sampling</h2>
                <div><?php echo $tabel; ?></div>
            </div><!-- Akhir Informasi Pemeriksaan Sampel !-->
            
            <div style="height:5px;">&nbsp;</div>
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERMINTAAN UJI</a></div>
                <div class="accCntnt">
                  <h2 class="small garis">Informasi Data Surat Permintaan Uji</h2>
                    <form name="fspu" id="fspu" method="post" action="<?php echo $act; ?>" autocomplete="off">
                    <table class="form_tabel">
                    	<tr><td class="td_left">Nomor SPU</td><td class="td_right"><input type="text" name="SPU[NOMOR_SPU]" class="stext" title="Nomor Surat Perintah Uji" rel="required" /></td></tr>
                        <tr><td class="td_left">Tanggal SPU</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Uji" rel="required" name="SPU[TANGGAL]" /></td></tr>
                        <tr><td class="td_left">Ditujukan Kepada</td><td class="td_right"><input type="text" class="stext" title="Ditujukan ke Manager Teknis" rel="required" id="nama_mt" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/4" /><input type="hidden" name="user_mt" id="user_mt" /></td></tr>
                         <tr><td class="td_left">Bidang</td><td class="td_right"><?php echo form_dropdown('SPU[BIDANG]','','','class="stext" rel="requried" title="Laboratorium" id="bidang"'); ?></td></tr>
                    </table>
                <div style="height:20px;">&nbsp;</div>
                <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fspu','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
                <input type="hidden" name="periksa_sampel" value="<?php echo $id; ?>" />
                <input type="hidden" name="anggaran_sampel" value="<?php echo $anggaran_sampling; ?>" />
                </form>
                
                <div style="height:20px;">&nbsp;</div>
            </div><!-- Akhir Informasi SPU!-->
            
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("#nama_mt").autocomplete($("#nama_mt").attr('url'), {width: 244, selectFirst: false});
	$("#nama_mt").result(function(event, data, formatted){
		if(data){
			$(this).val(data[2]);
			$("#user_mt").val(data[1]);
			$.get('<?php echo site_url().'/autocompletes/autocomplete/get_bidang/'; ?>' + data[1], function(hasil){
				var hasil = hasil.replace(' ', '');
				var jum = hasil.length;
				if(jum==0){
					$('#bidang').html();
				}else{
					$('#bidang').html(hasil);
				}
			});
		}
	});
});
</script>            