<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>
<div id="judulpmnsarana" class="judul"></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><b><?php echo $header; ?></b></div>
      <div class="collapse">
        <div class="accCntnt">
          <h2 class="small garis">Informasi Pemeriksaan</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left">Nama Sarana</td>
              <td class="td_right"><?php echo $sess['NAMA_SARANA']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Jenis Sarana</td>
              <td class="td_right"><?php echo $sess['NAMA_JENIS_SARANA']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Tanggal Pemeriksaan</td>
              <td class="td_right"><?php echo $sess['AWAL_PERIKSA']; ?> s.d <?php echo $sess['AKHIR_PERIKSA']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Balai Besar / Balai POM</td>
              <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Petugas Entri</td>
              <td class="td_right"><?php echo $sess['PETUGAS']; ?></td>
            </tr>
            <tr>
              <td class="td_left">Status Pemeriksaan</td>
              <td class="td_right"><?php echo $sess['STATUS']; ?></td>
            </tr>
          </table>
          <div><a href="#" class="button back" onclick="kembali(); return false;" ><span><span class="icon"></span>&nbsp; <?php echo $cancel; ?> &nbsp;</span></a><?php if($allowed) echo '&nbsp;<a href="javascript:void(0);" class="button reload edit-periksa" url="'.site_url().'/get/pemeriksaan/get_periksa/'.$sess['PERIKSA_ID'].'/'.$sess['SARANA_ID'].'" judul = "Edit Header Pemeriksaan" ><span><span class="icon"></span>&nbsp; Edit Data &nbsp;</span></a>'?></div>
          <div style="height:10px;"></div>
          <div><?php echo $tabel; ?></div>
          <div style="height:5px;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="ctn-periksa-edit"></div>
<script>
	$(document).ready(function(){
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id'});
		$(".edit-periksa").click(function(){
			var judul = $(this).attr("judul");
			$.get($(this).attr("url"), function(data){
				$("#ctn-periksa-edit").html(data); 
				$("#ctn-periksa-edit").dialog({ 
					title: judul, 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
		});	
	});
</script>