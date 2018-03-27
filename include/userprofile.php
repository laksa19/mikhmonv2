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

// get user profile
	$getprofile = $API->comm("/ip/hotspot/user/profile/print");
	$TotalReg = count($getprofile);
// count user profile
	$countprofile = $API->comm("/ip/hotspot/user/profile/print", array(
	  "count-only" => "",));

?>
<div style="overflow-x:auto;">
<table style="white-space: nowrap;" class="zebra" align="center"  >
  <tr>
    <th colspan="8">
<?php
if($countprofile < 2 ){echo "$countprofile item  ";
  }elseif($countprofile > 1){echo "$countprofile items  ";}
?>
      <a class="btnsubmit" title="Add User Profile" href="./?user-profile=add">Add</a>
    </th>
  </tr>
	<tr>
		<th ></th>
		<th >Name</th>
		<th >Shared<br>Users</th>
		<th >Rate<br>Limit</th>
		<th >Expired Mode</th>
		<th >Validity</th>
		<th >Grace<br>Period</th>
		<th >Price <?php echo $curency;?></th>
	</tr>
<?php

for ($i=0; $i<$TotalReg; $i++){
echo "<tr>";
$profiledetalis = $getprofile[$i];
$pid = $profiledetalis['.id'];
$pname = $profiledetalis['name'];
$psharedu = $profiledetalis['shared-users'];
$pratelimit = $profiledetalis['rate-limit'];
$ponlogin = $profiledetalis['on-login'];

echo "<td style='text-align:center;'><a class='btnsmall' href='./?remove-user-profile=".$pid . "' title='Remove User Profile " . $pname . "'>-</a></td>";
echo "<td><a style='color:#000;' title='Open User Profile " . $pname . "' href='./?user-profile=".$pid."'>$pname</a></td>";
//$profiledetalis = $ARRAY[$i];echo "<td>" . $profiledetalis['name'];echo "</td>";
echo "<td>" . $psharedu;echo "</td>";
echo "<td>" . $pratelimit;echo "</td>";

echo "<td>";
$getexpmode = explode(",",$ponlogin);
// get expired mode
$expmode = $getexpmode[1];
if($expmode == "rem"){
	echo "Remove";
}elseif($expmode == "ntf"){
	echo "Notice";
}elseif($expmode == "remc"){
	echo "Remove & Record";
}elseif($expmode == "ntfc"){
	echo "Notice & Record";
}else{
	
}
echo "</td>";
echo "<td>";
// get validity
$getvalid = explode(",",$ponlogin);
echo $getvalid[3];

echo "</td>";
echo "<td>";

$getgracep= explode(",",$ponlogin);
echo $getgracep[4];
echo "</td>";

echo "<td style='text-align:right;'>";
// get price
$getprice = explode(",",$ponlogin);
$price = trim($getprice[2]);
if($price == "" ){
	  echo "";
}else{
	echo " " .number_format($price);
}
echo  "</td>";
echo "</tr>";
}
?>
</table>
</div>