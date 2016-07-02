<?php $SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>
<?php #print_r($sess); ?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f02BBnew" id="f02BBnew" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama Sarana Distribusi/Ritel/Toko/Apotek/PBF</td>
                <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Bertindak Sebagai</td>
                <td class="td_right"><?php echo form_dropdown('STATUS_BB', $sarana_bb, $sess['SARANA_BB'], 'class="stext" rel="required" title="Sarana bertindak sebagai"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Kantor</td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $alamat_1 = explode(";", $sess['ALAMAT_1']); echo "<li>".join("</li><li>", $alamat_1)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Gudang</td>
                <td class="td_right"><ul style="list-style-type:disc; padding-left:15px; margin:0;">
                    <?php $alamat_2 = explode(";", $sess['ALAMAT_2']); echo "<li>".join("</li><li>", $alamat_2)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Telepon</td>
                <td class="td_right"><ul style="list-style-type:decimal; padding-left:20px; margin:0;">
                    <?php $telepon = explode(";", $sess['TELEPON']); echo "<li>".join("</li><li>", $telepon)."</li>"; ?>
                  </ul></td>
              </tr>
              <tr>
                <td class="td_left">Nomor Izin</td>
                <td class="td_right"><?php echo $sess['NOMOR_IZIN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Pemilik / Pimpinan Usaha</td>
                <td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Penanggung Jawab</td>
                <td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Status Sarana</td>
                <td class="td_right"><?php echo form_dropdown('STATUS_SARANA', $status_sarana, $sess['STATUS_SARANA'], 'class="stext" title="Status sarana yang diperika" id="stts_sarana" rel="required"'); ?></td>
              </tr>
            </table>
            <h2 class="small">Log Status Sarana</h2>
            <table class="tabelajax">
              <tr class="head">
                <th>Update</th>
                <th>Keterangan</th>
                <th>Petugas Entri</th>
              </tr>
              <?php
					$jmllog_bb = count($log_bb);
					if($jmllog_bb > 0){
						for($x = 0; $x < $jmllog_bb; $x++){
							?>
              <tr>
                <td><?php echo $log_bb[$x]['UPDATE']; ?></td>
                <td><?php echo $log_bb[$x]['KETERANGAN']; ?></td>
                <td><?php echo $log_bb[$x]['NAMA_USER']; ?></td>
              </tr>
              <?php
						}
					}else{
						?>
              <tr>
                <td colspan="3">Data tidak ditemukan</td>
              </tr>
              <?php
					}
					?>
            </table>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" />
                  <input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" onchange="compare('#sess_tgl', '#waktuperiksa_'); return false;" />
                  &nbsp; sampai dengan &nbsp;
                  <input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#sess_tgl', '#waktu_akhir'); return false;" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_BB[TUJUAN_PEMERIKSAAN]', $tujuan_pemeriksaan, $sess['TUJUAN_PEMERIKSAAN'], 'class="stext" id="tujuan_periksa" rel="required" title="Tujuan Pemeriksaan"'); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Informasi Pemeriksaan !-->
        
        <div id="dtl-pemeriksaan" <?php if(array_key_exists('TUJUAN_PEMERIKSAAN', $sess)){ if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin" || $sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } }else{ echo 'style=""'; } ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL PEMERIKSAAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <table class="form_tabel">
                <tr>
                  <td width="20" class="atas">&nbsp;</td>
                  <td width="385" class="atas">Jenis produk yang diperiksa</td>
                  <td class="atas" colspan="2"><div id="check_list_produk_bb">
                    <div>
                      <input type="checkbox" <?php echo in_array('01', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="01" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Larutan Formaldehid (formalin)" />
                      &nbsp;Larutan Formaldehid (formalin)</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('02', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="02" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Paraformaldehid serbuk" />
                      &nbsp;Paraformaldehid serbuk</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('03', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="03" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Paraformaldehid tablet" />
                      &nbsp;Paraformaldehid tablet</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('04', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="04" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Boraks" />
                      &nbsp;Boraks</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('05', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="05" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Rhodamin B" />
                      &nbsp;Rhodamin B</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('06', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="06" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Kuning Metanil" />
                      &nbsp;Kuning Metanil</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('07', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="07" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Auramin" />
                      &nbsp;Auramin</div>
                    <div>
                      <input type="checkbox" <?php echo in_array('08', $divproduk) ? 'checked="checked"' : ''; ?> class="jenis" value="08" name="PEMERIKSAAN_DIST_BB[PRODUK][]" title="Amaran" />
                      &nbsp;Amaran</div>
                    <div></td>
                </tr>
              </table>
              <h2 class="small">I. Administrasi</h2>
              <table class="form_tabel">
                <tr id="f02BB_point1a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Memiliki izin sesuai</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1a">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Formaldehid (formalin)" id="formalin1a" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin) <?php echo $formalin[0] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1a" />'; ?> </div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk <?php echo $serbuk[0] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1a" />'; ?> </div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet <?php echo $tablet[0] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet1a" />'; ?> </div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks1a" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[0] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1a" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $rhodamin[0] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1a" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[0] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1a" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1a" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[0] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil1a" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin1a" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[0] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[0] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran1a" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[0] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran1a" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1a" value="<?php echo is_array($aspek_check)?$aspek_check[0]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[0] != '' ? $aspek_keterangan[0] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point1b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Memiliki faktur pembelian / tanda terima barang</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1b">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $formalin[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin1b" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[1] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1b" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $serbuk[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[1] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1b" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $tablet[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet
                          <input type="hidden" name="tablet[]" value="0" id="hidden_tablet1b" />
                        </div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $boraks[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks1b" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[1] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1b" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $rhodamin[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1b" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[1] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1b" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $metanil[1] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1b" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[1] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil1b" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $auramin[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin1b" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[1] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin1b" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  <?php echo $amaran[1] == '1' ? 'checked="checked"' : ''; ?>  class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran1b" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[1] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran1b" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1b" value="<?php echo is_array($aspek_check)?$aspek_check[1]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[1] != '' ? $aspek_keterangan[1] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point1c">
                  <td></td>
                  <td class="atas">c.</td>
                  <td class="atas">Mengeluarkan bon penjualan/surat jalan barang</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1c">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin1c" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin) <?php echo $formalin[2] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1c" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1c" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[2] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1c" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1c" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[2] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet1c" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks1c" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[2] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1c" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1c" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[2] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1c" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1c" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[2] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil1c" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin1c" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[2] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin1c" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[2] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran1c" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[2] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran1c" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1c" value="<?php echo is_array($aspek_check)?$aspek_check[2]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[2] != '' ? $aspek_keterangan[2] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point1d">
                  <td></td>
                  <td class="atas">d.</td>
                  <td class="atas">Ada pencatatan pemasukan dan pengeluaran barang</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1d">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[3] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin1d" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[3] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1d" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  class="check_produk" <?php echo $serbuk[3] == '1' ? 'checked="checked"' : ''; ?>  value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1d" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[3] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1d" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[3] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1d" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[3] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tabl1d" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  class="check_produk" <?php echo $boraks[3] == '1' ? 'checked="checked"' : ''; ?> value="1" name="boraks[]" title="Produk Boraks" id="boraks1d" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[3] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1d" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[3] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1d" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[3] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1d" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  class="check_produk" <?php echo $metanil[3] == '1' ? 'checked="checked"' : ''; ?> value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1d" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[3] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_rhodamin1d" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  class="check_produk" <?php echo $auramin[3] == '1' ? 'checked="checked"' : ''; ?> value="1" name="auramin[]" title="Produk Auramin" id="auramin1d" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[3] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin1d" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox"  class="check_produk" <?php echo $amamran[3] == '1' ? 'checked="checked"' : ''; ?> value="1" name="amaran[]" title="Produk Amaran" id="amaran1d" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[3] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amarind1d" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1d" value="<?php echo is_array($aspek_check)?$aspek_check[3]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[3] != '' ? $aspek_keterangan[3] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point1e">
                  <td></td>
                  <td class="atas">e.</td>
                  <td class="atas">Ada pencatatan tujuan penggunaan bahan berbahaya oleh pembeli</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1e">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin1e" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[4] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1e" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1e" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[4] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1e" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1e" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[4] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet1e" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks1e" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[4] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1e" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1e" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[4] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1e" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1e" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[4] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil1e" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin1e" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[4] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin1e" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[4] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran1e" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[4] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amarin1e" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1e" value="<?php echo is_array($aspek_check)?$aspek_check[4]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[4] != '' ? $aspek_keterangan[4] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point1f">
                  <td></td>
                  <td class="atas">f.</td>
                  <td class="atas">Ada pencatatan identitas jelas dan alamat pembeli (untuk pembeli perorangan)</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point1f">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin1f" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[5] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin1f" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk1f" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[5] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk1f" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet1f" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[5] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet1f" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks1f" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[5] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks1f" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin1f" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[5] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin1f" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil1f" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[5] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil1f" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin1f" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[5] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin1f" />'; ?>
                          <input type="hidden" name="auramin[]" value="0" id="hidden_auramin1f" />
                        </div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[5] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran1f" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $auramin[5] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran1f" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point1f" value="<?php echo is_array($aspek_check)?$aspek_check[5]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[5] != '' ? $aspek_keterangan[5] : ''; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">II. Kesesuain Pengadaan Bahan Berbahaya</h2>
              <table class="form_tabel">
                <tr id="f02BB_point2a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Sumber pengadaan sesuai dengan surat penunjukan</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point2a">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin2a" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[6] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin2a" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk2a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[6] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk2a" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet2a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[6] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet2a" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks2a" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[6] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks2a" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin2a" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[6] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin2a" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil2a" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[6] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil2a" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin2a" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[6] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramina2a" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[6] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran2a" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[6] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran2a" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point2a" value="<?php echo is_array($aspek_check)?$aspek_check[6]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[6] != '' ? $aspek_keterangan[6] : ''; ?></textarea>
                    </textarea></td>
                </tr>
                <tr id="f02BB_point2b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Pengadaan bahan berbahaya sesuai dengan Surat Izin Usaha Perdagangan Bahan Berbahaya yang dimiliki</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point2b">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin2b" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[7] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin2b" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk2b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[7] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk2b" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet2b" onchange="checklist($(this));" />
                          &nbsp;
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[7] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet2b" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks2b" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[7] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks2b" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin2b" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[7] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin2b" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil2b" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[7] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil2b" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin2b" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[7] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin2b" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[7] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran2b" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[7] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran2b" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point2b" value="<?php echo is_array($aspek_check)?$aspek_check[7]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[7] != '' ? $aspek_keterangan[7] : ''; ?></textarea>
                    </textarea></td>
                </tr>
              </table>
              <h2 class="small">III. Kesesuaian Penyaluran / Distribusi Bahan Berbahaya</h2>
              <table class="form_tabel">
                <tr id="f02BB_point3a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Penyaluran bahan berbahaya dilakukan hanya ke industri pengguna akhir bahan berbahaya atau instansi / lembaga pengguna akhir bahan berbahaya</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point3a">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin3a" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[8] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin3a" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk3a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[8] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk3a" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet3a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[8] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet3a" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks3a" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[8] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks3a" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin3a" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[8] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin3a" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil3a" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[8] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil3a" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin3a" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[8] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin3a" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[8] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran3a" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[8] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amarana3a" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point3a" value="<?php echo is_array($aspek_check)?$aspek_check[8]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[8] != '' ? $aspek_keterangan[8] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point3b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Tidak melakukan menyalurkan ke perorangan tanpa identitas dan tujuan penggunaan jelas</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point3b">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin3b" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[9] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin3b" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk3b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[9] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk3b" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet3b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[9] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet3b" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks3b" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[9] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks3b" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin3b" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[9] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin3b" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil3b" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[9] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil3b" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin3b" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[9] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin3b" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[9] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran3b" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[9] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran3b" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point3b" value="<?php echo is_array($aspek_check)?$aspek_check[9]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[9] != '' ? $aspek_keterangan[9] : ''; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">IV. Pengemasan Ulang</h2>
              <table class="form_tabel">
                <tr id="f02BB_point4">
                  <td></td>
                  <td width="20" class="atas">&nbsp;</td>
                  <td width="385" class="atas">Melakukan pengemasan ulang (<em>repacking</em>) bahan berbahaya</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point4">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[10] ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin4a" onchange="chkrepack($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[10] ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin4a" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo  $serbuk[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk4a" onchange="chkrepack($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo  $serbuk[10] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk4a" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet4a" onchange="chkrepack($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[10] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet4a" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks4a" onchange="chkrepack($(this));" />
                          &nbsp;Boraks<?php echo $boraks[10] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks4a" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin4a" onchange="chkrepack($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[10] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin4a" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil4a" onchange="chkrepack($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[10] == '1' ? '"' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil4a" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin4a" onchange="chkrepack($(this));" />
                          &nbsp;Auramin<?php echo $auramin[10] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin4a" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[10] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran4a" onchange="chkrepack($(this));" />
                          &nbsp;Amaran<?php echo $amaran[10] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amarana4a" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point4a" value="<?php echo is_array($aspek_check)?$aspek_check[10]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[10] != '' ? $aspek_keterangan[10] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point4x">
                  <td></td>
                  <td width="20" class="atas">&nbsp;</td>
                  <td width="385" class="atas">Lampiran file</td>
                  <td class="atas sel_penyimpangan">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas"><?php if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){ ?>
                    <span class="upload_LAMPIRAN" style="display:none;">
                    <input type="file" class="stext upload" jenis="LAMPIRAN" allowed="jpeg-jpg" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_upload($(this)); return false;" title="Lampiran File BAP" />
                    &nbsp;Tipe file : *.jpeg, jpg</span><span class="file_LAMPIRAN"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" jns="LAMPIRAN">Edit atau Hapus File ?</a></span>
                    <?php
		}else{
		?>
                    <span class="upload_LAMPIRAN">
                    <input type="file" class="stext upload" jenis="LAMPIRAN" allowed="jpeg-jpg" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_upload($(this)); return false;" />
                    &nbsp;Tipe File : *.jpeg, jpg</span><span class="file_LAMPIRAN"></span>
                    <?php
		}
		?></td>
                </tr>
              </table>
              <h2 class="small">V. Pelaporan</h2>
              <table class="form_tabel">
                <tr id="f02BB_point6a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Muatan Laporan sesuai dengan ketentuan</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point6a">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin5a" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[11] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin5a" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk5a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[11] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk5a" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet5a" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[11] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet5a" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks5a" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[11] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks5a" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin5a" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[11] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin5a" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil5a" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[11] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil5a" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin5a" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[11] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin5a" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[11] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran5a" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[11] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran5a" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point6a" value="<?php echo is_array($aspek_check)?$aspek_check[11]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[11] != '' ? $aspek_keterangan[11] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point6b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Melakukan pelaporan berkala per triwulan</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point6b">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin5b" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[12] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin5b" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk5b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[12] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk5b" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet5b" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[12] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet5b" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks5b" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[12] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks5b" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin5b" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[12] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin5b" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil5b" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[12] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil5b" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin5b" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[12] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin5b" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[12] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran5b" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[12] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran5b" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point6b" value="<?php echo is_array($aspek_check)?$aspek_check[12]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[12] != '' ? $aspek_keterangan[12] : ''; ?></textarea></td>
                </tr>
                <tr id="f02BB_point6c">
                  <td></td>
                  <td class="atas">c.</td>
                  <td class="atas">Laporan dikirimkan ke Instansi yang dinyatakan sesuai dengan ketentuan</td>
                  <td class="atas sel_penyimpangan"><div id="chk_point6c">
                      <div class="produk_bb">
                        <div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $formalin[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="formalin[]" title="Produk Larutan Formaldehid (formalin)" id="formalin5c" onchange="checklist($(this));" />
                          &nbsp;Larutan Formaldehid (formalin)<?php echo $formalin[13] == '1' ? '' : '<input type="hidden" name="formalin[]" value="0" id="hidden_formalin5c" />'; ?></div>
                        <div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $serbuk[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="serbuk[]" title="Produk Paraformaldehid serbuk" id="serbuk5c" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid serbuk<?php echo $serbuk[13] == '1' ? '' : '<input type="hidden" name="serbuk[]" value="0" id="hidden_serbuk5c" />'; ?></div>
                        <div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $tablet[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="tablet[]" title="Produk Paraformaldehid tablet" id="tablet5c" onchange="checklist($(this));" />
                          &nbsp;Paraformaldehid tablet<?php echo $tablet[13] == '1' ? '' : '<input type="hidden" name="tablet[]" value="0" id="hidden_tablet5c" />'; ?></div>
                        <div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $boraks[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="boraks[]" title="Produk Boraks" id="boraks5c" onchange="checklist($(this));" />
                          &nbsp;Boraks<?php echo $boraks[13] == '1' ? '' : '<input type="hidden" name="boraks[]" value="0" id="hidden_boraks5c" />'; ?></div>
                        <div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $rhodamin[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="rhodamin[]" title="Produk Rhodamin B" id="rhodamin5c" onchange="checklist($(this));" />
                          &nbsp;Rhodamin B<?php echo $rhodamin[13] == '1' ? '' : '<input type="hidden" name="rhodamin[]" value="0" id="hidden_rhodamin5c" />'; ?></div>
                        <div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $metanil[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="metanil[]" title="Produk Kuning Metanil" id="metanil5c" onchange="checklist($(this));" />
                          &nbsp;Kuning Metanil<?php echo $metanil[13] == '1' ? '' : '<input type="hidden" name="metanil[]" value="0" id="hidden_metanil5c" />'; ?></div>
                        <div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $auramin[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="auramin[]" title="Produk Auramin" id="auramin5c" onchange="checklist($(this));" />
                          &nbsp;Auramin<?php echo $auramin[13] == '1' ? '' : '<input type="hidden" name="auramin[]" value="0" id="hidden_auramin5c" />'; ?></div>
                        <div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>>
                          <input type="checkbox" <?php echo $amaran[13] == '1' ? 'checked="checked"' : ''; ?> class="check_produk" value="1" name="amaran[]" title="Produk Amaran" id="amaran5c" onchange="checklist($(this));" />
                          &nbsp;Amaran<?php echo $amaran[13] == '1' ? '' : '<input type="hidden" name="amaran[]" value="0" id="hidden_amaran5c" />'; ?></div>
                      </div>
                    </div></td>
                  <td class="atas"><input type="text" class="scode res" rel="required" title="Hasil Penilaian" readonly="readonly" name="PEMERIKSAAN_DIST_BB[ASPEK_CHECK][]" id="check_point6c" value="<?php echo is_array($aspek_check)?$aspek_check[13]:'Tidak'; ?>" /></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_BB[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[13] != '' ? $aspek_keterangan[13] : ''; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">Detil Pengadaan B2, Distribusi B2 dan Repacking B2</h2>
              <table class="form_temuan" id="lap_bb">
                <tr>
                  <td class="atas isi" colspan="5">B2 yang Dikelola</td>
                </tr>
                <tr>
                  <td class="td_left">B2</td>
                  <td class="td_right" colspan="4"><select class="stext" title="B2 yang dikelola" id="lap_produk_bb">
                      <option value=""></option>
                      <!--<option value="01">Larutan Formaldehid (Formalin)</option>
					<option value="02">Paraformaldehid serbuk</option>
					<option value="03">Paraformaldehidtablet</option>
					<option value="04">Boraks</option>
					<option value="05">Rhodamin B</option>
					<option value="06">Kuning Metanil</option>
					<option value="07">Auramin</option>
					<option value="08">Amaran</option>!-->
                    </select></td>
                </tr>
                <tr>
                  <td class="atas isi" colspan="5">Pengadaan</td>
                </tr>
                <tr>
                  <td class="temuan_left">Nama Sarana</td>
                  <td class="temuan_right"><input type="text" id="lap_pengadaan_sarana" class="stext" title="Nama Sarana" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana_bb" />
                    <input type="hidden" id="lap_pengadaan_id" />
                    <!--<div style="padding:5px;"><input type="checkbox" class="chk-importir" />Importir</div>!--></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Alamat</td>
                  <td class="temuan_right"><textarea class="stext" id="lap_pengadaan_alamat" title="Pengadaan - Alamat Sarana"></textarea></td>
                </tr>
                <tr>
                  <td class="temuan_left">&nbsp;</td>
                  <td class="temuan_right">&nbsp;</td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Propinsi</td>
                  <td class="temuan_right"><?= form_dropdown('PEMASOK',$propinsi,'','class="stext" title="Pengadaan - Propinsi" id="lap_pengadaan_daerah_id"'); ?></td>
                </tr>
                <tr>
                  <td class="temuan_left">Ukuran Kemasan</td>
                  <td class="temuan_right"><input type="text" class="stext" id="lap_pengadaan_kemasan" title="Pengadaan - Ukuran Kemasan" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Status Pemasok</td>
                  <td class="temuan_right"><?php echo form_dropdown('', $sarana_bb, '', 'class="stext" title="Pengadaan - Status Pemasok" id="lap_pengadaan_status"'); ?></td>
                </tr>
                <tr id="stts_pemasok" style="display:none;">
                  <td class="temuan_left">&nbsp;</td>
                  <td class="temuan_right">&nbsp;</td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Catatan</td>
                  <td class="temuan_right"><textarea class="stext" id="clap_pengadaan_status" title="Catatan"></textarea></td>
                </tr>
                <tr>
                  <td class="atas isi" colspan="5">Distribusi</td>
                </tr>
                <tr>
                  <td class="temuan_left">Nama Sarana</td>
                  <td class="temuan_right"><input type="text" class="stext" id="lap_distribusi_sarana" title="Distribusi - Nama Sarana" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana_bb" />
                    <input type="hidden" id="lap_distribusi_id" /></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Alamat</td>
                  <td class="temuan_right"><textarea class="stext" id="lap_distribusi_alamat" title="Distribusi - Alamat Sarana"></textarea></td>
                </tr>
                <tr>
                  <td class="temuan_left">&nbsp;</td>
                  <td class="temuan_right">&nbsp;</td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Propinsi</td>
                  <td class="temuan_right"><?= form_dropdown('PEMASOK',$propinsi,'','class="stext" title="Distribusi - Propinsi" id="lap_distribusi_daerah_id"'); ?></td>
                </tr>
                <tr>
                  <td class="temuan_left">Jenis Sarana</td>
                  <td class="temuan_right"><?php echo form_dropdown('', $sarana_bb, '', 'class="stext" title="Distribusi - Jenis sarana" id="lap_distribusi_jenis"'); ?></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Tujuan Penggunaan</td>
                  <td class="temuan_right"><input type="text" class="stext" title="Distribusi - Tujuan Penggunaan" id="lap_distribusi_tujuan" /></td>
                </tr>
                <tr id="stts_jns_sarana" style="display:none;">
                  <td class="temuan_left">Catatan</td>
                  <td class="temuan_right"><textarea class="stext" id="c_stts_jns_sarana" title="Catatan"></textarea></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">&nbsp;</td>
                  <td class="temuan_right">&nbsp;</td>
                </tr>
                <tr>
                  <td class="atas isi" colspan="5">Kemasan</td>
                </tr>
                <tr>
                  <td class="temuan_left">Ukuran kemasan
                    <div>(terkecil distribusi)</div></td>
                  <td class="td_right"><div style="padding-top:5px;">
                      <?= form_dropdown('',$kemasan,'','class="stext" title="Keperluan ukuran kemasan bahan berbahaya" id="kemasan_id" url="'.site_url().'/autocompletes/autocomplete/get_kemasanbb/"'); ?>
                    </div>
                    <div style="margin-top:5px;">
                      <input type="text" class="sdate" title="Ukuran kemasan terkecil distribusi" id="lap_kemasan" />
                    </div></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Repacking</td>
                  <td class="temuan_right"><select class="sjenis" id="lap_repacking" title="Repacking (Ya / Tidak)">
                      <option value=""></option>
                      <option value="Y">Ya</option>
                      <option value="T">Tidak</option>
                    </select></td>
                </tr>
              </table>
              <div style="height:5px;"></div>
              <div class="btn"><span><a href="#" id="add_laporan">Klik Untuk Menyimpan Laporan</a></span></div>
              <table width="99%" id="bb_laporan" cellpadding="0" cellspacing="0" class="listtemuan">
                <thead>
                  <tr>
                    <th>Bahan Berbahaya</th>
                    <th colspan="2">Kemasan</th>
                    <th colspan="3">Pengadaan</th>
                    <th colspan="3">Distribusi</th>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Ukuran</th>
                    <th>Repacking</th>
                    <th>Nama <br />
                      Alamat Pemasok</th>
                    <th>Status <br />
                      Pemasok</th>
                    <th>Ukuran <br />
                      Kemasan</th>
                    <th>Nama <br />
                      Alamat Pembeli</th>
                    <th>Jenis <br />
                      Sarana</th>
                    <th>Tujuan <br />
                      Penggunaan</th>
                  </tr>
                </thead>
                <tbody id="body_lap_bb">
                  <?php
					if(is_array($laporan_bb)){
						$jlap = count($laporan_bb);
						if($jlap > 0){
							for($i=0; $i<$jlap; $i++){
								?>
                  <tr id="rec<?php echo $i; ?>">
                    <td><input type="hidden" name="LAPORAN_BB[PRODUK_BB][]" value="<?php echo $laporan_bb[$i]['PRODUK_BB']; ?>">
                      <?php echo $laporan_bb[$i]['UR_PRODUK_BB']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[KEMASAN][]" value="<?php echo $laporan_bb[$i]['KEMASAN']; ?>">
                      <?php echo $laporan_bb[$i]['KEMASAN']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[REPACKING][]" value="<?php echo $laporan_bb[$i]['REPACKING']; ?>">
                      <?php echo $laporan_bb[$i]['UR_REPACKING']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[PENGADAAN_SARANA][]" value="<?php echo $laporan_bb[$i]['PENGADAAN_SARANA']; ?>">
                      <?php echo $laporan_bb[$i]['PENGADAAN_SARANA']; ?><br />
                      <input type="hidden" name="LAPORAN_BB[PENGADAAN_ALAMAT][]" value="<?php echo $laporan_bb[$i]['PENGADAAN_ALAMAT']; ?>">
                      <?php echo $laporan_bb[$i]['PENGADAAN_ALAMAT']; ?><br />
                      <input type="hidden" name="LAPORAN_BB[PENGADAAN_DAERAH_ID][]" value="<?php echo $laporan_bb[$i]['PENGADAAN_DAERAH_ID']; ?>">
                      <?php echo $laporan_bb[$i]['UR_PENGADAAN_DAERAH_ID']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[PENGADAAN_STATUS][]" value="<?php echo $laporan_bb[$i]['PENGADAAN_STATUS']; ?>">
                      <?php echo $laporan_bb[$i]['PENGADAAN_STATUS']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[PENGADAAN_KEMASAN][]" value="<?php echo $laporan_bb[$i]['PENGADAAN_KEMASAN']; ?>">
                      <?php echo $laporan_bb[$i]['PENGADAAN_KEMASAN']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_SARANA][]" value="<?php echo $laporan_bb[$i]['DISTRIBUSI_SARANA']; ?>">
                      <?php echo $laporan_bb['DISTRIBUSI_SARANA']; ?><br />
                      <input type="hidden" name="LAPORAN_BB[DISTRIBUSI_ALAMAT][]" value="<?php echo $laporan_bb[$i]['DISTRIBUSI_ALAMAT']; ?>">
                      <?php echo $laporan_bb[$i]['DISTRIBUSI_ALAMAT']; ?><br />
                      <input type="hidden" name="LAPORAN_BB[DISTRIBUSI_DAERAH_ID][]" value="<?php echo $laporan_id[$i]['DISTRIBUSI_DAERAH_ID']; ?>">
                      <?php echo $laporan_bb[$i]['UR_DISTRIBUSI_DAERAH_ID']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_JENIS][]" value="<?php echo $laporan_bb[$i]['DISTRIBUSI_JENIS']; ?>">
                      <?php echo $laporan_bb[$i]['DISTRIBUSI_JENIS']; ?></td>
                    <td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_TUJUAN][]" value="<?php echo $laporan_bb[$i]['DISTRIBUSI_TUJUAN']; ?>">
                      <?php echo $laporan_bb[$i]['DISTRIBUSI_TUJUAN']; ?><span style="float:right;"><a href="#" onclick="removelist($(this)); return false;" id="remove'<?php echo $i; ?>"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan laporan" /></a></span></td>
                  </tr>
                  <?php
							}
						}
					}
					?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Akhir Detil Pemeriksaaan !-->
        
        <div id="periksa-sebelumnya">
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PEMERIKSAAN SEBELUMNYA</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small"><a href="#" url="<?php echo $history_periksa; ?>" onclick="expand_detail($(this), 'detail_periksa'); return false;" id="detail_hisotry">Kesimpulan Pemeriksaan Sebelumnya</a></h2>
              <div id="detail_periksa"></div>
            </div>
          </div>
        </div>
        <!-- Akhir Pemeriksaan Sebelumnya !-->
        
        <div id="temuan-produk" <?php if(array_key_exists('TUJUAN_PEMERIKSAAN', $sess)){ if($sess['TUJUAN_PEMERIKSAAN'] == "Penelusuran Jaringan"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } }else{ echo 'style=""'; } ?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Temuan Produk</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Ada Temuan Bahan Berbahaya?</td>
                  <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_BB[ADA_TEMUAN]', $tanya_temuan, $sess['ADA_TEMUAN'], 'class="sel_header" title="Konfirmasi temuan produk" id="tanya_temuan"'); ?></td>
                </tr>
              </table>
              <table id="tb_bb" class="form_temuan">
                <tr>
                  <td class="temuan_left">Bahan Berbahaya</td>
                  <td class="temuan_right"><select class="stext" title="Bahan Berbahaya" id="nama_bb">
                      <option value=""></option>
                      <option value="Larutan Formaldehid">Larutan Formaldehid (Formalin)</option>
                      <option value="Paraformaldehid serbuk">Paraformaldehid serbuk</option>
                      <option value="Paraformaldehidtablet">Paraformaldehidtablet</option>
                      <option value="Boraks">Boraks</option>
                      <option value="Rhodamin B">Rhodamin B</option>
                      <option value="Kuning Metanil">Kuning Metanil</option>
                      <option value="Auramin">Auramin</option>
                      <option value="Amaran">Amaran</option>
                    </select></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Nama Dagang</td>
                  <td class="temuan_right"><input type="text" class="stext" id="nama_dagang" title="Nama Dagang"/></td>
                </tr>
                <tr>
                  <td class="temuan_left">Ukuran kemasan</td>
                  <td class="temuan_right"><input type="text" class="stext" id="ukuran_bb" title="Ukuran Kemasan"/></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Asal Bahan Berbahaya</td>
                  <td class="temuan_right"><?php echo form_dropdown('klasifikasi',$klasifikasi_temuan,'','class="stext" id="asal_bb" title="Pilih salah satu : Lokal , Impor"'); ?></td>
                </tr>
                <tr>
                  <td class="temuan_left">Sumber Pengadaan</td>
                  <td class="temuan_right"><?php echo form_dropdown('', $status_bb[0], $sess['STATUS_BB'], 'class="stext" title="Sumber Pengadaan" id="sumber_bb"'); ?></td>
                  <td class="temuan_pemisah">
                  <td class="temuan_left">Nama Sarana</td>
                  <td class="temuan_right"><input type="text" class="stext" id="sarana_bb" title="Nama Sarana Pengadaan" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana_bb"/></td>
                </tr>
                <tr>
                  <td class="temuan_left">Alamat</td>
                  <td class="temuan_right"><textarea class="stext" title="Alamat pengadaan" id="alamat_bb"></textarea></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Telepon</td>
                  <td class="temuan_right"><input type="text" class="stext" id="telepon_bb" title="Telepon Sarana Pengadaan"/></td>
                </tr>
                <tr>
                  <td class="temuan_left">Cara Pembelian </td>
                  <td class="temuan_right"><input type="text" class="stext" id="pembelian_bb" title="Cara pembelian"/></td>
                  <td class="temuan_pemisah">&nbsp;</td>
                  <td class="temuan_left">Status Produk</td>
                  <td class="temuan_right"><select class="stext" title="Status Produk" id="status_bb">
                      <option value=""></option>
                      <option value="1">Hasil Repacking</option>
                      <option value="0">Kemasan Original</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="temuan_left">Lampiran File</td>
                  <td colspan="4" class="temuan_right"><span class="upload_LABEL">
                    <input type="file" class="stext upload" jenis="LABEL" allowed="jpeg-jpg" url="<?php echo site_url(); ?>/utility/uploads/get_upload/<?php echo $sess['SARANA_ID'];?>" id="fileToUpload_LABEL" title="File Lampiran (attachment)" name="userfile" onchange="do_upload_produk($(this)); return false;"/>
                    &nbsp;
                    <div>Tipe File : *.jpeg, *.jpg</div>
                    </span><span class="file_LABEL"></span></td>
                </tr>
              </table>
              <div style="height:5px;"></div>
              <div class="btn"><span><a href="#" id="add_bb">Klik Untuk Menyimpan Temuan</a></span></div>
              <table width="99%" id="bb_temuan" cellpadding="0" cellspacing="0" class="listtemuan">
                <thead>
                  <tr>
                    <th>Bahan Berbahaya</th>
                    <th>Ukuran & <br />
                      Asal Bahan Berbahaya</th>
                    <th>Sumber Pengadaan</th>
                    <th>Cara Pembelian & <br />
                      Status Produk</th>
                  </tr>
                </thead>
                <tbody id="body_bb">
                  <?php
					if(is_array($produk_bb)){
						$jprod = count($produk_bb);
						if($jprod > 0){
							for($i=0; $i<$jprod; $i++){
								?>
                  <tr id="baris<?php echo $produk_bb[$i]['SERI']; ?>">
                    <td><input type="hidden" name="TEMUAN_PRODUK[NAMA_BB][]" value="<?php echo $produk_bb[$i]['NAMA_BB']; ?>">
                      <?php echo $produk_bb[$i]['NAMA_BB']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $produk_bb[$i]['NAMA_PRODUK']; ?>">
                      <?php echo $produk_bb[$i]['NAMA_PRODUK']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[LAMPIRAN][]" value="<?php echo $produk_bb[$i]['LAMPIRAN']; ?>">
                      <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $produk_bb[$i]['LAMPIRAN']; ?>" target="_blank">Lampiran File</a></td>
                    <td><input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="<?php echo $produk_bb[$i]['KEMASAN']; ?>">
                      <?php echo $produk_bb[$i]['KEMASAN']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="<?php echo $produk_bb[$i]['KLASIFIKASI_PRODUK']; ?>">
                      <?php echo $produk_bb[$i]['KLASIFIKASI_PRODUK']; ?></td>
                    <td><input type="hidden" name="TEMUAN_PRODUK[SUMBER_PENGADAAN][]" value="<?php echo $produk_bb[$i]['SUMBER_PENGADAAN']; ?>">
                      <?php echo $produk_bb[$i]['SUMBER_PENGADAAN']; ?>
                      <input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="<?php echo $produk_bb[$i]['NAMA_PERUSAHAAN']; ?>">
                      <br>
                      <?php echo $produk_bb[$i]['NAMA_PERUSAHAAN']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="<?php echo $produk_bb[$i]['ALAMAT_PERUSAHAAN']; ?>">
                      <?php echo $produk_bb[$i]['ALAMAT_PERUSAHAAN']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[TELEPON][]" value="<?php echo $produk_bb[$i]['TELEPON']; ?>">
                      <?php echo $produk_bb[$i]['TELEPON']; ?></td>
                    <td><input type="hidden" name="TEMUAN_PRODUK[CARA_PEMBELIAN][]" value="<?php echo $produk_bb[$i]['CARA_PEMBELIAN']; ?>">
                      <?php echo $produk_bb[$i]['CARA_PEMBELIAN']; ?><br>
                      <input type="hidden" name="TEMUAN_PRODUK[STATUS_REPACKING][]" value="<?php echo $produk_bb[$i]['STATUS_REPACKING']; ?>">
                      <?php echo $produk_bb[$i]['STATUS_REPACKING']; ?><span style="float:right;"><a href="#" id="baris_rec<?php echo $produk_bb[$i]['SERI']; ?>" onclick="removebb($(this)); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td>
                  </tr>
                  <?php
							}
						}else{
							echo "<tr><td colspan=\"4\">Data tidak ditemukan</td></tr>";
						}
					}
					?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Akhir Temuan Pemeriksaan !-->
        
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN dan TINDAK LANJUT</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Kesimpulan</h2>
            <table id="f02BB_tbhasil" class="form_tabel">
              <tr>
                <td class="td_left">Hasil Pemeriksaan</td>
                <td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN[HASIL]', $hasil, array_key_exists('HASIL', $sess)?$sess['HASIL']:'', 'id="f02BB_hasil" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Detil Kesimpulan 
                <td class="td_right"><textarea class="stext catatan" title="Catatan" name="PEMERIKSAAN_DIST_BB[CATATAN]"><?php echo $sess['CATATAN']; ?></textarea></td>
              </tr>
            </table>
            <h2 class="small garis htmpbb" <?php echo array_key_exists('STATUS_SARANA', $sess) && $sess['STATUS_SARANA'] == '4' ? '' : 'style="display:none"'; ?>>Jenis Bahan Berbahaya</h2>
            <table class="form_tabel" id="tbltmpbb" <?php echo array_key_exists('STATUS_SARANA', $sess) && $sess['STATUS_SARANA'] == '4' ? '' : 'style="display:none"'; ?>>
              <tr>
                <td class="td_left">Jenis bahan berbahaya yang pernah di kelola</td>
                <td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN_DIST_BB[KELOLA_BB][]', $arr_produk_tmpbb, array_key_exists('KELOLA_BB', $sess)?$sel_arr_produk_tmpbb:'', 'class="stext multiselect"" multiple style="height:140px;" id="bbkelola" title="Jenis bahan berbahaya yang pernah di kelola"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Pemasok (voluntary)</td>
                <td class="td_right"><textarea class="stext catatan" name="PEMERIKSAAN_DIST_BB[VOLUNTARY]" title="Voluntary"><?php echo $sess['VOLUNTARY']; ?></textarea></td>
              </tr>
            </table>
            <h2 class="small">Tindak Lanjut</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tindak lanjut</td>
                <td class="td_right"><div>
                    <input type="checkbox" <?php echo in_array('01', $arrtl) ? 'checked="checked"' : ''; ?> value="01" id="chk_rekomendasi" name="TINDAK_LANJUT[]" />
                    &nbsp;Rekomendasi</div>
                  <div>
                    <input type="checkbox" <?php echo in_array('02', $arrtl) ? 'checked="checked"' : ''; ?> value="02" id="chk_inventarisasi" name="TINDAK_LANJUT[]" />
                    &nbsp;Inventarisasi</div>
                  <div>
                    <input type="checkbox" <?php echo in_array('03', $arrtl) ? 'checked="checked"' : ''; ?> value="03" id="chk_larangan" name="TINDAK_LANJUT[]" />
                    &nbsp;Larangan Mengedarkan Sementara</div>
                  <div>
                    <input type="checkbox" <?php echo in_array('04', $arrtl) ? 'checked="checked"' : ''; ?> value="04" id="chk_contoh" name="TINDAK_LANJUT[]" />
                    &nbsp;Pengambilan Contoh</div>
                  <div>
                    <input type="checkbox" <?php echo in_array('05', $arrtl) ? 'checked="checked"' : ''; ?> value="05" id="chk_pembinaan" name="TINDAK_LANJUT[]" />
                    &nbsp;Pembinaan</div></td>
              </tr>
              <tr id="tr_rekomendasi" <?php echo in_array('01', $arrtl) || in_array('02', $arrtl) || in_array('03', $arrtl) ? '' : 'style="display:none;"'; ?>>
                <td class="td_left">Rekomendasi</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_BB[REKOMENDASI]', $status_bb[3], $sess['REKOMENDASI'], 'class="stext" title="Pilih salah rekomendasi" id="selrekomendasi"'); ?></td>
              </tr>
              <tr id="tr_catatan" <?php echo (in_array('02', $arrtl) || in_array('03', $arrtl) || in_array('04', $arrtl)) ? '' : 'style="display:none;"'; ?>>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea class="stext catatan" title="Rekomendasi yang diberikan" name="PEMERIKSAAN_DIST_BB[KEBIJAKAN]"><?php echo $sess['KEBIJAKAN']; ?></textarea></td>
              </tr>
              <tr id="tr_contoh" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
                <td class="td_left">Hasil Uji</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_BB[HASIL_UJI]', $hasil_uji, $sess['HASIL_UJI'], 'class="stext" title="Pilih salah rekomendasi" id="selrekomendasi"'); ?></td>
              </tr>
              <tr id="tr_kode_sampel" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
                <td class="td_left">Kode Sampel</td>
                <td class="td_right"><input type="text" class="stext" value="<?php echo $sess['KODE_SAMPEL']; ?>" name="PEMERIKSAAN_DIST_BB[KODE_SAMPEL]" title="Kode sampel hasil uji" /></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Temuan Pemeriksaan !-->
        
        <?php
		if(!array_key_exists('PERIKSA_ID', $sess)){
		?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN KLASIFIKASI KOMODITI LAIN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Temuan Klasifikasi Komoditi Lain</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Jenis Temuan</td>
                <td class="td_right"><?php echo form_dropdown('cb_konfirm', $this->config->item('konfirmasi'), '', 'id="cb_konfirm" class="stext" title="Pilih salah satu jenis temuan" onchange="sel_konfirmasi($(this));"'); ?></td>
              </tr>
              <tr id="tr_jenis_sarana" style="display:none;">
                <td class="td_left">Jenis Sarana</td>
                <td class="td_right"><?php echo form_dropdown('jns', $jenis_sarana, '', 'id="jns" class="stext" url="'.site_url().'/get/pemeriksaan/set_klasifikasi_sarana/" onchange="get_klasifikasi($(this));" title="Pilih salah satu jenis sarana"', $disinput); ?></td>
              </tr>
              <tr id="tr_jenis_klasifikasi" style="display:none;">
                <td class="td_left">Jenis Klasifikasi</td>
                <td class="td_right"><?php echo form_dropdown('kk', $klasifikasi_kategori, '', 'id="kk" class="stext" title="Pilih salah satu jenis klasifikasi"'); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Temuan Pemeriksaan !-->
        <?php
		}
		if($stat=="20102" || $stat=="20103" || $stat=="20113" || $stat=="20112" || $stat=="60020"){ ?>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Verifikasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Proses Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN[STATUS]',$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td>
              </tr>
            </table>
            <div style="padding-top:5px;">
              <h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan</a></h2>
              <div id="detail_log"></div>
            </div>
          </div>
        </div>
        <!-- Akhir Verifikasi !-->
        <?php
		}
		?>
      </div>
    </div>
    <div id="clear_fix"></div>
    <!--  !-->
    <div><a href="#" class="button save" onclick="fpost('#f02BBnew','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
    <div id="clear_fix"></div>
  </form>
</div>
<script type="text/javascript">
	var jmlcek = 0;
	$(document).ready(function(){
		create_ck("textarea.chk", 505);
		$("#div_izin").html('Loading..');
		$("#div_izin").load($("#div_izin").attr("url"));
		$("#detail_petugas").html("Loading ...");
		$("#detail_petugas").load($("#detail_petugas").attr("url"));
		$("#tujuan_periksa").change(function(){
			var kunci = $(this).val();
			var stts = $("#stts_sarana").val();
			if(kunci == "Penelusuran Jaringan"){
				$("#dtl-pemeriksaan, #periksa-sebelumnya").hide();
				$("#temuan-produk").show();
				$(".res").removeAttr("rel","");
				$(":input.jenis").attr('checked', false);
				$(":input.check_produk").each(function(){
					var inputan = $(this).parent().attr("class");
					$("."+inputan).remove();
				});
				$("#tanya_temuan").attr("rel","required");
			}else if(kunci == "Rutin" || kunci == "Kasus"){
				if(stts == "0" || stts == "4"){
					$("#dtl-pemeriksaan, #periksa-sebelumnya").hide();
					$("#temuan-produk").show();
					$(".res").removeAttr("rel","");
					$(":input.jenis").attr('checked', false);
					$(":input.check_produk").each(function(){
						var inputan = $(this).parent().attr("class");
						$("."+inputan).remove();
					});
				}else{
					$("#dtl-pemeriksaan, #periksa-sebelumnya").show();
					$("#temuan-produk").hide();
					$(".res").attr("rel","required");
				}
				$("#tanya_temuan").removeAttr("rel");
			}
		});
		$("#stts_sarana").change(function(){
			var nil = $(this).val();
			if(nil == "1"){
				if($("#tujuan_periksa option:selected").text() == "Penelusuran Jaringan"){
					$("#dtl-pemeriksaan").hide();
					$(".res").removeAttr("rel","");
				}else{
					$("#dtl-pemeriksaan").show();
					$(".res").attr("rel","required");
				}
				$("#f02BB_hasil").val('');
			}else if(nil == "0" || nil == "4"){
				$("#dtl-pemeriksaan").hide();
				$(".res").removeAttr("rel","");
				$(".res").removeAttr("rel","");
				$(":input.jenis").attr('checked', false);
				$(":input.check_produk").each(function(){
					var inputan = $(this).parent().attr("class");
					$("."+inputan).remove();
				});
				if(nil == "0"){
					$("#f02BB_hasil").val('TTP');
					$(".htmpbb, #tbltmpbb").hide();
					$("#bbkelola").removeAttr("rel");
				}else if(nil == "4"){
					$(".htmpbb, #tbltmpbb").show();
					$("#f02BB_hasil").val('TMBB');
					$("#bbkelola").attr("rel","required");
				}else{
					$("#f02BB_hasil").val('');
					$(".htmpbb, #tbltmpbb").hide();
					$("#bbkelola").removeAttr("rel");
				}
			}
		});
		$(".jenis").change(function(){
			var cls = $(this).val();
			var title = $(this).attr("title");
			if($(this).is(':checked')){
				$("."+cls).show();
				$("#lap_produk_bb").append("<option value='"+cls+"'>"+title+"</option>");
			}else{
				$("."+cls).hide();
				$("#lap_produk_bb option[value='"+cls+"']").remove();
				$(".produk_bb").each(function(){
					var id = $(this).parent().attr("id");
					var row = $(this).closest("tr").attr("id");
					var ip = $('#'+row+' td:nth-child(5)').find('input').attr('id');
					var chk = $('#'+id+' input:checkbox.check_produk:checked').length;
					var nchk = $('#'+id+' input:checkbox.check_produk:visible').length;
					if(chk < nchk){
						$("#"+ip).val('Tidak');
					}else if(chk == nchk){
						$("#"+ip).val('Ya');
					}else if(chk==0 && nchk==0){
						$("#"+ip).val('');
					}
				});
			}
			return false;
		});
		$('.check_produk:visible').each(function(){
			if($(this).is(':checked'))
				$(this).val('1');
			else
				$(this).val('0');
		});
		$("#lap_pengadaan_sarana").autocomplete($("#lap_pengadaan_sarana").attr("url"), {width: 244, selectFirst: false}); 
		$("#lap_pengadaan_sarana").result(function(event, data, formatted){ 
			if(data){
				$("#lap_pengadaan_id").val(data[1]);
				$(this).val(data[2]); 
				$("#lap_pengadaan_alamat").val(data[3]); 
				$("#lap_pengadaan_daerah_id").val(data[4]);
				$("#lap_pengadaan_status").val(data[5]);
			}else{
				$("#lap_pengadaan_id").val('');
			}
		});
		$("#lap_distribusi_sarana").autocomplete($("#lap_distribusi_sarana").attr("url"), {width: 244, selectFirst: false}); 
		$("#lap_distribusi_sarana").result(function(event, data, formatted){ 
			if(data){ 
				$("#lap_distribusi_id").val(data[1]);
				$(this).val(data[2]); 
				$("#lap_distribusi_alamat").val(data[3]);
				$("#lap_distribusi_daerah_id").val(data[4]);
				$("#lap_distribusi_jenis").val(data[5]); 
			}else{
				$("#lap_distribusi_id").val('');
			}
		});
		$("#sarana_bb").autocomplete($("#sarana_bb").attr("url"), {width: 244, selectFirst: false}); 
		$("#sarana_bb").result(function(event, data, formatted){ 
			if(data){ 
				$(this).val(data[2]); 
				$("#alamat_bb").val(data[3]); 
			} 
		});
		$("#kemasan_id").change(function(){
			var kemasanid = $(this).val();
			if(kemasanid == ""){
				$("#lap_kemasan").val('');
			}else{
				$.get($(this).attr('url') + kemasanid, function(hasil){
					$("#lap_kemasan").val(hasil);
				});
			}
		});
		$("#chk_rekomendasi").change(function(){
			if($(this).is(':checked')){
				$("#tr_rekomendasi").show();
			}else if(($(this).is(':checked') && $("#chk_inventarisasi").is(':checked')) || ($(this).is(':checked') && $("#chk_larangan").is(':checked'))){
				$("#tr_rekomendasi").show();
				$("#tr_catatan").show();
			}else if($(this).is(':checked') && $("#chk_contoh").is(':checked')){
				$("#tr_rekomendasi").show();
				$("#tr_contoh").show();
				$("#tr_kode_sampel").show();
			}else if($(this).is(':checked') && $("#chk_pembinaan").is(':checked')){
				$("#tr_rekomendasi").hide();
				$("#tr_catatan").hide();
			}else{
				$("#tr_rekomendasi").hide();
				$("#tr_catatan").hide();
				$("#tr_kode_sampel").hide();
			}
		});
		$("#chk_inventarisasi").change(function(){
			if($(this).is(':checked')){
				$("#tr_catatan").show();
			}else if($(this).is(':checked') || $("#chk_larangan").is(':checked')){
				$("#tr_catatan").show();
			}else if($(this).is(':checked') && $("#chk_contoh").is(':checked')){
				$("#tr_catatan").show();
				$("#tr_contoh").show();
				$("#tr_kode_sampel").show();
			}else{
				$("#tr_catatan").hide();
				$("#tr_contoh").hide();
				$("#tr_kode_sampel").hide();
			}
		});
		$("#chk_larangan").change(function(){
			if($(this).is(':checked')){
				$("#tr_catatan").show();
			}else if($(this).is(':checked') || $("#chk_inventarisasi").is(':checked')){
				$("#tr_catatan").show();
			}else{
				$("#tr_catatan").hide();
			}
		});
		$("#chk_contoh").change(function(){
			if($(this).is(':checked')){
				$("#tr_contoh").show();
				$("#tr_kode_sampel").show();
			}else{
				$("#tr_contoh").hide();
				$("#tr_kode_sampel").hide();
			}
		});
		$("#selrekomendasi").change(function(){
			var val = $(this).val();
			if(val == "05"){
				$("#tr_catatan").css("display","");
			}else{
				$("#tr_catatan").css("display","none");
			}
			return false;
		});
		$("#lap_pengadaan_status").change(function(){
			var val = $(this).val();
			if(val == "STB"){
				$("tr#stts_pemasok").show();
			}else{
				$("tr#stts_pemasok").hide();
			}
			return false;
		});
		$("#lap_distribusi_jenis").change(function(){
			var val = $(this).val();
			if(val == "STB" || val == "PA"){
				$("tr#stts_jns_sarana").show();
			}else{
				$("tr#stts_jns_sarana").hide();
			}
			return false;
		});
		$("#add_bb").click(function(){
			if(!beforeSubmit("#tb_bb")){
				return false;
			}else{
				var urut = $("#body_bb tr").length; 
				var str = '<tr id="baris'+(urut+1)+'"><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_BB][]" value="'+$("#nama_bb").val()+'">'+$("#nama_bb option:selected").text()+'<br><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="'+$("#nama_dagang").val()+'">'+$("#nama_dagang").val()+'<br><input type="hidden" name="TEMUAN_PRODUK[LAMPIRAN][]" value="'+$("#lampiran_temuan").val()+'"><a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/'+$("#lampiran_temuan").val()+'" target="_blank">Lampiran File</a></td><td><input type="hidden" name="TEMUAN_PRODUK[KEMASAN][]" value="'+$("#ukuran_bb").val()+'">'+$("#ukuran_bb").val()+'<br><input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="'+$("#asal_bb").val()+'">'+$("#asal_bb option:selected").text()+'</td><td><input type="hidden" name="TEMUAN_PRODUK[SUMBER_PENGADAAN][]" value="'+$("#sumber_bb").val()+'">'+$("#sumber_bb option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="'+$("#sarana_bb").val()+'"><br>'+$("#sarana_bb").val()+'<br><input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="'+$("#alamat_bb").val()+'">'+$("#alamat_bb").val()+'<br><input type="hidden" name="TEMUAN_PRODUK[TELEPON][]" value="'+$("#telepon_bb").val()+'">'+$("#telepon_bb").val()+'</td><td><input type="hidden" name="TEMUAN_PRODUK[CARA_PEMBELIAN][]" value="'+$("#pembelian_bb").val()+'">'+$("#pembelian_bb").val()+'<br><input type="hidden" name="TEMUAN_PRODUK[STATUS_REPACKING][]" value="'+$("#status_bb").val()+'">'+$("#status_bb option:selected").text()+'<span style="float:right;"><a href="#" id="baris_rec'+(urut+1)+'" onclick="removebb($(this)); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td></tr>';
				$(".upload_LABEL").show();
				$("#fileToUpload_LABEL").val('');
				$(".file_LABEL").html('');
				$("#body_bb").append(str);
				clearForm("#tb_bb");
				return false;
			}
		});
		$("#add_laporan").click(function(){
			if(!beforeSubmit("#lap_bb")){
				return false;
			}else{
				var no = $("#body_bb tr").length;
				var lp = $("#lap_pengadaan_status").val();
				var jns = $("#lap_distribusi_jenis").val();
				var txt_lp = "";
				var txt_jns = "";
				if(lp == "STB"){
					txt_lp = '<div>'+$("#clap_pengadaan_status").val()+'<input type="hidden" name="LAPORAN_BB[PENGADAAN_SARANA_CATATAN][]" value="'+$("#clap_pengadaan_status").val()+'"></div>';
				}else{
					txt_lp = "";
				}
				
				if(jns == "PA" || jns == "STB"){
					txt_jns = '<div>'+$("#c_stts_jns_sarana").val()+'<input type="hidden" name="LAPORAN_BB[DISTRIBUSI_JENIS_CATATAN][]" value="'+$("#c_stts_jns_sarana").val()+'"></div>';
				}else{
					txt_jns = "";
				}
				var clsrow = $("#lap_produk_bb").val();
				var strs = '<tr id="rec'+(parseInt(no)+1)+'" class="'+clsrow+'"><td><input type="hidden" name="LAPORAN_BB[PENGADAAN_ID][]" value="'+$("#lap_pengadaan_id").val()+'"><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_ID][]" value="'+$("#lap_distribusi_id").val()+'"><input type="hidden" name="LAPORAN_BB[PRODUK_BB][]" value="'+$("#lap_produk_bb").val()+'">'+$("#lap_produk_bb option:selected").text()+'<br></td><td><input type="hidden" name="LAPORAN_BB[KEMASAN][]" value="'+$("#lap_kemasan").val()+'">'+$("#lap_kemasan").val()+'</td><td><input type="hidden" name="LAPORAN_BB[REPACKING][]" value="'+$("#lap_repacking").val()+'">'+$("#lap_repacking option:selected").text()+'</td><td><input type="hidden" name="LAPORAN_BB[PENGADAAN_SARANA][]" value="'+$("#lap_pengadaan_sarana").val()+'">'+$("#lap_pengadaan_sarana").val()+'<br />'+txt_lp+'<br><input type="hidden" name="LAPORAN_BB[PENGADAAN_ALAMAT][]" value="'+$("#lap_pengadaan_alamat").val()+'">'+$("#lap_pengadaan_alamat").val()+'<br /><input type="hidden" name="LAPORAN_BB[PENGADAAN_DAERAH_ID][]" value="'+$("#lap_pengadaan_daerah_id").val()+'">'+$("#lap_pengadaan_daerah_id option:selected").text()+'</td><td><input type="hidden" name="LAPORAN_BB[PENGADAAN_STATUS][]" value="'+$("#lap_pengadaan_status").val()+'">'+$("#lap_pengadaan_status option:selected").val()+'</td><td><input type="hidden" name="LAPORAN_BB[PENGADAAN_KEMASAN][]" value="'+$("#lap_pengadaan_kemasan").val()+'">'+$("#lap_pengadaan_kemasan").val()+'</td><td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_SARANA][]" value="'+$("#lap_distribusi_sarana").val()+'">'+$("#lap_distribusi_sarana").val()+'<br /><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_ALAMAT][]" value="'+$("#lap_distribusi_alamat").val()+'">'+$("#lap_distribusi_alamat").val()+'<br /><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_DAERAH_ID][]" value="'+$("#lap_distribusi_daerah_id").val()+'">'+$("#lap_distribusi_daerah_id option:selected").text()+'</td><td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_JENIS][]" value="'+$("#lap_distribusi_jenis").val()+'">'+$("#lap_distribusi_jenis option:selected").text()+'<br>'+txt_jns+'</td><td><input type="hidden" name="LAPORAN_BB[DISTRIBUSI_TUJUAN][]" value="'+$("#lap_distribusi_tujuan").val()+'">'+$("#lap_distribusi_tujuan").val()+'<span style="float:right;"><a href="#" onclick="removelist($(this)); return false;" id="remove'+(no+1)+'"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan laporan" /></a></span></td></tr>';
				$("#body_lap_bb").append(strs);
				jConfirm('Apakah anda akan menambah temuan pengadaan sarana dengan sarana distribusi yang berbeda ?', 'SIPT Versi 1.0', function(r){
					if(r==true){
						$("#lap_distribusi_sarana").val('');
						$("#lap_distribusi_alamat").val('');
						$("#lap_distribusi_daerah_id").val('');
						$("#lap_distribusi_jenis").val('');
						$("#lap_distribusi_tujuan").val('');
						$("#c_stts_jns_sarana").val('');
						$("#kemasan_id").val('');
						$("#lap_kemasan").val('');
						$("#lap_repacking").val('');
					}else{
						clearForm("#lap_bb");
					}
				});
				return false;
			}
		});
		$(".del_upload").live("click", function(){
			var jenis = $(this).attr("jns");
			$.ajax({
				type: "GET",
				url: $(this).attr("url"),
				data: $(this).serialize(),
				success: function(data){
					var arrdata = data.split("#");
					$(".upload_"+jenis+"").show();
					$("#fileToUpload_"+jenis+"").val('');
					$(".file_"+jenis+"").html("");
				}
			});
			return false;
		});
		<?php
		if($sess['PERIKSA_ID'] != ""){
			?>
			$(".jenis").each(function(){
				var cls = $(this).val();
				var title = $(this).attr("title");
				if($(this).is(':checked')){
					$("#lap_produk_bb").append("<option value='"+cls+"'>"+title+"</option>");
				}else{
					$("#body_bb tr."+cls+"").remove();
				}
			});			
			<?php
		}
		?>
	});
	
	function removelist(obj){
		var row = $(obj).closest("tr").attr("id");
		jConfirm('Apakah anda akan menghapus atau membatalkan temuan tersebut ?', 'SIPT Versi 1.0', function(r){
		if(r==true){
				$("#"+row).remove();
			}else{
				return false;
			}
		});
	}
	
	function removebb(obj){
		var row = $(obj).closest("tr").attr("id");
		jConfirm('Apakah anda akan menghapus atau membatalkan temuan tersebut ?', 'SIPT Versi 1.0', function(r){
		if(r==true){
				$("#"+row).remove();
			}else{
				return false;
			}
		});
	}
	
	function checklist(obj){
		var jml = 0;
		var row = $(obj).closest("tr").attr("id");
		var chkid = $(obj).attr("id");
		var hiddname = $(obj).attr("name");
		var next = $("#"+row+" td:nth-child(5)").find("input").attr("id");
		var cek = $("#"+row+" input:checkbox:checked").length;
		$("#"+row+" :input.check_produk:visible").each(function(){
			jml++;
		});
		if(cek < jml){
			$("#"+next).val('Tidak');
		}else if(cek == jml){
			$("#"+next).val('Ya');
		}else if(cek > jml){
			$("#"+next).val('');
		}
		if($(obj).is(':checked')){
			$("#hidden_"+chkid).remove();
		}else{
			arrdiv = row.split('_');
			$("#chk_"+arrdiv[1]).append('<input type="hidden" name="'+hiddname+'" value="0" id="hidden_'+chkid+'" />');
		}
		return false;
	}
	
	function chkrepack(obj){
		var jml = 0;
		var row = $(obj).closest("tr").attr("id");
		var chkid = $(obj).attr("id");
		var hiddname = $(obj).attr("name");
		var next = $("#"+row+" td:nth-child(5)").find("input").attr("id");
		var cek = $("#"+row+" input:checkbox:checked").length;
		$("#"+next).attr('rel','required');
		if(cek > 0){
			$("#"+next).val('Ya');
		}else{
			$("#"+next).val('');
			$("#"+next).removeAttr("rel","required");
		}
		if($(obj).is(':checked')){
			$("#hidden_"+chkid).remove();
		}else{
			arrdiv = row.split('_');
			$("#chk_"+arrdiv[1]).append('<input type="hidden" name="'+hiddname+'" value="0" id="hidden_'+chkid+'" />');
		}
		return false;
	}
	
	function do_upload(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+jenis+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 ");
					}else{
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"PEMERIKSAAN_DIST_BB["+arrdata[2]+"]\" value="+arrdata[0]+">");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}

	function do_upload_produk(element){
		var jenis = $(element).attr("jenis");
		var allowed = $(element).attr("allowed");
		$.ajaxFileUpload({
			url: $(element).attr("url")+'/'+jenis+'/'+allowed,
			secureuri: false,
			fileElementId: $(element).attr("id"),
			dataType: "json",
			success: function(data){
				var arrdata = data.msg.split("#");
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						jAlert(data.error, "SIPT Versi 1.0 ");
					}else{
						$(".upload_"+arrdata[2]+"").hide();
						$("#fileToUpload_"+arrdata[2]+"").removeAttr("rel");
						$(".file_"+arrdata[2]+"").html("<input type=\"hidden\" value="+arrdata[0]+" id=\"lampiran_temuan\"><b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/"+arrdata[3]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[3]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a>");
					}
				}
			},
			error: function (data, status, e){
				jAlert(e, "SIPT Versi 1.0 Beta");
			}
		});
	}
	
</script>