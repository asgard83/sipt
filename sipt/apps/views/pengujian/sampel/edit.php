<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); 
$arrexternal = array('10','11','12');
?>

<div id="judulmsampel" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fnewsampel" id="fnewsampel" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <?php
	if($external){
		?>
    <input type="hidden" name="external" value="<?php echo $external; ?>" />
    <?php
	}
	?>
    <input type="hidden" name="periksa_sampel" value="<?php echo $periksa_sampel; ?>" />
    <input type="hidden" name="kode_sampel" value="<?php echo $kode_sampel; ?>" />
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI PEMERIKSAAN SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Data Pemeriksaan Sampel</h2>
            <?php 
			if(in_array($sess['ASAL_SAMPEL'], $arrexternal)){#Pihak Ketiga
			?>
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
            <?php	
			}else{#Rutin
				?>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Nomor Surat Tugas </td>
                <td class="td_right"><input type="text" class="stext" title="Nomor Surat Tugas" name="SURAT[NOMOR_SURAT]" value="<?php echo $sess['NOMOR_SURAT']; ?>" rel="required" id="nomor_surat" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_surat/0" />
                  <input type="hidden" name="surat_id" id="surat_id" value="<?php echo $sess['PERIKSA_SAMPEL']; ?>" /></td>
                <td width="10"></td>
                <td class="td_left">Asal Sampel </td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[ASAL_SAMPEL]',$asal,$sess['ASAL_SAMPEL'],'class="stext" title="Asal Sampel" id="asal_sampling" rel="required"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Tanggal Surat Tugas </td>
                <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Tugas" name="SURAT[TANGGAL_SURAT]" rel="required" id="tanggal_surat" value="<?php echo $sess['TANGGAL_SURAT']; ?>" /></td>
                <td></td>
                <td class="td_left">Prioritas Sampling</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[PRIORITAS]',$prioritas,$sess['PRIORITAS'],'class="stext prioritas" title="Data prioritas sampling" rel="required" id="cbprioritas" data-url = "'.site_url().'/autocompletes/autocomplete/set_prioritas/"'); ?><div>Pilih salah satu opsi dari pilihan Prioritas Sampling diatas untuk menentukan kategori pada informasi data sampel.</div></td>
              </tr>
              <tr>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
                <td></td>
                <td class="td_left">Komoditi</td>
                <td class="td_right"><?php
						  if($kode_sampel == ""){
							  echo form_dropdown('KOMODITI[]',$komoditi,$sess['KOMODITI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); 
						  }else{
							  echo "<b>".$sess['KO']."<input type=\"hidden\" id=\"sel1\" ke=\"1\" value=\"".$sess['KOMODITI']."\"></b>";
						  }
						  ?></td>
              </tr>
              <tr>
                <td class="td_left">Anggaran Sampling</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[ANGGARAN]',$anggaran,$sess['ANGGARAN'],'class="stext" rel="required" title="Anggaran Sampling" id="anggaran_sampling"'); ?></td>
                <td></td>
                <td class="td_left">Tujuan Sampling </td>
                <td class="td_right"><div style="padding-bottom:5px;"> <?php echo form_dropdown('SAMPEL[TUJUAN_SAMPLING]',$tujuan,$sess['TUJUAN_SAMPLING'],'class="stext" title="Tujuan Sampling" rel="required" id="tujuan_sampling" url="'.site_url().'/autocompletes/autocomplete/get_tujuan_sampling/"'); ?> </div>
                  <div <?= (array_key_exists('SUB_TUJUAN', $sess)) && ($sess['SUB_TUJUAN'] != "") ? '' : 'style="display:none;"'; ?> id="div_tujuan"> <?php echo form_dropdown('SAMPEL[SUB_TUJUAN]',$sub_tujuan,$sess['SUB_TUJUAN'],'class="stext" title="Tujuan Sampling" id="sub_tujuan"'); ?> </div></td>
              </tr>
              <tr>
                <td class="td_left">Bulan Anggaran Sampling </td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[BULAN_ANGGARAN]',$bulan, $sess['BULAN_ANGGARAN'],'class="stext" rel="required" title="Bulan Anggaran" id="bulan"'); ?></td>
                <td></td>
                <td class="td_left">Tanggal Sampling </td>
                <td class="td_right"><input type="text" class="sdate" title="Tanggal Sampling" name="SAMPEL[TANGGAL_SAMPLING]" rel="required" value="<?php echo $sess['TANGGAL_SAMPLING']; ?>" id="tanggal_sampling" /></td>
              </tr>
              <tr>
                <td class="td_left">Petugas Sampling</td>
                <td class="td_right"><input type="text" class="stext operator" id="operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" title="Ketikan nama petugas, lalu tekan enter untuk menambahkan nama petugas." />
                  <ul style="list-style:none; margin:0px; padding:0px;" id="petugas">
                  </ul></td>
                <td></td>
                <td class="td_left">Tempat Sampling </td>
                <td class="td_right"><input type="text" class="stext" name="SAMPEL[TEMPAT_SAMPLING]" value="<?php echo $sess['TEMPAT_SAMPLING']; ?>" id="saranaid_" url="<?php echo site_url(); ?>/autocompletes/autocomplete/sarana" title="Pilih salah satu Nama Sarana" rel="required"/>
                  <input type="hidden" id="saranaidval_" name="SAMPEL[SARANA_ID]" value="<?php echo $sess['SARANA_ID']; ?>"/></td>
              </tr>
              <tr id="tr_petugas">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php 
						  if($kode_sampel != ""){
						  	?>
                  <ul style="list-style:none; margin:0px; padding:0px;" id="urut0">
                    <?php
								$jmlpetugas = count($user_id);
								for($i=0;$i<$jmlpetugas;$i++){
									?>
                    <li style="padding-bottom:5px;" id="<?php echo $user_id[$i]; ?>">
                      <input type="text" class="stext" value="<?php echo $nama_user[$i]; ?>" title="Nama Petugas" readonly>
                      &nbsp;&nbsp;<a href="javasript:void(0);"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$('ul#urut0 li#<?php echo $user_id[$i]; ?>').remove();" /></a>
                      <input type="hidden" name="USER_ID[]" value="<?php echo $user_id[$i]; ?>">
                    </li>
                    <?php
								}
								?>
                  </ul>
                  <?php
						  }else{
						  	?>
                  <ul style="list-style:none; margin:0px; padding:0px;" id="urut0">
                  </ul>
                  <?php
						  }
						  ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right"></td>
              </tr>
            </table>
            <?php
			}
			?>
          </div>
        </div>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA PENGIRIM</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <div class="rutin" <?= !in_array($sess['ASAL_SAMPEL'], $arrexternal) ? '' : 'style="display:none"'; ?>>
              <h2 class="small garis">Data Pengirim Sampel</h2>
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Nama Pengirim</td>
                  <td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_rutin" id="nama_pengirim" value="<?php echo $sess['NAMA_PENGIRIM']; ?>"  url="<?php echo site_url(); ?>/autocompletes/autocomplete/operator/" /></td>
                  <td width="10"></td>
                  <td class="td_left">NIP</td>
                  <td class="td_right"><input type="text" class="stext" title="NIP" name="nip_rutin" id="nip_rutin" value="<?php echo $sess['NIP_PENGIRIM'];?>" /></td>
                </tr>
              </table>
            </div>
            <div class="pihak-3-swasta-pemerintah" <?= ($sess['ASAL_SAMPEL'] == '10' || $sess['ASAL_SAMPEL'] == '12')? '' : 'style="display:none;"'; ?>>
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
            <div class="pihak-3-polisi" <?= $sess['ASAL_SAMPEL'] == '11' ? '' : 'style="display:none;"'; ?>>
              <h2 class="small garis">Data Pengirim Pihak Ke 3 Kepolisian</h2>
              <table class="form_tabel" id="dt-pengirim">
                <tr>
                  <td class="td_left">Nama Pengirim</td>
                  <td class="td_right"><input type="text" class="stext" title="Nama Pengirim Sampel" name="pengirim_polisi" value="<?php echo $sess['NAMA_PENGIRIM']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">NIP / NRP</td>
                  <td class="td_right"><input type="text" class="stext" title="NIP / NRP" name="nip_polisi" value="<?php echo $sess['NIP_POLISI']; ?>" /></td>
                </tr>
                <tr>
                  <td class="td_left">Pangkat</td>
                  <td class="td_right"><input type="text" class="stext" title="Pangkat" name="SURAT[PANGKAT]" value="<?php $sess['PANGKAT']; ?>" /></td>
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
            <?php 
			if(in_array($sess['ASAL_SAMPEL'], $arrexternal)){#Pihak Ketiga
			?>
            <div class="biaya-pihak-ke-3">
              <h2 class="small garis">Penerimaan Negara Bukan Pajak (Pengujian)</h2>
              <!-- PNBP !-->
              <table class="listtemuan" width="100%" id="pnbp-input">
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
                <tbody id="body-pnbp-input">
                  <tr>
                    <td><input type="text" class="stext acpnbp" title="Jenis PNBP Pengujian" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_pnbp" id="acpnbp0"/>
                      <input type="hidden" name="PNBP[PNBP_ID][]" id="pnbp0" value="" />
                      <input type="hidden" id="chk-input" edit="FALSE" target="" /></td>
                    <td><input type="text" class="w100" title="Satuan pengujian" id="pnbpsatuan0" readonly="readonly" /></td>
                    <td><input type="text" class="scode jmltarif" title="Jumlah uji" onkeyup="numericOnly($(this))" id="jmlpnbp0" name="PNBP[PNBP_JML][]" /></td>
                    <td><input type="text" class="w100" title="Tarif" id="pnbptarif0" readonly="readonly" name="PNBP[PNBP_TARIF][]" /></td>
                    <td><input type="text" class="w100" title="Sub Total" id="pnbptotal0" readonly="readonly" /></td>
                    <td><div id="tdopsi0"><a href="#" class="addpnbp"><img src="<?php echo base_url(); ?>images/add.png" align="absmiddle" style="border:none" title="Tambah data PNBP Pengujian" /></a></div></td>
                  </tr>
                </tbody>
              </table>
              <hr />
              <table class="listtemuan" width="100%" id="list-pnbp">
                <tbody id="body-pnbp">
                  <?php
				 $arrpnbp = count($list_pnbp);
				 $total = 0;
				 if($arrpnbp > 0){
					 $x = 1;
					 $subtotal = 0;
					 for($i = 0; $i < $arrpnbp; $i++){
						 $subtotal = $list_pnbp[$i]['PNBP_JML'] * $list_pnbp[$i]['PNBP_TARIF'];
						 $total = $total + $subtotal;
						 ?>
                  <tr id="<?php echo $x; ?>">
                    <td width="301"><?php echo $list_pnbp[$i]['PNBP_DESCRIPTION']; ?>
                      <input type="hidden" name="PNBP[PNBP_ID][]" id="pnbp0" value="<?php echo $list_pnbp[$i]['PNBP_ID']; ?>" />
                      <input type="hidden" id="chk-input" edit="FALSE" target="" /></td>
                    <td width="214"><?php echo $list_pnbp[$i]['PNBP_UNIT']; ?></td>
                    <td width="119"><?php echo $list_pnbp[$i]['PNBP_JML']; ?>
                      <input type="hidden" value="<?php echo $list_pnbp[$i]['PNBP_JML']; ?>" name="PNBP[PNBP_JML][]" /></td>
                    <td width="214"><input type="hidden" name="PNBP[PNBP_TARIF][]" value="<?php echo $list_pnbp[$i]['PNBP_TARIF']; ?>" />
                      <?php echo $list_pnbp[$i]['PNBP_TARIF']; ?></td>
                    <td width="214" class="jmltotalpnbp"><?php echo $subtotal; ?></td>
                    <td width="40"><a href="javascript:void(0);" class="delpnbp"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="editpnbp"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a></td>
                  </tr>
                  <?php
						 $x++;
					 }
				 }else{
					 ?>
                  <tr>
                    <td colspan="6">Data tidak ditemukan</td>
                  </tr>
                  <?php
				 }
				 ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="4">Total</th>
                    <th><span id="total-pnbp"><?php echo $total; ?></span></th>
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
            <?php
			}
			?>
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
			  
			  if(in_array($sess['ASAL_SAMPEL'], $arrexternal)){#Pihak Ketiga
			  ?>
               <tr>
                <td class="td_left">Data Prioritas</td>
                <td class="td_right" colspan="5"><?php echo form_dropdown('SAMPEL[PRIORITAS]',$prioritas,$sess['PRIORITAS'],'class="stext prioritas" title="Data prioritas sampling" rel="required" id="cbprioritas" data-url = "'.site_url().'/autocompletes/autocomplete/set_prioritas/"'); ?><div>Pilih salah satu opsi dari pilihan Prioritas Sampling diatas untuk menentukan kategori pada informasi data sampel.</div></td>
              </tr>
                  <tr>
                    <td class="td_left">Komoditi</td>
                    <td class="td_right bold"><?php
                      if($kode_sampel == ""){
                          echo form_dropdown('KOMODITI[]',$komoditi,$sess['KOMODITI'],'class="stext komoditi" title="Komoditi" ke="1" id="sel1" rel="required"'); 
                      }else{
                          echo "<b>".$sess['KO']."<input type=\"hidden\" id=\"sel1\" ke=\"1\" value=\"".$sess['KOMODITI']."\"></b>";
                      }
                      ?></td>
                    </td>
                    <td width="10"></td>
                    <td class="td_left">&nbsp;</td>
                    <td class="td_right">&nbsp;</td>
                  </tr>
              <?php
			  }
			  ?> 
              <tr id="tdanak2" ke="2">
                <td class="td_left">Kategori sampel</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[0]) ? $selkategori[0] : '',$sel[0],'class="stext komoditi" title="Sub Komoditi atau Sub Kategori sampel" id="sel2" ke="2" rel="required"'); ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr <?php echo (strlen($sel[1]) == 6 || strlen($sel[1]) == 7 ) ? '' : 'class="hideme"'; ?> id="tdanak3" ke="3">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[1]) ? $selkategori[1] : '',$sel[1],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel3" ke="3"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr <?php echo (strlen($sel[2]) == 8 || strlen($sel[2]) == 9) ? '' : 'class="hideme"'; ?> id="tdanak4" ke="4">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[2]) ? $selkategori[2] : '',$sel[2],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel4" ke="4"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr <?php echo (strlen($sel[3]) == 10 || strlen($sel[3]) == 11)? '' : 'class="hideme"'; ?> id="tdanak5" ke="5">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[3]) ? $selkategori[3] : '',$sel[3],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel5" ke="5"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
			  <tr <?php echo (strlen($sel[4]) == 12 || strlen($sel[4]) == 13)? '' : 'class="hideme"'; ?> id="tdanak6" ke="6">
                <td class="td_left">&nbsp;</td>
                <td class="td_right"><?php echo form_dropdown('KOMODITI[]',is_array($selkategori[4]) ? $selkategori[4] : '',$sel[4],'class="stext komoditi" title="Sub Sub Komoditi atau Sub Sub Kategori sampel" id="sel6" ke="6"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Kategori Tambahan</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[KLASIFIKASI_TAMBAHAN]',$klasifikasi_tambahan,$sess['KLASIFIKASI_TAMBAHAN'],'class="stext" title="Komoditi" id="kk_tambahan"'); ?></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" class="td_left"><div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;"> <i>* Untuk pencarian data produk dari web registrasi, bisa menggunakan <b>Nama Produk</b> atau <b>Nomor Izin Edar</b></i> </div></td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><input type="text" class="stext" title="Nama sampel" name="SAMPEL[NAMA_SAMPEL]" id="nama_sampel" rel="required" value="<?php echo $sess['NAMA_SAMPEL'];?>" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/"/>
                  <input type="hidden" id="klasifikasi" value="<?php echo $sess['KOMODITI']; ?>" /></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><input type="text" class="stext" title="Nomor Registrasi" name="SAMPEL[NOMOR_REGISTRASI]" value="<?php echo $sess['NOMOR_REGISTRASI']; ?>" id="nie" url="<?php echo site_url(); ?>/autocompletes/autocomplete/produk_reg/" /></td>
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
                <td class="td_right"><input type="text" class="scode" id="jumlah" title="Jumlah sampel" rel="required" value="<?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>" name="SAMPEL[JUMLAH_SAMPEL]" onkeyup="numericOnly($(this))"/>
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
                    <input type="text" class="scode jml" title="Pengujian Kimia" id="jml_kimia" value="<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?>" name="SAMPEL[JUMLAH_KIMIA]" <?php echo trim($sess['JUMLAH_KIMIA']) != "" ? "":'readonly="readonly"'; ?>  onkeyup="numericOnly($(this))"/>
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
                <td class="td_left">Harga Pembelian</td>
                <td class="td_right"><input type="text" class="stext w100" title="Harga Pembelian" name="SAMPEL[HARGA_SAMPEL]" rel="required" value="<?php echo $sess['HARGA_SAMPEL']; ?>" onkeyup="numericOnly($(this))"/>
                  (dalam Rupiah)</td>
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
              <tr>
                <td class="td_left">Pemerian</td>
                <td class="td_right"><textarea class="stext" title="Catatan" name="SAMPEL[PEMERIAN]"><?php echo $sess['PEMERIAN']; ?></textarea></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
            </table>
          </div>
        </div>
        <?php
		if(array_key_exists('1', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('10', $this->newsession->userdata('SESS_KODE_ROLE')) || array_key_exists('9', $this->newsession->userdata('SESS_KODE_ROLE')) || $this->newsession->userdata('LOGGED_IN') ==  TRUE){
			?>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL HASIL SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small">Hasil Pengujian</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Hasil Kimia</td>
                <td class="td_right">
                <?php 
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					echo form_dropdown('SAMPEL[HASIL_KIMIA]', $hasil, $sess['HASIL_KIMIA'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS"'); 
				}else{
					echo $sess['HASIL_KIMIA']. "<input type=\"hidden\" name=\"SAMPEL[HASIL_KIMIA]\" value=\"".$sess['HASIL_KIMIA']."\">";
				}
				?>
                </td>
              </tr>
              <tr>
                <td class="td_left">Hasil Mikro</td>
                <td class="td_right">
                <?php 
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					echo form_dropdown('SAMPEL[HASIL_MIKRO]', $hasil, $sess['HASIL_MIKRO'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS"'); 
				}else{
					echo $sess['HASIL_MIKRO']. "<input type=\"hidden\" name=\"SAMPEL[HASIL_MIKRO]\" value=\"".$sess['HASIL_MIKRO']."\">";
				}
				?>
                </td>
              </tr>
              <tr>
                <td class="td_left">Hasil Sampel</td>
                <td class="td_right">
				<?php 
				if($this->newsession->userdata('SESS_BBPOM_ID') == "00"){
					echo form_dropdown('SAMPEL[HASIL_SAMPEL]', $hasil, $sess['HASIL_SAMPEL'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS"'); 
				}else{
					echo $sess['HASIL_SAMPEL']. "<input type=\"hidden\" name=\"SAMPEL[HASIL_SAMPEL]\" value=\"".$sess['HASIL_SAMPEL']."\">";
				}
				?>
                </td>
              </tr>
              <tr>
                <td class="td_left">Status Kimia</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[STATUS_KIMIA]', $uji_bidang, $sess['STATUS_KIMIA'], 'class="stext" title="Pilih salah satu pilihan : Di uji atau tidak di uji"'); ?></td>
              </tr>
              <tr>
                <td class="td_left">Status Mikro</td>
                <td class="td_right"><?php echo form_dropdown('SAMPEL[STATUS_MIKRO]', $uji_bidang, $sess['STATUS_MIKRO'], 'class="stext" title="Pilih salah satu pilihan : Di uji atau tidak di uji"'); ?></td>
              </tr>
            </table>
          </div>
        </div>
        <?php
		}
		?>
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
            <?php
			if($prevadmin){
					if(strlen($sess['SPU_ID']) > 0){
					?>
            <div style="height:5px;">&nbsp;</div>
            <h2 class="small">Catatan Perbaikan</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left">Keterangan</td>
                <td class="td_right"><textarea class="stext catatan" rel="required" title="Catatan perbaikan sampel" name="KEGIATAN"></textarea></td>
              </tr>
            </table>
            <?php
					}
			}
					?>
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
	$("#saranaid_").autocomplete($("#saranaid_").attr("url"), {width: 244, selectFirst: false}); 
	$("#saranaid_").result(function(event, data, formatted){ 
		if(data){ 
			$(this).val(data[2]);
			$("#saranaidval_").val(data[1]); 
			$("#input.operator").focus();
		} 
	});
	$("input.operator").autocomplete($("input.operator").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("input.operator").result(function(event, data, formatted){ 
		if(data){ 
			$("ul#urut0").append('<li style="padding-bottom:5px;" id="'+data[1]+'"><input type="text" class="stext" value="'+data[2]+'" readonly title="Nama Petugas">&nbsp;&nbsp;<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" title="Hapus Petugas" onclick="$(\'ul#urut0 li#' + data[1]+ '\').remove();" /></a><input type="hidden" name="USER_ID[]" value="'+data[1]+'"></li>'); 
			$(this).val(''); $(this).focus(); 
		} 
	});
	$("#nomor_surat").autocomplete($("#nomor_surat").attr("url"), {width: 244, selectFirst: false}); 
	$("#nomor_surat").result(function(event, data, formatted){ 
		if(data){
			$("#surat_id").val(data[1]); 
			$(this).val(data[2]);
			$("#tanggal_surat").val(data[3]);
			$("#anggaran_sampling").val(data[4]);
			$("#asal_sampling").val(data[5]);
			$("#tanggal_sampling").val(data[6]);
			$("#bulan").val(data[7]);
			$("#nama_pengirim").val(data[8]);
			$("#nip_rutin").val(data[9]);
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
						str += '<li style="padding-bottom:5px;" id="'+arrdata[0]+'">'+arrdata[1]+'<input type="hidden" name="USER_ID[]" value="'+arrdata[0]+'"></li>'
					}
					$("#operator").css("display","none");
					$("tr#tr_petugas").css("display","none");
					$("ul#petugas").append(str);
				}
			});
		} 
	});
	$("#nama_pengirim").autocomplete($("#nama_pengirim").attr("url")+'<?php echo $this->newsession->userdata('SESS_BBPOM_ID') ?>', {width: 244, selectFirst: false}); 
	$("#nama_pengirim").result(function(event, data, formatted){ 
		if(data){
			$(this).val(data[2]);
			$("#nip_rutin").val(data[1]);
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
		if(val == "05" || val == "06" || val == "07"){
			$(".biaya-pihak-ke-3").css("display","");
			$(".surat").html('Tanggal Surat Pengantar');
			$(".petugas").html('Petugas Penerima Sampel');
			$(".nomor").html('Nomor Surat Pengantar');
		}else{
			$(".biaya-pihak-ke-3").css("display","none");
			$(".surat").html('Tanggal Surat Tugas');
			$(".petugas").html('Petugas Sampling');
			$(".nomor").html('Nomor Surat Tugas');
		}
		return false;
	});
	$("#asal_sampling").change(function(){
		var val = $(this).val();
		if(val == "11"){
			$(".pihak-3-polisi").css("display","");
			$(".pihak-3-swasta-pemerintah").css("display","none");
		}else{
			$(".pihak-3-polisi").css("display","none");
			$(".pihak-3-swasta-pemerintah").css("display","");
		}
	});
	
	$("select.prioritas").change(function(e){
        var $this = $(this);
		if($this.val() == ""){
			$('#sel1, #sel2, #sel3, #sel4, #sel5').html('');
		}else{
			<?php
			if(in_array($sess['ASAL_SAMPEL'], $arrexternal)){
			?>
			$.get($this.attr("data-url") + $this.val() + '/external', function(data){
				if(data){
					$('#sel1').html(data);
				}
			});
			<?php
			}else{
			?>
			$.get($this.attr("data-url") + $this.val(), function(data){
				if(data){
					$('#sel1').html(data);
				}
			});
			<?php
			}
			?>
		}
		return false;		
    });
	
	$('select.komoditi').change(function(){
		var $this = $(this);
		var $substr = "";
		var ke = $(this).attr('ke');
		var kunci = $(this).val();
		var prioritasx = $("#cbprioritas option:selected").val();
		var urls = '<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + kunci + '/' + prioritasx;
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
			$("#nie").autocomplete($("#nie").attr('url') + kunci, {width: 244, selectFirst: false});
			$("#nie").result(function(event, data, formatted){
				if(data){
					$("#nama_sampel").val(data[1]);
					$(this).val(data[2]);
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
			$("#tujuan_sampling").val('');
			$("#div_tujuan").hide();
			$("#sub_tujuan").html('');
			$("#sub_tujuan").removeAttr("rel");
			if(kunci == "14"){
				$("#fileToUpload_LAMPIRAN").attr("rel","required");
			}else{
				$("#fileToUpload_LAMPIRAN").removeAttr("rel");
			}
			
		}
		ke = parseInt(ke) + 1;
		for(i=ke;i<=6;i++){
			$('#sel' + ke).html();
		}
		$.get(urls, function(hasil){
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
	$("#tujuan_sampling").change(function(){
		var kunci = $(this).val();
		var prioritasx = $("#cbprioritas option:selected").val();
		<?php
		if($kode_sampel == ""){
		?>
		var komoditi = $("#sel1 option:selected").val();
		<?php
		}else{
			?>
			var komoditi = $("#sel1").val();
			<?php
		}
		?>
		if(komoditi == "") return false;
		if(kunci != "01" && kunci != "02"){
			$("#div_tujuan").hide();
			$("#sub_tujuan").html('');
			$("#sub_tujuan").removeAttr("rel");
		}else{
			if(komoditi == "10" || komoditi == "11" || komoditi == "12"){
				$("#div_tujuan").show();
				$("#sub_tujuan").attr("rel", "required");
				$.get($(this).attr("url") + komoditi + '/' + kunci, function(hasil){
					$("#sub_tujuan").html(hasil);
				});
			}else if(komoditi == "01"){
				$("#sub_tujuan").removeAttr("rel");
				$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + komoditi + '/'+ prioritasx + '/' + kunci, function(hasil){
					var hasil = hasil.replace(' ', '');
					var jum = hasil.length;
					if(jum == 0 || kunci == 00){
						$('#tdanak2').hide();
						$('#sel2').html('');
					}else{
						$('#tdanak2').show();
						$('#sel2').html(hasil);
					}
				});			  
			}
		}
		
		$.get('<?php echo site_url().'/autocompletes/autocomplete/get_kategori/'; ?>' + komoditi +'/'+ prioritasx +  '/' + kunci, function(hasil){
			var hasil = hasil.replace(' ', '');
			var jum = hasil.length;
			if(jum == 0 || kunci == 00){
				$('#tdanak2').hide();
				$('#sel2').html('');
			}else{
				$('#tdanak2').show();
				$('#sel2').html(hasil);
			}
		});	
			
	});
	
	$("#jml_kimia").change(function(){
		var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseFloat($("#jumlah").val()) == 0) return false;
		sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));		
		if(parseFloat($("#jml_kimia").val()) + sisa > parseFloat($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
		}
		if(jml > parseFloat($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_kimia").focus();
			$("#jml_kimia").val('0');
			sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_mikro").val()) + parseFloat($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseFloat(sisa).toFixed(2));
	});
	$("#jml_mikro").change(function(){
		var jml = parseFloat($("#jml_mikro").val()) + parseFloat($("#jml_kimia").val());
		if($("#jumlah").val() == "" || parseFloat($("#jumlah").val()) == 0) return false;
		sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));
		if(parseFloat($("#jml_mikro").val()) + sisa > parseFloat($("#jumlah").val())){
			jAlert('Jumlah sampel melebihi sisa sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
		}
		if(jml > parseFloat($("#jumlah").val())){
			jAlert('Total jumlah sampel kimia dan mikro melebihi jumlah sampel','SIPT versi 1.0')
			$("#jml_mikro").focus();
			$("#jml_mikro").val('0');
			sisa = parseFloat($("#jumlah").val()) - (parseFloat($("#jml_kimia").val()) + parseFloat($(this).val()));
		}
		if(sisa < 0) sisa = 0;
		$("#sisa").val(parseFloat(sisa).toFixed(2));
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
			$(this).val(data[2]);
			$("#pnbp0").val(data[1]);
			$("#retacpnb0").html(data[2]);
			$("#pnbptarif0").val(data[3]);
			$("#pnbpsatuan0").val(data[4]);
			$("#jmlpnbp0").focus();
		}
	})
	$(".jmltarif").change(function(){
		var totalpnbp = 0;
		var tmptotal = 0;
		var total = parseInt($("#jmlpnbp0").val()) * parseInt($("#pnbptarif0").val());
		totalpnbp = tmptotal + total;
		$("#pnbptotal0").val(parseInt(total));
	});
	$(".addpnbp").live("click", function(){
		var valid = $("#pnbp0").val();
		var edit = $("#chk-input").attr("edit");
		var target = $("#chk-input").attr("target");
		if(valid == ""){
			jAlert('Maaf, Data PNBP yang dimasukan tidak terdapat dalam daftar PNBP.', 'SIPT Versi 1.0');
			$("#acpnbp0").val('');
			$("#pnbp0").val('');
			$("#jmlpnbp0").val('');
			$("#pnbptarif0").val('');
			$("#pnbpsatuan0").val('');
			$("#pnbptotal0").val('');
			$("#acpnbp0").focus();
			return false;
		}else{
			var ke = $("#list-pnbp #body-pnbp tr").length; 
			var chkjml = $("#jmlpnbp0").val();
			var jml = 0;
			if(chkjml != ""){
				if(edit == "FALSE"){
					$("#list-pnbp #body-pnbp").append('<tr id="'+(ke+1)+'" ke="'+(ke+1)+'"><td width="301" class="pnbpid">'+ $("#acpnbp0").val()+'<input type="hidden" name="PNBP[PNBP_ID][]" value="'+$("#pnbp0").val()+'" /></td><td width="214">'+$("#pnbpsatuan0").val()+'</td><td width="119"><input type="hidden" name="PNBP[PNBP_JML][]" value="'+$("#jmlpnbp0").val()+'" />'+$("#jmlpnbp0").val()+'</td><td width="214">'+$("#pnbptarif0").val()+'<input type="hidden" value="'+$("#pnbptarif0").val()+'" name="PNBP[PNBP_TARIF][]" /></td><td width="214" class="jmltotalpnbp">'+$("#pnbptotal0").val()+'</td><td><div><a href="javascript:void(0);" class="delpnbp"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="editpnbp"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a></div></td></tr>');
					$("#chk-input").attr("edit","FALSE");
					$("#chk-input").attr("target","");
				}else{
					$("#list-pnbp #body-pnbp tr#"+target).html('<td width="301" class="pnbpid">'+ $("#acpnbp0").val()+'<input type="hidden" name="PNBP[PNBP_ID][]" value="'+$("#pnbp0").val()+'" /></td><td width="214">'+$("#pnbpsatuan0").val()+'</td><td width="119"><input type="hidden" name="PNBP[PNBP_JML][]" value="'+$("#jmlpnbp0").val()+'" />'+$("#jmlpnbp0").val()+'</td><td width="214">'+$("#pnbptarif0").val()+'<input type="hidden" value="'+$("#pnbptarif0").val()+'" name="PNBP[PNBP_TARIF][]" /></td><td width="214" class="jmltotalpnbp">'+$("#pnbptotal0").val()+'</td><td><div><a href="javascript:void(0);" class="delpnbp"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="absmiddle" style="border:none" title="Hapus data PNBP Pengujian" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" class="editpnbp"><img src="<?php echo base_url(); ?>images/info.png" align="absmiddle" style="border:none" title="Edit data PNBP Pengujian" /></a><div></td>');
					$("#list-pnbp #body-pnbp tr#"+target).css("background-color","#FFF");
					$("#chk-input").attr("edit","FALSE");
					$("#chk-input").attr("target","");
				}
			}else{
				jAlert('Maaf, Jumlah uji tidak boleh kosong', 'SIPT Versi 1.0');
				$("#jmlpnbp0").focus();
				return false;
			}
			$("#list-pnbp #body-pnbp td.jmltotalpnbp").each(function(){
				jml = jml + parseInt($(this).html());
            });
			$("#acpnbp0").val('');
			$("#pnbp0").val('');
			$("#jmlpnbp0").val('');
			$("#pnbptarif0").val('');
			$("#pnbpsatuan0").val('');
			$("#pnbptotal0").val('');
			$("#total-pnbp").html(parseInt(jml));
			$("#biaya").val(parseInt(jml));
			$(".delpnbp").click(function(){
				var cl = $(this).closest("tr").attr("id");
				jConfirm('Anda yakin akan menghapus data PNBP tersebut ?', 'SIPT Versi 1.0', function(ojan){
					if(ojan==true){ 
						var jmlhapus = 0;
						$("#list-pnbp #body-pnbp tr#"+cl).remove();
						$("#list-pnbp #body-pnbp td.jmltotalpnbp").each(function(){
							jmlhapus = jmlhapus + parseInt($(this).html());
						});
						$("#total-pnbp").html(parseInt(jmlhapus));
						$("#biaya").val(parseInt(jmlhapus));
					}else{
						return false;
					}
				});
				$("#chk-input").attr("edit","FALSE");
				$("#chk-input").attr("target","");
				return false;
            });
			$(".editpnbp").click(function(){
                var rowedit = $(this).closest("tr").attr("id");
				var _JENISPNBP = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(1)").text();
				var _PNBPID = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(1)").find('input[name="PNBP[PNBP_ID][]"]').val();
				var _SATUAN = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(2)").text();
				var _JMLUJI = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(3)").text();
				var _TARIF = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(4)").text();
				var _TOTAL = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(5)").text();
				$("#acpnbp0").val(_JENISPNBP);
				$("#pnbp0").val(_PNBPID);
				$("#pnbpsatuan0").val(_SATUAN);
				$("#jmlpnbp0").val(_JMLUJI);
				$("#pnbptarif0").val(_TARIF);
				$("#pnbptotal0").val(_TOTAL);
				$("#chk-input").attr("edit","TRUE");
				$("#chk-input").attr("target",rowedit);
				$("#list-pnbp #body-pnbp tr#"+rowedit).css("background-color","#008DDE");
				return false;
            });
		}
		return false;
	});
	<?php
	if($kode_sampel!=""){
		?>
		$(".delpnbp").click(function(){console.log('Hapus Data ');
			var cl = $(this).closest("tr").attr("id");
			jConfirm('Anda yakin akan menghapus data PNBP tersebut ?', 'SIPT Versi 1.0', function(ojan){
				if(ojan==true){ 
					var jmlhapus = 0;
					$("#list-pnbp #body-pnbp tr#"+cl).remove();
					$("#list-pnbp #body-pnbp td.jmltotalpnbp").each(function(){
						jmlhapus = jmlhapus + parseInt($(this).html());
					});
					$("#total-pnbp").html(parseInt(jmlhapus));
					$("#biaya").val(parseInt(jmlhapus));
				}else{
					return false;
				}
			});
			$("#chk-input").attr("edit","FALSE");
			$("#chk-input").attr("target","");
			return false;
		});
		$(".editpnbp").click(function(){
			var rowedit = $(this).closest("tr").attr("id");
			var _JENISPNBP = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(1)").text();
			var _PNBPID = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(1)").find('input[name="PNBP[PNBP_ID][]"]').val();
			var _SATUAN = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(2)").text();
			var _JMLUJI = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(3)").text();
			var _TARIF = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(4)").text();
			var _TOTAL = $("#list-pnbp #body-pnbp tr#"+rowedit+" td:nth-child(5)").text();
			$("#acpnbp0").val(_JENISPNBP);
			$("#pnbp0").val(_PNBPID);
			$("#pnbpsatuan0").val(_SATUAN);
			$("#jmlpnbp0").val(_JMLUJI);
			$("#pnbptarif0").val(_TARIF);
			$("#pnbptotal0").val(_TOTAL);
			$("#chk-input").attr("edit","TRUE");
			$("#chk-input").attr("target",rowedit);
			$("#list-pnbp #body-pnbp tr#"+rowedit).css("background-color","#008DDE");
			return false;
		});
		<?php
	}
	?>
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