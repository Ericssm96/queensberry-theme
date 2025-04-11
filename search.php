<?php
get_header();

$search_query = sanitize_text_field($_GET['s']);

$search_query = new WP_Query([
  's'              => $search_query,
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC',
  'post_type' => 'post',
  'post_status' => 'publish'
]);

$early_posts_metadata = [];

if($search_query->have_posts()){
  while($search_query->have_posts()) {
    $search_query->the_post();
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
    $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
      $lower_log_name = trim(mb_strtolower($log_name));
      $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

      return $lower_log_name == $current_item_name && $program_log_info["CadernoStatus"] !== "I" && $program_log_info["CadernoPastaImagens"] !== "";
    });

    $images_folder_prefix_url = "https://www.queensberry.com.br/imagens//Programas/";
    $category_image_folder = $category_info["PastaImagens"]; // Ex.: FERIAS_NA_NEVE
    $program_log_image_folder = $program_log_info["CadernoPastaImagens"]; // Ex.: AMERICAS
    $url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]); // Ex.: NEVE002
    $card_image_file_name = $program_info["CaminhoImagem"];

    $card_image_url = "$images_folder_prefix_url/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$card_image_file_name";
    $post_slug = get_post_field( 'post_name', get_post() );

    
    $early_posts_metadata[] = [
      "Link" => get_permalink(),
      "PostData" => $metadata,
      "CardImageUrl" => $card_image_url,
      "PostSlug" => $post_slug,
      "LogSlug" => sanitize_title($log_name)
    ];
  }
}
wp_reset_postdata();

$categories_list =  require 'cached-categories.php';
$valid_categories_list = array_filter($categories_list, function($category_info) {
  return $category_info["CategoriaStatus"] == "A" && trim($category_info["Titulo"]) != "";
});


$json_early_posts_meta = json_encode($early_posts_metadata, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
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
?>
  <section class="search-banner">
    <div class="wrapper">
    </div>
  </section>

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
      searchQuery: "",
      resultsHTML: "", 
      _postsMeta: <?= $json_early_posts_meta ?>,
      selectedCategories: [],
      isLoading: false,
      postsOrder: "",

      async performSearch() {
        if (!this.searchQuery.trim()) return;
        this.isLoading = true;

        try {
          const response = await axios.get("<?php echo esc_url(rest_url("api/v1/search/")); ?>", {
            params: { s: this.searchQuery },
          });

          this._postsMeta = response.data;

          console.log(this._postsMeta);
        } catch (error) {
          console.error("Error fetching search results:", error);
        } finally {
          this.isLoading = false;
        }
      },

      get postsMeta() {
        if(this.selectedCategories.length == 0) {
          return this._postsMeta;
        }

        if(this.selectedCategories.length > 0) {
          return this._postsMeta.filter((postMeta)=> {
            let slugifiedCategoryTitle = this.sanitizeTitle(postMeta["PostData"]["CategoryInfo"]["Titulo"]);
            return this.selectedCategories.includes(slugifiedCategoryTitle);
          });
        }
      },
      orderPosts() {
        console.log(this.postsOrder);
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
      }
    }' x-effect="console.log(selectedCategories)">
    <article class="search-container">
      <div class="checkable-filters">
        <h2>Pesquise</h2>
        <div class="checkbox-area">
          <div class="list-title">
            <label for="logs_list_trigger" class="text-area"><span class="active-indicator">[+]</span><p>Produtos</p></label>
            <img src="<?= get_template_directory_uri() ?>/src/img/icone-bussola.png" alt="">
          </div>
          <input type="checkbox" name="logs_list_trigger" id="logs_list_trigger">
          <ul class="checkbox-list">
            <?php
            foreach($valid_categories_list as $valid_category) {
              $cat_title = capitalize_pt_br_string($valid_category['Titulo']);
              $cat_slug = sanitize_title($cat_title);

              echo <<<CHECKBOX_FIELD
              <li>
                <input type="checkbox" name="produto1" x-model="selectedCategories" value="$cat_slug" id="produto1">
                <label for="produto1">$cat_title</label>
              </li>
              CHECKBOX_FIELD;
            }
            ?>
          </ul>
        </div>
      </div>
      <form action="/" @submit.prevent="performSearch()" class="search-form">
        <input type="text" x-model="searchQuery" placeholder="Informe seu destino">
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
      <div class="cards-grid" x-show="!isLoading && postsMeta.length > 0">
        <template x-for="postMeta in postsMeta">
          <div class="card" x-data="{
            qtdDiasPrograma: postMeta['PostData']['ProgramInfo']['QtdDiasViagem'],
            qtdNoitesPrograma: postMeta['PostData']['ProgramInfo']['QtdNoitesViagem'],
            isHighlightedPost: postMeta['PostData']['ProgramInfo']['DestaquePortal'] === 'S',
            cardImgHeight: 0
          }">
            <a class="post-link" x-bind:href="postMeta['Link']">
              <div class="card-img">
                <img class="" x-ref="cardImg" x-bind:src="postMeta['CardImageUrl']" alt="Imagem card">
                <span x-show="isHighlightedPost" class="highlight-stamp">
                  DESTAQUE
                </span>
              </div>
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

<?php
get_footer();
?>
