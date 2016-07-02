<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
<div class="adCntnr">
	<div class="acco2">
		<div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGUJIAN</a></div>
		<div class="collapse">
			<div class="accCntnt">
				<h2 class="small garis">Informasi Surat Perintah Pengujian</h2>
				<table class="form_tabel">
					<tr>
						<td class="td_left bold">Berdasarkan :</td>
						<td class="td_right bold">&nbsp;</td>
					</tr>
					<tr>
						<td class="td_left">Nomor Surat Perintah Pengujian</td>
						<td class="td_right bold" width="300"><?php echo $sp[0]['UR_SPP'];  ?></td>
					</tr>
					<tr>
						<td class="td_left">Tanggal Surat Perintah Pengujian</td>
						<td class="td_right bold"><?php echo $sp[0]['TGL_SPP']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Nomor Surat Perintah Kerja</td>
						<td class="td_right bold"><?php echo $sp[0]['UR_SPK']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Tanggal Surat Perintah Kerja</td>
						<td class="td_right bold"><?php echo $sp[0]['TGL_SPK']; ?></td>
					</tr>
					<tr>
						<td class="td_left">&nbsp;</td>
						<td class="td_right">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="td_left">Agar dilakukan pengujian kode sampel <b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b>, sesuai dengan parameter uji di bawah ini.</td>
					</tr>
				</table>
				<div style="height:5px;">&nbsp;</div>
				<h2 class="small garis">Informasi Sampel</h2>
				<table class="form_tabel">
					<tr>
						<td class="td_left">Kode Sampel</td>
						<td class="td_right bold"><b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b></td>
					</tr>
					<tr>
						<td class="td_left">Pemerian</td>
						<td class="td_right"><?php echo $sampel[0]['PEMERIAN']; ?></td>
					</tr>
				</table>
				<table class="form_tabel" width="100%">
					<tr>
						<td class="td_left">Komoditi</td>
						<td class="td_right" style="width:300px;"><?php echo $sampel[0]['KOMODITI']; ?></td>
						<td width="10"></td>
						<td class="td_left">Komoditi Tambahan</td>
						<td class="td_right"><?php echo $sampel[0]['KLASIFIKASI_TAMBAHAN']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Nama sampel</td>
						<td class="td_right"><?php echo $sampel[0]['NAMA_SAMPEL'];?></td>
						<td width="10"></td>
						<td class="td_left">No Registrasi</td>
						<td class="td_right"><?php echo $sampel[0]['NOMOR_REGISTRASI']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Kategori sampel</td>
						<td class="td_right"><?php echo $sampel[0]['UR_KATEGORI']; ?></td>
						<td width="10"></td>
						<td class="td_left">&nbsp;</td>
						<td class="td_right">&nbsp;</td>
					</tr>
					<tr>
						<td class="td_left">Pabrik</td>
						<td class="td_right"><?php echo $sampel[0]['PABRIK']; ?></td>
						<td width="10"></td>
						<td class="td_left">Importir</td>
						<td class="td_right"><?php echo $sampel[0]['IMPORTIR']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Bentuk Sediaan sampel</td>
						<td class="td_right"><?php echo $sampel[0]['BENTUK_SEDIAAN']; ?></td>
						<td width="10"></td>
						<td class="td_left">Kemasan sampel</td>
						<td class="td_right"><?php echo $sampel[0]['KEMASAN']; ?></td>
					</tr>
					<tr>
						<td class="td_left">No Bets</td>
						<td class="td_right"><?php echo $sampel[0]['NO_BETS']; ?></td>
						<td width="10"></td>
						<td class="td_left">Keterangan ED</td>
						<td class="td_right"><?php echo $sampel[0]['KETERANGAN_ED']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Komposisi</td>
						<td class="td_right"><?php echo $sampel[0]['KOMPOSISI']; ?></td>
						<td width="10"></td>
						<td class="td_left">Netto</td>
						<td class="td_right"><?php echo $sampel[0]['NETTO']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Evaluasi Penandaan</td>
						<td class="td_right"><?php echo $sampel[0]['EVALUASI_PENANDAAN']; ?></td>
						<td width="10"></td>
						<td class="td_left">Cara Penyimpanan</td>
						<td class="td_right"><?php echo $sampel[0]['CARA_PENYIMPANAN']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Kondisi sampel</td>
						<td class="td_right"><?php echo $sampel[0]['KONDISI_SAMPEL']; ?></td>
						<td width="10"></td>
						<td class="td_left">Jumlah sampel</td>
						<td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sampel[0])?$sampel[0]['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sampel[0]['SATUAN']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Segel sampel</td>
						<td class="td_right"><?php echo $sampel[0]['SEGEL']; ?></td>
						<td></td>
						<td class="td_left">Label sampel</td>
						<td class="td_right"><?php echo $sampel[0]['LABEL']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Pengujian</td>
						<td class="td_right"><div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_KIMIA'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Kimia</span>&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sampel[0])?$sampel[0]['JUMLAH_KIMIA']:"0"; ?></div>
							<div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_MIKRO'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Mikro</span>&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sampel[0])?$sampel[0]['JUMLAH_MIKRO']:"0"; ?></div>
							<div><span>Sisa</span>&nbsp;<?php echo array_key_exists('SISA', $sampel[0])?$sampel[0]['SISA']:"0"; ?></div></td>
						<td></td>
						<td class="td_left">Harga Pembelian</td>
						<td class="td_right"><?php echo $sampel[0]['HARGA_SAMPEL']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Catatan</td>
						<td class="td_right"><?php echo $sampel[0]['CATATAN']; ?></td>
						<td width="10"></td>
						<td class="td_left">Lampiran File</td>
						<td class="td_right"><?php
                      if(trim($sampel[0]['LAMPIRAN']) != ""){
                          ?>
							<a href="<?php echo $file; ?>" target="_blank">Preview Photo</a>
							<?php
                      }
                      ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div style="height:5px;">&nbsp;</div>
		<div class="expand"><a title="expand/collapse" href="#" style="display: block;">PARAMETER UJI DAN HASIL PENGUJIAN</a></div>
		<div class="collapse">
			<div class="accCntnt">

            <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
                <p>Catatan : untuk data parameter uji yang ditolak dapat dilihat pada baris yang diwarnai, dan untuk detail dari penolakan bisa dilihat pada Detail Log Sampel di bawah</p>
            </div>		            
            	
                <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_sampel/<?php echo $sampel[0]['KODE_SAMPEL']; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Catatan Sampel (
                  <?= $jml_log; ?>
                  )</a></h2>
                <div id="detail_log"></div>
            
				<h2 class="small garis">Hasil Uji</h2>
				<table class="form_tabel" width="100%">
					<tr>
						<td class="td_left">Kode Sampel</td>
						<td class="td_right"><?php echo $sampel[0]['UR_KODESAMPEL']; ?></td>
					</tr>
					<tr>
						<td class="td_left">Jumlah sampel yang diterima</td>
						<td class="td_right"><?php echo in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA')) ? $jml[0]['JUMLAH_KIMIA'] : $jml[0]['JUMLAH_MIKRO']; ?>&nbsp; <?php echo $jml[0]['SATUAN']; ?></td>
					</tr>
				</table>
				<?php
                 $jparams = count($sess);
                 if($jparams > 0){
                     for($i=0; $i < $jparams; $i++){
                         ?>
						<div>
							<table class="listtemuan" width="100%" <?php echo $sess[$i]['STATUS'] == '20202' ? 'style="background:#F00; border:1px solid #ccc;"' : ''; ?>>
								<tr style="background:#e7e7e7;">
									<td width="300"><b>Parameter Uji</b></td>
									<td width="100"><b>Metode</b></td>
									<td width="350"><b>Pustaka</b></td>
									<td width="100"><b>Syarat</b></td>
								</tr>
								<tr>
									<td><?php echo $sess[$i]['PARAMETER_UJI']; ?></td>
									<td><?php echo $sess[$i]['METODE']; ?></td>
									<td><?php echo $sess[$i]['PUSTAKA']; ?></td>
									<td><?php echo $sess[$i]['SYARAT']; ?></td>
								</tr>
							</table>
							<table class="form_tabel" <?php echo $sess[$i]['STATUS'] == '20202' ? 'style="background:#F00; border:1px solid #ccc;"' : ''; ?>>
								<tr>
									<td class="td_left">Mulai Diuji </td>
									<td class="td_right"><?php echo $sess[$i]['AWAL_UJI']; ?></td>
									<td></td>
									<td class="td_left">Selesai Diuji</td>
									<td class="td_right"><?php echo $sess[$i]['AKHIR_UJI']; ?></td>
								</tr>
								<tr>
									<td class="td_left">Jumlah Sampel</td>
									<td colspan="4" class="td_right"><div style="padding-bottom:5px;"><span>Diuji </span><span style="margin-left:39px;"> <?php echo $sess[$i]['JUMLAH_UJI']; ?> </span></div></td>
								</tr>
								<tr>
									<td class="td_left">Hasil Kualitatif</td>
									<td class="td_right"><?php echo $sess[$i]['HASIL']; ?></td>
									<td></td>
									<td class="td_left">Hasil Kuantitatif</td>
									<td class="td_right"><?php echo $sess[$i]['HASIL_KUALITATIF']; ?></td>
								</tr>
								<tr>
									<td class="td_left">LCP</td>
									<td class="td_right">
									<?php
									if(trim($sess[$i]['LCP']) != ""){
										?>
											<a href="<?php echo base_url(); ?>files/LCP/<?php echo $kode_sampel; ?>/<?php echo $sess[$i]['LCP']; ?>" target="_blank">Lampiran Data LCP</a>
											<?php
									}
									?>
									</td>
									<td></td>
									<td class="td_left">&nbsp;</td>
									<td class="td_right">&nbsp;</td>
								</tr>
							</table>
							<?php
							if($sess[$i]['STATUS'] == "20202"){
								?>
								<div>
									<p style="padding:3px;"><a href="javascript:;" class="review-params" id="<?php echo $sess[$i]['SPK_ID']; ?>.<?php echo $sess[$i]['UJI_ID']; ?>" url="<?php echo site_url(); ?>/get/pengujian/get_review_params/">Klik Disini Untuk Memperbaiki Data Penolakan</a></p>
								</div>
								<?php
							}
							?>
						</div>
						<div style="height:2px; padding-bottom:4px; padding-top:4px; border-bottom:1px solid #3c7faf">&nbsp;</div>
						<div style="height:10px;">&nbsp;</div>
				<?php
                     }
                 }else{
                    ?>
						<div>Tidak ditemukan data parameter uji dengan kode sampel : <b><?php echo $kode_sampel; ?></b>
					<?php
                 }
                 ?>
				</div>
			</div>
		</div>
		<div style="height:10px;">&nbsp;</div>
		<div style="padding-left:5px;"><a href="#" class="button reload" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
		<div style="height:10px;">&nbsp;</div>
	</div>
</div>
<div id="ctn-review-params"></div>
<script>
	$(document).ready(function(){
		$(".review-params").live("click", function(){
			$.get($(this).attr("url") + "/" + $(this).attr("id"), function(data){
				$("#ctn-review-params").html(data); 
				$("#ctn-review-params").dialog({ 
					title: 'Perbaikan Data Paramater Uji Hasil Pengujian', 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
		});
	});
</script>
