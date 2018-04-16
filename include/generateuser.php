<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);


if(!isset($_SESSION["$userhost"])){
echo "<!--";
}else{
  
  $srvlist = $API->comm("/ip/hotspot/print");
  
  if(isset($_POST['qty'])){
    $qty = ($_POST['qty']);
    $server = ($_POST['server']);
    $user = ($_POST['user']);
    $userl = ($_POST['userl']);
    $prefix = ($_POST['prefix']);
    $char = ($_POST['char']);
    $profile = ($_POST['profile']);
    $timelimit = ($_POST['timelimit']);
    $datalimit = ($_POST['datalimit']);
    if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
    if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*1000000000;}
    $getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$profile"));
    $ponlogin = $getprofile[0]['on-login'];
    $getvalid = explode(",",$ponlogin)[3];
    $getprice = explode(",",$ponlogin)[2];
    
    $commt = $user . "-" . rand(100,999) . "-" . date("m.d.y") . "";
    
    $gen = '<?php $genu="'. $commt . "-" . $profile . "-" . $getvalid . '";?>';
    $temp = './voucher/temp.php';
		$handle = fopen($temp, 'w') or die('Cannot open file:  '.$temp);
		$data = $gen;
		fwrite($handle, $data);
    
		$a = array ("1"=>"","",1,2,2,3,3,4);

    if($user=="up"){
		for($i=1;$i<=$qty;$i++){
			if($char == "lower"){
			$u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$userl);
		  }elseif($char == "upper"){
		  $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
		  }elseif($char == "upplow"){
		  $u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
		  }
		  if($userl == 3){
				$p[$i]= rand(100,999);
			}elseif($userl == 4){
				$p[$i]= rand(1000,9999);
			}elseif($userl == 5){
				$p[$i]= rand(10000,99999);
			}elseif($userl == 6){
				$p[$i]= rand(100000,999999);
			}elseif($userl == 7){
				$p[$i]= rand(1000000,9999999);
			}elseif($userl == 8){
				$p[$i]= rand(10000000,99999999);
			}
			
			$u[$i] = "$prefix$u[$i]";
		}
		
		for($i=1;$i<=$qty;$i++){
			$API->comm("/ip/hotspot/user/add", array(
			"server" => "$server",
			"name" => "$u[$i]",
			"password" => "$p[$i]",
			"profile" => "$profile",
			"limit-uptime" => "$timelimit",
			"limit-bytes-out" => "$datalimit",
			"comment" => "$commt",
			));
		}}
		
		if($user=="vc"){
		  $shuf = ($userl-$a[$userl]);
		for($i=1;$i<=$qty;$i++){
        if($char == "lower"){
          $u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$shuf);
        }elseif($char == "upper"){
          $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$shuf);
        }elseif($char == "upplow"){
          $u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), -$shuf);
        }
        if($userl == 3){
			  	$p[$i]= rand(1,9);
			  }elseif($userl == 4 || $userl == 5){
			  	$p[$i]= rand(10,99);
			  }elseif($userl == 6 || $userl == 7){
			  	$p[$i]= rand(100,999);
			  }elseif($userl == 8){
			  	$p[$i]= rand(1000,9999);
			  }

	      $u[$i] = "$prefix$u[$i]$p[$i]";
	      
	      if($char == "num"){
	      if($userl == 3){
			  	$p[$i]= rand(100,999);
			  }elseif($userl == 4){
			  	$p[$i]= rand(1000,9999);
			  }elseif($userl == 5){
			  	$p[$i]= rand(10000,99999);
			  }elseif($userl == 6){
			  	$p[$i]= rand(100000,999999);
			  }elseif($userl == 7){
			  	$p[$i]= rand(1000000,9999999);
			  }elseif($userl == 8){
			  	$p[$i]= rand(10000000,99999999);
			  }

	      $u[$i] = "$prefix$p[$i]";
	      }
		}
		for($i=1;$i<=$qty;$i++){
			$API->comm("/ip/hotspot/user/add", array(
			"server" => "$server",
			"name" => "$u[$i]",
			"password" => "$u[$i]",
			"profile" => "$profile",
			"limit-uptime" => "$timelimit",
			"limit-bytes-out" => "$datalimit",
			"comment" => "$commt",
			));
		}}
		

		
	if($qty < 2){
		  echo "<script>window.location='./?hotspot-user=".$u[1]."'</script>";
		}else{
		header("Location:$url");
		}
	}
  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  include_once('./voucher/temp.php');
  $genuser = explode("-",$genu);
  $umode = $genuser[0];
  $ucode = $genuser[1];
  $udate = $genuser[2];
  $uprofile = $genuser[3];
  $uvalid = $genuser[4];
  $urlprint = "$umode-$ucode-$udate";
}
?>
<div style="overflow-x:auto;">
<form autocomplete="off" method="post" action="">
<table class="tdata">
  <tr>
    <th colspan="5">
