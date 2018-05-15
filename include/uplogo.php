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
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Nama file : ' . basename($_FILES["UploadLogo"]["name"]). '. </div>';
      }else{
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> File name is : ' . basename($_FILES["UploadLogo"]["name"]). '. </div>';
      }
        $uploadOk = 1;
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> File bukan gambar. </div>';
      }else{
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> File is not an image. </div>';
      }
        $uploadOk = 0;
    }


// Check file size
if ($_FILES["UploadLogo"]["size"] > 5000000) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Ukuran file terlalu besar. </div>';
      }else{
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> File is too large. </div>';
      }
    $uploadOk = 0;
}
// Allow certain file formats
if( basename($_FILES["UploadLogo"]["name"] != "logo.png")) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Hanya bisa upload logo.png. </div>';
      }else{
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Alert!</h5> Only logo.png are allowed. </div>';
      }
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Alert!</h5> File tidak diupload. </div>';
      }else{
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Alert!</h5> File was not uploaded. </div>';
      }
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["UploadLogo"]["tmp_name"], $logo_file)) {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
           $galat = '<div class="alert alert-success alert-dismissible"><h5><i class="icon fa fa-info"></i> Success!</h5> File '. basename( $_FILES["UploadLogo"]["name"]). ' telah diupload. </div>';
      }else{
           $galat = '<div class="alert alert-success alert-dismissible"><h5><i class="icon fa fa-info"></i> Success!</h5> The File '. basename( $_FILES["UploadLogo"]["name"]). ' has been uploaded. </div>';
      }
       
    } else {
      if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
          $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Alert!</h5> Terjadi masalah ketika upload file. </div>';
      }else{
           $galat = '<div class="alert alert-danger alert-dismissible"><h5><i class="icon fa fa-ban"></i> Alert!</h5> There was an error uploading your file </div>';
      }
        
    }
}
}
?>

<div style="padding: 10px;" class="register-box settings card-primary">
  <div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fa fa-upload"></i> Upload Logo Voucher</h3>
    </div>
    <div class="card-body">
    <?php echo $galat;?>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleInputFile">Format file : logo.png </label>
            <div class="input-group">
              <div class="custom-file">
                <input style="cursor: pointer; " type="file" class="custom-file-input" id="exampleInputFile" name="UploadLogo" >
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
              <div class="input-group-append">
                <input style="cursor: pointer; font-size: 14px;" class="input-group-text" type="submit" value="Upload" title="Upload logo" name="submit">
              </div>
            </div>
          </div>
      </form>
    </div>
  <div class="card-footer">
      <a class="btn btn-sm btn-primary mx-1 my-1" href="./" title="Home"><i class='fa fa-tachometer'></i> Dashboard</a>
      <a class="btn btn-sm btn-info mx-1 my-1" href="./admin.php?id=settings" title="Mikhmon Settings"><i class='fa fa-gear'></i> Settings</a>
    </div>
  </div>
</div>
