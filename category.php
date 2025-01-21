<?php
get_header();

$category = get_queried_object();
$category_name = $category->name;

function get_active_programs() {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasAtivos";

    $programs_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];

    $curl_programs_request = curl_init();

    curl_setopt($curl_programs_request, CURLOPT_URL, $url);
    curl_setopt($curl_programs_request, CURLOPT_POST, true);
    curl_setopt($curl_programs_request, CURLOPT_POSTFIELDS, json_encode($programs_req_payload));
    curl_setopt($curl_programs_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_programs_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_programs_request);
    $response = json_decode($response_json, true);

    curl_close($curl_programs_request);

    return $response;
}

$active_programs_response = get_active_programs();
$active_programs = $active_programs_response["ProgramasAtivosPortal"]["ProgramasAtivoPortal"];
$page_product_group = "Férias na Neve";

function is_item_in_current_product_group($product) {
    global $page_product_group;
    return $product["CategoriaDescricao"] === mb_strtoupper($page_product_group);
    // return $product["CategoriaDescricao"] === "FÉRIAS NA NEVE";
}

$products_in_current_group = array_filter($active_programs, 'is_item_in_current_product_group');

?>

<?php
    foreach($products_in_current_group as $program_items) {
    ?>
<ul>
    <?php
        foreach($program_items as $program_item){
        ?>
    <p><?= $program_item ?></p>
    <?php
        }
        ?>
</ul>
-------
<?php
    }
   ?>
