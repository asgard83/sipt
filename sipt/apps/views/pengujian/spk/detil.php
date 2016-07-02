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
                <td class="td_left bold">Nama Manajer Teknis</td>
                <td class="td_right"><?php echo $sess['MT']; ?></td>
              </tr>
              <tr>
                <td class="td_left bold">Jabatan</td>
                <td class="td_right"><?php echo $sess['JABATAN_MT']; ?></td>
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
                <td class="td_left bold">Jabatan</td>
                <td class="td_right"><?php echo $sess['JABATAN_PENYELIA']; ?></td>
              </tr>
            </table>
            <div style="height:5px;">&nbsp;</div>
            <div style="background:#e7e7e7; border:1px solid #ccc; padding:5px;">
              <p><b>Keterangan :</b></p>
              <p>Jika terjadi kesalahan dalam disposisi Manajer Teknis dan Penentuan Penyelia, silahkan <a href="javascript:;" class="revisi-spk" data-url = "<?php echo site_url(); ?>/get/pengujian/revisi_spk/<?php echo $sess['SPK_ID']; ?>">klik disini untuk memperbaikinya</a>.</p>
            </div>
            <h2 class="small garis">Detail Parameter Uji</h2>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
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
                                    <tr class="detilspk" data-id="<?php echo $parameter[$i]['UJI_ID']; ?>" data-url="<?php echo site_url(); ?>">
                                      <td><?php echo $parameter[$i]['PARAMETER_UJI']; ?><div style="font-size:10px;">Bidang : <?php echo $parameter[$i]['UR_JENIS_UJI']; ?></div></td>
                                      <td><?php echo $parameter[$i]['METODE']; ?></td>
                                      <td><?php echo $parameter[$i]['PUSTAKA']; ?></td>
                                      <td><?php echo $parameter[$i]['SYARAT']; ?></td>
                                      <td><?php echo $parameter[$i]['RUANG_LINGKUP']; ?></td>
                                      <td><?php echo $parameter[$i]['PENYELIA']; ?><div style="font-size:10px;"><?php echo $parameter[$i]['JABATAN']; ?></div></td>
                                      <td><?php echo $parameter[$i]['UR_PENGUJI'] == "" ? "-" : $parameter[$i]['UR_PENGUJI']; ?></td>
                                    </tr>
                                    <?php
								  }
							  }else{
							  ?>
                <tr>
                  <td colspan="7"><b>Data tidak ditemukan</b></td>
                </tr>
                <?php
							  }
							?>
              </tbody>
            </table>
            <div style="height:10px;"></div>
            <h2 class="small"><a href="#" url="<?php echo site_url(); ?>/get/pengujian/log_spk/<?php echo $sess['SPK_ID']; ?>" onclick="expand_detail($(this), 'detail_log'); return false;" id="detail_hisotry">Detail Log SPK (
              <?= $logspk; ?>
              )</a></h2>
            <div id="detail_log"></div>
            <div style="height:10px;"></div>
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
                  <td class="td_left">Asal Sampling</td>
                  <td class="td_right"><b><?php echo $sampel[0]['ASAL_SAMPEL'];?></b></td>
                  <td width="10"></td>
                  <td class="td_left">Tujuan Sampling</td>
                  <td class="td_right"><b><?php echo $sampel[0]['TUJUAN_SAMPLING']; ?></b></td>
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
            <div style="height:10px;">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div style="height:10px;">&nbsp;</div>
  <div style="padding-left:5px;"><a href="#" class="button back" onclick="window.history.back(); return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
  <div style="height:10px;">&nbsp;</div>
</div>
<div id="ctn-kategori-edit"></div>
<div id="ctn-penyelia-edit"></div>
<div id="ctn-revisi-spk"></div>
<script>
	$(document).ready(function(e){
		$(".revisi-spk").click(function(){
			var $this = $(this);
			$.get($this.attr("data-url"), function(data){
				$("#ctn-revisi-spk").html(data); 
				$("#ctn-revisi-spk").dialog({ 
					title: 'Revisi Disposisi Surat Permintaan Kerja', 
					width: 800, 
					resizable: false, 
					modal: true
				}); 
			});
		});
		$(".detilspk").click(function(){
			var $this = $(this);
			console.log($this.attr("data-url"));
		});	
	});
</script> 
