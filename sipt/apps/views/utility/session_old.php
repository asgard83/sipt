<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<meta http-equiv="refresh" content="10">
<div id="<?php echo $idjudul; ?>" class="judul"></div>
<div class="content">
<div id="accordion">
	<h2 class="current"><?php echo $caption_header; ?></h2>
	<form id="fsession_" action="<?= $act; ?>" method="post" autocomplete="off">
    <table class="tabelajax">
        <tr class="head">
        	<th width="10px;">NO</th><th>NAMA PETUGAS</th><th width="300px;">BADAN / BALAI POM<th width="100px;">LOG TERAKHIR</th><th width="130px;">IP ADDRESS</th>
        </tr>
		<?php
			$session=array_keys($sess);
			$jml = count($session);
			$no=1;
			for($i=0; $i<$jml;$i++){
				$arrsess = explode('|', $sess[$session[$i]]);
				$j = strlen($arrsess[0]);
				$log = substr($arrsess[0], $j-9, 9);
				if($log=="LOGGED_IN"){
					$xval = explode(";", $sess[$session[$i]]);
					foreach($xval as $a){
						$b = explode('|', $a);
						$jum = strlen($b[1]);
						if($b[0]!="LOGS"){
							$c[$b[0]] = str_replace(":","",substr($b[1], 5, $jum-2));
						}else{
							$c[$b[0]] = substr($b[1], 5, $jum-2);
						}
					} 
				}
				?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo str_replace('"','',$c['SESS_USER_ID']);?><div><?php echo str_replace('"','',$c['SESS_NAMA_USER']);?></div></td>
                    <td><?php echo str_replace('"','',$c['SESS_MBBPOM']);?><div>Jabatan : <?php echo str_replace('"','',$c['SESS_JABATAN']);?></div></td>
                    <td>Login Terakhir : <div><?php echo str_replace('"','',$c['SESS_LOGIN']);?></div>Logout Terkahir : <div><?php echo str_replace('"','',$c['SESS_LOGOUT']);?></div></td>
                    <td>IP Address : <div><?php echo str_replace('"','',$c['SESS_IP']);?></div>Browser : <div><?php echo str_replace('"','',$c['SESS_AGENTS']);?></div></td>
                </tr>
                <?php
                $no++;
			}
		?>
        <tr><th colspan="5" style="height:25px;"></th></tr>	
         </table>
    </form>
</div>
</div>
