<?php
$posts_metadata = [];
$tag_title = "";
$world_region = "";
$current_country = "";

$tag = get_queried_object();

if ($tag && isset($tag->name)) {
  $tag_title = $tag->name;
}

if(have_posts()){
  while(have_posts()) {
    the_post();

    // $tag_title = single_tag_title( '', false );

    $post_id = get_the_ID();
    $metadata = get_post_meta($post_id, 'custom_data', true);
    foreach($metadata["ProgramInfo"] as $program_info) {
      if(gettype($program_info) == "string") {
        $program_info = str_replace('"', "'", $program_info);
      }
    }
    $additional_program_info = $metadata['ProgramAddInfo'];
    $program_logs_info = $metadata['ProgramLogInfo'];
    $category_info = $metadata["CategoryInfo"];
    $program_info = $metadata['ProgramInfo'];
    $log_name = $additional_program_info["CadernoTitulo"]; 
    $region_info = $metadata["RegionInfo"];
    $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
      $lower_log_name = trim(mb_strtolower($log_name));
      $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

      return $lower_log_name == $current_item_name && $program_log_info["CadernoPastaImagens"] !== "";
    });

    $images_folder_prefix_url = "https://www.queensberry.com.br/imagens//Programas/";
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

$json_posts_meta = json_encode($posts_metadata, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);

$categories_list =  require_once 'cached-categories.php';
$valid_categories_list = array_filter($categories_list, function($category_info) {
  return $category_info["CategoriaStatus"] == "A" && trim($category_info["Titulo"]) != "";
});

$all_countries_list = require_once "cached-countries-list.php";
$world_regions_list = require_once "cached-world-regions.php";
$world_regions_names = [];
foreach($world_regions_list as $world_region_info) {
  $world_regions_names[] = trim($world_region_info['NomeRegiao']);
}

// if(array_search($tag_title, $world_regions_names, true)) {
if(gettype(array_search($tag_title, $world_regions_names, true)) !== "integer") {
  $current_country = $tag_title;
  $current_country_info = array_find($all_countries_list, function($country_info, $key) use ($current_country) {
    return $country_info['pais'] === $current_country;
  });
  $world_region = $current_country_info["regiao"];
} else {
  $world_region = $tag_title;
}


$countries_in_region = array_filter($all_countries_list, function($country_info) use ($world_region) {
  return $country_info['regiao'] === $world_region;
});

/* $countries_in_region = array_filter($all_countries_list, function($country_info, $key) use ($world_region) {
  return $country_info['regiao'] == $world_region;
}); */
$banner_img_name = "busca.jpg";
$info_file_url = "";


switch(mb_strtolower($tag_title)) {
  case "áfrica do sul":
    $banner_img_name = "africadosul.jpg";
    break;
  case "egito":
    $banner_img_name = "egito.jpg";
    $info_file_url = "https://www.queensberry.com.br/imagens//fundos/cadernos/paises/ebook_egito.pdf";
    break;
  case "quênia":
    $banner_img_name = "quenia.jpg";
    break;
  case "marrocos":
    $banner_img_name = "marrocos.jpg";
    break;
  case "tanzânia":
    $banner_img_name = "tanzania.jpg";
    $info_file_url = "https://www.queensberry.com.br/imagens//fundos/cadernos/paises/ebook_tanzania.pdf";
    break;
  case "argentina:":
    $banner_img_name = "argentina.jpg";
    break;
  case "chile:":
    $banner_img_name = "chile.jpg";
    break;
  case "canada:":
    $banner_img_name = "canada.jpg";
    break;
  case "estados unidos:":
    $banner_img_name = "estadosunidos.jpg";
    break;
  case "méxico:":
    $banner_img_name = "mexico.jpg";
    break;
  case "peru:":
    $banner_img_name = "peru.jpg";
    break;
  case "brasil:":
    $banner_img_name = "brasil.jpg";
    break;
  case "emirados árabes":
    $banner_img_name = "dubai.jpg";
    $info_file_url = "https://www.queensberry.com.br/imagens//fundos/cadernos/paises/ebook_dubai.pdf";
  default:
    $banner_img_name = "busca.jpg";
}

