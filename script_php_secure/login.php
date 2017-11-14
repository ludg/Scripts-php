<?php
    require_once 'core/init.php';
    
    if(Input::exists()){    
        if(Token::check(Input::get('token'))){
            $validator = new Validate();
            $validator->check($_POST,array(
                'username' => array('required' => TRUE),
                'password' => array('required' => TRUE),
            ));
            
            if($validator->passed()){
                $remember = (Input::get('remember') === 'on')? TRUE :FALSE;
                $user = new User();
                $login = $user->login(Input::get('username'),Input::get('password'),$remember);
                if($login){
                    Redirect::to('index.php');
                }else{
                    echo 'Erro';
                }
            }else{
                foreach ($validator->errors() as $error){
                    echo $error.'<br>';
                }
            }
        }
    }    

?>

<form role="form" method="POST" action="">
    <div class="">
        <label for="email">Email address:</label>
        <input type="text" class="form-control" id="email" name="username">
    </div>
    
    <div class="">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" name="password" autocomplete="off">
    </div>
    <input type="hidden" value="<?php echo Token::generate() ?>" name="token">
    <div class="checkbox">
        <label><input name="remember" type="checkbox"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>