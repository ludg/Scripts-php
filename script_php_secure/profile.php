<?php
require_once 'core/init.php';
if(!Input::get('user')){
    Redirect::to('index.php');
}else{
    $username = Input::get('user');
    $user = new User($username);
    if(!$user->exists()){
        Redirect::to(404);
    }else{
        $data = $user->data();
    }
    ?>
    <h1>User<?php echo escape($data->username) ?></h1>
    <p>Full name: <?php echo escape($data->name) ?></p>
<?php } ?>