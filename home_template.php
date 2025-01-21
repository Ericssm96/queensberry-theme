<?php
/*
    Template Name: Home Template
*/
get_header();
?>
    <div class="video-overlay"></div>
    <main>
    <section class="banner">
      <video id="video" poster="https://www.queensberry.com.br/imagens//Videos/thumbnail.jpg" autoplay muted loop>
        <source src="https://www.queensberry.com.br/imagens//Videos/site27_04_21.webm"
          type='video/webm; codecs="vp8, vorbis"' />
        <source src="https://www.queensberry.com.br/imagens//Videos/site27_04_21.mp4" type="video/mp4" />
      </video>
      <article class="gbm-cta">
        <strong>GBM 2024</strong>
        <a href="#" rel="noreferrer" target="_blank">Saiba mais</a>
      </article>
    </section>
    <article class="mb-currency-field">
      <strong class="quotation">US$ 1 = R$6,27 | € 1 = R$6,59</strong>
      <p id="quotation-date" class="quotation-date">Data: 04/12/2024 às 12:10</p>
    </article>
    <section class="products" x-init="
    const productSwiper = new Swiper('.products .swiper', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,

      // Navigation arrows
      navigation: {
        nextEl: '.products .swiper-button-next',
        prevEl: '.products .swiper-button-prev',
      },

      breakpoints: {
        1: {
          slidesPerView: 1,
          spaceBetween: 0
        },
        768: {
          slidesPerView: 4,
          spaceBetween: 1
        },
        1260: {
          slidesPerView: 5,
          spaceBetween: 2
        }
      }
    });
    ">
      <div class="wrapper">
        <h2 class="section-title">Nossos Produtos</h2>
        <div class="swiper product-swiper">
          <div class="swiper-wrapper">
            <a href="#" style="background-image: url(<?= get_template_directory_uri() ?>/src/img//slides/01-01-lg.jpg);" class="swiper-slide">
              <div class="slide-overlay"></div>
              <div class="desktop-slide-overlay"></div>
              <div class="text-content">
                <strong>Férias na Neve</strong>
                <div class="retractable-content">
                  <p>Viagens elaboradas para quem procura diversão em família ou entre amigos, com experiências de inverno nos principais destinos que oferecem estrutura e atrações focadas nessa estação do ano.</p>
                  <span class="product-cta">Saiba mais</span>
                </div>
              </div>
            </a>
            <a href="#" style="background-image: url(<?= get_template_directory_uri() ?>/src/img//slides/01-02-lg.jpg);" class="swiper-slide">
              <div class="slide-overlay"></div>
              <div class="desktop-slide-overlay"></div>
              <div class="text-content">
                <strong>GBM - Grupos Brasileiros no Mundo</strong>
                <div class="retractable-content">
                  <p>Viagem em grupo com acompanhamento de guia brasileiro.</p>
                  <span class="product-cta">Saiba mais</span>
                </div>
              </div>
            </a>
            <a href="#" style="background-image: url(<?= get_template_directory_uri() ?>/src/img//slides/01-03-lg.jpg);" class="swiper-slide">
              <div class="slide-overlay"></div>
              <div class="desktop-slide-overlay"></div>
              <div class="text-content">
                <strong>Viagens Peronalizadas</strong>
                <div class="retractable-content">
                  <p>Ideal para quem prefere viajar sozinho, com a família ou amigos.</p>
                  <span class="product-cta">Saiba mais</span>
                </div>
              </div>
            </a>
            <a href="#" style="background-image: url(<?= get_template_directory_uri() ?>/src/img//slides/01-04-lg.jpg);" class="swiper-slide">
              <div class="slide-overlay"></div>
              <div class="desktop-slide-overlay"></div>
              <div class="text-content">
                <strong>Brasil IN</strong>
                <div class="retractable-content">
                  <p>Viagens individuais sob medida pelo Brasil</p>
                  <span class="product-cta">Saiba mais</span>
                </div>
              </div>
            </a>
            <a href="#" style="background-image: url(<?= get_template_directory_uri() ?>/src/img//slides/01-05-lg.jpg);" class="swiper-slide">
              <div class="slide-overlay"></div>
              <div class="desktop-slide-overlay"></div>
              <div class="text-content">
                <strong>Cruzeiros</strong>
                <div class="retractable-content">
                  <p>Marítimos e fluviais para casais, famílias ou grupo de amigos.</p>
                  <span class="product-cta">Saiba mais</span>
                </div>
              </div>
            </a>
          </div>

          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
    </section>

    <!-- DESTAQUES -->

    <section class="featured-content">
      <div class="wrapper">
        <h2>Destaques</h2>
        <div class="items-grid">
          <article class="first-col two-thirds"
            style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/amazonia-hoteis.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Brasil In</h3>
                <h4>A Amazônia é Nossa - Juma Hotéis</h4>
                <p>O pulmão verde do planeta.</p>
                <div class="cta-content">
                  <strong>9 dias / 8 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
          <article class="second-col one-third" style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/seychelles.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Viagens Personalizadas</h3>
                <h4>Seychelles Paradisíaca</h4>
                <p>O Tesouro do Oceano Índico</p>
                <div class="cta-content">
                  <strong>8 dias / 7 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
          <article class="one-third first-col" style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/leste-africano.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Viagens Personalizadas</h3>
                <h4>Aventura Pelo Leste Africano - Quênia e Tanzânia</h4>
                <p>Descubra a natureza única do Quênia e Tanzânia numa jornada emocionante.</p>
                <div class="cta-content">
                  <strong>10 dias / 9 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
          <article class="two-thirds second-col" style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/ilha-mauricio.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Viagens Peronalizadas</h3>
                <h4>Ilha Maurício</h4>
                <p>O encanto da Pérola do Oceano Índico</p>
                <div class="cta-content">
                  <strong>6 dias / 5 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
          <article class="one-half first-col" style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/natal_laponia.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Tours Regulares</h3>
                <h4>Natal na Lapônia Fun Family</h4>
                <p>Com saídas exclusivas de Madri e Barcelona</p>
                <div class="cta-content">
                  <strong>6 dias / 5 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
          <article class="one-half second-col" style="background-image: url(<?= get_template_directory_uri() ?>/src/img/destaques/montreal-quebec.jpeg);">
            <a href="#">
              <div class="card-overlay"></div>
              <div class="desktop-card-overlay"></div>
              <div class="text-content">
                <h3>Tours Regulares</h3>
                <h4>Montreal e Quebec</h4>
                <p>E a Magia do Festival de Inverno.</p>
                <div class="cta-content">
                  <strong>9 dias / 6 noites</strong>
                  <span class="cta">Saiba Mais</span>
                </div>
              </div>
            </a>
          </article>
        </div>
      </div>
    </section>

    <!-- PALAVRA DO ESPECIALISTA -->


    <section class="specialists-review">
      <div class="wrapper">
        <h2>Palavra do Especialista</h2>
        <div class="cards-grid" x-init="
        const reviewsSwiper = new Swiper('.specialists-review .swiper', {
          // Optional parameters
          direction: 'horizontal',
          loop: true,
          autoplay: {
            delay: 10000
          },
          allowTouchMove: false,
          breakpoints: {
            1: {
              slidesPerView: 1,
              spaceBetween: 20
            }
          }
        });
        ">
          <div class="slider-card swiper">
            <div class="swiper-wrapper">
              <article class="swiper-slide">
                <div class="quote">
                  <img src="<?= get_template_directory_uri() ?>/src/img/green-quotation-mark.png" class="quotation-mark" alt="">
                  <h3>O Norte da Grécia merece ser visitado!</h3>
                  <p class="description">A combinação de uma semana no norte, com uma semana entre Atenas e duas ilhas
                    tradicionais, tornarão a viagem muito agradável e interessante.
                    Thessaloníki, o túmulo do Rei Felipe e os mosteiros de Meteora, são imperdíveis.</p>
                </div>
                <div class="author">
                  <div class="info">
                    <strong class="name">Martin Jensen</strong>
                    <p class="ocupation">Fundador</p>
                  </div>
                  <img src="<?= get_template_directory_uri() ?>/src/img/slides/martin-jensen.jpg" class="portrait" alt="Martin Jensen">
                </div>
              </article>
              <article class="swiper-slide">
                <div class="quote">
                  <img src="<?= get_template_directory_uri() ?>/src/img/green-quotation-mark.png" class="quotation-mark" alt="">
                  <h3>A Turquia é um destino espetacular!</h3>
                  <p class="description">
                    O voo de balão na Capadócia, é um dos passeios imperdíveis do destino, que permite apreciar a linda e peculiar paisagem da região. Uma experiência inesquecível!
                </p>
                </div>
                <div class="author">
                  <div class="info">
                    <strong class="name">Vanessa Nomoto</strong>
                    <p class="ocupation">Gerente Operações</p>
                  </div>
                  <img src="<?= get_template_directory_uri() ?>/src/img/slides/vanessa-nomoto.jpg" class="portrait" alt="Vanessa Nomoto">
                </div>
              </article>
            </div>
          </div>
          <div class="slider-card swiper">
            <div class="swiper-wrapper">
              <article class="swiper-slide">
                <div class="quote">
                  <img src="<?= get_template_directory_uri() ?>/src/img/green-quotation-mark.png" class="quotation-mark" alt="">
                  <h3>A Costa Esmeralda tem recantos impressionantes</h3>
                  <p class="description">Uma história que remonta aos fenícios, ilhas paradisíacas como as Ilhas
                    Magdalena, e muito sol. Malta, Sardenha e Ischia: eu recomendo!</p>
                </div>
                <div class="author">
                  <div class="info">
                    <strong class="name">Marco Lourenço</strong>
                    <p class="ocupation">Diretor de Produtos</p>
                  </div>
                  <img src="<?= get_template_directory_uri() ?>/src/img/slides/marco-lourenco.jpg" class="portrait" alt="Marco Lourenço">
                </div>
              </article>
              <article class="swiper-slide">
                <div class="quote">
                  <img src="<?= get_template_directory_uri() ?>/src/img/green-quotation-mark.png" class="quotation-mark" alt="">
                  <h3>Lugar exótico e que mexe com a nossa imaginação: Marrocos</h3>
                  <p class="description">Toda a excentricidade de uma cultura diferente com lindas paisagens, hotéis de luxo e excelentes restaurantes de renome internacional!</p>
                </div>
                <div class="author">
                  <div class="info">
                    <strong class="name">José Luiz Gracie</strong>
                    <p class="ocupation">Gerente de Operações de Incentivos</p>
                  </div>
                  <img class="portrait" src="<?= get_template_directory_uri() ?>/src/img/slides/jose-luiz.jpg" alt="José Luiz Gracie">
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="external-links">
      <article class="queensclub-section">
        <h2>
          <img src="<?= get_template_directory_uri() ?>/src/img/logo-queensclub.png" alt="QueensClub">
        </h2>
        <strong>Quanto mais você viajar, mais você vai ganhar.</strong>
        <a href="#">Saiba Mais</a>
      </article>
      <article class="blog-section">
        <h2>Blog</h2>
        <strong>Uma viagem exploratória, sensorial e exclusiva pelos cinco continentes.</strong>
        <a href="#">Confira</a>
      </article>
    </section>

    <section class="featured-videos" x-data="{
      videoTitles: ['LIVE | TUNÍSIA, A JORNADA', 'LIVE | Arábia Saudita - O Berço do Islã', 'LIVE | Lançamento GBM 2024/2025', 'LIVE | Lançamento FÉRIAS NA NEVE', 'Lançamento BRASIL IN'],
      currentVideoTitle: 'Título do vídeo atual',
      currentSlideIndex: 0,
      videoSwiper: new Swiper('.featured-videos .swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        navigation: {
          nextEl: '.featured-videos .swiper-button-next',
          prevEl: '.featured-videos .swiper-button-prev',
        },
        shortSwipes: false,
        breakpoints: {
          1: {
            slidesPerView: 1,
            spaceBetween: 0
          },
          1024: {
            slidesPerView: 1.7,
            spaceBetween: 20
          },
          1100: {
            slidesPerView: 1.8,
            spaceBetween: 20
          },
          1260: {
            slidesPerView: 2,
            spaceBetween: 20
          },
          1350: {
            slidesPerView: 2.5,
            spaceBetween: 20
          },
          1450: {
            slidesPerView: 2.6,
            spaceBetween: 20
          },
          1550: {
            slidesPerView: 2.5,
            spaceBetween: 20
          },
          1700: {
            slidesPerView: 3,
            spaceBetween: 20
          }
        }
      })
    }" x-init="
    currentVideoTitle = videoTitles[currentSlideIndex]
    videoSwiper.on('navigationPrev', (e)=>{
      if(currentSlideIndex === 0) {
        currentSlideIndex = videoTitles.length - 1;
      } else {
        currentSlideIndex -= 1;
      }
      currentVideoTitle = videoTitles[currentSlideIndex];
    });
    videoSwiper.on('navigationNext', (e)=>{
      if(currentSlideIndex === videoTitles.length - 1) {
        currentSlideIndex = 0;
      } else {
        currentSlideIndex += 1;
      }
      currentVideoTitle = videoTitles[currentSlideIndex];
    })
    ">
      <div class="wrapper">
        <header>
          <h2>Vídeos</h2>
          <h3 x-text="currentVideoTitle"></h3>
        </header>
        <div class="filler"></div>
        <article class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%"
                  src="https://www.youtube-nocookie.com/embed/l2pEIa7Y82o?si=e4jfITaXolmYStZW"
                  title="YouTube video player" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/lGFMtFWI5p8?si=UsuooP-aXZPT8gcA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/yHrsLgJLwA4?si=uQRpuEoolT4A2IQ2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/JBnoB_zEY5A?si=Llh2EQwbql7RM0iX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/17D-bk9Y7Y0?si=zGPowTm9m-89eTvC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
          </div>

          <div class="mobile-controllers">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </article>

        <!-- <div class="desktop-controllers">
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div> -->
      </div>
    </section>
  </main>

  <?php get_footer(); ?>