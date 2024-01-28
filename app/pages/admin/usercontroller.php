<?php
if ($action == 'add') {
    if (!empty($_POST)) {
      $errors = [];
  
      // Validate username
      if (empty($_POST['username'])) {
        $errors['username'] = 'A username is required';
      } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $errors['username'] = 'Username must contain only letters and numbers';
      } elseif (strlen($_POST['username']) < 8) {
        $errors['username'] = 'Username must be at least 8 characters long';
      }
  
      // Validate password
      if (empty($_POST['password'])) {
        $errors['password'] = 'Password can\'t be empty';
      } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
      }
      if (empty($_POST['retype-password'])) {
        $errors['retype-password'] = 'Confirm password is required';
      } elseif ($_POST['retype-password'] !== $_POST['password']) {
        $errors['retype-password'] = 'Passwords do not match';
      }
      // Validate email
      if (empty($_POST['email'])) {
        $errors['email'] = 'Email can\'t be empty';
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
      } else {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $existingEmail = query($query, ['email' => $_POST['email']]);
        if ($existingEmail) {
          $errors['email'] = 'Email already in use';
        }
      }
  
                //validate image and move to folder name uploads
                $allowed = ['image/jpeg','image/png','image/webp'];
                if(!empty($_FILES['image']['name']))
                {
                  $destination = "";
                  if(!in_array($_FILES['image']['type'], $allowed))
                  {
                    $errors['image'] = "Image format not supported";
                  }else
                  {
                    $folder = "uploads/";
                    if(!file_exists($folder))
                    {
                      mkdir($folder, 0777, true);
                     
                    }
                    $destination = $folder . time() . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                  }
        
                }
      // If no errors, register the user
      if (empty($errors)) {
        $data = [
          'username' => $_POST['username'],
          'email' => $_POST['email'],
          'role' =>  $_POST['role'],
          'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];
  
        $query = "insert into users (username,email,password,role) values (:username,:email,:password,:role)";
            
            if(!empty($destination))
            {
              $data['image']     = $destination;
              $query = "insert into users (username,email,password,role,image) values (:username,:email,:password,:role,:image)";
            }


        query($query, $data);
        redirect('admin/users');
      }
    }
  }
  elseif($action == 'edit')
  {
    $query = "select * from users where id = :id limit 1";
    $row = query_row($query,['id'=>$id]);
    if (!empty($_POST)) {
      if($row){  
      $errors = [];
      
      if (empty($_POST['username'])) {
        $errors['username'] = 'A username is required';
      } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
        $errors['username'] = 'Username must contain only letters and numbers';
      } elseif (strlen($_POST['username']) < 8) {
        $errors['username'] = 'Username must be at least 8 characters long';
      }
  
      // Validate password
      if (empty($_POST['password'])) {
  
      } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
      }
      if (empty($_POST['retype-password'])) {
     
    } elseif ($_POST['retype-password'] !== $_POST['password']) {
      $errors['retype-password'] = 'Passwords do not match';
    }
      // Validate email
      if (empty($_POST['email'])) {
        $errors['email'] = 'Email can\'t be empty';
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
      } else {
        $query = "SELECT id FROM users WHERE email = :email && id!= :id LIMIT 1";
        $existingEmail = query($query, ['email' => $_POST['email'],'id' =>$id]);
        if ($existingEmail) {
          $errors['email'] = 'Email already in use';
        }
      }
        //validate image and move to folder name uploads
        $allowed = ['image/jpeg','image/png','image/webp'];
        if(!empty($_FILES['image']['name']))
        {
          $destination = "";
          if(!in_array($_FILES['image']['type'], $allowed))
          {
            $errors['image'] = "Image format not supported";
          }else
          {
            $folder = "uploads/";
            if(!file_exists($folder))
            {
              mkdir($folder, 0777, false);
             
            }

            $destination = $folder . time() . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
          }

        }
    

      // If no errors, register the user
      if (empty($errors)) {
      $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'role' => $_POST['role'],
        'id' => $id
      ];
      $password_str     = "";
      $image_str        = "";
    
      if (!empty($_POST['password'])) {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_str = "password = :password,";
      } 
      
      if(!empty($destination))
      {
        $data['image'] = $destination;
        $image_str = "image = :image, ";
      }
      $query= "UPDATE users SET username = :username, email = :email, ".$password_str.$image_str."role = :role WHERE id = :id";

        query($query, $data);
        redirect('admin/users');
      }
  }
  }
    }
  elseif($action == 'delete')
  {
    $query = "select * from users where id = :id limit 1";
    $row = query_row($query,['id'=>$id]);
    if ($_SERVER['REQUEST_METHOD']== "POST") {
      if($row){  
      $errors = [];
      if (empty($errors)) {
      $data = [
        'id' => $id
      ];
    
        $query = "DELETE FROM users WHERE id = :id";
        query($query, $data);
        redirect('admin/users');
      }
  }
  }
    }
    
  
    
    

?>