
<?php    
include './header.php';

?>
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">

    <img src="./assets/img/carroussel1.jpeg" class="d-block w-100" alt="..."style="margin: 5% 4% 5% 4%; height : 800px;">
      
      <div class="carousel-caption d-none d-md-block">
        <h5>Le Goût de l'exellence</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="./assets/img/carroussel2.jpeg" class="d-block w-100" alt="..." style="margin: 5% 4% 5% 4%; height : 800px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>Une Evasion de saveur</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="./assets/img/cheese-7952772.jpg" class="d-block w-100" alt="..." style="margin: 5% 4% 5% 4%; height : 800px;">
      <div class="carousel-caption d-none d-md-block">
        <h5>Des produits d'Exeption</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<?php
include 'footer.php';
?>

