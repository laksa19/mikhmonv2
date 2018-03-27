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
?>
<?php
error_reporting(0);

include('../include/config.php');
include('../lib/formatbytesbites.php');

if(!isset($_SESSION["$userhost"])){
	header("Location:../admin.php?id=login");
}
$url = $_SERVER['REQUEST_URI'];
$id = $_GET['id'];
if($id == "default" || $id == "rdefault"){
  $idt = "template";
}elseif($id == "thermal" || $id == "rthermal"){
  $idt = "template-thermal";
}elseif($id == "small" || $id == "rsmall"){
  $idt = "template-small";
}
  if(isset($_POST['save'])){
    $template = './'.$idt.'.php';
		$handle = fopen($template, 'w') or die('Cannot open file:  '.$template);
		
		$data = ($_POST['editor']);
    
		fwrite($handle, $data);
		
		//header("Location:$url");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>.:: MIKHMON ::.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<link rel="icon" href="../img/favicon.png" />
		<link rel="stylesheet" href="../css/style.css" media="screen">
		<style>
body {
  color: #fff;
  background-color: #607D8B;
  font-size: 14px;
  font-family:  'Helvetica', arial, sans-serif;
}
textarea.editor{
  font-size:12px;
  background-color: #3D4241;
  color:#fff;
  box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
b{
  text-shadow: 1px 1px 4px #424242;
}

		</style>
	</head>
	<body align="center">
	  <form autocomplete="off" method="post" action="">
	    <table>
	      <tr>
	        <td>
	          <b style="float:left;">| Variable</b>
	        </td>
	        <td style="float:left;">
	          <b>| Editor </b><input type="submit" style="font-weight:bold;" title="Save template" class="btnsubmit" name="save" value="Save"/>
	          <a class="btnsubmit" href="../" title="Close">Close</a>
	          <a class="btnsubmit" href="./editor.php?id=default" title="Default voucher template">Default</a>
	          <a class="btnsubmit" href="./editor.php?id=thermal" title="Default voucher template for thermal printer">Thermal</a>
	          <a class="btnsubmit" href="./editor.php?id=small" title="Small voucher template">Small</a>
	          <b>| Reset</b>
	          <a class="btnsubmit" href="./editor.php?id=rdefault" title="Default voucher template">Default</a>
	          <a class="btnsubmit" href="./editor.php?id=rthermal" title="Default voucher template for thermal printer">Thermal</a>
	          <a class="btnsubmit" href="./editor.php?id=rsmall" title="Small voucher template">Small</a>
	        </td>
	      </tr>
	      <tr>
	        <td>
	          <textarea disabled class="editor" rows=40 cols=30>
	            <?=file_get_contents ('./variable.php');?>
	          </textarea>
	        </td>
	        <td>
	          <textarea id="editor" class="editor" name="editor" rows=40 cols=150>
	            <?php if($id == "default"){?>
	            <?=file_get_contents ('./template.php');?>
	            <?php }elseif($id == "thermal"){?>
	              <?=file_get_contents ('./template-thermal.php');?>
	            <?php }elseif($id == "small"){?>
	              <?=file_get_contents ('./template-small.php');?>
	           <?php }elseif($id == "rdefault"){?>
	            <?=file_get_contents ('./default.php');?>
	            <?php }elseif($id == "rthermal"){?>
	              <?=file_get_contents ('./default-thermal.php');?>
	            <?php }elseif($id == "rsmall"){?>
	              <?=file_get_contents ('./default-small.php');?>
	            <?php }?>
	          </textarea>
	        </td>
	      </tr>
	    </table>
	  </form>
</body>
</html>
