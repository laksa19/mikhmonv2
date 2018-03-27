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
<div id="login">
  <form autocomplete="off" action="" method="post">
  <br>
    <table style="border:0px;" class="tlogin">
      <td><img src="./img/favicon.png" alt="Mikhmon logo" height="90" width="90" /></td>
    </table>
    <table class="tlogin">
      <tr>
        <th>MIKHMON</th>
      </tr>
      <tr>
        <td>
          <input type="text" name="user" placeholder="User" required="1" autofocus>
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="pass" placeholder="Password" required="1">
        </td>
      </tr>
      <tr>
        <td>
          <input class="btnlogin" type="submit" name="login" value="Login"><p style="font-size: 14px; color:red; "><?php if(isset($_POST['login'])){ print_r($error);}?></p>
        </td>
      </tr>
    </table>
    <br>
</form>
</div>