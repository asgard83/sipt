<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f02pr_" id="f02pr_" method="post" action="<?php echo $act; ?>" autocomplete="off"> 
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Informasi Sarana</h2>
                <table class="form_tabel">
                <tr><td class="td_left">Nama Sarana</td><td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:''; ?></td></tr>
                <tr><td class="td_left">Nama Pemilik </td><td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:'';?></td></tr>
                <tr><td class="td_left">Alamat</td><td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:'';?></td></tr>
                <tr><td class="td_left">Izin Usaha</td><td class="td_right"><?php echo array_key_exists('IZIN_PERUSAHAAN', $sess)?$sess['IZIN_PERUSAHAAN']:'';?></td></tr>
                </table>
                <h2 class="small">Informasi Petugas Pemeriksa</h2>
                <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                <div style="height:5px;"></div>
                <h2 class="small">Informasi Pemeriksaan</h2>
                <table class="form_tabel">
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
                <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[TUJUAN_PEMERIKSAAN]', $tujuan_pemeriksaan, $sess['TUJUAN_PEMERIKSAAN'], 'class="stext" id="F02PR_tujuan" rel="required" title="Tujuan Pemeriksaan"'); ?></td></tr>
                </table>
                
				</div>
        </div><!-- Akhir Informasi Sarana !-->
        
        <div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
				<input type="hidden" value="0" id="flag">
                <table id="F02PR_tbtms" class="form_tabel">
                <tr><td class="td_left">Nama produk</td><td class="td_right"><input type="text" class="stext" id="F02PR_nama_produk" name="F02PR_nama_produk" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/3" title="Nama Produk" /></td></tr>
                <tr><td class="td_left"> Produsen/Importir</td><td class="td_right"><input type="text" id="F02PR_produsen_importir" name="F02PR_produsen_importir" class="stext" title="Nama Produk atau Importir" /></td></tr>
                <tr><td class="td_left">Nomor Registrasi</td><td class="td_right"><input type="text" name="F02PR_no_registrasi" id="F02PR_no_registrasi" class="stext" title="Nomor Registrasi produk" /></td></tr>
	                <tr><td class="td_left">Registrasi Produk</td><td class="td_right"><select class="stext" name="F02PR_reg_produk" id="F02PR_reg_produk" title="Jenis Registrasi Produk"><option value="MD">MD</option><option value="ML">ML</option><option value="PIRT">PIRT</option><option value="SP">SP</option><option value="Tidak Terdaftar">Tidak Terdaftar</option></select></td></tr>
                <tr><td class="td_left">Jumlah Kemasan Terkecil</td><td class="td_right"><input type="text" id="F02PR_jumlah_kemasan" class="scode" name="F02PR_jumlah_kemasan" title="Jumlah kemasan terkecil" onkeyup="numericOnly($(this))" />&nbsp;<select name="F02PR_satuan" id="F02PR_satuan" class="sel_penyimpangan" title="Pilih salah satu"><option value="Buah/Pieces">Buah/Pieces</option><option value="Sachet">Sachet</option><option value="Bungkus">Bungkus</option><option value="Botol">Botol</option><option value="Kaleng">Kaleng</option><option value="Karton">Karton</option><option value="Cup">Cup</option><option value="Lainnya">Lainnya</option></select>&nbsp;<input type="text" class="sdate" id="F02PR_satuan_lain" style="display:none;" value="-"/></td></tr>
                <tr><td class="td_left">Kategori Temuan</td><td class="td_right"><select name="F02PR_kategori_temuan" id="F02PR_kategori_temuan" class="stext" title="Kategori temuan"><option value="TIE (Tanpa Izin Edar)">TIE (Tanpa Izin Edar)</option><option value="Rusak">Rusak</option><option value="ED (Expire Date / Kedaluwarsa)">ED (Expire Date / Kedaluwarsa)</option><option value="TMK Label">TMK Label</option></select></td></tr>
                <tr><td class="td_left">Perkiraan harga total</td><td class="td_right"><input type="text" id="F02PR_harga" class="sdate" name="F02PR_harga" title="Perkiraan harga total" onkeyup="numericOnly($(this))" /></td></tr>
                <tr><td class="td_left">Klasifikasi</td><td class="td_right"><?php echo form_dropdown('F02PR_klasifikasi',$klasifikasi_produk,'','class="stext" id="F02PR_klasifikasi" title="Klasifikasi Pengawasan"'); ?></td></tr>
                </table>
                <div style="height:5px;"></div>
                <div class="btn"><span><a href="#" id="F02PR_add_temuan">Tambah Temuan</a></span></div>
                <div style="padding-bottom:5px;"></div>
                <table width="99%;" id="F02PR_tabel_pangan" cellpadding="0" cellspacing="0" class="listtemuan">
                    <thead style="background:#CCC; color:#3c7faf;"><tr>
                    <th>Produsen / Importir</th>
                    <th>Nama Produk</th>
                    <th>Detil Produk</th>
                    <th>Klasifikasi</th>
                    <th>Kategori Temuan</th>
                    </tr></thead>
                    <tbody id="F02PR_bod_pangan"></tbody>
                    <?php
					    if(!$temuan_produk==''){
							if($sess['JUMLAH_TEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                                    <tr id="<?php echo $temuan_produk[$i]['SERI']; ?>"><td><?php echo $temuan_produk[$i]['PRODUSEN']; ?><input type="hidden" name="TEMUAN_PRODUK[PRODUSEN][]" value="<?php echo $temuan_produk[$i]['PRODUSEN']; ?>"></td><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>"></td><td>Registrasi Produk : <?php echo $temuan_produk[$i]['REGISTRASI']; ?><input type="hidden" name="TEMUAN_PRODUK[REGISTRASI][]" value="<?php echo $temuan_produk[$i]['REGISTRASI'];?>"><br>Nomor Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?><input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="<?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?>"><br>Jumlah Kemasan Terkecil : <?php echo $temuan_produk[$i]['KEMASAN'];?><input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="<?php echo $temuan_produk[$i]['KEMASAN'];?>"><br>Satuan : <?php echo $temuan_produk[$i]['SATUAN'];?><input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="<?php echo $temuan_produk[$i]['SATUAN'];?>"><br>Perkiraan Harga Total : <?php echo $temuan_produk[$i]['HARGA'];?><input type="hidden" name="TEMUAN_PRODUK[HARGA][]" value="<?php echo $temuan_produk[$i]['HARGA'];?>"></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_TEMUAN'];?><input type="hidden" value="<?php echo $temuan_produk[$i]['KLASIFIKASI_TEMUAN'];?>" name="TEMUAN_PRODUK[KLASIFIKASI_TEMUAN][]"></td><td><?php echo $temuan_produk[$i]['KATEGORI'];?><input type="hidden" value="<?php echo $temuan_produk[$i]['KATEGORI'];?>" name="TEMUAN_PRODUK[KATEGORI][]"><span style="float:right;"><a href="#" class="del_temuan"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>
                                    <?php
								}
							}
							
						}
					?>
                </table>
                </div>
        </div><!-- Akhir Temuan Produk !-->

		<div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN dan TINDAKAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Kesimpulan dan Tindakan</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[HASIL]',$hasil,$sess['HASIL'],'class="stext" rel="required" title="Pilih salah satu hasil pemeriksaan"'); ?></td></tr>
                    <tr><td class="td_left">Tindakan Terhadap Produk</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[TINDAKAN][]',$tindakan_sarana,explode("#",$sess['TINDAKAN']),'class="stext multiselect" multiple title="Tindakan terhadap produk, jika lebih dari salah satu tekan klik + Ctrl"'); ?></td></tr>
                </table>
                </div>
        </div>

        <?php
		if(!array_key_exists('PERIKSA_ID', $sess)){
		?>
        <div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN KLASIFIKASI KOMODITI LAIN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Klasifikasi Komoditi Lain</h2>
                <table class="form_tabel">
                	<tr><td class="td_left">Jenis Temuan</td><td class="td_right"><?php echo form_dropdown('cb_konfirm', $this->config->item('konfirmasi'), '', 'id="cb_konfirm" class="stext" title="Pilih salah satu jenis temuan" onchange="sel_konfirmasi($(this));"'); ?></td></tr>
                    <tr id="tr_jenis_sarana" style="display:none;"><td class="td_left">Jenis Sarana</td><td class="td_right"><?php echo form_dropdown('jns', $jenis_sarana, '', 'id="jns" class="stext" url="'.site_url().'/get/pemeriksaan/set_klasifikasi_sarana/" onchange="get_klasifikasi($(this));" title="Pilih salah satu jenis sarana"', $disinput); ?></td></tr>
                    <tr id="tr_jenis_klasifikasi" style="display:none;"><td class="td_left">Jenis Klasifikasi</td><td class="td_right"><?php echo form_dropdown('kk', $klasifikasi_kategori, '', 'id="kk" class="stext" title="Pilih salah satu jenis klasifikasi"'); ?></td>
                    </tr>
                </table>
                </div>
        </div><!-- Akhir Temuan Pemeriksaan !-->
        <?php
		}
		if($stat=="20102" || $stat=="20103" || $stat=="20113" || $stat=="20112" || $stat=="60020"){ ?>
		<div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[STATUS]',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>
                
                <div style="padding-top:5px;">
                      <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan</a></h2>
                      <div id="detail_log"></div>
                </div> 
                
                </div>
        </div><!-- Akhir Verifikasi !-->        
        <?php
		}
		?>
     </div>
