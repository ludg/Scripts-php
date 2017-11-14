<?php
    require_once 'core/init.php';
    
    if(Input::exists()){    
        if(Token::check(Input::get('token'))){
            $validator = new Validate();
            $validator->check($_POST,array(
                'username' => array(
                    'required' => true,
                    'min' => 6,
                    'max' => 30,
                    'unique' => 'users',
                ),
                'password' => array(
                    'required' => true,
                    'min' => 4,
                    'max' => 15,
                ),
                'password_again' => array(
                    'required' => true,
                    'min' => 4,
                    'max' => 15,
                    'matches' => 'password',
                ),
                'name' => array(
                    'required' => true,
                    'min' => 6,
                    'max' => 30,
                ),
            ));

            if($validator->passed()){
                $user = new User;
                $salt = Hash::salt(32);
                
                try {
                    $user->create(array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'),$salt),
                        'name' => Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'salt' => $salt,
                        'group' => 1
                    ));
                    Session::flash('Home','inserted succsessfuly');
                    Redirect::to('index.php');
                } catch (Exception $exc) {
                    die($exc->getMessage());
                }
            }else{
                foreach ($validator->errors() as $error){
                    echo '<p style="color:red;">'.$error.'</p>';
                }
            }
        }
        
    }    
?>

<form action="" method="POST">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>

    <div>
        <label for="new password">Password again</label>
        <input type="password" name="password_again">
    </div>

    <div>
        <label for="confirm password">Name</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div>
        <input type="submit" name="user_data">
    </div>
</form>