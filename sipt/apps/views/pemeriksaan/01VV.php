<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
$jml = count($jenis_pangan);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
  <form name="f01vv_" id="f01vv_" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Informasi Sarana</h2>
            <table id="tbsarana" class="form_tabel">
              <tr>
                <td class="td_left">Nama Sarana Produksi</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_SARANA', $sess)?$sess['NAMA_SARANA']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Alamat Lokasi Sarana</td>
                <td class="td_right"><?php echo array_key_exists('ALAMAT_1', $sess)?$sess['ALAMAT_1']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Telepon</td>
                <td class="td_right"><?php echo array_key_exists('TELEPON', $sess)?$sess['TELEPON']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Email</td>
                <td class="td_right"><?php echo array_key_exists('EMAIL', $sess)?$sess['EMAIL']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pemilik Fasilitas</td>
                <td class="td_right"><?php echo array_key_exists('NAMA_PIMPINAN', $sess)?$sess['NAMA_PIMPINAN']:""; ?></td>
              </tr>
              <tr>
                <td class="td_left">Penanggung Jawab</td>
                <td class="td_right"><?php echo array_key_exists('PENANGGUNG_JAWAB', $sess)?$sess['PENANGGUNG_JAWAB']:" - "; ?></td>
              </tr>
              <tr>
                <td class="td_left">Status Sarana</td>
                <td class="td_right"><?php echo form_dropdown('STATUS_SARANA',$status_sarana,$sess['STATUS_SARANA'],'class="stext" rel="required" title="Pilih salah satu status sarana : aktif atau tidak aktif / tidak berproduksi" id="stts_sarana"'); ?></td>
              </tr>
            </table>
            <h2 class="small">Jenis Pangan</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="400">Jenis Pangan</th>
                  <th width="150">No. PIRT</th>
                  <th width="250">Status</th>
                </tr>
              </thead>
              <tbody id="tbodyjenispangan">
                <?php
				if($jml > 0){
					for($i = 0; $i < $jml; $i++){
						?>
                        <tr>
                          <td><?php echo $jenis_pangan[$i]['JENIS_PANGAN']; ?></td>
                          <td><?php echo $jenis_pangan[$i]['NO_PIRT']; ?></td>
                          <td><?php echo $jenis_pangan[$i]['STATUS']; ?></td>
                        </tr>
						<?php
                        }
                    }
                    ?>
              </tbody>
            </table>
            <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
                <p><b>Keterangan : </b></p>
                <p>Silahkan untuk  melengkapi data jenis pangan terlebih dahulu untuk dapat melanjutkan data pemeriksaan. Ini dikarenakan untuk data jenis pangan wajib diisi. <br /> Silahkan untuk melakukan update data jenis pangan pada master data sarana atau klik <a href="javascript:void(0);" data-url = "<?php echo site_url(); ?>/get/pemeriksaan/jenis_pangan/<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" id="link-jenis-sarana" class="add-jenis-pangan">disini</a> untuk menambah jenis pangan.</p>
            </div>
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
                  <input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td>
              </tr>
              <tr>
                <td class="td_left">Tujuan Pemeriksaan</td>
                <td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[TUJUAN_PEMERIKSAAN]', $tujuan_pemeriksaan, $sess['TUJUAN_PEMERIKSAAN'], 'class="stext" rel="required" title="Tujuan Pemeriksaan"'); ?></td>
              </tr>
              <tr id="row-catatan" <?php echo array_key_exists('STATUS_SARANA', $sess) ? ($sess['STATUS_SARANA'] <> 0 ? 'style="display:none;"' : '') : 'style="display:none;"'?>>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea class="stext catatan" id="txt_catatan" name="CATATAN" title="Catatan"><?php echo $sess['CATATAN']; ?></textarea>
                <div style="height:5px;">&nbsp;</div>
                <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
                	<p><b>Keterangan : </b></p>
                    <p>Mohon untuk mengisi catatan yang jelas terkait sarana yang diperiksa dengan status sarana (tutup / tidak aktif, tidak berproduksi saat diperiksa dan menolak diperiksa).</p>
                </div></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Akhir Informasi Sarana !-->
        
        <div id="aspek_penilaian" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">ASPEK PENILAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small">A - LOKASI DAN LINGKUNGAN PRODUKSI</h2>
              <table id="pointa" class="form_tabel" group="GRUP A" isgroup="pointa">
                <tr id="a1">
                  <td class="atas" width="12">1.</td>
                  <td class="atas" width="600">Lokasi dan lingkungan IRTP tidak terawat, kotor dan berdebu</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('1|','',$aspek_penilaian[0]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[0] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">B - BANGUNAN DAN FASILITAS</h2>
              <table id="pointb" class="form_tabel" group="GRUP B" isgroup="pointb">
                <tr id="b2">
                  <td class="atas" width="12">2.</td>
                  <td class="atas" width="600">Ruang produksi sempit, sukar dibersihkan dan digunakan untuk memproduksi produk selain pangan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('2|','',$aspek_penilaian[1]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[1] : ""; ?></textarea></td>
                </tr>
                <tr id="b3">
                  <td class="atas" width="12">3.</td>
                  <td class="atas" width="600">Lantai, dinding, dan langit-langit, tidak terawat, kotor, berdebu dan atau berlendir</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('3|','',$aspek_penilaian[2]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[2] : ""; ?></textarea></td>
                </tr>
                <tr id="b4">
                  <td class="atas" width="12">4.</td>
                  <td class="atas" width="600">Ventilasi, pintu, dan jendela tidak terawat, kotor dan berdebu</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('4|','',$aspek_penilaian[3]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[3] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">C - PERALATAN PRODUKSI</h2>
              <table id="pointc" class="form_tabel" group="GRUP C" isgroup="pointc">
                <tr id="c5">
                  <td class="atas" width="12">5.</td>
                  <td class="atas" width="600">Permukaan yang kontak langsung dengan pangan berkarat dan kotor</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('5|','',$aspek_penilaian[4]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[4] : ""; ?></textarea></td>
                </tr>
                <tr id="c6">
                  <td class="atas" width="12">6.</td>
                  <td class="atas" width="600">Peralatan tidak dipelihara, dalam keadaan kotor dan tidak menjamin efektifnya sanitasi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('6|','',$aspek_penilaian[5]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[5] : ""; ?></textarea></td>
                </tr>
                <tr id="c7">
                  <td class="atas" width="12">7.</td>
                  <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang berat bersih / isi bersih tidak tersedia atau tidak teliti.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('7|','',$aspek_penilaian[6]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[6] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">D - SUPLAI AIR ATAU SARANA PENYEDIAAN AIR </h2>
              <table id="pointd" class="form_tabel" group="GRUP D" isgroup="pointd">
                <tr id="d8">
                  <td class="atas" width="12">8.</td>
                  <td class="atas" width="600">Air bersih tidak tersedia dalam jumlah yang cukup untuk memenuhi seluruh kebutuhan produksi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('8|','',$aspek_penilaian[7]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[7] : ""; ?></textarea></td>
                </tr>
                <tr id="d9">
                  <td class="atas" width="12">9.</td>
                  <td class="atas" width="600">Air berasal dari suplai yang tidak bersih</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('9|','',$aspek_penilaian[8]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[8] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">E - FASILITAS DAN KEGIATAN HIGIENE DAN SANITASI </h2>
              <table id="pointe" class="form_tabel" group="GRUP E" isgroup="pointe">
                <tr id="e10">
                  <td class="atas" width="12">10.</td>
                  <td class="atas" width="600">Sarana untuk pembersihan / pencucian bahan pangan, peralatan, perlengkapan dan bangunan tidak tersedia dan tidak terawat dengan baik.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('10|','',$aspek_penilaian[9]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[9] : ""; ?></textarea></td>
                </tr>
                <tr id="e11">
                  <td class="atas" width="12">11.</td>
                  <td class="atas" width="600">Tidak tersedia sarana cuci tangan lengkap dengan sabun dan alat pengering tangan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('11|','',$aspek_penilaian[10]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[10] : ""; ?></textarea></td>
                </tr>
                <tr id="e12">
                  <td class="atas" width="12">12.</td>
                  <td class="atas" width="600">Sarana toilet/jamban kotor tidak terawat dan terbuka ke ruang produksi.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('12|','',$aspek_penilaian[11]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[11] : ""; ?></textarea></td>
                </tr>
                <tr id="e13">
                  <td class="atas" width="12">13.</td>
                  <td class="atas" width="600">Tidak tersedia tempat pembuangan sampah tertutup.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('13|','',$aspek_penilaian[12]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[12] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">F - KESEHATAN DAN HIGIENE KARYAWAN </h2>
              <table id="pointf" class="form_tabel" group="GRUP F" isgroup="pointf">
                <tr id="f14">
                  <td class="atas" width="12">14.</td>
                  <td class="atas" width="600">Karyawan di bagian produksi pangan ada yang tidak merawat kebersihan badannya dan atau ada yang sakit</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('14|','',$aspek_penilaian[13]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[13] : ""; ?></textarea></td>
                </tr>
                <tr id="f15">
                  <td class="atas" width="12">15.</td>
                  <td class="atas" width="600">Karyawan di bagian produksi pangan tidak mengenakan pakaian kerja dan / atau mengenakan perhiasan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('15|','',$aspek_penilaian[14]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[14] : ""; ?></textarea></td>
                </tr>
                <tr id="f16">
                  <td class="atas" width="12">16.</td>
                  <td class="atas" width="600">Karyawan tidak mencuci tangan dengan bersih sewaktu memulai mengolah pangan, sesudah menangani bahan mentah, atau bahan/ alat yang kotor, dan sesudah ke luar dari toilet/jamban.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('16|','',$aspek_penilaian[14]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[15] : ""; ?></textarea></td>
                </tr>
                <tr id="f17">
                  <td class="atas" width="12">17.</td>
                  <td class="atas" width="600">Karyawan bekerja dengan perilaku yang tidak baik (seperti makan dan minum) yang dapat mengakibatkan pencemaran produk pangan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('17|','',$aspek_penilaian[16]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[16] : ""; ?></textarea></td>
                </tr>
                <tr id="f18">
                  <td class="atas" width="12">18.</td>
                  <td class="atas" width="600">Tidak ada Penanggungjawab higiene karyawan</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('18|','',$aspek_penilaian[17]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[17] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">G - PEMELIHARAAN DAN PROGRAM HIGIENE DAN SANITASI </h2>
              <table id="pointg" class="form_tabel" group="GRUP G" isgroup="pointg">
                <tr id="g19">
                  <td class="atas" width="12">19.</td>
                  <td class="atas" width="600">Bahan kimia pencuci tidak ditangani dan digunakan sesuai prosedur, disimpan di dalam wadah tanpa label</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('19|','',$aspek_penilaian[18]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[18] : ""; ?></textarea></td>
                </tr>
                <tr id="g20">
                  <td class="atas" width="12">20.</td>
                  <td class="atas" width="600">Program higiene dan sanitasi tidak dilakukan secara berkala</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('20|','',$aspek_penilaian[19]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[19] : ""; ?></textarea></td>
                </tr>
                <tr id="g21">
                  <td class="atas" width="12">21.</td>
                  <td class="atas" width="600"> Hewan peliharaan terlihat berkeliaran di sekitar dan di dalam ruang produksi pangan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('21|','',$aspek_penilaian[20]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[20] : ""; ?></textarea></td>
                </tr>
                <tr id="g22">
                  <td class="atas" width="12">22.</td>
                  <td class="atas" width="600">Sampah di lingkungan dan di ruang produksi tidak segera dibuang.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('22|','',$aspek_penilaian[21]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[21] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">H - PENYIMPANAN </h2>
              <table id="pointh" class="form_tabel" group="GRUP H" isgroup="pointh">
                <tr id="g23">
                  <td class="atas" width="12">23.</td>
                  <td class="atas" width="600">Bahan pangan, bahan pengemas disimpan bersama-sama dengan produk akhir dalam satu ruangan penyimpanan yang kotor, lembab dan gelap dan diletakkan di lantai atau menempel ke dinding.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('23|','',$aspek_penilaian[22]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[22] : ""; ?></textarea></td>
                </tr>
                <tr id="g24">
                  <td class="atas" width="12">24.</td>
                  <td class="atas" width="600">Peralatan yang bersih disimpan di tempat yang kotor.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('24|','',$aspek_penilaian[23]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[23] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">I - PENGENDALIAN PROSES </h2>
              <table id="pointi" class="form_tabel" group="GRUP I" isgroup="pointi">
                <tr id="i25">
                  <td class="atas" width="12">25.</td>
                  <td class="atas" width="600">IRTP tidak memiliki catatan; menggunakan bahan baku yang sudah rusak, bahan berbahaya, dan bahan tambahan pangan yang tidak sesuai dengan persyaratan penggunaannya.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('25|','',$aspek_penilaian[24]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[24] : ""; ?></textarea></td>
                </tr>
                <tr id="i26">
                  <td class="atas" width="12">26.</td>
                  <td class="atas" width="600">IRTP tidak mempunyai atau tidak mengikuti bagan alir produksi pangan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('26|','',$aspek_penilaian[25]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[25] : ""; ?></textarea></td>
                </tr>
                <tr id="i27">
                  <td class="atas" width="12">27.</td>
                  <td class="atas" width="600">IRTP tidak menggunakan bahan kemasan khusus untuk pangan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('27|','',$aspek_penilaian[26]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[26] : ""; ?></textarea></td>
                </tr>
                <tr id="i28">
                  <td class="atas" width="12">28.</td>
                  <td class="atas" width="600">BTP tidak diberi penandaan dengan benar.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('28|','',$aspek_penilaian[27]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[27] : ""; ?></textarea></td>
                </tr>
                <tr id="i29">
                  <td class="atas" width="12">29.</td>
                  <td class="atas" width="600">Alat ukur / timbangan untuk mengukur / menimbang BTP tidak tersedia atau tidak teliti.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('29|','',$aspek_penilaian[28]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[28] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">J - PELABELAN PANGAN </h2>
              <table id="pointj" class="form_tabel" group="GRUP J" isgroup="pointj">
                <tr id="i30">
                  <td class="atas" width="12">30.</td>
                  <td class="atas" width="600">Label pangan tidak mencantumkan nama produk, daftar bahan yang digunakan, berat bersih/isi bersih, nama dan alamat IRTP, masa kedaluwarsa, kode produksi dan nomor P-IRT.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('30|','',$aspek_penilaian[29]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[29] : ""; ?></textarea></td>
                </tr>
                <tr id="i31">
                  <td class="atas" width="12">31.</td>
                  <td class="atas" width="600">Label mencantumkan klaim kesehatan atau klaim gizi.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('31|','',$aspek_penilaian[30]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[30] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">K - PENGAWASAN OLEH PENANGGUNG JAWAB </h2>
              <table id="pointk" class="form_tabel" group="GRUP K" isgroup="pointk">
                <tr id="k32">
                  <td class="atas" width="12">32.</td>
                  <td class="atas" width="600">IRTP tidak mempunyai penanggung jawab yang memiliki Sertifikat Penyuluhan Keamanan Pangan (PKP)</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('32|','',$aspek_penilaian[31]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[31] : ""; ?></textarea></td>
                </tr>
                <tr id="k33">
                  <td class="atas" width="12">33.</td>
                  <td class="atas" width="600">IRTP tidak melakukan pengawasan internal secara rutin, termasuk monitoring dan tindakan koreksi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('33|','',$aspek_penilaian[32]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[32] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">L - PENARIKAN PRODUK </h2>
              <table id="pointl" class="form_tabel" group="GRUP L" isgroup="pointl">
                <tr id="l34">
                  <td class="atas" width="12">34.</td>
                  <td class="atas" width="600">Pemilik IRTP tidak melakukan penarikan produk pangan yang tidak aman</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('34|','',$aspek_penilaian[33]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[33] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">M - PENCATATAN DAN DOKUMENTASI </h2>
              <table id="pointm" class="form_tabel" group="GRUP M" isgroup="pointm">
                <tr id="m35">
                  <td class="atas" width="12">35.</td>
                  <td class="atas" width="600">IRTP tidak memiliki dokumen produksi</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('35|','',$aspek_penilaian[34]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[34] : ""; ?></textarea></td>
                </tr>
                <tr id="m36">
                  <td class="atas" width="12">36.</td>
                  <td class="atas" width="600">Dokumen produksi tidak mutakhir, tidak akurat, tidak tertelusur dan tidak disimpan selama 2 (dua) kali umur simpan produk pangan yang diproduksi.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('36|','',$aspek_penilaian[35]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[35] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">N - PELATIHAN KARYAWAN</h2>
              <table id="pointn" class="form_tabel" group="GRUP N" isgroup="pointn">
                <tr id="n36">
                  <td class="atas" width="12">37.</td>
                  <td class="atas" width="600">IRTP tidak memiliki program pelatihan keamanan pangan untuk karyawan.</td>
                  <td class="atas"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[KETIDAKSESUAIAN][]', $cb_kriteria, str_replace('36|','',$aspek_penilaian[36]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : OK, Major, Minor, Serius, Kritis, Tidak Berlaku" rel="required"', $diss = array("Minor", "Major", "Serius")); ?></td>
                  <td class="atas"><textarea class="stext" name="PEMERIKSAAN_PANGAN[ELEMENT_PERIKSA][]" title="Catatan"><?php echo is_array($element_periksa) ? $element_periksa[36] : ""; ?></textarea></td>
                </tr>
              </table>
              <h2 class="small">JUMLAH KETIDAK SESUAIAN</h2>
              <table class="form_tabel">
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain KRITIS</td>
                  <td class="atas"><input type="text" class="scode" rel="required" title="Jumlah ketidaksesuaian kritis" value="<?php echo array_key_exists('JML_KRITIS', $sess)?$sess['JML_KRITIS']:"0"; ?>" id="jml_kritis" name="PEMERIKSAAN_PANGAN[JML_KRITIS]" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain SERIUS</td>
                  <td class="atas"><input type="text" class="scode" rel="required" title="Jumlah ketidaksesuaian serius" value="<?php echo array_key_exists('JML_SERIUS', $sess)?$sess['JML_SERIUS']:"0"; ?>" id="jml_serius" name="PEMERIKSAAN_PANGAN[JML_SERIUS]" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain MAYOR</td>
                  <td class="atas"><input type="text" class="scode" rel="required" title="Jumlah ketidaksesuaian mayor" value="<?php echo array_key_exists('JML_MAJOR', $sess)?$sess['JML_MAJOR']:"0"; ?>" id="jml_major" name="PEMERIKSAAN_PANGAN[JML_MAJOR]" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Jumlah Ketidaksesuain MINOR</td>
                  <td class="atas"><input type="text" class="scode" rel="required" title="Jumlah ketidaksesuaian minor" value="<?php echo array_key_exists('JML_MINOR', $sess)?$sess['JML_MINOR']:"0"; ?>" id="jml_minor" name="PEMERIKSAAN_PANGAN[JML_MINOR]" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td class="atas" width="12">&nbsp;</td>
                  <td class="atas" width="600">Level IRTP</td>
                  <td class="atas"><input type="text" class="sel_header" rel="required" title="Level IRTP" id="level_irtp" name="PEMERIKSAAN_PANGAN[LEVEL_IRTP]" readonly="readonly" value="<?php echo array_key_exists('LEVEL_IRTP', $sess)?$sess['LEVEL_IRTP']:"Level 0"; ?>" /></td>
                </tr>
              </table>
            </div>
          </div>
          <!-- Akhir Aspek Penilaian !--> 
        </div>
        <div id="div-rincian-laporan" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>
          <div style="height:5px;"></div>
          <div class="expand"><a title="expand/collapse" href="#" style="display: block;">RINCIAN LAPORAN KETIDAKSESUAIAN</a></div>
          <div class="collapse">
            <div class="accCntnt">
              <h2 class="small garis">Rincian Ketidaksesuaian</h2>
              <table class="listtemuan" width="100%">
                <thead>
                  <tr>
                    <th width="500">Ketidaksesuaian</th>
                    <th width="75">Kriteria</th>
                    <th width="300">Timeline</th>
                  </tr>
                </thead>
                <tbody id="draft-penilaian">
                  <?php
				  $jml = count($rincian_ketidaksesuaian);
				  if($jml > 0){
					  for($i = 0; $i < $jml; $i++){
						?>
                        <tr id="<?php echo $rincian_ketidaksesuaian[$i]; ?>">
                          <td width="500"><?php echo $rincian_ketidaksesuaian[$i]; ?><input type="hidden" name="PEMERIKSAAN_PANGAN[RINCIAN_NOMOR][]" value="<?php echo $rincian_nomor[$i]; ?>"><input type="hidden" name = "PEMERIKSAAN_PANGAN[RINCIAN_KETIDAKSESUAIAN][]" value="<?php echo $rincian_ketidaksesuaian[$i]; ?>"></td>
                          <td width="70"><?php echo $rincian_kriteria[$i]; ?><input type="hidden" name = "PEMERIKSAAN_PANGAN[RINCIAN_KRITERIA][]" value="<?php echo $rincian_kriteria[$i]; ?>"></td>
                          <td><input type="text" class="sdate timelines" title="Batas waktu penyelesaian tindakan perbaikan" name="PEMERIKSAAN_PANGAN[RINCIAN_TIMELINE][]" value="<?php echo $rincian_timeline[$i]; ?>"></td>
                        </tr>
					<?php
                      }
                  }
                  ?>
                </tbody>
              </table>
              <div style="height:5px;">&nbsp;</div>
              <h2 class="small"><a href="#" url="<?php echo $history_periksa; ?>" onclick="expand_detail($(this), 'detail_periksa'); return false;" id="detail_hisotry">Pemeriksaan Sebelumnya</a></h2>
              <div id="detail_periksa"></div>
            </div>
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
    <div><a href="#" class="button save" onclick="fpost('#f01vv_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div id="clear_fix"></div>
    <div id="hasilnya"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KLASIFIKASI" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
    <input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
  </form>
</div>
<div id="ctn-dialog"></div>
<script>
	$(document).ready(function(){
		$('.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("#detail_petugas").html("Loading ...");
		$("#detail_petugas").load($("#detail_petugas").attr("url"));				
		$("#stts_sarana").change(function(){
			var stts = $(this).val();
			if(stts == "0" || stts == "2" || stts == "3"){
				$("#aspek_penilaian, #div-rincian-laporan").hide();
				$("#jml_kritis, #jml_major, #jml_minor, #jml_serius").val('0');
				$("#level_irtp").val('Level 0');
				$("tbody#draft-penilaian tr").remove();
				$("select.sel_penyimpangan").val('');
				$("tr#row-catatan").show();
				$(".sel_penyimpangan").removeAttr('rel');
			}else{
				$("#aspek_penilaian, #div-rincian-laporan").show();
				$("tr#row-catatan").hide();
				$("#txt_catatan").val('');
				$(".sel_penyimpangan").attr('rel','required');
			}		
			return false;
		});
		$(".add-jenis-pangan").click(function(e){
            var $this = $(this);
			$.get($this.attr("data-url"), function(data){
				$("#ctn-dialog").html(data); 
				$("#ctn-dialog").dialog({ 
					title: 'Input Jenis Pangan', 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
        });
		$("select.sel_penyimpangan").change(function(){
			var $this = $(this);
			var $html = $this.parent().prev().text();
			var $tr = $this.parent().parent().attr("id");
			var $element = $this.next(); $element.val($html);
			var $no = $this.parent().prev().prev().text();
			var minor = $("select.sel_penyimpangan option:selected[value='Minor']").length;
			var major = $("select.sel_penyimpangan option:selected[value='Major']").length;
			var kritis = $("select.sel_penyimpangan option:selected[value='Kritis']").length;
			var serius = $("select.sel_penyimpangan option:selected[value='Serius']").length;
			var ok = $("select.sel_penyimpangan option:selected[value='OK']").length;
			if(kritis >= 1){
				$("#level_irtp").val('Level IV');
			}else if(serius >= 5){
				$("#level_irtp").val('Level IV');
			}else if(kritis == 0 && ((serius >= 1 || serius == 4) || major >= 4 )){
				$("#level_irtp").val('Level III');
			}else if((kritis == 0 && serius == 0) && ((major > 1 || major == 3) || minor >= 1 )){
				$("#level_irtp").val('Level II');
			}else if(kritis == 0 && serius == 0 && (major == 1 || minor == 1)){
				$("#level_irtp").val('Level I');
			}else if(kritis == 0 && serius == 0 && major == 0 && minor == 0){
				$("#level_irtp").val('Level I');
			}else{
				$("#level_irtp").val('Level 0');
			}
			$("#jml_kritis").val(parseInt(kritis));
			$("#jml_serius").val(parseInt(serius));
			$("#jml_major").val(parseInt(major));
			$("#jml_minor").val(parseInt(minor));
			if($this.val() == "Minor" || $this.val() == "Major" || $this.val() == "Serius" || $this.val() == "Kritis"){
				$('.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
				var $string  = '<tr id="'+$tr+'">';
					$string += '<td data-content = "'+$html+'">'+$html+'<input type="hidden" name="PEMERIKSAAN_PANGAN[RINCIAN_NOMOR][]" value="'+$no.replace('.','')+'"><input type="hidden" name = "PEMERIKSAAN_PANGAN[RINCIAN_KETIDAKSESUAIAN][]" value="'+$html+'"></td>';
					$string += '<td>'+$this.val()+'<input type="hidden" name = "PEMERIKSAAN_PANGAN[RINCIAN_KRITERIA][]" value="'+$this.val()+'"></td>';
					$string += '<td><input type="text" class="sdate timelines" title="Batas waktu penyelesaian tindakan perbaikan" name="PEMERIKSAAN_PANGAN[RINCIAN_TIMELINE][]"></td>';
					$string += '</tr>';
				$("tbody#draft-penilaian").append($string);
			}else{
				$("tbody#draft-penilaian tr#"+$tr).remove();
			}
			$(".timelines").focus(function(){
				var $this = $(this);
				if(!$this.data('datepicker')){
					$this.removeClass("hasDatepicker");
					$this.datepicker();
					$this.datepicker("show");
				}
			});
			return false;
		});
    });
</script> 
