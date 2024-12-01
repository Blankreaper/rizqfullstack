document.addEventListener("DOMContentLoaded", () => {
    const dropdownToggle = document.querySelector(".dropdown-toggle");
    const navItem = dropdownToggle.closest(".nav__item");

    dropdownToggle.addEventListener("click", (e) => {
        e.preventDefault();
        navItem.classList.toggle("active");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!navItem.contains(e.target)) {
            navItem.classList.remove("active");
        }
    });
});









var indexValue = 1;
showImg(indexValue);

// Set an interval to change the slider every 4 seconds (4000 milliseconds)
setInterval(function() {
    side_slide(1);
}, 4000);

function btm_slide(e) {
    showImg(indexValue = e);
}

function side_slide(e) {
    indexValue += e;
    const totalImages = document.querySelectorAll('.images img').length;

    if (indexValue > totalImages) {
        indexValue = 1; // Loop back to the first image
    } else if (indexValue < 1) {
        indexValue = totalImages; // Loop back to the last image
    }

    showImg(indexValue);
}

function showImg(e) {
    const images = document.querySelectorAll('.images img');
    const sliders = document.querySelectorAll('.btm-slides span');

    // Hide all images
    images.forEach(image => image.style.display = "none");

    // Reset all slider backgrounds
    sliders.forEach(slider => slider.style.background = "rgba(255,255,255,0.1)");

    // Show the current image and highlight the corresponding slider dot
    images[e - 1].style.display = "block";
    sliders[e - 1].style.background = "white";
}