<?php if($_SESSION['ubp'] != ""){
    echo "    <a class='btnsubmit' href='./?user-by-profile=".$_SESSION['ubp']."'>Close</a>";
}else{
    echo "    <a class='btnsubmit' href='./?hotspot=users'>Close</a>";
}
?>
    <input type="submit" name="save" class="btnsubmit" title="Generate User" style="font-weight: bold;"   value="Generate">
    <a class="btnsubmit" title="Print Default" href="./voucher/print.php?id=<?php echo $urlprint;?>&qr=no" target="_blank">Print</a>
    <a class="btnsubmit" title="Print QR" href="./voucher/print.php?id=<?php echo $urlprint;?>&qr=yes" target="_blank">QR</a>
    <a class="btnsubmit" title="Print Small" href="./voucher/print.php?id=<?php echo $urlprint;?>&small=yes" target="_blank">Small</a>
    </th>
  </tr>
  <tr>
    <td>Qty</td><td><input type="number" size="4" name="qty"  calss="test" min="1" max="100" value="1" required="1"></td>
  </tr>
  <tr>
    <td>Server</td>
    <td>
			<select name="server" required="1">
				<option>all</option>
				<?php $TotalReg = count($srvlist);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $srvlist[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
	<tr>
    <td>User Mode</td><td>
			<select onchange="defUserl();" id="user" name="user" required="1">
				<option value="up">User & Pasword</option>
				<option value="vc">User = Pasword</option>
			</select>
		</td>
	</tr>
  <tr>
    <td>User Length</td><td>
      <select id="userl" name="userl" required="1">
        <option>4</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
			</select>
    </td>
  </tr>
  <tr>
    <td>Prefix</td><td><input type="text" size="4" maxlength="4" autocomplete="off" name="prefix" value=""></td>
  </tr>
  <tr>
    <td>Character</td><td>
      <select name="char" required="1">
				<option id="lower" style="display:block;" value="lower">abcd</option>
				<option id="upper" style="display:block;" value="upper">ABCD</option>
				<option id="upplow" style="display:block;" value="upplow">aBcD</option>
				<option id="lower1" style="display:none;" value="lower">abcd1234</option>
				<option id="upper1" style="display:none;" value="upper">ABCD1234</option>
				<option id="upplow1" style="display:none;" value="upplow">aBcD1234</option>
				<option id="num" style="display:none;" value="num">1234</option>
			</select>
    </td>
  </tr>
  <tr>
    <td>Profile</td><td>
			<select onchange="GetVP();" id="uprof" name="profile" required="1">
				<?php $TotalReg = count($getprofile);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $getprofile[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
	<tr>
    <td>Time Limit</td><td><input type="text" size="4" autocomplete="off" name="timelimit" value=""></td>
  </tr>
  <tr>
    <td>Data Limit</td><td><input type="number" min="0" max="9999" name="datalimit" value=""> GB</td>
  </tr>
  <tr >
    <td>Validity | Price</td><td id="GetValidPrice"></td>
  </tr>
  <tr >
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
         echo "Generate Terakhir:<br>Kode Generate: $ucode | Tanggal: $udate | Profile: $uprofile | Validity: $uvalid";
      }else{
        echo "Last Generated:<br>Generate Code: $ucode | Date: $udate | Profile: $uprofile | Validity: $uvalid";
      }
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Format Time Limit.<br>
        [wdhm] Example : 30d = 30days, 12h = 12hours, 4w3d = 31days.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</form>
</div>