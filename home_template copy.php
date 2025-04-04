<?php
/*
    Template Name: Home Template B
*/
get_header();

$categories_list = require_once "cached-categories.php";
$videos_arr = require_once "cached-videos-urls.php";
$videos_links = [];
$videos_titles = [];
foreach ($videos_arr as $video_info) {
  $videos_links[] = $video_info["Link"];
  $videos_titles[] = $video_info["Descricao"];
}
$json_videos_titles = json_encode($videos_titles, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
$json_videos_links = json_encode($videos_links, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
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
          <?php
          foreach ($categories_list as $category) {
            $cat_title = $category["Titulo"];
            $cat_description = $category["SubTitulo"];
            $sanitized_cat_title = sanitize_title($category["CategoriaDescricao"]);
            $cat_img_file_name = $category["ImagemHome"];
            $cat_img_folder = $category["PastaImagens"];
            $cat_img_url = "https://www.queensberry.com.br/imagens//categorias/$cat_img_folder/$cat_img_file_name";

            $cat_page_url = home_url() . "/category/$sanitized_cat_title";
            if ($cat_img_file_name !== "") {
              echo <<<SWIPER_SLIDE
                <a href="$cat_page_url" style="background-image: url($cat_img_url)" class="swiper-slide">
                  <div class="slide-overlay"></div>
                  <div class="desktop-slide-overlay"></div>
                  <div class="text-content">
                    <strong>$cat_title</strong>
                    <div class="retractable-content">
                      <p>$cat_description</p>
                      <span class="product-cta">Saiba mais</span>
                    </div>
                  </div>
                </a>
                SWIPER_SLIDE;
            }
          }
          ?>
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
        <?php
        $args = array(
          'post_type'      => 'post',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'orderby' => 'title',
          'order' => 'ASC'
        );

        $query = new WP_Query($args);
        $counter = 1;

        if ($query->have_posts()) {
          while ($query->have_posts() && $counter <= 6) {
            $query->the_post();
            $post_id = get_the_ID();
            $custom_data = get_post_meta($post_id, 'custom_data', true);

            $program_name = $program_info["Descricao"];

            if (is_array($custom_data)) {
              if ($custom_data["ProgramInfo"]["DestaquePortal"] !== "N") {
                $program_post_link = get_permalink();
                $program_info = $custom_data['ProgramInfo'];
                $additional_program_info = $custom_data['ProgramAddInfo'];
                $current_category_info = $custom_data['CategoryInfo'];
                $program_logs_info = $custom_data['ProgramLogInfo'];
                $program_notes = $custom_data['ProgramNotes'];
                $image_gallery_files = $custom_data['ImageGalleryFiles'];
                $price_table_image_files = $custom_data['PriceTableImageFiles'];

                $log_name = $additional_program_info["CadernoTitulo"];
                $program_code = $program_info["CodigoPrograma"];
                $category_code = $program_info["CategoriaCodigo"];

                $category_name = $current_category_info["CategoriaDescricao"];
                $category_title = $current_category_info["Titulo"];
                $program_tower = $program_info["Torre"];
                $program_log_info = array_find($program_logs_info, function ($program_log_info) use ($log_name) {
                  $lower_log_name = trim(mb_strtolower($log_name));
                  $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

                  return $lower_log_name == $current_item_name;
                });

                $quick_description = $program_info["DescricaoResumida"];
                $days_qtty = $program_info["QtdDiasViagem"];
                $nights_qtty = $program_info["QtdNoitesViagem"];
                $visit_details_quick_info = $program_info["Detalhes"];
                $program_outings_info = $program_info["SaidasPrograma"];

                $images_folder_prefix_url = "https://www.queensberry.com.br/imagens/";
                $category_image_folder = $current_category_info["PastaImagens"]; // Ex.: FERIAS_NA_NEVE
                $program_log_image_folder = $program_log_info["CadernoPastaImagens"]; // Ex.: AMERICAS
                $url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]); // Ex.: NEVE002
                $banner_img_file_name = $program_info["Banner"]; // Ex.: DESTAQUE_NEVE002.JPG
                $banner_img_file_name = rawurlencode($banner_img_file_name);
                $log_img_file_name = $image_gallery_files[0]['Descricao'];
                $program_banner_img_url = "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$banner_img_file_name";

                $class_list = "";

                switch ($counter) {
                  case 1:
                    $class_list = "first-col two-thirds";
                    break;
                  case 2:
                    $class_list = "second-col one-third";
                    break;
                  case 3:
                    $class_list = "one-third first-col";
                    break;
                  case 4:
                    $class_list = "two-thirds second-col";
                    break;
                  case 5:
                    $class_list = "one-half first-col";
                    break;
                  case 6:
                    $class_list = "one-half second-col";
                    break;
                }


                echo <<<FEATURED_PROGRAM
                  <article class="$class_list" style="background-image: url($program_banner_img_url);">
                    <a href="$program_post_link">
                      <div class="card-overlay"></div>
                      <div class="desktop-card-overlay"></div>
                      <div class="text-content">
                        <h3>$category_title</h3>
                        <h4>$program_name</h4>
                        <p>$quick_description</p>
                        <div class="cta-content">
                          <strong>$days_qtty dias / $nights_qtty noites</strong>
                          <span class="cta">Saiba Mais</span>
                        </div>
                      </div>
                    </a>
                  </article>
                  FEATURED_PROGRAM;

                $counter += 1;
              }
            }
          }
        }
        ?>
      </div>
    </div>
  </section>

  <!-- PALAVRA DO ESPECIALISTA -->

  <!-- 
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
        -->
  <section class="external-links">
    <article class="queensclub-section">
      <h2>
        <img src="<?= get_template_directory_uri() ?>/src/img/logo-queensclub.png" alt="QueensClub">
      </h2>
      <strong>Quanto mais você viajar, mais você vai ganhar.</strong>
      <a href="<?= home_url() ?>/queensclub/">Saiba Mais</a>
    </article>
    <article class="blog-section">
      <h2>Blog</h2>
      <strong>Uma viagem exploratória, sensorial e exclusiva pelos cinco continentes.</strong>
      <a href="https://blog.queensberry.com.br/" target="_blank">Confira</a>
    </article>
  </section>



  <section class="featured-videos" x-data='{
      videoTitles: <?= $json_videos_titles ?>,
      currentVideoTitle: "Título do vídeo atual",
      currentSlideIndex: 0,
      videoSwiper: new Swiper(".featured-videos .swiper", {
        // Optional parameters
        direction: "horizontal",
        loop: true,
        navigation: {
          nextEl: ".featured-videos .swiper-button-next",
          prevEl: ".featured-videos .swiper-button-prev",
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
    }' x-init="
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
    });
    ">
    <div class="wrapper">
      <header>
        <h2>Vídeos</h2>
        <h3 x-text="currentVideoTitle"></h3>
      </header>
      <div class="filler"></div>
      <article class="swiper">
        <div class="swiper-wrapper">
          <?php
          foreach ($videos_links as $video_link) {
            echo <<<SLIDE_ITEM
              <div class="swiper-slide">
                <div class="video-frame">
                  <iframe width="100%" height="100%"
                    src="https://www.youtube-nocookie.com/embed/$video_link"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
              </div>
              SLIDE_ITEM;
          }
          ?>
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