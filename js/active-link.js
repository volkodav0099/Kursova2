// active-link.js
$(document).ready(function() {
    var currentUrl = window.location.href;
    var menuLinks = document.querySelectorAll('.nav-link');
    menuLinks.forEach(function(link) {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });
});
