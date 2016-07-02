<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link type="text/css" href="<?php echo base_url();?>css/css.css" rel="stylesheet" />
<table class="detil">
	<tr><td colspan="2"><h2 class="small">Detil Data Sarana</h2></td></tr>
    <tr><td width="200">Nama Sarana</td><td><?php echo $sess['NAMA_SARANA']; ?></td></tr>
    <tr><td>Alamat Kantor</td><td><?php echo $sess['ALAMAT_1']; ?></td></tr>
    <tr><td>Alamat Gudang</td><td><?php echo $sess['ALAMAT_2']; ?></td></tr>
    <tr><td>Telepon</td><td><?php echo $sess['TELEPON'];?></td></tr>
    <tr><td>Nomor Izin</td><td><?php echo $sess['NOMOR_IZIN']; ?></td></tr>
    <tr><td>Tanggal Izin</td><td><?php echo $sess['TANGGAL_IZIN']; ?></td></tr>
    <tr><td>Nama Pimpinan</td><td><?php echo $sess['NAMA_PIMPINAN']; ?></td></tr>
    <tr><td>Nama Penanggung Jawab</td><td><?php echo $sess['PENANGGUNG_JAWAB']; ?></td></tr>
</table>
