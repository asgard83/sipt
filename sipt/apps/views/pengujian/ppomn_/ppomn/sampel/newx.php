<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

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
                <td class="td_left">Asal Sampel</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[ASAL_SAMPEL]',$asal,$sess['ASAL_SAMPEL'],'class="stext" title="Asal Sampel" id="asal_sampling" rel="required"'); ?></td>
                <td>&nbsp;</td>
                <td class="td_left">Anggaran Sampling</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[ANGGARAN]',$anggaran,$sess['ANGGARAN'],'class="stext" rel="required" title="Anggaran Sampling" id="anggaran_sampling"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Nomor Surat Pengantar</td>
                <td class="td_right"><input type="text" class="stext" title="Nomor Surat Pengantar" name="SURAT[NOMOR_SURAT]" value="<?php echo $sess['NOMOR_SURAT']; ?>" rel="required" id="nomor_surat" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_surat/1" />
                  <input type="hidden" name="surat_id" id="surat_id" value="<?php echo $sess['PERIKSA_SAMPEL']; ?>" /></td>
                <td>&nbsp;</td>
                <td class="td_left">Tempat Asal Sampel</td>
                <td class="td_right"><input type="text" class="stext" name="SAMPEL[TEMPAT_SAMPLING]" value="<?php echo $sess['TEMPAT_SAMPLING']; ?>" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Tempat asal sampel" rel="required"/></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Surat</td>
                <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Pengantar" name="SURAT[TANGGAL_SURAT]" rel="required" id="tanggal_surat" value="<?php echo $sess['TANGGAL_SURAT']; ?>" /></td>
                <td>&nbsp;</td>
                <td class="td_left">Tanggal diterima di TPS</td>
                <td class="td_right"><input type="text" class="sdate" value="<?php echo $sess['TANGGAL_SAMPLING']; ?>" title="Tanggal sampel di terima di TPS" name="SAMPEL[TANGGAL_SAMPLING]" rel="required" /></td>
              </tr>
            </table>
          </div>
        </div>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA PENGIRIM</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <div class="pihak-3-swasta-pemerintah">
              <h2 class="small garis">Data Pengirim Sampel Pihak Ke 3</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Nama Pengirim</td>
                  <td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_rutin" id="nama_pengirim" value="<?php echo $sess['NAMA_PENGIRIM']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">NIP</td>
                  <td class="td_right"><input type="text" class="stext" title="NIP" name="nip_rutin" id="nip_rutin" value="<?php echo $sess['NIP_PENGIRIM'];?>" /></td>
                </tr>
              </table>
            </div>
            <div class="pihak-3-polisi">
              <h2 class="small garis">Data Pengirim Pihak Ke 3 Kepolisian</h2>
              <table class="form_tabel" id="dt-pengirim">
                <tr>
                  <td class="td_left">Nama Pengirim</td>
                  <td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_polisi" value="<?php echo $sess['NAMA_PENGIRIM']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">NIP / NRP</td>
                  <td class="td_right"><input type="text" class="stext" title="NIP / NRP" name="nip_polisi" value="<?php echo $sess['NIP_PENGIRIM']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Pangkat</td>
                  <td class="td_right"><input type="text" class="stext" title="Pangkat" name="SURAT[PANGKAT]" value="<?php echo $sess['PANGKAT']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Alamat Kepolisian</td>
                  <td class="td_right"><input type="text" class="stext" title="Alamat Kepolisian" name="SURAT[INSTITUSI]" value="<?php echo $sess['INSTITUSI']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">No. LP</td>
                  <td class="td_right"><input type="text" class="stext" title="No. LP" name="SURAT[NO_LP]" value="<?php echo $sess['NO_LP']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Tanggal LP</td>
                  <td class="td_right"><input type="text" class="sdate" title="Tanggal LP" name="SURAT[TANGGAL_LP]" value="<?php echo $sess['TANGGAL_LP']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">No. SPDP</td>
                  <td class="td_right"><input type="text" class="stext" title="Surat Pemberitahuan Dimulainya Penyidikan" name="SURAT[NO_SPDP]" value="<?php echo $sess['NO_SPDP']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Tanggal SPDP</td>
                  <td class="td_right"><input type="text" class="sdate" title="Tanggal SPDP" name="SURAT[TANGGAL_SPDP]" value="<?php echo $sess['TANGGAL_SPDP']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Nama Tersangka</td>
                  <td class="td_right"><input type="text" class="stext" title="Nama Tersangka, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[NAMA_TERSANGKA]" value="<?php echo $sess['NAMA_TERSANGKA']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Kota</td>
                  <td class="td_right"><input type="text" class="stext" title="Kota" name="SURAT[KOTA]" value="<?php echo $sess['KOTA']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Nama Saksi</td>
                  <td class="td_right"><input type="text" class="stext" title="Saksi, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[SAKSI_POLISI]" value="<?php echo $sess['SAKSI_POLISI']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Tanggal Terima</td>
                  <td class="td_right"><input type="text" class="sdate" title="Tanggal Terima" name="SURAT[TANGGAL_TERIMA]" value="<?php echo $sess['TANGGAL_TERIMA']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Hari Terima</td>
                  <td class="td_right"><input type="text" class="stext" title="Hari Terima" name="SURAT[HARI_TERIMA]" value="<?php echo $sess['HARI_TERIMA']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Saksi Pengujian</td>
                  <td class="td_right"><input type="text" class="stext" title="Saksi Pengujian, jika lebih dari satu pisahkan dengan titik koma" name="SURAT[SAKSI_UJI]" value="<?php echo $sess['SAKSI_UJI']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Jumlah Sampel Di Surat Permintaan Uji</td>
                  <td class="td_right"><input type="text" class="stext w100" title="jumlah" name="SURAT[JUMLAH_UJI]" value="<?php echo $sess['JUMLAH_UJI']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Catatan</td>
                  <td class="td_right"><textarea class="stext" name="SURAT[CATATAN]" title="Catatan atau keterangan"><?php echo $sess['CATATAN_SURAT']; ?></textarea></td>
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
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody id="body-pnbp">
                  <?php
				 $arrpnbp = count($list_pnbp);
				 if($arrpnbp > 0){
					 for($i = 0; $i < $arrpnbp; $i++){
						 $subtotal = $list_pnbp[$i]['PNBP_JML'] * $list_pnbp[$i]['PNBP_TARIF'];
						 if($i == 0){
							 $btn = '<div id="tdopsi'.$i.'"><a href="#" class="addpnbp"><img src="'.base_url().'images/add.png" align="absmiddle" style="border:none" title="Tambah data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="#" class="editpnbp"><img src="'.base_url().'images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a></div>';
						 }else{
							  $btn = '<div id="tdopsi'.$i.'"><a href="#" class="delpnbp"><img src="'.base_url().'images/icon-delete.png" align="absmiddle" style="border:none" title="Tambah data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="#" class="editpnbp"><img src="'.base_url().'images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a></div>';
						 }
						 ?>
                  <tr id="<?php echo $i; ?>" ke="<?php echo $i; ?>">
                    <td><span id="retacpnb0"><?php echo $list_pnbp[$i]['PNBP_DESCRIPTION']; ?></span>
                      <input type="text" class="stext acpnbp" title="Jenis PNBP Pengujian" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_pnbp" id="acpnbp<?php echo $i; ?>" style="display:none;" value="<?php echo $list_pnbp[$i]['PNBP_DESCRIPTION']; ?>"/>
                      <input type="hidden" name="PNBP[PNBP_ID][]" id="pnbp<?php echo $i; ?>" value="<?php echo $list_pnbp[$i]['PNBP_ID']; ?>" /></td>
                    <td><input type="text" class="w100" value="<?php echo $list_pnbp[$i]['PNBP_UNIT']; ?>" title="Satuan pengujian" id="pnbpsatuan<?php echo $i; ?>" readonly="readonly" /></td>
                    <td><input type="text" class="scode jmltarif" title="Jumlah uji" value="<?php echo $list_pnbp[$i]['PNBP_JML']; ?>" onkeyup="numericOnly($(this))" id="jmlpnbp<?php echo $i; ?>" name="PNBP[PNBP_JML][]" /></td>
                    <td><input type="text" class="w100" title="Tarif" id="pnbptarif<?php echo $i; ?>" readonly="readonly" name="PNBP[PNBP_TARIF][]" value="<?php echo $list_pnbp[$i]['PNBP_TARIF']; ?>" /></td>
                    <td><input type="text" class="w100" title="Sub Total" id="pnbptotal<?php echo $i; ?>" readonly="readonly" value="<?php echo $subtotal; ?>" /></td>
                    <td><?php echo $btn; ?></td>
                  </tr>
                  <?php
					 }
				 }else{
				 ?>
                  <tr id="0" ke="0">
                    <td><span id="retacpnb0"></span>
                      <input type="text" class="stext acpnbp" title="Jenis PNBP Pengujian" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_pnbp" id="acpnbp0"/>
                      <input type="hidden" name="PNBP[PNBP_ID][]" id="pnbp0" /></td>
                    <td><input type="text" class="w100" title="Satuan pengujian" id="pnbpsatuan0" readonly="readonly" /></td>
                    <td><input type="text" class="scode jmltarif" title="Jumlah uji" onkeyup="numericOnly($(this))" id="jmlpnbp0" name="PNBP[PNBP_JML][]" /></td>
                    <td><input type="text" class="w100" title="Tarif" id="pnbptarif0" readonly="readonly" name="PNBP[PNBP_TARIF][]" /></td>
                    <td><input type="text" class="w100" title="Sub Total" id="pnbptotal0" readonly="readonly" /></td>
                    <td><div id="tdopsi0"><a href="#" class="addpnbp"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah data PNBP Pengujian" /></a></div></td>
                  </tr>
                  <?php
				 }
				 ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="4">Total</th>
                    <th><span id="total-pnbp"></span></th>
                    <th>&nbsp;</th>
                  </tr>
                </tfoot>
              </table>
              <!-- Akhir PNBP !-->
              <div style="height:5px;">&nbsp;</div>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Biaya</td>
                  <td class="td_right"><input type="text" class="stext w100" id="biaya" title="Biaya" name="SURAT[BIAYA]" value="<?php echo $sess['BIAYA']; ?>"  onkeyup="numericOnly($(this))" />
                    (dalam rupiah)</td>
                </tr>
                <tr>
                  <td class="td_left">No. Resi Bank</td>
                  <td class="td_right"><input type="text" class="stext" title="No. Resi Bank" name="SURAT[NO_RESI_BANK]" value="<?php echo $sess['NO_RESI_BANK']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Tanggal Resi Bank</td>
                  <td class="td_right"><input type="text" class="sdate" title="Tanggal Resi" name="SURAT[TANGGAL_RESI_BANK]" value="<?php echo $sess['TANGGAL_RESI_BANK']; ?>" /></td>
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
                <td class="td_left">Kode Sampel</td>
                <td class="td_right bold"><?php echo $sess['UR_KODE']; ?></td>
                <td></td>
                <td class="td_left">Nomor SPU</td>
                <td class="td_right bold"><?php echo $sess['FR_SPUID']; ?>
                  <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" /></td>
              </tr>
              <?php
			  }
			  ?>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php
					if($kode_sampel == ""){
						echo form_dropdown('KOMODITI[]',$komoditi,$sess['KOMODITI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); 
					}else{
						echo "<b>".$sess['KO']."</b>";
					}
					?></td>
                <td width="10"></td>
                <td class="td_left">Kategori Tambahan</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[KLASIFIKASI_TAMBAHAN]',$klasifikasi_tambahan,$sess['KLASIFIKASI_TAMBAHAN'],'class="stext" title="Komoditi" id="kk_tambahan"'); ?></td>
              </tr>
              <tr id="tdanak2" ke="2">
                <td class="td_left">Kategori sampel</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sel[0],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2" rel="required"'); ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr <?php echo strlen($sel[1]) == 6 ? '' : 'class="hideme"'; ?> id="tdanak3" ke="3">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sel[1],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr <?php echo strlen($sel[2]) == 8 ? '' : 'class="hideme"'; ?> id="tdanak4" ke="4">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sel[2],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel4" ke="4"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><input type="text" class="stext" title="Nama sampel" name="SAMPEL[NAMA_SAMPEL]" id="nama_sampel" rel="required" value="<?php echo $sess['NAMA_SAMPEL'];?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/"/>
                  <input type="hidden" id="klasifikasi" value="<?php echo $sess['KOMODITI']; ?>" /></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><input type="text" class="stext" title="Nomor Registrasi" name="SAMPEL[NOMOR_REGISTRASI]" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" id="nie" /></td>
              </tr>
              <tr>
                <td class="td_left">Pabrik</td>
                <td class="td_right"><input type="text" class="stext" title="Nama Pabrik" name="SAMPEL[PABRIK]" value="<?php echo $sess['PABRIK']; ?>" id="pabrik" /></td>
                <td width="10"></td>
                <td class="td_left">Importir</td>
                <td class="td_right"><input type="text" class="stext" name="SAMPEL[IMPORTIR]" title="Importir" id="pemilik" value="<?php echo $sess['IMPORTIR']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Bentuk Sediaan sampel</td>
                <td class="td_right"><input type="text" class="stext" title="Bentuk Sediaan Sampel / sampel" name="SAMPEL[BENTUK_SEDIAAN]" value="<?php echo $sess['BENTUK_SEDIAAN']; ?>" id="bentuk" /></td>
                <td width="10"></td>
                <td class="td_left">Kemasan sampel</td>
                <td class="td_right"><input type="text" class="stext" title=" Kemasan Sampel / sampel" name="SAMPEL[KEMASAN]" value="<?php echo $sess['KEMASAN']; ?>" id="kemasan" /></td>
              </tr>
              <tr>
                <td class="td_left">No Bets</td>
                <td class="td_right"><input type="text" name="SAMPEL[NO_BETS]" class="stext" title="Nomor Bets" value="<?php echo $sess['NO_BETS']; ?>" /></td>
                <td width="10"></td>
                <td class="td_left">Keterangan ED</td>
                <td class="td_right"><input type="text" class="sdate" title="Expire Date" name="SAMPEL[KETERANGAN_ED]" value="<?php echo $sess['KETERANGAN_ED']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Komposisi</td>
                <td class="td_right"><textarea class="stext" style="height:80px; resize:none;" name="SAMPEL[KOMPOSISI]" title="Komposisi sampel. Jika lebih dari satu, pisahkan dengan titik koma" id="komposisi"><?php echo $sess['KOMPOSISI']; ?></textarea></td>
                <td width="10"></td>
                <td class="td_left">Netto</td>
                <td class="td_right"><input type="text" class="stext w100" title="Netto" name="SAMPEL[NETTO]" value="<?php echo $sess['NETTO']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Evaluasi Penandaan</td>
                <td class="td_right"><input type="text" class="stext" title="Evaluasi Penandaan, Misal : Tidak dicantumkan nomor reg, nomor reg lama" name="SAMPEL[EVALUASI_PENANDAAN]" value="<?php echo $sess['EVALUASI_PENANDAAN']; ?>" /></td>
                <td width="10"></td>
                <td class="td_left">Cara Penyimpanan</td>
                <td class="td_right"><input type="text" class="stext" title="Sesuai dengan keterangan yang ada di label" name="SAMPEL[CARA_PENYIMPANAN]" value="<?php echo $sess['CARA_PENYIMPANAN']; ?>" /></td>
              </tr>
              <tr>
                <td class="td_left">Kondisi sampel</td>
                <td class="td_right"><?php echo form_dropdown('KONDISI_SAMPEL[]',$kondisi_sampel,$selkondisi,'multiple="multiple" style="height:110px;" class="stext" title="Kondisi sampel" rel="required"'); ?></td>
                <td width="10"></td>
                <td class="td_left">Jumlah sampel</td>
                <td class="td_right"><input type="text" class="scode" id="jumlah" title="Jumlah sampel" rel="required" value="<?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>" name="SAMPEL[JUMLAH_SAMPEL]"/>
                  &nbsp;&nbsp;<?php echo form_dropdown('SAMPEL[SATUAN]',$satuan,$sess['SATUAN'],'class="stext sjenis" title="Satuan" rel="required"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Segel sampel</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[SEGEL]',$segel,$sess['SEGEL'],'class="stext" title="Pilih salah satu, segel sampel" rel="required"'); ?></td>
                <td></td>
                <td class="td_left">Label Sampel</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[LABEL]',$label_sampel,$sess['LABEL'],'class="stext" title="Pilih salah satu, label sampel" rel="required"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Pengujian</td>
                <td class="td_right"><div style="padding-bottom:5px;">
                    <input type="checkbox" name="lab[]" class="chklab" id="kimia" onchange="check_uji('#kimia', '#jml_kimia');" value="K" <?php echo $sess['UJI_KIMIA'] > 0 ? 'checked="checked"' : ''; ?> />
                    &nbsp;Kimia&nbsp;
                    <input type="text" class="scode jml" title="Pengujian Kimia" id="jml_kimia" value="<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?>" name="SAMPEL[JUMLAH_KIMIA]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> />
                  </div>
                  <div style="padding-bottom:5px;">
                    <input type="checkbox" class="chklab" name="lab[]" id="mikro" onchange="check_uji('#mikro', '#jml_mikro');" value="M" <?php echo $sess['UJI_MIKRO'] > 0 ? 'checked="checked"' : ''; ?>/>
                    &nbsp;Mikro&nbsp;
                    <input type="text" class="scode jml" title="Pengujian Mikro" name="SAMPEL[JUMLAH_MIKRO]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?> id="jml_mikro" value="<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?>" onkeyup="numericOnly($(this))" />
                  </div>
                  <div>Retain&nbsp;
                    <input type="text" class="scode" id="sisa" title="Sisa (retain) sampel " name="SAMPEL[SISA]" readonly="readonly" value="<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?>" onkeyup="numericOnly($(this))" />
                  </div></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><textarea class="stext" title="Catatan" name="SAMPEL[CATATAN]"><?php echo $sess['CATATAN SAMPEL']; ?></textarea></td>
                <td width="10"></td>
                <td class="td_left">Lampiran File</td>
                <td class="td_right"><?php
                      if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){
                          ?>
                  <span class="upload_LAMPIRAN" style="display:none;">
                  <input type="file" class="stext upload" jenis="LAMPIRAN" allowed="jpg-jpeg-bmp-gif" url="<?php echo site_url(); ?>/utility/uploads/set_photosampel/" id="fileToUpload_LAMPIRAN" name="userfile" onchange="do_upload($(this)); return false;" title="Photos sampel" />
                  <div>Tipe File : *.jpg, *.jpeg, *.bmp, *.gif</div>
                  </span><span class="file_LAMPIRAN"><a href="<?php echo base_url(); ?>files/sampel/<?php echo md5(trim($sess['BBPOM_ID'])); ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">Preview Photo</a>&nbsp;&bull;&nbsp;<a href="#" class="del_upload" url="<?php echo site_url(); ?>/utility/uploads/del_upload/<?php echo md5(trim($sess['BBPOM_ID'])); ?>/<?php echo $sess['LAMPIRAN']; ?>">Edit atau Hapus File ?</a></span>
                  <?php
                      }else{
						  ?>
                  <span class="upload_LAMPIRAN">
                  <input type="file" class="stext upload" jenis="LAMPIRAN" allowed="jpg-jpeg-bmp-gif" url="<?php echo site_url(); ?>/utility/uploads/set_photosampel" id="fileToUpload_LAMPIRAN" title="Photo sampel" name="userfile" onchange="do_upload($(this)); return false;"/>
                  &nbsp;
                  <div>Tipe File : *.jpg, *.jpeg, *.bmp, *.gif</div>
                  </span><span class="file_LAMPIRAN"></span>
                  <?php 
                      }
                      ?></td>
              </tr>
            </table>
            <!-- Akhir PNBP !--> 
          </div>
        </div>
        <?php
			if($kode_sampel!=""){
			?>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LOG SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_sampel/<?php echo $kode_sampel; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Sampel (
              <?= $jml_log; ?>
              )</a></h2>
            <div id="detail_log"></div>
          </div>
        </div>
        <?php
			}
			?>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fnewsampel','',''); return false;"><span><span class="icon"></span>&nbsp; <?php echo $caption; ?> &nbsp;</span></a>&nbsp;<a href="#" class="button reload" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var totalpnbp = 0;
	var tmptotal = 0;
	$("#total-pnbp").html(parseInt(totalpnbp));
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
	});
	
	<?php
	if($kode_sampel!=""){
		if($sess['ANGGARAN'] == '06' || $sess['ANGGARAN'] == "07"){
		?>
		$(".pihak-3-polisi").css("display","none");
		$(".pihak-3-swasta-pemerintah").css("display","");
		<?php
		}else{
		?>
		$(".pihak-3-polisi").css("display","");
		$(".pihak-3-swasta-pemerintah").css("display","none");
		<?php
		}
	}else{
	?>
		$(".pihak-3-polisi").css("display","none");
	<?php
	}
	?>
	
	$('select.komoditi').change(function(){
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		if(ke == 1){
			$("#nama_sampel").autocomplete($("#nama_sampel").attr('url') + kunci, {width: 244, selectFirst: false});
			$("#nama_sampel").result(function(event, data, formatted){
				if(data){
					$(this).val(data[1]);
					$("#nie").val(data[2]);
					$("#kemasan").val(data[4]);
					$("#pemilik").val(data[7]);
					$("#pabrik").val(data[6]);
					$("#bentuk").val(data[9]);
					$.get('<?php echo site_url().'/autocompletes/autocomplete/get_komposisi/'; ?>' + data[10].replace(' ','-') + '/' + data[11], function(hasil){
						$('#komposisi').val(hasil);
					});
					
				}
			});
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
				$('#sel' + ke).removeAttr("rel");
			}else{
				$('#tdanak' + ke).show();
				$('#sel' + ke).html(hasil);
				$('#sel' + ke).attr("rel","required");
			}
		});
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
	$(".del_upload").live("click", function(){
		$.ajax({
			type: "GET",
			url: $(this).attr("url"),
			data: $(this).serialize(),
			success: function(data){
				$(".upload_LAMPIRAN").show();
				$("#fileToUpload_LAMPIRAN").val('');
				$(".file_LAMPIRAN").html("");
			}
		});
		return false;
	});	
	$("#acpnbp0").autocomplete($("#acpnbp0").attr('url'), {width: 244, selectFirst: false});
	$("#acpnbp0").result(function(event, data, formatted){
		if(data){
			$("#acpnbp0").hide();
			$("#pnbp0").val(data[1]);
			$("#retacpnb0").html(data[2]);
			$("#pnbptarif0").val(data[3]);
			$("#pnbpsatuan0").val(data[4]);
			$("#jmlpnbp0").focus();
			$("#tdopsi0").html('<a href="#" class="addpnbp"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="#" class="editpnbp"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a>');
		}
	})
	$(".jmltarif").change(function(){
		var ke = $(this).closest("tr").attr("id");
		var total = parseInt($("#jmlpnbp"+ke).val()) * parseInt($("#pnbptarif"+ke).val());
		totalpnbp = tmptotal + total;
		$("#pnbptotal"+ke).val(parseInt(total));
		$("#total-pnbp").html(parseInt(totalpnbp));
		$("#biaya").val(parseInt(totalpnbp));
	});
	$(".addpnbp").live("click", function(){
		var ke = $("#list-pnbp #body-pnbp tr").length; 
		$("#list-pnbp #body-pnbp").append('<tr id="'+(ke+1)+'" ke="'+(ke+1)+'"><td><span id="retacpnb'+(ke+1)+'"></span><input type="text" class="stext acpnbp" title="Jenis PNBP Pengujian" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_pnbp" id="acpnbp'+(ke+1)+'"/><input type="hidden" name="PNBP[PNBP_ID][]" id="pnbp'+(ke+1)+'"" /></td><td><input type="text" class="w100" title="Satuan pengujian" id="pnbpsatuan'+(ke+1)+'" readonly="readonly" /></td><td><input type="text" class="scode jmltarif" title="Jumlah uji" onkeyup="numericOnly($(this))" id="jmlpnbp'+(ke+1)+'" name="PNBP[PNBP_JML][]" /></td><td><input type="text" class="w100" title="Tarif" id="pnbptarif'+(ke+1)+'" readonly="readonly" name="PNBP[PNBP_TARIF][]" /></td><td><input type="text" class="w100" title="Sub Total" id="pnbptotal'+(ke+1)+'" readonly="readonly" /></td><td><div id="tdopsi'+(ke+1)+'"><a href="#" class="delpnbp"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data PNBP Pengujian" /></a></div></td></tr>');
		$("#acpnbp"+(ke+1)).autocomplete($("#acpnbp"+(ke+1)).attr('url'), {width: 244, selectFirst: false});
		$("#acpnbp"+(ke+1)).result(function(event, data, formatted){
			if(data){
				$("#acpnbp"+(ke+1)).hide();
				$("#pnbp"+(ke+1)).val(data[1]);
				$("#retacpnb"+(ke+1)).html(data[2]);
				$("#pnbptarif"+(ke+1)).val(data[3]);
				$("#pnbpsatuan"+(ke+1)).val(data[4]);
				$("#jmlpnbp"+(ke+1)).focus();
				$("#tdopsi"+(ke+1)).html('<a href="#" class="delpnbp"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="#" class="editpnbp"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a>');
			}
		});
		$(".jmltarif").change(function(){
			var ke = $(this).closest("tr").attr("id");
			var total = parseInt($("#jmlpnbp"+ke).val()) * parseInt($("#pnbptarif"+ke).val());
			var tmp = parseInt($("#total-pnbp").html());
			var tmps = tmp + total;
			$("#pnbptotal"+ke).val(parseInt(total));
			$("#total-pnbp").html(parseInt(tmps));
			$("#biaya").val(parseInt(tmps));
		});
		return false;
	});
	$(".delpnbp").live("click", function(){
		var ke = $(this).closest("tr").attr("id");
		var tmp = parseInt($("#total-pnbp").html());
		var del = parseInt($("#pnbptotal"+ke).val());
		var tmps = tmp - del;
		$("#total-pnbp").html(parseInt(tmps));
		$("#biaya").val(parseInt(tmps));
		$("#"+ke).remove();
		return false;
	});
	$(".editpnbp").live("click",function(){
		var ke = $(this).closest("tr").attr("id");
		var htmls = $("#retacpnb"+ke).html();
		$("#acpnbp"+ke).show();
		$("#acpnbp"+ke).val(htmls);
		$("#retacpnb"+ke).html('');
		return false;
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
					$(".upload_"+arrdata[3]+"").hide();
					$(".file_"+arrdata[3]+"").html("<b>1 File telah dilampirkan. </b>&nbsp;<a href=\"<?php echo base_url(); ?>files/sampel/"+arrdata[2]+"/"+arrdata[0]+"\" target=\"_blank\">Tampilkan File</a>&nbsp;&bull;&nbsp;<a href=\"#\" class=\"del_upload\" url=\"<?php echo site_url(); ?>/utility/uploads/del_upload/"+arrdata[2]+"/"+arrdata[0]+"\" jns="+arrdata[2]+">Edit atau Hapus File ?</a><input type=\"hidden\" name=\"SAMPEL[LAMPIRAN]\" value="+arrdata[0]+">");
				}
			}
		},
		error: function (data, status, e){
			jAlert(e, "SIPT Versi 1.0");
		}
	});
}
</script> 