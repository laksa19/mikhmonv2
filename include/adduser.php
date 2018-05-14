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

  $getprofile = $API->comm("/ip/hotspot/user/profile/print");
  $srvlist = $API->comm("/ip/hotspot/print");
  
  if(isset($_POST['name'])){
    $server = ($_POST['server']);
    $name = ($_POST['name']);
    $password = ($_POST['pass']);
    $profile = ($_POST['profile']);
    $disabled = ($_POST['disabled']);
    $timelimit = ($_POST['timelimit']);
    $datalimit = ($_POST['datalimit']);
    $comment = ($_POST['comment']);
    if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
    if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*1000000000;}
    $API->comm("/ip/hotspot/user/add", array(
	    "server" => "$server",
	    "name" => "$name",
	    "password" => "$password",
	    "profile" => "$profile",
	    "disabled" => "no",
	    "limit-uptime" => "$timelimit",
			"limit-bytes-out" => "$datalimit",
      "comment" => "$comment",
	    ));
    $getuser = $API->comm("/ip/hotspot/user/print", array(
    "?name"=> "$name",
    ));
    $uid =	$getuser[0]['.id'];
    echo "<script>window.location='./?hotspot-user=".$uid."'</script>";
  }
}
?>
<script>
  function PassUser(){
    var x = document.getElementById('passUser');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
</script>

<div>
<section class="content bg-trp">
<div class="">
<div class="col-12">
<div class="card">
<div class="card-header">
    <h3 class="card-title pull-left">Add User</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<div id="example2_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
<div class="row">
<div class="col-sm-12">

<form autocomplete="off" method="post" action="">
<table class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <tr>
    <th colspan="5">
<?php if($_SESSION['ubp'] != ""){
    echo "    <a class='btn btn-sm btn-warning btn-mrg' href='./?user-by-profile=".$_SESSION['ubp']."'> <i class='fa fa-close'></i> Close</a>";
}else{
    echo "    <a class='btn btn-sm btn-warning btn-mrg' href='./?hotspot=users'> <i class='fa fa-close'></i> Close</a>";
}
?>
    <button type="submit" name="save" class="btn btn-sm btn-primary btn-mrg"> <i class="fa fa-save"></i> Save</button>
    </th>
  </tr>
  <tr>
    <td>Server</td>
    <td>
			<select class="form-control form-control-sm" name="server" required="1">
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
    <td>Name</td><td><input class="form-control form-control-sm" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
    <td>Password</td><td>
        <div class="input-group">
          <input class="form-control form-control-sm" id="passUser" type="password" name="pass" autocomplete="new-password" value="" required="1">
            <div class="input-group-append">
              <span class="input-group-text"><input title="Show/Hide Password" type="checkbox" onclick="PassUser()"></span>
            </div>
        </div>
		</td>
  </tr>
  <tr>
    <td>Profile</td><td>
			<select class="form-control form-control-sm" name="profile" required="1">
				<?php $TotalReg = count($getprofile);
				for ($i=0; $i<$TotalReg; $i++){
				  echo "<option>" . $getprofile[$i]['name'] . "</option>";
				  }
				?>
			</select>
		</td>
	</tr>
	<tr>
    <td>Time Limit</td><td><input class="form-control form-control-sm" type="text"  autocomplete="off" name="timelimit" value=""></td>
  </tr>
  <tr>
    <td>Data Limit</td><td>
      <div class="input-group">
        <input class="form-control form-control-sm" type="number" min="0" max="9999" name="datalimit" value="">
          <div class="input-group-append">
            <span class="input-group-text">GB</span>
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td>Comment</td><td><input class="form-control form-control-sm" type="text"  autocomplete="off" name="comment" value=""></td>
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