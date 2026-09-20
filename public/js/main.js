document.addEventListener('DOMContentLoaded', function () {
  // 1. Logika Slider Kategori
  const slider = document.getElementById('categorySlider');
  const btnLeft = document.getElementById('scrollLeft');
  const btnRight = document.getElementById('scrollRight');

  if (slider && btnLeft && btnRight) {
    btnLeft.addEventListener('click', function () {
      slider.scrollBy({ left: -260, behavior: 'smooth' });
    });

    btnRight.addEventListener('click', function () {
      slider.scrollBy({ left: 260, behavior: 'smooth' });
    });
  }

  // 2. Logika Toggle Wishlist / Like
  const wishlistButtons = document.querySelectorAll('.btn-wishlist');

  wishlistButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const icon = this.querySelector('i');
      this.classList.toggle('active');

      if (this.classList.contains('active')) {
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
      } else {
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
      }
    });
  });
});