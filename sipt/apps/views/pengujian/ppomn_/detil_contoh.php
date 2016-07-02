<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI SAMPLING</a></div>
            <div class="collapse">
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
                    <div style="height:10px;">&nbsp;</div>
                    <h2 class="small garis">Data Detail Sampling</h2>
                    <div><?php echo $tabel; ?></div>
                </div>
            </div><!-- Akhir Informasi Pemeriksaan Sampel !-->
            
            <div style="height:5px;">&nbsp;</div>
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PENGIRIM</a></div>
            <div class="collapse">
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
                    
                </div>
            </div><!-- Akhir Informasi Pengirim!-->
            <form name="fdetil" id="fdetil" method="post" action="<?php echo $act; ?>" autocomplete="off"> 
            <div style="height:5px;">&nbsp;</div>
            <?php if($status_periksa != '70001'){ ?>
            <div style="padding:5px; font-weight:bold;"><input type="checkbox" id="check" />&nbsp;&nbsp;Apakah data sudah lengkap dan akan dikirim ke level selanjutnya ?</div>
            <div id="box-verifikasi" style="display:none;">
			<div style="height:5px;">&nbsp;</div>
            <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI KIRIM SAMPEL</a></div>
                <div class="accCntnt">
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('STATUS',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>                    
            </div><!-- Akhir Verifikasi!-->
            </div>
            <?php } ?>
        </div>
    </div>
    <div style="height:5px;">&nbsp;</div>
    <div style="padding-left:5px;">
    <?php if($status_periksa != '70001'){ ?>
    <span class="btn-verifikasi" style="display:none;"><a href="#" class="button check" onclick="fpost('#fdetil','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a></span>&nbsp;
		<?php if(in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('7', $this->newsession->userdata('SESS_KODE_ROLE'))){?>
        <a href="#" class="button download" target="_blank" onclick="batal($(this)); return false;" url="<?php echo site_url(); ?>/topdf/sampel/lampiran_tps/<?php echo $id; ?>"><span><span class="icon"></span>&nbsp; Cetak Lampiran Data Sampel &nbsp;</span></a>
        <?php } ?>
    <?php } ?>
    &nbsp;<a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
    <input type="hidden" name="periksa" value="<?php echo $id; ?>" />
    
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#check").change(function(){
		if($(this).is(":checked")){
			$("#box-verifikasi, .btn-verifikasi").css("display","");
		}else{
			$("#box-verifikasi, .btn-verifikasi").css("display","none");
		}
	});
});
</script>            