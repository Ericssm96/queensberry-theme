<?php
$current_category = get_queried_object();

$api_data = get_term_meta($current_category->term_id, 'api_data', true);

$banner_img_url_prefix = "https://img.queensberry.com.br/imagens//fundos/categorias";
$banner_img_file_name = $api_data["CategoryInfo"]["BannerImagemCategoria"];
$log_img_url_prefix = "https://img.queensberry.com.br/imagens//Cadernos/";

$category_info = $api_data["CategoryInfo"];
$category_title = $api_data["CategoryInfo"]["Titulo"];
$category_subtitle = $api_data["CategoryInfo"]["SubTitulo"];

$related_logs_qtty = count($api_data["RelatedLogs"]);
$related_logs_name_list = [];
$related_logs_text_list = [];
foreach($api_data["RelatedLogs"] as $related_log_info) {
  $related_logs_name_list[] = $related_log_info["CadernoTitulo"];
  $related_logs_text_list[] = $related_log_info["CadernoTexto"];
}

$posts_metadata = [];

$cat_query_args = [
  'post_type' => 'post',
  'posts_per_page' => -1,
  'category_name' => $current_category->slug,
  'orderby' => 'title',
  'order' => 'ASC'
];

$cat_query = new WP_Query($cat_query_args);

if($cat_query->have_posts()) {
  while($cat_query->have_posts()) {
    $cat_query->the_post();
    $post_id = get_the_ID();
    $metadata = get_post_meta($post_id, 'custom_data', true);
    foreach($metadata["ProgramInfo"] as $program_info) {
      if(gettype($program_info) == "string") {
        $program_info = str_replace('"', "'", $program_info);
      }
    }
    $additional_program_info = $metadata['ProgramAddInfo'];
    $program_logs_info = $metadata['ProgramLogInfo'];
    $program_info = $metadata['ProgramInfo'];
    $log_name = $additional_program_info["CadernoTitulo"]; 
    $region_info = $metadata["RegionInfo"];
    $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
      $lower_log_name = trim(mb_strtolower($log_name));
      $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

      return $lower_log_name == $current_item_name;
    });

    $images_folder_prefix_url = "https://img.queensberry.com.br/imagens//Programas/";
    $category_image_folder = $category_info["PastaImagens"]; // Ex.: FERIAS_NA_NEVE
    $program_log_image_folder = $program_log_info["CadernoPastaImagens"]; // Ex.: AMERICAS
    $url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]); // Ex.: NEVE002
    $card_image_file_name = $program_info["CaminhoImagem"];

    $card_image_url = "$images_folder_prefix_url/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$card_image_file_name";
    $post_slug = get_post_field( 'post_name', get_post() );

    
    $posts_metadata[] = [
      "Link" => get_permalink(),
      "PostData" => $metadata,
      "CardImageUrl" => $card_image_url,
      "PostSlug" => $post_slug,
      "LogSlug" => sanitize_title($log_name),
      "RegionInfo" => $region_info
    ];
  }
}

wp_reset_postdata();

$all_countries_list = require_once "cached-countries-list.php";
$world_regions_list = require_once "cached-world-regions.php";
$world_regions_names = [];
foreach($world_regions_list as $world_region_info) {
  $world_regions_names[] = trim($world_region_info['NomeRegiao']);
}

$countries_by_region = [
  "África" => [],
  "Américas" => [],
  "Ásia" => [],
  "Europa" => [],
  "Oceania" => [],
  "Oriente Médio" => []
];

foreach($world_regions_names as $world_region_name) {
  $formatted_region_name = trim($world_region_name);
  foreach($all_countries_list as $country_info) {
    if($country_info['regiao'] === $formatted_region_name) {
      $countries_by_region[$formatted_region_name][] = $country_info['pais'];
    }
  }
}

