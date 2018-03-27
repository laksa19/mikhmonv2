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
$id = $_GET['id'];
include_once('./include/headhtml.php');
include_once('./include/config.php');
include_once('./lib/routeros_api.class.php');


if($id == "login" || substr($url,-1) == "p"){

if(isset($_POST['login'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
		if($user == $userhost && $pass == $passwdhost){
			$_SESSION["$userhost"]=$user;
				echo "<script>window.location='.'</script>";
		}elseif ($user == $useradm && $pass == $passadm){
		  $_SESSION["$userhost"]=$user;
  			echo "<script>window.location='./admin.php?id=settings'</script>";
		}else{
			$error = "Username atau Password tidak sesuai.";
	}
}

include_once('./include/login.php');

}elseif(!isset($_SESSION["$userhost"])){
  echo "<script>window.location='./admin.php?id=login'</script>";
}elseif($id == "settings"){
  echo "<div id='login'>";
  include_once('./include/settings.php');
  echo "<div>";
}elseif($id == "connect"){
  $API = new RouterosAPI();
  $API->debug = false;
  $API->connect( $iphost, $userhost, $passwdhost );
  $getidentity = $API->comm("/system/identity/print");
  $identity = $getidentity[0]['name'];
  if($identity == "" ){
    $_SESSION["connect"] = "Not connected";
    echo "<script>window.location='./admin.php?id=settings'</script>";
  }else{
    $_SESSION["connect"] = "Connected";
    echo "<script>window.location='./admin.php?id=settings'</script>";
  }
}
?>