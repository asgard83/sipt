<?php 
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
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?>&nbsp; sampai dengan &nbsp;<?php echo $sess['AKHIR_PERIKSA']; ?></td></tr>
                <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td></tr>
                </table>
                </div>
        </div><!-- Akhir Informasi Sarana !-->
        
        <div style="height:5px;"></div>

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan Produk</h2>
                <table width="99%;" cellpadding="0" cellspacing="0" class="listtemuan">
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
                                    <tr><td><?php echo $temuan_produk[$i]['PRODUSEN']; ?></td><td><?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?></td><td>Registrasi Produk : <?php echo $temuan_produk[$i]['REGISTRASI']; ?><br>Nomor Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI'];?><br>Jumlah Kemasan Terkecil : <?php echo $temuan_produk[$i]['KEMASAN'];?><br>Satuan : <?php echo $temuan_produk[$i]['SATUAN'];?><br>Perkiraan Harga Total : <?php echo $temuan_produk[$i]['HARGA'];?></td><td><?php echo $temuan_produk[$i]['KLASIFIKASI_TEMUAN'];?></td><td><?php echo $temuan_produk[$i]['KATEGORI'];?></td></tr>
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
                <?php
				if($isEditTLBalai){
				?>
                <table class="form_tabel">
                	<tr><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo form_dropdown($obj_pangan.'[HASIL]',$hasil,$sess['HASIL'],'class="stext" title="Pilih salah satu hasil pemeriksaan"'); ?></td></tr>
                    <tr><td class="td_left">Tindakan Terhadap Produk</td><td class="td_right"><?php echo form_dropdown($obj_pangan.'[TINDAKAN][]',$tindakan_sarana,explode("#",$sess['TINDAKAN']),'class="stext multiselect" multiple title="Tindakan terhadap produk, jika lebih dari salah satu tekan klik + Ctrl"'); ?></td></tr>
                </table>
                <?php
				}else{
					?>
                    <table class="form_tabel">
                        <tr><td class="td_left">Hasil Pemeriksaan</td><td class="td_right"><?php echo $sess['URAIAN']; ?></td></tr>
                        <tr><td class="td_left">Tindakan Terhadap Produk</td><td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;"><?php $tindakan = explode("#", $sess['TINDAKAN']); echo "<li>".join("</li><li>", $tindakan)."</li>"; ?></ul></td></tr>
                    </table>
                    <?php
				}
				?>
                </div>
        </div>
      
      	<div style="height:5px;"></div>
        
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Verifikasi Pemeriksaan</h2>
                <?php if($isverifikasi){ ?>
                <table class="form_tabel">
                    <tr><td class="td_left">Proses Pemeriksaan</td><td class="td_right"><?php echo form_dropdown($obj_status,$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td></tr>
                    <tr><td class="td_left">Catatan</td><td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td></tr>
                </table>
                <?php } ?>
                <div style="padding-top:5px;">
                <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan (<?php echo $sess['JML_PROSES']; ?>)</a></h2>
                <div id="detail_log"></div>
                </div> 
                
                </div>
        </div><!-- Akhir Verifikasi !-->        
        
     </div>
</div>   

<div id="clear_fix"></div>
<div><?php if($isverifikasi){ ?><a href="#" class="button check" onclick="fpost('#f02pr_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<?php } ?><a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<input type="hidden" name="PERIKSA_ID" value="<?php echo $sess['PERIKSA_ID']; ?>" /><input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
<div id="clear_fix"></div>
</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		  var obj;
		  $("#detail_petugas").html("Loading ...");
		  $("#detail_petugas").load($("#detail_petugas").attr("url"));
	});
</script>