$has_additional_banner_info = $info_file_url !== "";
$banner_bg_img_url = get_template_directory_uri() . "/src/img/destinos/$banner_img_name";



get_header();
?>

<main>
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
    if($has_additional_banner_info) {
      echo <<<BANNER
      <section class="search-banner" style="background-image: url($banner_bg_img_url);">
        <div class="wrapper">
          <div class="content">
            <h1>$tag_title</h1>
            <p>Saiba mais sobre seu próximo destino: idioma, clima, melhor época, moeda e outras informações importantes para sua viagem!</p>
            <a href="$info_file_url" class="cta" target="_blank">Confira</a>
          </div>
        </div>
      </section>
      BANNER;
    } else {
      echo <<<BANNER
      <section class="search-banner" style="background-image: url($banner_bg_img_url);">
        <div class="wrapper">
        </div>
      </section>
      BANNER;
    }
    
  ?>

  <section class="search-related-content" x-data='{
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
    _postsMeta: <?= $json_posts_meta ?>,
    postsOrder: "",
    textFilter: "",
    searchQuery: "",
    currentCountry: "<?= $current_country ?>",
    selectedTags: [],
    selectedCategories: [],
    isLoading: false,
    get postsMeta() {
      if(this.textFilter === "") {
        return this._postsMeta;
      } else {
        return this._postsMeta.filter((postMeta)=> {
          let postDescription = postMeta["PostData"]["ProgramInfo"]["DescricaoResumida"].toLowerCase();
          let postSlug = postMeta["PostSlug"];
          let travelOutings = postMeta["PostData"]["ProgramInfo"]["SaidasPrograma"].toLowerCase();
          let travelVisits = postMeta["PostData"]["ProgramInfo"]["Detalhes"].toLowerCase();
          let lowerCaseFilter = this.textFilter.toLowerCase();
          return postDescription.includes(lowerCaseFilter) || 
          postSlug.includes(this.sanitizeTitle(this.textFilter)) || 
          travelOutings.includes(lowerCaseFilter) ||
          travelVisits.includes(lowerCaseFilter);
        });
      }
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
      this.postsMeta.sort((a, b) => a["PostSlug"].localeCompare(b["PostSlug"], undefined, { sensitivity: "base" }));
    },
    filterPostsByDescAlphabeticOrder() {
      // Função para ordenar os posts em ordem alfabética descrescente (Z-A)
      this.postsMeta.sort((a, b) => b["PostSlug"].localeCompare(a["PostSlug"], undefined, { sensitivity: "base" }));
    },
    async performSearch() {
      this.isLoading = true;
      try {
        const response = await axios.get("<?php echo esc_url(rest_url("api/v1/tagfilter/")); ?>", {
          params: {
            tags: this.selectedTags.join(","),
            categories: this.selectedCategories.join(",")
          },
        });

        this._postsMeta = response.data;

        console.log(this._postsMeta);
      } catch (error) {
        console.error("Error fetching search results:", error);
      } finally {
        this.isLoading = false;
      }

      
    },
  }' x-init="
    selectedTags = currentCountry.length !== 0 ? [sanitizeTitle(currentCountry)] : [];
    console.log(selectedTags);
  ">
    <article class="search-container">
      <div class="checkable-filters">
        <h2>Pesquise</h2>
        <div class="checkbox-area">
          <div class="list-title">
            <label for="categories_list_trigger" class="text-area"><span class="active-indicator">[+]</span><p>Produtos</p></label>
            <img src="<?= get_template_directory_uri() ?>/src/img/icone-bussola.png" alt="">
          </div>
          <input type="checkbox" name="categories_list_trigger" id="categories_list_trigger">
          <ul class="checkbox-list">
            <?php
            foreach($valid_categories_list as $category_info) {
              $category_title = capitalize_pt_br_string($category_info['CategoriaDescricao']);
              $sanitized_cat_title = sanitize_title($category_title);
              echo <<<ELEMENT
              <li>
                <input @change="performSearch()" type="checkbox" x-model="selectedCategories" value="$sanitized_cat_title" name="$sanitized_cat_title" id="$sanitized_cat_title">
                <label for="$sanitized_cat_title">$category_title</label>
              </li>
              ELEMENT;
            }
            ?>
          </ul>
        </div>
        <div class="checkbox-area">
          <div class="list-title">
            <label for="countries_list_trigger" class="text-area"><span class="active-indicator">[+]</span><p>Países</p></label>
            <i class="fa-solid fa-location-dot map-pin"></i>
          </div>
          <input type="checkbox" name="countries_list_trigger" id="countries_list_trigger">
          <ul class="checkbox-list">
            <li>
              <h3><?= $world_region ?></h3>
            </li>
            <?php
            foreach($countries_in_region as $country_info) {
              $country_name = capitalize_pt_br_string($country_info['pais']);
              $sanitized_country_name = sanitize_title($country_name);

              if($country_name === $tag_title) {
                echo <<<ELEMENT
                <li>
                  <input checked @change="performSearch()" type="checkbox" x-model="selectedTags" value="$sanitized_country_name" name="$sanitized_country_name" id="$sanitized_country_name">
                  <label for="$sanitized_country_name">$country_name</label>
                </li>
                ELEMENT;
              } else {
                echo <<<ELEMENT
                <li>
                  <input @change="performSearch()" type="checkbox" x-model="selectedTags" value="$sanitized_country_name" name="$sanitized_country_name" id="$sanitized_country_name">
                  <label for="$sanitized_country_name">$country_name</label>
                </li>
                ELEMENT;
              }
              
            }
            ?>
          </ul>
        </div>
      </div>
      <form action="" @submit.prevent="textFilter = $refs.textFilterField.value" class="search-form">
        <input type="text" x-ref="textFilterField" placeholder="Informe seu destino">
        <button class="submit-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
      <div class="filter-area">
        <select name="FILTRO_PRODUTOS" x-model="postsOrder" @change="orderPosts()" id="filtroProdutos">
          <option value="" disabled selected>Organizar</option>
          <option value="alphabAsc">A - Z</option>
          <option value="alphabDesc">Z - A</option>
          <!-- <option value="maisProcurados">Mais Procurados</option> -->
        </select>
      </div>
      <div class="results-messages" x-show="isLoading || postsMeta.length === 0">
        <div class="loading-results" x-show="isLoading">
          <div class="spinner"></div>
          <p>Carregando Programas...</p>
        </div>
        <div class="not-found" x-show="postsMeta.length === 0 && !isLoading">
          <p>Não foi possível encontrar um programa correspondente</p>
        </div>
      </div>
      <div class="cards-grid">
        <template x-for="postMeta in postsMeta">
          <div class="card" x-data="{
            qtdDiasPrograma: postMeta['PostData']['ProgramInfo']['QtdDiasViagem'],
            qtdNoitesPrograma: postMeta['PostData']['ProgramInfo']['QtdNoitesViagem'],
            cardImgHeight: 0
          }">
            <a x-bind:href="postMeta['Link']" class="post-link">
              <img class="card-img" x-ref="cardImg" x-bind:src="postMeta['CardImageUrl']" alt="Imagem card">
              <div class="card-content" x-init="cardImgHeight = $refs.cardImg.offsetHeight; console.log(cardImgHeight)" x-bind:style="'height: calc(100% - ' + cardImgHeight + 'px);'">
                  <div class="initial-description">
                      <h3 x-text="postMeta['PostData']['ProgramInfo']['Descricao']"></h3>
                      <p x-html="postMeta['PostData']['ProgramInfo']['DescricaoResumida'].replace('\n', '<br />')"></p>
                      <strong x-text="postMeta['PostData']['CategoryInfo']['Titulo']"></strong>
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
                  <button class="card-cta">Saiba mais</button>
              </div>
            </a>
          </div>
        </template>
      </div>
    </article>
  </section>
</main>

<?php get_footer(); ?>