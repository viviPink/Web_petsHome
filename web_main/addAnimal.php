<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sobaka.css">
    <link href="https://fonts.googleapis.com/css2?family=Kirang+Haerang&family=Modak&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <p>Pet's home</p>
    </header>
    
    <div class="title">Маленькие сердца, которые хотят домой...</div>
    <ul class="menu">
        <li><a href="javascript:void(0);" onclick="openModal()">Контакты</a></li>
        <li><a href="#">О нас</a></li>
        <li><a href="login.html">Аккаунт</a></li>
    </ul>

    <div class="animal-container" style="text-align: center; padding: 20px;">
    <?php
        $servername = "localhost"; 
        $username = "root";         
        $password = "";             
        $dbname = "petshome";      

        $conn = new mysqli($servername, $username, $password, $dbname);


        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Получение данных о животных
        $sql = "SELECT * FROM animals";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод данных о каждом животном
            while ($row = $result->fetch_assoc()) {
                echo '<div class="animal-card">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>Возраст: ' . htmlspecialchars($row['age']) . '</p>';
                echo '<p>Порода: ' . htmlspecialchars($row['breed']) . '</p>';
                echo '<button class="like-button">❤️ Лайк</button>';
                echo '</div>';
            }
        } else {
            echo "<p>нет собаки</p>";
        }

        $conn->close(); // Закрываем подключение
        ?>
    </div>

    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Контакты для связи</h2>
            <p>Email: example@example.com</p>
            <p>Телефон: 11111</p>
        </div>
    </div>

    <script src="sobaka.js"></script>
</body>
</html>
