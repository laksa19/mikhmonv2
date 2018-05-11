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
include('./include/config.php');

if(!isset($_SESSION["$userhost"])){
	header("Location:./admin.php?id=login");
}else{

// routeros api
include_once('./lib/routeros_api.class.php');
include_once('./lib/formatbytesbites.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, $passwdhost );

$getidentity = $API->comm("/system/identity/print");
  $identity = $getidentity[0]['name'];
  if($identity == ""){
  session_destroy();
  echo "<script>window.location='./?hotspot=login'</script>";
  }
// check url
$url = $_SERVER['REQUEST_URI'];
// get variable
$hotspot = $_GET['hotspot'];
$hotspotuser = $_GET['hotspot-user'];
$userbyname = $_GET['hotspot-user'];
$userbyprofile = $_GET['user-by-profile'];
$removeuseractive = $_GET['remove-user-active'];
$removehost = $_GET['remove-host'];
$removeipbinding = $_GET['remove-ip-binding'];
$removehotspotuser = $_GET['remove-hotspot-user'];
$removeuserprofile = $_GET['remove-user-profile'];
$resethotspotuser = $_GET['reset-hotspot-user'];
$enablehotspotuser = $_GET['enable-hotspot-user'];
$disablehotspotuser = $_GET['disable-hotspot-user'];
$enableipbinding = $_GET['enable-ip-binding'];
$disableipbinding = $_GET['disable-ip-binding'];
$userprofile = $_GET['user-profile'];
$userprofilebyname = $_GET['user-profile'];
$macbinding = $_GET['mac'];
$ipbinding = $_GET['addr'];
$srv = $_GET['srv'];

}
?>
<?php
include_once('./include/headhtml.php');
if(!isset($_SESSION["$userhost"])){
	header("Location:./admin.php?id=login");
}else{
  include_once('./include/menu.php');
}
?>

<?php
// logout
if($hotspot == "logout"){
  echo "<b class='cl-w'>Logout...</b>";
  echo "<div class='loader'></div>";
  session_destroy();
  echo "<script>window.location='./admin.php?id=login'</script>";
}

// redirect to home
elseif(substr($url,-1) == "/"){
  ?>
<?php
  include_once('./include/home.php');
  $_SESSION['ubn'] = "";
}

// hotspot log
elseif($hotspot == "log"){
	include_once('./include/log.php');
}

// about
elseif($hotspot == "about"){
  include_once('./include/about.php');
}

// bad request
elseif(substr($url,-1) == "="){
  echo "<b>Bad request! redirect to Home...</b>";
  echo "<div class='loader'></div>";
  echo "<script>window.location='./'</script>";
}

// hotspot users
elseif($hotspot == "users"){
  $_SESSION['ubp'] = "";
  $_SESSION['hua'] = "";
  include_once('./include/users.php');
}

// hotspot add users
elseif($hotspot == "add-user"){
  $_SESSION['hua'] = "";
  include_once('./include/adduser.php');
}

// hotspot users filter by profile
elseif($userbyprofile != ""){
  $_SESSION['ubp'] = $userbyprofile;
  $_SESSION['hua'] = "";
  include_once('./include/userbyprofile.php');
}

// add hotspot user
elseif($hotspotuser == "add"){
	include_once('./include/adduser.php');
}

// add hotspot user
elseif($hotspotuser == "generate"){
	include_once('./include/generateuser.php');
}

// hotspot users filter by name
elseif(substr($hotspotuser,0,1) == "*"){
  $_SESSION['ubn'] = $hotspotuser;
  $_SESSION['hua'] = "";
	include_once('./include/userbyname.php');
}elseif($hotspotuser != ""){
  $_SESSION['ubn'] = $hotspotuser;
	include_once('./include/userbyname.php');
}

// remove hotspot user
elseif($removehotspotuser != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/removehotspotuser.php');
}

// reset hotspot user
elseif($resethotspotuser != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/resethotspotuser.php');
}

// enable hotspot user
elseif($enablehotspotuser != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/enablehotspotuser.php');
}

// disable hotspot user
elseif($disablehotspotuser != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/disablehotspotuser.php');
}

// user profile
elseif($hotspot == "user-profiles"){
  include_once('./include/userprofile.php');
}

// add  user profile
elseif($userprofile == "add"){
include_once('./include/adduserprofile.php');
}

// User profile by name
elseif(substr($userprofile,0,1) == "*"){
  include_once('./include/userprofilebyname.php');
}elseif($userprofile != ""){
  include_once('./include/userprofilebyname.php');
}


// remove user profile
elseif($removeuserprofile != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/removeuserprofile.php');
}

// hotspot active
elseif($hotspot == "active"){
  $_SESSION['ubp'] = "";
  $_SESSION['hua'] = "hotspotactive";
  echo "<div class='loader'></div>";
  include_once('./include/hotspotactive.php');
}

// hotspot hosts
elseif($hotspot == "hosts" || $hotspot == "hostp" || $hotspot == "hosta"){
  include_once('./include/hosts.php');
}

// hotspot bindings
elseif($hotspot == "binding"){
  include_once('./include/binding.php');
}

// hotspot Ip Bindings
elseif($hotspot == "ipbinding"){
  include_once('./include/ipbinding.php');
}

// enable hotspot user
elseif($enableipbinding != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/enableipbinding.php');
}

// disable hotspot user
elseif($disableipbinding != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/disableipbinding.php');
}

// remove user active
elseif($removeuseractive != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/removeuseractive.php');
}

// remove host
elseif($removehost != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/removehost.php');
}

// remove ipbinding
elseif($removeipbinding != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/removeipbinding.php');
}

// makebinding
elseif($macbinding != ""){
  echo "<b class='cl-w'>Processing...</b>";
  echo "<div class='loader'></div>";
  include_once('./process/makebinding.php');
}

// selling
elseif($hotspot == "selling"){
  include_once('./include/selling.php');
}
?>
  </div>
  <!--
  <footer class="main-footer">
    <strong> <a href="https://laksa19.github.io" target="_blank">Mikhmon</a> &bull; Template by <a href="https://adminlte.io/">AdminLTE</a></strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version </b> 2.9
    </div>
  </footer>
-->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="js/autoreload.js"></script>
<script src="js/mikhmon.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.js"></script>
  </body>
</html>