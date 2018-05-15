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

<div>
<section class="content bg-trp">
<div class="">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3 class="card-title pull-left">
        <?php
				  if($counttuser < 2 ){echo "$counttuser item  ";
				  }elseif($counttuser > 1){echo "$counttuser items  ";}
				?>    
    </h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<div class="row">
<div class="col-sm-12">
			  
<div class="div-t">			   
<table id="tFilter" class="table table-sm table-bordered table-hover text-nowrap">
  <thead>
  <tr>
    <th style="min-width:75px;" ></th>
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input class="form-control form-control-sm" style="width:80%;" type="text" id="filterTable" size="auto" onkeyup="fTable()" placeholder="Server" title="Filter by Hotspot Server">
      </div>
    </th>
    <th colspan="2" style="min-width:85px;" >
      <div style="width:80%;">
        <input class="form-control form-control-sm" style="width:80%;" type="text" id="filterTable1" size="auto" onkeyup='fTable1()' placeholder="Name" title="Filter by Name">
      </div>
    </th>
    <th>
      <select class="form-control form-control-sm" onchange="window.location.href=this.value;" title="Filter by Profile">
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
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input class="form-control form-control-sm" style="width:80%;" type="text" id="filterTable3" size="auto" onkeyup='fTable3()' placeholder="Uptune" title="Filter by Uptime">
      </div>
    </th>
    <th style="min-width:85px;" >
      <div style="width:80%;">
        <input class="form-control form-control-sm" style="width:80%;" type="text" id="filterTable2" size="auto" onkeyup="fTable2()" placeholder="Comment" title="Filter by Comment">
      </div>
    </th>
    <th class="text-center align-middle" colspan="3">Print</th>
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
	echo "<td style='text-align:center;'><a  title='Remove ".$uname. "' href=./?remove-hotspot-user=".$uid . "><i class='fa fa-minus-square text-danger'></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	if($udisabled == "true"){ $tcolor = "#ccc"; echo "<a title='Enable User ".$uname . "'  href='./?enable-hotspot-user=".$uid . "'><i class='fa fa-lock text-dark'></i></a></td>";}else{ $tcolor = "#000";echo "<a title='Disable User ".$uname . "'  href='./?disable-hotspot-user=".$uid . "'><i class='fa fa-unlock text-dark'></i></a></td>";}
	echo "<td style='color:".$tcolor.";'>" . $userver;echo "</td>";
  if($uname == $upass){$usermode = "vc";}else{$usermode = "up";} 
  $popup = "javascript:window.open('./voucher/print.php?user=".$usermode."-".$uname."&qr=no','_blank','width=310,height=450').print();";
	echo "<td style='color:".$tcolor.";'><a title='Open User ".$uname . "' style='color:".$tcolor.";' href=./?hotspot-user=".$uid . "><i class='fa fa-edit'></i> ". $uname." </a>";echo '</td><td class"text-center"><a style="color:'.$tcolor.';"  title="Print Thermal" href="'.$popup.'"><i class="fa fa-print text-right"></i></a></td>';
	echo "<td style='color:".$tcolor.";'>" . $uprofile;echo "</td>";
	echo "<td style='color:".$tcolor.";'>" . $uuptime;echo "</td>";
	echo "<td style='color:".$tcolor.";'>"; if($uname == "default-trial"){}else{echo $ucomment;}; echo "</td>";
	echo "<td style='color:".$tcolor.";'>";

	if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print' href='./voucher/print.php?id=" . $ucomment . "&qr=no' target='_blank'>Default</a>";echo "</td>";
	}
  echo "<td style='color:".$tcolor.";'>";
  if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print QR' href='./voucher/print.php?id=" . $ucomment . "&qr=yes' target='_blank'> QR</a>";echo "</td>";
  }
  echo "<td style='color:".$tcolor.";'>";
  if(substr($ucomment,0,2) == "vc" || substr($ucomment,0,2) == "up"){echo "<a style='color:".$tcolor.";' title='Print Small' href='./voucher/print.php?id=" . $ucomment . "&small=yes' target='_blank'> Small</a>";echo "</td>";
  }
	echo "</tr>";
	}
?>
  </tbody>
</table>
</div>
</div>
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
	
	
	
