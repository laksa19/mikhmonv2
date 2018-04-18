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
if(!isset($_SESSION["$userhost"])){
	echo "<meta http-equiv='refresh' content='0;url=./' />";
}
?>

<div id='login'>
  <div class="dsettings" style="overflow-x:auto;">
  <form action="" method="post" enctype="multipart/form-data">
  <h3>Upload Logo Voucher</h3>
  <input style="cursor: pointer;" type="file" name="UploadLogo" id="UploadLogo" name="logo">
  <input class="btnsubmitb" type="submit" value="Upload Logo" title="Upload logo" name="submit">
  <a class="btnsubmitb" href="./" title="Home">Home</a>
  <a class="btnsubmitb" href="./admin.php?id=settings" title="Mikhmon Settings">Settings</a>
  </form>
<div>
<div>
<?php
if(isset($_POST["submit"])) {
$logo_dir = "./img/";
$logo_file = $logo_dir . basename($_FILES["UploadLogo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($logo_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["UploadLogo"]["tmp_name"]);
    if($check !== false) {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>Nama file : " . basename($_FILES["UploadLogo"]["name"]). ". </i><br>";
      }else{
          echo "<i>File name is : " . basename($_FILES["UploadLogo"]["name"]). ". </i><br>";
      }
        $uploadOk = 1;
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>File bukan gambar. </i><br>";
      }else{
          echo "<i>File is not an image. </i><br>";
      }
        $uploadOk = 0;
    }


// Check file size
if ($_FILES["UploadLogo"]["size"] > 5000000) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>Ukuran file terlalu besar. </i><br>";
      }else{
          echo "<i>File is too large. </i><br>";
      }
    $uploadOk = 0;
}
// Allow certain file formats
if( basename($_FILES["UploadLogo"]["name"] != "logo.png")) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>Hanya bisa upload logo.png. </i><br>";
      }else{
          echo "<i>Only logo.png are allowed. </i><br>";
      }
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>File tidak diupload. </i><br>";
      }else{
          echo "<i>File was not uploaded. </i><br>";
      }
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["UploadLogo"]["tmp_name"], $logo_file)) {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
           echo "<i>File ". basename( $_FILES["UploadLogo"]["name"]). " telah diupload.</i><br>";
      }else{
           echo "<i>The File ". basename( $_FILES["UploadLogo"]["name"]). " has been uploaded.</i><br>";
      }
       
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          echo "<i>Terjadi masalah ketika upload file. </i><br>";
      }else{
           echo "<i>There was an error uploading your file. </i></i><br>";
      }
        
    }
}
}
?>
