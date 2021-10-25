let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");
let collapse = document.querySelectorAll(".collapse");

btn.onclick = function() {
  sidebar.classList.toggle("active");
  if (sidebar.className == "sidebar active") {
  } else {
    for (let i = 0; i < collapse.length; i++) {
      collapse[i].className = ("collapse");
    }
  }
}
