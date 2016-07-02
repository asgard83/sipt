<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fspk" id="fspk" method="post" action="<?php echo $act; ?>" autocomplete="off">
  <input type="hidden" name="spu_id" id="spu_id" value="<?php echo $sess['SPU_ID']; ?>" readonly="readonly" />
  <div class="adCntnr">
  <div class="acco2">
  <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI DATA SURAT PERMINTAAN UJI</a></div>
  <div class="collapse">
    <div class="accCntnt">
      <h2 class="small garis">Surat Permintaan Uji</h2>
      <table class="form_tabel">
        <tr>
          <td class="td_left"><b>Nomor Surat Permintaan Uji</b></td>
          <td class="td_right"><?php echo $sess['UR_SPU']; ?></td>
        </tr>
        <tr>
          <td class="td_left"><b>Tanggal Surat Permintaan Uji</b></td>
          <td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
        </tr>
        <tr>
          <td class="td_left"><b>Nomor Surat Perintah</b></td>
          <td class="td_right"><?php echo $sess['NOMOR_SP']; ?></td>
        </tr>
        <tr>
          <td class="td_left"><b>Tanggal Surat Perintah</b></td>
          <td class="td_right"><?php echo $sess['TANGGAL_PERINTAH']; ?></td>
        </tr>
        <tr>
          <td class="td_left"><b>Menyetujui Kepala Balai</b></td>
          <td class="td_right"><?php echo $sess['NAMA_USER']; ?></td>
        </tr>
        <tr>
          <td class="td_left">&nbsp;</td>
          <td class="td_right"><?php echo $sess['NAMA_BBPOM']; ?></td>
        </tr>
        <tr>
          <td class="td_left" colspan="2">Jika terjadi kesalahan tanggal disposisi, silahkan klik <a href="javascript:;" class="tgl-dispo" id="<?php echo $sess['SPU_ID']; ?>" judul = "Edit Header Surat SPU"  url="<?php echo site_url(); ?>/get/pengujian/get_headerspu/<?php echo $sess['SPU_ID']; ?>">Disini</a> untuk memperbaikinya</td>
        </tr>
      </table>
    </div>
  </div>
  <div style="height:5px;">&nbsp;</div>
  <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PENERIMAAN SAMPEL DI BIDANG</a></div>
  <div class="collapse">
    <div class="accCntnt">
      <h2 class="small garis">Informasi Penerimaan Sampel Di Bidang</h2>
      <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
        <p><b>Keterangan :</b></p>
        <p>Klik pada baris data untuk menampilkan detail data dan edit data disposisi</p>
      </div>
      <table class="listtemuan" width="100%">
        <thead>
          <tr>
            <th>Komoditi</th>
            <th>Kode Sampel</th>
            <th>Nama Sampel</th>
            <th>Manajer Teknis</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="tbody-disposisi">
          <?php
			$jmldispo = count($disposisi);
			if($jmldispo > 0){
				for($x=0; $x < $jmldispo; $x++){
					?>
          <tr id="<?php echo $disposisi[$x]['SPU_ID']; ?>-<?php echo $disposisi[$x]['KODE_SAMPEL']; ?>-<?php echo $disposisi[$x]['USER_ID']; ?>" url="<?php echo site_url(); ?>/get/pengujian/detail_dispo/" judul = "Detail Disposisi Penyerahan Sampel di Bidang Pengujian">
            <td><?php echo $disposisi[$x]['KOMODITI']; ?></td>
            <td><?php echo $disposisi[$x]['KODE']; ?></td>
            <td><?php echo $disposisi[$x]['NAMA_SAMPEL']; ?></td>
            <td><?php echo $disposisi[$x]['NAMA_USER']; ?></td>
            <td><?php echo $disposisi[$x]['UR_STATUS']; ?></td>
          </tr>
          <?php
				}
			}else{
				?>
          <tr>
            <td colspan="5">Data Tidak Ditemukan</td>
          </tr>
          <?php
			}
			?>
        </tbody>
      </table>
    </div>
  </div>
  <?php
	  if($sess['STATUS'] == "NVAL" && in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
		  ?>
  <div style="height:5px;">&nbsp;</div>
  <div class="expand"><a title="expand/collapse" href="#" style="display: block;">UPDATE STATUS</a></div>
  <div class="collapse">
  <div class="accCntnt">
  <h2 class="small garis">Update Status SPU</h2>
    <table class="form_tabel">
      <tr>
        <td class="td_left bold">Status</td>
        <td class="td_right"><?php echo form_dropdown('STATUS',$cbspu,'','class="stext" id="cbspu" title="Status Surat Permintaan Uji" rel="required" style="width:350px;"'); ?></td>
      </tr>
    </table>
</div>
</div>
<?php
	  }
	  ?>
</div>
</div>
</div>
</form>
<div style="height:10px;">&nbsp;</div>
<div style="padding-left:5px;"><a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
<div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-detildispo"></div>
<div id="ctn-resdispo"></div>
<div id="ctn-header-dispo"></div>
<script>
	$(document).ready(function(e){
		$("tbody#tbody-disposisi tr").click(function(e){
            var _id = $(this).attr("id");
			var judul = $(this).attr("judul");
			$.get($(this).attr("url") + _id , function(data){
				$("#ctn-detildispo").html(data); 
				$("#ctn-detildispo").dialog({ 
					title: judul, 
					width: 900, 
					resizable: false, 
					modal: true
				}); 
			});
        });
		$(".tgl-dispo").click(function(){
            var judul = $(this).attr("judul");
			$.get($(this).attr("url"), function(data){
				$("#ctn-header-dispo").html(data); 
				$("#ctn-header-dispo").dialog({ 
					title: judul, 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
        });
		$("#cbspu").change(function(e){
            var val = $(this).val();
			if(val == ""){
				return false;
			}else{
				jConfirm('Apakah anda yakin dengan data yang Anda isikan ?', 'SIPT Versi 1.0', function(ojan){
					if(ojan==true){
						$.ajax({
							type: "POST", 
							url : isUrl + 'index.php/post/spu/spu_act/update-status/ajax',
							data: 'spuid='+$("#spu_id").val()+'&status='+$("#cbspu").val(),
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
								if(data.search("MSG")>=0){
									arrdata = data.split('#');
									if(arrdata[1]=="YES"){
										jAlert(arrdata[2],'SIPT Versi 1.0');
										if(arrdata.length>3){
											setTimeout(function(){location.reload(true);}, 1000);
											return false;
										}
									}else{
										jAlert(arrdata[2],'SIPT Versi 1.0');
									}
								}else{
									jAlert(arrdata[2],'SIPT Versi 1.0');
								}
								return false;  
							} 
						});
					}else{
						$("#cbspu").val('');
						return false;
					}
				});
				return false;
			}
        });
		
	});
</script> 