</div>   

<div id="clear_fix"></div>
<div><a href="#" class="button save" onclick="fpost('#f02pr_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<div id="clear_fix"></div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	create_ck("textarea.chk",505)
	$("#detail_petugas").html("Loading ...");
	$("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#F02PR_nama_produk").autocomplete($("#F02PR_nama_produk").attr('url'), {width: 244, selectFirst: false});
	$("#F02PR_nama_produk").result(function(event, data, formatted){
		if(data){
			$(this).val(data[1]);
			$("#F02PR_no_registrasi").val(data[2]);
			$("#F02PR_produsen_importir").val(data[6]);
			$("#flag").val('1');
		}
	});
	$("#F02PR_add_temuan").click(function(){if(!beforeSubmit("#F02PR_tbtms")){ return false; } else { var satuan;if($("#F02PR_satuan").val() != "Lainnya"){ satuan = $("#F02PR_satuan option:selected").text();}else{satuan = $("#F02PR_satuan_lain").val();} var id = $('#F02PR_bod_pangan tr').length; $("#F02PR_bod_pangan").append('<tr id="'+(id+1)+'"><td>'+$("#F02PR_produsen_importir").val()+'<input type="hidden" name="TEMUAN_PRODUK[PRODUSEN][]" value="'+$("#F02PR_produsen_importir").val()+'"></td><td>'+$("#F02PR_nama_produk").val()+'<input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="'+$("#F02PR_nama_produk").val()+'"></td><td>Registrasi Produk : '+$("#F02PR_reg_produk option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[REGISTRASI][]" value="'+$("#F02PR_reg_produk").val()+'"><br>Nomor Registrasi : '+$("#F02PR_no_registrasi").val()+'<input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="'+$("#F02PR_no_registrasi").val()+'"><br>Jumlah Kemasan Terkecil : '+$("#F02PR_jumlah_kemasan").val()+'<input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="'+$("#F02PR_jumlah_kemasan").val()+'"><br>Satuan : '+satuan+'<input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="'+$("#F02PR_satuan").val()+'"><br>Perkiraan Harga Total : '+$("#F02PR_harga").val()+'<input type="hidden" name="TEMUAN_PRODUK[HARGA][]" value="'+$("#F02PR_harga").val()+'"></td><td>'+$("#F02PR_klasifikasi option:selected").text()+'<input type="hidden" value="'+$("#F02PR_klasifikasi").val()+'" name="TEMUAN_PRODUK[KLASIFIKASI_TEMUAN][]"></td><td>'+$("#F02PR_kategori_temuan option:selected").text()+'<input type="hidden" value="'+$("#F02PR_kategori_temuan").val()+'" name="TEMUAN_PRODUK[KATEGORI][]"><input type="hidden" name="TEMUAN_PRODUK[FLAG][]" value="'+$("#flag").val()+'"><span style="float:right;"><a href="#" class="del_temuan"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Batalkan atau hapus temuan produk" /></a></span></td></tr>'); clearForm("#F02PR_tbtms"); $("#flag").val('0');$("#F02PR_satuan_lain").val('-'); return false;}});
	$(".del_temuan").live("click", function(){id = $(this).closest("table tr").attr("id"); $("table #"+id).remove();return false;});
	$("#F02PR_satuan").change(function(){if($(this).val() == "Lainnya"){$("#F02PR_satuan_lain").show();}else{$("#F02PR_satuan_lain").hide();}});
	
});
</script>
