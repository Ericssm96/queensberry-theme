<?php 
/*
    Template Name: Queens club Template
*/
get_header(); ?>



<main>
    <header class="banner">
        <h1>Queens Club</h1>
    </header>
  <article class="introduction-cards">
      <div class="wrapper">
          <div class="card">
              <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic1.png" alt="">
              <p class="card-text">Embarque em uma viagem GBM - Grupos Brasileiros no Mundo</p>
          </div>
          <div class="separator">
              <i class="fa-solid fa-chevron-down mb-separator"></i>
              <i class="fa-solid fa-chevron-right lg-separator"></i>
          </div>
          <div class="card">
              <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic2.png" alt="">
              <p class="card-text">Cadastre-se no Queens Club</p>
          </div>
          <div class="separator">
              <i class="fa-solid fa-chevron-down mb-separator"></i>
              <i class="fa-solid fa-chevron-right lg-separator"></i>
          </div>
          <div class="card">
              <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic3.png" alt="">
              <p class="card-text">Acumule pontos a cada viagem</p>
          </div>
          <div class="separator">
              <i class="fa-solid fa-chevron-down mb-separator"></i>
              <i class="fa-solid fa-chevron-right lg-separator"></i>
          </div>
          <div class="card">
              <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic4.png" alt="">
              <p class="card-text">Troque por descontos progressivos em seus futuros embarques</p>
          </div>
      </div>
  </article>
  <article class="first-cta-area">
      <div class="wrapper">
          <div class="content-area">
              <strong>JÁ SÃO MAIS DE 13 MIL CLIENTES CADASTRADOS. FAÇA PARTE VOCÊ TAMBÉM DESTE CLUBE EXCLUSIVO.</strong>
              <a href="<?= home_url() ?>/queensclub-cadastro" class="btn">Cadastre-se</a>
          </div>
          <div class="img-area">
              <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-IMAGEM1.jpg" alt="Casal sorrindo no meio da árvores">
          </div>
      </div>
  </article>
  <article class="second-cta-area">
      <div class="wrapper">
          <div class="img-area">
              <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-IMAGEM2.jpg" alt="Casal remando um um caiaque.">
          </div>
          <div class="content-area">
              <strong>ACUMULE PONTOS A CADA VIAGEM E TROQUE POR DESCONTOS PROGRESSIVOS EM SEUS FUTUROS EMBARQUES.</strong>
              <button class="btn">Veja o regulamento</button>
          </div> 
      </div>
  </article>
  <article class="points-cta">
    <div class="overlay"></div>
      <div class="wrapper">
          <strong>Quem já viajou possui pontos acumulados. <br> Quanto mais você viajar, mais você vai ganhar.</strong>
          <button class="btn">Consulte seus pontos</button>
      </div>
  </article>
  <section class="testimonials" x-data="{
    gallerySwiper: new Swiper('.testimonials .swiper', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,
      shortSwipes: true,
      breakpoints: {
        1: {
          slidesPerView: 1,
          spaceBetween: 0
        },
        768: {
          navigation: {
            nextEl: '.testimonials .swiper-button-next',
            prevEl: '.testimonials .swiper-button-prev',
          },
          pagination: {
            el: '.testimonials .swiper-pagination',
            clickable: true
          }
        }
      }
    }),
  }">
      <div class="wrapper swiper">
        <h2>Depoimentos</h2>
          <div class="swiper-wrapper slider-presentation">
            <div class="swiper-slide">       
              <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide1.jpg" alt="Egito e Dubai e seus contrastes">
              <div class="text">
                <blockquote>Excelente excursão. Ótimo grupo de participantes. Alegre, unido e agradável. Parabéns aos guias. Parabéns à Queensberry.</blockquote>
                <div class="quote-info">
                  <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
                  <p>G.G. - São Paulo - SP</p>
                  <p>Fevereiro/2022</p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">       
              <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide2.jpg" alt="Egito e Dubai e seus contrastes">
              <div class="text">
                <blockquote>Excelente excursão. Ótimo grupo de participantes. Alegre, unido e agradável. Parabéns aos guias. Parabéns à Queensberry.</blockquote>
                <div class="quote-info">
                  <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
                  <p>G.G. - São Paulo - SP</p>
                  <p>Fevereiro/2022</p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">       
              <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide3.jpg" alt="Egito e Dubai e seus contrastes">
              <div class="text">
                <blockquote>Excelente excursão. Ótimo grupo de participantes. Alegre, unido e agradável. Parabéns aos guias. Parabéns à Queensberry.</blockquote>
                <div class="quote-info">
                  <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
                  <p>G.G. - São Paulo - SP</p>
                  <p>Fevereiro/2022</p>
                </div>
              </div>
            </div>
          </div>

          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
      </div>
    </section>
</main>

<?php get_footer(); ?>