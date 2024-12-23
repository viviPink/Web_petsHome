

<!DOCTYPE html>
<html>

<head>
    
</head>

<body>
    <center>
        <?php


        $conn = mysqli_connect("localhost", "root", "", "petshome");

        
        if($conn === false){
            die("ERROR: Could not connect. "
                . mysqli_connect_error());
        }

        $petName = $_REQUEST['petName'];
        $petAge = $_REQUEST['petAge'];
        $petBreed = $_REQUEST['petType'];
        $petDescription = $_REQUEST['petDescription'];

        
        if (isset($_FILES['petPhoto']) && $_FILES['petPhoto']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/'; 
            $uploadFile = $uploadDir . basename($_FILES['petPhoto']['name']);

            
            if (move_uploaded_file($_FILES['petPhoto']['tmp_name'], $uploadFile)) {
                
            } else {
                echo "ERROR: Failed to upload file.";
                exit;
            }
        } else {
            echo "ERROR: No file uploaded.";
            exit;
        }



        $sql = "INSERT INTO animals (name, age, breed, description, image_url) VALUES ('$petName', '$petAge', '$petBreed', '$petDescription', '$uploadFile')";


        
        if(mysqli_query($conn, $sql)){
            echo "<h3>data stored in a database successfully."
                . " Please browse your localhost php my admin"
                . " to view the updated data  $petDescription</h3>";
        } else{
            echo "ERROR: Hush! Sorry $sql. "
                . mysqli_error($conn);
        }

        
        mysqli_close($conn);
        ?>
    </center>
</body>

</html>
