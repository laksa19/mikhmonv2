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
<div style="overflow-x:auto; overflow-y:auto; max-height: 70vh;">
<table class="zebra" id="tFilter" >
  <tr>
    <th>~</th>
    <th>Time</th>
    <th>
      <div style="width:50%;">
        <input style="width:50%;" type="text" id="filterTable1" size="auto" onkeyup="fTable1()" placeholder="Messages" title="Filter hotspot message">
      </div>
    </th>
  </tr>
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
