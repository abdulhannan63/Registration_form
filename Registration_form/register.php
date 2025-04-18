<?php
$DATABASE_HOST='localhost';
$DATABASE_USER='root';  
$DATABASE_PASS='';
$DATABASE_NAME='form';

$conn = mysqli_connect($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASS,$DATABASE_NAME );

if(mysqli_connect_error()){
    exist('Error connecting to the database'. mysqli_connect_error());
}

if(!isset($_POST['username'],$_POST['password'],$_POST['email'])){
    exit("Empty Field");
}
if(empty($_POST['username']) ||empty( $_POST['password']) || empty($_POST['email'])){
    exit("value Empty");
}
if($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')){
    $stmt->bind_param('s',$_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows>0) {
        echo 'Username Already Exists. Try Again';
    }else{
        if($stmt= $conn->prepare('INSERT INTO users (username,password,email) VALUES (?,?,?)')){
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $stmt->bind_param('sss',$_POST['username'],$password,$_POST['email']) ;
            $stmt->execute();
            echo 'Successfully Added';
        }else{
            echo 'Error in Adding the Data';
        }
    }
    $stmt->close();
}
else{
    echo 'Error Occured';
}

$conn->close()

?>