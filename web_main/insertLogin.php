

<!DOCTYPE html>
<html>

<head>
    <title>Insert Page page</title>
</head>

<body>
    <center>
        <?php

        $conn = mysqli_connect("localhost", "root", "", "petshome");

        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. "
                . mysqli_connect_error());
        }

        $userName = $_REQUEST['userName'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (userName, email, password) VALUES ('$userName', '$email', '$hashedPassword')";


        
        if(mysqli_query($conn, $sql)){
            echo "<h3>data stored in a database successfully."
                . " Please browse your localhost php my admin"
                . " to view the updated data</h3>";

            echo nl2br("\n$userName\n $email\n "
                . "$hashedPassword");
        } else{
            echo "ERROR: Hush! Sorry $sql. "
                . mysqli_error($conn);
        }

        
        mysqli_close($conn);
        ?>
    </center>
</body>

</html>
