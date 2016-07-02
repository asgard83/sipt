<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAPORAN HASIL UJI</a></div>
                <div class="accCntnt">
				<form name="fkonsep" id="fkonsep" method="post" action="<?php echo $act; ?>" autocomplete="off">
					<table class="form_tabel">
						<tr>
							<td class="td_left bold">Kode Sampel</td><td class="td_right"><?php echo $sess['KODE']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nama Sampel</td><td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Pengirim Sampel</td><td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tempat Sampling</td><td class="td_right"><div><?php echo $sess['TEMPAT_SAMPLING']; ?></div><div><?php echo $sess['ALAMAT_SAMPLING']; ?></div></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Sampling</td><td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nomor Surat Permintaan Uji</td><td class="td_right"><?php echo $sess['SPU']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Surat Permintaan Uji</td><td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
						</tr>
						</table>
						<h2 class="small garis">&nbsp;</h2>
						<table class="form_tabel">
						<tr>
							<td class="td_left bold">Nama Pabrik</td><td class="td_right"><?php echo $sess['PABRIK']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nomor Registrasi</td><td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">No. Bets / Lot</td><td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Kadaluarsa</td><td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Kemasan / Netto</td><td class="td_right"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></td>							
						</tr>
						<tr>
							<td class="td_left bold">Jumlah Sampel</td><td class="td_right">@ 
							<?php
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_MIKRO'];
							}
							?> <?php echo $sess['SATUAN']; ?>
							</td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Mulai Pengujian</td><td class="td_right"><?php echo $tanggaluji[0]['MINTGL']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Selesai Pengujian</td><td class="td_right"><?php echo $tanggaluji[0]['MAXTGL']; ?></td>
						</tr>
					</table>
					<h2 class="small garis">Hasil Pengujian</h2>
					<div style="height:5px;">&nbsp;</div>
					<table class="form_tabel">
						<tr>
							<td class="td_left bold">Pemerian</td><td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
						</tr>
                    </table>					
                    <table class="tabelajax">
					<tr class="head"><th>Jenis Uji</th><th>Uji yang dilakukan</th><th>Hasil</th><th>Syarat</th><th>Metode</th><th>Pustaka</th><th>LCP</th></tr>
					<?php
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								?>
								<tr><td><?php echo $parameter[$x]['JENIS_UJI']; ?></td><td><?php echo $parameter[$x]['PARAMETER_UJI']; ?></td><td><div><?php echo $parameter[$x]['HASIL']; ?></div><div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td><td><?php echo $parameter[$x]['SYARAT']; ?></td><td><?php echo $parameter[$x]['METODE']; ?></td><td><?php echo $parameter[$x]['PUSTAKA']; ?></td><td><a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a></td></tr>
								<?php
							}
						}
					?>
					</table>
					
					<div style="height:5px;">&nbsp;</div>
					<table class="form_tabel">
					<?php
					if($sess['UJI_KIMIA'] == 1){
					?>
					<tr>
						<td class="td_left bold">Kesimpulan Uji Kimia</td><td class="td_right"><?php echo $sess['HASIL_KIMIA']; ?></td>
					</tr>
					<?php
					}
					?>
					
					<?php
					if($sess['UJI_MIKRO'] == 1){
					?>
					<tr>
						<td class="td_left bold">Kesimpulan Uji Mikro</td><td class="td_right"><?php echo $sess['HASIL_MIKRO']; ?></td>
					</tr>
					<?php
					}
					?>
					
					<?php
					if(trim($sess['HASIL_SAMPEL']) != ""){
					?>
					<tr>
						<td class="td_left bold">Kesimpulan Uji Sampel</td><td class="td_right"><?php echo $sess['HASIL_SAMPEL']; ?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class="td_left bold">&nbsp;</td><td class="td_right"><?php //echo $rowcp[0]['CATATAN']; ?></td>
					</tr>
					</table>
					<?php
					if($stts == "30203" || $stts == "40204"){
					?>
					<table class="form_tabel">
					<?php
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
						if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
							$act = TRUE;
						}
					}
					
					if($act && $stts == "30203"){
					?>
					<tr>
						<td class="td_left bold">Kesimpulan Akhir Sampel</td><td class="td_right"><?php echo form_dropdown('HASIL_SAMPEL',$hasil,'','class="stext" title="Kesimpulan akhir sampel" id="hasil" rel="required"'); ?></td>
					</tr>
					<?php
					}
					?>
					</table>
					
					<?php
					}
					?>
					<div style="height:5px;">&nbsp;</div>
					<h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_cp/<?php echo $cp_id; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Catatan Pengujian (<?= $jml_log; ?>)</a></h2>
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
<script>
function blank_(obj){
	var url = $(obj).attr("url");
	window.open(url, '_blank');
	return false;
}
</script>