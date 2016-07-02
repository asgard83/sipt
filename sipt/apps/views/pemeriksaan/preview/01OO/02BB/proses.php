<?php 
$SESS_TGL = $this->session->userdata('SURAT');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR);
?>

<div id="judulpmnsarana" class="judul"></div>
<div class="headersarana"><?php echo $headersarana; ?></div>
<div class="content">
	<form name="f02BB_" id="f02BB_" method="post" action="<?php echo $act; ?>" autocomplete="off">
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
								<td class="td_right"><?php echo $sess['SARANA_BB']; ?></td>
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
								<td class="td_left">Tujuan Pemeriksaan</td>
								<td class="td_right"><?php echo $sess['TUJUAN_PEMERIKSAAN']; ?></td>
							</tr>
							<tr>
								<td class="td_left">Status Sarana</td>
								<td class="td_right"><?php echo $sess['STATUS_SARANA']; ?></td>
							</tr>
						</table>
						<div style="height:5px;"></div>
						<h2 class="small">Informasi Petugas Pemeriksa</h2>
						<div id="detail_petugas" url="<?php echo $histori_petugas;?>"></div>
						<div style="height:5px;"></div>
						<h2 class="small">Informasi Pemeriksaan</h2>
						<table class="form_tabel">
							<tr>
								<td class="td_left">Tanggal Pemeriksaan</td>
								<td class="td_right"><?php echo array_key_exists('AWAL_PERIKSA', $sess)?$sess['AWAL_PERIKSA']:""; ?>&nbsp; sampai dengan &nbsp;<?php echo array_key_exists('AKHIR_PERIKSA', $sess)?$sess['AKHIR_PERIKSA']:''; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Akhir Informasi Pemeriksaan !-->
				<div id="dtl-pemeriksaan" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Rutin" || $sess['TUJUAN_PEMERIKSAAN'] == "Kasus"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } ?>>
					<div style="height:5px;"></div>
					<div class="expand"><a title="expand/collapse" href="#" style="display: block;">DETIL PEMERIKSAAN</a></div>
					<div class="collapse">
						<div class="accCntnt">
							<table class="form_tabel">
								<tr>
									<td width="20" class="atas">&nbsp;</td>
									<td width="385" class="atas">Jenis produk yang diperiksa</td>
									<td class="atas" colspan="2"><?php
					  $jml = count($jenis_produk);
					  if($jml > 0){
					  	$no = 1;
					  	for($i = 0; $i < $jml; $i++){
							echo $no.". ".$jenis_produk[$i]."<br>";
							$no++;
						}
					  }
					  ?></td>
								</tr>
							</table>
							<h2 class="small">I. Administrasi</h2>
							<table class="form_tabel">
								<tr id="f02BB_point1a">
									<td></td>
									<td width="20" class="atas">a.</td>
									<td width="385" class="atas">Memiliki izin sesuai</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[0] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[0]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[0] != '' ? $aspek_keterangan[0] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point1b">
									<td></td>
									<td class="atas">b.</td>
									<td class="atas">Memiliki faktur pembelian / tanda terima barang</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[1] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[1]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[1] != '' ? $aspek_keterangan[1] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point1c">
									<td></td>
									<td class="atas">c.</td>
									<td class="atas">Mengeluarkan bon penjualan/surat jalan barang</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[2] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[2]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[2] != '' ? $aspek_keterangan[2] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point1d">
									<td></td>
									<td class="atas">d.</td>
									<td class="atas">Ada pencatatan pemasukan dan pengeluaran barang</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[3] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[3]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[3] != '' ? $aspek_keterangan[3] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point1e">
									<td></td>
									<td class="atas">e.</td>
									<td class="atas">Ada pencatatan tujuan penggunaan bahan berbahaya oleh pembeli</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[4] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[4]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[4] != '' ? $aspek_keterangan[4] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point1f">
									<td></td>
									<td class="atas">f.</td>
									<td class="atas">Ada pencatatan identitas jelas dan alamat pembeli (untuk pembeli perorangan)</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[5] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[5]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[5] != '' ? $aspek_keterangan[5] : '-'; ?></td>
								</tr>
							</table>
							<h2 class="small">II. Kesesuain Pengadaan Bahan Berbahaya</h2>
							<table class="form_tabel">
								<tr id="f02BB_point2a">
									<td></td>
									<td width="20" class="atas">a.</td>
									<td width="385" class="atas">Sumber pengadaan sesuai dengan surat penunjukan</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[6] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[6]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[6] != '' ? $aspek_keterangan[6] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point2b">
									<td></td>
									<td class="atas">b.</td>
									<td class="atas">Pengadaan bahan berbahaya sesuai dengan Surat Izin Usaha Perdagangan Bahan Berbahaya yang dimiliki</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[7] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[7]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[7] != '' ? $aspek_keterangan[7] : '-'; ?></td>
								</tr>
							</table>
							<h2 class="small">III. Kesesuaian Penyaluran / Distribusi Bahan Berbahaya</h2>
							<table class="form_tabel">
								<tr id="f02BB_point3a">
									<td></td>
									<td width="20" class="atas">a.</td>
									<td width="385" class="atas">Penyaluran bahan berbahaya dilakukan hanya ke industri pengguna akhir bahan berbahaya atau instansi / lembaga pengguna akhir bahan berbahaya</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[8] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[8]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[8] != '' ? $aspek_keterangan[8] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point3b">
									<td></td>
									<td class="atas">b.</td>
									<td class="atas">Tidak melakukan menyalurkan ke perorangan tanpa identitas dan tujuan penggunaan jelas</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[9] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[9]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[9] != '' ? $aspek_keterangan[9] : '-'; ?></td>
								</tr>
							</table>
							<h2 class="small">IV. Pengemasan Ulang</h2>
							<table class="form_tabel">
								<tr id="f02BB_point4">
									<td></td>
									<td width="20" class="atas">&nbsp;</td>
									<td width="385" class="atas">Melakukan pengemasan ulang (<em>repacking</em>) bahan berbahaya</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[10] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[10]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[10] != '' ? $aspek_keterangan[10] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point4x">
									<td></td>
									<td width="20" class="atas">&nbsp;</td>
									<td width="385" class="atas">Lampiran file</td>
									<td class="atas sel_penyimpangan">&nbsp;</td>
									<td class="atas">&nbsp;</td>
									<td class="atas"><?php if(array_key_exists('LAMPIRAN', $sess) && trim($sess['LAMPIRAN']) != ""){ ?> <a href="<?php echo base_url(); ?>files/<?php echo $sess['SARANA_ID']; ?>/<?php echo $sess['LAMPIRAN']; ?>" target="_blank">File Lampiran</a> <?php } ?></td>
								</tr>
							</table>
							<h2 class="small">V. Pelaporan</h2>
							<table class="form_tabel">
								<tr id="f02BB_point6a">
									<td></td>
									<td width="20" class="atas">a.</td>
									<td width="385" class="atas">Muatan Laporan sesuai dengan ketentuan</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[11] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[11]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[11] != '' ? $aspek_keterangan[11] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point6b">
									<td></td>
									<td class="atas">b.</td>
									<td class="atas">Melakukan pelaporan berkala per triwulan</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[12] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[12]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[12] != '' ? $aspek_keterangan[12] : '-'; ?></td>
								</tr>
								<tr id="f02BB_point6c">
									<td></td>
									<td class="atas">c.</td>
									<td class="atas">Laporan dikirimkan ke Instansi yang dinyatakan sesuai dengan ketentuan</td>
									<td class="atas sel_penyimpangan"><div class="01" <?php echo in_array('01', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $formalin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Formaldehid (formalin)</div>
										<div class="02" <?php echo in_array('02', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $serbuk[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid serbuk</div>
										<div class="03" <?php echo in_array('03', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $tablet[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Paraformaldehid tablet</div>
										<div class="04" <?php echo in_array('04', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $boraks[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Boraks</div>
										<div class="05" <?php echo in_array('05', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $rhodamin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Rhodamin B</div>
										<div class="06" <?php echo in_array('06', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $metanil[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Kuning Metanil</div>
										<div class="07" <?php echo in_array('07', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $auramin[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Auramin</div>
										<div class="08" <?php echo in_array('08', $divproduk) ? '' : 'style="display:none;"'; ?>><?php echo $amaran[13] == '1' ? '<b>&radic;</b>' : '<b>&times;</b>'; ?>&nbsp;Amaran</div></td>
									<td class="atas"><?php echo $aspek_check[13]; ?></td>
									<td class="atas"><?php echo $aspek_keterangan[13] != '' ? $aspek_keterangan[13] : '-'; ?></td>
								</tr>
							</table>
							<h2 class="small">Detil Pengadaan B2, Distribusi B2 dan Repacking B2</h2>
							<div style="height:5px;"></div>
							<div id="laporan-bb" url="<?php echo site_url(); ?>/get/pemeriksaan/get_lap_bb/<?php echo $sess['PERIKSA_ID']; ?>"></div>
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
				
				<div id="temuan-produk" <?php if($sess['TUJUAN_PEMERIKSAAN'] == "Penelurusan Jaringan"){ echo 'style=""'; }else{ echo 'style="display:none;"'; } ?>>
					<div style="height:5px;"></div>
					<div class="expand"><a title="expand/collapse" href="#" style="display: block;">TEMUAN PRODUK</a></div>
					<div class="collapse">
						<div class="accCntnt">
							<h2 class="small garis">Temuan Produk</h2>
							<div style="height:5px;"></div>
							<div id="temuan-bb" url="<?php echo site_url(); ?>/get/pemeriksaan/get_temuan_bb/<?php echo $sess['PERIKSA_ID']; ?>"></div>
						</div>
					</div>
					<!-- Akhir Temuan Pemeriksaan !--> 
				</div>
				<div style="height:5px;"></div>
				<div class="expand"><a title="expand/collapse" href="#" style="display: block;">KESIMPULAN dan TINDAK LANJUT</a></div>
				<div class="collapse">
					<div class="accCntnt">
						<h2 class="small garis">Kesimpulan</h2>
						<table id="f02BB_tbhasil" class="form_tabel">
							<tr>
								<td class="td_left">Hasil Pemeriksaan</td>
								<td class="td_right"><?php echo $sess['HASIL']; ?></td>
							</tr>
							<tr>
								<td class="td_left">Detil Kesimpulan
								<td class="td_right"><?php echo $sess['CATATAN']; ?></td>
							</tr>
						</table>
						<h2 class="small">Tindak Lanjut</h2>
						<table class="form_tabel">
							<tr>
								<td class="td_left">Tindak lanjut</td>
								<td class="td_right"><?php echo join("<br>",$tindak_lanjut); ?></td>
							</tr>
							<tr id="tr_rekomendasi" <?php echo in_array('01', $arrtl) || in_array('02', $arrtl) || in_array('03', $arrtl) ? '' : 'style="display:none;"'; ?>>
								<td class="td_left">Rekomendasi</td>
								<td class="td_right"><?php echo $sess['REKOMENDASI']; ?></td>
							</tr>
							<tr id="tr_catatan" <?php echo (in_array('02', $arrtl) || in_array('03', $arrtl) || in_array('04', $arrtl)) ? '' : 'style="display:none;"'; ?>>
							<td class="td_left">Catatan</td>
							<td class="td_right"><?php echo $sess['KEBIJAKAN'] != "" ? $sess['KEBIJAKAN'] : '-'; ?></td>
							</tr>
							<tr id="tr_contoh" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
								<td class="td_left">Hasil Uji</td>
								<td class="td_right"><?php echo $sess['HASIL_UJI']; ?></td>
							</tr>
							<tr id="tr_kode_sampel" <?php echo in_array('04', $arrtl) ? '' : 'style="display:none;"'; ?>>
								<td class="td_left">Kode Sampel</td>
								<td class="td_right"><?php echo $sess['KODE_SAMPEL']; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Akhir Temuan Pemeriksaan !-->
				
				<div style="height:5px;"></div>
				<div class="expand"><a title="expand/collapse" href="#" style="display: block;">VERIFIKASI PEMERIKSAAN</a></div>
				<div class="collapse">
					<div class="accCntnt">
						<h2 class="small garis">Verifikasi Pemeriksaan</h2>
						<?php if($isverifikasi) { ?>
						<table class="form_tabel">
							<tr>
								<td class="td_left">Proses Pemeriksaan</td>
								<td class="td_right"><?php echo form_dropdown($obj_status,$status,'','class="stext" title="Pilih salah satu, untuk memproses dokumen pemeriksaan" rel="required"', $disverifikasi); ?></td>
							</tr>
							<tr>
								<td class="td_left">Catatan</td>
								<td class="td_right"><textarea name="catatan" class="stext catatan" title="Catatan Verifikasi Pemeriksaan" rel="required"></textarea></td>
							</tr>
						</table>
						<?php } ?>
						<div style="padding-top:5px;">
							<h2 class="small"><a href="#" url="<?php echo $log; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Pemeriksaan (<?php echo $sess['JML_PROSES']; ?>)</a></h2>
							<div id="detail_log"></div>
						</div>
					</div>
				</div>
				<!-- Akhir Verifikasi !--> 
			</div>
		</div>
		<div id="clear_fix"></div>
		<div>
			<?php if($isverifikasi) { ?>
			<a href="#" class="button check" onclick="fpost('#f02BB_','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>&nbsp;
			<?php } ?>
			<a href="#" class="button back" onclick="kembali(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
		<div id="clear_fix"></div>
		<input type="hidden" name="PERIKSA_ID" value="<?php echo array_key_exists('PERIKSA_ID', $sess)?$sess['PERIKSA_ID']:'';?>" />
		<input type="hidden" name="NAMA_SARANA" value="<?php echo $sess['NAMA_SARANA']; ?>" />
		<input type="hidden" name="redir" value="<?php echo $redir; ?>" />
		<div id="clear_fix"></div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		create_ck("textarea.chk",505)
		$("#div_izin").html('Loading..');
		$("#div_izin").load($("#div_izin").attr("url"));
		$("#detail_petugas").html("Loading ...");
		$("#detail_petugas").load($("#detail_petugas").attr("url"));
		$("#laporan-bb").html('Loading..');
		$("#laporan-bb").load($("#laporan-bb").attr("url"));
		$("#temuan-bb").html("Loading ...");
		$("#temuan-bb").load($("#temuan-bb").attr("url"));
	});
</script>