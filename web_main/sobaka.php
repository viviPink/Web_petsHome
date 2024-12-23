
<?php
session_start(); 

require "this_file.php"; 


$searchQuery = "";
$sortBy = "name";

// if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search'])) {
//     $searchQuery = trim($_POST['search']);
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (!empty($_POST['search'])) {
        $searchQuery = trim($_POST['search']);
    }

 
    if (!empty($_POST['sort_by'])) {
        $sortBy = $_POST['sort_by'];
    }
}



$sql = "SELECT * FROM animals";
if (!empty($searchQuery)) {
 
    $sql .= " WHERE name LIKE ? OR breed LIKE ?";
}

$sql .= " ORDER BY " . ($sortBy == "age" ? "age" : "name");




$stmt = $conn->prepare($sql); 
if (!empty($searchQuery)) {
    $searchParam = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
}
$stmt->execute();
$result = $stmt->get_result();

?>


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
        <a href="favorite.php">
            <img src="bit.png" alt="Favorite Icon" class="fav-icon" /> 
        </a>
        <a href="javascript:void(0);" onclick="openModal()">
            <img src="information.png" alt="Contact Info" class="info-icon" style="cursor: pointer;" />
        </a>
        <!-- <div class="user-menu">
            <a href="login.html">
                <img src="account.png" alt="Login Icon" class="login-icon" /> 
            </a>
            <div class="dropdown-menu">
                <a href="login.html">Войти</a>
                <a href="my_profiles.php">Мои анкеты</a>
                <a href="exit_sis.php">Выйти</a>
            </div>
        </div>
         -->

         <div class="user-menu">
    <a href="login.html">
        <img src="account.png" alt="Login Icon" class="login-icon" /> 
    </a>
    <div class="dropdown-menu">
        <?php if (isset($_SESSION['user'])): ?>
            <a><?php echo htmlspecialchars($_SESSION['user']); ?></a>
            
            <a href="exit_sis.php">Выйти</a> 
            <a href="my_profiles.php">Мои анкеты</a>
        <?php else: ?>
            <a href="login.html">Войти</a>
        <?php endif; ?>
    </div>
</div>

<a class="user_namnam"><?php echo htmlspecialchars($_SESSION['user']); ?></a>


    </header>
    
    <div class="title">Маленькие сердца, которые хотят домой...</div>

    <div class="search-box">
        <form action="" method="post">
            <input type="text" id="searchInput" name="search" placeholder="Искать здесь...">
           
            <button type="submit" id="searchButton">Поиск</button>
            <select name="sort_by" id="sort_by">
                <option value="name">Сортировать по имени</option>
                <option value="age">Сортировать по возрасту</option>
            </select>
            <button type="submit" id="sortButton">Применить</button>
        </form>
    </div>

    <div class="slider-container">
    <div class="slider-labels">
        <span>Коты</span>
        <span>Все</span>
        <span>Собаки</span>
    </div>
    <input type="range" min="0" max="2" value="1" step="1" id="animalSlider" onchange="filterAnimals()">
</div>


<div class="animal-container" style="text-align: center; padding: 20px;">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="animal-card" onclick="openAnimalModal(\'' . htmlspecialchars($row['name']) . '\', \'' . htmlspecialchars($row['age']) . '\', \'' . htmlspecialchars($row['breed']) . '\', \'' . htmlspecialchars($row['description']) . '\')">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '" class="animal-image" width="300" height="200" />'; 
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>Возраст: ' . htmlspecialchars($row['age']) . '</p>';
                echo '<p>Порода: ' . htmlspecialchars($row['breed']) . '</p>';
                echo '<button class="like-button" data-id="' . htmlspecialchars($row['id']) . '" onclick="toggleLike(this)">❤️</button>';
                echo '</div>';
            }
        } else {
            echo "<p>Собаки с такой характеристикой не найдены.</p>";
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
            <p id="description"></p>
            <button class="like-button" onclick="likeAnimal()">❤️</button>
            <div id="likeMessage" style="display:none;">Спс бро</div>
        </div>
    </div>

    <script src="sobaka2.js"></script>
</body>
</html>
