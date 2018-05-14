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

include_once('./config.php');
include_once('./lib/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;


if(!isset($_SESSION["$userhost"])){
	header("Location:./");
}

$url = $_SERVER['REQUEST_URI'];
if(isset($_POST['save'])){
	$setupdata = ($_POST['setupdata']);
	$siphost = ($_POST['ipmik']);
	$suserhost = ($_POST['usermik']);
	$spasswdhost = ($_POST['passmik']);
	$suseradm = ($_POST['useradm']);
	$spassadm = ($_POST['passadm']);
    $shotspotname = ($_POST['hotspotname']);
    $sdnsname = ($_POST['dnsname']);
    $scurency = ($_POST['curency']);
    $reload = ($_POST['areload']);
    $iface = ($_POST['iface']);
    if($reload < 5 ){$sareload = 5;}elseif($reload >= 5){$sareload = $reload;}
 
		// Save Local
		if($setupdata == "local"){
		$mconfig = './include/config.php';
		$handleconfig = fopen($mconfig, 'w') or die('Cannot open file:  '.$mconfig);
		
		$dataconfig = '<?php $iphost="'.$siphost.'"; $userhost="'.$suserhost.'"; $passwdhost="'.$spasswdhost.'"; $useradm="'.$suseradm.'"; $passadm="'.$spassadm.'"; $hotspotname="'.$shotspotname.'"; $dnsname="'.$sdnsname.'"; $curency="'.$scurency.'";  $areload="'.$sareload.'";  $iface="'.$iface.'";?>';
    
		fwrite($handleconfig, $dataconfig);
		
		$mareload = './js/autoreload.js';
		$handleareload = fopen($mareload, 'w') or die('Cannot open file:  '.$mareload);
		
		$dataareload = ' $(document).ready(function(){ var interval = "'.$sareload.'000"; setInterval(function() { $("#reloadHome").load("./include/home.php"); }, interval); setInterval(function() { $("#reloadHotspotActive").load("./include/hotspotactive.php"); }, interval);});';
    
		fwrite($handleareload, $dataareload);
		
		
	// Export to MikroTik
	}elseif($setupdata == "export"){
	  $API->connect( $iphost, $userhost, $passwdhost);
	   $arrID=$API->comm("/system/script/getall",
						  array(
				  ".proplist"=> ".id",
				  "?name" => "mikhmonv2",
				  ));
	    $API->comm("/system/script/remove", array(
	    ".id" => $arrID[0][".id"],
	    ));
	  
      $export = "$shotspotname-|-$sdnsname-|-$scurency-|-$sareload-|-$iface";
  
    $API->comm("/system/script/add", array(
					  "name" => "mikhmonv2",
					  "source" => "$export",
			));
  
  
//Import from MikroTik
	}elseif($setupdata == "import"){
	 $API->connect( $iphost, $userhost, $passwdhost);
	 $getmikhmondata = $API->comm("/system/script/print", array(
	    "?name" => "mikhmonv2"));
    $import = $getmikhmondata[0]['source'];
    if($import == ""){}else{
    $importv = explode("-|-",$import);
   $shotspotname = $importv[0];
   $sdnsname = $importv[1];
   $scurency = $importv[2];
   $sareload = $importv[3];
   $iface = $importv[4];

	  $mconfig = './include/config.php';
		$handleconfig = fopen($mconfig, 'w') or die('Cannot open file:  '.$mconfig);
		
		$dataconfig = '<?php $iphost="'.$siphost.'"; $userhost="'.$suserhost.'"; $passwdhost="'.$spasswdhost.'"; $useradm="'.$suseradm.'"; $passadm="'.$spassadm.'"; $hotspotname="'.$shotspotname.'"; $dnsname="'.$sdnsname.'"; $curency="'.$scurency.'"; $areload="'.$sareload.'";  $iface="'.$iface.'";?>';
    
		fwrite($handleconfig, $dataconfig);
		
		$mareload = './js/autoreload.js';
		$handleareload = fopen($mareload, 'w') or die('Cannot open file:  '.$mareload);
		
		$dataareload = ' $(document).ready(function(){ var interval = "'.$sareload.'000"; setInterval(function() { $("#reloadHome").load("./include/home.php"); }, interval); setInterval(function() { $("#reloadHotspotActive").load("./include/hotspotactive.php"); }, interval);});';
    
		fwrite($handleareload, $dataareload);
	}
	}
	$_SESSION["connect"] = "";
	include('./include/config.php');
	$_SESSION["$userhost"]=$userhost;
	}
?>
<script>
  function PassMk(){
    var x = document.getElementById('passmk');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
    function PassAdm(){
    var x = document.getElementById('passadm');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
  }}
</script>


<div style="padding: 10px;" class="register-box settings card-primary">
  <div class="card card-primary">
    <div class="card-body">
    	<form autocomplete="off" method="post" action="">
    		<div class="card card-primary">
    		    <div class="card-header">
    		    	<h3 class="card-title">Mikhmon Settings</h3>
    		    </div>
    			<div class="card-body">
        			<div class="form-group">
            			<div class="input-group">
              				<select class="form-control" style="float:left;" name="setupdata" required="1"> 
								<option value="local" title="Save local Mikhmon">Save Local</option>
								<option value="export" title="Export to MikroTik">Export Mikhmon data to MikroTik</option>
								<option value="import" title="Import from MikroTik">Import Mikhmon data  from MikroTik</option>
							</select>
							<div class="input-group-append ">
							<input class="input-group-text" type="submit" style="cursor: pointer;" name="save" value="Save"/>
							<a class="input-group-text" href="./admin.php?id=connect" title="Test connection to MikroTik ">Connect</a>
        					<?php if($_SESSION["$userhost"] != "$userhost"){ echo '<a class="input-group-text" href="./admin.php?id=login" title="Login">Login</a>';
							}else{echo '<a class="input-group-text"  href="./" title="Dashboard">Dashboard</a>';}?>      
              				</div>
            			</div>
          			</div>

    			</div>
    		</div>
		<div class="card card-primary">
        	<div class="card-header">
            	<h3 class="card-title">MikroTik<?php echo " <b>". $_SESSION["connect"]."</b>";?></h3>
        	</div>
        		<div class="card-body">
    				<div class="row">  
						<table class="table table-sm">
							<tr>
	  							<td>IP MikroTik  </td><td><input class="form-control form-control-sm" type="text" size="15" name="ipmik" title="IP MikroTik / IP Cloud MikroTik" value="<?php echo $iphost; ?>" required="1"/></td>
							</tr>
							<tr>
								<td>Username  </td><td><input class="form-control form-control-sm" id="usermk" type="text" size="10" name="usermik" title="User MikroTik" value="<?php echo $userhost; ?>" required="1"/></td>
							</tr>
							<tr>
							<td>Password  </td><td>
								<div class="input-group">
        							<input class="form-control form-control-sm" id="passmk" type="password" size="10" name="passmik" title="Password MikroTik" value="<?php echo $passwdhost ;?>" required="1"/>
            						<div class="input-group-append">
                						<span class="input-group-text"><input title="Show/Hide Password" type="checkbox" onclick="PassMk()"></span>
            						</div>
    							</div>
								</td>
							</tr>
						</table>
        			</div>
        		</div>
    	</div>
	<div class="card card-primary">
       	<div class="card-header">
           <h3 class="card-title">Admin</h3>
        </div>
    <div class="card-body">
        <div class="row">		
	<table class="table table-sm">
	<tr>
	<td>Username  </td><td><input class="form-control form-control-sm" id="useradm" type="text" size="10" name="useradm" title="User Admin" value="<?php echo $useradm; ?>" required="1"/></td>
	</tr>
	<tr>
	<td>Password  </td><td>
	<div class="input-group">
        <input class="form-control form-control-sm" id="passadm" type="password" size="10" name="passadm" title="Password Admin" value="<?php echo $passadm; ?>" required="1"/>
             <div class="input-group-append">
                <span class="input-group-text"><input title="Show/Hide Password" type="checkbox" onclick="PassAdm()"></span>
             </div>
    </div>
	</td>
	</tr>
	<tr>
		<td style="text-align:left" colspan=2>
		<strong>Please change username and password Admin.</strong>
		</td>
	</tr>
	</table>
        </div>
        </div>
    </div>
	<div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Mikhmon Data</h3>
              <!-- /.card-tools -->
        </div>
            <!-- /.card-header -->
    <div class="card-body">
    <div class="row">
	<table class="table table-sm">
	<tr>
	<td>Hotspot Name  </td><td><input class="form-control form-control-sm" type="text" size="15" maxlength="50" name="hotspotname" title="Hotspot Name" value="<?php echo $hotspotname; ?>" required="1"/></td>
	</tr>
	<tr>
	<td>DNS Name  </td><td><input class="form-control form-control-sm" type="text" size="15" maxlength="500" name="dnsname" title="DNS Name [IP->Hotspot->Server Profiles->DNS Name]" value="<?php echo $dnsname; ?>" required="1"/></td>
	</tr>
	<tr>
	<td>Curency  </td><td><input class="form-control form-control-sm" type="text" size="3" maxlength="4" name="curency" title="Curency" value="<?php echo $curency; ?>" required="1"/></td>
	</tr>
	<tr>
	<td>Auto Reload</td><td>
	<div class="input-group">
        <input class="form-control form-control-sm" type="number" min="5" max="60" name="areload" title="Auto Reload in sec [min 5s]" value="<?php echo $areload; ?>" required="1"/>
            <div class="input-group-append">
                <span class="input-group-text">sec</span>
            </div>
        </div>
	</td>
	</tr>
	<tr>
	<td>Traffic Ether  </td><td><input class="form-control form-control-sm" type="number" min="1" max="99" name="iface" title="Traffic Interface" value="<?php echo $iface; ?>" required="1"/></td>
	</tr>
	<tr>
	<td colspan="2"><small>Mikhmon V2.9</small></td>
	</tr>
	</table>
    </div>
    </div>
    </div>
</form>

</div>
    <!-- /.login-card-body -->
</div>
</div>
<!-- /.login-box -->
<script type="text/javascript">
	var mk = document.getElementById('usermk');
  	var adm = document.getElementById('useradm');
	useradm.addEventListener("input", function (e) {
  	if (mk.value === adm.value){
  		alert('Username MikroTik should not be the same with username Admin');
  		adm.value = '';
  	}});
</script>





