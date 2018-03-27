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
include_once('../include/config.php');
include_once('../lib/routeros_api.class.php');

$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, $passwdhost );

$uprofname = $_GET['name'];
if($uprofname != ""){
  $getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$uprofname"));
  $ponlogin = $getprofile[0]['on-login'];
  $getvalid = explode(",",$ponlogin)[3];
  $getprice = explode(",",$ponlogin)[2];
  if($getprice == 0){}else{$price = "| ".$curency." ".number_format($getprice);}
  echo '<b>'.$getvalid.' '.$price.'</b>';
}
?>