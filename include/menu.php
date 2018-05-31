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
  $shome = "active";
  $mpage = "Dashboard";
}elseif($hotspot == "users" || $userbyprofile != ""){
  $susersl = "active";
  $susers = "active";
  $mpage = "Users";
  $umenu = "menu-open";
}elseif($hotspot == "user-profiles"){
  $suserprofiles = "active";
  $suserprof = "active";
  $mpage = "User Profiles";
  $upmenu = "menu-open";
}elseif($hotspot == "active"){
  $sactive = "active";
  $mpage = "Hotspot Active";
}elseif($hotspot == "hosts" || $hotspot == "hostp" || $hotspot == "hosta"){
  $shosts = "active";
  $mpage = "Hosts";
}elseif($hotspot == "ipbinding" || $hotspot == "binding"){
  $sipbind = $btnmenuactive;
  $mpage = "IP Bindings";
}elseif($hotspot == "log"){
  $log = "active";
  $slog = "active";
  $mpage = "Hotspot Log";
  $lmenu = "menu-open";
}elseif($hotspot == "userlog"){
  $log = "active";
  $sulog = "active";
  $mpage = "User Log";
  $lmenu = "menu-open";
}elseif($hotspot == "selling"){
  $sselling = "active";
  $mpage = "Report";
}elseif($userprofile == "add"){
  $suserprof = "active";
  $sadduserprof = "active";
  $mpage = "User Profiles";
  $upmenu = "menu-open";
}elseif($userprofilebyname != ""){
  $suserprof = "active";
  $mpage = "User Profiles";
}elseif($hotspotuser == "add"){
  $sadduser = "active";
  $mpage = "Users";
  $susers = "active";
  $umenu = "menu-open";
}elseif($hotspotuser == "generate"){
  $sgenuser = "active";
  $mpage = "Users";
  $susers = "active";
  $umenu = "menu-open";
}elseif($userbyname != ""){
  $mpage = "Users";
  $susers = "active";
}elseif($hotspot == "about"){
  $mpage = "About";
  $sabout= "active";
}
?>

  <!-- Navbar -->
  <nav class="main-header navbar navbar navbar-expand  navbar-light bg-primary border-bottom border-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link"><?php echo $mpage;?></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <?php echo $hotspotname;?>
        </a>
      </li>
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown show">
          <a href="./?hotspot=logout" class="nav-link">
            <i class="fa fa-sign-out mr-1"></i> Logout
          </a>
      </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./" class="brand-link">
      <img src="img/favicon.png" alt="Mikhmon Logo" class="brand-image"
           style="opacity: .8">
      <span class="brand-text font-weight-bold">MIKHMON</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="./" class="nav-link <?php echo $shome;?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo $umenu;?>">
            <a href="#" class="nav-link <?php echo $susers;?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Users
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./?hotspot=users" class="nav-link <?php echo $susersl;?>">
                  <i class="fa fa-list nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./?hotspot-user=add" class="nav-link <?php echo $sadduser;?>">
                  <i class="fa fa-user nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./?hotspot-user=generate" class="nav-link <?php echo $sgenuser;?>">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Ganerate</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo $upmenu;?>">
            <a href="#" class="nav-link <?php echo $suserprof;?>">
              <i class="nav-icon fa fa-pie-chart"></i>
              <p>
                Users Profile
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./?hotspot=user-profiles" class="nav-link <?php echo $suserprofiles;?>">
                  <i class="fa fa-list nav-icon"></i>
                  <p>User Profile List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./?user-profile=add" class="nav-link <?php echo $sadduserprof;?>">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p>Add User Profile</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./?hotspot=active" class="nav-link <?php echo $sactive;?>">
              <i class="nav-icon fa fa-wifi"></i>
              <p>Hotspot Active</p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo $lmenu;?>">
            <a href="#" class="nav-link <?php echo $log;?>">
              <i class="nav-icon fa fa-align-justify"></i>
              <p>
                Log
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./?hotspot=log" class="nav-link <?php echo $slog;?>">
                  <i class="fa fa-wifi nav-icon"></i>
                  <p>Hotspot Log</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./?hotspot=userlog" class="nav-link <?php echo $sulog;?>">
                  <i class="fa fa-user nav-icon"></i>
                  <p>User Log</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./?hotspot=selling" class="nav-link <?php echo $sselling;?>">
              <i class="nav-icon fa fa-money"></i>
              <p>Selling Report</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-gear"></i>
              <p>
                Settings
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./admin.php?id=settings" class="nav-link">
                  <i class="fa fa-gear nav-icon"></i>
                  <p>All Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./voucher/editor.php?id=default" class="nav-link">
                  <i class="fa fa-edit nav-icon"></i>
                  <p>Template Editor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./admin.php?id=uplogo" class="nav-link <?php echo $sadduser;?>">
                  <i class="fa fa-upload nav-icon"></i>
                  <p>Upload Logo</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./?hotspot=about" class="nav-link <?php echo $sabout;?>">
              <i class="nav-icon fa fa-info"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-trp">
    <!-- Content Header (Page header) -->
    <div class="content-header p-0">
      <div class="container-fluid p-1">
        <div class="row p-0">
          <div class="col-sm-6">
            <h4 class="m-0 text-light"><?php echo $mpage;?></h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item text-light active"><?php echo $identity;?></li>
              <li class="breadcrumb-item text-light active"><?php echo $userhost;?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
