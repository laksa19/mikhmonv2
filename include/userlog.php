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

// load ip user pass MikroTik
include_once('./config.php');

if(!isset($_SESSION["$userhost"])){
	echo "<meta http-equiv='refresh' content='0;url=./' />";
}else{

$idhr = $_GET['idhr'];
$idbl = $_GET['idbl'];
$remdata = ($_POST['remdata']);

if(isset($remdata)){
  if(strlen($idhr) > "0"){
	if ($API->connect( $iphost, $userhost, $passwdhost )) {
	  $API->write('/system/script/print', false);
	  $API->write('?source='.$idhr.'', false);
	  $API->write('=.proplist=.id');
	  $ARREMD = $API->read();
	  for ($i=0;$i<count($ARREMD);$i++) {
	  $API->write('/system/script/remove', false);
	  $API->write('=.id=' . $ARREMD[$i]['.id']);
	  $READ = $API->read();
	    
	}
	}
  }elseif(strlen($idbl) > "0"){
  if ($API->connect( $iphost, $userhost, $passwdhost )) {
	  $API->write('/system/script/print', false);
	  $API->write('?owner='.$idbl.'', false);
	  $API->write('=.proplist=.id');
	  $ARREMD = $API->read();
	  for ($i=0;$i<count($ARREMD);$i++) {
	  $API->write('/system/script/remove', false);
	  $API->write('=.id=' . $ARREMD[$i]['.id']);
	  $READ = $API->read();
	    
	}
	}
  
}
  echo "<script>window.location='./?hotspot=selling'</script>";
}
  
}


