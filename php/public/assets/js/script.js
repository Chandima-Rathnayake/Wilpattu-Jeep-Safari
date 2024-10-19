'use strict';



/**
 * navbar toggle
 */

const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navbar = document.querySelector("[data-navbar]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");

const navElemArr = [navOpenBtn, navCloseBtn];

for (let i = 0; i < navElemArr.length; i++) {
  navElemArr[i].addEventListener("click", function () {
    navbar.classList.toggle("active");
  });
}

/**
 * toggle navbar when click any navbar link
 */

const navbarLinks = document.querySelectorAll("[data-nav-link]");

for (let i = 0; i < navbarLinks.length; i++) {
  navbarLinks[i].addEventListener("click", function () {
    navbar.classList.remove("active");
  });
}





/**
 * header active when window scrolled down
 */

const header = document.querySelector("[data-header]");

window.addEventListener("scroll", function () {
  window.scrollY >= 50 ? header.classList.add("active")
    : header.classList.remove("active");
});




 // Get the button
 const mybutton = document.getElementById("backToTop");

 // Show the button when user scrolls down 20px from the top
 window.onscroll = function() {
     scrollFunction();
 };

 function scrollFunction() {
     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
         mybutton.style.display = "block";
     } else {
         mybutton.style.display = "none";
     }
 }

 // Scroll to the top when the button is clicked
 function topFunction() {
     document.body.scrollTop = 0; // For Safari
     document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
 }



 const mapThumbnail = document.getElementById('mapThumbnail');
 const mapModal = document.getElementById('mapModal');
 const closeModal = document.querySelector('.close');
 
 // When the map is clicked, show the modal in the middle of the page
 mapThumbnail.addEventListener('click', function() {
   mapModal.style.display = 'flex';  // Change to 'flex' to center it
 });
 
 // When the map in the modal is clicked, hide the modal
 mapModal.addEventListener('click', function(event) {
   if (event.target !== closeModal) { // Close if not clicking the close button
     mapModal.style.display = 'none';
   }
 });
 
 // When the close button is clicked, hide the modal
 closeModal.addEventListener('click', function() {
   mapModal.style.display = 'none';
 });
 
 
 
 
 

