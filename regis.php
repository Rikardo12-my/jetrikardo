<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pge</title>
</head>
    <style>
        body{
            background: linear-gradient(to right,rgb(117, 243, 203),rgb(184, 165, 188)); 
            background: linear-gradient(to right, #00c6ff, #0072ff); 
            background: linear-gradient(to right,rgb(103, 207, 245),rgb(210, 212, 213));

        }
        .formregis{
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color:rgb(135, 145, 158);
        }
        button{
            background-color:cream;
            border-radius: 8px;
             cursor: pointer;
        }
        h1{
            text-align:center;
            margin-top:30px;
        }
        
    </style>
<body>

    <h1>Form Register</h1>

    <div class="formregis">
    <div class="box-with-shadow"></div>


        <form action="daftar.php" method="post">
            Username : <br>
            <input type="text" name="username" id="" ><br> <br>
            Password : <br>
            <input type="text" name="password" id=""> <br> <br>
            Email :  <br>
            <input type="text" name="email" id=""> <br> <br>
            
            <button type="submit">Daftar</button>

        </form>
    </div>

</body>
</html>