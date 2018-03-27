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
	    header("Location:#");
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
	    header("Location:#");
	}
	}
  
}}}


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
			    var rows = document.querySelectorAll("#selling tr");
			    
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
		<div style="overflow-x:auto; overflow-y:auto;  max-height: 70vh;">
		  <div>
		    <?php if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){?>
		      <ul>
		        <li>Filter berdasarkan hari klik pada [19/2018].</li>
		        <li>Filter berdasarkan bulan klik pada [jan/].</li>
		        <li>Click CSV untuk mengunduh.</li>
		      </ul>
		    <?php }else{?>
		      <ul>
		        <li>Filter by day click on [19/2018].</li>
		        <li>Filter by month day click on [jan/].</li>
		        <li>Klik CSV to download.</li>
		      </ul>
		    <?php }?>
		    </p>
		  </div>
		  <input style="float:left;" type="<?php echo $shf;?>" id="filterData" size="15" onkeyup="fTgl()" placeholder="Filter date" title="Filter selling date">
		  <button class="btnsubmitb" onclick="exportTableToCSV('report-mikhmon-<?php echo $filedownload;?>.csv')" title="Download selling report">CSV</button>
		  <button class="btnsubmitb" onclick="location.href='./?hotspot=selling';" title="Reload all data">ALL</button>
		  <input style="float:left;" type="<?php echo $shd;?>" name="remdata" class="btnsubmitb" onclick="location.href='#remdata';" title="Delete Data <?php echo $filedownload;?>" value="Delete data <?php echo $filedownload;?>"><br>
			<table id="selling" style="white-space: nowrap;" class="zebra" >
				<tr>
				  <th colspan=2 >Selling report <?php echo $filedownload;?><b style="font-size:0;">,</b></th>
				  <th style="text-align:right;">Total</b></th>
				  <th style="text-align:right;" id="total"></th>
				</tr>
				<tr>
					<th >Date</th>
					<th >Time</th>
					<th >User</th>
					<th style="text-align:right;">Price <?php echo $curency;?></th>
				</tr>
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
							echo "<a style='color:#000;' href='./?hotspot=selling&idbl=".$getowner ."' title='Filter selling report month : ".$getowner."'>$m/</a><a style='color:#000;' href='./?hotspot=selling&idhr=".$tgl ."' title='Filter selling report day : ".$tgl."'>$dy</a>";
							echo "</td>";
							echo "<td>";
							$ltime = $getname[1];
							echo $ltime;
							echo "</td>";
							echo "<td>";
							$username = $getname[2];
							echo $username;
							echo "</td>";
							echo "<td style='text-align:right;'>";
							$price = $getname[3];
							echo $price;
							echo "</td>";
							echo "</tr>";
							}
				?>
			</table>
		</div>
	</div>
	<div id="remdata" class="modal-window">
		  <div>
			<a style="font-wight:bold;"href="#" title="Close" class="modal-close">X</a>
	<?php
	echo "<div style='overflow-x:auto;'>";
	echo "<p style='text-align:center;'>Are you sure to delete data<br> $filedownload?</p>";

	echo "<form autocomplete='off' method='post' action=''>";
	echo "<center>";
	echo "<input type='submit' name='remdata' title='Yes' class='btnsubmit' value='Yes'/>";
	echo "<a class='btnsubmit' href='#' title='No'>No</a>";
	echo "</center>";
	echo "</form>";
	
	echo "</div>";

  ?>
    </div>
	<script>
	function fTgl() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("filterData");
  filter = input.value.toUpperCase();
  table = document.getElementById("selling");
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
	</script>