$json_countries_by_region = json_encode($countries_by_region, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
$json_posts_meta = json_encode($posts_metadata, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
$json_logs_names = json_encode($related_logs_name_list);
$json_logs_descriptions = json_encode($related_logs_text_list);

get_header();
?>

<main x-data='{
      slideTitles: <?= $json_logs_names ?>,

      slideDescriptions: <?= $json_logs_descriptions ?>,

      sanitizeTitle(str) {
        if (typeof str !== "string") {
          return "";
        }

        // Convert to lowercase
        str = str.toLowerCase();

        str = str.normalize("NFKD");

        // Replace spaces and special characters with hyphens
        str = str.replace(/[^a-z0-9\s-]/g, "") // Remove unwanted characters
                .replace(/\s+/g, "-")         // Replace spaces with hyphens
                .replace(/-+/g, "-");         // Replace multiple hyphens with a single hyphen

        // Trim hyphens from the start and end
        str = str.replace(/^-+|-+$/g, "");

        return str;
      },

      currentSlideTitle: "",
      currentSlideDescription: "",
      currentSlideIndex: 0,

      productGroupSwiper: new Swiper(".product-page-slider .swiper", {
        // Optional parameters
        direction: "horizontal",

        // Navigation arrows
        navigation: {
          nextEl: ".product-page-slider .swiper-button-next",
          prevEl: ".product-page-slider .swiper-button-prev",
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
      }),
      isLogFilterListOpen: false,
      postsMeta: <?= $json_posts_meta ?>,
      amountOfPosts: 0,
      displayedPosts: 6,
      countriesByRegion: <?= $json_countries_by_region ?>,
      selectedRegionsData: [],
      limitedPostsMeta: [],
      selectedLogs: [],
      selectedWorldRegions: [],
      selectedCountries: [],
      textFilter: "",
      postsOrder: "",
      loadMoreCards() {
        if(this.displayedPosts < this.amountOfPosts) {
          this.displayedPosts += 6;
        }
      },
      get filteredPostsMeta() {
        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter == "") {
          return this.postsMeta.filter((postMeta)=> {
            return this.selectedLogs.includes(postMeta["LogSlug"]);
          });
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter !== "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter !== "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter == "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length == 0 &&
        this.textFilter !== "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && 
        this.selectedCountries.length == 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter !== "") {
          return this.postsMeta;
        }

        

        if(this.selectedLogs.length > 0 && 
        this.selectedCountries.length > 0 && 
        selectedWorldRegions.length > 0 &&
        this.textFilter !== "") {
          return this.postsMeta;
        }

        if(this.selectedLogs.length == 0 && this.textFilter == "") {
          return this.postsMeta;
        }
        
        if(this.selectedLogs.length == 0 && this.textFilter != "") {
          return this.postsMeta.filter((postMeta)=> {
            return postMeta["PostSlug"].includes(this.sanitizeTitle(this.textFilter));
          });
        }
        if(this.selectedLogs.length > 0 && this.textFilter == "") {
          return this.postsMeta.filter((postMeta)=> {
            return this.selectedLogs.includes(postMeta["LogSlug"]);
          });
        }
        return this.postsMeta.filter((postMeta)=> {
          return this.selectedLogs.includes(postMeta["LogSlug"]) && postMeta["PostSlug"].includes(this.sanitizeTitle(this.textFilter))
        });
      },
      orderPosts() {
        if(this.postsOrder == "alphabAsc") {
          this.filterPostsByAscAlphabeticOrder();
        } else if (this.postsOrder == "alphabDesc") {
          this.filterPostsByDescAlphabeticOrder();
        }
      },
      filterPostsByAscAlphabeticOrder() {
        // Função para ordenar os posts em ordem alfabética crescente (A-Z)
        this.filteredPostsMeta.sort((a, b) => a["PostSlug"].localeCompare(b["PostSlug"], undefined, { sensitivity: "base" }));
      },
      filterPostsByDescAlphabeticOrder() {
        // Função para ordenar os posts em ordem alfabética descrescente (Z-A)
        this.filteredPostsMeta.sort((a, b) => b["PostSlug"].localeCompare(a["PostSlug"], undefined, { sensitivity: "base" }));
      }  
    }' x-init="currentSlideTitle = slideTitles[currentSlideIndex];
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
    });
    amountOfPosts = postsMeta.length;
    limitedPostsMeta = filteredPostsMeta.slice(0, displayedPosts);
    filteredPostsMeta = postsMeta;" x-effect="
    limitedPostsMeta = filteredPostsMeta.slice(0, displayedPosts);
    for(let region in countriesByRegion) {
      if(selectedWorldRegions.includes(sanitizeTitle(region))) {
        /* selectedRegionsData.push({
          region,
          'countries': countriesByRegion[region]
        }) */
        const isDuplicate = selectedRegionsData.find(obj => {

          return JSON.stringify(obj) === JSON.stringify({
            region,
            'countries': countriesByRegion[region]
          });

        });

        if (!isDuplicate) {
          selectedRegionsData.push({
            region,
            'countries': countriesByRegion[region]
          });
        }
      } else {
        let positionInSelectedRegions = selectedRegionsData.findIndex(obj => {
          return JSON.stringify(obj) === JSON.stringify({
            region,
            'countries': countriesByRegion[region]
          });
        });
        if(positionInSelectedRegions !== -1) {
          selectedRegionsData.splice(positionInSelectedRegions, 1);
        } 
      }
    }
    
    console.log(selectedRegionsData);
    ">
