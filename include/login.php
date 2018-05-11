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

<div class="login-box">
  <div class="login-logo"><img src="img/favicon.png" alt="MIKHMON Logo" style="opacity: .8">
  
    <div><b style="color:#fff">MIKHMON</b></div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div style="text-align:center"></div>
      <center><h3>LOGIN</h3></center>
		  <?php if(isset($_POST['login'])){ echo '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fa fa-ban"></i> Alert!</h5>';
				  print_r($error);
                echo'</div>'; }?>
      <form autocomplete="off" action="" method="post">
        <div class="form-group has-feedback">
          <input class="form-control" type="text" name="user" placeholder="User" required="1" autofocus>
          
        </div>
        <div class="form-group has-feedback">
          <input class="form-control" type="password" name="pass" placeholder="Password" required="1">
          
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
		        <input class="btn btn-primary btn-block " type="submit" name="login" value="Login">
		  
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

</body>
</html>