<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH UJI</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Detil Sampel</h2>
        <div style="height:5px;"></div>
        <div> <?php echo $tabel; ?> </div>
        <div style="height:5px;">&nbsp;</div>
        <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
          <p><b>Keterangan :</b></p>
          <p>Untuk detil data sampel klik link pada tiap-tiap nama sampel</p>
        </div>
        <div style="height:5px;"></div>
        <h2 class="small garis">Informasi Data Surat Perintah Uji</h2>
        <form name="fspu" id="fspu" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left">Sampel <b><?php echo $komoditinya; ?></b> diatas diuji</td>
              <td class="td_right"><b><?php echo $tipeuji; ?></b><input type="hidden" name="chkjml" value="<?php echo $jmlinput; ?>" /></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Terima Sampel</td>
              <td class="td_right"><b><?php echo $sess['TANGGAL_TERIMA']; ?></b></td>
            </tr>
            <tr>
              <td class="td_left">Nomor Surat Permintaan Uji</td>
              <td class="td_right"><b><?php echo $sess['SPU']; ?></b></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Surat Perintah Uji</td>
              <td class="td_right"><input type="text" class="sdate" title="Tanggal Surat Perintah Uji" rel="required" name="PERINTAH_UJI[TANGGAL_PERINTAH]" id="tgl_perintah" onchange="chk_tgl('#tgl_terima', '#tgl_perintah', 'Mohon diperiksa kembali tanggal perintah tidak boleh lebih kecil dari tanggal penerimaan di TPS'); return false;" /></td>
            </tr>
            <tr class="row-petugas" ke="0" id="petugas">
              <td class="td_left petugas">Ditujukan Kepada</td>
              <td class="td_right">
              <?php echo form_dropdown('USER_ID[]',$arrmt,'','class="stext multiselect" style="height:90px; width:500px;" title="Daftar nama Manager Teknis. Untuk memilih MT lebih dari satu, silahkan klik di salah satu nama MT kemudian tekan tombol Ctrl untuk memilih MT yang lainnya" multiple rel="required"'); ?>		
                </td>
            </tr>
          </table>
          <div style="height:20px;">&nbsp;</div>
          <div style="padding-left:5px;"><a href="#" class="button save" onclick="fpost('#fspu','',''); return false;"><span><span class="icon"></span>&nbsp; Simpan &nbsp;</span></a>&nbsp;<a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
          <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" />
          <input type="hidden" name="KOMODITI" value="<?php echo $sess['KOMODITI']; ?>" />
          <input type="hidden" id="tgl_terima" value="<?php echo $sess['TANGGAL_TERIMA']; ?>" />
        </form>
      </div>
    </div>
  </div>
  <div style="height:20px;">&nbsp;</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
	$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
	$("input.operator").result(function(event, data, formatted){
		if(data){
			var ke = parseInt($(this).closest("tr").attr("ke"));
			$(this).val(data[2]);
			$("#ippetugas-"+ke).val(data[1]);
		}
	});
	$(".addpetugas").live("click", function(){
		var ke = $(this).closest("tr").attr("ke");
		var jml = $("tr.row-petugas").length;
		var str = '<tr id="row-petugas" ke="'+(jml+1)+'" id="petugas'+(jml+1)+'"><td class="td_left">&nbsp;</td><td class="td_right"><input type="text" class="stext operator" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/4/<?php echo $sess['SPU_ID']; ?>" rel="required" title="Ketikan Nama Penyelia, kemudian tekan enter" /><input type="hidden" id="ippetugas-'+(jml+1)+'" name="USER_ID[]" />&nbsp;<a href="#" class="removepetugas"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" /></a></td></tr>';
		$("tr#petugas").after(str);
		$("input.operator").autocomplete($("input.operator").attr('url'), {width: 244, selectFirst: false});
		$("input.operator").result(function(event, data, formatted){
			if(data){
				var ke = parseInt($(this).closest("tr").attr("ke"));
				$(this).val(data[2]);
				$("#ippetugas-"+ke).val(data[1]);
			}
		});
		return false;
	});
	$(".removepetugas").live("click", function(){
		var tr = $(this).closest("tr").attr("id");
		$("#"+tr).remove();
		return false;
	});
});
</script> 