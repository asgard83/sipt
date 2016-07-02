<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>
<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
    <div class="adCntnr">
    	<div class="acco2">
        	<div class="expand"><a title="expand/collapse" href="#" style="display: block;">DATA HASIL SAMPEL </a></div>
                <div class="accCntnt">
				<form name="ftlabsah" id="ftlabsah" method="post" action="<?php echo $act; ?>" autocomplete="off">
					<table class="form_tabel">
						<tr>
							<td class="td_left bold">Kode Sampel</td><td class="td_right"><?php echo $sess['KODE']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nama Sampel</td><td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Pengirim Sampel</td><td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tempat Sampling</td><td class="td_right"><div><?php echo $sess['TEMPAT_SAMPLING']; ?></div><div><?php echo $sess['ALAMAT_SAMPLING']; ?></div></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Sampling</td><td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nomor Surat Permintaan Uji</td><td class="td_right"><?php echo $sess['SPU']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Surat Permintaan Uji</td><td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
						</tr>
						</table>
						<h2 class="small garis">&nbsp;</h2>
						<table class="form_tabel">
						<tr>
							<td class="td_left bold">Nama Pabrik</td><td class="td_right"><?php echo $sess['PABRIK']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Nomor Registrasi</td><td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">No. Bets / Lot</td><td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Kadaluarsa</td><td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Kemasan / Netto</td><td class="td_right"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></td>							
						</tr>
						<tr>
							<td class="td_left bold">Jumlah</td><td class="td_right"> 
							<?php
							if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_KIMIA'];
							}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
								echo $sess['JUMLAH_MIKRO'];
							}else{
								?>Jumlah Kimia : <?php echo $sess['JUMLAH_KIMIA']; ?> <?php echo $sess['SATUAN']; ?>, Jumlah Mikro : <?php echo $sess['JUMLAH_MIKRO']; 
							}
							?> <?php echo $sess['SATUAN']; ?>
							
							</td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Mulai Pengujian</td><td class="td_right"><?php echo $tanggaluji[0]['MINTGL']; ?></td>
						</tr>
						<tr>
							<td class="td_left bold">Tanggal Selesai Pengujian</td><td class="td_right"><?php echo $tanggaluji[0]['MAXTGL']; ?></td>
						</tr>
					</table>
					<h2 class="small garis">Hasil Pengujian</h2>
					<div style="height:5px;">&nbsp;</div>
					<table class="form_tabel">
						<tr>
							<td class="td_left bold">Pemerian</td><td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
						</tr>
                    </table>					
                    <table class="tabelajax">
					<tr class="head"><th>Jenis Uji</th><th>Uji yang dilakukan</th><th>Hasil</th><th>Syarat</th><th>Metode</th><th>Pustaka</th><th>LCP</th></tr>
					<?php
						$jparameter = count($parameter);
						if($jparameter > 0){
							for($x = 0; $x < $jparameter; $x++){
								?>
								<tr><td><?php echo $parameter[$x]['JENIS_UJI']; ?></td><td><?php echo $parameter[$x]['PARAMETER_UJI']; ?></td><td><div><?php echo $parameter[$x]['HASIL']; ?></div><div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td><td><?php echo $parameter[$x]['SYARAT']; ?></td><td><?php echo $parameter[$x]['METODE']; ?></td><td><?php echo $parameter[$x]['PUSTAKA']; ?></td><td><a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a></td></tr>
								<?php
							}
						}
					?>
					</table>
					<h2 class="small garis">&nbsp;</h2>
					<table class="form_tabel">
					<?php
					if($sess['UJI_KIMIA'] == 1){
					?>
					<tr>
						<td class="td_left bold">Hasil Uji Kimia</td><td class="td_right"><?php echo $sess['HASIL_KIMIA']; ?></td>
					</tr>
					<?php
					}
					?>
					<?php
					if($sess['UJI_MIKRO'] == 1){
					?>
					<tr>
						<td class="td_left bold">Hasil Uji Mikro</td><td class="td_right"><?php echo $sess['HASIL_MIKRO']; ?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class="td_left bold">Hasil Sampel</td><td class="td_right"><?php echo $sess['HASIL_SAMPEL']; ?></td>
					</tr>
					<tr>
						<td class="td_left bold">Hasil PPOMN</td><td class="td_right"><?php echo $sess['HASIL_PPOMN']; ?></td>
					</tr>
					</table>
                    <?php
					if(count($proses)>1){
					?>
                    <div style="height:5px;">&nbsp;</div>
                    <h2 class="small garis">Hasil Tindak Lanjut</h2>
                    <table class="form_tabel">
                      <?php echo $input; ?>
                      <tr>
                      	<td class="td_left">Proses</td>
                        <td class="td_right"><?php echo form_dropdown('STATUS',$proses,'','class="stext" title="Pilih salah satu, untuk memproses tindak lanjut hasil sampling" rel="required"', $disproses); ?></td>
                      </tr>
                      <tr>
                      	<td class="td_left">Catatan</td>
                        <td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan verifikasi tindak lanjut hasil sampling" rel="required"></textarea></td>
                      </tr>
					</table>
                    <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
                    <?php
					}
					?>
					
                </form>
            </div>
        </div>
		
		<div style="height:10px;">&nbsp;</div>		
		<div style="padding-left:5px;">
        <?php
		if(count($proses)>1){
		?>
        <a href="#" class="button check" onclick="fpost('#ftlabsah','',''); return false;"><span><span class="icon"></span>&nbsp; Proses&nbsp;</span></a>&nbsp;
        <?php } ?>
        <a href="javascript:;" onclick="javascript:history.back();" class="button reload"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
		<div style="height:10px;">&nbsp;</div>	
		
    </div>
</div>