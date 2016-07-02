<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<?php 
if($existing > 0)
	$allowed = FALSE;
else
	$allowed = TRUE;
if(!$allowed){
?>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH KERJA</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Surat perintah kerja sudah dibuat.</h2>
        <div style="padding-left:5px;"><a href="#" class="button back" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
      </div>
    </div>
  </div>
</div>
<?php
}else{
?>
<div class="content">
  <form name="fspk" id="fspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
    <div class="adCntnr">
      <div class="acco2">
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA SAMPEL</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <h2 class="small garis">Perintah Pengujian</h2>
            <table class="form_tabel" width="100%">
              <tr>
                <td class="td_left">Nomor Surat Perintah Pengujian</td>
                <td class="td_right bold" style="width:300px;"><?php echo $sampel[0]['UR_SPP'];  ?></td>
                <td></td>
                <td class="td_left">Tanggal Surat Perintah Pengujian</td>
                <td class="td_right bold"><?php echo $sampel[0]['TGL_SPP']; ?></td>
              </tr>
            </table>
            <h2 class="small garis">Informasi Sampel</h2>
            <table class="form_tabel" width="100%">
              <tr>
                <td class="td_left">Kode Sampel</td>
                <td class="td_right" style="width:300px;"><b><?php echo $sampel[0]['UR_KODESAMPEL']; ?></b></td>
                <td></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Komoditi</td>
                <td class="td_right" style="width:300px;"><?php echo $sampel[0]['UR_KOMODITI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Komoditi Tambahan</td>
                <td class="td_right"><?php echo $sampel[0]['KLASIFIKASI_TAMBAHAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Nama sampel</td>
                <td class="td_right"><?php echo $sampel[0]['NAMA_SAMPEL'];?></td>
                <td width="10"></td>
                <td class="td_left">No Registrasi</td>
                <td class="td_right"><?php echo $sampel[0]['NOMOR_REGISTRASI']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kategori sampel</td>
                <td class="td_right"><?php echo $sampel[0]['UR_KATEGORI']; ?></td>
                <td width="10"></td>
                <td class="td_left">&nbsp;</td>
                <td class="td_right">&nbsp;</td>
              </tr>
              <tr>
                <td class="td_left">Pabrik</td>
                <td class="td_right"><?php echo $sampel[0]['PABRIK']; ?></td>
                <td width="10"></td>
                <td class="td_left">Importir</td>
                <td class="td_right"><?php echo $sampel[0]['IMPORTIR']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Bentuk Sediaan sampel</td>
                <td class="td_right"><?php echo $sampel[0]['BENTUK_SEDIAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Kemasan sampel</td>
                <td class="td_right"><?php echo $sampel[0]['KEMASAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">No Bets</td>
                <td class="td_right"><?php echo $sampel[0]['NO_BETS']; ?></td>
                <td width="10"></td>
                <td class="td_left">Keterangan ED</td>
                <td class="td_right"><?php echo $sampel[0]['KETERANGAN_ED']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Komposisi</td>
                <td class="td_right"><?php echo $sampel[0]['KOMPOSISI']; ?></td>
                <td width="10"></td>
                <td class="td_left">Netto</td>
                <td class="td_right"><?php echo $sampel[0]['NETTO']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Evaluasi Penandaan</td>
                <td class="td_right"><?php echo $sampel[0]['EVALUASI_PENANDAAN']; ?></td>
                <td width="10"></td>
                <td class="td_left">Cara Penyimpanan</td>
                <td class="td_right"><?php echo $sampel[0]['CARA_PENYIMPANAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Kondisi sampel</td>
                <td class="td_right"><?php echo $sampel[0]['KONDISI_SAMPEL']; ?></td>
                <td width="10"></td>
                <td class="td_left">Jumlah sampel</td>
                <td class="td_right"><?php echo array_key_exists('JUMLAH_SAMPEL', $sampel[0])?$sampel[0]['JUMLAH_SAMPEL']:"0"; ?>&nbsp;&nbsp;<?php echo $sampel[0]['SATUAN']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Segel sampel</td>
                <td class="td_right"><?php echo $sampel[0]['SEGEL']; ?></td>
                <td></td>
                <td class="td_left">Label sampel</td>
                <td class="td_right"><?php echo $sampel[0]['LABEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Pengujian</td>
                <td class="td_right"><div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_KIMIA'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Kimia</span>&nbsp;<?php echo array_key_exists('JUMLAH_KIMIA', $sampel[0])?$sampel[0]['JUMLAH_KIMIA']:"0"; ?></div>
                  <div style="padding-bottom:5px;"><span <?php echo $sampel[0]['UJI_MIKRO'] > 0 ? 'style="text-decoration:line-through;"' : ''; ?>>&nbsp;Mikro</span>&nbsp;<?php echo array_key_exists('JUMLAH_MIKRO', $sampel[0])?$sampel[0]['JUMLAH_MIKRO']:"0"; ?></div>
                  <div><span>Sisa</span>&nbsp;<?php echo array_key_exists('SISA', $sampel[0])?$sampel[0]['SISA']:"0"; ?></div></td>
                <td></td>
                <td class="td_left">Harga Pembelian</td>
                <td class="td_right"><?php echo $sampel[0]['HARGA_SAMPEL']; ?></td>
              </tr>
              <tr>
                <td class="td_left">Catatan</td>
                <td class="td_right"><?php echo $sampel[0]['CATATAN']; ?></td>
                <td></td>
                <td class="td_left">Lampiran File</td>
                <td class="td_right"><?php
			  if(trim($sampel[0]['LAMPIRAN']) != ""){
			  ?>
                  <a href="<?php echo $file; ?>" target="_blank">Preview Photo</a>
                  <?php
			  }
			  ?></td>
              </tr>
            </table>
          </div>
        </div>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PARAMETER UJI</a></div>
        <div class="collapse">
          <div class="accCntnt">
            <?php
			if($notallowed){#Jika Sudah Entri Parameter Uji
			?>
            <h2 class="small garis">Informasi Tanggal Surat Perintah Kerja</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
                <td class="td_right"><?php echo $sess['TANGGAL']; ?></td>
              </tr>
              <tr>
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
              </tr>
            </table>
            <h2 class="small garis">Penetuan Parameter Uji</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="100">Pustaka</th>
                  <th width="75">Syarat</th>
                  <th width="75">Ruang Lingkup</th>
                </tr>
              </thead>
              <tbody>
                <?php
			  $jml = count($parameter);
			  if($jml > 0){
				  for($i = 0; $i < $jml; $i++){
					  ?>
                <tr>
                  <td><?php echo $parameter[$i]['PARAMETER_UJI']; ?></td>
                  <td><?php echo $parameter[$i]['METODE']; ?></td>
                  <td><?php echo $parameter[$i]['PUSTAKA']; ?></td>
                  <td><?php echo $parameter[$i]['SYARAT']; ?></td>
                  <td><?php echo $parameter[$i]['RUANG_LINGKUP']; ?></td>
                </tr>
                <?php
				  }
			  }else{
			  ?>
                <tr>
                  <td colspan="5"><b>Data tidak ditemukan</b></td>
                  <?php
			  }
			  ?>
              </tbody>
            </table>
            <?php
			}else{#Jika Belum Entri Parameter  Uji
			?>
            <h2 class="small garis">Informasi Tanggal Surat Perintah Kerja</h2>
            <table class="form_tabel">
              <tr>
                <td class="td_left bold">Tanggal Surat Perintah Kerja</td>
                <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Keja" name="TANGGAL"/></td>
              </tr>
              <tr>
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right"><input type="text" class="stext operator" title="Penyelia Penerima SPK" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>" id="acpenyelia"/>
                  <input type="hidden" id="penyelia" name="KASIE" />
                  <input type="hidden" name="spuid" value="<?php echo $sampel[0]['SPU_ID']; ?>" />
                  <input type="hidden" name="kode_sampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
                  <input type="hidden" name="komoditi" value="<?php echo $sampel[0]['KOMODITI']; ?>" /></td>
              </tr>
            </table>
            <h2 class="small garis">Penetuan Parameter Uji</h2>
            <table class="form_tabel" id="tbparamater">
              <tr>
                <td class="td_left">Parameter Uji</td>
                <td class="td_right" style="width:300px;"><input type="text" class="stext paramuji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $sampel[0]['KATEGORI']; ?>" title="Parameter Uji" id="parameter" />
                  <input id="srlid" type="hidden" />
                  <input type="hidden" id="biduji" />
                  <input type="hidden" id="kodesampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
                  <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" />
                  </td>
                <td></td>
                <td class="td_left">Metode</td>
                <td class="td_right" style="width:300px;"><input type="text" class="stext" title="Metode" readonly="readonly" id="metode" /></td>
              </tr>
              <tr>
                <td class="td_left">Pustaka</td>
                <td class="td_right"><input type="text" class="stext" title="Pustaka" readonly="readonly" id="pustaka" /></td>
                <td></td>
                <td class="td_left">Syarat</td>
                <td class="td_right"><input type="text" class="stext" title="Syarat" readonly="readonly" id="syarat" /></td>
              </tr>
              <tr>
                <td class="td_left">Ruang Lingkup</td>
                <td class="td_right" colspan="4"><input type="text" id="rlingkup" class="stext" title="Ruang Lingkup" readonly="readonly" /></td>
              </tr>
              <?php /*?>              <tr>
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right" colspan="4"><input type="text" class="stext operator" title="Penyelia Penerima SPK" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>" id="acpenyelia"/>
                  <input type="hidden" id="penyelia" name="KASIE" />
                  <input type="hidden" name="spuid" value="<?php echo $sampel[0]['SPU_ID']; ?>" />
                  <input type="hidden" name="kode_sampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
                  <div style="padding-top:5px;">
                    <input type="checkbox" id="chkpenyelia" />
                    &nbsp;Ceklis tanda disamping, jika SPK dikirim ke penyelia yang sama dengan beberapa parameter uji</div></td>
              </tr>
<?php */?>
            </table>
            <div style="height:5px;"></div>
            <div class="btn"><span><a href="javascript:void(0);" id="addparameter">Klik Disini Untuk Menambah Parameter Uji</a></span></div>
            <h2 class="small garis">Daftar Penetuan Parameter Hasil Uji</h2>
            <table class="listtemuan" width="100%" id="draft-parameter">
              <thead>
                <tr>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="100">Pustaka</th>
                  <th width="75">Syarat</th>
                  <th width="75">Ruang Lingkup</th>
                  <th width="200">Penyelia</th>
                </tr>
              </thead>
              <tbody id="body-paramater">
              </tbody>
            </table>
            <?php    
			}
			?>
            <div style="height:10px;">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;">
    <?php
  if($notallowed){
	  ?>
    <a href="#" class="button download" onclick="batal($(this)); return false;" url="<?php echo site_url(); ?>/topdf/spk/prints/<?php echo $sampel[0]['KODE_SAMPEL']; ?>"><span><span class="icon"></span>&nbsp; Cetak SPK &nbsp;</span></a>
    <?php
  }else{
	  ?>
    <a href="#" class="button check" onclick="fpost('#fspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>
    <?php
  }?>
    &nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<script>
	$(document).ready(function(e){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$("#parameter").autocomplete($("#parameter").attr('url'), {width: 244, selectFirst: false});
		$("#parameter").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#metode").val(data[3]);
				$("#pustaka").val(data[4] == '' ? '-' : data[4]);
				$("#syarat").val(data[5] == '' ? '-' : data[5]);
				$("#rlingkup").val(data[6] == '' ? '-' : data[6]);
				$("#biduji").val(data[7] == '' ? '-' : data[7]);
			}
		});
		$("#acpenyelia").autocomplete($("#acpenyelia").attr('url'), {width: 244, selectFirst: false});
		$("#acpenyelia").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#penyelia").val(data[1]);
			}
		});
		$("#chkpenyelia").change(function(){
			if($(this).is(':checked')){
				$("#acpenyelia").attr("readonly","readonly");
				$("#acpenyelia").removeAttr("url");
			}else{
				$("#acpenyelia").removeAttr("readonly");
				$("#acpenyelia").attr("url","<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>");
				$("#penyelia").val('');
				$("#acpenyelia").val('');
			}
		});
		$("#addparameter").live("click", function(){
			if(!beforeSubmit("#tbparamater")){
				return false;
			}else{
				var no = $("#body-paramater tr").length;
				var str = '<tr id="baris'+(no+1)+'">';
					str += '<td>'+$("#parameter").val()+'&nbsp;<input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+$("#parameter").val()+'"></td>';
					str += '<td>'+$("#metode").val()+'&nbsp;<input type="hidden" name="UJI[METODE][]" value="'+$("#metode").val()+'"></td>';
					str += '<td>'+$("#pustaka").val()+'&nbsp;<input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka").val()+'"></td>';
					str += '<td>'+$("#syarat").val()+'&nbsp;<input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat").val()+'"></td>';
					str += '<td>'+$("#rlingkup").val()+'&nbsp;<input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+$("#rlingkup").val()+'"></td>';
					str += '<td>'+$("#acpenyelia").val()+'&nbsp;<input type="hidden" name="UJI[PENYELIA][]" value="'+$("#penyelia").val()+'"></td>';
					str += '</tr>';
					$("#body-paramater").append(str);
					/*if($("#chkpenyelia").attr("checked")){
						$("#parameter").val('');	
						$("#metode").val('');	
						$("#pustaka").val('');	
						$("#syarat").val('');	
						$("#rlingkup").val('');
					}else{
						clearForm("#tbparamater");
					}*/
					clearForm("#tbparamater");
			}
			return false;
		});
    });
</script>
<?php
}
?>
