<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <form name="fnewparam" id="fnewparam" method="post" autocomplete="off">
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
              <tr>
                <td class="td_left bold" colspan="2">
                <div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:5px;">
                    <p><b>Keterangan :</b></p>
                    <p>Jika terjadi kesalahan dalam menentukan penyelia, untuk memperbaiki atau mengedit penyelia tersebut silahkan <a href="javascript:void(0);" class="rep-penyelia" id="<?php echo $sess['KODE_SAMPEL']; ?>.<?php echo $sess['SPK_ID']; ?>" url="<?php echo site_url(); ?>/get/pengujian/get_penyelia">KLIK DISINI</a></p>
                  </div>
                </td>
              </tr>
            </table>
            <h2 class="small garis">Detail Sampel</h2>
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
                <td class="td_left" colspan="5"><div style="background:#FBE3E4; border:1px solid #FBE3E4; padding:5px;">
                    <p><b>Keterangan :</b></p>
                    <p>Jika terjadi kesalahan dalam entri kategori sampel, untuk memperbaiki atau mengedit kategori tersebut silahkan <a href="javascript:void(0);" class="rep-kategori" id="<?php echo $sampel[0]['KODE_SAMPEL']; ?>" url="<?php echo site_url(); ?>/get/pengujian/get_kategori">KLIK DISINI</a></p>
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
            <h2 class="small garis">Detail Parameter Uji</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th width="5">&nbsp;</th>
                  <th width="200">Parameter Uji</th>
                  <th width="75">Metode</th>
                  <th width="100">Pustaka</th>
                  <th width="75">Syarat</th>
                  <th width="75">Ruang Lingkup</th>
                  <th width="75">Penyelia</th>
                  <th width="75">Penguji</th>
                </tr>
              </thead>
              <tbody id="list-parameter">
                <?php
							  $jml = count($parameter);
							  if($jml > 0){
								  for($i = 0; $i < $jml; $i++){
									?>
                <tr id="<?php echo $parameter[$i]['UJI_ID']; ?>">
                  <td><a href="javascript:void(0);" class="del-parameter" id="<?php echo $parameter[$i]['UJI_ID']; ?>" url="<?php echo site_url(); ?>/get/pengujian/params_act/"><img src="<?php echo base_url(); ?>images/icon-delete.png"></a></td>
                  <td><?php echo $parameter[$i]['PARAMETER_UJI']; ?></td>
                  <td><?php echo $parameter[$i]['METODE']; ?></td>
                  <td><?php echo $parameter[$i]['PUSTAKA']; ?></td>
                  <td><?php echo $parameter[$i]['SYARAT']; ?></td>
                  <td><?php echo $parameter[$i]['RUANG_LINGKUP']; ?></td>
                  <td><?php echo $parameter[$i]['PENYELIA']; ?></td>
                  <td><?php echo $parameter[$i]['UR_PENGUJI'] == "" ? "-" : $parameter[$i]['UR_PENGUJI']; ?></td>
                </tr>
                <?php
								  }
							  }else{
							  ?>
                <tr>
                  <td colspan="8"><b>Data tidak ditemukan</b></td>
                </tr>
                <?php
							  }
							?>
              </tbody>
            </table>
            <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
              <p><b>Keterangan :</b></p>
              <div style="background:#FBE3E4; border:1px solid #ccc; padding:5px;">
                <p>
                  <input type="checkbox" id="chk-parameter">
                  &nbsp;<b>Tambahkan beberapa parameter uji, jika terdapat kekurangan parameter uji yang terlewat. </b></p>
              </div>
            </div>
            <div id="contparameter" style="display:none;">
              <h2 class="small garis">Penetuan Parameter Uji</h2>
              <table class="form_tabel" id="tbparamater">
                <tr>
                  <td class="td_left">Tanggal SPK</td>
                  <td class="td_right"><b><?php echo $sess['TANGGAL_SPK']; ?></b></td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td class="td_left">Nama Penyelia</td>
                  <td class="td_right"><b><?php echo $sess['NAMA_USER']; ?></b></td>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td class="td_left">Parameter Uji</td>
                  <td class="td_right" style="width:300px;"><input type="text" class="stext paramuji" url="<?php echo site_url(); ?>/autocompletes/autocomplete/get_jenis_pengujian/<?php echo $sampel[0]['KATEGORI']; ?>" title="Parameter Uji" id="parameter" />
                    <input type="hidden" id="srlid" />
                    <input type="hidden" id="biduji" />
                    <input type="hidden" id="golongan" />
                    <input type="hidden" id="kodesampel" value="<?php echo $sess['KODE_SAMPEL']; ?>" /></td>
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
                  <td class="td_right"><input type="text" id="rlingkup" class="stext" title="Ruang Lingkup" readonly="readonly" /></td>
                  <td></td>
                  <td class="td_left">Penguji</td>
                  <td class="td_right"><?php echo form_dropdown('arrpenguji',$arrpenguji,'','class="stext" title="Pada proses ini MT bisa menentukan langsung penguji untuk No SPK dan Sampel tersebut di atas" id="penguji"'); ?></td>
                </tr>
              </table>
              <div style="height:5px;"></div>
              <div class="btn"><span><a href="javascript:void(0);" id="addparameter">Klik Disini Untuk Menambah Parameter Uji</a></span></div>
              <h2 class="small garis">Daftar Penetuan Parameter Hasil Uji</h2>
              <table class="listtemuan" width="100%" id="draftnew-parameter">
                <thead>
                  <tr>
                    <th width="200">Parameter Uji</th>
                    <th width="75">Metode</th>
                    <th width="90">Pustaka</th>
                    <th width="75">Syarat</th>
                    <th width="75">Ruang Lingkup</th>
                    <th width="200">Penguji</th>
                    <th width="75">Opsi</th>
                  </tr>
                </thead>
                <tbody id="body-newparamater">
                </tbody>
              </table>
            </div>
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
    <input type="hidden" name="SPK_ID" value="<?php echo $sess['SPK_ID']; ?>" />
    <input type="hidden" name="KASIE" value="<?php echo $sess['KASIE']; ?>" />
    <input type="hidden" name="KODE_SAMPEL" value="<?php echo $sess['KODE_SAMPEL']; ?>" />
    <input type="hidden" name="SPU_ID" value="<?php echo $sess['SPU_ID']; ?>" />
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"> <a id="btn-proses" style="display:none;" href="#" class="button check" onclick="fpost('#fnewparam','',''); return false;"><span><span class="icon"></span>&nbsp; Proses Ulang SPK &nbsp;</span></a> &nbsp;<a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-kategori-edit"></div>
<div id="ctn-penyelia-edit"></div>
<script>
	$(document).ready(function(e){
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
			}
		});
		$("a.del-parameter").live("click", function(){
			var url = $(this).attr("url");
			var idparams = $(this).attr("id");
			var trid = $(this).closest("tr").attr("id");
			jConfirm('Anda yakin akan menghapus data paramter uji terpilih ? \n Harap diperhatikan, bahwa data parameter uji yang telah dihapus tidak bisa dikembalkan lagi.', 'SIPT Versi 1.0', function(r){
				if(r==true){
					$.get(url + idparams, function(hasil){
						if(hasil.search("MSG")>=0){
							arrdata = hasil.split('#');
							if(arrdata[1]=="YES"){
								jAlert('Parameter Uji berhasil di Hapus','SIPT versi 1.0');
								setTimeout(function(){$("#list-parameter tr#"+arrdata[2]).remove();}, 2000);
							}else{
								jAlert('Parameter Uji gagal di Hapus','SIPT versi 1.0');
								return false;
							}
						}else{
							jAlert('Request hapus parameter uji gagal','SIPT versi 1.0');
							return false;
						}
					});
				}else{
					return false;
				}
			});
		});
		$("#chk-parameter").change(function(){
			if($(this).attr("checked")){
				$("#contparameter").fadeIn(500);
				$("#btn-proses").fadeIn(500);
				$("#fnewparam").attr("action", "<?php echo site_url().'/post/ppomn/spk_act/add-params'; ?>");
				$("#fnewparam").attr("method", "post");
				$("#fnewparam").attr("autocomplete","off");
			}else{
				$("#contparameter").fadeOut(500);
				$("#btn-proses").fadeOut(500);
				$("#fnewparam").removeAttr("action");
				$("#fnewparam").removeAttr("method");
				$("#fnewparam").removeAttr("autocomplete");
				clearForm("#tbparamater");
				$("#body-newparamater").empty();
			}
		});
		
		$("#addparameter").live("click", function(){
			if(!beforeSubmit("#draft-parameter")){
				return false;
			}else{
				if($("#parameter").val()==""){
					jAlert('Maaf, Kolom parameter uji tidak boleh kosong.', 'SIPT Versi 1.0');
					$("#acpenyelia").focus();
					return false;
				}
				var no = $("#body-newparamater tr").length;
				var str = '<tr id="baris'+(no+1)+'">';
					str += '<td>'+$("#parameter").val()+'&nbsp;<input type="hidden" name="UJI[GOLONGAN][]" value="'+$("#golongan").val()+'"><input type="hidden" name="UJI[PARAMETER_UJI][]" value="'+$("#parameter").val()+'"></td>';
					str += '<td>'+$("#metode").val()+'&nbsp;<input type="hidden" name="UJI[METODE][]" value="'+$("#metode").val()+'"></td>';
					str += '<td>'+$("#pustaka").val()+'&nbsp;<input type="hidden" name="UJI[PUSTAKA][]" value="'+$("#pustaka").val()+'"></td>';
					str += '<td>'+$("#syarat").val()+'&nbsp;<input type="hidden" name="UJI[SYARAT][]" value="'+$("#syarat").val()+'"></td>';
					str += '<td>'+$("#rlingkup").val()+'&nbsp;<input type="hidden" name="UJI[RUANG_LINGKUP][]" value="'+$("#rlingkup").val()+'"></td>';
					str += '<td>'+$("#penguji option:selected").text()+'&nbsp;<input type="hidden" name="UJI[PENGUJI][]" value="'+$("#penguji").val()+'"><input type="hidden" name="UJI[PENYELIA][]" value="<?php echo $sess['KASIE']; ?>"><input type="hidden" name="UJI[JENIS_UJI][]" value="<?php echo $jenis_uji; ?>"></td>';
					str += '<td><a href="#" class="hapusparams">Edit / Hapus</a></td>';
					str += '</tr>';
					$("#body-newparamater").append(str);
					clearForm("#tbparamater");
					$(".hapusparams").live("click", function(){
						var idke = $(this).closest("tr").attr("id");
						$("#"+idke).remove();
						return false;
					});
			}
			return false;
		});
		$(".rep-kategori").click(function(){
			$.get($(this).attr("url") + "/" + $(this).attr("id"), function(data){
				$("#ctn-kategori-edit").html(data); 
				$("#ctn-kategori-edit").dialog({ 
					title: 'Edit Kategori Sampel', 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
		});
		$(".rep-penyelia").click(function(){
			$.get($(this).attr("url") + "/" + $(this).attr("id"), function(data){
				$("#ctn-penyelia-edit").html(data); 
				$("#ctn-penyelia-edit").dialog({ 
					title: 'Edit Penyelia', 
					width: 700, 
					resizable: false, 
					modal: true
				}); 
			});
		});	
	});
</script> 
