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
}

  $btnmenuactive = "font-weight: bold;background-color: #f9f9f9; color: #000000";
if($hotspot == "home" || substr($url,-1) == "/"){
  $shome = $btnmenuactive;
}elseif($hotspot == "users" || $userbyprofile != "" || $userbyname != "" || $hotspotuser != ""){
  $susers = $btnmenuactive;
}elseif($hotspot == "user-profiles"){
  $suserprofiles = $btnmenuactive;
}elseif($hotspot == "active"){
  $sactive = $btnmenuactive;
}elseif($hotspot == "log"){
  $slog = $btnmenuactive;
}elseif($hotspot == "selling"){
  $sselling = $btnmenuactive;
}elseif($userprofile != ""){
  $suserprofiles = $btnmenuactive;
}
?>
<div class="main">
<div class="menubg">
<div>
  <span id="titleapp" style="color:#f9f9f9; font-weight:bold; text-shadow: 1px 1px 4px #424242;"><strong style="font-size:25px;">MIKHMON</strong><strong style="font-size:12px;"> v2</strong></span>
  <span id="close"><a class="btnmenu" href="./?hotspot=logout" title="Logout">Logout</a></span>
</div>
<table class="tmenu">
  <tr>
    <td>
      <strong style="font-size:12px; color:#f9f9f9; text-shadow: 1px 1px 4px #424242;"> [MikroTik Hotspot Monitor]</strong>
    </td>
  </tr>
  <tr>
    <td>
      <a class="btnmenu" style="<?php echo $shome;?>" href="./" title="Home">Home</a>
      <a class="btnmenu" style="<?php echo $susers;?>" href="./?hotspot=users" title="Hotspot Users">Users</a>
      <a class="btnmenu" style="<?php echo $suserprofiles;?>" href="./?hotspot=user-profiles" title="User Profile">User Profiles</a>
      <a class="btnmenu" style="<?php echo $sactive;?>" href="./?hotspot=active" title="Hotspot Active">Active</a>
      <a class="btnmenu" style="<?php echo $slog;?>" href="./?hotspot=log" title="Hotspot Log">Log</a>
      <a class="btnmenu" style="<?php echo $sselling;?>" href="./?hotspot=selling" title="Selling"><?php echo $curency;?></a>
      <a class="btnmenu" href="./admin.php?id=settings" title="Mikhmon Settings">Settings</a>
    </td>
  </tr>
</table>
</div>