<?php
    if(is_user_logged_in()) {
      echo <<<ELEMENT
      <div class="shaded-overlay" style="top: 32px;">
      </div>
      ELEMENT;
    } else {
      echo <<<ELEMENT
      <div class="shaded-overlay" style="top: 0px;">
      </div>
      ELEMENT;
    }
    ?>
    <section class="product-banner" style="background-image: url(<?= "$banner_img_url_prefix/$banner_img_file_name" ?>);">
      <div class="wrapper">
        <h1 class="product-title"><?= $category_title; ?></h1>
        <div class="product-description">
            <p class="description-text"><?= $category_subtitle ?></p>
        </div>
      </div>
    </section>
    <?php
    if($related_logs_qtty > 1) {
      ?>
    <section class="product-page-slider">
      <div class="container">
        <div class="slide-item-description">
          <div class="top">
            <h2 x-text="currentSlideTitle"></h2>
            <p x-html="currentSlideDescription.replace('\n', '<br />')"></p>
          </div>
          <div class="bottom">
            <a href="#" class="schedules-cta">Programas</a>

            <div class="controls">
              
                <img @click="$refs.prevBtnTarget.click()" src="<?= get_template_directory_uri(); ?>/src/img/prev-btn.png" alt="Slide Anterior">
                <img @click="$refs.nextBtnTarget.click()" src="<?= get_template_directory_uri(); ?>/src/img/next-btn.png" alt="Próximo Slide">
            </div>
          </div>
        </div>
        <div class="swiper products-slide">
          <div class="swiper-wrapper">
            <?php
            if($related_logs_qtty <= 3) {
              // Se tiver menos de 3 cadernos relacionados à categoria, repetir os slides para a propriedade "loop" do slide funcionar corretamente.
              foreach($api_data["RelatedLogs"] as $related_log_info) {
                $log_slide_img_file_name = $related_log_info["CadernoFoto"];
                $log_title = $related_log_info["CadernoTitulo"];
                echo <<<SLIDE_ELEMENT
                  <a href="#searchContainer" class="swiper-slide"><img src="$log_img_url_prefix/$log_slide_img_file_name" alt="$category_title - $log_title"></a>
                SLIDE_ELEMENT;
              }
            }
            foreach($api_data["RelatedLogs"] as $related_log_info) {
              $log_slide_img_file_name = $related_log_info["CadernoFoto"];
              $log_title = $related_log_info["CadernoTitulo"];
              echo <<<SLIDE_ELEMENT
                <a href="#searchContainer" class="swiper-slide"><img src="$log_img_url_prefix/$log_slide_img_file_name" alt="$category_title - $log_title"></a>
              SLIDE_ELEMENT;
            }
            ?>
          </div>

          <div x-ref="prevBtnTarget" class="swiper-button-prev"></div>
          <div x-ref="nextBtnTarget" class="swiper-button-next"></div>
        </div>
      </div>
    </section>
    <?php 
    } ?>

    <section class="search-related-content" id="searchContainer">
        <article class="search-container" >
            <div class="checkable-filters">
              <h2>Pesquise</h2>
              <div class="checkbox-area">
                <div class="list-title">
                  <label for="logs_list_trigger" class="text-area"><span class="active-indicator" x-text="isLogFilterListOpen ? '[ - ]' : '[ + ]'"></span><p>Cadernos</p></label>
                  <img src="<?= get_template_directory_uri(); ?>/src/img/i.icone-caderno.png" alt="">
                </div>
                <input @change="isLogFilterListOpen = !isLogFilterListOpen" type="checkbox" name="logs_list_trigger" id="logs_list_trigger">
                <ul class="checkbox-list">
                  <?php
                  foreach($related_logs_name_list as $related_log_name) {
                    $log_identifier = sanitize_title($related_log_name);

                    echo <<<CHECKBOX_FIELD
                      <li>
                        <input type="checkbox" x-model="selectedLogs" value="$log_identifier" name="$log_identifier" id="$log_identifier">
                        <label for="$log_identifier">$related_log_name</label>
                      </li>
                    CHECKBOX_FIELD;
                  }
                  ?>
                </ul>
              </div>
              <div class="checkbox-area">
                <div class="list-title">
                  <label for="regions_list_trigger" class="text-area"><span class="active-indicator">[ + ]</span><p>Regiões Mundiais</p></label>
                  <img src="<?= get_template_directory_uri(); ?>/src/img/icone-globo.png" alt="">
                </div>
                <input type="checkbox" name="regions_list_trigger" id="regions_list_trigger">
                <ul class="checkbox-list">
                  <?php 
                  foreach($world_regions_names as $world_region_name) {
                    $sanitized_name = sanitize_title($world_region_name);
                    echo <<<CHECKBOX_FIELD
                    <li>
                      <input type="checkbox" x-model="selectedWorldRegions" value="$sanitized_name" name="$sanitized_name" id="$sanitized_name">
                      <label for="$sanitized_name">$world_region_name</label>
                    </li>
                    CHECKBOX_FIELD;
                  }
                  ?>
                </ul>
              </div>
              <div class="checkbox-area" x-show="selectedWorldRegions.length > 0">
                <div class="list-title">
                  <label for="countries_list_trigger" class="text-area"><span class="active-indicator">[ + ]</span><p>Países</p></label>
                  <img src="<?= get_template_directory_uri(); ?>/src/img/icone-globo.png" alt="">
                </div>
                <input type="checkbox" name="countries_list_trigger" id="countries_list_trigger">
                <ul class="countries-checkbox-list">
                  
                  <template x-for="region in selectedRegionsData">
                    <div class="region-list">
                      <h3 x-text="region['region']" x-init="console.log(region['countries'])"></h3>
                      <template x-for="countryName in region['countries']">
                        <li>
                          <input type="checkbox" x-model="selectedCountries" x-bind:value="sanitizeTitle(countryName)" x-bind:name="sanitizeTitle(countryName)" x-bind:id="sanitizeTitle(countryName)">
                          <label x-bind:for="sanitizeTitle(countryName)" x-text="countryName"></label>
                        </li>
                      </template>
                    </div>
                  </template>
                </ul>
              </div>
            </div>
            <form action="" @submit.prevent="filteredPostsMeta = filteredPostsMeta" class="search-form">
                <input type="text" x-model="textFilter" placeholder="Informe seu destino">
                <button class="submit-btn" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div class="filter-area">
                <select x-model="postsOrder" @change="orderPosts()" name="FILTRO_PRODUTOS" id="filtroProdutos">
                    <option value="" disabled selected>Organizar</option>
                    <option value="alphabAsc">A - Z</option>
                    <option value="alphabDesc">Z - A</option>
                    <option value="mostSearched">Mais Procurados</option>
                </select>
            </div>
            <ul class="cards-grid">
              <template x-for="postMeta in limitedPostsMeta">
                <li class="card" x-data="{
                  qtdDiasPrograma: postMeta['PostData']['ProgramInfo']['QtdDiasViagem'],
                  qtdNoitesPrograma: postMeta['PostData']['ProgramInfo']['QtdNoitesViagem'],
                  cardImgHeight: 0
                }">
                  <img class="card-img" x-ref="cardImg" x-bind:src="postMeta['CardImageUrl']" alt="Imagem card">
                  <div class="card-content" x-init="cardImgHeight = $refs.cardImg.offsetHeight; console.log(cardImgHeight)" x-bind:style="'height: calc(100% - ' + cardImgHeight + 'px);'">
                      <div class="initial-description">
                          <h3 x-text="postMeta['PostData']['ProgramInfo']['Descricao']"></h3>
                          <p x-html="postMeta['PostData']['ProgramInfo']['DescricaoResumida'].replace('\n', '<br />')"></p>
                          <strong><?= $category_title ?></strong>
                      </div>
                      <div class="complementary-description">
                          <strong>Duração</strong>
                          <p x-text="`${qtdDiasPrograma} dias / ${qtdNoitesPrograma} noites`"></p>
                      </div>
                      <div class="complementary-description">
                          <strong>Visitando</strong>
                          <p x-html="postMeta['PostData']['ProgramInfo']['Detalhes'].replace('\n', '<br />')"></p>
                      </div>
                      <div class="complementary-description">
                          <strong>Saídas</strong>
                          <p x-html="postMeta['PostData']['ProgramInfo']['SaidasPrograma'].replace('\n', '<br />')"></p>
                      </div>
                      <p class="additional-info"></p>
                      <div class="spacer"></div>
                      <a x-bind:href="postMeta['Link']" class="card-cta">Saiba mais</a>
                  </div>
                </li>
              </template>

            </ul>

            
        </article>
    </section>
    <div x-intersect="loadMoreCards()" style="height: 1px;" class=""></div>
</main>
<?php get_footer(); ?>