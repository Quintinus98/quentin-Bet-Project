const button = document.querySelectorAll('.mybutton');
const paragraph = document.getElementsByClassName("output");

for (let i = 0; i < button.length; i++) {
  button[i].addEventListener('click', updateButton);
  
}

function updateButton() {
  paragraph.textContent = "You clicked " + button.value;
}