if(strlen($idhr) > "0"){
  if ($API->connect( $iphost, $userhost, $passwdhost )) {
	$API->write('/system/script/print', false);
	$API->write('?=source='.$idhr.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idhr;
	$shf = "hidden";
	$shd = "text";
}elseif(strlen($idbl) > "0"){
  if ($API->connect( $iphost, $userhost, $passwdhost )) {
	$API->write('/system/script/print', false);
	$API->write('?=owner='.$idbl.'');
	$ARRAY = $API->read();
	$API->disconnect();
  }
	$filedownload = $idbl;
	$shf = "hidden";
	$shd = "text";
}elseif($idhr == "" || $idbl == ""){
  if ($API->connect( $iphost, $userhost, $passwdhost )) {
	$API->write('/system/script/print', false);
	$API->write('?=comment=mikhmon');
	$ARRAY = $API->read();
	$API->disconnect();
}
$filedownload = "all";
$shf = "text";
$shd = "hidden";
}
?>
		<script>
			function downloadCSV(csv, filename) {
			  var csvFile;
			  var downloadLink;
			  // CSV file
			  csvFile = new Blob([csv], {type: "text/csv"});
			  // Download link
			  downloadLink = document.createElement("a");
			  // File name
			  downloadLink.download = filename;
			  // Create a link to the file
			  downloadLink.href = window.URL.createObjectURL(csvFile);
			  // Hide download link
			  downloadLink.style.display = "none";
			  // Add the link to DOM
			  document.body.appendChild(downloadLink);
			  // Click download link
			  downloadLink.click();
			  }
			  
			  function exportTableToCSV(filename) {
			    var csv = [];
			    var rows = document.querySelectorAll("#userlog tr");
			    
			   for (var i = 0; i < rows.length; i++) {
			      var row = [], cols = rows[i].querySelectorAll("td, th");
			   for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);
        csv.push(row.join(","));
        }
        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
        }
        
        window.onload=function() {
          var sum = 0;
          var dataTable = document.getElementById("selling");
          
          // use querySelector to find all second table cells
          var cells = document.querySelectorAll("td + td + td + td");
          for (var i = 0; i < cells.length; i++)
          sum+=parseFloat(cells[i].firstChild.data);
          
          var th = document.getElementById('total');
          th.innerHTML = th.innerHTML + (sum) ;
        }
		</script>
<div>
<section class="content p-0 bg-trp">
<div class="col-12 p-1">
<div class="card">
<div class="card-header p-2">
	<h3 class="card-title pull-left">User Log</h3>
</div>
<!-- /.card-header -->
<div class="card-body p-1">
<div class="row">
<div class="col-sm-12">
		<div>	   
		  <input class="form-control form-control-sm mx-1 my-1" style="float:left; max-width: 150px;" type="<?php echo $shf;?>" id="filterData" onkeyup="fTgl()" placeholder="Filter date" title="Filter date"> 
		  <input class="form-control form-control-sm mx-1 my-1" style="float:left; max-width: 150px;" type="<?php echo $shd;?>" id="filterData1" onkeyup="fTgl1()" placeholder="Filter Username" title="Filter Username">&nbsp;
		  <button class="btn btn-sm btn-primary mx-1 my-1" onclick="exportTableToCSV('user-log-mikhmon-<?php echo $filedownload;?>.csv')" title="Download user log"><i class="fa fa-download"></i> CSV</button>
		  <button class="btn btn-sm btn-primary mx-1 my-1" onclick="location.href='./?hotspot=userlog';" title="Reload all data"><i class="fa fa-search"></i> ALL</button>
		</div>  
		  <div style="padding-top:10px; overflow-x:auto; overflow-y:auto; max-height: 70vh;">
			<table id="userlog" class="table table-sm table-bordered table-hover text-nowrap">
				<thead class="thead-light">
				<tr>
				  <th colspan=6 >User Log <?php echo $filedownload;?></th>
				</tr>
				<tr>
					<th >Date</th>
					<th >Time</th>
					<th >Username</th>
					<th >address</th>
					<th >Mac Address</th>
					<th >Validity</th>
				</tr>
				</thead>
				<?php
					$TotalReg = count($ARRAY);

						for ($i=0; $i<$TotalReg; $i++){
						  $regtable = $ARRAY[$i];
						  echo "<tr>";
							echo "<td>";
							$getname = explode("-|-",$regtable['name']);
							$getowner = $regtable['owner'];
							$tgl = $getname[0];
							$getdy = explode("/",$tgl);
							$m = $getdy[0];
							$dy = $getdy[1]."/".$getdy[2];
							echo "<a style='color:#000;' href='./?hotspot=userlog&idbl=".$getowner ."' title='Filter user log month : ".$getowner."'>$m/</a><a style='color:#000;' href='./?hotspot=userlog&idhr=".$tgl ."' title='Filter userlog day : ".$tgl."'>$dy</a>";
							echo "</td>";
							echo "<td>";
							$ltime = $getname[1];
							echo $ltime;
							echo "</td>";
							echo "<td>";
							$username = $getname[2];
							echo $username;
							echo "</td>";
							echo "<td>";
							$addr = $getname[4];
							echo $addr;
							echo "</td>";
							echo "<td>";
							$mac = $getname[5];
							echo $mac;
							echo "</td>";
							echo "<td>";
							$val = $getname[6];
							echo $val;
							echo "</td>";
							echo "</tr>";
							}
				?>
			</table>
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

<!-- Modal -->
<div class="modal fade" id="remdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure to Delete?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	
	<?php

	echo "<form autocomplete='off' method='post' action=''>";
	echo "<center>";
	echo "<input type='submit' name='remdata' title='Yes' class='btn btn-primary' value='Yes'/>&nbsp;";
	echo '<button type="button" class="btn btn-danger" data-dismiss="modal" title="No">No</button>';
	echo "</center>";
	echo "</form>";

  	?>
      </div>
    </div>
  </div>
</div>
</div>		
		
<script>
function fTgl() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterData");
  filter = input.value.toUpperCase();
  table = document.getElementById("userlog");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function fTgl1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterData1");
  filter = input.value.toUpperCase();
  table = document.getElementById("userlog");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
