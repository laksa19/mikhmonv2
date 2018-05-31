<?php
error_reporting(0);
require('../lib/routeros_api.class.php');
include('../lib/formatbytesbites.php');
include('../include/config.php');
$API = new RouterosAPI();
$API->debug = false;
if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
	$title = "Status Voucher";
	$title1 = "User/Kode Voucher";
	$title2 = "Paket";
	$title3 = "Lama Terhubung";
	$title4 = "Pemakaian Data";
	$title5 = "Sisa Data";
	$title6 = "Masa Aktif";
	$title7 = "Dari";
	$title8 = "Sampai";
	$title9 = "tidak terdaftar.";
	$title10 = "sudah kadaluarsa.";
	$title11 = "Tanggal"; 
	$title12 = "Cek Status";
	$title13 = " Hari";
	$title14 = " Jam";
	$title15 = "Aktif";
	$title16 = "Expired";
}else{
	$title = "Voucher Status";
	$title1 = "User/Voucher Code";
	$title2 = "Profile";
	$title3 = "Uptime";
	$title4 = "Data Usage";
	$title5 = "Data Remaining";
	$title6 = "Validity";
	$title7 = "Start";
	$title8 = "End";
	$title9 = "not registered.";
	$title10 = "expired.";
	$title11 = "Date"; 
	$title12 = "Check Status";
	$title13 = " Day";
	$title14 = " Hour";
	$title15 = "Active";
	$title16 = "Expired";
}
if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
	$s = "";
}else{$s = "s";}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title." ".$hotspotname;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<link rel="icon" href="../img/favicon.png" />
<script>
function goBack() {
    window.history.back();
}
</script>
<style>
table {
  table-layout: fixed;
  width: 330;
  border-collapse: collapse;
  margin-left:auto;
  margin-right:auto;
}
/* Zebra striping */
tr:nth-of-type(odd) {
  background: #eee;
}
th {
  background: #333;
  color: white;
  font-weight: bold;
}
td, th {
  padding: 6px;
  border: 1px solid #ccc;
  text-align: left;
}
.button {
    background-color: #008CCA;
    border: none;
    padding: 5px 5px;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
}
table.tnav {
  table-layout: fixed;
  white-space: nowrap;
  width: 200;
  border-collapse: collapse;
  
}
table.tnav td {
  padding: 3px;
  border: 0px;
  text-align: left;
}
textarea,input,select {
  padding: 2px;
  margin: 2px;
  font-size: 14px;
}
</style>
</head>
<body align="center">
<h3 style="text-align:center;">Status Voucher<br><?php echo $hotspotname;?></h3>
<p style="text-align:center;" id="date1"><?php echo $title11." : " . date("d-m-Y") . "<br>";?></p>
<form autocomplete="off" method="post" action="">
	<table class="tnav">
		<tr><td><?php echo $title1;?> :</td><td><input type="text" size="15" name="nama" autofocus required="1" /></td></tr>
		<tr><td></td><td><input type="submit" class="button" value=<?php echo '"'.$title12.'"';?>/></td></tr>
	</table>
</form>
<?php
	if(isset($_POST['nama'])){
	$name = ($_POST['nama']);
	if ($API->connect( $iphost, $userhost, $passwdhost )) {
	$API->write('/system/scheduler/print', false);
	$API->write('?=name='.$name.'');
	$ARRAY1 = $API->read();
	$regtable = $ARRAY1[0];
				$exp = $regtable['next-run'];
				$strd = $regtable['start-date'];
				$strt = $regtable['start-time'];
				$cek = $regtable['interval'];
					$ceklen = strlen(substr($cek,0));
					$cekw = substr($cek, 0,2);
					$cekw1 = substr($cekw, 0,1)*7;
					$cekd = substr($cek, 2,2);
					$cekd1 = substr($cek, 2,1);
				if ($ceklen > 3){
					if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
						$cekall = $cekw1 + $cekd1 .$title13;
					}else{
						$cekall = $cekw1 + $cekd1;
						if($cekall > 1){$cekall = $cekw1 + $cekd1 .$title13.$s;}else{$cekall = $cekw1 + $cekd1 .$title13;}
					}
				}elseif (substr($cek, -1) == "h"){
					$cek1 = substr($cek, 0,-1);
					$cekall = $cek1;
					if($cekall > 1){$cekall = $cekw1 + $cekd1 .$title14.$s;}else{$cekall = $cekw1 + $cekd1 .$title14;}
				}elseif (substr($cek, -1) == "d"){
					$cek1 = substr($cek, 0,-1);
					$cekall = $cek1 .$title13;
				}elseif (substr($cek, -1) == "w"){
					$cek1 = substr($cek, 0,-1);
					$cekall = ($cek1*7);
					if($cekall > 1){$cekall = $cekw1 + $cekd1 .$title13.$s;}else{$cekall = $cekw1 + $cekd1 .$title13;}
				}elseif($cekall == ""){
					}
				 $cekall;

	
	$getuser = $API->comm("/ip/hotspot/user/print", array("?name"=> "$name"));
	$user = $getuser[0]['name'];
	$profile = $getuser[0]['profile'];
	$uptime = $getuser[0]['uptime'];
	$getbyteo = $getuser[0]['bytes-out'];
	$byteo = formatBytes2($getbyteo, 0);
	$limitup = $getuser[0]['limit-uptime'];
	$limitbyte = $getuser[0]['limit-bytes-out'];
	if($limitbyte == ""){$dataleft = "Unlimited";}else{$dataleft = formatBytes2($limitbyte-$getbyteo,0);}
	}
	if($user == "" || $exp == ""){
		echo "<h3>User <i style='color:#008CCA;'>$name</i> $title9</h3>";
	}elseif($limitup == "1s" || $uptime == $limitup || $getbyteo == $limitbyte){
		echo "<h3>User <i style='color:#008CCA;'>$name</i> $title10</h3>";
	}
	if($user == "" || $exp == ""){}else{
	echo "<div style='overflow-x:auto;'>";
	echo "<table style='width:200;'>";
	echo "	<tr>";
	echo "		<td >$title1</td>";
	echo "		<td > $user</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title2</td>";
	echo "		<td > $profile</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title3</td>";
	echo "		<td > $uptime</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title4</td>";
	echo "		<td > $byteo</td>";
	echo "	</tr>";
	if($limitup == "1s"  || $uptime == $limitup || $getbyteo == $limitbyte){
	echo "	<tr>";
	echo "		<td >Status</td>";
	echo "		<td >$title16</td>";
	echo "	</tr>";
	echo "</table>";
	echo "</div>";	
	}else{
	echo "	<tr>";
	echo "		<td >$title5</td>";
	echo "		<td > $dataleft</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title6</td>";
	echo "		<td >$cekall</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title7</td>";
	echo "		<td >$strd $strt</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >$title8</td>";
	echo "		<td >$exp</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td >Status</td>";
	echo "		<td >$title15</td>";
	echo "	</tr>";
	echo "</table>";
	echo "</div>";
	}
	}
	$API->disconnect();
	
}

?>
</div>
</body>
</html>
