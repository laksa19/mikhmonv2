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

  if(isset($_POST['name'])){
    $name = ($_POST['name']);
    $sharedusers = ($_POST['sharedusers']);
    $ratelimit = ($_POST['ratelimit']);
    $expmode = ($_POST['expmode']);
    $validity = ($_POST['validity']);
    $graceperiod = ($_POST['graceperiod']);
    $getprice = ($_POST['price']);
    if($getprice == ""){$price = "0";}else{$price = $getprice;}
    
      $onlogin1 = ':put (",rem,'.$price.','.$validity.','.$graceperiod.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"] }}';
			$onlogin2 = ':put (",ntf,'.$price.','.$validity.',,"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time] }}';
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
    
		$API->comm("/ip/hotspot/user/profile/add", array(
			  		  /*"add-mac-cookie" => "yes",*/
					  "name" => "$name",
					  "rate-limit" => "$ratelimit",
					  "shared-users" => "$sharedusers",
					  "status-autorefresh" => "15",
					  "transparent-proxy" => "yes",
					  "on-login" => "$onlogin",
			));
			
		$getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
    "?name"=> "$name",
    ));
    $pid =	$getprofile[0]['.id'];
    echo "<script>window.location='./?user-profile=".$pid."'</script>";
  }
}
?>
<div>
<section class="content p-0 bg-trp">
<div class="col-12 p-1">
<div class="card">
<div class="card-header p-2">
    <h3 class="card-title pull-left">Add Users Profiles</h3>
</div>
<!-- /.card-header -->
<div class="card-body p-1">
<div class="row">
<div class="col-sm-12">
<form autocomplete="off" method="post" action="">
<div class="card">
<div class="card-header p-1">
    <a class="btn btn-sm btn-warning" href="./?hotspot=user-profiles"> <i class="fa fa-close btn-mrg"></i> Close</a>
    <button type="submit" name="save" class="btn btn-sm btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
</div>  
<table class="table table-sm">
  </tr>
  <tr>
    <td class="align-middle">Name</td><td><input class="form-control form-control-sm" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
    <td class="align-middle">Shared Users</td><td><input class="form-control form-control-sm" type="text" size="4" autocomplete="off" name="sharedusers" value="1" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle">Rate limit [up/down]</td><td><input class="form-control form-control-sm" type="text" name="ratelimit" autocomplete="off" value="" placeholder="Example : 512k/1M" ></td>
  </tr>
  <tr>
    <td class="align-middle">Expired Mode</td><td>
      <select class="form-control form-control-sm" onchange="RequiredV();" id="expmode" name="expmode" required="1">
        <option value="">Select...</option>
        <option value="0">None</option>
        <option value="rem">Remove</option>
        <option value="ntf">Notice</option>
        <option value="remc">Remove & Record</option>
        <option value="ntfc">Notice & Record</option>
      </select>
    </td>
  </tr>
  <tr id="validity" style="display:none;">
    <td class="align-middle">Validity</td><td><input class="form-control form-control-sm" type="text" id="validi" size="4" autocomplete="off" name="validity" value="" required="1"></td>
  </tr>
  <tr id="graceperiod" style="display:none;">
    <td class="align-middle">Grace Period</td><td><input class="form-control form-control-sm" type="text" id="gracepi" size="4" autocomplete="off" name="graceperiod" placeholder="5m" value="5m" required="1"></td>
  </tr>
  <tr>
    <td class="align-middle">Price <?php echo $curency;?></td><td><input class="form-control form-control-sm" type="number" size="10" min="0" name="price" value="" ></td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
      <p style="padding:0px 5px;">
        Expired Mode adalah kontrol untuk user hotspot.<br>
        Pilihan : Remove, Notice, Remove & Record,Notice & Record.
        <ul>
        <li>Remove : User akan dihapus ketika sudah grace period habis.</li>
        <li>Notice : User tidah dihapus dan akan mendapatkan notifikasi setelah user expired.</li>
        <li>Record : Menyimpan data harga tiap user yang login. Untuk menghitung total penjualan user hotspot.</li>
        </ul>
      </p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Period.<br>
        [wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.
      </p>
      <?php }else{?>
      <p style="padding:0px 5px;">
        Expired Mode is the control for the hotspot user.<br>
        Options : Remove, Notice, Remove & Record, Notice & Record.
        <ul>
        <li>Remove: User will be deleted when the grace period expires.</li>
        <li>Notice: User will not deleted and get notification after user expiration.</li>
        <li>Record: Save the price of each user login. To calculate total sales of hotspot users.</li>
        </ul>
      </p>
      <p style="padding:0px 5px;">
        Format Validity & Grace Period.<br>
        [wdhm] Example : 30d = 30days, 12h = 12hours, 4w3d = 31days.
      </p>
      <?php }?>
    </td>
  </tr>
</table>
</div>
</form>
</div>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>
</div>  