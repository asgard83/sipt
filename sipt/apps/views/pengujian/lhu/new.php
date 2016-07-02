<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">LAPORAN HASIL UJI</a></div>
      <div class="accCntnt">
        <form name="fcp" id="fcp" method="post" action="<?php echo $act; ?>" autocomplete="off">
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Kode Sampel</td>
              <td class="td_right"><?php echo $sess['KODE']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nama Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_SAMPEL']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Pengirim Sampel</td>
              <td class="td_right"><?php echo $sess['NAMA_PENGIRIM']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tempat Sampling</td>
              <td class="td_right"><div><?php echo $sess['TEMPAT_SAMPLING']; ?></div>
                <div><?php echo $sess['ALAMAT_SAMPLING']; ?></div></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Sampling</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SAMPLING']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nomor Surat Permintaan Uji</td>
              <td class="td_right"><?php echo $sess['SPU']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Surat Permintaan Uji</td>
              <td class="td_right"><?php echo $sess['TANGGAL_SPU']; ?></td>
            </tr>
          </table>
          <h2 class="small garis">&nbsp;</h2>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Nama Pabrik</td>
              <td class="td_right"><?php echo $sess['PABRIK']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Nomor Registrasi</td>
              <td class="td_right"><?php echo $sess['NOMOR_REGISTRASI']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">No. Bets / Lot</td>
              <td class="td_right"><?php echo $sess['NO_BETS']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Kadaluarsa</td>
              <td class="td_right"><?php echo $sess['KETERANGAN_ED']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Kemasan / Netto</td>
              <td class="td_right"><?php echo $sess['KEMASAN']; ?> / <?php echo $sess['NETTO']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Jumlah Sampel</td>
              <td class="td_right">@
                <?php
				if(in_array('B1',$this->newsession->userdata('SESS_SUB_SARANA')) || in_array('B2',$this->newsession->userdata('SESS_SUB_SARANA'))){
					echo $sess['JUMLAH_KIMIA'];
				}else if(in_array('B3',$this->newsession->userdata('SESS_SUB_SARANA'))){
					echo $sess['JUMLAH_MIKRO'];
				}
				?>
                <?php echo $sess['SATUAN']; ?></td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Mulai Pengujian</td>
              <td class="td_right">
			  <?php 
			  $arrmin = explode("-",$tanggaluji[0]['MINTGL']); 
			  echo $arrmin[2]."/".$arrmin[1]."/".$arrmin[0];
			  ?>
              </td>
            </tr>
            <tr>
              <td class="td_left bold">Tanggal Selesai Pengujian</td>
              <td class="td_right">
			  <?php 
			  $arrmax = explode("-",$tanggaluji[0]['MAXTGL']); 
			  echo $arrmax[2]."/".$arrmax[1]."/".$arrmax[0];
			  ?>
              </td>
            </tr>
          </table>

          <?php if($data_asal > 0){ ?>
            <h2 class="small garis">Informasi Balai Asal</h2>
            <div style="height:5px;"></div>
              <table class="form_tabel" width="100%">
                <tr>
                  <td class="td_left" style="width:200px;">Kode Sampel balai asal</td>
                  <td class="td_right" ><b><?php echo $asal[0]['UR_KODESAMPEL']; ?></b></td>                
                </tr>
                <tr>              
                  <td class="td_left">Nama Balai Asal <?php echo $tipe; ?></td>
                  <td class="td_right" ><b><?php echo $asal[0]['NAMA_BBPOM']; ?></b></td>
                </tr>
              </table>
            <?php } ?>
            
          <h2 class="small garis">Hasil Pengujian</h2>
          <div style="height:5px;">&nbsp;</div>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Pemerian</td>
              <td class="td_right"><?php echo $sess['PEMERIAN']; ?></td>
            </tr>
          </table>
          <table class="tabelajax">
            <tr class="head">
              <th>Uji yang dilakukan</th>
              <th>Hasil</th>
              <th>Syarat</th>
              <th>Metode</th>
              <th>Pustaka</th>
              <th>LCP</th>
              <th>Hasil</th>
            </tr>
            <?php
			$jparameter = count($parameter);
			if($jparameter > 0){
				for($x = 0; $x < $jparameter; $x++){
					?>
            <tr>
              <td><a href="javascript:;" class="koreksi-cp" url="<?php echo site_url(); ?>/get/pengujian/get_koreksi_params" id="<?php echo $parameter[$x]["UJI_ID"]; ?>"><?php echo $parameter[$x]['PARAMETER_UJI']; ?></a></td>
              <td><div><?php echo $parameter[$x]['HASIL']; ?></div>
                <div><?php echo $parameter[$x]['HASIL_KUALITATIF']; ?></div></td>
              <td><?php echo $parameter[$x]['SYARAT']; ?></td>
              <td><?php echo $parameter[$x]['METODE']; ?></td>
              <td><?php echo $parameter[$x]['PUSTAKA']; ?></td>
              <td><?php
			  if(strlen(trim($parameter[$x]['LCP'])) > 0){
				  ?>
                <a href="<?php echo base_url().'files/LCP/'.$sess['KODE_SAMPEL'].'/'.$parameter[$x]['LCP']; ?>" target="_blank">LCP</a>
                <?php
				}else{
					?>
                Tidak melampirkan LCP
                <?php
				}
				?></td>
              <td><?php echo $parameter[$x]['HASIL_PARAMETER']; ?></td>
            </tr>
            <?php
				  }
			  }
		  ?>
          </table>
          <?php
		  if(in_array('4', $this->newsession->userdata('SESS_KODE_ROLE'))){
		  ?>
          <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
            <p><b>Keterangan :</b></p>
            <p>Untuk melakukan koreksi hasil pengujian, silahkan klik pada masing-masing nama parameter uji</p>
          </div>
          <?php
		  }
		  ?>
          <div style="height:5px;">&nbsp;</div>
          <table class="form_tabel">
            <tr>
              <td class="td_left bold">Kesimpulan</td>
              <td class="td_right"><?php echo form_dropdown('HASIL', $hasil, $rowcp[0]['HSL'], 'class="stext" title="Pilih salah satu pilihan : MS atau TMS" rel="required"'); ?></td></tr>
            
            <tr>
              <td class="td_left bold">Tanggal di periksa</td>
              <td class="td_right"><input type="text" class="sdate datepick" name="PEJABAT_TANGGAL" rel="required" title="Tanggal Laporan Hasil Uji di periksa" /></td>
           	</tr>  
            <tr>
              <td class="td_left bold">Catatan</td>
              <td class="td_right"><textarea class="stext catatan" rel="required" name="CATATAN_CP" title="Catatan"></textarea></td>
            </tr>
          </table>
          
           <?php
		  if(strlen(trim($sess['KODE_RUJUKAN'])) > 1){
			  ?>
              <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:10px;">
              <p>Sampel ini merupakan sampel rujukan untuk sampel <b> <?= $sess['UR_KODE_RUJUKAN']; ?></b></p>
              </div>
              <?php
			  $jml = count($capafile);
			  if($jml > 0){
				  ?>
                  <table class="form_tabel">
                  <?php
				  $noindex = 1;
				  for($no=0;$no<$jml;$no++){
					  ?>
                      <tr>
                        <td class="td_left bold">Lampiran CAPA <?= $noindex; ?></td>
                        <td class="td_right"><a href="<?= base_url().'files/CAPA/'.$capafile[$no]['KODE_SAMPEL'].'/'.$capafile[$no]['CAPA_FILE']; ?>" target="_blank">Download Lampiran</a></td>
                      <tr>
                      <?php
					  $noindex++;
				  }
				  ?>
                  </table>
                  <?php
			  }
			  
		  }
		  ?>
          
          <div style="height:5px;">&nbsp;</div>
          <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_cp/<?php echo $cp_id; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log Catatan Pengujian (
            <?= $jml_log; ?>
            )</a></h2>
          <div id="detail_log"></div>
          <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
          <input type="hidden" name="CP_ID" value="<?php echo $cp_id; ?>" />
          <?= $bypass ? '<input type="hidden" name="CREATE_BY" value="'.$uid.'" /><input type="hidden" name="BYPASS" value="1" />' : ''; ?>
        </form>
      </div>
    </div>
    <div style="height:10px;">&nbsp;</div>
    <div style="padding-left:5px;"> <a href="#" class="button check" onclick="fpost('#fcp','',''); return false;"><span><span class="icon"></span>&nbsp; Verifikasi &nbsp;</span></a>&nbsp; <a href="#" class="button reload" url="<?php echo $batal; ?>" onclick="batal($(this)); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
    <div style="height:10px;">&nbsp;</div>
  </div>
</div>
<div id="ctn-koreksi-params"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('input.datepick').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});
		$(".koreksi-cp").live("click", function(){
			$.get($(this).attr("url") + "/" + $(this).attr("id"), function(data){
				$("#ctn-koreksi-params").html(data); 
				$("#ctn-koreksi-params").dialog({ 
					title: 'Koreksi hasil data parameter uji', 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
		});
	});
</script>