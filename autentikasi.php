 <?php
    include('koneksi.php');
    $user =$_POST['username'];
    $password =$_POST['password'];
    $sql = "select *from user where username='$user' and password='$password'";
    $exe = $conn->query($sql);
    $banyak = $exe->num_rows;
    if($banyak==1){
        session_start();
        $_SESSION['username']=$user;
        $_SESSION['login']=true;
        header("Location:index.php?page=home");
    }else {
        echo "Username and Password has failed!!";
    }
 ?>