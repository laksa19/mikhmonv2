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
}
  if(substr($userprofile,0,1) == "*"){
	  $userprofile = $userprofile;
  }elseif(substr($userprofile,0,1) != ""){
	  $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
    "?name"=> "$userprofile",
    ));
    $userprofile =	$getprofile[0]['.id'];
    if($userprofile == ""){echo "<b>User Profile not found</b>";}
  }
  
  $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
    "?.id" => "$userprofile"));
	$profiledetalis = $getprofile[0];
  $pid = $profiledetalis['.id'];
  $pname = $profiledetalis['name'];
  $psharedu = $profiledetalis['shared-users'];
  $pratelimit = $profiledetalis['rate-limit'];
  $ponlogin = $profiledetalis['on-login'];
  
  $getexpmode = explode(",",$ponlogin)[1];
  
		if($getexpmode == "rem"){
		  $getexpmodet = "Remove";
		}elseif($getexpmode == "ntf"){
		  $getexpmodet = "Notice";
		}elseif($getexpmode== "remc"){
		  $getexpmodet = "Remove & Record";
		}elseif($getexpmode == "ntfc"){
		  $getexpmodet = "Notice & Record";
		}else{
		  $getexpmode = "0";
		  $getexpmodet = "None";
		}
		
		$getprice = explode(",",$ponlogin)[2];
		
		$getvalid = explode(",",$ponlogin)[3];
		
		$getgracep = explode(",",$ponlogin)[4];

  if(isset($_POST['name'])){
    $name = ($_POST['name']);
    $sharedusers = ($_POST['sharedusers']);
    $ratelimit = ($_POST['ratelimit']);
    $expmode = ($_POST['expmode']);
    $validity = ($_POST['validity']);
    $graceperiod = ($_POST['graceperiod']);
    $price = ($_POST['price']);
    
      $onlogin1 = ':put (",rem,'.$price.','.$validity.','.$graceperiod.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"] }}';
			$onlogin2 = ':put (",ntf,'.$price.','.$validity.',,"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$exptime.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time] }}';
			$onlogin3 = ':put (",remc,'.$price.','.$validity.','.$graceperiod.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[/system script add name="$date-|-$time-|-$user-|-$price" owner="$bln$thn" source=$date comment=mikhmon] }}';
			$onlogin4 = ':put (",ntfc,'.$price.','.$validity.',,"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[/system script add name="$date-|-$time-|-$user-|-$price" owner="$bln$thn" source=$date comment=mikhmon] }}';
			
			if($expmode == "rem"){
			$onlogin = "$onlogin1";
			}elseif($expmode == "ntf"){
			$onlogin = "$onlogin2";
			}elseif($expmode == "remc"){
			$onlogin = "$onlogin3";
			}elseif($expmode == "ntfc"){
			$onlogin = "$onlogin4";
			}elseif($expmode == "0" && $price != "" ){
			$onlogin = ':put (",,'.$price.',,,noexp,")';
			}else{
			$onlogin = "";
			}
    
	$API->comm("/ip/hotspot/user/profile/set", array(
			  		  /*"add-mac-cookie" => "yes",*/
	".id" => "$pid",
  "name" => "$name",
  "rate-limit" => "$ratelimit",
  "shared-users" => "$sharedusers",
  "status-autorefresh" => "15",
  "transparent-proxy" => "yes",
  "on-login" => "$onlogin",
			));
			
    echo "<script>window.location='./?user-profile=".$pid."'</script>";
  }

?>
<div style="overflow-x:auto;">
<form autocomplete="off" method="post" action="">
<table class="tdata">
  <tr>
    <th colspan="5">
    <a class="btnsubmit" href="./?hotspot=user-profiles">Close</a>
    <input type="submit" name="save" class="btnsubmit" style="font-weight: bold;"   value="Save">
    <a class="btnsubmit" href="./?remove-user-profile=<?php echo $pid;?>">Remove</a>
    </th>
  </tr>
  <tr>
    <td>Name</td><td><input type="text" autocomplete="off" name="name" value="<?php echo $pname;?>" required="1" autofocus></td>
	</tr>
  <tr>
    <td>Shared Users</td><td><input type="text" size="4" autocomplete="off" name="sharedusers" value="<?php echo $psharedu;?>" required="1"></td>
  </tr>
  <tr>
    <td>Rate limit [up/down]</td><td><input type="text" name="ratelimit" autocomplete="off" value="<?php echo $pratelimit;?>" placeholder="Example : 512k/1M" ></td>
  </tr>
  <tr>
    <td>Expired Mode</td><td>
			<select onchange="RequiredV();" id="expmode" name="expmode" required="1">
			  <option value="<?php echo $getexpmode;?>"><?php echo $getexpmodet;?></option>
				<option value="0">None</option>
				<option value="rem">Remove</option>
				<option value="ntf">Notice</option>
				<option value="remc">Remove & Record</option>
				<option value="ntfc">Notice & Record</option>
			</select>
		</td>
	</tr>
	<tr id="validity" style="display:none;">
    <td>Validity</td><td><input type="text" id="validi" size="4" autocomplete="off" name="validity" value="<?php echo $getvalid;?>" required="1"></td>
  </tr>
	<tr id="graceperiod" style="display:none;">
    <td>Grace Period</td><td><input type="text" id="gracepi" size="4" autocomplete="off" name="graceperiod" value="<?php echo $getgracep;?>" required="1"></td>
  </tr>
  <tr>
    <td>Price <?php echo $curency;?></td><td><input type="number" min="0" name="price" value="<?php echo $getprice;?>" ></td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Expired Mode adalah kontrol untuk user hotspot.<br>
        Pilihan : Remove, Notice, Remove & Record,Notice & Record.
        <ul>
        <li>Remove : User akan dihapus ketika sudah grace period habis.</li>
        <li>Notice : User akan mendapatkan nitifikasi setelah user expired.</li>
        <li>Record : Menyimpan data harga tiap user yang login. Untuk menghitung total penjualan user hotspot.</li>
        </ul>
      </p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Periode.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Expired Mode is the control for the hotspot user.<br>
        Options : Remove, Notice, Remove & Record, Notice & Record.
        <ul>
        <li>Remove: User will be deleted when the grace period expires.</li>
        <li>Notice: User will get nitification after user expiration.</li>
        <li>Record: Save the price of each user login. To calculate total sales of hotspot users.</li>
        </ul>
      </p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Periode.<br>
        [wdhm] Example : 30d = 30days, 12h = 12hours, 4w3d = 31days.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</form>
</div>