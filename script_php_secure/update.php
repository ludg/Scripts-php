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
                'name' => array(
                    'required' => true,
                    'min' => 6,
                    'max' => 30,
                ),
            ));
            
            if($validator->passed()){
                
                
                try {
                    $user->update(array(
                        'name' => Input::get('name'),
                    ));
                    Session::flash('Home','Updated succsessfuly');
                    Redirect::to('index.php');
                } catch (Exception $exc) {
                    die($exc->getMessage());
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
        <label for="password">Name</label>
        <input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div>
        <input type="submit" name="user_data">
    </div>
</form>