<main>
    <div class="shaded-overlay"></div>
    <section class="product-banner">
        <div class="wrapper">
            <h1 class="product-title">Férias na Neve</h1>
            <div class="product-description">
                <p class="description-text">Viagens elaboradas para quem procura diversão em família ou entre amigos,
                    com experiências de inverno nos principais destinos que oferecem estrutura e atrações focadas nesta
                    estação do ano.</p>
            </div>
        </div>
    </section>
    <section class="product-page-slider" x-data="{
      slideTitles: ['América do Norte', 'Europa'],

      slideDescriptions: ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla et lobortis enim. Suspendisse quis posuere justo. Vivamus ac eros tellus. Nulla lobortis vehicula turpis, a lobortis elit commodo non. Integer mollis felis id odio malesuada, ut vulputate odio pharetra. Maecenas ullamcorper erat pretium massa lacinia, eu lobortis ipsum auctor.', 'Etiam gravida fringilla ante. Pellentesque eget nulla nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce pharetra orci dui, id maximus diam gravida id. Morbi pulvinar quam vitae volutpat molestie. Etiam mollis massa nibh, vitae aliquam lorem dignissim ac.'],

      currentSlideTitle: '',
      currentSlideDescription: '',
      currentSlideIndex: 0,

      productGroupSwiper: new Swiper('.product-page-slider .swiper', {
        // Optional parameters
        direction: 'horizontal',

        // Navigation arrows
        navigation: {
          nextEl: '.product-page-slider .swiper-button-next',
          prevEl: '.product-page-slider .swiper-button-prev',
        },

        loop: true,

        breakpoints: {
          1: {
            loop: true,
            centeredSlides: true,
            slidesPerView: 1.35,
            spaceBetween: 10
          },
          768: {
            centeredSlides: false,
            loop: true,
            slidesPerView: 1.2,
            spaceBetween: 20
          },
          800: {
            centeredSlides: false,
            slidesPerView: 1.35,
            spaceBetween: 20
          },
          830: {
            centeredSlides: false,
            slidesPerView: 1.42,
            spaceBetween: 20
          },
          870: {
            centeredSlides: false,
            slidesPerView: 1.55,
            spaceBetween: 20
          },
          900: {
            centeredSlides: false,
            slidesPerView: 1.7,
            spaceBetween: 20
          },
          950: {
            centeredSlides: false,
            slidesPerView: 1.8,
            spaceBetween: 20
          },
          1024: {
            slidesPerView: 2,
            spaceBetween: 25
          },
          1260: {
            slidesPerView: 1.8,
            spaceBetween: 25
          },
          1360: {
            slidesPerView: 1.9,
            spaceBetween: 25
          },
          1500: {
            slidesPerView: 2.3,
            spaceBetween: 25
          },
          1550: {
            slidesPerView: 2.5,
            spaceBetween: 25
          },
          1600: {
            slidesPerView: 2.7,
            spaceBetween: 25
          },
          1900: {
            slidesPerView: 2.9,
            spaceBetween: 25
          }
        }
      })
    }" x-init="
    currentSlideTitle = slideTitles[currentSlideIndex];
    currentSlideDescription = slideDescriptions[currentSlideIndex];
    productGroupSwiper.on('navigationPrev', (e)=>{
      if(currentSlideIndex === 0) {
        currentSlideIndex = slideTitles.length - 1;
      } else {
        currentSlideIndex -= 1;
      }
      currentSlideTitle = slideTitles[currentSlideIndex];
      currentSlideDescription = slideDescriptions[currentSlideIndex];
    });
    productGroupSwiper.on('navigationNext', (e)=>{
      if(currentSlideIndex === slideTitles.length - 1) {
        currentSlideIndex = 0;
      } else {
        currentSlideIndex += 1;
      }
      currentSlideTitle = slideTitles[currentSlideIndex];
      currentSlideDescription = slideDescriptions[currentSlideIndex];
    })
    ">
        <div class="container">
            <div class="slide-item-description">
                <div class="top">
                    <h2 x-text="currentSlideTitle"></h2>
                    <p x-text="currentSlideDescription"></p>
                </div>
                <div class="bottom">
                    <a href="#" class="schedules-cta">Programas</a>

                    <div class="controls">
                        <img @click="$refs.prevBtnTarget.click()" src="./src/img/prev-btn.png" alt="Slide Anterior">
                        <img @click="$refs.nextBtnTarget.click()" src="./src/img/next-btn.png" alt="Próximo Slide">
                    </div>
                </div>
            </div>
            <div class="swiper products-slide">
                <div class="swiper-wrapper">
                    <a href="#" class="swiper-slide"><img src="./src/img/slides/america_norte_ferias.jpg"
                            alt="Férias na Neve - América do Norte"></a>

                    <a href="#" class="swiper-slide"><img src="./src/img/slides/europa_ferias.jpg"
                            alt="Férias na Neve - Europa"></a>

                    <a href="#" class="swiper-slide"><img src="./src/img/slides/america_norte_ferias.jpg"
                            alt="Férias na Neve - América do Norte"></a>

                    <a href="#" class="swiper-slide"><img src="./src/img/slides/europa_ferias.jpg"
                            alt="Férias na Neve - Europa"></a>
                </div>

                <div x-ref="prevBtnTarget" class="swiper-button-prev"></div>
                <div x-ref="nextBtnTarget" class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <section class="search-related-content" x-data="">
        <article class="search-container">
            <div class="btn-list">
                <h2>Pesquise</h2>
                <div class="list-item">
                    <span class="text-area"><span class="active-indicator">[+]</span>
                        <p>Cadernos</p>
                    </span>
                    <img src="./src/img/i.icone-caderno.png" alt="">
                </div>
                <div class="list-item">
                    <span class="text-area"><span class="active-indicator">[+]</span>
                        <p>Regiões Mundiais</p>
                    </span>
                    <img src="./src/img/icone-globo.png" alt="">
                </div>
            </div>
            <form action="" class="search-form">
                <input type="text" placeholder="Informe seu destino">
                <button class="submit-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div class="filter-area">
                <select name="FILTRO_PRODUTOS" id="filtroProdutos">
                    <option value="" disabled selected>Organizar</option>
                    <option value="alfabCresc">A - Z</option>
                    <option value="alfabDescresc">Z - A</option>
                    <option value="maisProcurados">Mais Procurados</option>
                </select>
            </div>
            <div class="cards-grid">
                <div class="card">
                    <img class="card-img" src="./src/img/img-card-produto.jpg" alt="Imagem card">
                    <div class="card-content">
                        <div class="initial-description">
                            <h3>Grande Hotel Termas de Araxá</h3>
                            <p>Onde luxo e bem-estar se encontram, uma experiência
                                inesquecível!</p>
                            <strong>GO4 Brazil</strong>
                        </div>
                        <div class="complementary-description">
                            <strong>Duração</strong>
                            <p>5 dias / 4 noites</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Visitando</strong>
                            <p>Araxá</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Saídas</strong>
                            <p>Saídas 2024: Saídas específicas de Jan.22 até
                                Nov.25</p>
                        </div>
                        <p class="additional-info">*OUTRA OPÇÃO DE DURAÇÃO: 04 dias/ 03 noites*</p>
                        <div class="spacer"></div>
                        <a href="#" class="card-cta">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img" src="./src/img/img-card-produto.jpg" alt="Imagem card">
                    <div class="card-content">
                        <div class="initial-description">
                            <h3>Grande Hotel Termas de Araxá</h3>
                            <p>Onde luxo e bem-estar se encontram, uma experiência
                                inesquecível!</p>
                            <strong>GO4 Brazil</strong>
                        </div>
                        <div class="complementary-description">
                            <strong>Duração</strong>
                            <p>5 dias / 4 noites</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Visitando</strong>
                            <p>Araxá</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Saídas</strong>
                            <p>Saídas 2024: Saídas específicas de Jan.22 até
                                Nov.25</p>
                        </div>
                        <p class="additional-info">*OUTRA OPÇÃO DE DURAÇÃO: 04 dias/ 03 noites*</p>
                        <div class="spacer"></div>
                        <a href="#" class="card-cta">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img" src="./src/img/img-card-produto.jpg" alt="Imagem card">
                    <div class="card-content">
                        <div class="initial-description">
                            <h3>Grande Hotel Termas de Araxá</h3>
                            <p>Onde luxo e bem-estar se encontram, uma experiência
                                inesquecível!</p>
                            <strong>GO4 Brazil</strong>
                        </div>
                        <div class="complementary-description">
                            <strong>Duração</strong>
                            <p>5 dias / 4 noites</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Visitando</strong>
                            <p>Araxá</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Saídas</strong>
                            <p>Saídas 2024: Saídas específicas de Jan.22 até
                                Nov.25</p>
                        </div>
                        <p class="additional-info">*OUTRA OPÇÃO DE DURAÇÃO: 04 dias/ 03 noites*</p>
                        <div class="spacer"></div>
                        <a href="#" class="card-cta">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img" src="./src/img/img-card-produto.jpg" alt="Imagem card">
                    <div class="card-content">
                        <div class="initial-description">
                            <h3>Grande Hotel Termas de Araxá</h3>
                            <p>Onde luxo e bem-estar se encontram, uma experiência
                                inesquecível!</p>
                            <strong>GO4 Brazil</strong>
                        </div>
                        <div class="complementary-description">
                            <strong>Duração</strong>
                            <p>5 dias / 4 noites</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Visitando</strong>
                            <p>Araxá</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Saídas</strong>
                            <p>Saídas 2024: Saídas específicas de Jan.22 até
                                Nov.25</p>
                        </div>
                        <p class="additional-info">*OUTRA OPÇÃO DE DURAÇÃO: 04 dias/ 03 noites*</p>
                        <div class="spacer"></div>
                        <a href="#" class="card-cta">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img" src="./src/img/img-card-produto.jpg" alt="Imagem card">
                    <div class="card-content">
                        <div class="initial-description">
                            <h3>Grande Hotel Termas de Araxá</h3>
                            <p>Onde luxo e bem-estar se encontram, uma experiência
                                inesquecível!</p>
                            <strong>GO4 Brazil</strong>
                        </div>
                        <div class="complementary-description">
                            <strong>Duração</strong>
                            <p>5 dias / 4 noites</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Visitando</strong>
                            <p>Araxá</p>
                        </div>
                        <div class="complementary-description">
                            <strong>Saídas</strong>
                            <p>Saídas 2024: Saídas específicas de Jan.22 até
                                Nov.25</p>
                        </div>
                        <p class="additional-info">*OUTRA OPÇÃO DE DURAÇÃO: 04 dias/ 03 noites*</p>
                        <div class="spacer"></div>
                        <a href="#" class="card-cta">Saiba mais</a>
                    </div>
                </div>
            </div>
        </article>
    </section>
</main>
<?php get_footer(); ?>