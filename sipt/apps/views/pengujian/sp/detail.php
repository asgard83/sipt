<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(E_ERROR); ?>

<div id="juduluji" class="judul"></div>
<div class="headersarana"><?php echo $judul; ?></div>
<div class="content">
  <div class="adCntnr">
    <div class="acco2">
      <div class="expand"><a title="expand/collapse" href="#" style="display: block;">SURAT PERINTAH UJI</a></div>
      <div class="accCntnt">
        <h2 class="small garis">Detil Surat Perintah Uji</h2>
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
          <tr>
            <td class="td_left">Ditujukan Kepada : </td>
            <td class="td_right"><?php
						$jml = count($kabid);
						if($jml > 0){
							for($i = 0; $i < $jml; $i++){
								?>
              <div><a href="javascript:void(0);" class="delsampelmt" url="<?php echo site_url(); ?>/get/pengujian/del_sampel_mt/<?php echo $sess['SPU_ID']; ?>/<?php echo $kabid[$i]['USER_ID']; ?>" namamt="<?php echo $kabid[$i]['NAMA_USER']; ?>" nospu="<?php echo $sess['UR_SPU']; ?>"><img src="<?php echo base_url(); ?>images/icon-delete.png" align="middle"></a>&nbsp;<b><?php echo $kabid[$i]['NAMA_USER']; ?></b></div>
              <div><?php echo $kabid[$i]['USER_ID']; ?></div>
              <div>&bull;&nbsp;<?php echo $kabid[$i]['JABATAN']; ?></div>
              <div><i>Jika, terjadi kesalahan dalam menentukan disposisi surat perintah kepada kepala bidang pengujian. Silahkan klik <a href="javascript:void(0);" class="redispo" judul="Edit Data Kepala Bidang" url="<?php echo site_url(); ?>/get/pengujian/get_dispo/<?php echo $sess['SPU_ID']; ?>/<?php echo $kabid[$i]['USER_ID']; ?>"><b>DI SINI</b></a> untuk memperbaikinya.</i></div>
              <hr>
              <?php
							}
						}
						?></td>
          </tr>
          <tr>
            <td class="td_left" colspan="2"><div><i>Jika ada Kepala Bidang yang terlewat, silahkan klik <a href="javascript:void(0);" class="redispo" url="<?php echo site_url(); ?>/get/pengujian/get_addmt/<?php echo $sess['SPU_ID']; ?>" judul="Penambahan Kepala Bidang"><b>DI SINI</b></a> untuk menambah Kepada Bidang yang dimaksud.</i></div></td>
          </tr>
        </table>
        <div id="tabs">
          <ul>
            <?php
						if($chk_uji[0]['KIMIA'] > 0){
						?>
            <li><a href="#tabs-1">Sampel Kimia</a></li>
            <?php
						}
						?>
            <?php
						if($chk_uji[0]['MIKRO'] > 0){
						?>
            <li><a href="#tabs-2">Sampel Mikro</a></li>
            <?php
						}
						?>
          </ul>
          <?php
					if($chk_uji[0]['KIMIA'] > 0){
					?>
          <div id="tabs-1">
            <h2 class="small garis">Lampiran Penyerahan Sampel </h2>
            <p>Nomor Surat Penyerahan Sampel : <?php echo $sess['NOMOR_SPS']; ?></p>
            <div>&nbsp;</div>
            <?php
							$jmlk = count($sampelk);
							if($jmlk > 0){
								?>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th>Kode Sampel</th>
                  <th>Nama Sampel</th>
                  <th>Nomor Registrasi</th>
                  <th>No Bets</th>
                  <th>Kategori</th>
                </tr>
              </thead>
              <tbody>
                <?php
								for($k=0; $k<$jmlk; $k++){
									?>
                <tr>
                  <td><?php echo $sampelk[$k]['UR_KODE']; ?></td>
                  <td><?php echo $sampelk[$k]['NAMA_SAMPEL']; ?></td>
                  <td><?php echo $sampelk[$k]['NOMOR_REGISTRASI']; ?></td>
                  <td><?php echo $sampelk[$k]['NO_BETS']; ?></td>
                  <td><?php echo $sampelk[$k]['KATEGORI']; ?></td>
                </tr>
                <?php
								}
								?>
              </tbody>
            </table>
            <?php
							}
							?>
          </div>
          <?php
					}
					?>
          <?php
					if($chk_uji[0]['MIKRO'] > 0){
					?>
          <div id="tabs-2">
            <h2 class="small garis">Lampiran Penyerahan Sampel </h2>
            <p>Nomor Surat Penyerahan Sampel : <?php echo $sess['NOMOR_SPS']; ?></p>
            <div>&nbsp;</div>
            <?php
							$jmlm = count($sampelm);
							if($jmlm > 0){
								?>
            <table class="listtemuan" width="100%">
              <thead>
                <tr>
                  <th>Kode Sampel</th>
                  <th>Nama Sampel</th>
                  <th>Nomor Registrasi</th>
                  <th>No Bets</th>
                  <th>Kategori</th>
                </tr>
              </thead>
              <tbody>
                <?php
								for($m=0; $m<$jmlm; $m++){
									?>
                <tr>
                  <td><?php echo $sampelm[$m]['UR_KODE']; ?></td>
                  <td><?php echo $sampelm[$m]['NAMA_SAMPEL']; ?></td>
                  <td><?php echo $sampelm[$m]['NOMOR_REGISTRASI']; ?></td>
                  <td><?php echo $sampelm[$m]['NO_BETS']; ?></td>
                  <td><?php echo $sampelm[$m]['KATEGORI']; ?></td>
                </tr>
                <?php
								}
								?>
              </tbody>
            </table>
            <?php
							}
							?>
          </div>
          <?php
					}
					?>
        </div>
        <div style="padding-left:5px;"><a href="#" class="button back" onclick="window.history.back();return false;"><span><span class="icon"></span>&nbsp; Kembali &nbsp;</span></a></div>
      </div>
    </div>
  </div>
  <div style="height:20px;">&nbsp;</div>
