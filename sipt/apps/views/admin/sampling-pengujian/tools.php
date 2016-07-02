<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR);?>

<div id="juduluji" class="judul"></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><b>Tools Sampling - Pengujian</b></div>
      <div class="collapse">
        <div class="accCntnt">
          <div id="tabs">
            <ul>
            <?php
				if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
			?>
            <li><a href="#tabs-1">Reset Penomoran Kode Sampel</a></li>
              <li><a href="#tabs-2">Bidang Pengujian</a></li>
            </ul>
            <div id="tabs-1">
              <h2 class="small">Reset Nomor</h2>
              <form action="<?php echo site_url(); ?>/utility/tools/step_reset/first" id="freset-nomor" name="freset-nomor">
                <table class="form_tabel">
                  <tr>
                    <td class="td_left">Balai Besar / Balai POM</td>
                    <td class="td_right"><?php echo form_dropdown('cbbalai',$balai,'','class="stext" id="balai" rel="required" title="Pilih salah satu Balai"'); ?></td>
                  </tr>
                  <tr>
                    <td class="td_left">Komoditi</td>
                    <td class="td_right"><?php echo form_dropdown('cbkomoditi',$komoditi,'','class="stext" id="komoditi" title="Pilih salah satu komoditi atau abaikan jika akan direset seluruhnya"'); ?></td>
                  </tr>
                  <tr>
                    <td class="td_left">Anggaran</td>
                    <td class="td_right"><?php echo form_dropdown('cbanggaran',$anggaran,'','class="stext" id="komoditi" title="Pilih salah satu anggaran atau abaikan jika akan direset seluruhnya"'); ?></td>
                  </tr>
                  <tr>
                    <td class="td_left">Tahun Aktif</td>
                    <td class="td_right"><input type="text" class="sdate" readonly="readonly" value="<?php echo date("Y"); ?>" id="tahun" name="ta" title="Tahun aktif penomoran" /></td>
                  </tr>
                </table>
                <div style="padding-left:5px;" id="div-btn-reset"><a href="#" class="button download" id="btn-check" onclick="save_tools('#freset-nomor'); return false;"><span><span class="icon"></span>&nbsp; Check Data &nbsp;</span></a>&nbsp;<a href="#" class="button reload" id="btn-reload" onclick="reset_form(); return false;" style="display:none;"><span><span class="icon"></span>&nbsp; Cek Data Kembali &nbsp;</span></a></div>
                <div style="height:5px;">&nbsp;</div>
                <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
                  <p><b>Keterangan :</b></p>
                  <p>Proses reset nomor ini akan mempengaruhi nomor SPU, SPK dan SPP. Untuk surat-surat tersebut akan dihapus secara fisik dari database dan sampel akan dikembalikan ke posisi Operator Bidang Pemdik (untuk sampel rutin) dan TPS (untuk sampel pihak ke 3)</p>
                </div>
                <div style="height:5px;">&nbsp;</div>
                <h2 class="small h2rtn-reset" style="display:none; background:#e7e7e7; border:1px solid #ccc; padding:5px;">Hasil Check Data</h2>
                <div id="tmp-result"></div>
              </form>
            </div>
            <?php
				}
			?>
            <div id="tabs-2">
              <table class="form_tabel">
                <tr>
                  <td class="td_left">Pilih Menu</td>
                  <td class="td_right"><select id="menu-bidang" class="stext" url="<?php echo site_url(); ?>/utility/tools/bidang_pengujian/" title="Pilih salah satu menu">
                      <option value=""></option>
                      <?php
					  if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
						  ?>
                          <option value="revisi-kode-sampel">Revisi Kode Sampel</option>
                          <option value="roolback-tps">Roolback Data SPU ke TPS</option>
                          <option value="mapping-sampel">Mapping Sampel</option>
                          <option value="mapping-srl">Mapping SRL</option>
                          <?php
					  }else if(in_array('9', $this->newsession->userdata('SESS_KODE_ROLE'))){
						  ?>
                          <option value="revisi-kode-sampel">Revisi Kode Sampel</option>
                          <?php
					  }
					  if($this->newsession->userdata('SESS_USER_ID') == '102155'){
						  ?>
                          <option value="resort">Re-Sort Penomoran</option>
                          <option value="rilis">Get Status Rilis</option>
                          <option value="akhir-uji">Get Tanggal Akhir Uji</option>
                          <option value="mapping-kategori-pu">Mapping Kategori PU</option>
                          <option value="mapping-sampel-deleted">Mapping Deleted Sampel</option>
                          <option value="mapping-attachment">Mapping Lampiran Foto Kemasan</option>
                          <option value="mapping-kode">Mapping Penomoran Kode</option>
                          <option value="rekap-timeline-sampel">Rekap Timeline Sampel</option>
                          <?php
					  }
					  ?>
                    </select></td>
                </tr>
                <tr id="tr-responmt" style="display:none;">
                  <td colspan="2" class="td_left">Return : </td>
                </tr>
              </table>
              <div style="height:5px;">&nbsp;</div>
              <div id="loadmenucb"></div>
            </div>
            <!-- AKhir Bidang Pengujian!--> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
        $("#menu-bidang").change(function(){
			var urlmt = $(this).attr("url");
			var keymt = $(this).val();
			if(keymt == ""){
				$("#loadmenucb").html('');
				$("#tr-responmt").hide();
			}else{
				$("#loadmenucb").load(urlmt + keymt);
				$("#tr-responmt").show();
			}
			return false;
		});
    });
	
	function save_tools(formid){
		var jumlah = 0; 
		$.each($(formid+" input:visible, select:visible, textarea:visible"), function(){
			if($(this).attr('rel')){
				if($(this).attr('rel')=="required" && ($(this).val()=="" || $(this).val()==null)){
					$(this).css('background-color','#FBE3E4');
					$(this).css('border','1px solid #F00'); 
					jumlah++;
				}
			}
		});
		if(jumlah > 0){
			jAlert('Maaf, ada ' + jumlah + ' kolom yang harus diisi', 'SIPT Versi 1.0');
			return false;
		}else{
			$.ajax({
				type: "POST", 
				url: $(formid).attr('action') + '/ajax', 
				data: $(formid).serialize(),
				error: function(){ 
					jAlert('Maaf, Request halaman tidak ditemukan', 'SIPT Versi 1.0'); 
				}, 
				beforeSend: function(){
					jLoadingOpen('','SIPT Versi 1.0');
				}, 
				complete: function(){ 
					jLoadingClose();
				},
				success: function(data){
					if(data){
						$("#div-btn-reset").hide();
						$("#btn-check").hide();
						$("#btn-reload").show();
						$("#tmp-result").html(data);
						$(".h2rtn-reset").show();
					}
				}
			});
		}
	}
</script>