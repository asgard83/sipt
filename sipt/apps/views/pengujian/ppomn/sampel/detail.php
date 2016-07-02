<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil" width="100%">
	<tr><td class="td_left">Komoditi</td><td class="td_right"><?php echo $sess['KOMODITI']; ?></td><td width="10"></td><td class="td_left">Komoditi Tambahan</td><td class="td_right"><?php echo $sess['KLASIFIKASI_TAMBAHAN']; ?></td></tr>
	<tr><td class="td_left">Nama sampel</td><td class="td_right"><?php echo $sess['NAMA_SAMPEL'];?></td><td width="10"></td><td class="td_left">No Registrasi</td><td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td></tr>
	<tr>
	  <td class="td_left">Kategori sampel</td>
	  <td class="td_right"><?php echo $sess['UR_KATEGORI']; ?></td><td width="10"></td>
	<td class="td_left">&nbsp;</td>
	<td class="td_right">&nbsp;</td>
	</tr>
	<tr><td class="td_left">Pabrik</td><td class="td_right"><?php echo $sess['PABRIK']; ?></td><td width="10"></td><td class="td_left">Importir</td><td class="td_right"><?php echo $sess['IMPORTIR']; ?></td></tr>                    	
	<tr><td class="td_left">Bentuk Sediaan sampel</td><td class="td_right"><?php echo $sess['BENTUK_SEDIAAN']; ?></td><td width="10"></td><td class="td_left">Kemasan sampel</td><td class="td_right"><?php echo $sess['KEMASAN']; ?></td></tr>
	<tr><td class="td_left">No Bets</td><td class="td_right"><?php echo $sess['NO_BETS']; ?></td><td width="10"></td><td class="td_left">Keterangan ED</td><td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td></tr>
	<tr><td class="td_left">Komposisi</td><td class="td_right"><?php echo $sess['KOMPOSISI']; ?></td><td width="10"></td><td class="td_left">Netto</td><td class="td_right"><?php echo $sess['NETTO']; ?></td></tr>
	<tr><td class="td_left">Evaluasi Penandaan</td><td class="td_right"><?php echo $sess['EVALUASI_PENANDAAN']; ?></td><td width="10"></td><td class="td_left">Cara Penyimpanan</td><td class="td_right"><?php echo $sess['CARA_PENYIMPANAN']; ?></td></tr>
	<tr><td class="td_left">Kondisi sampel</td><td class="td_right"><?php echo $sess['KONDISI_SAMPEL']; ?></td><td width="10"></td><td class="td_left">Jumlah sampel</td><td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sess)?$sess['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sess['SATUAN']; ?></td></tr>
	<tr>
	  <td class="td_left">Segel sampel</td>
	  <td class="td_right"><?php echo $sess['SEGEL']; ?></td>
	  <td></td>
	  <td class="td_left">Label sampel</td>
	  <td class="td_right"><?php echo $sess['LABEL']; ?></td>
  </tr>
	<tr>
	  <td class="td_left">Pengujian</td>
	  <td class="td_right"><div style="padding-bottom:5px;"><span <?php echo $sess['UJI_KIMIA'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Kimia</span>&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sess)?$sess['JUMLAH_KIMIA']:"0"; ?></div><div style="padding-bottom:5px;"><span <?php echo $sess['UJI_MIKRO'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Mikro</span>&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sess)?$sess['JUMLAH_MIKRO']:"0"; ?></div>
	  <div><span>Sisa</span>&nbsp;<?php echo array_key_exists('SISA', $sess)?$sess['SISA']:"0"; ?></div></td>
	  <td></td>
	  <td class="td_left">Harga Pembelian</td>
	  <td class="td_right"><?php echo $sess['HARGA_SAMPEL']; ?></td>
  </tr>
	<tr>
	  <td class="td_left">Catatan</td><td class="td_right"><?php echo $sess['CATATAN']; ?></td><td width="10"></td>
	  <td class="td_left">Lampiran File</td><td class="td_right">
      <?php
	  if(trim($sess['LAMPIRAN']) != ""){
		  ?>
		  <a href="<?php echo $file; ?>" target="_blank">Preview Photo</a>
		  <?php
	  }
	  ?>
      </td>
  </tr>
</table>
