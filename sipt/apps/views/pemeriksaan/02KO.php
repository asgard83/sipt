<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f02KO_" id="f02KO_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nama Sarana Distribusi / Toko</td>
                <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
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
                <td class="td_left">Nama Pimpinan</td>
                <td class="td_right"><?php echo $sess['NAMA_PIMPINAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama Penanggung Jawab</td>
                <td class="td_right"><?php echo $sess['PENANGGUNG_JAWAB']; ?></td>
              </tr>
            </table>
            <h2 class="small">Izin yang Dimiliki</h2>
            <div id="div_izin" url="<?php echo $url_izin;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Petugas Pemeriksa</h2>
            <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
            <div style="height:5px;"></div>
            <h2 class="small">Informasi Pemeriksaan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tanggal Pemeriksaan</td>
                <td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" />
                  <input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />
                  &nbsp; sampai dengan &nbsp;
                  <input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[TUJUAN_PEMERIKSAAN]', $tujuan_pemeriksaan, $sess['TUJUAN_PEMERIKSAAN'], 'class="stext" id="F02PR_tujuan" rel="required" title="Tujuan Pemeriksaan"'); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Informasi Pemeriksaan !-->
        
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small">I. Klasifikasi</h2>
            <table class="form_tabel">
              <tr>
                <td width="10"></td>
                <td width="405" class="isi">1.1. Bertindak sebagai</td>
                <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[KLASIFIKASI_PEMERIKSAAN]',$klasifikasi_distribusi,array_key_exists('KLASIFIKASI_PEMERIKSAAN', $sess)?$sess['KLASIFIKASI_PEMERIKSAAN']:'','class="stext" id="F02KO_klasifikasi" rel="required" title="Pilih salah satu klasifkasi : Importir, Badan Usaha, Distribusi, Penjualan melalui media eletkronik"'); ?></td>
              </tr>
            </table>
            <h2 class="small">II. Administrasi</h2>
            <div class="importir" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Importir Kosmetika"){ echo 'style=""';}else{ echo 'style="display:none;"';}?> >
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td colspan="2" class="isi">&bull; Bertindak sebagai importir</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="F02KO_point21a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Memiliki  surat penunjukan dari produsen / distributor di luar negeri</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[0],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[0]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Memiliki  Angka Pengenal Importir (API)</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[1],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[1]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21c">
                  <td></td>
                  <td class="atas">c.</td>
                  <td class="atas">Memiliki dokumen persetujuan pendaftaran</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[2],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[2]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21d">
                  <td></td>
                  <td class="atas">d.</td>
                  <td class="atas">Mempunyai  Dokumen Informasi Produk (DIP) </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[3],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[3]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21e">
                  <td></td>
                  <td class="atas">e.</td>
                  <td class="atas">Memiliki  Surat Keterangan Impor (SKI)</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[4],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[4]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21f">
                  <td></td>
                  <td class="atas">f.</td>
                  <td class="atas">Memiliki  faktur pembelian / pesanan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[5],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[5]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21g">
                  <td></td>
                  <td class="atas">g.</td>
                  <td class="atas">Mengeluarkan  faktur / bon penjualan </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[6],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[6]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21h">
                  <td></td>
                  <td class="atas">h.</td>
                  <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[7],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[7]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21i">
                  <td></td>
                  <td class="atas">i.</td>
                  <td class="atas">Surat Keterangan GMP Produsen luar negeri</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[8],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[8]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point21j">
                  <td></td>
                  <td class="atas">j.</td>
                  <td class="atas">Certificate of Free Sale (CFS) </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[43],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[40]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <div <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Badan Usaha / Perorangan Sebagai Pemohon Notifikasi Kosmetika" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan kosmetik melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?> class="badan">
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td colspan="4" class="isi">&bull; Bertindak  sebagai Badan  Usaha / Usaha Perorangan Sebagai Pemohon  notifikasi kosmetika</td>
                </tr>
                <tr id="F02KO_point22a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Memiliki  surat perjanjian kontrak produksi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[9],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[9]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Memiliki dokumen persetujuan pendaftaran</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[10],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[10]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22c">
                  <td></td>
                  <td class="atas">c.</td>
                  <td class="atas">Mempunyai  Dokumen Informasi Produk (DIP)</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[11],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[11]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22d">
                  <td></td>
                  <td class="atas">d.</td>
                  <td class="atas">Memiliki  faktur pembelian / pesanan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[12],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[12]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22e">
                  <td></td>
                  <td class="atas">e.</td>
                  <td class="atas">Mengeluarkan  faktur / bon penjualan </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[13],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[13]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22f">
                  <td></td>
                  <td class="atas">f.</td>
                  <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[14],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[14]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point22g">
                  <td></td>
                  <td class="atas">g.</td>
                  <td class="atas">Sertifikat CPKB penerima kontrak produksi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[15],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[15]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <div <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Distribusi" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Distributor" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Agen" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Stokist MLM" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Klinik Kecantikan / Salon / Spa" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Toko Kosmetik / Swalayan / Pengecer" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Lain-lain" || $sess['KLASIFIKASI_PEMERIKSAAN'] == "Penjualan kosmetik melalui media elektronik"){ echo 'style=""'; }else{ echo 'style="display:none;"';}?> class="distributor">
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td colspan="2" class="isi">&bull; Bertindak sebagai Distribusi</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="F02KO_point23a">
                  <td></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Memiliki  izin sarana yang sesuai</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[16],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[16]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point23b">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Memiliki  faktur pembelian </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[17],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[17]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point23c">
                  <td></td>
                  <td class="atas">c.</td>
                  <td class="atas">Mengeluarkan  bon penjualan </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[18],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[18]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point23d">
                  <td></td>
                  <td class="atas">d.</td>
                  <td class="atas">Ada  pencatatan pemasukan dan penjualan dalam kartu stock</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[19],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[19]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <h2 class="small">III. Penyimpanan</h2>
            <div class="F02KO_gudang">
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td colspan="2" class="isi" width="385">3.1. Tempat  penyimpanan</td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr>
                  <td></td>
                  <td width="20">a.</td>
                  <td width="385">Memiliki gudang</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,is_array($aspek_check)?$aspek_check[20]:'Y','class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak" onchange="show_hide($(this).val(), \'.detail_gudang\');"'); ?></td>
                </tr>
              </table>
            </div>
            <div class="detail_gudang" <?php if(is_array($aspek_check)){ if($aspek_check[20] == "Y"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
              <table class="form_tabel">
                <tr id="F02KO_gudang_detail1">
                  <td width="10"></td>
                  <td width="20">&nbsp;</td>
                  <td width="385">- Memiliki gudang pada alamat yang sama</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[21],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[20]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail2">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>- Memiliki  gudang pada alamat lain</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[22],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[21]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail3">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>- Memiliki  gudang yang memenuhi syarat</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[23],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[22]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail4">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;&nbsp;1.&nbsp;Kebersihan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[24],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[23]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail5">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;&nbsp;2.&nbsp;Terhindar  dari binatang pengerat</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[25],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[24]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail6">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;&nbsp;3.&nbsp;Dilengkapi  pendingin udara untuk produk tertentu </td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[26],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[25]; ?></textarea></td>
                </tr>
                <tr id="F02KO_gudang_detail7">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;&nbsp;4.&nbsp;Terhindar  dari kebocoran</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[27],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_gudang"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[26]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <div class="F02KO_display_produk">
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td width="20">b.</td>
                  <td width="385">Tempat  display produk</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[28],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak" onchange="show_hide($(this).val(), \'.detail_display\');"'); ?></td>
                </tr>
              </table>
            </div>
            <div class="detail_display"<?php if(is_array($aspek_check)){ if($aspek_check[28] == "Y"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
              <table class="form_tabel">
                <tr id="F02KO_display_produk_detail1">
                  <td width="10"></td>
                  <td width="20">&nbsp;</td>
                  <td width="385">- Lemari / tempat tertutup</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[29],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_display"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[27]; ?></textarea></td>
                </tr>
                <tr id="F02KO_display_produk_detail2">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>- Rak</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[30],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_display"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[28]; ?></textarea></td>
                </tr>
                <tr id="F02KO_display_produk_detail3">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>- Lain-lain</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[31],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_display"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[29]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <div class="F02KO_display_produk1">
              <table class="form_tabel">
                <tr>
                  <td width="10"></td>
                  <td width="20">c.</td>
                  <td width="385">Tempat display produk memenuhi syarat</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[32],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak" onchange="show_hide($(this).val(), \'.detail_syarat\');"'); ?></td>
                </tr>
              </table>
            </div>
            <div class="detail_syarat" <?php if(is_array($aspek_check)){ if($aspek_check[32] == "Y"){ echo 'style=""'; }else{ echo 'style="display:none;"';} }else{ echo 'style=""';}?>>
              <table class="form_tabel">
                <tr id="F02KO_display_produk1_detail1">
                  <td width="10"></td>
                  <td width="20">&nbsp;</td>
                  <td width="385">1. Kebersihan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[33],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_syarat"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[30]; ?></textarea></td>
                </tr>
                <tr id="F02KO_display_produk1_detail2">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>2. Terhindar  dari binatang pengerat</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[34],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_syarat"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[31]; ?></textarea></td>
                </tr>
                <tr id="F02KO_display_produk1_detail3">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>3. Dilengkapi  pendingin udara untuk produk tertentu</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[35],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_syarat"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[32]; ?></textarea></td>
                </tr>
                <tr id="F02KO_display_produk1_detail4">
                  <td></td>
                  <td>&nbsp;</td>
                  <td>4. Terhindar  dari kebocoran</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[36],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?><input type="hidden" class="detail_syarat"></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[33]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <div class="F02KO_penyimpanan">
              <table class="form_tabel">
                <tr>
                  <td></td>
                  <td colspan="2" class="isi">3.2. Cara  penyimpanan/penyusunan</td>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="F02KO_point321">
                  <td width="10"></td>
                  <td width="20" class="atas">a.</td>
                  <td width="385" class="atas">Khusus/  tersendiri</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[37],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[34]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point322">
                  <td></td>
                  <td class="atas">b.</td>
                  <td class="atas">Cara  meletakkan produk teratur</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[38],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[35]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point323">
                  <td class="atas"></td>
                  <td class="atas">c.</td>
                  <td>Mengikuti sistem FIFO</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[39],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[36]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point324">
                  <td></td>
                  <td class="atas">d.</td>
                  <td class="atas">Mengikuti  sistem FEFO</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[40],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[37]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point325">
                  <td></td>
                  <td class="atas">e.</td>
                  <td class="atas">Bercampur  dengan produk  lain</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[41],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[38]; ?></textarea></td>
                </tr>
                <tr id="F02KO_point326">
                  <td></td>
                  <td class="atas">f.</td>
                  <td class="atas">Bercampur  dengan barang lain</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]',$pilihan,$aspek_check[42],'class="sel_penyimpangan" title="Pilih salah satu, Ya atau Tidak"'); ?></td>
                  <td class="atas"><textarea class="stext" title="Keterangan" name="PEMERIKSAAN_DIST_KOS[ASPEK_KETERANGAN][]"><?php echo $aspek_keterangan[39]; ?></textarea></td>
                </tr>
              </table>
            </div>
            <h2 class="small">Hasil Temuan Lainnya yang Tidak Tercantum dalam Aspek Penilaian</h2>
            <table id="form_tabel">
              <tr>
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_DIST_KOS[HASIL_TEMUAN_LAIN]" id="TEMUAN_LAIN" title="Hasil temuan lainnya yang tidak tercantum dalam aspek penilaian"><?php echo $sess['HASIL_TEMUAN_LAIN'];?></textarea></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Detil Pemeriksaan !-->
        
        <div class="importir_dip" <?php if($sess['KLASIFIKASI_PEMERIKSAAN'] == "Importir Kosmetika"){ echo 'style=""';}else{ echo 'style="display:none;"';}?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PEMERIKSAAN DIP</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Pemeriksaan DIP</h2>
              <table class="form_tabel">
                <tr>
                  <td>Bagian I : Dokumen Administrasi & Ringkasan Produk</td>
                </tr>
                <tr>
                  <td><textarea name="PEMERIKSAAN_DIST_KOS[HASIL_DIP_A]" class="stext catatan" title="Pemeriksaan DIP : Dokumen administrasi dan ringkasan produk"><?php echo $sess['HASIL_DIP_A']; ?></textarea></td>
                </tr>
                <tr>
                  <td>Bagian II : Data Mutu Keamanan dan Bahan Kosmetik</td>
                </tr>
                <tr>
                  <td><textarea name="PEMERIKSAAN_DIST_KOS[HASIL_DIP_B]" class="stext catatan" title="Pemeriksaan DIP : Data mutu keamanan dan bahan kosmetik"><?php echo $sess['HASIL_DIP_B']; ?></textarea></td>
                </tr>
                <tr>
                  <td>Bagian III : Data Mutu Kosmetik</td>
                </tr>
                <tr>
                  <td><textarea name="PEMERIKSAAN_DIST_KOS[HASIL_DIP_C]" class="stext catatan" title="Pemeriksaan DIP : Data mutu kosmetik"><?php echo $sess['HASIL_DIP_C']; ?></textarea></td>
                </tr>
                <tr>
                  <td>Bagian IV : Data Keamanan dan Kemanfaatan Kosmetik</td>
                </tr>
                <tr>
                  <td colspan="2"><textarea name="PEMERIKSAAN_DIST_KOS[HASIL_DIP_D]" class="stext catatan" title="Pemeriksaan DIP : Data keamanan dan kemanfaatan kosmetik"><?php echo $sess['HASIL_DIP_D']; ?></textarea></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- Akhir DIP !--> 
        </div>
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Temuan Produk</h2>
            <input type="hidden" value="0" id="flag">
            <table id="F02KO_tbtms" class="form_temuan">
              <tr>
                <td class="temuan_left">Nama Kosmetik</td>
                <td class="temuan_right"><input type="text" class="stext" id="F02KO_temuan_kosmetik" title="Nama Kosmetik" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/kos" /></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Nama Perusahaan</td>
                <td class="temuan_right"><input type="text" class="stext" id="F02KO_temuan_perusahaan" title="Nama perusahaan"/></td>
              </tr>
              <tr>
                <td class="temuan_left">Klasifikasi Produk</td>
                <td class="temuan_right"><?php echo form_dropdown('F02KO_klasifikasi_produk',$klasifikasi_temuan,'','class="stext" id="F02KO_klasifikasi_produk" title="Pilih salah satu : Lokal , Impor"'); ?></span></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Alamat Perusahaan</td>
                <td class="temuan_right"><textarea class="stext" name="F02KO_temuan_alamat" id="F02KO_temuan_alamat" title="Alamat perusahaan"></textarea></td>
              </tr>
              <tr>
                <td class="temuan_left">Tanggal Expire</td>
                <td class="temuan_right"><input type="text" class="sdate" name="F02KO_temuan_expire" id="F02KO_temuan_expire" title="Tanggal expire" />
                  &nbsp;<small>Jika kosong, isi dengan tanda - (strip)</small></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">No. Registrasi / Notifkasi</td>
                <td class="temuan_right"><input type="text" class="stext" id="F02KO_temuan_noreg" name="F02KO_temuan_noreg" title="No. Registrasi / Notifikasi"/></td>
              </tr>
              <tr>
                <td class="temuan_left">No. Batch</td>
                <td class="temuan_right"><input type="text" class="stext" id="F02KO_temuan_nobatch" name="F02KO_temuan_nobatch" title="No. Batch" /></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Netto</td>
                <td class="temuan_right"><input type="text" class="sdate" id="F02KO_temuan_satuan" name="F02KO_temuan_satuan" title="Netto produk"/>
                  &nbsp;<small>Pemisah desimal gunakan titik</small></td>
              </tr>
              <tr>
                <td class="temuan_left">Harga Satuan</td>
                <td class="temuan_right"><input type="text" class="sdate" id="F02KO_temuan_harga" name="F02KO_temuan_harga" onkeyup="numericOnly($(this))" title="Harga satuan" /></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Jumlah Temuan</td>
                <td class="temuan_right"><input type="text" name="F02KO_temuan_jumlah" id="F02KO_temuan_jumlah" class="sdate" onkeyup="numericOnly($(this))" title="Jumlah temuan"  />
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <select name="F02KO_satuan" id="F02KO_satuan" class="sel_penyimpangan" title="Satuan kemasan">
                    <option value="Buah/Pieces">Buah/Pieces</option>
                    <option value="Sachet">Sachet</option>
                    <option value="Bungkus">Bungkus</option>
                    <option value="Botol">Botol</option>
                    <option value="Kaleng">Kaleng</option>
                    <option value="Karton">Karton</option>
                    <option value="Cup">Cup</option>
                    <option value="Tube">Tube</option>
                  </select></td>
              </tr>
              <tr>
                <td class="temuan_left">Kategori Temuan</td>
                <td class="temuan_right"><?php echo form_dropdown('F02KO_temuan_kategori',$kategori_temuan,'','class="stext" id="F02KO_temuan_kategori" title="Pilih salah satu : TIE, Dilarang, Penandaan, Kadaluarsa, Rusak"'); ?></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Jenis Pelanggaran</td>
                <td class="temuan_right"><input type="text" id="F02KO_temuan_pelanggaran" class="stext" name="F02KO_temuan_pelanggaran" title="Jenis pelanggaran" /></td>
              </tr>
              <tr>
                <td class="temuan_left">Tindakan Produk</td>
                <td class="temuan_right"><?php echo form_dropdown('F02KO_tindakan_produk',$tindak_lanjut_temuan,'','class="stext" id="F02KO_tindakan_produk" title="Pilih salah satu : Pengamanan, Pemusnahan, Penarikan"'); ?></td>
                <td class="temuan_pemisah">&nbsp;</td>
                <td class="temuan_left">Keterangan Sumber (perolehan)</td>
                <td class="temuan_right"><input type="text" id="F02KO_temuan_keterangan" class="stext" name="F02KO_temuan_keterangan" title="Keterangan sumber (perolehan)" /></td>
              </tr>
            </table>
            <div style="height:5px;"></div>
            <div class="btn"><span><a href="#" id="F02KO_add_temuan">Tambah Temuan</a></span></div>
            <div style="padding-bottom:5px;"></div>
            <table width="99%" id="F02KO_temuankos" cellpadding="0" cellspacing="0" class="listtemuan">
              <thead>
                <tr>
                  <th>Detil Kosmetik</th>
                  <th>Klasifikasi</th>
                  <th>Nama<br />
                    Perusahaan</th>
                  <th>Kategori<br />
                    Temuan</th>
                  <th>Jenis <br />
                    Pelanggaran</th>
                  <th>Harga Total</th>
                  <th>Keterangan<br />
                    (sumber perolehan)</th>
                </tr>
              </thead>
              <tbody id="F02KO_temuanbodykos">
                <?php
					    if(!$temuan_produk==''){
							if($sess['JMLTEMUAN'] != 0){
								for($i=0; $i<count($temuan_produk); $i++){
									?>
                <tr id="baris<?php echo $i; ?>">
                  <td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="<?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?>">
                    <?php echo $temuan_produk[$i]['NAMA_PRODUK']; ?><br>
                    No. Registrasi : <?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="<?php echo $temuan_produk[$i]['NOMOR_REGISTRASI']; ?>">
                    <br>
                    No. Batch : <?php echo $temuan_produk[$i]['NO_BATCH']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[NO_BATCH][]" value="<?php echo $temuan_produk[$i]['NO_BATCH']; ?>">
                    <br>
                    Tanggal Expire : <?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[TANGGAL_EXPIRE][]" value="<?php echo $temuan_produk[$i]['TANGGAL_EXPIRE']; ?>">
                    <br>
                    Netto : <?php echo $temuan_produk[$i]['NETTO']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[NETTO][]" value="<?php echo $temuan_produk[$i]['NETTO']; ?>">
                    <br>
                    Harga Satuan : <?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[HARGA_SATUAN][]" value="<?php echo $temuan_produk[$i]['HARGA_SATUAN']; ?>">
                    <br>
                    <br>
                    Jumlah Temuan : <?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[JUMLAH_TEMUAN][]" value="<?php echo $temuan_produk[$i]['JUMLAH_TEMUAN']; ?>">
                    &nbsp;<?php echo $temuan_produk[$i]['SATUAN']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="<?php echo $temuan_produk[$i]['SATUAN']; ?>"></td>
                  <td><?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="<?php echo $temuan_produk[$i]['KLASIFIKASI_PRODUK']; ?>"></td>
                  <td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?>">
                    <?php echo $temuan_produk[$i]['NAMA_PERUSAHAAN']; ?><br>
                    <?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="<?php echo $temuan_produk[$i]['ALAMAT_PERUSAHAAN']; ?>"></td>
                  <td><?php echo $temuan_produk[$i]['KATEGORI']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="<?php echo $temuan_produk[$i]['KATEGORI']; ?>"></td>
                  <td><input type="hidden" name="TEMUAN_PRODUK[JENIS_PELANGGARAN][]" value="<?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?>">
                    <?php echo $temuan_produk[$i]['JENIS_PELANGGARAN']; ?><br />
                    Tindakan Produk : <?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[TINDAKAN_PRODUK][]" value="<?php echo $temuan_produk[$i]['TINDAKAN_PRODUK']; ?>"></td>
                  <td><?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[HARGA_TOTAL][]" value="<?php echo $temuan_produk[$i]['HARGA_TOTAL']; ?>"></td>
                  <td><?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?>
                    <input type="hidden" name="TEMUAN_PRODUK[KETERANGAN_SUMBER][]" value="<?php echo $temuan_produk[$i]['KETERANGAN_SUMBER']; ?>">
                    <span style="float:right;"><a href="#" onclick="$('#baris<?php echo $i ?>').remove();"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td>
                </tr>
                <?php
								}
							}else{
								$temuan_produk = "";
							}
						}
					  ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Akhir Temuan Pemeriksaan !-->
        
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN dan TINDAK LANJUT</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Kesimpulan</h2>
            <table id="F02KO_tbhasil" class="form_tabel">
              <tr>
                <td class="td_left">Hasil Pemeriksaan</td>
                <td class="td_right"><?php echo  form_dropdown('PEMERIKSAAN[HASIL]', $hasil, array_key_exists('HASIL', $sess)?$sess['HASIL']:'', 'id="F02KO_hasil" class="stext" rel="required" title="Hasil Kesimpulan"'); ?></td>
              </tr>
              <tr id="row_catatan" <?php if($sel_hasil == "MK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>>
                <td class="td_left">Catatan 
                <td class="td_right"><textarea class="stext catatan" title="Catatan" name="PEMERIKSAAN_DIST_KOS[CATATAN]"><?php echo $sess['CATATAN']; ?></textarea></td>
              </tr>
              <tr id="row_tmk" <?php if($sess['HASIL'] == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>>
                <td class="td_left">Detil Hasil Pemeriksaan</td>
                <td class="td_right"><span class="F02KO_mk" style="display:none;"></span><span class="F02KO_temuan_kos"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[DETIL_HASIL][]',$detil_hasil,is_array($sel_tmk)?$sel_tmk:'','id="F02KO_detiltmk" class="stext multiselect" multiple title="Detil hasil pemeriksaan. Jika lebih dari satu tekan klik + Ctrl"'); ?></span></td>
              </tr>
              <?php /*?>                <?php if(!array_key_exists('PERIKSA_ID', $sess)){ ?>
                <tr id="row_dttmk"><td class="td_left" id="F02KO_tdlabeldetiltmk">&nbsp;</td><td class="td_right" id="F02KO_tddetiltmk"></td></tr>
                <?php }else{ ?>
                <tr id="row_dttmk"><td class="td_left" id="F02KO_tdlabeldetiltmk">Detil Kesimpulan TMK</td><td class="td_right" id="F02KO_tddetiltmk">
                <?php for($a=0;$a<count($sel_detil_hasil);$a++) { ?>
                <div style="padding-bottom:5px;"><textarea class="stext catatan" name="PEMERIKSAAN_DIST_KOS[KESIMPULAN_DETIL_TMK][]" id="F02KO_detilkesimpulantmk" title="Detil Kesimpulan TMK"><?php echo $sel_detil_hasil[$a]; ?></textarea></div>
                <?php } ?>
                </td></tr>
				<?php } ?>
<?php */?>
              <tr id="row_dttmk" <?php if($sel_hasil == "TMK"){echo 'style=""'; }else{ echo 'style="display:none;"'; }?>>
                <td class="td_left" id="F02KO_tdlabeldetiltmk">Detil Kesimpulan TMK</td>
                <td class="td_right" id="F02OT_tddetiltmk"><textarea class="stext chk" name="PEMERIKSAAN_DIST_KOS[KESIMPULAN_DETIL_TMK]" id="KESIMPULAN_DETIL_TMK" title="Detil Kesimpulan TMK"><?php echo $sess['KESIMPULAN_DETIL_TMK']; ?></textarea></td>
              </tr>
            </table>
            <h2 class="small">Tindak Lanjut</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Tindak lanjut</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_DIST_KOS[TINDAKAN_SARANA][]',$tindakan_sarana,is_array($sel_tindakan_sarana)?$sel_tindakan_sarana:'','class="stext multiselect" style="height:130px; width:350px;" multiple title="Tindak lanjut terhadap sarana. Jika lebih dari satu klik + Ctrl"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Saran Tindak Lanjut</td>
                <td class="td_right"><textarea class="stext chk" title="Saran Tindak Lanjut" name="PEMERIKSAAN_DIST_KOS[SARAN_TL]"><?php echo $sess['SARAN_TL']; ?></textarea></td>
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
    <div><a href="#" class="button save" onclick="fpost('#f02KO_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
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
	$(document).ready(function(){
		create_ck("textarea.chk", 505);
		$("#div_izin").html('Loading..');
		$("#div_izin").load($("#div_izin").attr("url"));
		$("#detail_petugas").html("Loading ...");
		$("#detail_petugas").load($("#detail_petugas").attr("url"));
		$("#F02KO_hasil").change(function(){val = $(this).val(); if(val == "TMK"){ $("#row_catatan").hide(); $("#row_tmk").show();$("#row_dttmk").show(); }else{ $("#row_catatan").show(); $("#row_tmk").hide(); $("#row_dttmk").hide(); } });
		
		$("#F02KO_temuan_kosmetik").autocomplete($("#F02KO_temuan_kosmetik").attr('url'), {width: 244, selectFirst: false});
		$("#F02KO_temuan_kosmetik").result(function(event, data, formatted){
			if(data){
				$(this).val(data[1]);
				$("#F02KO_temuan_noreg").val(data[2]);
				$("#F02KO_temuan_perusahaan").val(data[3]);
				$("#F02KO_temuan_alamat").val(data[5]);
				$("#flag").val('1');
			}
		});
		
		$("#F02KO_klasifikasi").change(function(){
			val = $(this).val();
			if(val == "Importir Kosmetika"){
				$(".importir, .importir_dip").show();
				$(".badan, .distributor").hide();
			}else if(val == "Badan Usaha / Perorangan Sebagai Pemohon Notifikasi Kosmetika"){
				$(".badan").show();
				$(".importir, .importir_dip, .distributor").hide();
			}else if(val == "Distribusi" || val == "Distributor" || val == "Agen" || val == "Stokist MLM" || val == "Klinik Kecantikan / Salon / Spa" || val == "Toko Kosmetik / Swalayan / Pengecer" || val == "Lain-Lain"){
				$(".distributor").show();
				$(".importir, .importir_dip, .badan").hide();
			}else if(val == "Penjualan kosmetik melalui media elektronik"){
				$(".importir, .importir_dip, .badan, .distributor").show();
			}else if(val == ""){
				$(".import, .importir_dip, .badan, .distributor").hide();
			}
		});
		
		$("#F02KO_add_temuan").click(function(){
			if(!beforeSubmit("#F02KO_tbtms"))
			{
				return false;
			}
			else
			{
				var urut = $("#F02KO_temuanbodykos tr").length;
				var total_harga = $("#F02KO_temuan_jumlah").val() * $("#F02KO_temuan_harga").val();
				var str = '<tr id="baris'+(urut+1)+'"><td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PRODUK][]" value="'+$("#F02KO_temuan_kosmetik").val()+'">'+$("#F02KO_temuan_kosmetik").val();
				str += '<br>No. Registrasi : '+$("#F02KO_temuan_noreg").val()+'<input type="hidden" name="TEMUAN_PRODUK[NOMOR_REGISTRASI][]" value="'+$("#F02KO_temuan_noreg").val()+'">';
				str += '<br>No. Batch : '+$("#F02KO_temuan_nobatch").val()+'<input type="hidden" name="TEMUAN_PRODUK[NO_BATCH][]" value="'+$("#F02KO_temuan_nobatch").val()+'">';
				str += '<br>Tanggal Expire :'+$("#F02KO_temuan_expire").val()+'<input type="hidden" name="TEMUAN_PRODUK[TANGGAL_EXPIRE][]" value="'+$("#F02KO_temuan_expire").val()+'">';
				str += '<br>Netto : '+$("#F02KO_temuan_satuan").val()+'<input type="hidden" name="TEMUAN_PRODUK[NETTO][]" value="'+$("#F02KO_temuan_satuan").val()+'">';
				str += '<br>Harga Satuan : '+$("#F02KO_temuan_harga").val()+'<input type="hidden" name="TEMUAN_PRODUK[HARGA_SATUAN][]" value="'+$("#F02KO_temuan_harga").val()+'">';
				str += '<br>Jumlah Temuan : '+$("#F02KO_temuan_jumlah").val()+'<input type="hidden" name="TEMUAN_PRODUK[JUMLAH_TEMUAN][]" value="'+$("#F02KO_temuan_jumlah").val()+'">&nbsp;'+$("#F02KO_satuan option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[SATUAN][]" value="'+$("#F02KO_satuan").val()+'"></td>';
				str += '<td>'+$("#F02KO_klasifikasi_produk option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[KLASIFIKASI_PRODUK][]" value="'+$("#F02KO_klasifikasi_produk").val()+'"></td>';
				str += '<td><input type="hidden" name="TEMUAN_PRODUK[NAMA_PERUSAHAAN][]" value="'+$("#F02KO_temuan_perusahaan").val()+'">'+$("#F02KO_temuan_perusahaan").val();
				str += '<br>'+$("#F02KO_temuan_alamat").val()+'<input type="hidden" name="TEMUAN_PRODUK[ALAMAT_PERUSAHAAN][]" value="'+$("#F02KO_temuan_alamat").val()+'"></td>';
				str += '<td>'+$("#F02KO_temuan_kategori option:selected").text()+'<input type="hidden" name="TEMUAN_PRODUK[KATEGORI][]" value="'+$("#F02KO_temuan_kategori").val()+'"></td><td><input type="hidden" name="TEMUAN_PRODUK[JENIS_PELANGGARAN][]" value="'+$("#F02KO_temuan_pelanggaran").val()+'">'+$("#F02KO_temuan_pelanggaran").val()+'<br>Tindakan Produk : '+$("#F02KO_tindakan_produk").val()+'<input type="hidden" name="TEMUAN_PRODUK[TINDAKAN_PRODUK][]" value="'+$("#F02KO_tindakan_produk").val()+'"></td><td>'+total_harga+'<input type="hidden" name="TEMUAN_PRODUK[HARGA_TOTAL][]" value="'+total_harga+'"></td><td>'+$("#F02KO_temuan_keterangan").val()+'<input type="hidden" name="TEMUAN_PRODUK[KETERANGAN_SUMBER][]" value="'+$("#F02KO_temuan_keterangan").val()+'"><input type="hidden" name="TEMUAN_PRODUK[FLAG][]" value="'+$("#flag").val()+'"><span style="float:right;"><a href="#" onclick="$(\'#baris' + (urut+1) + '\').remove(); return false;"><img src="<?php echo base_url(); ?>images/cancel.png" align="absmiddle" style="border:none" title="Hapus atau batalkan temuan" /></a></span></td></tr>';
				$("#F02KO_temuanbodykos").append(str);
				clearForm("#F02KO_tbtms");
				$("#flag").val('0');
				return false;
			}
		});
		
	});
	
	function show_hide(element, target){
		if(element=="Y"){
			$(target +' input:hidden').each(function(){
				$(this).prev().attr("name","PEMERIKSAAN_DIST_KOS[ASPEK_CHECK][]");
				$(this).attr("name", $(this).prev().attr("name"));
				$(this).val("Y");
			});
			$(target).show();
		}else{
			$(target +' input:hidden').each(function(){
				$(this).attr("name", $(this).prev().attr("name"));
				$(this).val("T");
				$(this).prev().removeAttr("name");
			});
			$(target).hide();
		}
		return false;
	}
</script>