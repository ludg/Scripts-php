<?php
    require_once 'core/init.php';
    $user = new User;
    if(!$user->isLoggedIn()){
        Redirect::to('index.php');
    }
    if(Input::exists()){    
        if(Token::check(Input::get('token'))){
            $validator = new Validate();
            $validator->check($_POST,array(
                'password' => array(
                    'required' => true,
                    'min' => 4,
                    'max' => 15,
                ),
                'new_password' => array(
                    'required' => true,
                    'min' => 4,
                    'max' => 15,
                ),
                'confirm_password' => array(
                    'required' => true,
                    'min' => 4,
                    'max' => 15,
                    'matches' => 'new_password',
                ),
            ));
            
            if($validator->passed()){
                if(Hash::make(Input::get('password'),$user->data()->salt) !== $user->data()->password){
                    echo 'Your password is wrong';
                }else{
                    try {
                        $salt = Hash::salt(32);
                        $user->update(array(
                            'password' => Hash::make(Input::get('new_password'),$salt),
                            'salt'     => $salt
                        ));
                        Session::flash('Home','Senha alterada com sucesso');
                        Redirect::to('index.php');
                    } catch (Exception $exc) {
                        die($exc->getMessage());
                    }
                }  
            }else{
                foreach ($validator->errors() as $error){
                    echo $error.'<br>';
                }
            }
        }
        
    }    
?>

<form action="" method="POST">
    <div>
        <label for="password">Old password</label>
        <input type="password" name="password" autocomplete="off">
    </div>

    <div>
        <label for="new password">New Password</label>
        <input type="password" name="new_password" autocomplete="off">
    </div>

    <div>
        <label for="confirm password">New Password again</label>
        <input type="password" name="confirm_password" value="" autocomplete="off">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div>
        <input type="submit" name="user_data">
    </div>
</form>