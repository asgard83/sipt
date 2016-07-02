<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="judulhome" class="judul"></div>
<div class="content">
  <div id="accordion">
    <h2 class="current">Aktivitas Terakhir</h2>
    <?php
	if(in_array('1', $this->newsession->userdata('SESS_KODE_ROLE'))){
		$this->load->view('charts');
	}else{
	?>
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Informasi Pengguna</a></li>
        <?php  if(in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {?>
        <li><a href="#tabs-2">Grafik Pemeriksaan</a></li>
        <?php } ?>
      </ul>
      <div id="tabs-1">
        <table style="padding:5px;">
          <tr>
            <td width="200">Nama Lengkap</td>
            <td><?php echo  $this->newsession->userdata('SESS_NAMA_USER'); ?></td>
          </tr>
          <tr>
            <td>Jabatan</td>
            <td><?php echo $this->newsession->userdata('SESS_JABATAN'); ?></td>
          </tr>
          <tr>
            <td>BADAN / BALAI POM</td>
            <td><?php echo $this->newsession->userdata('SESS_MBBPOM'); ?></td>
          </tr>
          <?php
            if(!in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && !in_array('03', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && !in_array('05', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && !in_array('10', $this->newsession->userdata('SESS_KODE_ROLE'))){#Pengujian
			$inisal = array("Supervisor Dua", "Supervisor Satu", "Operator");
			$ganti = array("Manager Teknis", "Penyelia", "Penguji");
            ?>
          <tr>
            <td>Role SIPT </td>
            <td><?php echo join(" &bull; ",str_replace($inisal, $ganti, $this->newsession->userdata('SESS_UR_ROLE'))); ?></td>
          </tr>
          <?php } else { ?>
          <tr>
            <td>Role SIPT </td>
            <td><?php 
					if($this->newsession->userdata('SESS_BBPOM_ID') == '90')
          {
              echo "Biro Umum";
          }
          else if($this->newsession->userdata('SESS_BBPOM_ID') == '90')
          {
              echo "Inspektorat";
          }
          else
          {
					 echo join(" &bull; ",$this->newsession->userdata('SESS_UR_ROLE')); 
          }
          ?></td>
          </tr>
          <?php } ?>
          <?php
            if(in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))){#Pemeriksaan Sarana
            ?>
          <tr>
            <td valign="top">Jenis Sarana yang diperiksa</td>
            <td valign="top"><?php echo join(" &bull; ",$this->newsession->userdata('SESS_URAIAN_SARANA')); ?></td>
          </tr>
          <?php
            }else if(in_array('02', $this->newsession->userdata('SESS_JENIS_PELAPORAN')) && (in_array('2', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('3', $this->newsession->userdata('SESS_KODE_ROLE')) || in_array('4', $this->newsession->userdata('SESS_KODE_ROLE')))){#Pengujian
			?>
          <tr>
            <td valign="top">Klasifikasi yang diuji</td>
            <td valign="top"><?php echo join(" &bull; ",$this->newsession->userdata('SESS_URAIAN_KK')); ?></td>
          </tr>
          <?php
			}
            ?>
          <tr>
            <td>Login Terakhir</td>
            <td><?php echo $this->newsession->userdata('SESS_LOGIN'); ?></td>
          </tr>
          <tr>
            <td>Logout Terakhir</td>
            <td><?php echo $this->newsession->userdata('SESS_LOGOUT'); ?></td>
          </tr>
          <tr>
            <td>IP Address</td>
            <td><?php echo $this->newsession->userdata('SESS_IP'); ?></td>
          </tr>
        </table>
      </div>
      <?php  if(in_array('01', $this->newsession->userdata('SESS_JENIS_PELAPORAN'))) {?>
      <div id="tabs-2">
        <div id="show_chart" style="min-height:400px;">
          <table width="900" align="center">
            <tr>
              <td width="250" align="center" valign="top"><div id="chart_komoditi"></div></td>
              <td width="350" align="center" valign="top"><div id="chart_jenis"></div></td>
            </tr>
          </table>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php
	}
	?>
  </div>
</div>
<?php /*?><script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]}); google.setOnLoadCallback(function(){setTimeout(function(){
	$.get(isUrl+'index.php/utility/grafik/chart_komoditi', function(hasil){
		hasil = $.trim(hasil);
		drawChart(hasil, "chart_komoditi", "Komoditi");
	});

	$.get(isUrl+'index.php/utility/grafik/chart_jsarana', function(hasil){
		hasil = $.trim(hasil);
		drawChart(hasil, "chart_jenis", "Jenis Sarana");
	});

	}, 2000);});

	function drawChart(hasil, idobj, cols){
		hasil = hasil.split('|');
		var len = hasil.length;
		if(len>0){
			var data = new google.visualization.DataTable();
			data.addColumn('string', cols);
			data.addColumn('number', 'Jumlah');
			for(i=0;i<len;i++){
				var temp = hasil[i];
				temp = temp.split(';');
				data.addRows([[temp[0], parseInt(temp[1])]]);
				if(i==len)break;
			}
			var options = {width: 300,height: 300, backgroundColor: '#fff',chartArea: {left:10, top:10, bottom:0, width:'85%', height:'85%'}, tooltip: {textStyle: {fontName: 'verdana', fontSize: 11}}, legend: {position: 'none'},is3D: true, pieSliceTextStyle: {fontName: 'verdana', fontSize: 11}};
			var chart = new google.visualization.PieChart(document.getElementById(idobj));chart.draw(data, options);i--;$('#' + idobj).append(hasil[i]);
		}
	}

</script><?php */?>
