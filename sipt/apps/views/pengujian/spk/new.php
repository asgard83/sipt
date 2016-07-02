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
  <form name="fspk" id="fspk" method="post" action="<?php echo $act; ?>" autocomplete="off" class="frm_spk">
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
                <td class="td_left">Asal Sampling</td>
                <td class="td_right"><b><?php echo $sampel[0]['ASAL_SAMPEL'];?></b></td>
                <td width="10"></td>
                <td class="td_left">Tujuan Sampling</td>
                <td class="td_right"><b><?php echo $sampel[0]['TUJUAN_SAMPLING']; ?></b></td>
              </tr>
              <tr>
                <td class="td_left" colspan="5"><div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:5px;">
                    <p><b>Keterangan :</b></p>
                    <p>Jika terjadi kesalahan dalam entri kategori sampel, untuk memperbaiki atau mengedit kategori tersebut silahkan <a href="javascript:void(0);" class="rep-kategori" id="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" url="<?php echo site_url(); ?>/get/pengujian/get_kategori" data-prioritas = "<?php echo $sampel[0]['PRIORITAS']; ?>">KLIK DISINI</a></p>
                  </div></td>
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
        
        <?php if($data_asal > 0){ ?>
        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">INFORMASI BALAI ASAL</a></div>
        <div class="collapse">
          <div class="accCntnt">          	
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
          </div>
        </div>
        <?php } ?>

        <div style="height:5px;">&nbsp;</div>
        <div class="expand"><a title="expand/collapse" href="#" style="display: block;">PARAMETER UJI</a></div>
        <div class="collapse">
			<?php if($sampel[0]['KOMODITI'] == "01"){ ?>
					<script>
						
						var myRs = new Array();
						var myDK = new Array();
						var myArr = new Array();
						var myCnt = new Array();
						var Cnt;
						var myChk = new Array();
							<?php foreach($param['val'] as $key => $value){ ?>
								myRs['<?= $key; ?>'] = new Array();
								myDK['<?= $key; ?>'] = '<?= $value; ?>';
								myArr['<?= $key; ?>'] = new Array();
								Cnt = 0;
								<?php foreach($param[$key] as $key2 => $value2){ ?>
									myRs['<?= $key; ?>']['<?= $key2; ?>'] = [];
									myArr['<?= $key; ?>']['<?= $key2; ?>'] = '<?= $value2; ?>';
									Cnt++;
								<?php } ?>
								<?php
									if($sampel[0]['KAT'] == '0106'){#Start Alur D2
								?>
									myRs[0] = new Array();
									myRs[0][16] = [];
									myRs[0][17] = [];
									myRs[0][18] = [];
									myRs[0][19] = [];
								<?php 
									}
								?>
								myCnt['<?= $key; ?>'] = new Array();
								myCnt['<?= $key; ?>']['jum'] = Cnt;
								myCnt['<?= $key; ?>']['count'] = 0;
								myChk['<?= $key; ?>'] = [];
							<?php } ?>
							
						
						$(document).ready(function(e){
							
							if('<?= $param['val']['0'] ?>' == '-' && '<?= $sampel[0]['KAT']; ?>' != '0106'){
								var val = '0';
								var text = '';
								for(var val2 in myArr[val]){
									text += '<tr><td><input type="hidden" id="parameter-'+val+'-'+val2+'" value="'+ val2 +'">' + myArr[val][val2]+'</td>';
									text += '<td><input type="text" id="metode-'+val+'-'+val2+'" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/'+val2+'/'+val+'"></td>'; 
									text += '<td><input type="text" id="syarat-'+val+'-'+val2+'" readonly></td>';
									text += '<td><input type="text" id="pustaka-'+val+'-'+val2+'" readonly></td>';
									text += '<td><input type="hidden" id="golongan-'+val+'-'+val2+'"><input type="hidden" id="bidang_uji-'+val+'-'+val2+'"><input type="hidden" id="kategori_pu-'+val+'-'+val2+'"><input type="button" value="+" onclick="chkplus('+val+', '+val2+');"></td></tr>';
									//text += '<td width="75"><input type="button" value="Tambahkan" onclick="lstuji('+val+', '+val2+');"></td></tr>';
								}
								text += '';
								
								document.getElementById("uji").innerHTML = text;
								
								for(var val2 in myArr[val]){
									$("#metode-"+val+"-"+val2).autocomplete($("#metode-"+val+"-"+val2).attr('url'), {width: 244, selectFirst: false}); 
									$("#metode-"+val+"-"+val2).result(function(event, data, formatted){
										if(data){
											$(this).val(data[5]);
											$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
											$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
											$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
											$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
											$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
											//$(this).attr("readonly","readonly");
										}
									});
								}
								
							}
						});
						var chkexist = "";
						
						function chkuji(){
							//$("#k_khusus > tbody").html("");	
							$('#body-paramater').html('');				
							var val = $('#ujian').val();
							var text = '';
							for(var val2 in myArr[val]){
								
								text += '<tr><td><input type="hidden" id="parameter-'+val+'-'+val2+'" value="'+ val2 +'">' + myArr[val][val2]+'</td>';
								text += '<td><input type="text" id="metode-'+val+'-'+val2+'" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/'+val2+'/'+val+'"></td>';
								text += '<td><input type="text" id="syarat-'+val+'-'+val2+'" readonly></td>';
								text += '<td><input type="text" id="pustaka-'+val+'-'+val2+'" readonly></td>';
								text += '<td><input type="hidden" id="golongan-'+val+'-'+val2+'"><input type="hidden" id="bidang_uji-'+val+'-'+val2+'"><input type="hidden" id="kategori_pu-'+val+'-'+val2+'"><input type="button" value="+" onclick="chkplus('+val+', '+val2+');"></td></tr>';
								//text += '<td width="75"><input type="button" value="Tambahkan" onclick="lstuji('+val+', '+val2+');"></td></tr>';
							}
							text += '';
							document.getElementById("uji").innerHTML = text;
							for(var val2 in myArr[val]){
								resetStr(val, val2);
								$("#metode-"+val+"-"+val2).autocomplete($("#metode-"+val+"-"+val2).attr('url'), {width: 244, selectFirst: false}); 
								$("#metode-"+val+"-"+val2).result(function(event, data, formatted){
									if(data){
										$(this).val(data[5]);
										$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
										$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
										$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
										$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
										$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
										//$(this).attr("readonly","readonly");
									} 
								});
							}
							//$('#uji').append(text);
							
						}
						
						function chkplus(val, val2){		
							
							
							var text2 = '';
							//alert('asd');
							//return false;
							//alert(myRs[val][val2]);
							//return false;					
							var ko = myRs[val][val2].indexOf($("#metode-"+val+"-"+val2).val());
							if($("#syarat-"+val+"-"+val2).val() == ""){
								jAlert('Mohon pilih data dari autocomplete', 'SIPT Versi 1.0');
								return false;
							}
							//console.log(myRs);
							if(ko != "-1"){
								jAlert('Data yang sama sudah pernah di tambahkan', 'SIPT Versi 1.0');
								return false;
							}
							myRs[val][val2].push($("#metode-"+val+"-"+val2).val());
							var ki = myChk[val].indexOf(val2);
							if(myCnt[val]['count'] == "0"){
								$('#btn_proses').hide();
							}
							if(ki == "-1"){
								<?php
								if($sampel[0]['KAT'] != '0106'){#Start Alur D2
								?>
									myCnt[val]['count']++;
								<?php
								}else{
								?>
									if(val2 != "19" && val2 != "18"){
										myCnt[val]['count']++;
									}
								<?php 
								}
								?>
								
								if(myCnt[val]['count'] == myCnt[val]['jum']){
									$('#btn_proses').show();
								}
							}
							var btnhps = '';
							if(val2=="18" || val2=="19")
								btnhps = '<span style="float:right;" ><a href="javasript:void(0);"><img src="<?php echo base_url(); ?>images/cancel.png" align="top" style="border:none" id="<?php echo rand(); ?>|'+val2+'" title="Hapus Parameter Uji" onclick="hpstr($(this),'+val+','+val2+');" /></a></span>';

							myChk[val].push(val2);
							
							text2 += '<tr>';
							text2 += '<td><input type="hidden" name="UJI[KETENTUAN_KHUSUS][]" value="'+val+'">'+myDK[val]; +'</td>';
							text2 += '<td><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+myArr[val][val2]+'"><input type="hidden" name="idk[]" value="'+val+'-'+val2+'">'+myArr[val][val2]+'</td>';
							text2 += '<td><input type="hidden" name="UJI[METODE][]" value="'+$("#metode-"+val+"-"+val2).val()+'">'+$("#metode-"+val+"-"+val2).val()+'</td>';
							text2 += '<td><input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat-"+val+"-"+val2).val()+'">'+$("#syarat-"+val+"-"+val2).val()+'</td>';
							text2 += '<td><input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka-"+val+"-"+val2).val()+'">'+$("#pustaka-"+val+"-"+val2).val()+'<input type="hidden" name="UJI[GOLONGAN][]" value="'+$("#golongan-"+val+"-"+val2).val()+'"><input type="hidden" name="UJI[JENIS_UJI][]" value="'+$("#bidang_uji-"+val+"-"+val2).val()+'"> '+btnhps+'</td>';
							<?php
							if($sampel[0]['KAT'] != '0106'){#Start Alur D2
							?>
								text2 += '<td> <input type="checkbox" class="justifikasi" name="chkdt['+val+'-'+val2+']" value=1 checked onchange="justifikasi(); return false;">&nbsp;Diuji</td>';
							<?php
							}
							?>
							text2 += '</tr>';
							$('#body-paramater').append(text2);
						}

						function hpstr(e,val,val2){
							var ko = myRs[val][val2].indexOf($("#metode-"+val+"-"+val2).val());
							
							var span = $(e);							
							var tr = span.parent().parent().parent();
							
							jConfirm('Anda yakin akan menghapus data paramter uji terpilih ?', 'SIPT Versi 1.0', function(r){
								if(r==true){
									$(e).closest('tr').remove(); 
									//alert(myRs[val][val2][ko]);
									myRs[val][val2].splice(ko, 1);
									//myRs[0].splice(kduji, 1);
									//console.log(myRs[0]);
								}else{
									return false;
								}
							   });    					
						}

						function resetStr(val,val2){
							var ko = myRs[val][val2].indexOf($("#metode-"+val+"-"+val2).val());
							myRs[val][val2].splice(ko, 1);
						}
						
						function lstuji(){
							var val = $('#ujian').val();
							if(val == "" && '<?= $param['val']['0'] ?>' == '-') val = '0';
							else if(val == "" && ($('#ckpdown').val() == "2" || $('#ckpdown').val() == "1")) val = 'new';
							var text2 = '';
							var ichk = "0";
							var ochk = "0";
							if($("#chkex-"+val+"").val() != "" && $("#chkex-"+val+"").val() != undefined){
								//alert($("#chkex-"+val+"").val() );
								alert('Data Dengan Ketentuan Khusus yang sama Pernah Ditambahkan');
								return false;
							}else{
								myRs[val] = new Array();
								for(var val2 in myArr[val]){
									
									myRs[val][val2] = [];
									if($("#metode-"+val+"-"+val2).val() == "" || $("#syarat-"+val+"-"+val2).val() == "" || $("#pustaka-"+val+"-"+val2).val() == ""){
										if(ichk == "0"){
											alert('Mohon diperiksa kembali untuk isian Metode, Syarat dan Pustaka tidak boleh kosong');
											ichk = "1";
											return false;
										}
									}else{
										text2 += '<tr>';
										if(ochk == "1"){
											text2 += '<td><input type="hidden" name="UJI[KETENTUAN_KHUSUS][]" value="'+val+'">'+myDK[val]; +'</td>';
										}else{
											text2 += '<td><input type="hidden" id="chkex-'+val+'" value="'+val+'"><input type="hidden" name="UJI[KETENTUAN_KHUSUS][]" value="'+val+'">'+myDK[val]; +'</td>';
										}
										text2 += '<td><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+myArr[val][val2]+'"><input type="hidden" name="idk[]" value="'+val+'-'+val2+'">'+myArr[val][val2]+'</td>';
										text2 += '<td><input type="hidden" name="UJI[METODE][]" value="'+$("#metode-"+val+"-"+val2).val()+'">'+$("#metode-"+val+"-"+val2).val()+'</td>';
										text2 += '<td><input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat-"+val+"-"+val2).val()+'">'+$("#syarat-"+val+"-"+val2).val()+'</td>';
										text2 += '<td><input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka-"+val+"-"+val2).val()+'">'+$("#pustaka-"+val+"-"+val2).val()+'</td>';
										text2 += '<td> <input type="checkbox" class="justifikasi" name="chkdt['+val+'-'+val2+']" value=1 checked onchange="justifikasi(); return false;">&nbsp;Diuji</td>';
										text2 += '</tr>';
										myRs[val][val2].push($("#metode-"+val+"-"+val2).val()+"-"+$("#syarat-"+val+"-"+val2).val()+"-"+$("#pustaka-"+val+"-"+val2).val());
										//alert(print_r(myRs[val][val2]));
										ochk = "1";
									}
								}
							}
							$('#body-paramater').append(text2);
						}
						
						function lstuji2(){
							
							var text2 = '';			
							//var ock = '0';			
							if($("#metode").val() == "" || $("#syarat").val() == "" || $("#pustaka").val() == ""){
								if(ichk == "0"){
									alert('Mohon diperiksa kembali untuk isian Metode, Syarat dan Pustaka tidak boleh kosong');
									ichk = "1";
									return false;
								}
							}else{
								text2 += '<tr>';
								//if(ochk == "1"){
								//	text2 += '<td><input type="hidden" name="UJI[KETENTUAN_KHUSUS][]" value="-">-</td>';
								//}else{
								//	
								//}
								text2 += '<td><input type="hidden" id="chkex--" value="-"><input type="hidden" name="UJI[KETENTUAN_KHUSUS][]" value="-">-</td>';
								text2 += '<td><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+$("#parameter").val()+'"><input type="hidden" name="idk[]" value="--'+$("#srlid").val()+'">'+$("#parameter").val()+'</td>';
								text2 += '<td><input type="hidden" name="UJI[METODE][]" value="'+$("#metode").val()+'">'+$("#metode").val()+'</td>';
								text2 += '<td><input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat").val()+'">'+$("#syarat").val()+'</td>';
								text2 += '<td><input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka").val()+'">'+$("#pustaka").val()+'</td>';
								text2 += '<td> <input type="checkbox" class="justifikasi" name="chkdt[--'+$("#srlid").val()+']" value=1 checked onchange="justifikasi(); return false;"></td>';
								text2 += '</tr>';
								//ochk = "1";
							}
							$('#body-paramater').append(text2);
							clearForm("#tbparamater");
						}
						
						function chkckp(){
							if($('#ckpup').val() == "1"){
								$('.chkdown').show();
								$(".default").show();
								$(".catatan-justifikasi").hide();
								$('#ckpdown').attr('rel','required');
							}else{
								$("#tglspk").removeAttr("rel");
								$("#acpenyelia").removeAttr("rel");
								$("#btn_prosesx").css("display","");
								$("#btn_proses").css("display","none");
								$(".frm_spk").attr("id","fnewspk");
								$(".frm_spk").attr("name","fnewspk");
								$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/surveilance");
								$('.chkdown').hide();
								$('#ckpdown').removeAttr('rel');
								$(".default").hide();
								$(".catatan-justifikasi").show();
							}
						}
						function chkckp2(){
							
							var text = '';
							if($('#ckpdown').val() == "1"){	
								myDK['0'] = '-';
								myArr['0'] = new Array();
								myArr['0']['16'] = 'Identifikasi';
								myArr['0']['17'] = 'Penetapan Kadar';
								myArr['0']['18'] = 'Keragaman Bobot';
								myArr['0']['19'] = 'Keseragaman Kandungan';
								myCnt['0'] = new Array();
								myCnt['0']['jum'] = 2;
								myCnt['0']['count'] = 0;
								myChk['0'] = [];
								
								text += '<tr><td><input type="hidden" id="parameter-0-16" value="16">Identifikasi</td>';
								text += '<td><input type="text" value="" id="metode-0-16" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/16/0"></td>';
								text += '<td><input type="text" value="" id="syarat-0-16" readonly></td>';
								text += '<td><input type="text" value="" id="pustaka-0-16" readonly></td>';
								text += '<td><input type="hidden" id="golongan-0-16"><input type="hidden" id="bidang_uji-0-16"><input type="hidden" id="kategori_pu-0-16"><input type="button" value="+" onclick="chkplus(\'0\', \'16\');"></td></tr>';
								
								text += '<tr><td><input type="hidden" id="parameter-0-17" value="17">Penetapan Kadar</td>';
								text += '<td><input type="text" value="" id="metode-0-17" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/17/0"></td>';
								text += '<td><input type="text" value="" id="syarat-0-17" readonly></td>';
								text += '<td><input type="text" value="" id="pustaka-0-17" readonly></td>';
								text += '<td><input type="hidden" id="golongan-0-17"><input type="hidden" id="bidang_uji-0-17"><input type="hidden" id="kategori_pu-0-17"><input type="button" value="+" onclick="chkplus(\'0\', \'17\');"></td></tr>';
								
								text += '<tr class="nyumput" style="display:none;"><td><input type="hidden" id="parameter-0-18" value="18">Keragaman Bobot</td>';
								text += '<td><input type="text" value="" id="metode-0-18" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/18/0"></td>';
								text += '<td><input type="text" value="" id="syarat-0-18" readonly></td>';
								text += '<td><input type="text" value="" id="pustaka-0-18" readonly></td>';
								text += '<td><input type="hidden" id="golongan-0-18"><input type="hidden" id="bidang_uji-0-18"><input type="hidden" id="kategori_pu-0-18"><input type="button" value="+" onclick="chkplus(\'0\', \'18\');"></td></tr>';
								
								text += '<tr class="nyumput" style="display:none;"><td><input type="hidden" id="parameter-0-19" value="19">Keseragaman Kandungan</td>';
								text += '<td><input type="text" value="" id="metode-0-19" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/19/0"></td>';
								text += '<td><input type="text" value="" id="syarat-0-19" readonly></td>';
								text += '<td><input type="text" value="" id="pustaka-0-19" readonly></td>';
								text += '<td><input type="hidden" id="golongan-0-19"><input type="hidden" id="bidang_uji-0-19"><input type="hidden" id="kategori_pu-0-19"><input type="button" value="+" onclick="chkplus(\'0\', \'19\');"></td></tr>';
								text += '';
								$("#tglspk").attr("rel","required");
								$("#acpenyelia").attr("rel","required");
								$("#btn_prosesx").css("display","none");
								$("#btn_proses").css("display","");
								$(".frm_spk").attr("id","fspk");
								$(".frm_spk").attr("name","fspk");
								$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/save");
								$(".default").show();
								document.getElementById("uji").innerHTML = text;
								
								$("#metode-0-17").autocomplete($("#metode-0-17").attr('url'), {width: 244, selectFirst: false}); 
									$("#metode-0-17").result(function(event, data, formatted){
										if(data){
											$(this).val(data[5]);
											$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
											$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
											$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
											$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
											$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
											
										}
									});
								
									$("#metode-0-16").autocomplete($("#metode-0-16").attr('url'), {width: 244, selectFirst: false}); 
									$("#metode-0-16").result(function(event, data, formatted){
										if(data){
											$(this).val(data[5]);
											$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
											$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
											$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
											$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
											$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
											
										}
									});
									
									$("#metode-0-18").autocomplete($("#metode-0-18").attr('url'), {width: 244, selectFirst: false}); 
									$("#metode-0-18").result(function(event, data, formatted){
										if(data){
											$(this).val(data[5]);
											$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
											$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
											$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
											$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
											$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
											
										}
									});
									
									$("#metode-0-19").autocomplete($("#metode-0-19").attr('url'), {width: 244, selectFirst: false}); 
									$("#metode-0-19").result(function(event, data, formatted){
										if(data){
											$(this).val(data[5]);
											$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
											$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
											$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
											$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
											$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
											
										}
									});
								$(".catatan-justifikasi").hide();
								$(".btn-parameter-d2").show();
							}else if($('#ckpdown').val() == "2"){
								myDK['0'] = '-';
								myArr['0'] = new Array();
								myArr['0']['16'] = 'Identifikasi';
								myCnt['0'] = new Array();
								myCnt['0']['jum'] = 1;
								myCnt['0']['count'] = 0;
								myChk['0'] = [];
								text += '<tr><td><input type="hidden" id="parameter-0-16" value="16">Identifikasi</td>';
								text += '<td><input type="text" value="" id="metode-0-16" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_metode_puk/<?= $sampel[0]['GOLONGAN']; ?>/16/0"></td>';
								text += '<td><input type="text" value="" id="syarat-0-16" readonly></td>';
								text += '<td><input type="text" value="" id="pustaka-0-16" readonly></td>';
								text += '<td><input type="hidden" id="golongan-0-16"><input type="hidden" id="bidang_uji-0-16"><input type="hidden" id="kategori_pu-0-16"><input type="button" value="+" onclick="chkplus(\'0\', \'16\');"></td></tr>';
								text += '';
								$("#tglspk").attr("rel","required");
								$("#acpenyelia").attr("rel","required");
								$("#btn_prosesx").css("display","none");
								$("#btn_proses").css("display","");
								$(".frm_spk").attr("id","fspk");
								$(".frm_spk").attr("name","fspk");
								$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/save");
								$(".default").show();
								document.getElementById("uji").innerHTML = text;
								
								
								$("#metode-0-16").autocomplete($("#metode-0-16").attr('url'), {width: 244, selectFirst: false}); 
								$("#metode-0-16").result(function(event, data, formatted){
									if(data){
										$(this).val(data[5]);
										$("#syarat-"+data[8]+"-"+data[7]).val(data[6]);
										$("#pustaka-"+data[8]+"-"+data[7]).val(data[4]);
										$("#golongan-"+data[8]+"-"+data[7]).val(data[3]);
										$("#bidang_uji-"+data[8]+"-"+data[7]).val(data[2]);
										$("#kategori_pu-"+data[8]+"-"+data[7]).val(data[8]);
										
									}
								});
								$(".catatan-justifikasi").hide();
								$(".btn-parameter-d2").hide();
							}else{
								
								$("#tglspk").removeAttr("rel");
								$("#acpenyelia").removeAttr("rel");
								$("#btn_prosesx").css("display","");
								$("#btn_proses").css("display","none");
								$(".frm_spk").attr("id","fnewspk");
								$(".frm_spk").attr("name","fnewspk");
								$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/surveilance");
								$(".default").hide();
								//$(".catatan-justifikasi").hide();
								$(".btn-parameter-d2").hide();
								$(".catatan-justifikasi").show();
								//alert('asdadasd');
							}
							//document.getElementById("uji").innerHTML = text;
							
						}
						
					</script>
					<div class="accCntnt">
						<h2 class="small garis">Informasi Tanggal Surat Perintah Kerja</h2>
						<table class="form_tabel">
						<?php
						if($sampel[0]['KAT'] == '0106'){#Start Alur D2
						?>
							<tr>
								<td class="td_left bold">Sampel Cukup </td>
								<td class="td_right">
									<select id="ckpup" rel="required" onchange="chkckp();" class="stext" style="width:75px;" title="Sampel cukup atau tidak" name="CUKUP">
										<option value=""></option>
										<option value="1">Ya</option>
										<option value="2">Tidak</option>
									</select>
								</td>
							</tr>
							<tr class="chkdown" style="display:none;">
								<td class="td_left bold"></td>
								<td class="td_right">
									<select id="ckpdown" rel="required"  onchange="chkckp2();" class="stext" title="Opsi jika sampel cukup" name="OPSI_D2">
										<option value=""></option>
										<option value="1">Metode Analisis ada dan Baku Pembanding ada</option>
										<option value="2">Metode Analisis ada dan Baku Pembanding tidak ada</option>
										<option value="0">Tidak ada Metode Analisis dan Baku Pembanding</option>
									</select>
								</td>
							</tr>
						<?php
						}
						?>
						<tr class="default">
							<td class="td_left bold">Tanggal Surat Perintah Kerja</td>
							<td class="td_right"><input type="text" class="sdatespk" id="tglspk" rel="required" title="Tanggal Surat Perintah Keja" name="TANGGAL" readonly/></td>
						</tr>
						<tr class="default">
							<td class="td_left bold">Nama Penyelia</td>
							<td class="td_right"><input type="text" class="stext operator" title="Penyelia Penerima SPK" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>" id="acpenyelia" rel="required"/>
							<input type="hidden" id="penyelia" name="KASIE" />
							<input type="hidden" name="spuid" value="<?php echo $sampel[0]['SPU_ID']; ?>" />
							<input type="hidden" name="kode_sampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
							<input type="hidden" name="komoditi" value="<?php echo $sampel[0]['KOMODITI']; ?>" /></td>
						</tr>
						</table>
						<h2 class="small garis default">Penetuan Parameter Uji</h2>
						<?php
							if($sampel[0]['KAT'] != '0106'){#Start Alur D2
							?>
						<table class="listtemuan default" width="100%" border=0>
						<tr>
							<th width="275" colspan=2>Ketentuan Khusus &nbsp; &nbsp; &nbsp; &nbsp; 
							<select onchange="chkuji();" id="ujian" class="stext" title="Pilih ketentuan Khusus">
								<option></option>
							<?php foreach($param['val'] as $key => $value){ ?>
								<option value="<?= $key; ?>"><?= $value ?></option>
							<?php } ?>
							</select>
							 <!--&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type="button" value="Tambahkan" onclick="lstuji();">-->
							</th>
							
						</tr>
						</table>
						<?php
							}
							else
							{
								?>
								<div style="height: 5px;"></div>
								<div class="btn btn-parameter-d2" style="display: none;"><span><a href="javascript:void(0);" id="add-parameterd2">Klik Disini Untuk Menambah Parameter Uji Lainnya</a></span></div>
								<div style="height: 5px;"></div>								
								<?php
							}
						?>
						<table class="listtemuan default" width="100%" border=0>
							<thead>
							<tr>
								<th width="40">Parameter Uji</th>
								<th width="75">Metode</th>
								<th width="75">Syarat</th>
								<th width="75">Pustaka</th>
								<th width="75"></th>
							</tr>
							</thead>
						
						<tbody id="uji">
						</tbody>
						</table>
						<!--<br>
						<table class="form_tabel default" id="tbparamater">
						<tr>
							<td class="td_left">Parameter Uji</td>
							<td class="td_right" style="width:300px;"><input type="text" class="stext paramuji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $sampel[0]['KATEGORI']; ?>/<?php echo $sampel[0]['PRIORITAS']; ?>" title="Parameter Uji" id="parameter" />
							
							<input type="hidden" id="srlid" value="" />
							<input type="hidden" id="biduji" />
							<input type="hidden" id="golongan" />
							<input type="hidden" id="kategori_pu" />
							<input type="hidden" id="simulan" />
							<input type="hidden" id="kodesampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
							<input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" /></td>
							<td></td>
							<td class="td_left">Metode</td>
							<td class="td_right" style="width:300px;"><input type="text" class="stext" title="Metode" readonly id="metode" /></td>
						</tr>
						<tr>
							<td class="td_left">Pustaka</td>
							<td class="td_right"><input type="text" class="stext" title="Pustaka" readonly id="pustaka" /></td>
							<td></td>
							<td class="td_left">Syarat</td>
							<td class="td_right"><input type="text" class="stext" title="Syarat" readonly id="syarat" /></td>
						</tr>
						<tr>
							<td class="td_left"><input type="button" value="Tambahkan" onclick="lstuji2();"></td>
							<td class="td_right" colspan="4"></td>
						</tr>
						</table>-->
						<h2 class="small garis default">Daftar Penentuan Parameter Hasil Uji</h2>
						<table class="listtemuan default" id="k_khusus" width="100%">
						<thead>
							<tr>
							<th width="200">Ketentuan Khusus</th>
							<th width="75">Parameter Uji</th>
							<th width="75">Metode</th>
							<th width="75">Syarat</th>
							<th width="100">Pustaka</th>
							<?php
							if($sampel[0]['KAT'] != '0106'){#Start Alur D2
							?>
							<th width="100">Diuji</th>
							<?php } ?>
							</tr>
						</thead>
						<tbody  id="body-paramater">
						</tbody>
						</table>
                        <div style="height:5px;">&nbsp;</div>
						<?php
						if($sampel[0]['KAT'] != '0106'){#Start Alur D2
						?>
						<table class="form_tabel default">
						
						<tr>
                          <td class="td_left bold" colspan=2><div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:5px;"><b>Jika kolom diuji tidak diceklist, maka:</b><br>1. Parameter tersebut dinyatakan tidak dapat diuji dan petugas wajib menyertakan justifikasi mengapa parameter tersebut tidak diuji
						  <br>2. Data akan terkirim ke Ditwas Produksi PT dan PKRT untuk mendapat verifikasi revisi/persetujuan parameter uji</div></td>
                        </tr>
						</table>
                        <table class="form_tabel catatan-justifikasi default">
						
						
						<tr>
                          <td class="td_left bold" colspan=2>Catatan Justifikasi</td>
                          <td class="td_right"><textarea class="stext catatan" name="JUSTIFIKASI" title="Catatan justifikasi"></textarea></td>
                        </tr>
						
						
                        
                        </table>
						<?php }else{ ?>
							<table class="form_tabel catatan-justifikasi default">
						
						
						<tr>
                          <td class="td_left bold" colspan=2>Catatan Justifikasi</td>
                          <td class="td_right"><textarea class="stext catatan" name="JUSTIFIKASI" title="Catatan justifikasi"></textarea></td>
                        </tr>
						
						
                        
                        </table>
						<?php } ?>
					</div>
				<?php }else{?>
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
                <td class="td_right"><input type="text" class="sdatespk" rel="required" title="Tanggal Surat Perintah Keja" name="TANGGAL" readonly/></td>
              </tr>
              <tr>
                <td class="td_left bold">Nama Penyelia</td>
                <td class="td_right"><input type="text" class="stext operator" title="Penyelia Penerima SPK" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_petugas_pengujian/3/<?php echo $sampel[0]['SPU_ID']; ?>" id="acpenyelia" rel="required"/>
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
                <td class="td_right" style="width:300px;"><input type="text" class="stext paramuji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $sampel[0]['KATEGORI']; ?>/<?php echo $sampel[0]['PRIORITAS']; ?>" title="Parameter Uji" id="parameter" />
                 <?php
				 if($sampel[0]['PRIORITAS'] == "1"){
					 ?>
                     &nbsp;<a href="javascript:void(0);" id="m_prioritas" url="<?php echo site_url(); ?>/load/master/list_prioritas/<?php echo $sampel[0]['KATEGORI']; ?>/<?php echo $sampel[0]['PRIORITAS']; ?>" onclick="PopupCenter('#m_prioritas'); return false;" judul="Master Data Prioritas" lebar="900" tinggi="480"><br>Untuk pencarian KLIK DISNI</a>&nbsp;
                     <!--<img src="<?php echo base_url(); ?>images/info.png" align="top" title="Tampilkan data prioritas sampling" style="border:none;" />-->
					 <?php
				 }
				 ?>
                  <input type="hidden" id="srlid" value="" />
                  <input type="hidden" id="biduji" />
                  <input type="hidden" id="golongan" />
                  <input type="hidden" id="kategori_pu" />
                  <input type="hidden" id="simulan" />
                  <input type="hidden" id="kodesampel" value="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" />
                  <input type="hidden" name="jenis_uji" value="<?php echo $jenis_uji; ?>" /></td>
                <td></td>
                <td class="td_left">Metode</td>
                <td class="td_right" style="width:300px;"><input type="text" class="stext" title="Metode" readonly id="metode" /></td>
              </tr>
              <tr>
                <td class="td_left">Pustaka</td>
                <td class="td_right"><input type="text" class="stext" title="Pustaka" readonly id="pustaka" /></td>
                <td></td>
                <td class="td_left">Syarat</td>
                <td class="td_right"><input type="text" class="stext" title="Syarat" readonly id="syarat" /></td>
              </tr>
              <tr>
                <td class="td_left">Ruang Lingkup</td>
                <td class="td_right" colspan="4"><input type="text" id="rlingkup" class="stext" title="Ruang Lingkup" readonly /></td>
              </tr>
            </table>
            <div style="height:5px;"></div>
            <div class="btn"><span><a href="javascript:void(0);" id="addparameter">Klik Disini Untuk Menambah Parameter Uji</a></span></div>
            <h2 class="small garis">Daftar Penetuan Parameter Hasil Uji</h2>
            <table class="listtemuan" width="100%" id="draft-parameter">
              <thead>
                <tr>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="90">Pustaka</th>
                  <th width="75">Syarat</th>
                  <th width="75">Ruang Lingkup</th>
                  <th width="200">Penyelia</th>
                  <th width="75">Opsi</th>
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
			<?php } ?>
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
    <a href="#" id="btn_proses" class="button check" onclick="fpost('#fspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>
    <a href="#" id="btn_prosesx" style="display:none;" class="button check" onclick="fpost('#fnewspk','',''); return false;"><span><span class="icon"></span>&nbsp; Proses &nbsp;</span></a>
    <?php
  }?>
    &nbsp;<a href="#" class="button reload" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Batal &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-kategori-edit"></div>
