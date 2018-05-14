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

// array color
$color = array ('1'=>'danger','warning','success','info','primary','secondary');


// routeros api

include_once('../lib/routeros_api.class.php');
include_once('../lib/formatbytesbites.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect( $iphost, $userhost, $passwdhost );
}
?>

<div id="reloadHome">
  <!-- Main content -->
    <section class="content bg-trp">
      <div class="container-fluid">
      <div class="row">
    
      <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-calendar"></i></span>
        <?php
        // get MikroTik system clock
          $getclock = $API->comm("/system/clock/print");
          $clock = $getclock[0];
        ?>
              <div class="info-box-content">
                <span class="info-box-text">System Date & Time</span>
                <span class="info-box-number"><?php echo $clock['date'];?></span>
                <span class="info-box-number"><?php echo $clock['time'];?></span>
                <div class="progress">
                  <div class="progress-bar" style="width:<?php echo substr($clock['time'],-2)/60*100;?>%"></div>
                </div>
                <span class="progress-description">
                  
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
      <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-info-circle"></i></span>
<?php
// get system resource MikroTik
$getresource = $API->comm("/system/resource/print");
$resource = $getresource[0];
// get routeboard info
$getrouterboard = $API->comm("/system/routerboard/print");
$routerboard = $getrouterboard[0];
?>
              <div class="info-box-content">
                <span class="info-box-number">
        Board Name : <?php echo $resource['board-name'];?><br/>
        Model : <?php echo $routerboard['model']?><br/>
        Router OS : <?php echo $resource['version']?>
                </span>
                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
    <div class="col-md-4 col-sm-12 col-12">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-server"></i></span>
              <div class="info-box-content">
                <span class="info-box-number">
        CPU Load <?php echo $resource['cpu-load']?>%<br/>
        Free Memory <?php echo formatBytes($resource['free-memory'],0)?><br/>
        Free HDD <?php echo formatBytes($resource['free-hdd-space'],0)?>
                </span>
                <div class="progress">
                  <div class="progress-bar" style="width: <?php echo $resource['cpu-load'];?>%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
      
          </div>
    
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-8 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fa fa-wifi mr-1"></i>
                  Hotspot
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
        
        <!-- Small boxes (Stat box) -->
        <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
          <a href="./?hotspot=active">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-laptop"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Hotspot Active</span>
                <span class="info-box-number">
<?php
// get & counting hotspot active
  $counthotspotactive = $API->comm("/ip/hotspot/active/print", array(
    "count-only" => ""));
  if($counthotspotactive < 2 ){echo "$counthotspotactive item";
  }elseif($counthotspotactive > 1){
  echo "$counthotspotactive items";
  }
?>              </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
          <a href="./?hotspot=users">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Hotspot Users</span>
                <span class="info-box-number">
<?php
// get & counting hotspot users
  $countallusers = $API->comm("/ip/hotspot/user/print", array(
    "count-only" => ""));
  if($countallusers < 2 ){echo "$countallusers item";
  }elseif($countallusers > 1){
  echo "$countallusers items";}
?>              </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
          <a href="./?hotspot-user=add">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Add</span>
                <span class="info-box-number">User</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
          <a href="./?hotspot-user=generate">
            <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Generate</span>
                <span class="info-box-number">Users</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
          </div>
      </div>
    </div>
  </div><!-- /.card-body -->
</div>
<!-- /.card -->
<div class="card">
  <div class="card-header d-flex p-0">
    <h3 class="card-title p-3">
      <i class="fa fa-area-chart mr-1"></i>
        Traffic
    </h3>
  </div><!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content p-0">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
             <div class="info-box bg-<?php echo $color[rand(1,6)];?>">
              <span class="info-box-icon bg-<?php echo $color[rand(1,6)];?>"><i class="fa fa-tachometer"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"></span>
                <span class="info-box-number">
<?php
// get traffic ether
  $getinterface = $API->comm("/interface/print");
  $interface = $getinterface[$iface-1]['name'];
  $getinterfacetraffic = $API->comm("/interface/monitor-traffic", array(
    "interface" => "$interface",
    "once" => "",
    ));
  $tx = formatBites($getinterfacetraffic[0]['tx-bits-per-second'],0);
  $rx = formatBites($getinterfacetraffic[0]['rx-bits-per-second'],0);
?>
      <?php echo $interface;?><br> </span>
                <div class="progress">
                  <div class="progress-bar" style="width: <?php echo $getinterfacetraffic[0]['tx-bits-per-second']/1000000;?>%"></div>
                </div>
                <span class="progress-description">
                  Tx : <?php echo $tx;?>
                </span>
                <div class="progress">
                  <div class="progress-bar" style="width: <?php echo $getinterfacetraffic[0]['rx-bits-per-second']/1000000;?>%"></div>
                </div>
                <span class="progress-description">
                  Rx : <?php echo $rx;?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
      </div>
    </div><!-- /.card-body -->
  </div>
  <!-- /.card -->
  </section>
         
  <!-- /.Left col -->
  <!-- right col (We are only adding the ID to make the widgets sortable)-->
  <section class="col-lg-4 connectedSortable">
    <!-- Map card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
              <i class="fa fa-user mr-1"></i>
                  Hotspot Log
          </h3>
        </div>
          <div class="card-body">
            <div class="row">
                <textarea style="overflow: auto; width:100%; height:346px; font-size:11px; background-color: #fff; color:#111; border:0;" disabled>
<?php
// move hotspot log to disk
  $getlogging = $API->comm("/system/logging/print", array(
    "?prefix" => "->",));
  $logging = $getlogging[0];
  if($logging['prefix'] == "->"){}else{
  $API->comm("/system/logging/add", array("action" => "disk","prefix" => "->","topics" => "hotspot,info,debug",));
  }
// get hotspot log
  $getlog = $API->comm("/log/print", array(
    "?topics" => "hotspot,info,debug",));
  $log = array_reverse($getlog);
  $TotalReg = count($getlog);
  for ($i=0; $i<$TotalReg; $i++){
  echo "" . $log[$i]['message']."&#13;&#10;";
  }
?>
      </textarea>
</div>
<!-- /.row -->
</div>
</div>
<!-- /.card -->
</section>
<!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

