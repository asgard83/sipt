<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
	<div class="adCntnr">
		<div class="acco2">
			<div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETAIL PERINTAH PENGUJIAN</a></div>
			<div class="accCntnt">
				<h2 class="small garis">Surat Perintah Kerja</h2>
				<table class="form_tabel" width="100%">
					<tr>
						<td class="td_left">Nomor Surat Perintah Kerja</td>
						<td class="td_right" style="width:300px;"><?php echo $sess['UR_SPK']; ?></td>
						<td>&nbsp;</td>
						<td class="td_left">Tanggal Surat Perintah Kerja</td>
						<td class="td_right"><?php echo $sess['TGL_SPK']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Pengirim Surat Perintah Kerja</td>
						<td class="td_right"><?php echo $sess['PENYELIA']; ?></td>
						<td>&nbsp;</td>
						<td class="td_left">Nomor Surat Perintah Pengujian</td>
						<td class="td_right"><?php echo $sess['UR_SPP']; ?></td>
					</tr>
				</table>
				<h2 class="small garis">Detail Sampel</h2>
				<table class="form_tabel">
					<tr>
						<td class="td_left">Kode Sampel</td>
						<td class="td_right" style="width:300px;"><?php echo $sess['UR_KODE_SAMPEL']; ?></td>
						<td></td>
						<td class="td_left">Komoditi</td>
						<td class="td_right"><?php echo $sess['KOMODITI']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Nama sampel</td>
						<td class="td_right"><?php echo $sess['NAMA_SAMPEL'];?></td>
						<td width="10"></td>
						<td class="td_left">No Registrasi</td>
						<td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
					</tr>
					<tr>
						<td class="td_left">No Bets</td>
						<td class="td_right"><?php echo $sess['NO_BETS'];?></td>
						<td width="10"></td>
						<td class="td_left">Bentuk Sediaan</td>
						<td class="td_right"><?php echo $sess['BENTUK_SEDIAAN']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Kemasan</td>
						<td class="td_right"><?php echo $sess['KEMASAN'];?></td>
						<td width="10"></td>
						<td class="td_left">Komposisi</td>
						<td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Keterangan Expire Date</td>
						<td class="td_right"><?php echo $sess['KETERANGAN_ED'];?></td>
						<td width="10"></td>
						<td class="td_left">Pemerian</td>
						<td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
					</tr>
				</table>	
				
				<h2 class="small garis">Detil Parameter Uji</h2>
				<div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:5px;">
					<p><b>Keterangan :</b></p>
					<p>Untuk pilihan detail parameter uji, silahkan klik pada nama parameter uji.</p>
				</div>
				<div style="height:5px;">&nbsp;</div>
				<table class="listtemuan" width="100%">
					<thead>
						<tr>
							<th width="300">Parameter Uji</th>
							<th width="100">Metode</th>
							<th width="100">Pustaka</th>
							<th width="100">Syarat</th>
							<th width="100">Ruang Lingkup</th>
							<th width="100">Hasil</th>
							<th width="150">Penguji</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$jml = count($sess_parameter);
					if($jml > 0){
						for($x = 0; $x < $jml; $x++){
							?>
							<tr id="<?php echo $sess_parameter[$x]['SPK_ID']; ?>-<?php echo $sess_parameter[$x]['UJI_ID']; ?>">
								<td><a href="javscript:;" url="<?php echo site_url(); ?>/get/pengujian/get_parameter" class="detail-params"><?php echo $sess_parameter[$x]['PARAMETER_UJI']; ?></a></td>
								<td><?php echo $sess_parameter[$x]['PUSTAKA']; ?></td>
								<td><?php echo $sess_parameter[$x]['METODE']; ?></td>
								<td><?php echo $sess_parameter[$x]['SYARAT']; ?></td>
								<td><?php echo $sess_parameter[$x]['RUANG_LINGKUP']; ?></td>
								<td><div><?php echo $sess_parameter[$x]['HASIL']; ?></div><div><?php echo $sess_parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
								<td width="200">
								<?php
								if(trim($sess_parameter[$x]['PENGUJI']) == "Belum Ditentukan Penguji" || strlen($sess_parameter[$x]['PENGUJI']) == 0){
									?>
                                    <a href="javascript:;" class="koreksi-penguji" style="color:#F00;" url="<?php echo site_url(); ?>/get/pengujian/get_penguji" id="<?php echo $sess_parameter[$x]['SPK_ID']; ?>-<?php echo $sess_parameter[$x]['UJI_ID']; ?>">Klik untuk Menentukan Ulang Penguji</a>
                                    <?php
								}else{
									echo $sess_parameter[$x]['PENGUJI']; 
								}
								?>
                                </td>
							</tr>
							<?php
						}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div style="height:10px;">&nbsp;</div>
		<div style="padding-left:5px;">
			<a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a>
		</div>
	</div>
</div>
<div id="cnt-parameter"></div>
<div id="cnt-penguji"></div>
<script>
	$(document).ready(function(){
		$(".detail-params").live("click", function(){
			var id = $(this).closest("tr").attr("id");
			$.get($(this).attr("url") + "/" + id, function(data){
				$("#cnt-parameter").html(data); 
				$("#cnt-parameter").dialog({ 
					title: 'Detail Parameter Uji', 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
			return false;
		});
		$(".koreksi-penguji").live("click", function(){
			var id = $(this).attr("id");
			$.get($(this).attr("url") + "/" + id, function(data){
				$("#cnt-penguji").html(data); 
				$("#cnt-penguji").dialog({ 
					title: 'Penentuan Ulang Penguji', 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
			return false;
		});
	});
</script>