</div>
<div id="ctn-resdispo"></div>
<div id="ctn-header-dispo"></div>
<script>
	$(document).ready(function(e){
		$(".redispo").click(function(){
			var judul = $(this).attr("judul");
			$.get($(this).attr("url"), function(data){
				$("#ctn-resdispo").html(data); 
				$("#ctn-resdispo").dialog({ 
					title: judul, 
					width: 700, 
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
		$("a.delsampelmt").live("click", function(){
			var url = $(this).attr("url");
			var nospu = $(this).attr("nospu");
			var namamt = $(this).attr("namamt");
			jConfirm('Anda akan menghapus <b>'+namamt+'</b>,  dari SPU : <b>'+nospu+'</b> ? \n Harap diperhatikan, bahwa data yang telah dihapus tidak bisa dikembalkan lagi.', 'SIPT Versi 1.0', function(r){
				if(r==true){
					$.get(url + '/ajax', function(hasil){
						if(hasil.search("MSG")>=0){
							arrdata = hasil.split('#');
							if(arrdata[1]=="YES"){
								jAlert('Manajer Teknis : <b>'+namamt+'</b> \n berhasil dihapus dari SPU : <b>'+nospu+'</b>','SIPT versi 1.0');
								setTimeout(function(){location.reload(true);}, 1000);
							}else{
								jAlert('Manajer Teknis : <b>'+namamt+'</b> \n gagal dihapus dari SPU : <b>'+nospu+'</b>','SIPT versi 1.0');
								return false;
							}
						}else{
								jAlert('Manajer Teknis : <b>'+namamt+'</b> \n gagal dihapus dari SPU : <b>'+nospu+'</b>','SIPT versi 1.0');
							return false;
						}
					});
				}else{
					return false;
				}
			})
		})
	});
</script> 
