<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
	<form name="freviewspk" id="freviewspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
		<div class="adCntnr">
			<div class="acco2">
				<div class="expand"><a title="expand/collapse" href="#" style="display: block;">PERINTAH KERJA</a></div>
				<div class="collapse">
					<div class="accCntnt">
						<h2 class="small garis">Detail Perintah Kerja</h2>
						<table class="form_tabel">
							<tr>
								<td class="td_left bold">Nomor SPU</td>
								<td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
							</tr>
							<tr>
								<td class="td_left bold">Kode Sampel</td>
								<td class="td_right"><?php echo $sess['UR_KODE']; ?></td>
							</tr>
							<tr>
								<td class="td_left bold">Nomor SPK</td>
								<td class="td_right"><?php echo $sess['UR_SPK']; ?></td>
							</tr>
							<tr>
								<td class="td_left bold">Tanggal Surat Perintah Kerja</td>
								<td class="td_right"><?php echo $sess['TANGGAL_SPK']; ?></td>
							</tr>
							<tr>
								<td class="td_left bold">Nama Penyelia</td>
								<td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
							</tr>
						</table>
						<h2 class="small garis">Detail Parameter Uji</h2>
						<table class="listtemuan" width="100%">
							<thead>
								<tr>
									<th width="200">Parameter Uji</th>
									<th width="75">Metode</th>
									<th width="100">Pustaka</th>
									<th width="75">Syarat</th>
									<th width="75">Ruang Lingkup</th>
									<th width="80">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
			  $jml = count($parameter);
			  if($jml > 0){
				  for($i = 0; $i < $jml; $i++){
						if($parameter[$i]['STATUS'] == '40205'){
							?>
								<tr id="<?php echo $parameter[$i]['UJI_ID']; ?>" ke = "<?php echo $i; ?>">
									<td><input type="text" name="PU[PARAMETER_UJI][]" rel="required" class="stext parameter" value="<?php echo $parameter[$i]['PARAMETER_UJI']; ?>" title="Parameter Uji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $parameter[$i]['KATEGORI']; ?>" id="params_<?php echo $i; ?>" />
										<input type="hidden" name="PU[UJI_ID][]" value="<?php echo $parameter[$i]['UJI_ID']; ?>" />
										<input type="hidden" id="golongan_<?php echo $i; ?>" name="PU[GOLONGAN][]" /></td>
									<td><?php echo $parameter[$i]['METODE']; ?></td>
									<td><?php echo $parameter[$i]['PUSTAKA']; ?>
										<input type="hidden" name="PU[PUSTAKA][]" id="pustaka_<?php echo $i; ?>" /></td>
									<td><?php echo $parameter[$i]['SYARAT']; ?>
										<input type="hidden" name="PU[SYARAT][]" id="syarat_<?php echo $i; ?>" /></td>
									<td><?php echo $parameter[$i]['RUANG_LINGKUP']; ?>
										<input type="hidden" name="PU[RUANG_LINGKUP][]" id="ruang_lingkup_<?php echo $i; ?>" /></td>
									<td><div style="border:1px solid #F00; width:80px; text-align:center; color:#FFF; background-color:#F00; font-weight:bold;">- Review PU</div></td>
								</tr>
								<?php
						}else{
							?>
								<tr>
									<td><?php echo $parameter[$i]['PARAMETER_UJI']; ?></td>
									<td><?php echo $parameter[$i]['METODE']; ?></td>
									<td><?php echo $parameter[$i]['PUSTAKA']; ?></td>
									<td><?php echo $parameter[$i]['SYARAT']; ?></td>
									<td><?php echo $parameter[$i]['RUANG_LINGKUP']; ?></td>
									<td class="bold atas isi">Sesuai</td>
								</tr>
								<?php
						}
				  ?>
									</td>
								
									</tr>
								
								<?php
				  }
			  }else{
			  ?>
								<tr>
									<td colspan="6"><b>Data tidak ditemukan</b></td>
								</tr>
								<?php
			  }
			  ?>
							</tbody>
						</table>
						<div style="height:5px;">&nbsp;</div>
						<table class="form_tabel">
							<tr>
								<td class="td_left">Catatan</td>
								<td class="td_right"><textarea class="stext catatan" name="CATATAN" rel="required" title="Catatan Revisi SPK"></textarea></td>
							</tr>
						</table>
						<div style="height:10px;"></div>
						<h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_spk/<?php echo $sess['SPK_ID']; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log SPK (
							<?= $logspk; ?>
							)</a></h2>
						<div id="detail_log"></div>
						<div style="height:10px;">&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" />
		<input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
		<input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
	</form>
	<div style="height:10px;">&nbsp;</div>
	<div style="padding-left:5px;"> <a href="#" class="button check" onclick="fpost('#freviewspk','',''); return false;"><span><span class="icon"></span>&nbsp; Kirim Ulang SPK &nbsp;</span></a> &nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
	<div style="height:10px;">&nbsp;</div>
</div>
<script>
	$(document).ready(function(e){
		$("input.parameter").autocomplete($("input.parameter").attr('url'), {width: 244, selectFirst: false});
		$("input.parameter").result(function(event, data, formatted){
			if(data){
				var idtr = $(this).closest("tr").attr("id");
				var ke = $(this).closest("tr").attr("ke");
				$(this).val(data[2]);
				$("#metode_"+ke+"").val(data[3]);
				$("#pustaka_"+ke+"").val(data[4] == '' ? '-' : data[4]);
				$("#syarat_"+ke+"").val(data[5] == '' ? '-' : data[5]);
				$("#ruang_lingkup_"+ke+"").val(data[6] == '' ? '-' : data[6]);
				$("#golongan_"+ke+"").val(data[8]);
				$("tr#"+idtr+" td:nth-child(2)").html(data[3]+'<input type="hidden" name="PU[METODE][]" value="'+data[3]+'" />');
				$("tr#"+idtr+" td:nth-child(3)").html(data[4] == '' ? ' - <input type="hidden" name="PU[PUSTAKA][]" value="-" />' : data[4]+'<input type="hidden" name="PU[PUSTAKA][]" value="'+data[4]+'" />');
				$("tr#"+idtr+" td:nth-child(4)").html(data[5] == '' ? ' - <input type="hidden" name="PU[SYARAT][]" value="-" />' : data[5]+'<input type="hidden" name="PU[SYARAT][]" value="'+data[5]+'" />');
				$("tr#"+idtr+" td:nth-child(5)").html(data[6] == '' ? ' - <input type="hidden" name="PU[SYARAT][]" value="-" />' : data[6]+'<input type="hidden" name="PU[SYARAT][]" value="'+data[6]+'" />');
			}
		});
	});
</script> 
