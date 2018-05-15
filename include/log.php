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

  $getlog = $API->comm("/log/print", array(
	  "?topics" => "hotspot,info,debug"));
	$log = array_reverse($getlog);
	$TotalReg = count($getlog);

?>
<div>
<section class="content bg-trp">
<div class="">
<div class="col-12">
<div class="card">
<div class="card-header bg-light">
    <h3 class="card-title">Log</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<div id="example2_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
<div class="row">
<div class="col-sm-12">
        
<div class="input-group input-group-sm" style="max-width: 350px; margin: 5px;">
    <input id="filterTable1" size="auto" onkeyup="fTable1()" placeholder="Filter log messages" title="Filter log message"class="form-control float-right" type="text">
</div>
<div style="padding: 5px;" class="div-t">
<table class="table table-sm" id="tFilter" >
<?php
	for ($i=0; $i<$TotalReg; $i++){
	echo "<tr>";
	echo "<td></td>";
	echo "<td>" . $log[$i]['time'];echo "</td>";
	echo "<td>" . $log[$i]['message'];echo "</td>";
	echo "</tr>";
	}
?>
</table>
</div>
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
