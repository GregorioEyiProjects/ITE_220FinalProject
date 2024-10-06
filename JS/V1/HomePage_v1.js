<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const images = document.querySelectorAll('.order_again_img');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    let currentIndex = 0;

    function showSlide(index) {
        const offset = -index * 100; // Adjust based on the width of images
        sliderWrapper.style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Circular navigation
        showSlide(currentIndex);
    });

    nextButton.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % images.length; // Circular navigation
        showSlide(currentIndex);
    });

    // Optional: Auto-slide
    setInterval(function() {
        nextButton.click();
    }, 3000); // Change slide every 3 seconds
=======
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const images = document.querySelectorAll('.order_again_img');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    let currentIndex = 0;

    function showSlide(index) {
        const offset = -index * 100; // Adjust based on the width of images
        sliderWrapper.style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener('click', function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Circular navigation
        showSlide(currentIndex);
    });

    nextButton.addEventListener('click', function() {
        currentIndex = (currentIndex + 1) % images.length; // Circular navigation
        showSlide(currentIndex);
    });

    // Optional: Auto-slide
    setInterval(function() {
        nextButton.click();
    }, 3000); // Change slide every 3 seconds
>>>>>>> 2465aec46218dbac1bb297b97524c9327b1caeea
});