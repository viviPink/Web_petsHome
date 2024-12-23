
console.log("Загрузка sobaka.js"); 

const userMenu = document.querySelector('.user-menu');
const dropdownMenu = document.querySelector('.dropdown-menu');

userMenu.addEventListener('mouseenter', () => {
    dropdownMenu.style.display = 'block';
});

userMenu.addEventListener('mouseleave', () => {
    dropdownMenu.style.display = 'none';
});

dropdownMenu.addEventListener('mouseenter', () => {
    dropdownMenu.style.display = 'block';
});

dropdownMenu.addEventListener('mouseleave', () => {
    dropdownMenu.style.display = 'none';
});


function openModal() {
    document.getElementById("contactModal").style.display = "block";
}

function openAnimalModal(name, age, breed,description) {
    
    document.getElementById('animalName').innerText = name;
    document.getElementById('animalAge').innerText = 'Возраст: ' + age;
    document.getElementById('animalBreed').innerText = 'Порода: ' + breed;
    document.getElementById('description').innerText = 'Описание: ' + description;

    console.log('description'); 
    
    document.getElementById('animalModal').style.display = 'block';
}

function closeModal() {
    document.getElementById("contactModal").style.display = "none";
}


window.onclick = function(event) {
    const modal = document.getElementById("contactModal");
    if (event.target == modal) {
        closeModal();
    }
}

function closeAnimalModal() {
    document.getElementById('animalModal').style.display = 'none';
}

function likeAnimal() {
    document.getElementById('likeMessage').style.display = 'block';
}



function filterAnimals() {
    var sliderValue = document.getElementById("animalSlider").value;
    
    
    var form = document.querySelector('.search-box form');
    
    
    var sliderInput = document.createElement("input");
    sliderInput.type = "hidden";
    sliderInput.name = "animal_type"; 
    sliderInput.value = sliderValue; 

    form.appendChild(sliderInput);
    
    form.submit();
};