<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN SAMPEL</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small garis">Data Pemeriksaan Sampel</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left">Asal Sampel</td>
              <td class="td_right"><?php echo $sess['ASAL_SAMPEL']; ?></td>
              <td>&nbsp;</td>
              <td class="td_left">Anggaran Sampling</td>
              <td class="td_right"><?php echo $sess['UR_ANGGARAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Pengantar</td>
              <td class="td_right"><?php echo $sess['NOMOR_SURAT']; ?></td>
              <td>&nbsp;</td>
              <td class="td_left">Tempat Asal Sampel</td>
              <td class="td_right"><?php echo $sess['TEMPAT_SAMPLING']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SURAT']; ?></td>
              <td>&nbsp;</td>
              <td class="td_left">Tanggal diterima di TPS</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div style="height:5px;">&nbsp;</div>
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA PENGIRIM</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <div class="pihak-3-swasta-pemerintah" <?php echo $sess['ANGGARAN'] == "10" || "12" ? '' : 'style="display:none;"'; ?>>
            <h2 class="small garis">Data Pengirim Sampel Pihak Ke 3</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama Pengirim</td>
                <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
              </tr>
              <tr>
                <td class="td_left">NIP</td>
                <td class="td_right"><?php echo $sess['NIP_PENGIRIM'];?></td>
              </tr>
            </table>
          </div>
          <div class="pihak-3-polisi" <?php echo $sess['ASAL_SAMPLING'] == "11" ? '' : 'style="display:none;"'; ?>>
            <h2 class="small garis">Data Pengirim Pihak Ke 3 Kepolisian</h2>
            <table class="form_tabel" id="dt-pengirim">
              <tr>
                <td class="td_left">Nama Pengirim</td>
                <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
              </tr>
              <tr>
                <td class="td_left">NIP / NRP</td>
                <td class="td_right"><?php echo $sess['NIP_POLISI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pangkat</td>
                <td class="td_right"><?php $sess['PANGKAT']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Kepolisian</td>
                <td class="td_right"><?php echo $sess['INSTITUSI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">No. LP</td>
                <td class="td_right"><?php echo $sess['NO_LP']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal LP</td>
                <td class="td_right"><?php echo $sess['TANGGAL_LP']; ?></td>
              </tr>
              <tr>
                <td class="td_left">No. SPDP</td>
                <td class="td_right"><?php echo $sess['NO_SPDP']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal SPDP</td>
                <td class="td_right"><?php echo $sess['TANGGAL_SPDP']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Tersangka</td>
                <td class="td_right"><?php echo $sess['NAMA_TERSANGKA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kota</td>
                <td class="td_right"><?php echo $sess['KOTA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Saksi</td>
                <td class="td_right"><?php echo $sess['SAKSI_POLISI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Terima</td>
                <td class="td_right"><?php echo $sess['TANGGAL_TERIMA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Hari Terima</td>
                <td class="td_right"><?php echo $sess['HARI_TERIMA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Saksi Pengujian</td>
                <td class="td_right"><?php echo $sess['SAKSI_UJI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Jumlah Sampel Di Surat Permintaan Uji</td>
                <td class="td_right"><?php echo $sess['JUMLAH_UJI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sess['CATATAN_SURAT']; ?></td>
              </tr>
            </table>
          </div>
          <div class="biaya-pihak-ke-3">
            <h2 class="small garis">Penerimaan Negara Bukan Pajak (Pengujian)</h2>
            <!-- PNBP !-->
            <table class="listtemuan" width="100%" id="list-pnbp">
              <thead>
                <tr>
                  <th width="300">Jenis PNBP</th>
                  <th>Satuan</th>
                  <th>Jumlah Uji</th>
                  <th>Tarif</th>
                  <th>Sub Total</th>
                </tr>
              </thead>
              <tbody id="body-pnbp">
                <?php
				 $allpnbp = count($list_pnbp);
				 if($allpnbp > 0){
					 $total = 0;
					 for($i=0; $i < $allpnbp; $i++){
						 $total = $total + ($list_pnbp[$i]['PNBP_JML'] * $list_pnbp[$i]['PNBP_TARIF']);
					 ?>
                <tr>
                  <td><?php echo $list_pnbp[$i]['PNBP_DESCRIPTION']; ?></td>
                  <td><?php echo $list_pnbp[$i]['PNBP_UNIT']; ?></td>
                  <td><?php echo $list_pnbp[$i]['PNBP_JML']; ?></td>
                  <td><?php echo "Rp " . number_format($list_pnbp[$i]['PNBP_TARIF'],2,',','.'); ?></td>
                  <td><?php echo "Rp " . number_format($list_pnbp[$i]['PNBP_JML'] * $list_pnbp[$i]['PNBP_TARIF'],2,',','.'); ?></td>
                </tr>
                <?php
					 }
					 ?>
                <tr>
                  <td colspan="4">Total</td>
                  <td><?php echo "Rp " . number_format($total,2,',','.'); ?></td>
                </tr>
                <?php
				 }else{
					 ?>
                <tr id="0" ke="0">
                  <td colspan="5">Data PNBP tidak ditemukan</td>
                </tr>
                <?php
				 }
				 ?>
              </tbody>
            </table>
            <!-- Akhir PNBP !-->
            <div style="height:5px;">&nbsp;</div>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Biaya</td>
                <td class="td_right"><?php echo "Rp " . number_format($sess['BIAYA'],2,',','.'); ?></td>
              </tr>
              <tr>
                <td class="td_left">No. Resi Bank</td>
                <td class="td_right"><?php echo $sess['NO_RESI_BANK']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Resi Bank</td>
                <td class="td_right"><?php echo $sess['TANGGAL_RESI_BANK']; ?></td>
              </tr>
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
          	 <tr>
                <td class="td_left">Data Prioritas</td>
                <td class="td_right" colspan="5"><?php echo $sess['PRIORITAS'] == "0" ? 'Bukan Data Prioritas Sampling' : 'Data Prioritas Sampling'; ?></td>
            </tr>
            <tr>
              <td class="td_left">Komoditi</td>
              <td class="td_right" style="width:300px;"><?php echo "<b>".$sess['KO']."</b>"; ?></td>
              <td width="10"></td>
              <td class="td_left">Komoditi Tambahan</td>
              <td class="td_right"><?php echo $sess['KLASIFIKASI_TAMBAHAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Nama sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_SAMPEL'];?></td>
              <td width="10"></td>
              <td class="td_left">No Registrasi</td>
              <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
            </tr>
            <tr id="tdanak2" ke="2">
              <td class="td_left">Kategori sampel</td>
              <td class="td_right"><?php echo $sess['KATEGORI']; ?></td>
              <td width="10"></td>
              <td class="td_left">&nbsp;</td>
              <td class="td_right">&nbsp;</td>
            </tr>
            <tr>
              <td class="td_left">Pabrik</td>
              <td class="td_right"><?php echo $sess['PABRIK']; ?></td>
              <td width="10"></td>
              <td class="td_left">Importir</td>
              <td class="td_right"><?php echo $sess['IMPORTIR']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Bentuk Sediaan sampel</td>
              <td class="td_right"><?php echo $sess['BENTUK_SEDIAAN']; ?></td>
              <td width="10"></td>
              <td class="td_left">Kemasan sampel</td>
              <td class="td_right"><?php echo $sess['KEMASAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">No Bets</td>
              <td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
              <td width="10"></td>
              <td class="td_left">Keterangan ED</td>
              <td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Komposisi</td>
              <td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td>
              <td width="10"></td>
              <td class="td_left">Netto</td>
              <td class="td_right"><?php echo $sess['NETTO']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Evaluasi Penandaan</td>
              <td class="td_right"><?php echo $sess['EVALUASI_PENANDAAN']; ?></td>
              <td width="10"></td>
              <td class="td_left">Cara Penyimpanan</td>
              <td class="td_right"><?php echo $sess['CARA_PENYIMPANAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Kondisi sampel</td>
              <td class="td_right"><?php echo $sess['KONDISI_SAMPEL']; ?></td>
              <td width="10"></td>
              <td class="td_left">Jumlah sampel</td>
              <td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sess['SATUAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Segel sampel</td>
              <td class="td_right"><?php echo $sess['SEGEL']; ?></td>
              <td></td>
              <td class="td_left">Label sampel</td>
              <td class="td_right"><?php echo $sess['LABEL']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Pengujian</td>
              <td class="td_right">
                <div style="padding-bottom:5px;">
				<?php echo $sess['UJI_KIMIA'] > 0 ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kimia&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?></div>
                  <div style="padding-bottom:5px;">
                  <?php echo $sess['UJI_MIKRO'] > 0 ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Mikro&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?></div>
                  <div>Retain&nbsp;<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?></div>
              </td>
              <td></td>
              <td class="td_left">Harga Pembelian</td>
              <td class="td_right"><?php echo $sess['HARGA_SAMPEL']; ?> (dalam Rupiah)</td>
            </tr>
            <tr>
              <td class="td_left">Catatan</td>
              <td class="td_right"><?php echo $sess['CATATAN SAMPEL']; ?></td>
              <td width="10"></td>
              <td class="td_left"><!--Lampiran File!--></td>
              <td class="td_right">&nbsp;</td>
            </tr>
          </table>
        </div>
      </div>
      <?php if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			?>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL DATA</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small">Detil Transaksional Sampel</h2>
            <div id="tabs">
              <ul>
                <li><a href="#tabs-1">Penyerahan Sampel</a></li>
                <li><a href="#tabs-2">Perintah Kerja</a></li>
                <li><a href="#tabs-3">Perintah Pengujian</a></li>
                <li><a href="#tabs-4">Parameter Uji</a></li>
                <li><a href="#tabs-5">Catatan & Laporan Pengujian</a></li>
              </ul>
              <div id="tabs-1" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/sps/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
              <div id="tabs-2" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/spk/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
              <div id="tabs-3" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/spp/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
              <div id="tabs-4" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/parameter/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
              <div id="tabs-5" class="tab-pengujian" url="<?php echo site_url(); ?>/get/pengujian/trans_act/cp/<?php echo $sess['KODE_SAMPEL']; ?>"></div>
            </div>
            <div style="height:5px;">&nbsp;</div>
            <table class="form_tabel">
            	<tr>
                	<td class="td_left">Kode Sampel</td><td class="td_right"><?php echo $sess['UR_KODE']; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Hasil Kimia</td><td class="td_right"><?php echo strlen($sess['HASIL_KIMIA']) > 0 ? $sess['HASIL_KIMIA'] : '-'; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Hasil Mikro</td><td class="td_right"><?php echo strlen($sess['HASIL_MIKRO']) > 0 ? $sess['HASIL_MIKRO'] : '-'; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Hasil Sampel</td><td class="td_right"><?php echo strlen($sess['HASIL_SAMPEL']) > 0 ? $sess['HASIL_SAMPEL'] : '-'; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Catatan</td><td class="td_right"><?php echo $sess['CATATAN_CP']; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Status Kimia</td><td class="td_right"><input class="chk-status-uji" type="checkbox" <?php echo (int)$sess['STATUS_KIMIA'] == 1 ? 'value="1" checked="checked"' : 'value="0"';?> data-url = "<?php echo site_url(); ?>/get/pengujian/status_act/bidang/02/<?php echo $sess['KODE_SAMPEL']; ?>/" />&nbsp;<?php echo (int)$sess['STATUS_KIMIA'] == 0 ? 'Belum selesai atau tidak ada proses pengujian kimia' : 'Selesai'; ?></td> 
                </tr>
            	<tr>
                	<td class="td_left">Status Mikro</td><td class="td_right"><input class="chk-status-uji" type="checkbox" <?php echo (int)$sess['STATUS_MIKRO'] == 1 ? 'value="1" checked="checked"' : 'value="0"';?> data-url = "<?php echo site_url(); ?>/get/pengujian/status_act/bidang/01/<?php echo $sess['KODE_SAMPEL']; ?>/" />&nbsp;<?php echo (int)$sess['STATUS_MIKRO'] == 0 ? 'Belum selesai atau tidak ada proses pengujian mikro' : 'Selesai'; ?></td> 
                </tr>
                <?php
				if($redispo){
					?>
                <tr>
                	<td colspan="2" class="td_left">
                    <div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
                      <p><b>Keterangan :</b></p>
                      <p>Jika status sampel sudah di disposisikan ke bidang, namun bidang tidak menerima sampel tersebut <a href="javascript:;" class="redispo-ulang" data-url = "<?php echo site_url(); ?>/get/pengujian/get_statusmt/<?php echo $sess['KODE_SAMPEL']; ?>/<?php echo $sess['SPU_ID']; ?>">klik disini untuk mendisposisikan sampel tersebut</a>.</p>
                    </div>
                    </td>
                </tr>    
                    <?php
				}
				?>
            </table>
          </div>
        </div>
        <?php
		}
        ?>
      <div style="height:5px;">&nbsp;</div>
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LOG SAMPEL</a></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_sampel/<?php echo $sess['KODE_SAMPEL']; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Sampel (
            <?= $jml_log; ?>
            )</a></h2>
          <div id="detail_log"></div>
        </div>
      </div>
    </div>
  </div>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button back" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-redispoy"></div>
<script>
	$(document).ready(function(){
		$(".chk-status-uji").change(function(e){
			var $this = $(this);
			if($this.is(":checked")){
				jConfirm('Proses data terpilih sekarang ?', 'SIPT Versi 1.0', function(ojan){
					if(ojan==true){
						$.get($this.attr("data-url") + $this.val(), function($return){
							if($return){
								var $arr = $return.split('#');
								if($arr[1] == "YES"){
									jAlert($arr[2], 'SIPT Versi 1.0');
									if($arr.length>3){
										setTimeout(function(){
											window.history.back();
										}, 1000);
										return false;
									}
								}else{
									jAlert($arr[2], 'SIPT Versi 1.0');
									$this.removeAttr("checked");
								}
							}
						});
					}else{
						$this.removeAttr("checked");
					}
				});
			}
		});
		$(".tab-pengujian").each(function(){
			var $this = $(this).attr("id");
			$.get($(this).attr('url'), function(hasil){
				if(hasil){
					$('#'+$this).html(hasil);
				}
			});
        });	
		
		$(".redispo-ulang").click(function(){
			var $this = $(this);
			$.get($this.attr("data-url"), function(data){
				$("#ctn-redispoy").html(data); 
				$("#ctn-redispoy").dialog({ 
					title: 'Disposisi Ulang Sampel Ke Bidang Pengujian', 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
		});
	});
</script>