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

// hide all error
error_reporting(0);

  $getuser = $API->comm("/ip/hotspot/user/print");
	$TotalReg = count($getuser);
	
  $counttuser = $API->comm("/ip/hotspot/user/print", array(
	 "count-only" => ""));
	
	$getprofile = $API->comm("/ip/hotspot/user/profile/print");
	$TotalReg2 = count($getprofile);
?>
<div style="overflow-x:auto; overflow-y:auto; max-height: 70vh;">
<table class="zebra" id="tFilter">
  <thead>
  <tr>
    <th colspan='7'>
<?php
  if($counttuser < 2 ){echo "$counttuser item  ";
  }elseif($counttuser > 1){echo "$counttuser items  ";}
?>
      <a class="btnsubmit" title="Add User" href="./?hotspot-user=add">Add</a>
      <a class="btnsubmit" title="Generate Users" href="./?hotspot-user=generate">Generate</a>
    </th>
  </tr>
  <tr>
    <th></th>
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input style="width:80%;" type="text" id="filterTable" size="auto" onkeyup="fTable()" placeholder="Server" title="Filter by Hotspot Server">
      </div>
    </th>
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input style="width:80%;" type="text" id="filterTable1" size="auto" onkeyup='fTable1()' placeholder="Name" title="Filter by Name">
      </div>
    </th>
    <th>
      <select onchange="window.location.href=this.value;" title="Filter by Profile">
        <option>
<?php
if($userbyprofile == ""){echo "Profile";}else {echo $userbyprofile;}
?>
        </option>
        <option value="./?hotspot=users">Show All</option>
<?php
for ($i=0; $i<$TotalReg2; $i++){
	$profile = $getprofile[$i];echo "<option value='./?user-by-profile=".$profile['name'] . "'>". $profile['name']."</option>";
	}
?>
        </select>
    </th>
    <th>Uptime</th>
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input style="width:80%;" type="text" id="filterTable2" size="auto" onkeyup="fTable2()" placeholder="Comment" title="Filter by Comment">
      </div>
    </th>
    <th>Print</th>
    </tr>
  </thead>
  <tbody>
<?php
for ($i=0; $i<$TotalReg; $i++){
	$userdetails =	$getuser[$i];
	$uid = $userdetails['.id'];
	$userver = $userdetails['server'];
	$uname = $userdetails['name'];
	$upass = $userdetails['password'];
	$uprofile = $userdetails['profile'];
	$uuptime = $userdetails['uptime'];
	$ucomment = $userdetails['comment'];
	$udisabled = $userdetails['disabled'];

	echo "<tr>";
	echo "<td style='text-align:center;'><a class='btnsmall' title='Remove ".$uname. "' href=./?remove-hotspot-user=".$uid . ">-</a>";
	if($udisabled == "true"){ $tcolor = "#ccc"; echo "<a title='Enable User ".$uname . "' class='btnsmall' href='./?enable-hotspot-user=".$uid . "'>E</a></td>";}else{ $tcolor = "#000";echo "<a title='Disable User ".$uname . "' class='btnsmall' href='./?disable-hotspot-user=".$uid . "'>D</a></td>";}
	echo "<td style='color:".$tcolor.";'>" . $userver;echo "</td>";
	echo "<td style='color:".$tcolor.";'><a title='Open User ".$uname . "' style='color:".$tcolor.";' href=./?hotspot-user=".$uid . ">". $uname."</a>";echo "</td>";
	echo "<td style='color:".$tcolor.";'>" . $uprofile;echo "</td>";
	echo "<td style='color:".$tcolor.";'>" . $uuptime;echo "</td>";
	echo "<td style='color:".$tcolor.";'>"; if($uname == "default-trial"){}else{echo $ucomment;}; echo "</td>";
	echo "<td style='color:".$tcolor.";'>";
	if($ucomment == ""){}else{echo " | <a style='color:".$tcolor.";' title='Print' href='./voucher/print.php?id=" . $ucomment . "&qr=no' target='_blank'> Print</a>";
	echo " | <a style='color:".$tcolor.";' title='Print QR' href='./voucher/print.php?id=" . $ucomment . "&qr=yes' target='_blank'> QR</a>";
 	echo " | <a style='color:".$tcolor.";' title='Print Small' href='./voucher/print.php?id=" . $ucomment . "&small=yes' target='_blank'> Small</a> |";
	}
	echo "</td>";
	echo "</tr>";
	}
?>
  </tbody>
</table>
</div>

