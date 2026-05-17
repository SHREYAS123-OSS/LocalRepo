function explore() {
    alert("Welcome to Smart Gym Management System 💪");
}

/* Scroll Animation */
window.addEventListener("scroll", function() {
    let navbar = document.querySelector(".navbar");
    if(window.scrollY > 50){
        navbar.style.background = "black";
    } else {
        navbar.style.background = "rgba(0,0,0,0.6)";
    }
});
