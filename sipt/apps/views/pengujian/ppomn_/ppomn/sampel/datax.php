<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form id="fpreview" name="fpreview">
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
            <div class="pihak-3-swasta-pemerintah" <?php echo $sess['ANGGARAN'] == "06" || "07" ? '' : 'style="display:none;"'; ?>>
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
            <div class="pihak-3-polisi" <?php echo $sess['ANGGARAN'] == "05" ? '' : 'style="display:none;"'; ?>>
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
                <td class="td_left">Kode sampel</td>
                <td class="td_right bold"><?php echo $sess['UR_KODE']; ?>
                  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" /></td>
                <td></td>
                <td class="td_left">Nomor SPU</td>
                <td class="td_right bold"><?php echo $sess['FR_SPUID']; ?>
                  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php echo "<b>".$sess['KO']."</b>"; ?></td>
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
              <?php
			  $arrtolak = array('11001');
			  if(in_array('11',$this->newsession->userdata('SESS_KODE_ROLE')) && in_array($sess['STATUS_SAMPEL'], $arrtolak)){
			  ?>
              <tr>
                <td class="td_left" colspan="5"><input type="checkbox" id="chk_tolak"/>
                  &nbsp;&nbsp;Silahkan centang ceklist disamping jika anda ingin sampel ini diperbaiki.</td>
              </tr>
              <tr id="tr_ctsampel" style="display:none;">
                <td class="td_left">Catatan Perbaikan</td>
                <td class="td_right" colspan="4"><textarea class="stext catatan" id="catatan" name="KEGIATAN" title="Catatan Perbaikan"></textarea></td>
              </tr>
              <?php
			  }
			  ?>
            </table>
          </div>
        </div>
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
    <div style="padding-left:5px;"><a style="display:none" href="#" id="btnpros" class="button save" onclick="fpost('#fpreview','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;<a href="#" class="button back" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
    <input type="hidden" name="STATUS_SPU" value="<?php echo $status_spu; ?>" />
  </form>
</div>
<script>
	<?php
	if(in_array('11',$this->newsession->userdata('SESS_KODE_ROLE'))){
	?>
	$(document).ready(function(){
		$("#chk_tolak").change(function(){
			if($(this).attr("checked")){
				$("tr#tr_ctsampel").fadeIn(500);
				$("#btnpros").fadeIn(500);
				$("#fpreview").attr("action", "<?php echo site_url().'/post/ppomn/sampelx_act/tolak'; ?>");
				$("#fpreview").attr("method", "post");
				$("#fpreview").attr("autocomplete","off");
			}else{
				$("tr#tr_ctsampel").fadeOut(500);
				$("#btnpros").fadeOut(500);
				$("#fpreview").removeAttr("action");
				$("#fpreview").removeAttr("method");
				$("#fpreview").removeAttr("autocomplete");
				$("#catatan").val('');
			}
		});
	});
	<?php
	}
	?>
</script>