<div id="ctn-master-prioritas"></div>
<script>

	function justifikasi(){
		var numberOfChecked = $('tbody#body-paramater input:checkbox:checked').length;
		var totalCheckboxes = $('tbody#body-paramater input:checkbox').length;
		if(numberOfChecked < totalCheckboxes)
		{
			$(".catatan-justifikasi").css("display","");
		}
		else
		{
			$(".catatan-justifikasi").css("display","none");
		}
		return false;
	}
	
	$(document).ready(function(e){
		
		$("#chksurveilance").change(function(e) {
            var $this = $(this);
			if($this.is(":checked"))
			{
				$("#tglspk").removeAttr("rel");
				$("#acpenyelia").removeAttr("rel");
				$("#btn_prosesx").css("display","");
				$("#btn_proses").css("display","none");
				$(".frm_spk").attr("id","fnewspk");
				$(".frm_spk").attr("name","fnewspk");
				$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/surveilance");
			}
			else
			{
				$("#tglspk").attr("rel","required");
				$("#acpenyelia").attr("rel","required");
				$("#btn_prosesx").css("display","none");
				$("#btn_proses").css("display","");
				$(".frm_spk").attr("id","fspk");
				$(".frm_spk").attr("name","fspk");
				$(".frm_spk").attr("action","<?= site_url(); ?>/post/spk/spk_act/save");
			}
			return false;
        });
		
		$(".catatan-justifikasi").css("display","none");
		$('input.sdate').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', maxDate: new Date()});

		var tgl = new Date();
  		var tahunskrng = tgl.getFullYear();    		
		$('input.sdatespk').datepicker({ dateFormat: 'dd/mm/yy',regional: 'id', minDate: new Date(tahunskrng, 01 - 1, 1), maxDate: new Date()});

		$("#parameter").autocomplete($("#parameter").attr('url'), {width: 244, selectFirst: false});
		$("#parameter").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#metode").val(data[3] == '' ? '-' : data[3]);
				$("#pustaka").val(data[4] == '' ? '-' : data[4]);
				$("#syarat").val(data[5] == '' ? '-' : data[5]);
				$("#rlingkup").val(data[6] == '' ? '-' : data[6]);
				$("#biduji").val(data[7]);
				$("#golongan").val(data[8]);
				$("#srlid").val(data[10]);
				$("#kategori_pu").val(data[11]);
				$("#simulan").val(data[12]);
			}
		});
		$("#acpenyelia").autocomplete($("#acpenyelia").attr('url'), {width: 244, selectFirst: false});
		$("#acpenyelia").result(function(event, data, formatted){
			if(data){
				$(this).val(data[2]);
				$("#penyelia").val(data[1]);
				$(this).attr("readonly","readonly");
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
			if(!beforeSubmit("#draft-parameter")){
				return false;
			}else{
				if($("#penyelia").val()==""){
					jAlert('Maaf, Anda belum memilih penyelia.', 'SIPT Versi 1.0');
					$("#acpenyelia").focus();
					return false;
				}
				if($("#parameter").val()==""){
					jAlert('Maaf, Kolom parameter uji tidak boleh kosong.', 'SIPT Versi 1.0');
					$("#acpenyelia").focus();
					return false;
				}
				if($("#acpenyelia").val()==""){
					jAlert('Maaf, Anda belum memilih penyelia.', 'SIPT Versi 1.0');
					$("#acpenyelia").focus();
					return false;
				}
				if($("#srlid").val()==""){
					jAlert('Maaf, Parameter Uji Berikut : \n <b>'+$("#parameter").val()+'</b> \n Tidak terdaftar dalam database. \n Untuk menambah data parameter uji baru silahkan masuk di menu \n Master Data &raquo; Standar Ruang Lingkup &raquo; Parameter Uji', 'SIPT Versi 1.0');
					$("#parameter").focus();
					$("#srlid").val('');
					return false;
				}
				var no = $("#body-paramater tr").length;
				var str = '<tr id="baris'+(no+1)+'">';
					str += '<td>'+$("#parameter").val()+'&nbsp;<input type="hidden" name="UJI[GOLONGAN][]" value="'+$("#golongan").val()+'"><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+$("#parameter").val()+'"><input type="hidden" name="UJI[SIMULAN][]" value="'+$("#simulan").val()+'"><input type="hidden" name="UJI[KATEGORI_PU][]" value="'+$("#kategori_pu").val()+'"></td>';
					str += '<td>'+$("#metode").val()+'&nbsp;<input type="hidden" name="UJI[METODE][]" value="'+$("#metode").val()+'"></td>';
					str += '<td>'+$("#pustaka").val()+'&nbsp;<input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka").val()+'"></td>';
					str += '<td>'+$("#syarat").val()+'&nbsp;<input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat").val()+'"></td>';
					str += '<td>'+$("#rlingkup").val()+'&nbsp;<input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+$("#rlingkup").val()+'"></td>';
					str += '<td>'+$("#acpenyelia").val()+'&nbsp;<input type="hidden" name="UJI[PENYELIA][]" value="'+$("#penyelia").val()+'"></td>';
					str += '<td><a href="#" class="hapusparams">Hapus</a></td>';
					str += '</tr>';
					$("#body-paramater").append(str);
					clearForm("#tbparamater");
					$(".hapusparams").live("click", function(){
						var idke = $(this).closest("tr").attr("id");
						$("#"+idke).remove();
						return false;
					});
				$("#srlid").val('');	
			}
			return false;
		});
		$(".rep-kategori").click(function(){
			$.get($(this).attr("url") + "/" + $(this).attr("id") + "/" + $(this).attr("data-prioritas"), function(data){
				$("#ctn-kategori-edit").html(data); 
				$("#ctn-kategori-edit").dialog({ 
					title: 'Edit Kategori Sampel', 
					height: 400, 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
		});		
		$(".btn-parameter-d2").click(function(){
			if($(".nyumput").length > 0)
			{
				$(".nyumput").show();
			}
			return false;
		});
    });
</script>
<?php
}
?>
