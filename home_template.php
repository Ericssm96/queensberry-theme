<?php
/*
    Template Name: Home Template
*/
get_header();

$categories_list = require_once "cached-categories.php";
$videos_arr = require_once "cached-videos-urls.php";
$videos_links = [];
$videos_titles = [];
foreach($videos_arr as $video_info) {
  $videos_links[] = $video_info["Link"];
  $videos_titles[] = $video_info["Descricao"];
}
$json_videos_titles = json_encode($videos_titles, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
$json_videos_links = json_encode($videos_links, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);


$dolar_currency_info = require_once "dolar-currency-conversion-info.php";
$euro_currency_info = require_once "euro-currency-conversion-info.php";

$last_dolar_conversion_update_date = explode("T", $dolar_currency_info["DataAtualizacao"])[0];
$last_conversion_update_date = explode("T", $euro_currency_info["DataAtualizacao"])[0];
$last_conversion_date_obj = new DateTime($last_conversion_update_date);
$formatted_conversion_date = $last_conversion_date_obj->format('d/m/Y');

$last_euro_conversion_update_time = explode("T", $euro_currency_info["DataAtualizacao"])[1];
$dolar_price = substr(str_replace(".", ",", $dolar_currency_info["ValorCambio"]), 0, 4);
// $euro_price = str_replace(".", ",", $euro_currency_info["ValorCambio"]);
$euro_price = substr(str_replace(".", ",", $euro_currency_info["ValorCambio"]), 0, 4);
?>
    <div class="video-overlay"></div>
    <main x-init="setTimeout(()=>{
      isModalOpen = true;
    }, 5000)">
    <section class="banner">
      <video id="video" poster="https://www.queensberry.com.br/imagens//Videos/thumbnail.jpg" autoplay muted loop>
        <source src="https://www.queensberry.com.br/imagens//Videos/site27_04_21.webm"
          type='video/webm; codecs="vp8, vorbis"' />
        <source src="https://www.queensberry.com.br/imagens//Videos/site27_04_21.mp4" type="video/mp4" />
      </video>
      <article class="gbm-cta">
        <strong>GBM 2025</strong>
        <a href="<?= home_url(); ?>/category/grupos-brasileiros-no-mundo" rel="noreferrer" target="_blank">Saiba mais</a>
      </article>
    </section>
    <article class="mb-currency-field">
      <strong class="quotation">US$ 1 = R$<?= $dolar_price; ?> | € 1 = R$<?= $euro_price ?></strong>
      <p id="quotation-date" class="quotation-date">Data: <?= $formatted_conversion_date; ?> às <?= $last_euro_conversion_update_time; ?></p>
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
            foreach($categories_list as $category) {
              $cat_title = $category["Titulo"];

              // Pula o card se for "Contiki - Especial para Jovens"
              if (stripos($cat_title, 'Contiki') !== false && stripos($cat_title, 'Especial para Jovens') !== false) {
                continue;
              }

              $cat_description = $category["SubTitulo"];
              $sanitized_cat_title = sanitize_title($category["CategoriaDescricao"]);
              $cat_img_file_name = $category["ImagemHome"];
              $cat_img_folder = $category["PastaImagens"];
              $cat_img_url = "https://www.queensberry.com.br/imagens//categorias/$cat_img_folder/$cat_img_file_name";

              $cat_page_url = home_url() . "/category/$sanitized_cat_title";
              if($cat_img_file_name !== "") {
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

    <!--

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

          if($query->have_posts()) {
            while($query->have_posts() && $counter <= 6) {
              $query->the_post();
              $post_id = get_the_ID();
              $custom_data = get_post_meta($post_id, 'custom_data', true);

              $program_info = $custom_data["ProgramInfo"];
              
              $program_name = $program_info["Descricao"];

              if(is_array($custom_data)) {
                if($custom_data["ProgramInfo"]["DestaquePortal"] !== "N") {
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
                  $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
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
  
                  switch($counter) {
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
    -->

    <!-- DESTAQUES -->
<section class="featured-content">
  <div class="wrapper">
    <h2>Destaques</h2>
    <div class="items-grid">
      <?php 
      // Lista dos nomes que devem aparecer nos destaques
      $nomes_dos_destaques = array(
        'A AMAZÔNIA É NOSSA - JUMA HOTÉIS',
        'SEYCHELLES PARADISÍACA',
        'AVENTURA PELO LESTE AFRICANO – QUÊNIA E TANZÂNIA',
        'ILHA MAURÍCIO',
        'SUÍÇA AUTÊNTICA',
        'ÁFRICA DO SUL COM CHARME'
      );

      $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, 
        'post_status'    => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
      );

      $query = new WP_Query($args);
      $counter = 1;

      if($query->have_posts()) {
        while($query->have_posts() && $counter <= 6) {
          $query->the_post();
          $post_id = get_the_ID();
          $custom_data = get_post_meta($post_id, 'custom_data', true);

          if (is_array($custom_data)) {
            $program_info = $custom_data["ProgramInfo"];
            $program_name = $program_info["Descricao"];

            // Verifica se o nome está na lista de destaques
            if(in_array($program_name, $nomes_dos_destaques)) {
              $program_post_link = get_permalink();
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
              $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
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
              $category_image_folder = $current_category_info["PastaImagens"];
              $program_log_image_folder = $program_log_info["CadernoPastaImagens"];
              $url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]);
              $banner_img_file_name = rawurlencode($program_info["Banner"]);
              $log_img_file_name = $image_gallery_files[0]['Descricao'];
              $program_banner_img_url = "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$banner_img_file_name";

              $class_list = "";

              switch($counter) {
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

<?php
$allowed_titles = [
  "LIVE | TUNÍSIA, A JORNADA",
  "LIVE | Lançamento FÉRIAS NA NEVE",
  "LIVE | Lançamento GBM 2024/2025",
  "Lançamento BRASIL IN",
  "LIVE | Arábia Saudita - O Berço do Islã"
];

$filtered_titles = [];
$filtered_links = [];

foreach ($videos_titles as $index => $title) {
  if (in_array($title, $allowed_titles)) {
    $filtered_titles[] = $title;
    $filtered_links[] = $videos_links[$index];
  }
}

$json_videos_titles = json_encode($filtered_titles);
$videos_links = $filtered_links;
$videos_titles = $filtered_titles;
?>

<section class="featured-videos" x-data='{
  videoTitles: <?= $json_videos_titles ?>,
  currentVideoTitle: "Título do vídeo atual",
  currentSlideIndex: 0,
  videoSwiper: new Swiper(".featured-videos .swiper", {
    direction: "horizontal",
    loop: true,
    navigation: {
      nextEl: ".featured-videos .swiper-button-next",
      prevEl: ".featured-videos .swiper-button-prev",
    },
    shortSwipes: false,
    breakpoints: {
      1: { slidesPerView: 1, spaceBetween: 0 },
      1024: { slidesPerView: 1.7, spaceBetween: 20 },
      1100: { slidesPerView: 1.8, spaceBetween: 20 },
      1260: { slidesPerView: 2, spaceBetween: 20 },
      1350: { slidesPerView: 2.5, spaceBetween: 20 },
      1450: { slidesPerView: 2.6, spaceBetween: 20 },
      1550: { slidesPerView: 2.5, spaceBetween: 20 },
      1700: { slidesPerView: 3, spaceBetween: 20 }
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
        $allowed_titles = [
          "LIVE | TUNÍSIA, A JORNADA",
          "LIVE | Lançamento FÉRIAS NA NEVE",
          "LIVE | Lançamento GBM 2024/2025",
          "Lançamento BRASIL IN",
          "LIVE | Arábia Saudita - O Berço do Islã"
        ];

        foreach ($videos_links as $index => $video_link) {
          $title = $videos_titles[$index];

          if (in_array($title, $allowed_titles)) {
            echo <<<SLIDE_ITEM
            <div class="swiper-slide">
              <div class="video-frame">
                <iframe width="100%" height="100%"
                  src="https://www.youtube-nocookie.com/embed/$video_link"
                  title="$title" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
            SLIDE_ITEM;
          }
        }
        ?>
      </div>

      <div class="mobile-controllers">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </article>
  </div>
</section>




    <section class="popup-form-overlay" x-show="isModalOpen">
      <form id="f_queensberry_pop_up_cadastro" name="f_queensberry_pop_up_cadastro" class="sign-up-form" method="POST">

        <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false;"></i>

        <header>
          <h2>Receba Novidades</h2>
          <p>Cadastre seu e-mail</p>
        </header>

        <div class="form-content">
          <input type="hidden" name="action" value="queensberry_popup_cadastro">
          <!-- Eloqua -->
          <input type="hidden" name="elqFormName" value="queensberry-pop-up-cadastro">
          <input type="hidden" name="elqSiteID" value="2864845">
          <input type="hidden" name="elqCustomerGUID" value="">
          <input type="hidden" name="elqCookieWrite" value="0">
          <!-- Responsys -->
          <input type="hidden" name="_ri_"
              value="X0Gzc2X%3DAQjkPkSRWQGzazcsJ6AbKrIB0a2vaLabgUpCnzceuwybVwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQG4TwrzbhWDWUINdjCsOv9y4pzbag2rEa6">
          <input type="hidden" name="_ei_" value="EOFhGZUqGt_VmZAPvWQd4rs">
          <input type="hidden" name="_di_" value="4n7tvcf4fs51837d46au3eocul9la5beeatniu923cdoafbbdf40">
          <input type="hidden" name="EMAIL_PERMISSION_STATUS_" value="O" id="optIn">
          <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
          <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário PopUp Cadastro - Queensberry">
          <input type="hidden" id="URL_CADASTRO" name="URL_CADASTRO" onload="getURL">
          <!-- <input type="hidden" name="FULL_PHONE_NUMBER" value="" id="fullPhoneNumber"> -->
          <!-- Formulário -->
          <div class="input-area">
            <label for="iptNome">Nome*</label>
            <input type="text" id="iptNome" placeholder="Nome*" required name="FIRST_NAME">
          </div>
          <div class="input-area">
            <label for="iptNome">Email*</label>
            <input type="text" placeholder="email@exemplo.com" required name="EMAIL_ADDRESS_">
          </div>
          <div class="input-area">
            <label for="slctPerfil">Perfil*</label>
            <select id="slctPerfil" required name="PERFIL">
              <option value="">- Selecione o Assunto - </option>
              <option value="passageiro">Passageiro</option>
              <option value="agente">Agente de Viagens</option>
            </select>
          </div>
          <div class="input-area">
            <label for="slctEstado">Estado*</label>
            <select id="slctEstado" required name="ESTADO">
              <option value="">Selecione</option>
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AP">Amapá</option>
              <option value="AM">Amazonas</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RO">Rondônia</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SP">São Paulo</option>
              <option value="SE">Sergipe</option>
              <option value="TO">Tocantins</option>
            </select>
          </div>
          <div class="checkbox-area">
            <span class="custom-checkbox">
              <input type="checkbox" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
              <label for="RECEBER_COMUNICACOES" class="checkmark"></label>
            </span>
            <label class="text-label" for="RECEBER_COMUNICACOES">Aceito receber comunicações e informações da Queensberry</label>
          </div>
          <p>A nossa empresa está comprometida a proteger e respeitar sua privacidade, utilizaremos seus dados apenas para fins de marketing. Você pode alterar suas preferências a qualquer momento.</p>
          <button class="submit-btn" type="submit">Cadastrar</button>
        </div>
      </form>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
      <script>
          var formData = new FormData(jQuery("#f_queensberry_pop_up_cadastro")[0]); // Use FormData para incluir anexos


          $(document).ready(() => {

              $("#f_queensberry_pop_up_cadastro").on("submit", (e) => {
                  e.preventDefault();

                  const perfil = $("select[name='PERFIL']").val();

                  if (!perfil || perfil === "") {
                    // Se não houver perfil selecionado, exibe o alert
                    alert("Por favor, selecione um perfil válido (Passageiro ou Agente).");
                    return;  // Interrompe o envio do formulário
                  }

                  if (perfil === "passageiro") {
                      // Se for "passageiro", envia para o backend (Responsys)
                      jQuery.post(
                          "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_popup_cadastro",
                          $("#f_queensberry_pop_up_cadastro").serialize(),
                          function (data) {
                            // Callback para lidar com a resposta
                            console.log(data); // Exibe a resposta no console
                            alert("Cadastro concluído com sucesso!")
                          }
                      )
                  } else if (perfil === "agente") {
                      // Se for "agente", envia para Eloqua
                      jQuery.ajax({
                          type: "POST",
                          url: "https://s2864845.t.eloqua.com/e/f2",
                          data: jQuery("#f_queensberry_pop_up_cadastro").serialize(),
                          success: () => {
                              console.log("Eloqua ok");
                              alert("Cadastro concluído com sucesso!")
                          },
                          error: (res) => {
                              console.log("Eloqua fail", res);
                          },
                      })
                  }
              });
          });
      </script>

      <script type="text/javascript">
          var timerId = null, timeout = 5;

          function WaitUntilCustomerGUIDIsRetrieved() {
              if (!!(timerId)) {
                  if (timeout === 0) {
                      return;
                  }
                  if (typeof this.GetElqCustomerGUID === 'function') {
                      document.forms["f_queensberry_pop_up_cadastro"].elements["elqCustomerGUID"].value = GetElqCustomerGUID();
                      return;
                  }
                  timeout -= 1;
              }
              timerId = setTimeout("WaitUntilCustomerGUIDIsRetrieved()", 500);
              return;
          }

          window.onload = WaitUntilCustomerGUIDIsRetrieved;
          /* _elqQ = _elqQ || [];
          _elqQ.push(['elqGetCustomerGUID']); */
      </script>

      <script>
          /*Script para verificar se o usuario
          marcou o aceite de recebimento de e-mails ou nao (opt-in/opt-out)*/
          $(function ($) { // on DOM ready (when the DOM is finished loading)
              $('#agree').click(function () { // when the checkbox is clicked
                  var checked = $('#agree').is(':checked'); // check the state
                  $('#optIn').val(checked ? "I" : "O"); // set the value
                  $('#optInSMS').val(checked ? "I" : "O"); // set the value

              });
              $('#optIn').triggerHandler("click"); // initialize the value
              $('#optInSMS').triggerHandler("click"); // initialize the value
          });

      </script>
      <script>
          $(function getURL() {
              var url_cadastro = window.location.href;
              document.getElementById('URL_CADASTRO').value = url_cadastro;
          });
      </script>
    </section>
  </main>

  <div class="mini-popup">
    <div class="popup-rotativo">
            <button class="mini-popup-close-btn" onclick="fecharMiniPopup()"> X </button>
            <a href="<?= home_url(); ?>/category/walt-disney-world-resort" target="_blank">
                <img src="<?= get_template_directory_uri(); ?>/src/img/popupdisney.png">
            </a>
    </div>
  </div>

<!-- Botão Flutuante -->
<div class="floating-button-container">
  <!-- Sub Botões -->
  <div class="floating-menu" id="floatingMenu">
    <button class="circle-button email" onclick="window.location.href='/fale-conosco'">
      <i class="fas fa-envelope"></i>
    </button>
    <button class="circle-button whatsapp" onclick="window.open('https://api.whatsapp.com/send?phone=551132177100', '_blank')">
      <i class="fab fa-whatsapp"></i>
    </button>
    <button class="circle-button phone" onclick="showPhonePopup()">
      <i class="fas fa-phone"></i>
    </button>
  </div>

  <!-- Botão principal -->
  <button class="main-button" id="toggleMenu">
    <i class="fas fa-comment"></i>
  </button>

  <!-- Botão de Fechar-->
  <button class="close-button" id="closeMenu">
    <i class="fas fa-times"></i>
  </button>
</div>

<!-- Pop-up Telefone-->
<div class="phone-popup" id="phonePopup">
  <div class="popup-header">
    <span>Telefone</span>
    <button class="close-x" onclick="closePhonePopup()">×</button>
  </div>
  <div class="popup-body">
    <p>+55 (11) 3217-7100</p>
  </div>
</div>

<style>
  .floating-button-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .main-button,
  .circle-button,
  .close-button {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: none;
    color: white;
    font-size: 23px;
    cursor: pointer;
    transition: transform 0.3s ease, opacity 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .main-button {
    background-color: #a3c166;
  }

  .close-button {
    background-color: #a2c36f;
    display: none;
  }

  .floating-menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    pointer-events: none;
    transform: translateY(20px);
    transition: all 0.3s ease;
  }

  .floating-menu.active {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
  }

  .circle-button.email {
    background-color: #666;
  }

  .circle-button.whatsapp {
    background-color: #25d366;
  }

  .circle-button.phone {
    background-color: #007bff;
  }

  /* Pop-up de telefone */
  .phone-popup {
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 250px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    display: none;
    overflow: hidden;
    font-family: sans-serif;
  }

  .popup-header {
    background-color: #a2c36f;
    color: white;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
  }

  .popup-header .close-x {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
  }

  .popup-body {
    padding: 20px;
    text-align: center;
    font-size: 20px;
    font-weight: 500;
    color: #333;
  }

  @media (max-width: 600px) {
    .main-button,
    .circle-button,
    .close-button {
      width: 45px;
      height: 45px;
      font-size: 18px;
    }

    .popup-body {
      font-size: 18px;
    }

    .phone-popup {
      width: 90%;
      right: 5%;
    }
  }

  .mini-popup {
    position: fixed;
    bottom: 15px;
    left: 15px;
    z-index: 1000;
    -webkit-transition: all ease-in-out 300ms;
    -moz-transition: all ease-in-out 300ms;
    -o-transition: all ease-in-out 300ms;
    transition: all ease-in-out 300ms
}

.mini-popup img {
    -webkit-box-shadow: -2px 5px 25px 5px rgba(0,0,0,.62);
    box-shadow: -2px 5px 25px 5px rgba(0,0,0,.62)
}

.popup-rotativo img {
    border-radius: 15px
}

@media only screen and (max-width: 480px) {
    .mini-popup {
        left:50%!important;
        top: 72%!important;
        transform: translate(-50%,-50%)
    }

    .mini-popup img {
        width: 80vw
    }

    .popup-rotativo__imagem--desktop {
        display: none
    }

    .mini-popup--alerta {
        z-index: 1100;
        margin: 0 auto;
        display: flex!important;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        left: initial!important;
        bottom: 0!important;
        background: #000000a3
    }

    .popup-rotativo--alerta {
        height: initial!important;
        display: flex;
        flex-direction: column
    }

    .fecharBlog--alerta {
        width: 25px!important;
        position: relative!important;
        top: initial!important
    }
}

@media(max-width: 700px) {
    .mini-popup>a>img {
        width:173px;
        height: 136px
    }
}

@media(max-width: 576px) {
    .mini-popup {
        bottom:5px;
        left: 5px
    }

    .mini-popup>a>img {
        width: 151px;
        height: 119px
    }
}

@media only screen and (min-width: 481px) {
    .popup-rotativo__imagem--mobile {
        display:none
    }
}

.mini-popup-close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #99d02c;
    border-radius: 50%;
    border: 2px solid #fff;
    color: #fff;
    width: 30px;
    height: 30px
}

</style>

<script>
  const toggleBtn = document.getElementById("toggleMenu");
  const closeBtn = document.getElementById("closeMenu");
  const menu = document.getElementById("floatingMenu");
  const popup = document.getElementById("phonePopup");

  toggleBtn.addEventListener("click", () => {
    menu.classList.add("active");
    toggleBtn.style.display = "none";
    closeBtn.style.display = "flex";
  });

  closeBtn.addEventListener("click", () => {
    menu.classList.remove("active");
    toggleBtn.style.display = "flex";
    closeBtn.style.display = "none";
    popup.style.display = "none"; // fecha se estiver aberto!!
  });

  function showPhonePopup() {
    popup.style.display = "block";
  }

  function closePhonePopup() {
    popup.style.display = "none";
  }
</script>


<script>
  function fecharMiniPopup() {
    const popup = document.querySelector('.mini-popup');
    if (popup) {
      popup.style.display = 'none';
    }
  }
</script>

  <?php get_footer(); ?>