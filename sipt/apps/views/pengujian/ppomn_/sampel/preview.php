<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <form name="fnewsampel" id="fnewsampel" method="post" action="<?php echo $act; ?>" autocomplete="off">
	<input type="hidden" name="periksa_sampel" value="<?php echo $periksa_sampel; ?>" />
	<input type="hidden" name="kode_sampel" value="<?php echo $kode_sampel; ?>" />
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN SAMPEL</a></div>
            <div class="collapse">
                <div class="accCntnt">
                    <h2 class="small garis">Data Pemeriksaan Sampel</h2>
					<table class="form_tabel">
						<tr>
						  <td class="td_left">Nomor Surat Tugas </td>
						  <td class="td_right"><input type="text" class="stext" title="Nomor Surat Tugas" name="SURAT[NOMOR_SURAT]" value="<?php echo $sess['NOMOR_SURAT']; ?>" rel="required" id="nomor_surat" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_surat" /><input type="hidden" name="surat_id" id="surat_id" value="<?php echo $sess['PERIKSA_SAMPEL']; ?>" /></td><td width="10"></td>
						  <td class="td_left">Asal Sampel </td><td class="td_right"><?php echo form_dropdown('SAMPEL[ASAL_SAMPEL]',$asal,$sess['ASAL_SAMPEL'],'class="stext" title="Asal Sampel" id="asal_sampling" rel="required"'); ?></td></tr>
						<tr>
						  <td class="td_left">Tanggal Surat Tugas </td>
						  <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Tugas" name="SURAT[TANGGAL_SURAT]" rel="required" id="tanggal_surat" value="<?php echo $sess['TANGGAL_SURAT']; ?>" /></td>
						  <td></td>
						  <td class="td_left">Tujuan Sampling </td>
						  <td class="td_right"><?php echo form_dropdown('SAMPEL[TUJUAN_SAMPLING]',$tujuan,$sess['TUJUAN_SAMPLING'],'class="stext" title="Tujuan Sampling" rel="required"'); ?></td>
					  </tr>
						<tr>
						  <td class="td_left">Anggaran Sampling </td>
						  <td class="td_right"><?php echo form_dropdown('SAMPEL[ANGGARAN]',$anggaran,$sess['ANGGARAN'],'class="stext" rel="required" title="Anggaran Sampling" id="anggaran_sampling"'); ?></td>
						  <td></td>
						  <td class="td_left">Tanggal Sampling </td>
						  <td class="td_right"><input type="text" class="sdate" title="Tanggal Sampling" name="SAMPEL[TANGGAL_SAMPLING]" rel="required" value="<?php echo $sess['TANGGAL_SAMPLING']; ?>" /></td>
					  </tr>
						<tr>
						  <td class="td_left">Bulan Anggaran Sampling </td>
						  <td class="td_right"><?php echo form_dropdown('SAMPEL[BULAN_ANGGARAN]',$bulan, $sess['BULAN_ANGGARAN'],'class="stext" rel="required" title="Bulan Anggaran" id="bulan"'); ?></td>
						  <td></td>
						  <td class="td_left">Tempat Sampling </td>
						  <td class="td_right"><input type="text" class="stext" name="SAMPEL[TEMPAT_SAMPLING]" value="<?php echo $sess['TEMPAT_SAMPLING']; ?>" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" rel="required"/><input type="hidden" id="saranaidval_" name="SAMPEL[SARANA_ID]" value="<?php echo $sess['SARANA_ID']; ?>"/></td>
					  </tr>
						<tr id="tr_petugas1">
						  <td class="td_left">&nbsp;</td>
						  <td class="td_right">&nbsp;</td>
						  <td></td>
						  <td class="td_left">Petugas Sampling </td>
						  <td class="td_right">
						  <input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." /><ul style="list-style:none; margin:0px; padding:0px;" id="petugas"></ul>
						</td>
					  </tr>
						<tr id="tr_petugas">
						  <td class="td_left">&nbsp;</td>
						  <td class="td_right">&nbsp;</td>
						  <td></td>
						  <td class="td_left">&nbsp;</td>
						  <td class="td_right">
						  <?php 
						  if($kode_sampel != ""){
						  	?>
						  	<ul style="list-style:none; margin:0px; padding:0px;" id="urut0">
							<?php
								$jmlpetugas = count($user_id);
								for($i=0;$i<$jmlpetugas;$i++){
									?>
									<li style="padding-bottom:5px;" id="<?php echo $user_id[$i]; ?>"><input type="text" class="stext" value="<?php echo $nama_user[$i]; ?>" title="Nama Petugas" readonly>&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$('ul#urut0 li#<?php echo $user_id[$i]; ?>').remove();" /></a><input type="hidden" name="USER_ID[]" value="<?php echo $user_id[$i]; ?>"></li>
									<?php
								}
								?>
						  	</ul>
							<?php
						  }else{
						  	?>
						  		<ul style="list-style:none; margin:0px; padding:0px;" id="urut0"></ul>
							<?php
						  }
						  ?>
						  </td>
					  </tr>
					</table>
                </div>
            </div>
			
            <div style="height:5px;">&nbsp;</div>
			<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA PENGIRIM</a></div>
			<div class="collapse">
			<div class="accCntnt">
				<div class="pihak-3-swasta-pemerintah">
					<h2 class="small garis">Data Pengirim Sampel</h2>
					<table class="form_tabel">
						<tr>
						  <td class="td_left">Nama Pengirim</td>
						  <td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_rutin" id="nama_pengirim" value="<?php echo $sess['NAMA_PENGIRIM']; ?>"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" /></td><td width="10"></td>
						  <td class="td_left">NIP</td><td class="td_right"><input type="text" class="stext" title="NIP" name="nip_rutin" id="nip_rutin" value="<?php echo $sess['NIP_PENGIRIM'];?>" /></td>
					  </tr>
					</table>
				</div>
				<div class="pihak-3-polisi" style="display:none;">
					<h2 class="small garis">Data Pengirim Pihak Ke 3 Kepolisian</h2>
					<table class="form_tabel" id="dt-pengirim">
					<tr><td class="td_left">Nama Pengirim</td><td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_polisi" value="<?php echo $sess['NAMA_PENGIRIM']; ?>" /></td></tr>
					<tr><td class="td_left">NIP / NRP</td><td class="td_right"><input type="text" class="stext" title="NIP / NRP" name="nip_polisi" value="<?php echo $sess['NIP_POLISI']; ?>" /></td></tr>
					<tr><td class="td_left">Pangkat</td><td class="td_right"><input type="text" class="stext" title="Pangkat" name="SURAT[PANGKAT]" value="<?php $sess['PANGKAT']; ?>" /></td></tr>
					<tr><td class="td_left">Alamat Kepolisian</td><td class="td_right"><input type="text" class="stext" title="Alamat Kepolisian" name="SURAT[INSTITUSI]" value="<?php echo $sess['INSTITUSI']; ?>" /></td></tr>
					<tr><td class="td_left">No. LP</td><td class="td_right"><input type="text" class="stext" title="No. LP" name="SURAT[NO_LP]" value="<?php echo $sess['NO_LP']; ?>" /></td></tr>
					<tr><td class="td_left">Tanggal LP</td><td class="td_right"><input type="text" class="sdate" title="Tanggal LP" name="SURAT[TANGGAL_LP]" value="<?php echo $sess['TANGGAL_LP']; ?>" /></td></tr>
					<tr><td class="td_left">No. SPDP</td><td class="td_right"><input type="text" class="stext" title="Surat Pemberitahuan Dimulainya Penyidikan" name="SURAT[NO_SPDP]" value="<?php echo $sess['NO_SPDP']; ?>" /></td></tr>
					<tr><td class="td_left">Tanggal SPDP</td><td class="td_right"><input type="text" class="sdate" title="Tanggal SPDP" name="SURAT[TANGGAL_SPDP]" value="<?php echo $sess['TANGGAL_SPDP']; ?>" /></td></tr>
					<tr><td class="td_left">Nama Tersangka</td><td class="td_right"><input type="text" class="stext" title="Nama Tersangka, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[NAMA_TERSANGKA]" value="<?php echo $sess['NAMA_TERSANGKA']; ?>" /></td></tr>
					<tr><td class="td_left">Kota</td><td class="td_right"><input type="text" class="stext" title="Kota" name="SURAT[KOTA]" value="<?php echo $sess['KOTA']; ?>" /></td></tr>
					<tr><td class="td_left">Nama Saksi</td><td class="td_right"><input type="text" class="stext" title="Saksi, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[SAKSI_POLISI]" value="<?php echo $sess['SAKSI_POLISI']; ?>" /></td></tr>
					<tr><td class="td_left">Tanggal Terima</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Terima" name="SURAT[TANGGAL_TERIMA]" value="<?php echo $sess['TANGGAL_TERIMA']; ?>" /></td></tr>
					<tr><td class="td_left">Hari Terima</td><td class="td_right"><input type="text" class="stext" title="Hari Terima" name="SURAT[HARI_TERIMA]" value="<?php echo $sess['HARI_TERIMA']; ?>" /></td></tr>
					<tr><td class="td_left">Saksi Pengujian</td><td class="td_right"><input type="text" class="stext" title="Saksi Pengujian, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[SAKSI_UJI]" value="<?php echo $sess['SAKSI_UJI']; ?>" /></td></tr>
					<tr><td class="td_left">Jumlah Sampel Di Surat Permintaan Uji</td><td class="td_right"><input type="text" class="stext w100" title="jumlah" name="SURAT[JUMLAH_UJI]" value="<?php echo $sess['JUMLAH_UJI']; ?>" /></td></tr>
					<tr><td class="td_left">Catatan</td><td class="td_right"><textarea class="stext" name="SURAT[CATATAN]" title="Catatan atau keterangan"><?php echo $sess['CATATAN_SURAT']; ?></textarea></td></tr>
					</table>
				</div>
				
				<div class="biaya-pihak-ke-3" style="display:none;">
				  <table class="form_tabel">
					  <tr><td class="td_left">Biaya</td><td class="td_right"><input type="text" class="stext w100" title="Biaya" name="SURAT[BIAYA]" value="<?php echo $sess['BIAYA']; ?>" /></td></tr>                        
					  <tr><td class="td_left">No. Resi Bank</td><td class="td_right"><input type="text" class="stext" title="No. Resi Bank" name="SURAT[NO_RESI_BANK]" value="<?php echo $sess['NO_RESI_BANK']; ?>" /></td></tr>
					  <tr><td class="td_left">Tanggal Resi Bank</td><td class="td_right"><input type="text" class="sdate" title="Tanggal Resi" name="SURAT[TANGGAL_RESI_BANK]" value="<?php echo $sess['TANGGAL_RESI_BANK']; ?>" /></td></tr>
				  </table>
				</div>
			</div>	
			</div>
			
			<div style="height:5px;">&nbsp;</div>
			<div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA SAMPEL</a></div>
			<div class="collapse">
			<div class="accCntnt">
				<h2 class="small garis">Data Sampel</h2>
				<table class="form_tabel">
					<tr><td class="td_left">Komoditi</td><td class="td_right">
					<?php
					if($kode_sampel == ""){
						echo form_dropdown('KOMODITI[]',$komoditi,$sess['KOMODITI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); 
					}else{
						echo "<b>".$sess['KO']."</b>";
					}
					?></td><td width="10"></td>
					<td class="td_left">Kategori Tambahan</td>
					<td class="td_right"><?php echo form_dropdown('SAMPEL[KLASIFIKASI_TAMBAHAN]',$klasifikasi_tambahan,$sess['KLASIFIKASI_TAMBAHAN'],'class="stext" title="Komoditi" id="kk_tambahan"'); ?></td></tr>
					<tr><td class="td_left">Nama sampel</td><td class="td_right"><input type="text" class="stext" title="Nama sampel" name="SAMPEL[NAMA_SAMPEL]" id="nama_sampel" rel="required" value="<?php echo $sess['NAMA_SAMPEL'];?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/"/><input type="hidden" id="klasifikasi" value="<?php echo $sess['KOMODITI']; ?>" /></td><td width="10"></td><td class="td_left">No Registrasi</td><td class="td_right"><input type="text" class="stext" title="Nomor Registrasi" name="SAMPEL[NOMOR_REGISTRASI]" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" id="nie" /></td></tr>
					<tr id="tdanak2" ke="2">
					  <td class="td_left">Kategori sampel</td>
					  <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sel[1],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2"'); ?></td><td width="10"></td>
					  <td class="td_left">&nbsp;</td><td class="td_right">&nbsp;</td>
					</tr>
					<tr <?php echo strlen($sel[1]) == 7 ? 'class="hideme"' : ''; ?> id="tdanak3" ke="3">
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sel[2],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td>
					  <td></td>
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right">&nbsp;</td>
				  </tr>
					<tr <?php echo strlen($sel[2]) == 9 ? '' : 'class="hideme"'; ?> id="tdanak4" ke="4">
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sel[3],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel4" ke="4"'); ?></td>
					  <td></td>
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right">&nbsp;</td>
				  </tr>
					<tr <?php echo strlen($sel[3]) == 11 ? '' : 'class="hideme"'; ?> id="tdanak5" ke="5">
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[3]) ? $selkategori[3] : '',$sel[4],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel5" ke="5"'); ?></td>
					  <td></td>
					  <td class="td_left">&nbsp;</td>
					  <td class="td_right">&nbsp;</td>
				  </tr>
					<tr><td class="td_left">Pabrik</td><td class="td_right"><input type="text" class="stext" title="Nama Pabrik" name="SAMPEL[PABRIK]" value="<?php echo $sess['PABRIK']; ?>" id="pabrik" /></td><td width="10"></td><td class="td_left">Importir</td><td class="td_right"><input type="text" class="stext" name="SAMPEL[IMPORTIR]" title="Importir" id="pemilik" value="<?php echo $sess['IMPORTIR']; ?>" /></td></tr>                    	
					<tr><td class="td_left">Bentuk Sediaan sampel</td><td class="td_right"><input type="text" class="stext" title="Bentuk Sediaan Sampel / sampel" name="SAMPEL[BENTUK_SEDIAAN]" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" id="bentuk" /></td><td width="10"></td><td class="td_left">Kemasan sampel</td><td class="td_right"><input type="text" class="stext" title=" Kemasan Sampel / sampel" name="SAMPEL[KEMASAN]" value="<?php echo $sess['KEMASAN']; ?>" id="kemasan" /></td></tr>
					<tr><td class="td_left">No Bets</td><td class="td_right"><input type="text" name="SAMPEL[NO_BETS]" class="stext" title="Nomor Bets" value="<?php echo $sess['NO_BETS']; ?>" /></td><td width="10"></td><td class="td_left">Keterangan ED</td><td class="td_right"><input type="text" class="sdate" title="Expire Date" name="SAMPEL[KETERANGAN_ED]" value="<?php echo $sess['KETERANGAN_ED']; ?>" /></td></tr>
					<tr><td class="td_left">Komposisi</td><td class="td_right"><textarea class="stext" style="height:80px; resize:none;" name="SAMPEL[KOMPOSISI]" title="Komposisi sampel. Jika lebih dari satu, pisahkan dengan titik koma"><?php echo $sess['KOMPOSISI']; ?></textarea></td><td width="10"></td><td class="td_left">Netto</td><td class="td_right"><input type="text" class="stext w100" title="Netto" name="SAMPEL[NETTO]" value="<?php echo $sess['NETTO']; ?>" /></td></tr>
					<tr><td class="td_left">Evaluasi Penandaan</td><td class="td_right"><input type="text" class="stext" title="Evaluasi Penandaan, Misal : Tidak dicantumkan nomor reg, nomor reg lama" name="SAMPEL[EVALUASI_PENANDAAN]" value="<?php echo $sess['EVALUASI_PENANDAAN']; ?>" /></td><td width="10"></td><td class="td_left">Cara Penyimpanan</td><td class="td_right"><input type="text" class="stext" title="Sesuai dengan keterangan yang ada di label" name="SAMPEL[CARA_PENYIMPANAN]" value="<?php echo $sess['CARA_PENYIMPANAN']; ?>" /></td></tr>
					<tr><td class="td_left">Kondisi sampel</td><td class="td_right"><?php echo form_dropdown('SAMPEL[KONDISI_SAMPEL]',$kondisi_sampel,$sess['KONDISI_SAMPEL'],'class="stext" title="Kondisi sampel" rel="required"'); ?></td><td width="10"></td><td class="td_left">Jumlah sampel</td><td class="td_right"><input type="text" class="scode" id="jumlah" title="Jumlah sampel" rel="required" value="<?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>" name="SAMPEL[JUMLAH_SAMPEL]"/>&nbsp;&nbsp;<?php echo form_dropdown('SAMPEL[SATUAN]',$satuan,$sess['SATUAN'],'class="stext sjenis" title="Satuan" rel="required"'); ?></td></tr>
					<tr>
					  <td class="td_left">Pengujian</td>
					  <td class="td_right"><div style="padding-bottom:5px;"><input type="checkbox" name="lab[]" class="chklab" id="kimia" onchange="check_uji('#kimia', '#jml_kimia');" value="K" <?php echo $sess['UJI_KIMIA'] > 0 ? 'checked="checked"' : ''; ?> />&nbsp;Kimia&nbsp;<input type="text" class="scode jml" title="Pengujian Kimia" id="jml_kimia" value="<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?>" name="SAMPEL[JUMLAH_KIMIA]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> /></div><div style="padding-bottom:5px;"><input type="checkbox" class="chklab" name="lab[]" id="mikro" onchange="check_uji('#mikro', '#jml_mikro');" value="M" <?php echo $sess['UJI_MIKRO'] > 0 ? 'checked="checked"' : ''; ?>/>&nbsp;Mikro&nbsp;<input type="text" class="scode jml" title="Pengujian Mikro" name="SAMPEL[JUMLAH_MIKRO]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> id="jml_mikro" value="<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?>" onkeyup="numericOnly($(this))" /></div>
					  <div>Retain&nbsp;
					    <input type="text" class="scode" id="sisa" title="Sisa (retain) sampel " name="SAMPEL[SISA]" readonly="readonly" value="<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?>" onkeyup="numericOnly($(this))" /></div></td>
					  <td></td>
					  <td class="td_left">Harga Pembelian</td>
					  <td class="td_right"><input type="text" class="stext w100" title="Harga Pembelian" name="SAMPEL[HARGA_SAMPEL]" rel="required" value="<?php echo $sess['HARGA_SAMPEL']; ?>" onkeyup="numericOnly($(this))"/></td>
				  </tr>
					<tr>
					  <td class="td_left">Catatan</td><td class="td_right"><textarea class="stext" title="Catatan" name="SAMPEL[CATATAN]"><?php echo $sess['CATATAN SAMPEL']; ?></textarea></td><td width="10"></td>
					  <td class="td_left">Lampiran File</td><td class="td_right"><input type="file" class="stext" title="Lampiran File : file photo dan lain-lain" /></td></tr>
				</table>
			</div>
			</div>
			
			<?php
			if($kode_sampel!=""){
			?>
			<div style="height:5px;">&nbsp;</div>
			<div class="expand"><a title="expand/collapse" href="#" style="display: block;">LOG SAMPEL</a></div>
			<div class="collapse">
				<div class="accCntnt">
					<h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_sampel/<?php echo $kode_sampel; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Sampel (<?= $jml_log; ?>)</a></h2>
					<div id="detail_log"></div>
				</div>
			</div>
			<?php
			}
			?>
        </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fnewsampel','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $caption; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="javascript:history.back();"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false}); 
	$("#saranaid_").result(function(event, data, formatted){ 
		if(data){ 
			$(this).val(data[2]);
			$("#saranaidval_").val(data[1]); 
			$("#input.operator").focus();
		} 
	});
	$("input.operator").autocomplete($("input.operator").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("input.operator").result(function(event, data, formatted){ 
		if(data){ 
			$("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly title="Nama Petugas">&nbsp;&nbsp;<a href="#"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); 
			$(this).val(''); $(this).focus(); 
		} 
	});
	
	$("#nomor_surat").autocomplete($("#nomor_surat").attr("url"), {width: 244, selectFirst: false}); 
	$("#nomor_surat").result(function(event, data, formatted){ 
		if(data){ 
			$(this).val(data[2]);
			$("#surat_id").val(data[1]); 
			$("#tanggal_surat").val(data[3]);
			$("#anggaran_sampling").val(data[4]);
			$.get(isUrl + 'index.php/autocompletes/autocomplete/petugas_sampling/' + data[1], function(hasil){
				hasil = $.trim(hasil);
				if(hasil==""){
					$("#operator").css("display","");
					$("tr#tr_petugas").css("display","");
					$("ul#petugas").html('');
					return false;
				}else{
					var str = "";
					var arrcol = hasil.split(';');
					for(i=0;i<arrcol.length;i++){
						var arrdata = arrcol[i].split('|');
						str += '<li style="padding-bottom:5px;" id="'+arrdata[0]+'">'+arrdata[1]+'<input type="hidden" name="USER_ID[]" value="'+arrdata[1]+'"></li>'
					}
					$("#operator").css("display","none");
					$("tr#tr_petugas").css("display","none");
					$("ul#petugas").append(str);
				}
			});
		} 
	});
	
	$("#nama_pengirim").autocomplete($("#nama_pengirim").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("#nama_pengirim").result(function(event, data, formatted){ 
		if(data){
			$(this).val(data[2]);
			$("#nip_rutin").val(data[1]);
		} 
	});
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
	$("#anggaran_sampling").change(function(){
		var val = $(this).val();
		if(val == "05"){
			$(".pihak-3-polisi").css("display","");
			$(".pihak-3-swasta-pemerintah").css("display","none");
		}else{
			$(".pihak-3-polisi").css("display","none");
			$(".pihak-3-swasta-pemerintah").css("display","");
		}
		if(val == "05" || val == "06" || val == "07"){
			$(".biaya-pihak-ke-3").css("display","");
			$(".surat").html('Tanggal Surat Pengantar');
			$(".petugas").html('Petugas Penerima Sampel');
			$(".nomor").html('Nomor Surat Pengantar');
		}else{
			$(".biaya-pihak-ke-3").css("display","none");
			$(".surat").html('Tanggal Surat Tugas');
			$(".petugas").html('Petugas Sampling');
			$(".nomor").html('Nomor Surat Tugas');
		}
		return false;
	});
	$('select.komoditi').change(function(){
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		if(ke == 1){
			$(this).attr("klas",kunci);
			$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kk_tambahan/'; ?>' + kunci, function(hasil){
				var hasil = hasil.replace(' ', '');
				var jum = hasil.length;
				if(jum==0){
					$('#kk_tambahan').html();
				}else{
					$('#kk_tambahan').html(hasil);
				}
			});
			$('tr.hideme').hide();
		}
		ke = parseInt(ke) + 1;
		for(i=ke;i<=5;i++){
			$('#sel' + ke).html();
		}
		$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci, function(hasil){
			var hasil = hasil.replace(' ', '');
			var jum = hasil.length;
			if(jum == 0 || kunci == 00){
				$('#tdanak' + ke).hide();
				$('#sel' + ke).html('');
			}else{
				$('#tdanak' + ke).show();
				$('#sel' + ke).html(hasil);
			}
		});
	});
	$("#nama_sampel").autocomplete($("#nama_sampel").attr('url') + $("#sel1").attr("klas"), {width: 244, selectFirst: false});
	$("#nama_sampel").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#nie").val(data[2]);
			$("#kemasan").val(data[4]);
			$("#pemilik").val(data[7]);
			$("#pabrik").val(data[6]);
			$("#bentuk").val(data[9]);
		}
	});
	$("#jml_kimia").change(function(){
		var jml = parseInt($("#jml_mikro").val()) + parseInt($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseInt($("#jumlah").val()) == 0) return false;
		sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_mikro").val()) + parseInt($(this).val()));		
		if(parseInt($("#jml_kimia").val()) + sisa > parseInt($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
		}
		if(jml > parseInt($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
			$("#jml_kimia").val('0');
			sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_mikro").val()) + parseInt($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseInt(sisa));
	});
	$("#jml_mikro").change(function(){
		var jml = parseInt($("#jml_mikro").val()) + parseInt($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseInt($("#jumlah").val()) == 0) return false;
		sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($(this).val()));
		if(parseInt($("#jml_mikro").val()) + sisa > parseInt($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
		}
		if(jml > parseInt($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
			$("#jml_mikro").val('0');
			sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseInt(sisa));
	});	
});

function check_uji(obj, next){
	var jml = $("#jumlah").val();
	if($(obj).is(':checked')){
		if(jml > 0){
			$(next).attr("readonly", "");
			$(next).focus();
		}
	}else{
		$(next).attr("readonly", "readonly");
		$(next).val('0');
	}
	sisa = parseInt($("#jumlah").val()) - (parseInt($("#jml_kimia").val()) + parseInt($("#jml_mikro").val()));
	$("#sisa").val(parseInt(sisa));
}

</script>            