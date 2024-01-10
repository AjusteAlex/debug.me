
var sidenav = document.getElementById("menu-responsive");
var openBtn = document.getElementById("menu-responsive-open");
var closeBtn = document.getElementById("menu-responsive-action");

openBtn.onclick = openNav;
closeBtn.onclick = closeNav;

function openNav() {
  sidenav.style.display = 'block';
}

function closeNav() {
  sidenav.style.display = 'none';
}