var slideIndex = 0;

showSlide();

var timer = setInterval(showSlide, 5000);

var slideContainer = document.getElementById("slide-container");
var slideControl = document.getElementById("slide-container__slide-control");

slideControl.onmouseover = function () {
  clearInterval(timer);
};

slideControl.onmouseleave = function () {
  timer = setInterval(showSlide, 5000);
};

function showSlide() {
  var i;
  var slides = document.getElementsByClassName("slide-container__slide-item");
  var dots = document.getElementsByClassName("slide-container__dot");
  for (var i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (var i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slideIndex++;
  if (slideIndex > slides.length) slideIndex = 1;
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}

function chooseSlide(n) {
  slideIndex = n;
  showSlide();
  clearInterval(timer);
}
