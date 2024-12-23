<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sobaka.css">
    <link href="https://fonts.googleapis.com/css2?family=Kirang+Haerang&family=Modak&display=swap" rel="stylesheet">
    <title>Pet's Home</title>
</head>
<body>
    <header>
        <p>Pet's home</p>
        <a href="javascript:void(0);" onclick="openModal()">
            <img src="information.png" alt="Contact Info" class="info-icon" style="cursor: pointer;" />
        </a>
        <a href="login.php"> 
            <img src="account.png" alt="Login Icon" class="login-icon" /> 
        </a>
    </header>
    
    <div class="title">Маленькие сердца, которые приятны вашему сердцу...</div>

    <div class="search-box">
        <form action="#">
            <input type="text" id="searchInput" placeholder="Искать здесь...">
            <button type="submit" id="searchButton">поиск</button>
        </form>
    </div>

    <div class="animal-container" style="text-align: center; padding: 20px;">
        <?php
        session_start();
        var_dump($_SESSION);
        require "this_file.php"; 
   
        if (!isset($_SESSION['user'])) {
            echo "Пожалуйста, войдите в систему.";
            exit();
        }

        // Получение ID пользователя из сессии
        $username = $_SESSION['user'];
        $stmt = $conn->prepare("SELECT id FROM users WHERE userName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $user_id = $user_data['id'];

            
            $stmt = $conn->prepare("SELECT a.* FROM favorites_pets f JOIN animals a ON f.animal_id = a.id WHERE f.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $favorites_result = $stmt->get_result();

            // Вывод избранных животных
            echo "<h2>Ваши избранные животные:</h2>";
            if ($favorites_result->num_rows > 0) {
                while ($row = $favorites_result->fetch_assoc()) {
                    echo '<div class="animal-card" onclick="openAnimalModal(\'' . htmlspecialchars($row['name']) . '\', \'' . htmlspecialchars($row['age']) . '\', \'' . htmlspecialchars($row['breed']) . '\')">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>Возраст: ' . htmlspecialchars($row['age']) . '</p>';
                    echo '<p>Порода: ' . htmlspecialchars($row['breed']) . '</p>';
                    echo '<button class="like-button">❤️</button>'; 

                    echo '</div>';
                }
            } else {
                echo "<p>У вас нет избранных животных.</p>";
            }
        } else {
            echo "Пользователь не найден.";
        }

        
        $stmt->close();
        $conn->close(); 
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

    <div id="animalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAnimalModal()">&times;</span>
            <h2 id="animalName"></h2>
            <p id="animalAge"></p>
            <p id="animalBreed"></p>
            <button class="like-button" onclick="likeAnimal()">❤️</button>
            <div id="likeMessage" style="display:none;">Спс бро</div>
        </div>
    </div>

    <script src="sobaka2.js"></script>
</body>
</html>
