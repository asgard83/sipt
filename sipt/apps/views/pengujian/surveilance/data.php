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
                <td class="td_left">Nomor Surat Tugas </td>
                <td class="td_right"><?php echo $sess['NOMOR_SURAT']; ?></td>
                <td width="10"></td>
                <td class="td_left">Asal Sampel </td>
                <td class="td_right"><?php echo $sess['ASAL_SAMPEL']; ?></td>
              </tr>
              
              <tr>
                <td class="td_left">Tanggal Surat Tugas </td>
                <td class="td_right"><?php echo $sess['TANGGAL_SURAT']; ?></td>
                <td></td>
                <td class="td_left">Prioritas Sampling</td>
                <td class="td_right"><?php echo $sess['PRIORITAS'] == "0" ? 'Bukan Data Prioritas Sampling' : 'Data Prioritas Sampling'; ?></td>
              </tr>
              <tr>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
                <td></td>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php echo "<b>".$sess['KO']."</b>"; ?></td>
              </tr>
              
              <tr>
                <td class="td_left">Anggaran Sampling</td>
                <td class="td_right"><?php echo $sess['ANGGARAN']; ?></td>
                <td></td>
                <td class="td_left">Tujuan Sampling</td>
                <td class="td_right"><?php echo $sess['TUJUAN_SAMPLING']; ?> <?php echo strlen($sess['SUB_TUJUAN']) > 0 ? "&raquo; ".$sess['SUB_TUJUAN'] : '' ?></td>
              </tr>
              <tr>
                <td class="td_left">Bulan Anggaran Sampling </td>
                <td class="td_right"><?php echo $sess['BULAN_ANGGARAN']; ?></td>
                <td></td>
                <td class="td_left">Tanggal Sampling </td>
                <td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Petugas Sampling </td>
                <td class="td_right"><ul style="list-style:none; margin:0px; padding:0px;" id="urut0">
                    <?php
								$jmlpetugas = count($user_id);
								for($i=0;$i<$jmlpetugas;$i++){
									?>
                    <li style="padding-bottom:5px;"><?php echo $nama_user[$i]; ?></li>
                    <?php
								}
								?>
                  </ul></td>
                <td></td>
                <td class="td_left">Tempat Sampling </td>
                <td class="td_right"><?php echo $sess['TEMPAT_SAMPLING']; ?></td>
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
                  <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
                  <td width="10"></td>
                  <td class="td_left">NIP</td>
                  <td class="td_right"><?php echo $sess['NIP_PENGIRIM'];?></td>
                </tr>
              </table>
            </div>
            <div class="pihak-3-polisi" style="display:none;">
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
            <div class="biaya-pihak-ke-3" style="display:none;">
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Biaya</td>
                  <td class="td_right"><?php echo $sess['BIAYA']; ?></td>
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
              <?php
			  if(strlen($sess['SPU_ID']) > 1){
			  ?>
              <tr>
                <td class="td_left">Kode sampel</td>
                <td class="td_right bold"><?php echo $sess['UR_KODE']; ?>
                  <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" /></td>
                <td></td>
                <td class="td_left">Nomor SPU</td>
                <td class="td_right bold"><?php echo $sess['UR_SPU']; ?>
                  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" /></td>
              </tr>
              <?php
			  }
			  ?>
              <tr>
                <td class="td_left">Kategori Sampel</td>
                <td class="td_right" style="width:300px;"><?php echo $sess['KATEGORI']; ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right"></td>
              </tr>
              <tr>
                <td class="td_left">Kategori Tambahan</td>
                <td class="td_right"><?php echo $sess['KLASIFIKASI_TAMBAHAN']; ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><?php echo $sess['NAMA_SAMPEL'];?></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
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
                <td class="td_left">Kemasan Sampel</td>
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
                <td class="td_right"><div style="padding-bottom:5px;"> <?php echo $sess['UJI_KIMIA'] > 0 ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kimia&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?></div>
                  <div style="padding-bottom:5px;"> <?php echo $sess['UJI_MIKRO'] > 0 ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Mikro&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?></div>
                  <div>Retain&nbsp;<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?></div></td>
                <td></td>
                <td class="td_left">Harga Pembelian</td>
                <td class="td_right"><?php echo $sess['HARGA_SAMPEL']; ?> (dalam Rupiah)</td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sess['CATATAN SAMPEL']; ?></td>
                <td width="10"></td>
                <td class="td_left">Lampiran File</td>
                <td class="td_right"><?php
					  if(trim($sess['LAMPIRAN']) != ""){
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
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI</a></div>
        <div class="collapse">
          <div class="accCntnt">
          <form name="fverifikasi" id="fverifikasi" method="post" action="<?php echo $act; ?>" autocomplete="off">
		  <table class="form_tabel">
          	<?php
			if(strlen(trim($sess['HASIL_EVALUASI_D2'])) > 0){
				?>
                <tr>
                  <td class="td_left">Hasil Evaluasi</td>
                  <td class="td_right"><?php echo $sess['HASIL_EVALUASI_D2']; ?></td>
                </tr>
                <?php
			}
			?>
          
          	<?php
			if(count($proses)>1){
			?>
          	<?php
			if(in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE'))){
			?>
            <tr>
              <td class="td_left">Hasil Evaluasi</td>
              <td class="td_right"><textarea name="HASIL_EVALUASI_D2" class="stext catatan" title="Hasil Evaluasi" <?php echo in_array($this->newsession->userdata('SESS_BBPOM_ID'), $this->config->item('cfg_unit')) && in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) && $sess['STATUS_SAMPEL'] == '20200' ? 'rel="required"' : ''; ?>></textarea></td>
            </tr>
            <?php
			}
			?>
            <tr>
              <td class="td_left">Proses</td>
              <td class="td_right"><?php echo form_dropdown('STATUS_SAMPEL',$proses,'','class="stext" title="Pilih salah satu, untuk memproses tindak data sampling" rel="required"', $disproses); ?></td>
            </tr>
            <tr>
              <td class="td_left">Catatan</td>
              <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan verifikasi tindak lanjut hasil sampling" rel="required"></textarea></td>
            </tr>
            <?php
			}
			?>
          </table>
          <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" /> 	          
          <input type="hidden" name="STATUS" value="<?php echo $sess['STATUS_SAMPEL']; ?>" /> 	          
          </form>
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
    <div style="padding-left:5px;">
    <?php
	  if(count($proses)>1){
	  ?>
    <a href="#" id="btnpros" class="button check" onclick="fpost('#fverifikasi','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
    <?php
	}
    ?><a href="#" class="button back" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
</div>