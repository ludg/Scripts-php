<?php
require_once 'core/init.php';

if(Session::exists('Home')){
    echo Session::flash('Home');
}

$user = new User();
//echo 

if($user->isLoggedIn()){ ?>
<a href="profile.php?user=<?php echo $user->data()->username; ?>"><?php echo $user->data()->name;  ?></a>
    
    <ul>
        <li><a href="update.php">Update</a></li>
        <li><a href="changepasswod.php">Change Password</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <?php 
        if($user->hasPermission('admin')){
            echo 'Admin';
        }else{
            echo 'User';
        }
    ?>
<?php }else{ ?>
    <p>Utilizador nao logado</p>
    <p><a href="login.php">LOGIN</a></p>
    <p><a href="register.php">REGISTER</a></p>
<?php } ?>
