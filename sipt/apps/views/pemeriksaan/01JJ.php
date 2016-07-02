<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
<form name="f01jj_" id="f01jj_" method="post" action="<?php echo $act; ?>" autocomplete="off" > 
<div class="adCntnr">
    <div class="acco2">
    
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Informasi Pemeriksaan</h2>
                <h2 class="small">Informasi Petugas Pemeriksa</h2>
                <div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
                <div style="height:5px;"></div>
                <h2 class="small">Informasi Pemeriksaan</h2>
                <table class="form_tabel">
                  <tr><td class="td_left">Tanggal Pemeriksaan</td><td class="td_right"><input type="hidden" id="sess_tgl" value="<?php echo $SESS_TGL['TANGGAL'][0]; ?>" /><input type="text" class="sdate" name="PEMERIKSAAN[AWAL_PERIKSA]" id="waktuperiksa_" rel="required" value="<?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>" title="Tanggal pemeriksaan awal" />&nbsp; sampai dengan &nbsp;<input type="text" class="sdate" name="PEMERIKSAAN[AKHIR_PERIKSA]" id="waktu_akhir" value="<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?>" title="Tanggal pemeriksaan akhir" onchange="compare('#waktuperiksa_', '#waktu_akhir'); return false;" rel="required" /></td></tr>
                  <tr><td class="td_left">Tujuan Pemeriksaan</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[TUJUAN_PEMERIKSAAN]',$tujuan_pemeriksaan,$sess['TUJUAN_PEMERIKSAAN'],'class="stext" rel="required" title="Pilih salah satu tujuan pemeriksaan"'); ?></td></tr>
                  <tr><td class="td_left">Status Sarana</td><td class="td_right"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[STATUS_SARANA]',$status_sarana,$sess['STATUS_SARANA'],'class="stext" rel="required" title="Pilih salah satu status sarana : aktif atau tidak aktif / tidak berproduksi" id="stts_sarana"'); ?></td></tr>
                </table>
				<h2 class="small"><a href="#" url="<?php echo $history_periksa; ?>" onclick="expand_detail($(this), 'detail_periksa'); return false;" id="detail_hisotry">Pemeriksaan Sebelumnya</a></h2>
                <div id="detail_periksa"></div>                
                </div>
        </div><!-- Akhir Informasi Sarana !-->
        
        <div style="height:5px;"></div>         


        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA UMUM</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Data Umum Sarana</h2>
				<div id="data_umum" url="<?php echo site_url(); ?>/get/distribusi/set_panganmd/<?php echo $sarana_id; ?>/no"></div>                
                </div>
        </div><!-- Akhir Data Umum!-->

        <div style="height:5px;"></div>   

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA KHUSUS</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Data Khusus Sarana</h2>
                <table class="form_tabel">
                <tr><td style="width:500px;">1. Apakah Unit Pengolahan sudah  mempunyai buku Panduan Mutu/HACCP <em>(HACCP  Plan)</em></td>
                <td><?php echo form_dropdown('PEMERIKSAAN_PANGAN[DATA_KHUSUS][SATU]',$pilihan[0],str_replace('SATU|','',$khusus[0]),'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" onchange="header_satu($(this).val(), \'#khusus_seri_1\', \'#khusus_seri_2\', \'#khusus_seri_3\')" title="Pilih salah satu pilihan"'); ?></td></tr>
                </table>
                                
                <table class="form_tabel" id="khusus_seri_1" <?php if(str_replace('SATU|','',$khusus[0] )=='Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
                <tr><td style="width:500px;">2. Apakah Unit Pengolahan sudah menerapkan Sistem HACCP ?</td><td><?php echo form_dropdown('PEMERIKSAAN_PANGAN[DATA_KHUSUS][DUA]',$pilihan[0],str_replace('DUA|','',$khusus[1]),'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" onchange="header_dua($(this).val(), \'#khusus_seri_sub2\', \'#khusus_seri_2\');" title="Pilih salah satu pilihan"'); ?></td></tr>
                <tr id="khusus_seri_sub2" <?php if(str_replace('DUA|','',$khusus[1]) == 'Belum') echo 'style=""'; else echo 'style="display:none;"'; ?>><td style="width:500px;">apa alasannya Unit Pengolahan belum menerapkan Sistem HACCP ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][DUA_BELUM]" value="<?php echo str_replace('DUA_BELUM|','',$khusus[2]); ?>" title="Apa alasan unit pengolahan belum menerakan sistem HACCP" /></td></tr>                
                
                </table>
                
                <table class="form_tabel" id="khusus_seri_2" <?php if(str_replace('DUA|','',$khusus[1]) == 'Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
                <tr><td style="width:500px;">bagian/departemen apa saja yang terlibat ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][DUA_SUDAH]" value="<?php echo str_replace('DUA_SUDAH|','',$khusus[3]); ?>" title="Bagian apa saja yang terlibat" /></td></tr>
                <tr><td style="width:500px;">3. Formulir-formulir apa  saja yang dibuat untuk <em>record keeping ?</em> Sebutkan!</td><td ><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][TIGA]" value="<?php echo str_replace('TIGA|','',$khusus[4]);?>" title="Formulir apa saja yang dibuat" /></td></tr>
                <tr><td style="width:500px;">4. Tindakan apa yang dilakukan  jika terjadi penyimpangan ?</td><td>&nbsp;</td></tr>
                <tr><td style="width:500px;">a. Terhadap bahan baku ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][EMPAT_A]" value="<?php echo str_replace('EMPAT_A|','',$khusus[5]); ?>" title="Tindakan terhadap bahan baku" /></td></tr>
                <tr><td style="width:500px;">b. Produk yang sedang  diolah ?</td><td class="atas"><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][EMPAT_B]" value="<?php echo str_replace('EMPAT_B|','',$khusus[6]); ?>" title="Tindakan terhadap produk yang diolah" /></td></tr>
                <tr><td style="width:500px;">c. Produk akhir ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][EMPAT_C]" value="<?php echo str_replace('EMPAT_C|','',$khusus[7]); ?>" title="Tindakan terhadap produk akhir" /></td></tr>
                <tr><td style="width:500px;">5. Kesulitan apa yang  dihadapi dalam penerapan sistem HACCP ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][LIMA]" value="<?php echo str_replace('LIMA|','',$khusus[8]); ?>" title="Kesulitan dalam penerapan sistem HACCP" /></td></tr>
                <tr><td style="width:500px;">6. Bimbingan apa yang  diperlukan dalam penerapan sistem HACCP  ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][ENAM]" value="<?php echo str_replace('ENAM|','',$khusus[9]); ?>" title="Bimbingan HACCP" /></td></tr>
                <tr><td style="width:500px;">7. Selama ini apakah sudah  mendapatkan pelatihan tentang sistem  HACCP ?</td><td><?php echo form_dropdown('PEMERIKSAAN_PANGAN[DATA_KHUSUS][TUJUH]',$pilihan[0],str_replace('TUJUH|','',$khusus[10]),'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" onchange="header_tiga($(this).val(), \'#khusus_seri_3\');" title="Pilih salah satu pilihan"'); ?></td>
                </tr>
                </table>
                
                <table id="khusus_seri_3" class="form_tabel" <?php if(str_replace('TUJUH|','',$khusus[10]) == 'Sudah') echo 'style=""'; else echo 'style="display:none;"'; ?>>
                <tr><td style="width:500px;">a. Siapa  penyelenggaranya dan kapan dilaksanakannya ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][TUJUH_A]" value="<?php echo str_replace('TUJUH_A|','',$khusus[11]); ?>" title="Siapa penyelenggara dan kapan dilaksanankan" /></td></tr>
                <tr><td style="width:500px;">b. Siapa dan dari mana tenaga pelatihnya ?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][TUJUH_B]" value="<?php echo str_replace('TUJUH_B|','',$khusus[12]); ?>" title="Berasal dari mana pelatihnya" /></td></tr>
                <tr><td style="width:500px;">c. Berapa orang dan bagian  apa saja yang terlibat dalam pelatihan?</td><td><input type="text" class="stext" name="PEMERIKSAAN_PANGAN[DATA_KHUSUS][TUJUH_C]" value="<?php echo str_replace('TUJUH_C|','',$khusus[13]); ?>" title="Jumlah orang yang terlibat dalam pelatihan" /></td></tr>
                </table>
                </div>
        </div><!-- Akhir Data Khusus !-->

        <div id="aspek_penilaian" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>   
        <div style="height:5px;"></div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENGECEKAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Pengecekan CPMB</h2>
                <table class="form_tabel">
                  <tr><td width="20">&nbsp;</td><td class="atas isi" width="400">ASPEK YANG DINILAI</td><td class="atas isi" width="90">KRITERIA</td><td class="atas isi" width="300">KETERANGAN / TANGGAL PERBAIKAN</td></tr>
                </table>
                
                <table class="form_tabel" id="tb_pointa">
                <tr>
                  <td class="atas isi" width="20">a.</td>
                  <td class="atas isi" width="400">Pimpinan</td>
                  <td class="atas isi" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('0|','',$aspek_penilaian[0]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointa"  onchange="ok_tb(\'#sel_atas_pointa\', \'#tb_pointa\')"'); ?>
      </td>
                  <td class="atas isi" width="">&nbsp;</td>
                </tr>
                <tr id="point1_operasional">
                  <td class="atas" width="20">1.</td>
                  <td class="atas" width="400">Pimpinan tidak  mempunyai wawasan terhadap metode pengawasan modern (HACCP) dan tidak melaksanakannya dengan baik</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('1|','',$aspek_penilaian[1]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('0|','',$aspek_keterangan[0]); ?></textarea></td>
                </tr>
                <tr id="point2_operasional">
                  <td class="atas" width="20">2.</td>
                  <td class="atas" width="400">Tidak berkeinginan bekerja sama  dengan Inspektur: a.l. tidak menerima Pengawas dengan sepenuh hati dan tidak  mau menunjukkan data. yang diperlukan oleh Inspektur.</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('2|','',$aspek_penilaian[2]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('1|','',$aspek_keterangan[1]); ?></textarea></td>
                </tr>
                </table>
            
                <table class="form_tabel" id="tb_pointb">
                <tr>
                  <td class="atas isi" width="20">b.</td>
                  <td class="atas isi" width="400">Sanitasi dan Lingkungan :</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('3|','',$aspek_penilaian[3]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointb"  onchange="ok_tb(\'#sel_atas_pointb\', \'#tb_pointb\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr id="point3_fisik">
                  <td class="atas" width="20">3.</td>
                  <td class="atas" width="400">Lingkungan tidak bebas dari  semak belukar/rumput liar.</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('4|','',$aspek_penilaian[4]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('2|','',$aspek_keterangan[2]); ?></textarea></td>
            </tr>
                <tr id="point4_fisik">
                  <td class="atas" width="20">4.</td>
                  <td class="atas" width="400">Lingkungan tidak bebas dari  sampah, dan barang-barang tak berguna diareal pabrik maupun di luarnya</td>            
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('5|','',$aspek_penilaian[5]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('3|','',$aspek_keterangan[3]); ?></textarea></td>
            </tr>
                <tr id="point5_fisik">
                  <td class="atas" width="20">5.</td>
                  <td class="atas" width="400">Tidak ada tempat  sampah disekitar lingkungan pabrik atau tempat sampah ada tetapi tdk dirawat  dgn baik</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('6|','',$aspek_penilaian[6]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('4|','',$aspek_keterangan[4]); ?></textarea></td>
            </tr>
                <tr id="point6_fisik">
                  <td class="atas">6.</td>
                  <td class="atas" width="400">Bangunan yang digunakan untuk menaruh perlengkapan  tidak teratur, tidak terawat dan tidak mudah dibersihkan</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('7|','',$aspek_penilaian[7]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('5|','',$aspek_keterangan[5]); ?></textarea></td>
            </tr>
                <tr id="point7_fisik">
                  <td class="atas">7.</td>
                  <td class="atas" width="400">Ada tempat  pemeliharaan hewan yang memungkinkan menjadi sumber kontaminasi</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('8|','',$aspek_penilaian[8]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('6|','',$aspek_keterangan[6]); ?></textarea></td>
            </tr>
                <tr id="point8_fisik">
                  <td class="atas">8.</td>
                  <td class="atas" width="400">Terdapat debu, asap, bau yang  berlebihan di jalanan, tempat parkir atau disekeliling pabrik.</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('9|','',$aspek_penilaian[9]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('7|','',$aspek_keterangan[7]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointc">
                <tr>
                  <td class="atas isi" width="20">c.</td>
                  <td class="atas isi">Sanitasi Lingkungan : Pembuangan / Limbah</td>
                  </tr>
                </table>
                <table id="tb_ponitc_sub1" border="0" class="form_tabel">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Saluran Air / Air Hujan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('10|','',$aspek_penilaian[10]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointc_sub1"  onchange="ok_tb(\'#sel_atas_pointc_sub1\', \'#tb_ponitc_sub1\')"'); ?></td>
                 <td width="300"></td>
                  </tr>
                <tr id="point9_fisik">
                  <td class="atas" width="20">9.</td>
                  <td class="atas" width="400">Sistem pembuangan limbah  cair/saluran disekitar lingkungan pabrik kurang baik:</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('11|','',$aspek_penilaian[11]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('8|','',$aspek_keterangan[8]); ?></textarea></td>
            </tr>
                <tr id="point10_fisik">
                  <td class="atas">10.</td>
                  <td class="atas" width="400">Kapasitas  saluran di lingkungan pabrik tidak  mencukupi.</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('12|','',$aspek_penilaian[12]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('9|','',$aspek_keterangan[9]); ?></textarea></td>
            </tr>
            </table>
                <table id="tb_pointc_subdua" border="0" class="form_tabel">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Pembuangan Limbah : Cair, Padat,Sampah di sekitar lingkungan pabrik</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('13|','',$aspek_penilaian[13]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointc_subdua"  onchange="ok_tb(\'#sel_atas_pointc_subdua\', \'#tb_pointc_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point11_fisik">
                  <td class="atas" width="20">11.</td>
                  <td class="atas" width="400">Limbah cair disekitar lingkungan tidak ditangani dengan  baik</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('14|','',$aspek_penilaian[14]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('10|','',$aspek_keterangan[10]); ?></textarea></td>
            </tr>
                <tr id="point12_fisik">
                  <td class="atas">12.</td>
                  <td class="atas" width="400">Konstruksi tempat pembuangan  limbah tidak selayaknya.</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('15|','',$aspek_penilaian[15]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('11|','',$aspek_keterangan[11]); ?></textarea></td>
            </tr>
                <tr id="point13_fisik">
                  <td class="atas">13.</td>
                  <td class="atas" width="400">Tempat/wadah sampah tidak ada  penutupnya.</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('16|','',$aspek_penilaian[16]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('12|','',$aspek_keterangan[12]); ?></textarea></td>
                  </tr>
                  </table>
                <table class="form_tabel" id="tb_pointd">
                <tr>
                  <td class="atas isi" width="20">d.</td>
                  <td class="atas isi" width="400">Sanitasi Lingkungan:  Investasi Burung, Serangga atau binatang lain</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('17|','',$aspek_penilaian[17]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointd"  onchange="ok_tb(\'#sel_atas_pointd\', \'#tb_pointd\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr id="point14_fisik">
                  <td class="atas">14.</td>
                  <td class="atas" width="400">Tidak ada pengendalian untuk  mencegah serangga, tikus dan binatang pengganggu lainnya dilingkungan pabrik.</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('18|','',$aspek_penilaian[18]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>           
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('13|','',$aspek_keterangan[13]); ?></textarea></td>
                </tr>
                <tr id="point15_fisik">
                  <td class="atas">15.</td>
                  <td class="atas" width="400">Pencegahan serangga, burung,  tikus dan binatang lain tidak efektif</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('19|','',$aspek_penilaian[19]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('14|','',$aspek_keterangan[14]); ?></textarea></td>
                </tr>
                </table>
                <table class="form_tabel" id="tb_pointe">
                <tr>
                  <td class="atas isi" width="20">e.</td>
                  <td class="atas isi" width="400">Pabrik Umum</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('20|','',$aspek_penilaian[20]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointe"  onchange="ok_tb(\'#sel_atas_pointe\', \'#tb_pointe\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr id="point16_fisik">
                  <td class="atas">16.</td>
                  <td class="atas" width="400">Rancang bangun, bahan-bahan  atau konstruksinya menghambat program sanitasi.</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('21|','',$aspek_penilaian[21]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('15|','',$aspek_keterangan[15]); ?></textarea></td>
            </tr>
                <tr id="point17_fisik">
                  <td class="atas">17.</td>
                  <td class="atas" width="400">Rancang bangun tidak  sesuai dengan jenis pangan yang diproduksi</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('22|','',$aspek_penilaian[22]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('16|','',$aspek_keterangan[16]); ?></textarea></td>
            </tr>
                <tr id="point18_fisik">
                  <td class="atas">18.</td>
                  <td class="atas" width="400">Luas pabrik tidak  sesuai dengan kapasitas produksi</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('23|','',$aspek_penilaian[23]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('17|','',$aspek_keterangan[17]); ?></textarea></td>
            </tr>
                <tr id="point19_fisik">
                  <td class="atas">19.</td>
                  <td class="atas" width="400">Bangunan dalam keadaan tidak  terawat</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('24|','',$aspek_penilaian[24]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('18|','',$aspek_keterangan[18]); ?></textarea></td>
            </tr>
                <tr id="point20_fisik">
                  <td class="atas">20.</td>
                  <td class="atas" width="400">Tidak ada fasilitas atau usaha  lain untuk mencegah binatang atau  serangga masuk kedalam pabrik  (Kisi-kisi, kasa penutup lubang angin, tirai udara<em>-air curtain, </em>tirai plastik atau tirai air-<em>water curtain)</em>, kalaupun ada tidak efektif</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('25|','',$aspek_penilaian[25]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis",)); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('19|','',$aspek_keterangan[19]); ?></textarea></td>
            </tr>
                <tr id="point21_fisik">
                  <td class="atas">21.</td>
                  <td class="atas" width="400">Tata ruang tidak sesuai alur  proses produsi</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('26|','',$aspek_penilaian[26]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('20|','',$aspek_keterangan[20]); ?></textarea></td>
            </tr>
                <tr id="point22_fisik">
                  <td class="atas">22.</td>
                  <td class="atas" width="400">Tidak ada ruang  istirahat, jika ada tidak memenuhi persyaratan kesehatan</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('27|','',$aspek_penilaian[27]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('21|','',$aspek_keterangan[21]); ?></textarea></td>
            </tr>
            </table>
                <table class="form_tabel" id="tb_pointf">
                <tr>
                  <td class="atas isi" width="20">f.</td>
                  <td class="atas isi" width="400">Pabrik Ruang Pengolahan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('28|','',$aspek_penilaian[28]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointf"  onchange="ok_tb(\'#sel_atas_pointf\', \'#tb_pointf\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  
                </tr>
                <tr id="point23_fisik">
                  <td class="atas">23</td>
                  <td class="atas" width="400">Ruang pengolahan berhubungan  langsung/terbuka dengan tempat tinggal, garasi dan bengkel.</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('29|','',$aspek_penilaian[29]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('22|','',$aspek_keterangan[22]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointf_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Lantai</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('30|','',$aspek_penilaian[30]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointf_subsatu"  onchange="ok_tb(\'#sel_atas_pointf_subsatu\', \'#tb_pointf_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point24_fisik">
                  <td class="atas" width="20">24.</td>
                  <td class="atas" width="400">Terbuat dari bahan  yang tidak mudah diperbaiki/dicuci atau rusak</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('31|','',$aspek_penilaian[31]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('23|','',$aspek_keterangan[23]); ?></textarea></td>
            </tr>
                <tr id="point25_fisik">
                  <td class="atas">25.</td>
                  <td class="atas" width="400">Konstruksi tidak  sesuai persyaratan teknik sanitasi dan higiene (tidak rata,tidak kuat, retak  atau licin)</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('32|','',$aspek_penilaian[32]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('24|','',$aspek_keterangan[24]); ?></textarea></td>
            </tr>
                <tr id="point26_fisik">
                  <td class="atas">26.</td>
                  <td class="atas" width="400">Pertemuan antara  lantai dan dinding tidak mudah dibersihkan (tidak ada lengkungan)</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('33|','',$aspek_penilaian[33]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('25|','',$aspek_keterangan[25]); ?></textarea></td>
            </tr>
                <tr id="point27_fisik">
                  <td class="atas">27.</td>
                  <td class="atas" width="400">Kemiringan tidak sesuai.</td>        
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('34|','',$aspek_penilaian[34]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('26|','',$aspek_keterangan[26]); ?></textarea></td>
            </tr>
                <tr id="point28_fisik">
                  <td class="atas">28.</td>
                  <td class="atas" width="400">Tidak kedap air</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('35|','',$aspek_penilaian[35]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('27|','',$aspek_keterangan[27]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointf_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Dinding</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('36|','',$aspek_penilaian[36]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointf_subdua"  onchange="ok_tb(\'#sel_atas_pointf_subdua\', \'#tb_pointf_subdua\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point29_fisik">
                  <td class="atas" width="20">29.</td>
                  <td class="atas" width="400">Dinding tidak kedap  air sampai pada ketinggian minimal 1,70 m</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('37|','',$aspek_penilaian[37]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor","Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('28|','',$aspek_keterangan[28]); ?></textarea></td>
            </tr>
                <tr id="point30_fisik">
                  <td class="atas">30.</td>
                  <td class="atas" width="400">Terbuat dari bahan  yang tidak mudah diperbaiki/dicuci</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('38|','',$aspek_penilaian[38]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor","Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('29|','',$aspek_keterangan[29]); ?></textarea></td>
            </tr>
                <tr id="point31_fisik">
                  <td class="atas">31.</td>
                  <td class="atas" width="400">Konstruksi tidak  sesuai persyaratan teknik sanitasi dan higiene (tidak halus, tidak kuat,  retak, cat mudah mengelupas)</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('39|','',$aspek_penilaian[39]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('30|','',$aspek_keterangan[30]); ?></textarea></td>
            </tr>
                <tr id="point32_fisik">
                  <td class="atas">32.</td>
                  <td class="atas" width="400">Pertemuan antara  dinding dan dinding tidak mudah dibersihkan (tidak ada lengkungan)</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('40|','',$aspek_penilaian[40]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('31|','',$aspek_keterangan[31]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointf_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Langit Langit</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('41|','',$aspek_penilaian[41]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointf_subtiga"  onchange="ok_tb(\'#sel_atas_pointf_subtiga\', \'#tb_pointf_subtiga\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point33_fisik">
                  <td class="atas" width="20">33.</td>
                  <td class="atas" width="400">Tidak ada  langit-langit atau plavon di tempat tertentu yang diperlukan</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('42|','',$aspek_penilaian[42]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('32|','',$aspek_keterangan[32]); ?></textarea></td>
            </tr>
                <tr id="point34_fisik">
                  <td class="atas">34.</td>
                  <td class="atas" width="400">Langit langit /  plavon tidak bebas dari kemungkinan catnya mengelupas / rontok atau ada  kondensasi</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('43|','',$aspek_penilaian[43]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor","Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('33|','',$aspek_keterangan[33]); ?></textarea></td>
            </tr>
                <tr id="point35_fisik">
                  <td class="atas">35.</td>
                  <td class="atas" width="400">Tidak kedap air dan  tidak mudah dibersihkan</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('44|','',$aspek_penilaian[44]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('34|','',$aspek_keterangan[34]); ?></textarea></td>
            </tr>
                <tr id="point36_fisik">
                  <td class="atas">36.</td>
                  <td class="atas" width="400">Tidak rata , retak ,  bocor , berlubang</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('45|','',$aspek_penilaian[45]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('35|','',$aspek_keterangan[35]); ?></textarea></td>
            </tr>
                <tr id="point37_fisik">
                  <td class="atas">37.</td>
                  <td class="atas" width="400">Ketinggian kurang  dari 2,40 m</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('46|','',$aspek_penilaian[46]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('36|','',$aspek_keterangan[36]); ?></textarea></td>
            </tr>
            </table>
                <table class="form_tabel" id="tb_pointg">
                <tr>
                  <td class="atas isi" width="20">g.</td>
                  <td class="atas isi" width="400">Fasilitas Pabrik</td>
                  </tr>
            </table>
            <table id="tb_pointg_subsatu" border="0" class="form_tabel">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Fasilitas cuci tangan dan kaki</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('47|','',$aspek_penilaian[47]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointg_subsatu"  onchange="ok_tb(\'#sel_atas_pointg_subsatu\', \'#tb_pointg_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point38_fisik">
                  <td class="atas" width="20">38.</td>
                  <td class="atas" width="400">Tidak ada tempat cuci  tangan, maupun bak cuci kaki, kalau ada tidak mencukupi</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('48|','',$aspek_penilaian[48]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('37|','',$aspek_keterangan[37]) ?></textarea></td>
            </tr>
                <tr id="point39_fisik">
                  <td class="atas">39.</td>
                  <td class="atas" width="400">Tempat cuci tangan  dan bak cuci kaki tidak mudah dijangkau atau tidak ditempatkan secara layak</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('49|','',$aspek_penilaian[49]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('38|','',$aspek_keterangan[38]); ?></textarea></td>
            </tr>
                <tr id="point40_fisik">
                  <td class="atas">40.</td>
                  <td class="atas" width="400">Fasilitas pencucian  tidak disediakan <em>(sabun, pengering, dan  lain-lain)</em></td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('50|','',$aspek_penilaian[50]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('39|','',$aspek_keterangan[39]); ?></textarea></td>
            </tr>
                <tr id="point41_fisik">
                  <td class="atas">41.</td>
                  <td class="atas" width="400">Tidak ada peringatan  pencucian tangan sebelum bekerja atau setelah ke toilet</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('51|','',$aspek_penilaian[51]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('40|','',$aspek_keterangan[40]); ?></textarea></td>
            </tr>
                <tr id="point42_fisik">
                  <td class="atas">42.</td>
                  <td class="atas" width="400">Peralatan pencucian  tangan tidak cukup/tidak lengkap</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('52|','',$aspek_penilaian[52]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('41|','',$aspek_keterangan[41]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointg_subdua">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Toilet / Urinior Karyawan</td>
                  <td class="atas isi" width=""><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('53|','',$aspek_penilaian[53]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointg_subdua" onchange="ok_tb(\'#sel_atas_pointg_subdua\', \'#tb_pointg_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point43_fisik">
                  <td class="atas">43.</td>
                  <td class="atas" width="400">Tidak ada fasilitas/bahan  untuk pencucian seperti tisue, sabun (cair) dan pengering atau tidak ada  peringatan agar karyawan mencuci tangan mereka setelah menggunakan toilet</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('54|','',$aspek_penilaian[54]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('42|','',$aspek_keterangan[42]); ?></textarea></td>
            </tr>
                <tr id="point44_fisik">
                  <td class="atas">44.</td>
                  <td class="atas" width="400">Peralatan toilet  tidak lengkap</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('55|','',$aspek_penilaian[55]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('43|','',$aspek_keterangan[43]); ?></textarea></td>
            </tr>
                <tr id="point45_fisik">
                  <td class="atas">45.</td>
                  <td class="atas" width="400">Jumlah toilet tidak  mencukupi sebagaimana yang dipersyaratkan</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('56|','',$aspek_penilaian[56]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('44|','',$aspek_keterangan[44]); ?></textarea></td>
            </tr>
                <tr id="point46_fisik">
                  <td class="atas">46.</td>
                  <td class="atas" width="400">Pintu toilet  berhubungan langsung dengan ruang pengolahan</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('57|','',$aspek_penilaian[57]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('45|','',$aspek_keterangan[45]); ?></textarea></td>
            </tr>
                <tr id="point47_fisik">
                  <td class="atas">47.</td>
                  <td class="atas" width="400">Konstruksi toilet tidak  layak <em>(lantai</em>, <em>dinding, langit-langit, pintu, ventilasi, dll.)</em></td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('58|','',$aspek_penilaian[58]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('46|','',$aspek_keterangan[46]); ?></textarea></td>
            </tr>
                <tr id="point48_fisik">
                  <td class="atas">48.</td>
                  <td class="atas" width="400">Tidak dilengkapi  dengan saluran pembuangan</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('59|','',$aspek_penilaian[59]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('47|','',$aspek_keterangan[47]); ?></textarea></td>
            </tr>
                <tr id="point49_fisik">
                  <td class="atas">49.</td>
                  <td class="atas" width="400">Toilet tidak terawat  atau digunakan untuk keperluan lain</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('60|','',$aspek_penilaian[60]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('48|','',$aspek_keterangan[48]); ?></textarea></td>
            </tr>
                <tr id="point50_fisik">
                  <td class="atas">50.</td>
                  <td class="atas" width="400">Intensitas cahaya  penerangan tidak cukup, atau menyilaukan</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('61|','',$aspek_penilaian[61]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('49|','',$aspek_keterangan[49]); ?></textarea></td>
            </tr>
                <tr id="point51_fisik">
                  <td height="29" class="atas">51.</td>
                  <td class="atas" width="400">Lampu di ruang pengolahan, penyimpanan material dan  pengemasan tidak aman <em>(tanpa</em> <em>pelindung)</em></td>        
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('62|','',$aspek_penilaian[62]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('50|','',$aspek_keterangan[50]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointg_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Ventilasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('63|','',$aspek_penilaian[63]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointg_subtiga" onchange="ok_tb(\'#sel_atas_pointg_subtiga\', \'#tb_pointg_subtiga\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point52_fisik">
                  <td class="atas" width="20">52.</td>
                  <td class="atas" width="400">Terjadi akumulasi  kondensasi di atas ruang pengolahan, pengemasan dan penyimpanan bahan </td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('64|','',$aspek_penilaian[64]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('51|','',$aspek_keterangan[51]); ?></textarea></td>
            </tr>
                <tr id="point53_fisik">
                  <td class="atas">53.</td>
                  <td class="atas" width="400">Terdapat kapang  (mold), asap dan bau yang mengganggu di ruang pengolahan</td>        
                 <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('65|','',$aspek_penilaian[65]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('52|','',$aspek_keterangan[52]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointg_subempat">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">PPPK/Klinik/Fasilitas Keamanan Kerja</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('66|','',$aspek_penilaian[66]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointg_subempat" onchange="ok_tb(\'#sel_atas_pointg_subempat\', \'#tb_pointg_subempat\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point54_fisik">
                  <td class="atas" width="20">54.</td>
                  <td class="atas" width="400">Tak tersedia PPPK atau  fasilitas keamanan/kesehatan kerja (klinik) yang memadai</td>       
                  <td class="atas" width="30"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('67|','',$aspek_penilaian[67]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('53|','',$aspek_keterangan[53]); ?></textarea></td>
            </tr>
                <tr id="point55_operasional">
                  <td class="atas">55.</td>
                  <td class="atas" width="400">Fasilitas klinik  pabrik tidak digunakan untuk cek up rutin seluruh karyawan khususnya di bagian  produksi</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('68|','',$aspek_penilaian[68]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('54|','',$aspek_keterangan[54]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointh">
                <tr>
                  <td class="atas isi" width="20">h.</td>
                  <td colspan="2" class="atas isi" width="400">Pembuangan Limbah di Pabrik</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointh_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Sistem Pembuangan Limbah dalam pabrik (cair, sisa produk, pada/kering)</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('69|','',$aspek_penilaian[69]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointh_subsatu" onchange="ok_tb(\'#sel_atas_pointh_subsatu\', \'#tb_pointh_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point56_operasional">
                  <td class="atas" width="20">56.</td>
                  <td class="atas" width="400">Limbah cair tidak ditangani  dengan baik</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('70|','',$aspek_penilaian[70]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('55|','',$aspek_keterangan[55]); ?></textarea></td>
            </tr>
                <tr id="point57_operasional">
                  <td class="atas">57.</td>
                  <td class="atas" width="400">Limbah produksi atau sisa-sisa produksi tidak  dikumpulkan dan tidak ditangani dengan baik</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('71|','',$aspek_penilaian[71]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('56|','',$aspek_keterangan[56]); ?></textarea></td>
            </tr>
                <tr id="point58_operasional">
                  <td class="atas">58.</td>
                  <td class="atas" width="400">Limbah kering/padat  tidak ditangani dan dikumpulkan pada wadah yang baik dan mencukupi jumlahnya  untuk seluruh pabrik</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('72|','',$aspek_penilaian[72]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('57|','',$aspek_keterangan[57]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointh_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Tempat sampah dalam pabrik</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('73|','',$aspek_penilaian[73]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointh_subdua" onchange="ok_tb(\'#sel_atas_pointh_subdua\', \'#tb_pointh_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point59_fisik">
                  <td class="atas" width="20">59.</td>
                  <td class="atas" width="400">Konstruksi tempat  pembuangan limbah tidak selayaknya</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('74|','',$aspek_penilaian[74]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('58|','',$aspek_keterangan[58]); ?></textarea></td>
            </tr>
                <tr id="point60_fisik">
                  <td class="atas">60.</td>
                  <td class="atas" width="400">Tempat/wadah sampah tidak ada penutupnya</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('75|','',$aspek_penilaian[75]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('59|','',$aspek_keterangan[59]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointh_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Saluran/Pembuangan dalam pabrik</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('76|','',$aspek_penilaian[76]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointh_subtiga" onchange="ok_tb(\'#sel_atas_pointh_subtiga\', \'#tb_pointh_subtiga\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point61_operasional">
                  <td class="atas" width="20">61.</td>
                  <td class="atas" width="400">Sistem pembuangan  limbah cair/saluran dalam pabrik kurang  baik</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('77|','',$aspek_penilaian[77]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('60|','',$aspek_keterangan[60]); ?></textarea></td>
            </tr>
                <tr id="point62_fisik">
                  <td class="atas">62.</td>
                  <td class="atas" width="400">Kapasitas saluran  dalam pabrik tidak mencukupi</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('78|','',$aspek_penilaian[78]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('61|','',$aspek_keterangan[61]); ?></textarea></td>
            </tr>
                <tr id="point63_fisik">
                  <td class="atas">63.</td>
                  <td class="atas" width="400">Dinding saluran air  tidak halus dan tidak kedap air</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('79|','',$aspek_penilaian[79]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('62|','',$aspek_keterangan[62]); ?></textarea></td>
            </tr>
                <tr id="point64_fisik">
                  <td class="atas">64.</td>
                  <td class="atas" width="400">Saluran pembuangan  tidak tertutup dan tidak dilengkapi bak kontrol dan alirannya terhambat oleh  kotoran fisik</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('80|','',$aspek_penilaian[80]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('63|','',$aspek_keterangan[63]); ?></textarea></td>
            </tr>
                <tr id="point65_fisik">
                  <td class="atas">65.</td>
                  <td class="atas" width="400">Tidak dilengkapi  dengan alat yang mempunyai katup untuk mencegah masuknya air ke dalam pabrik</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('81|','',$aspek_penilaian[81]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('64|','',$aspek_keterangan[64]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointi">
                <tr>
                  <td class="atas isi" width="20">i.</td>
                  <td class="atas isi" width="400">Operasional Sanitasi di Pabrik</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('82|','',$aspek_penilaian[82]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointi" onchange="ok_tb(\'#sel_atas_pointi\', \'#tb_pointi\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr>
                  <td class="atas isi">&nbsp;</td>
                  <td class="atas isi" colspan="3">Program Sanitasi</td>
                </tr>
                <tr id="point66_operasional">
                  <td class="atas">66.</td>
                  <td class="atas" width="400">Tidak ada program  sanitasi yang efektif di unit pengolahan</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('83|','',$aspek_penilaian[83]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('65|','',$aspek_keterangan[65]); ?></textarea></td>
            </tr>
                <tr id="point67_operasional">
                  <td class="atas">67.</td>
                  <td class="atas" width="400">Kontrol sanitasi  tidak efektif melindungi produk dari kontaminasi.</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('84|','',$aspek_penilaian[84]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('66|','',$aspek_keterangan[66]); ?></textarea></td>
            </tr>
                <tr id="point68_operasional">
                  <td class="atas">68.</td>
                  <td class="atas" width="400">Peralatan dan wadah  tidak dicuci dan disanitasi sebelum digunakan</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('85|','',$aspek_penilaian[85]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('67|','',$aspek_keterangan[67]); ?></textarea></td>
            </tr>
                <tr id="point69_operasional">
                  <td class="atas">69.</td>
                  <td class="atas" width="400">Metode  pembersihan/pencucian tidak mencegah kontaminasi terhadap produk</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('86|','',$aspek_penilaian[86]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('68|','',$aspek_keterangan[68]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointj">
                <tr>
                  <td class="atas isi" width="20">j.</td>
                  <td class="atas isi" width="400">Binatang penggangu / serangga dalam pabrik</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('87|','',$aspek_penilaian[87]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointj" onchange="ok_tb(\'#sel_atas_pointj\', \'#tb_pointj\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr id="point70_fisik">
                  <td class="atas">70.</td>
                  <td class="atas" width="400">Ruang dan tempat yang  digunakan untuk penerimaan, pengolahan dan penyimpanan bahan baku/produk akhir  tidak dipelihara kebersihan dan sanitasinya</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('88|','',$aspek_penilaian[88]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('69|','',$aspek_keterangan[69]); ?></textarea></td>
            </tr>
                <tr id="point71_fisik">
                  <td class="atas">71.</td>
                  <td class="atas" width="400">Tidak ada  pengendalian untuk mencegah masuknya serangga, tikus, dan binatang pengganggu  lainnya di dalam pabrik</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('89|','',$aspek_penilaian[89]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('70|','',$aspek_keterangan[70]); ?></textarea></td>
            </tr>
                <tr id="point72_fisik">
                  <td class="atas">72.</td>
                  <td class="atas" width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif didalam pabrik</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('90|','',$aspek_penilaian[90]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('71|','',$aspek_keterangan[71]); ?></textarea></td>
            </tr>
                <tr id="point73_operasional">
                  <td class="atas">73.</td>
                  <td class="atas" width="400">Binatang peliharaan  tidak dicegah masuk kedalam pabrik</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('91|','',$aspek_penilaian[91]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('72|','',$aspek_keterangan[72]); ?></textarea></td>
            </tr>
                <tr id="point74_operasional">
                  <td class="atas">74.</td>
                  <td class="atas" width="400">Penggunaan obat pembasmi serangga, tikus, binatang  pengerat lain, serta kapang tidak  efektif (pestisida, insektisida, fungisida , bahan repellent)</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('92|','',$aspek_penilaian[92]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('73|','',$aspek_keterangan[73]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointk">
                <tr>
                  <td class="atas isi" width="20">k.</td>
                  <td class="atas isi" width="400">Peralatan Produksi</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointk_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Sanitasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('93|','',$aspek_penilaian[93]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointk_subsatu" onchange="ok_tb(\'#sel_atas_pointk_subsatu\', \'#tb_pointk_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point75_fisik">
                  <td class="atas" width="20">75.</td>
                  <td class="atas" width="400">Permukaan peralatan,  wadah dan alat-alat lain yang kontak dengan produk tidak dibuat dari bahan yang  sesuai seperti halus, tahan karat, tahan air dan tahan terhadap bahan kimia</td>        
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('94|','',$aspek_penilaian[94]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('74|','',$aspek_keterangan[74]); ?></textarea></td>
            </tr>
                <tr id="point76_fisik">
                  <td class="atas">76.</td>
                  <td class="atas" width="400">Bahan yang terbuat  dari kayu tidak dilapisi dengan bahan yang tidak berbahaya dan/atau kedap air</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('95|','',$aspek_penilaian[95]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('75|','',$aspek_keterangan[75]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointk_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Desain</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('96|','',$aspek_penilaian[96]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointk_subdua" onchange="ok_tb(\'#sel_atas_pointk_subdua\', \'#tb_pointk_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point77_fisik">
                  <td class="atas" width="20">77.</td>
                  <td class="atas" width="400">Rancang bangun,  konstruksi dan penempatan peralatan serta wadah tidak menjamin sanitasi dan  tidak dapat dibersihkan secara efektif</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('97|','',$aspek_penilaian[97]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('76|','',$aspek_keterangan[76]); ?></textarea></td>
            </tr>
                <tr id="point78_fisik">
                  <td class="atas">78.</td>
                  <td class="atas" width="400">Peralatan dan wadah  yang masih digunakan tidak dirawat dengan baik.</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('98|','',$aspek_penilaian[98]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('77|','',$aspek_keterangan[77]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointk_subtiga">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Peralatan tidak di pakai lagi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('99|','',$aspek_penilaian[99]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointk_subtiga" onchange="ok_tb(\'#sel_atas_pointk_subtiga\', \'#tb_pointk_subtiga\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point79_operasional">
                  <td class="atas" width="20">79.</td>
                  <td class="atas" width="400">Tidak ada program  pemantauan untuk membuang wadah dan peralatan yang sudah rusak/tidak digunakan</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('100|','',$aspek_penilaian[100]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('78|','',$aspek_keterangan[78]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointk_subempat">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Kecukupan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('101|','',$aspek_penilaian[101]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointk_subempat" onchange="ok_tb(\'#sel_atas_pointk_subempat\', \'#tb_pointk_subempat\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point80_fisik">
                  <td class="atas" width="20">80.</td>
                  <td class="atas" width="400">Peralatan  kebersihan tidak sesuai kapasitas produksi  atau tidak cukup tersedia</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('102|','',$aspek_penilaian[102]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('79|','',$aspek_keterangan[79]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointk_sublima">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Penyuci halaman peralatan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('103|','',$aspek_penilaian[103]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointk_sublima" onchange="ok_tb(\'#sel_atas_pointk_sublima\', \'#tb_pointk_sublima\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point81_operasional">
                  <td class="atas" width="20">81.</td>
                  <td class="atas" width="400">Tidak dilakukan  penyucihamaan peralatan secara efektif</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('104|','',$aspek_penilaian[104]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('80|','',$aspek_keterangan[80]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointl">
                <tr>
                  <td class="atas isi" width="20">l.</td>
                  <td class="atas isi" width="400">Pasokan Air</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
             </table>
             <table class="form_tabel" id="tb_pointl_subsatu">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Sumber Air</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('105|','',$aspek_penilaian[105]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointl_subsatu" onchange="ok_tb(\'#sel_atas_pointl_subsatu\', \'#tb_pointl_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point82_fisik">
                  <td class="atas" width="20">82.</td>
                  <td class="atas" width="400">Pasokan air panas  atau dingin tidak cukup</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('106|','',$aspek_penilaian[106]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('81|','',$aspek_keterangan[81]); ?></textarea></td>
            </tr>
                <tr id="point83_fisik">
                  <td class="atas">83.</td>
                  <td class="atas" width="400">Air tidak mudah dijangkau/disediakan</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('107|','',$aspek_penilaian[107]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('82|','',$aspek_keterangan[82]); ?></textarea></td>
            </tr>
                <tr id="point84_fisik">
                  <td class="atas">84.</td>
                  <td class="atas" width="400">Air dapat  terkontaminasi, misalnya hubungan silang antara air kotor dengan air bersih,  sanitasi lingkungan</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('108|','',$aspek_penilaian[108]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('83|','',$aspek_keterangan[83]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointl_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">'Treatment' air</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('109|','',$aspek_penilaian[109]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointl_subdua" onchange="ok_tb(\'#sel_atas_pointl_subdua\', \'#tb_pointl_subdua\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point85_fisik">
                  <td class="atas" width="20">85.</td>
                  <td class="atas" width="400">Air baku tidak layak digunakan <em>(potable</em>), tidak dilakukan pengujian secara  berkala</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('110|','',$aspek_penilaian[110]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('84|','',$aspek_keterangan[84]); ?></textarea></td>
            </tr>
                <tr id="point86_operasional">
                  <td class="atas">86.</td>
                  <td class="atas" width="400">Air tidak mendapat persetujuan  dari pihak berwenang untuk digunakan sebagai bahan untuk pengolahan (tidak ada  hasil uji)</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('111|','',$aspek_penilaian[111]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('85|','',$aspek_keterangan[85]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointl_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Es (apabila digunakan)</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('112|','',$aspek_penilaian[112]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointl_subtiga" onchange="ok_tb(\'#sel_atas_pointl_subtiga\', \'#tb_pointl_subtiga\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point87_fisik">
                  <td class="atas" width="20">87.</td>
                  <td class="atas" width="400">Tidak terbuat dari air  yang memenuhi persyaratan <em>(potable)</em></td>         
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('113|','',$aspek_penilaian[113]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('86|','',$aspek_keterangan[86]); ?></textarea></td>
            </tr>
                <tr id="point88_fisik">
                  <td class="atas">88.</td>
                  <td class="atas" width="400">Tidak dibuat dari air  yang telah diijinkan</td>           
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('114|','',$aspek_penilaian[114]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('87|','',$aspek_keterangan[87]); ?></textarea></td>
            </tr>
                <tr id="point89_fisik">
                  <td class="atas">89.</td>
                  <td class="atas" width="400">Tidak dibuat, ditangani  dan digunakan sesuai persyaratan sanitasi</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('115|','',$aspek_penilaian[115]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('88|','',$aspek_keterangan[88]); ?></textarea></td>
            </tr>
                <tr id="point90_fisik">
                  <td class="atas">90.</td>
                  <td class="atas" width="400">Digunakan kembali  untuk bahan baku  yang diproses berikutnya</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('116|','',$aspek_penilaian[116]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('89|','',$aspek_keterangan[89]); ?></textarea></td>
            </tr>
            </table>
            <table id="tb_pointm" border="0">
                <tr>
                  <td class="atas isi" width="20">m.</td>
                  <td class="atas isi" width="400">Sanitasi dan Higiene Karyawan</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointm_subsatu">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Pembinaan Karyawan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('117|','',$aspek_penilaian[117]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointm_subsatu" onchange="ok_tb(\'#sel_atas_pointm_subsatu\', \'#tb_pointm_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point91_operasional">
                  <td class="atas" width="20">91.</td>
                  <td class="atas" width="400">Manajemen unit  pengolahan tidak memiliki tidakan-tindakan efektif untuk mencegah karyawan yang  diketahui menghidap penyakit yang dapat mengkontaminasi produk <em>(luka, TBC, Hepatitis, Tipus dsb.)</em></td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('118|','',$aspek_penilaian[118]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('90|','',$aspek_keterangan[90]); ?></textarea></td>
            </tr>
                <tr id="point92_operasional">
                  <td class="atas">92.</td>
                  <td class="atas" width="400">Pelatihan pekerja  dalam hal sanitasi dan higiene tidak cukup</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('119|','',$aspek_penilaian[119]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('91|','',$aspek_keterangan[91]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointmsubdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Perilaku Karyawan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('120|','',$aspek_penilaian[120]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointm_subdua" onchange="ok_tb(\'#sel_atas_pointm_subdua\', \'#tb_pointmsubdua\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point93_operasional">
                  <td class="atas" width="20">93.</td>
                  <td class="atas" width="400">Kebersihan karyawan  tidak dijaga dengan baik dan tidak memperhatikan aspek sanitasi dan higiene <em>(seperti pakaian kurang</em> <em>lengkap dan kotor, meludah di ruang</em> <em>pengolahan, merokok dan</em> <em>lain-lain)</em></td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('121|','',$aspek_penilaian[121]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('92|','',$aspek_keterangan[92]); ?></textarea></td>
            </tr>
                <tr id="point94_operasional">
                  <td class="atas">94.</td>
                  <td class="atas" width="400">Tindak-tanduk  karyawan tidak mampu mengurangi dan mencegah kontaminasi baik dari mikroba  maupun benda asing lainnya</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('122|','',$aspek_penilaian[122]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('93|','',$aspek_keterangan[93]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointm_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Sanitasi Karyawan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('123|','',$aspek_penilaian[123]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointm_subtiga" onchange="ok_tb(\'#sel_atas_pointm_subtiga\', \'#tb_pointm_subtiga\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point95_operasional">
                  <td class="atas" width="20">95.</td>
                  <td class="atas" width="400">Pakain kerja tidak  dipakai dengan benar dan tidak bersih</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('124|','',$aspek_penilaian[124]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('94|','',$aspek_keterangan[94]); ?></textarea></td>
            </tr>
                <tr id="point96_operasional">
                  <td class="atas">96.</td>
                  <td class="atas" width="400">Tidak ada pengawasan  dalam sanitasi, pencucian tangan dan kaki sebelum masuk ruang pengolahan dan  setelah keluar dari toilet</td>        
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('125|','',$aspek_penilaian[125]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('95|','',$aspek_keterangan[95]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointm_subempat">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Sumber infeksi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('126|','',$aspek_penilaian[126]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointm_subempat" onchange="ok_tb(\'#sel_atas_pointm_subempat\', \'#tb_pointm_subempat\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point97_operasional">
                  <td class="atas" width="20">97.</td>
                  <td class="atas"width="400">Karyawan tidak bebas  dari penyakit kulit, atau penyakit menular lainnya</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('127|','',$aspek_penilaian[127]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('96|','',$aspek_keterangan[96]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointn">
                <tr>
                  <td class="atas isi" width="20">n.</td>
                  <td class="atas isi" width="400">Gudang biasa (kering)</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointn_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Kontrol sanitasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('128|','',$aspek_penilaian[128]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointn_subsatu" onchange="ok_tb(\'#sel_atas_pointn_subsatu\', \'#tb_pointn_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point98_fisik">
                  <td class="atas" width="20">98.</td>
                  <td class="atas" width="400">Tidak menggunakan  tempat penyimpanan seperti pallet, lemari, kabinet rak dan lain-lain yang  dibutuhkan untuk mencegah kontaminasi.</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('129|','',$aspek_penilaian[129]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas"  width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('97|','',$aspek_keterangan[97]); ?></textarea></td>
            </tr>
                <tr id="point99_operasional">
                  <td class="atas">99.</td>
                  <td class="atas" width="400">Metode penyimpanan  bahan berpeluang terjadinya kontaminasi</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('130|','',$aspek_penilaian[130]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('98|','',$aspek_keterangan[98]); ?></textarea></td>
            </tr>
                <tr id="point100_fisik">
                  <td class="atas">100.</td>
                  <td class="atas" width="400">Fasilitas penyimpanan  tidak bersih, tidak saniter dan tidak dirawat dengan baik </td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('131|','',$aspek_penilaian[131]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('99|','',$aspek_keterangan[99]); ?></textarea></td>
            </tr>
                <tr id="point101_operasional">
                  <td class="atas">101.</td>
                  <td class="atas" width="400">Penempatan barang tidak teratur dan tidak  dipisah-pisahkan (Penyimpanan bahan pengemas  dan bahan-bahan lain: kimia, bahan berbahaya dll)</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('132|','',$aspek_penilaian[132]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('100|','',$aspek_keterangan[100]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointn_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Pencegahan serangga, tikus, dan binatang lain</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('133|','',$aspek_penilaian[133]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointn_subdua" onchange="ok_tb(\'#sel_atas_pointn_subdua\', \'#tb_pointn_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point102_operasional">
                  <td class="atas" width="20">102.</td>
                  <td class="atas" width="400">Tidak ada pengendalian  untuk mencegah serangga, tikus dan binatang pengganggu lainnya digudang</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('134|','',$aspek_penilaian[134]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('101|','',$aspek_keterangan[101]); ?></textarea></td>
            </tr>
                <tr id="point103_operasional">
                  <td class="atas">103.</td>
                  <td class="atas" width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('135|','',$aspek_penilaian[135]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('102|','',$aspek_keterangan[102]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointn_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Ventilasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('136|','',$aspek_penilaian[136]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointn_subtiga" onchange="ok_tb(\'#sel_atas_pointn_subtiga\', \'#tb_pointn_subtiga\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point104_fisik">
                  <td class="atas" width="20">104.</td>
                  <td class="atas" width="400">Ventilasi tidak  berfungsi dengan baik</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('137|','',$aspek_penilaian[137]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('103|','',$aspek_keterangan[103]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointo">
                <tr>
                  <td class="atas isi" width="20">o.</td>
                  <td class="atas isi" width="400">Gudang  Beku, Dingin (apabila digunakan)</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointo_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Kontrol sanitasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('138|','',$aspek_penilaian[138]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointo_subsatu" onchange="ok_tb(\'#sel_atas_pointo_subsatu\', \'#tb_pointo_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point105_fisik">
                  <td class="atas" width="20">105.</td>
                  <td class="atas" width="400">Metode penyimpanan  bahan-bahan berpeluang terjadinya  kontaminasi.</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('139|','',$aspek_penilaian[139]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('104|','',$aspek_keterangan[104]); ?></textarea></td>
            </tr>
                <tr id="point106_fisik">
                  <td class="atas">106.</td>
                  <td class="atas" width="400">Fasilitas penyimpanan  tidak bersih, saniter dan tidak dirawat dengan baik </td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('140|','',$aspek_penilaian[140]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('105|','',$aspek_keterangan[105]); ?></textarea></td>
            </tr>
                <tr id="point107_fisik">
                  <td class="atas">107.</td>
                  <td class="atas" width="400">Tidak ada pemisahan  barang secara teratur</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('141|','',$aspek_penilaian[141]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('106|','',$aspek_keterangan[106]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointo_subdua">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Pencegahan serangga, tikus, dan binatang lain</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('142|','',$aspek_penilaian[142]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointo_subdua" onchange="ok_tb(\'#sel_atas_pointo_subdua\', \'#tb_pointo_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point108_fisik">
                  <td class="atas" width="20">108.</td>
                  <td class="atas" width="400">Tidak ada pengendalian untuk mencegah serangga,  digudang</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('143|','',$aspek_penilaian[143]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('107|','',$aspek_keterangan[107]); ?></textarea></td>
            </tr>
                <tr id="point109_operasional">
                  <td class="atas">109.</td>
                  <td class="atas" width="400">Pencegahan serangga, tidak  efektif</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('144|','',$aspek_penilaian[144]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('108|','',$aspek_keterangan[108]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointo_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Kontrol suhu</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('145|','',$aspek_penilaian[145]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointo_subtiga" onchange="ok_tb(\'#sel_atas_pointo_subtiga\', \'#tb_pointo_subtiga\')"'); ?></td>
                  <td>&nbsp;</td>
                </tr>
                <tr id="point110_fisik">
                  <td class="atas" width="20">110.</td>
                  <td class="atas" width="400">Produk beku tidak  terlindung dari peningkatan suhu</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('146|','',$aspek_penilaian[146]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('109|','',$aspek_keterangan[109]); ?></textarea></td>
            </tr>
                <tr id="point111_fisik">
                  <td class="atas">111.</td>
                  <td class="atas" width="400">Ruang penyimpanan  tidak dilengkapi dengan kontrol suhu</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('147|','',$aspek_penilaian[147]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('110|','',$aspek_keterangan[110]); ?></textarea></td>
            </tr>
                <tr id="point112_fisik">
                  <td class="atas">112.</td>
                  <td class="atas" width="400">Ada bahan yang  mengandung zat logam disimpan dengan produk</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('148|','',$aspek_penilaian[148]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('111|','',$aspek_keterangan[111]); ?></textarea></td>
            </tr>
                <tr id="point113_fisik">
                  <td class="atas">113.</td>
                  <td class="atas" width="400">Ruang penyimpanan  produk tidak dioperasikan pada suhu yang dipersyaratkan</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('149|','',$aspek_penilaian[149]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('112|','',$aspek_keterangan[112]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointp">
                <tr>
                  <td class="atas isi" width="20">p.</td>
                  <td class="atas isi" width="400">Gudang kemasan produk</td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
            </table>
            <table class="form_tabel" id="tb_pointp_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Kontrol sanitasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('150|','',$aspek_penilaian[150]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointp_subsatu" onchange="ok_tb(\'#sel_atas_pointp_subsatu\', \'#tb_pointp_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point114_fisik">
                  <td class="atas" width="20">114.</td>
                  <td class="atas" width="400">Tidak menggunakan  tempat penyimpanan seperti pallet atau  rak dan lain-lain yang dibutuhkan untuk mencegah kontaminasi</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('151|','',$aspek_penilaian[151]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('113|','',$aspek_keterangan[113]); ?></textarea></td>
            </tr>
                <tr id="point115_operasional">
                  <td class="atas">115.</td>
                  <td class="atas" width="400">Metode penyimpanan  bahan-bahan berpeluang terjadinya kontaminasi</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('152|','',$aspek_penilaian[152]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('114|','',$aspek_keterangan[114]); ?></textarea></td>
            </tr>
                <tr id="point116_fisik">
                  <td class="atas">116.</td>
                  <td class="atas" width="400">Fasilitas penyimpanan  tidak bersih, tidak saniter dan tidak dirawat dengan baik </td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('153|','',$aspek_penilaian[153]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('115|','',$aspek_keterangan[115]); ?></textarea></td>
            </tr>
                <tr id="point117_fisik">
                  <td class="atas">117.</td>
                  <td class="atas" width="400">Wadah atau pengemas tidak disimpan pada tempat yang  bersih, rapi dan terlindung dari kontaminasi</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('154|','',$aspek_penilaian[154]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('116|','',$aspek_keterangan[116]); ?></textarea></td>
            </tr>
                <tr id="point118_fisik">
                  <td class="atas">118.</td>
                  <td class="atas" width="400">Tidak terpisah pada  tempat khusus</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('155|','',$aspek_penilaian[155]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('117|','',$aspek_keterangan[117]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointp_subdua">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Pencegahan serangga, tikus, dan binatang lain</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('156|','',$aspek_penilaian[156]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointp_subdua" onchange="ok_tb(\'#sel_atas_pointp_subdua\', \'#tb_pointp_subdua\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point119_operasional">
                  <td class="atas" width="20">119.</td>
                  <td class="atas" width="400">Tidak ada  pengendalian untuk mencegah serangga,  tikus dan binatang pengganggu lainnya digudang</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('157|','',$aspek_penilaian[157]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('118|','',$aspek_keterangan[118]); ?></textarea></td>
            </tr>
                <tr id="point120_fisik">
                  <td class="atas">120.</td>
                  <td class="atas" width="400">Pencegahan serangga,  burung, tikus dan binatang lain tidak efektif</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('158|','',$aspek_penilaian[158]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('119|','',$aspek_keterangan[119]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointp_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Ventilasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('159|','',$aspek_penilaian[159]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointp_subtiga" onchange="ok_tb(\'#sel_atas_pointp_subtiga\', \'#tb_pointp_subtiga\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point121_fisik">
                  <td class="atas" width="20">121.</td>
                  <td class="atas" width="400">Ventilasi tidak  berfungsi dengan baik</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('160|','',$aspek_penilaian[160]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('120|','',$aspek_keterangan[120]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointq">
                <tr>
                  <td class="atas isi" width="20">q.</td>
                  <td class="atas isi" width="400">Tindakan Pengawasan</td>
                  <td></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Bahan baku/mentah</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('161|','',$aspek_penilaian[161]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointq" onchange="ok_tb(\'#sel_atas_pointq\', \'#tb_pointq\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point122_operasional">
                  <td class="atas">122.</td>
                  <td class="atas" width="400">Tidak dilakukan  pengujian mutu sebelum diolah</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('162|','',$aspek_penilaian[162]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('121|','',$aspek_keterangan[121]); ?></textarea></td>
            </tr>
                <tr id="point123_operasional">
                  <td class="atas">123.</td>
                  <td class="atas" width="400">Campuran bahan baku tidak disesuaikan  spesifikasi</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('162|','',$aspek_penilaian[162]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('122|','',$aspek_keterangan[122]); ?></textarea></td>
            </tr>
                <tr id="point124_operasional">
                  <td class="atas">124.</td>
                  <td class="atas" width="400">Bahan Tambahan Pangan  tidak sesuai dengan peraturan</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('164|','',$aspek_penilaian[164]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('123|','',$aspek_keterangan[123]); ?></textarea></td>
            </tr>
                <tr id="point125_operasional">
                  <td class="atas">125.</td>
                  <td class="atas" width="400">Proses Produksi tidak  dilakukan pengawasan setiap tahap</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('165|','',$aspek_penilaian[165]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('124|','',$aspek_keterangan[124]); ?></textarea></td>
            </tr>
                <tr id="point126_operasional">
                  <td class="atas">126.</td>
                  <td class="atas" width="400">Produk akhir tidak  dilakukan pengujian mutu sebelum diedarkan</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('166|','',$aspek_penilaian[166]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('125|','',$aspek_keterangan[125]); ?></textarea></td>
            </tr>
                <tr id="point127_operasional">
                  <td class="atas">127.</td>
                  <td class="atas" width="400">Penyimpanan bahan baku  dan produk akhir tidak dipisahkan</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('167|','',$aspek_penilaian[167]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('126|','',$aspek_keterangan[126]); ?></textarea></td>
            </tr>
                <tr id="point128_operasional">
                  <td class="atas">128.</td>
                  <td class="atas" width="400">Penyimpanan dan  penyerahan tidak dilakukan secara FIFO</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('168|','',$aspek_penilaian[168]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('127|','',$aspek_keterangan[127]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointr">
                <tr>
                  <td class="atas isi" width="20">r.</td>
                  <td class="atas isi" width="400">Bahan mentah dan produk akhir</td>
                  <td class="atas isi"></td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Kontaminasi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('169|','',$aspek_penilaian[169]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointr" onchange="ok_tb(\'#sel_atas_pointr\', \'#tb_pointr\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point129_operasional">
                  <td class="atas">129.</td>
                  <td class="atas" width="400">Terindikasi adanya  kontaminan setelah dilakukan pengujian bahan mentah atau produk akhir</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('170|','',$aspek_penilaian[170]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('128|','',$aspek_keterangan[128]); ?></textarea></td>
            </tr>
                <tr id="point130_operasional">
                  <td class="atas">130.</td>
                  <td class="atas" width="400">Teridikasi adanya  kemunduran mutu/deteriorasi/dekomposisi setelah dilakukan pengujian bahan  mentah dan produk akhir</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('171|','',$aspek_penilaian[171]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('129|','',$aspek_keterangan[129]); ?></textarea></td>
            </tr>
                <tr id="point131_operasional">
                  <td class="atas">131.</td>
                  <td class="atas" width="400">Terindikasi adanya  pencemaran fisik benda-benda asing setelah dilakukan pengujian bahan mentah dan  produk akhir</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('172|','',$aspek_penilaian[172]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('130|','',$aspek_keterangan[130]); ?></textarea></td>
            </tr>
                <tr id="point132_operasional">
                  <td class="atas">132.</td>
                  <td class="atas" width="400">Penanganan,  Pengolahan, penyimpanan, pengangkutan dan pengemasan tidak dilakukan secara  higienis</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('173|','',$aspek_penilaian[173]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('131|','',$aspek_keterangan[131]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_points">
                <tr>
                  <td class="atas isi" width="20">s.</td>
                  <td class="atas isi" width="400">Hasil Uji</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_points_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Pengujian bahan baku dan produk akhir</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('174|','',$aspek_penilaian[174]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_points_subsatu" onchange="ok_tb(\'#sel_atas_points_subsatu\', \'#tb_points_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point133_operasional">
                  <td class="atas" width="20">133.</td>
                  <td class="atas" width="400">Tidak dilakukan  pengujian</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('175|','',$aspek_penilaian[175]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('132|','',$aspek_keterangan[132]); ?></textarea></td>
            </tr>
                <tr id="point134_fisik">
                  <td class="atas">134.</td>
                  <td class="atas" width="400">Tidak memiliki  laboratorium yang sekurang-kurangnya dilengkapi dengan peralatan dan media  untuk pengujian organoleptik dan mikrobiologi</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('176|','',$aspek_penilaian[176]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('133|','',$aspek_keterangan[133]); ?></textarea></td>
            </tr>
                <tr id="point135_operasional">
                  <td class="atas">135.</td>
                  <td class="atas" width="400">Jumlah tenaga  laboratorium tidak mencukupi dan atau kualifikasi tenaganya tidak memadai</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('177|','',$aspek_penilaian[177]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('134|','',$aspek_keterangan[134]); ?></textarea></td>
            </tr>
                <tr id="point136_operasional">
                  <td class="atas">136.</td>
                  <td class="atas" width="400">Tidak aktif  melaksanakan monitoring terhadap bahan baku,  bahan pembantu, kebersihan peralatan dan produk akhir</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('178|','',$aspek_penilaian[178]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('135|','',$aspek_keterangan[135]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_points_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Hasil Uji tidak memenuhi persyaratan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('179|','',$aspek_penilaian[179]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_points_subdua" onchange="ok_tb(\'#sel_atas_points_subdua\', \'#tb_points_subdua\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point137_operasional">
                  <td class="atas" width="20">137.</td>
                  <td class="atas" width="400">Angka Lempeng Total  (ALT)</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('180|','',$aspek_penilaian[180]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('136|','',$aspek_keterangan[136]); ?></textarea></td>
            </tr>
                <tr id="point138_operasional">
                  <td class="atas">138.</td>
                  <td class="atas" width="400">Staphyloccocci</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('181|','',$aspek_penilaian[181]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('137|','',$aspek_keterangan[137]); ?></textarea></td>
            </tr>
                <tr id="point139_operasional">
                  <td class="atas">139.</td>
                  <td class="atas" width="400">M.P.N. Coliform</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('182|','',$aspek_penilaian[182]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('138|','',$aspek_keterangan[138]); ?></textarea></td>
            </tr>
                <tr id="point140_operasional">
                  <td class="atas">140.</td>
                  <td class="atas" width="400">Faecal Streptococci</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('183|','',$aspek_penilaian[183]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('139|','',$aspek_keterangan[139]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointt">
                <tr>
                  <td class="atas isi" width="20">t.</td>
                  <td class="atas isi" width="400">Tindakan pengawasan</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointt_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Jaminan mutu</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('184|','',$aspek_penilaian[184]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointt_subsatu" onchange="ok_tb(\'#sel_atas_pointt_subsatu\', \'#tb_pointt_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point141_operasional">
                  <td class="atas" width="20">141.</td>
                  <td class="atas" width="400">Tidak dilakukan sistem jaminan  mutu pada keseluruhan proses (in-process)</td>            
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('185|','',$aspek_penilaian[185]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('140|','',$aspek_keterangan[140]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointt_subdua">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Prosedur Pelacakan & Penarikan (Recall Procedure)</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('186|','',$aspek_penilaian[186]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointt_subdua" onchange="ok_tb(\'#sel_atas_pointt_subdua\', \'#tb_pointt_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point142_operasional">
                  <td class="atas" width="20">142.</td>
                  <td class="atas" width="400">Tidak dilakukan dengan  baik, teratur dan kontinu</td>            
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('187|','',$aspek_penilaian[187]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('141|','',$aspek_keterangan[141]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointu">
                <tr>
                  <td class="atas isi" width="20">u.</td>
                  <td class="atas isi" width="400">Sarana Pengolahan / Pengawetan</td>
                  <td>&nbsp;</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Pendinginan, Pembekuan, Pengalengan, Pengeringan dan Pengolahan lainnya</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('188|','',$aspek_penilaian[188]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointu" onchange="ok_tb(\'#sel_atas_pointu\', \'#tb_pointu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point143_fisik">
                  <td class="atas">143.</td>
                  <td class="atas" width="400">Sarana  pengolahan/pengawetan tidak mencukupi</td>            
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('189|','',$aspek_penilaian[189]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('142|','',$aspek_keterangan[142]); ?></textarea></td>
            </tr>
                <tr id="point144_operasional">
                  <td class="atas">144.</td>
                  <td class="atas" width="400">Suhu dan waktu pengolahan/ pengawetan tidak sesuai persyaratan</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('190|','',$aspek_penilaian[190]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('143|','',$aspek_keterangan[143]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointv">
                <tr>
                  <td class="atas isi" width="20">v.</td>
                  <td class="atas isi">Penggunaan bahan kimia</td>
                  </tr>
                  </table>
                  <table class="form_tabel" id="tb_pointv_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Insektisida/Rodentisida/peptisida</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('191|','',$aspek_penilaian[191]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointv_subsatu" onchange="ok_tb(\'#sel_atas_pointv_subsatu\', \'#tb_pointv_subsatu\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point145_fisik">
                  <td class="atas" width="20">145.</td>
                  <td class="atas" width="400">Insektisida/rodentisida tidak sesuai persyaratan</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('192|','',$aspek_penilaian[192]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('144|','',$aspek_keterangan[144]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointv_subdua">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas" width="400">Bahan kimia/sanitizer/deterjen dll</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('193|','',$aspek_penilaian[193]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointv_subdua" onchange="ok_tb(\'#sel_atas_pointv_subdua\', \'#tb_pointv_subdua\')"'); ?></td>
                  <td width="300">&nbsp;</td>
                </tr>
                <tr id="point146_fisik">
                  <td class="atas" width="20">146.</td>
                  <td class="atas" width="400">Bahan kimia tidak digunakan  sesuai metode yang dipersyaratkan</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('194|','',$aspek_penilaian[194]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('145|','',$aspek_keterangan[145]); ?></textarea></td>
            </tr>
                <tr id="point147_fisik">
                  <td class="atas">147.</td>
                  <td class="atas" width="400">Bahan kimia,  sanitizer dan bahan tambahan tidak diberi label dan disimpan dengan baik</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('195|','',$aspek_penilaian[195]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('146|','',$aspek_keterangan[146]); ?></textarea></td>
            </tr>
                <tr id="point148_fisik">
                  <td class="atas">148.</td>
                  <td class="atas" width="400">Penggunaan bahan  kimia yang tidak diijinkan</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('196|','',$aspek_penilaian[196]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('147|','',$aspek_keterangan[147]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw">
                <tr>
                  <td class="atas isi" width="20">w.</td>
                  <td class="atas isi" width="400">Bahan, Penanganan dan Pengolahan</td>
                  <td class="atas" width="300">&nbsp;</td>
                  </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subsatu">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas" width="400">Bahan baku</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('197|','',$aspek_penilaian[197]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subsatu" onchange="ok_tb(\'#sel_atas_pointw_subsatu\', \'#tb_pointw_subsatu\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point149_operasional">
                  <td class="atas" width="20">149.</td>
                  <td class="atas" width="400">Tidak sesuai dengan  standar sehingga membahayakan kesehatan manusia</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('198|','',$aspek_penilaian[198]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('148|','',$aspek_keterangan[148]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subdua">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Bahan Tambahan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('199|','',$aspek_penilaian[199]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subdua" onchange="ok_tb(\'#sel_atas_pointw_subdua\', \'#tb_pointw_subdua\')"'); ?></td>
                  <td class="atas" width="300">&nbsp;</td>
                </tr>
                <tr id="point150_operasional">
                  <td class="atas" width="20">150.</td>
                  <td class="atas" width="400">Tidak sesuai dengan standar dan pemakaiannya tidak sesuai dengan persyaratan</td>    
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('200|','',$aspek_penilaian[200]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('149|','',$aspek_keterangan[149]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subtiga">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi">Penanganan bahan baku</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('201|','',$aspek_penilaian[201]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subtiga" onchange="ok_tb(\'#sel_atas_pointw_subtiga\', \'#tb_pointw_subtiga\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point151_operasional">
                  <td class="atas" width="20">151.</td>
                  <td class="atas" width="400">Penerimaan bahan baku tidak dilakukan  dengan baik, dan tidak terlindung dari kontaminan atau pengaruh  lingkungan yang tidak sehat</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('202|','',$aspek_penilaian[202]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('150|','',$aspek_keterangan[150]); ?></textarea></td>
            </tr>
                <tr id="point152_operasional">
                  <td class="atas">152.</td>
                  <td class="atas" width="400">Suhu produk yang  diolah di dalam ruang pengolahan tidak sesuai syarat</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('203|','',$aspek_penilaian[203]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('151|','',$aspek_keterangan[151]); ?></textarea></td>
            </tr>
                <tr id="point153_operasional">
                  <td class="atas">153.</td>
                  <td class="atas" width="400">Bahan baku yang datang terlebih  dahulu tidak diproses lebih dahulu (Sistem FIFO)</td>       
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('204|','',$aspek_penilaian[204]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('152|','',$aspek_keterangan[152]); ?></textarea></td>
            </tr>
                <tr id="point154_operasional">
                  <td class="atas">154.</td>
                  <td class="atas" width="400">Penanganan bahan baku ataupun produk dari  tahap satu ke tahap berikutnya tidak dilakukan secara hati-hati, higienes dan  saniter</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('205|','',$aspek_penilaian[205]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('153|','',$aspek_keterangan[153]); ?></textarea></td>
            </tr>
                <tr id="point155_operasional">
                  <td class="atas">155.</td>
                  <td class="atas" width="400">Penanganan produk  yang sedang menunggu giliran untuk diproses tidak disimpan/dikumpulkan di  tempat yang saniter</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('206|','',$aspek_penilaian[206]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('154|','',$aspek_keterangan[154]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subempat">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas isi" width="400">Pengolahan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('207|','',$aspek_penilaian[207]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subempat" onchange="ok_tb(\'#sel_atas_pointw_subempat\', \'#tb_pointw_subempat\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point156_operasional">
                  <td class="atas" width="20">156.</td>
                  <td class="atas" width="400">Proses pengolahan/pengawetan dilakukan tidak sesuai dengan jenis produk dan suhu serta  waktunya tidak sesuai dengan persyaratan</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('208|','',$aspek_penilaian[208]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('155|','',$aspek_keterangan[155]); ?></textarea></td>
            </tr>
                <tr id="point157_operasional">
                  <td class="atas">157.</td>
                  <td class="atas" width="400">Produk akhir tidak  mempunyai ukuran dan bentuk yang teratur</td> 
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('209|','',$aspek_penilaian[209]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Major", "Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('156|','',$aspek_keterangan[156]); ?></textarea></td>
            </tr>
                <tr id="point158_operasional">
                  <td class="atas">158.</td>
                  <td class="atas" width="400">Sistem pemberian  etiket atau kode-kode tidak dilakukan pada waktu memproses bahan baku yang dapat membantu identifikasi produk</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('210|','',$aspek_penilaian[210]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('157|','',$aspek_keterangan[157]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_sublima">
                <tr>
                  <td class="atas">&nbsp;</td>
                  <td class="atas">Pewadahan dan atau Pengemasan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('211|','',$aspek_penilaian[211]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_sublima" onchange="ok_tb(\'#sel_atas_pointw_sublima\', \'#tb_pointw_sublima\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point159_operasional">
                  <td class="atas" width="20">159.</td>
                  <td class="atas" width="400">Produk akhir tidak  dikemas dan atau diwadahi dengan cepat, tepat dan saniter</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('212|','',$aspek_penilaian[212]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('158|','',$aspek_keterangan[158]); ?></textarea></td>
            </tr>
                <tr id="point160_operasional">
                  <td class="atas">160.</td>
                  <td class="atas" width="400">Produk akhir tidak  diberi label yang memuat : jenis produk, nama perusahaan pembuat, ukuran, tipe, grade <em>(tingkatan mutu)</em>, tanggal kadaluwarsa, berat bersih, nama bahan tambahan makanan yang dipakai, kode produksi atau persyaratan lain</td>  
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('213|','',$aspek_penilaian[213]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('159|','',$aspek_keterangan[159]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subenam">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Penyimpanan</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('214|','',$aspek_penilaian[214]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subenam" onchange="ok_tb(\'#sel_atas_pointw_subenam\', \'#tb_pointw_subenam\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point161_operasional">
                  <td class="atas" width="20">161.</td>
                  <td class="atas" width="400">Produk akhir yang  disimpan dalam gudang tidak dipisah dengan barang lain</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('215|','',$aspek_penilaian[215]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('160|','',$aspek_keterangan[160]); ?></textarea></td>
            </tr>
                <tr id="point162_operasional">
                  <td class="atas">162.</td>
                  <td class="atas" width="400">Susunan produk akhir  tidak memungkinkan mempengaruhi kondisi masing-masing kemasan dan tidak  memungkinkan produk akhir yang lebih lama disimpan dikeluarkan terlebih dahulu  (tidak mengikuti FIFO).</td>
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('216|','',$aspek_penilaian[216]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('161|','',$aspek_keterangan[161]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_pointw_subtujuh">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Penyimpanan bahan berbahaya</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('217|','',$aspek_penilaian[217]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subtujuh" onchange="ok_tb(\'#sel_atas_pointw_subtujuh\', \'#tb_pointw_subtujuh\')"'); ?></td>
                  <td class="atas">&nbsp;</td>

                </tr>
                <tr id="point163_fisik">
                  <td class="atas" width="20">163.</td>
                  <td class="atas" width="400">Tidak tersendiri dan dapat terhindar dari hal-hal yang dapat membahayakan</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('218|','',$aspek_penilaian[218]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('162|','',$aspek_keterangan[162]); ?></textarea></td>
            </tr>
                <tr id="point164_fisik">
                  <td class="atas">164.</td>
                  <td class="atas" width="400">Tidak ada tanda  peringatan</td>   
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria,str_replace('219|','',$aspek_penilaian[219]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Serius", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('163|','',$aspek_keterangan[163]); ?></textarea></td>
            </tr>
            </table>
            <table class="form_tabel" id="tb_point_subdelapan">
                <tr>
                  <td class="atas" width="20">&nbsp;</td>
                  <td class="atas isi" width="400">Pengangkutan dan Distribusi</td>
                  <td class="atas isi"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_header, str_replace('220|','',$aspek_penilaian[220]), 'class="sel_header" title="Pilih salah satu pilihan" id ="sel_atas_pointw_subdelapan" onchange="ok_tb(\'#sel_atas_pointw_subdelapan\', \'#tb_point_subdelapan\')"'); ?></td>
                  <td class="atas">&nbsp;</td>
                </tr>
                <tr id="point165_operasional">
                  <td class="atas" width="20">165.</td>
                  <td class="atas" width="400">Kendaraan <em>(kontainer)</em> yang dipakai untuk  mengangkut produk akhir tidak mampu mempertahankan kondisi/ keawetan yang  dipersyaratkan</td>     
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('221|','',$aspek_penilaian[221]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Major", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('164|','',$aspek_keterangan[164]); ?></textarea></td>
            </tr>
                <tr id="point166_operasional">
                  <td class="atas">166.</td>
                  <td class="atas" width="400">Pembongkaran tidak  dilakukan dengan cepat, cermat dan terhindar dari pengaruh yang menyebabkan  kemunduran mutu</td>      
                  <td class="atas" width="90"><?php echo form_dropdown('PEMERIKSAAN_PANGAN[ASPEK_PENILAIAN][]', $cb_kriteria, str_replace('222|','',$aspek_penilaian[222]), 'class="sel_penyimpangan" title="Pilih salah satu piilhan : Major, Minor, Serius, Kritis, OK, Tidak Diberlakukan" rel="required"', $diss = array("Minor", "Kritis")); ?></td>
                  <td class="atas" width="300"><textarea name="PEMERIKSAAN_PANGAN[ASPEK_KETERANGAN][]" title="Aspek Keterangan" class="stext small"><?php echo str_replace('165|','',$aspek_keterangan[165]); ?></textarea></td>
            </tr>
                </table>
                </div>
        </div><!-- Akhir Pengecekan!-->
        </div>

		<div id="aspek_rating" <?php if($sess['STATUS_SARANA']=="0") echo 'style="display:none;"'; else 'style=""';?>>
        <div style="height:5px;"></div>   
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">HASIL</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Hasil dan Penilaian</h2>  
                <table class="form_tabel">
                <tr><td class="td_left">1. Penyimpangan (<i>Deficiency</i>)</td><td class="td_right">&nbsp;</td></tr>
                <tr><td class="td_left" style="margin-left:10px;">a. Penyimpangan Minor</td><td class="td_right"><span id="jumlahminor"><?php echo $sess['JUMLAH_MINOR']; ?></span>&nbsp;Penyimpangan&nbsp;<input type="hidden" name="PEMERIKSAAN_PANGAN[JUMLAH_MINOR]" id="jminor" value="<?php echo $sess['JUMLAH_MINOR']; ?>"></td></tr>
                <tr><td class="td_left" style="margin-left:10px;">b. Penyimpangan Mayor</td><td class="td_right"><span id="jumlahmajor"><?php echo $sess['JUMLAH_MAJOR']; ?></span>&nbsp;Penyimpangan&nbsp;<input type="hidden" name="PEMERIKSAAN_PANGAN[JUMLAH_MAJOR]" id="jmajor" value="<?php echo $sess['JUMLAH_MAJOR']; ?>"></td></tr>
                <tr><td class="td_left" style="margin-left:10px;">c. Penyimpangan Serius</td><td class="td_right"><span id="jumlahserius"><?php echo $sess['JUMLAH_SERIUS']; ?></span>&nbsp;Penyimpangan&nbsp;<input type="hidden" name="PEMERIKSAAN_PANGAN[JUMLAH_SERIUS]" id="jserius" value="<?php echo $sess['JUMLAH_SERIUS']; ?>"></td></tr>
                <tr><td class="td_left" style="margin-left:10px;">d. Penyimpangan Kritis</td><td class="td_right"><span id="jumlahkritis"><?php echo $sess['JUMLAH_KRITIS']; ?></span>&nbsp;Penyimpangan&nbsp;<input type="hidden" name="PEMERIKSAAN_PANGAN[JUMLAH_KRITIS]" id="jkritis" value="<?php echo $sess['JUMLAH_KRITIS']; ?>"></td></tr>
                <tr><td class="td_left">2. Tingkat Rating Unit Pengolahan</td><td class="td_right"><span id="rating"><?php echo $sess['HASIL']; ?></span><input type="hidden" name="PEMERIKSAAN[HASIL]" id="F01JJ_rating" value="<?php echo $sess['HASIL']; ?>" /></td></tr>
                </table>
                </div>
        </div><!-- Akhir Hasail dan Penilaian !-->
        </div>

        <div style="height:5px;"></div>   

        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN</a></div>
        <div class="collapse">
                <div class="accCntnt">
                <h2 class="small garis">Temuan dan Penyimpangan</h2>
                <table class="form_tabel">
                    <tr><td class="td_left">1. Penyimpangan Administratif</td><td class="td_right"><textarea class="stext chk" title="Penyimpangan administratif" name="PEMERIKSAAN_PANGAN[ADMINISTRATIF]" id="F01JJ_penyimpangan_administratif"><?php echo $sess['ADMINISTRATIF']; ?></textarea></td></tr>
                    <tr>
                      <td class="td_left">Perbaikan CAPA</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[ADMINISTRATIF_PERBAIKAN]" title="Perbaikan CAPA Administratif"><?php echo $sess['ADMINISTRATIF_PERBAIKAN']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td class="td_left">Timeline</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[ADMINISTRATIF_TIMELINE]" title="Timeline Administratif"><?php echo $sess['ADMINISTRATIF_TIMELINE']; ?></textarea></td>
                    </tr>
                    <tr><td class="td_left">2. Penyimpangan Fisik</td><td class="td_right"><ul id="temuan_fisik"><?php echo $sess['FISIK']; ?></ul></td></tr>
                    <tr>
                      <td class="td_left">Perbaikan CAPA</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[FISIK_PERBAIKAN]" id="CAPA_FISIK" title="Perbaikan CAPA Fisik"><?php echo $sess['FISIK_PERBAIKAN']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td class="td_left">Timeline</td>
                      <td class="td_right" id="tl_fisik">
                      <?php 
					  if(trim($sess['FISIK_TIMELINE']) != ""){
						  $arr_fsk = explode(";",$sess['FISIK_TIMELINE']);
						  unset($arr_fsk[count($arr_fsk)-1]);
						  foreach($arr_fsk as $val_fsk){
							  $data_fsk = explode('|', $val_fsk);
							  echo '<p id="'.$data_fsk[0].'">Timeline Point '.$data_fsk[0].' : <input type="text" name="FISIK_TIMELINE['.$data_fsk[0].']" class="stext" title="Timeline" value="'.$data_fsk[1].'"></p>';
						  }
					  }
					  ?></td>
                    </tr>
                    <tr><td class="td_left">3. Penyimpangan Operasional</td><td class="td_right"><ul id="temuan_operasional"><?php echo $sess['OPERASIONAL']; ?></ul></td></tr>
                    <tr>
                      <td class="td_left">Perbaikan CAPA</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[OPERASIONAL_PERBAIKAN]" title="Perbaikan CAPA Operasional" id="CAPA_OPERASIONAL"><?php echo $sess['OPERASIONAL_PERBAIKAN']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td class="td_left">Timeline</td>
                      <td class="td_right" id="tl_operasional">
					  <?php 
					  if(trim($sess['OPERASIONAL_TIMELINE']) != ""){
						  $arr_op = explode(";",$sess['OPERASIONAL_TIMELINE']);
						  unset($arr_op[count($arr_op)-1]);
						  foreach($arr_op as $val_op){
							  $data_op = explode('|', $val_op);
							  echo '<p id="'.$data_op[0].'">Timeline Point '.$data_op[0].' : <input type="text" name="OPERASIONAL_TIMELINE['.$data_op[0].']" class="stext" title="Timeline" value="'.$data_op[1].'"></p>';
						  }
					  }
					  ?></td>
                    </tr>
                    <tr><td class="td_left">4. Penyimpangan Lain - Lain</td><td class="td_right"><textarea class="stext chk" title="Penyimpangan lain-lain" name="PEMERIKSAAN_PANGAN[LAINLAIN]" id="F01JJ_penyimpangan_lain"><?php echo $sess['LAINLAIN']; ?></textarea></td></tr>
                    <tr>
                      <td class="td_left">Perbaikan CAPA</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[LAINLAIN_PERBAIKAN]" title="Perbaikan CAPA Lain-lain"><?php echo $sess['LAINLAIN_PERBAIKAN']; ?></textarea></td>
                    </tr>
                    <tr>
                      <td class="td_left">Timeline</td>
                      <td class="td_right"><textarea class="stext chk" name="PEMERIKSAAN_PANGAN[LAINLAIN_TIMELINE]" title="Timeline Lain-lain"><?php echo $sess['LAINLAIN_TIMELINE']; ?></textarea></td>
                    </tr>
                </table>
                </div>
        </div><!-- Akhir Temuan !-->
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
<div><a href="#" class="button save" onclick="fpost('#f01jj_','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button back" url="<?php echo $urlback; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
<div id="clear_fix"></div>
    <input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
    <input type="hidden" name="SARANA_ID" value="<?php echo array_key_exists('SARANA_ID', $sess)?$sess['SARANA_ID']:$sarana_id;?>" />
    <input type="hidden" name="JENIS_SARANA_ID" value="<?php echo array_key_exists('JENIS_SARANA_ID', $sess)?$sess['JENIS_SARANA_ID']:$jenis_sarana_id;?>" />
    <input type="hidden" name="KK_ID" value="<?php echo array_key_exists('KK_ID', $sess)?$sess['KK_ID']:$klasifikasi;?>" />
</form>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#detail_petugas").html("Loading ...");
	$("#detail_petugas").load($("#detail_petugas").attr("url"));
	$("#data_umum").html("Loading ...");
	$("#data_umum").load($("#data_umum").attr("url"));
	$("#stts_sarana").change(function(){
		var stts = $(this).val();
		if(stts == "0" || stts == "2" || stts == "3"){
			$("#aspek_penilaian, #aspek_rating").hide();
			$("#jumlahminor, #jumlahmajor, #jumlahkritis, #jumlahserius, #rating, ul#temuan_fisik, ul#temuan_operasional, td#tl_fisik, td#tl_operasional, #F01JJ_rating").html('');
			$('#aspek_penilaian select.sel_penyimpangan').val('Pilih');
			$('#aspek_penilaian select.sel_header').val('Lanjut');
			$("#jmajor, #jminor, #jserius, #jkritis").val('');
		}else{
			$("#aspek_penilaian, #aspek_rating").show();
		}		
		return false;
	});
	$("select.sel_penyimpangan").change(function(){
		  var row, jenis, aspekcpmb, pointcpmb, id_fsk, id_op, tl_fsk, tl_op;
		  row = $(this).closest("table tr").attr("id");		
		  jenis = row.split("_");
		  pointcpmb = $("#"+row+" td:nth-child(1)").text();
		  aspekcpmb = $("#"+row+" td:nth-child(2)").text();
		  tl = pointcpmb.replace(".","");
		  if($(this).val() != "OK" && $(this).val() != "Tidak Berlaku" && $(this).val() != "Lanjut"){			
			  if(jenis[1] == "fisik"){
				  id_fsk = $("ul#temuan_fisik li#"+row).attr("id");
				  tl_fsk = $("td#tl_fisik p#"+tl).attr("id");
				  var isi_fisik = '<input type="hidden" name="FISIK[]" value="<li id=\''+row+'\'>'+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val()+'</li>">';
				  if(id_fsk != row && tl_fsk != tl){ 
					  $("ul#temuan_fisik").append('<li id="'+row+'">'+isi_fisik+' '+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val()+'</li>');
					  $("td#tl_fisik").append('<p id="'+tl+'">Timeline Point '+pointcpmb+' <input type="text" name="FISIK_TIMELINE['+tl+']" class="stext" title="Timeline"></p>');  
				  }else{
					  $("ul#temuan_fisik li#"+row).html(isi_fisik+' '+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val());
					  $("td#tl_fisik p#"+tl).html('Timeline Point '+pointcpmb+' <input type="text" name="FISIK_TIMELINE['+tl+']" class="stext" title="Timeline">');
				  }
			  }else if(jenis[1] == "operasional"){
				  id_op =  $("ul#temuan_operasional li#"+row).attr("id");
				  tl_op = $("td#tl_operasional p#"+pointcpmb).attr("id");
				  var isi_operasional = '<input type="hidden" name="OPERASIONAL[]" value="<li id=\''+row+'\'>'+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val()+'</li>">';
				  if(id_op != row && tl_op != pointcpmb){
					  $("ul#temuan_operasional").append('<li id="'+row+'">'+isi_operasional+' '+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val()+'</li>');
					  $("td#tl_operasional").append('<p id="'+tl+'">Timeline Point '+pointcpmb+' : <input type="text" name="OPERASIONAL_TIMELINE['+tl+']" class="stext" title="Timeline"></p>'); 
				  }else{
					  $("ul#temuan_operasional li#"+row).html(isi_operasional+' '+pointcpmb+' '+aspekcpmb+' - Kriteria : '+$(this).val());
					  $("td#tl_operasional p#"+tl).html('Timeline Point '+pointcpmb+' : <input type="text" name="OPERASIONAL_TIMELINE['+tl+']" class="stext" title="Timeline">');
				  }
			  }
		  }else{
			  if(jenis[1] == "fisik")$("ul#temuan_fisik li#"+row).remove();
			  if(jenis[1] == "operasional") $("ul#temuan_operasional li#"+row).remove();
			  $("p#"+tl).remove();
		  }
		  var minor = $("select.sel_penyimpangan option:selected[value='Minor']").length; 
		  var major = $("select.sel_penyimpangan option:selected[value='Major']").length; 
		  var kritis = $("select.sel_penyimpangan option:selected[value='Kritis']").length; 
		  var serius = $("select.sel_penyimpangan option:selected[value='Serius']").length;
		  if(kritis >= 1){
				$("#rating").html("<b>D</b> Jelek"); $("#F01JJ_rating").val('D');
		  }else if(serius >= 5){
				$("#rating").html("<b>D</b> Jelek"); $("#F01JJ_rating").val('D');
		  }else if(serius >= 3 || serius == 4){
				$("#rating").html("<b>C</b> Kurang"); $("#F01JJ_rating").val('C');
		  }else if(kritis == 0 && serius == 0 && major >= 11){
			  $("#rating").html("<b>B</b> Baik"); $("#F01JJ_rating").val('B');
		  }else{
			  if(serius >=1 && serius <= 2){
				  $("#rating").html("<b>B</b> Baik"); $("#F01JJ_rating").val('B');
			  }else if(minor >= 7){
				  $("#rating").html("<b>B</b> Baik"); $("#F01JJ_rating").val('B');
			  }else if(major <= 5){
				  $("#rating").html("<b>A</b> Baik Sekali"); $("#F01JJ_rating").val('A');
			  }else if(major >= 6 && major == 10){
				  $("#rating").html("<b>B</b> Baik"); $("#F01JJ_rating").val('B');
			  }else if(minor <= 6){
				  $("#rating").html("<b>A</b> Baik Sekali"); $("#F01JJ_rating").val('A');
			  }
		  }
		  $("#jumlahminor").html('<b> '+parseInt(minor)+'</b>'); $("#jumlahmajor").html('<b> '+parseInt(major)+'</b>'); $("#jumlahkritis").html('<b> '+parseInt(kritis)+'</b>'); $("#jumlahserius").html('<b> '+parseInt(serius)+'</b>'); $("#jminor").val(parseInt(minor)); $("#jmajor").val(parseInt(major)); $("#jkritis").val(parseInt(kritis)); $("#jserius").val(parseInt(serius));
	});
	
	<?php if($PERIKSA_ID != ""){ ?>
	$("ul#temuan_operasional li").each(function(){
		var ipt_operasional = '<input type="hidden" name="OPERASIONAL[]" value="<li id=\''+$(this).attr("id")+'\'>'+$(this).html()+'</li>">';
		$(this).append(ipt_operasional);
    });
	$("ul#temuan_fisik li").each(function(){
		var ipt_fisik = '<input type="hidden" name="FISIK[]" value="<li id=\''+$(this).attr("id")+'\'>'+$(this).html()+'</li>">';
		$(this).append(ipt_fisik);
        
    });
	<?php } ?>
	
});
</script>