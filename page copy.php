<?php
// Ensure this is a single page
if (is_page()) {
  // Get the current post ID
  $page_id = get_the_ID();

  // Retrieve the custom metadata
  $custom_data = get_post_meta($page_id, 'custom_data', true);

  // Check if the custom data exists
  if (!empty($custom_data)):
    // Access the data
    $program_info = $custom_data['ProgramInfo'];
    $categories_info = $custom_data['CategoryInfo'];
    $program_logs_info = $custom_data['ProgramLogInfo'];
    $program_notes = $custom_data['ProgramNotes'];
    $image_gallery_files = $custom_data['ImageGalleryFiles'];
    $price_table_image_files = $custom_data['PriceTableImageFiles'];

    $program_name = $program_info["Descricao"];
    $program_code = $program_info["CodigoPrograma"];
    $category_code = $program_info["CategoriaCodigo"];
    $current_category_info = array_find($categories_info, function($category_info) use ($category_code) {
      return $category_info["CategoriaCodigo"] == $category_code;
    });
    $category_name = $current_category_info["CategoriaDescricao"];
    $program_tower = $program_info["Torre"];
    /* $program_log_info = array_find($program_logs_info, function($program_log) use ($program_tower) {
      return $program_log[""];
    }); */
    $program_log_info = $program_logs_info[0];
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
    $log_img_file_name = $image_gallery_files[0]['Descricao'];
    $attraction_description_list = array_filter($program_notes, function($note) {
      return $note["ProgramaDescricao"] == "Atrações";
    });
    $itinerary_info_list = array_filter($program_notes, function($note) {
      return $note["ProgramaDescricao"] == "Roteiro Dia-a-Dia";
    });
    $itinerary_info_list = array_values($itinerary_info_list);
    $services_info_list = array_filter($program_notes, function($note) {
      return $note["ProgramaDescricao"] == "Serviços";
    });
    $gallery_image_list = array_slice($image_gallery_files, 1);

    get_header();
?>

  <main>
    <div class="banner-overlay">
    </div>
    <header style="background-image: url(<?= "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$banner_img_file_name" ?>);" class="product-page-banner">
      <div>
        <strong><?= $category_name ?></strong>
        <h1><?= "$program_name - $program_code" ?></h1>
        <p><?= $quick_description ?></p>
      </div>
    </header>
    <section class="quick-info">
      <div class="wrapper">
        <div class="info-area">
          <strong>Duração</strong>
          <p><?= $days_qtty ?> dias / <?= $nights_qtty ?> noites</p>
        </div>
        <div class="info-area">
          <strong>Visitando</strong>
          <p><?= $visit_details_quick_info ?></p>
        </div>
        <div class="info-area">
          <strong>Saídas</strong>
          <p><?= $program_outings_info ?></p>
        </div>
        <div class="info-area">
          <strong>Tempo e clima</strong>
          <p>ASPEN</p>
        </div>
      </div>
    </section>

    <section class="general-info">
      <div class="container">
        <div class="itinerary-image-wrapper">
          <img class="itinerary-image" src="<?= "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$log_img_file_name" ?>" alt="Imagem Roteiro Viagem">
        </div>

        <article class="info-text" x-data="{
          selectedTab: 'attractions',
        }">
          <ul class="tab-select" id="infoTabs">
            <li @click="selectedTab = 'attractions'" x-bind:class="selectedTab === 'attractions' ? 'selected' : ''"><i class="fa-solid fa-gift"></i> Atrações</li>
            <li @click="selectedTab = 'itinerary'" x-bind:class="selectedTab === 'itinerary' ? 'selected' : ''"><i class="fa-regular fa-calendar"></i> Roteiro</li>
            <li @click="selectedTab = 'services'" x-bind:class="selectedTab === 'services' ? 'selected' : ''"><i class="fa-solid fa-bell-concierge"></i> Serviços</li>
            <li @click="$refs.priceTableModal.showModal()"><i class="fa-solid fa-dollar-sign"></i> Preços</li>
          </ul>
          <div class="details">
            <div class="tab" x-show="selectedTab === 'attractions'">
              <div class="topic">
                <h2>Atrações</h2>
                <?php 
                foreach($attraction_description_list as $attraction_description_item):
                $attraction_description = $attraction_description_item['NotaTextoDescricao'];
                echo <<<ITEM_DESCRIPTION
                <p>
                  $attraction_description
                </p>
                ITEM_DESCRIPTION;
                endforeach;
                ?>
              </div>
            </div>
            <div class="tab" x-show="selectedTab === 'itinerary'">
              <?php 
              for($i = 0; $i < count($itinerary_info_list); $i++):
                $itinerary_daily_info = $itinerary_info_list[$i]['NotaTextoDescricao'];
                $topic_title = $itinerary_info_list[$i]['NotaDescricao'];
                echo <<<ITEM_DESCRIPTION
                <div class="topic">
                  <h2>$itinerary_day º DIA - $program_name</h2>

                  <p>
                    $itinerary_daily_info
                  </p>
                </div>
                ITEM_DESCRIPTION;
              endfor;
              ?>
            </div>
            <div class="tab" x-show="selectedTab === 'services'">
              <?php
              foreach($services_info_list as $service_info):
                $service_topic = $service_info["NotaDescricao"];
                $info_text = $service_info["NotaTextoDescricao"];
                echo <<<SERVICE_INFO
                <div class="topic">
                  <h2>$service_topic</h2>
                  <p>
                    $info_text
                  </p>
                </div>
                SERVICE_INFO;
              endforeach;
              ?>
            </div>
            <dialog class="price-table-modal" x-ref="priceTableModal">
              <div class="modal-header">
                <h2>Aspen Snowmass</h2>
                <strong>(Férias na Neve)</strong>
                <span class="close-icon"><i class="fa-solid fa-x" @click="$refs.priceTableModal.close()"></i></span>
              </div>
              <div class="modal-content">
                <img src="./src/img/NEVE002_TAB.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB2.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB3.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB4.jpeg" alt="">
              </div>
            </dialog>
          </div>
          <div class="share-links">
            <p>Compartilhe:</p>
            <a href="#"><i class="fa-regular fa-envelope"></i></a>
            <a href="#"><i class="fa-solid fa-print"></i></i></a>
          </div>
        </article>
      </div>
    </section>
    <div class="price-info" x-data="{
      isPriceTagOpen: false,
      productHasPriceInfo: false,
    }">
      <button class="price-info-toggle" @click="isPriceTagOpen = true" x-show="!isPriceTagOpen">Solicitar <br/> v</button>
      <article class="price" x-show="isPriceTagOpen">
        <span @click="isPriceTagOpen = false" class="close-icon"><i class="fa-solid fa-x"></i></span>
        <div class="get-more-info" x-show="!productHasPriceInfo">
          <p>Gostou deste roteiro? Solicite mais informações.</p>
          <a href="#" class="cta">Solicitar</a>
        </div>
        <div class="additional-info" x-show="productHasPriceInfo">
          <div class="value-box">
            <p class="highlighted-text">a partir de:</p>

            <div>
              <strong class="value">R$27.492,08</strong>
              <small class="small-text">
                EM 6X IGUAIS <br/>
                (US$ 4463,00 Câmbio R$ 6,1600)
              </small>
            </div>
          </div>
          <form>
            <select name="" id="">
              <option value="">Selecione</option>
            </select>
            <button class="buy-btn">
              Comprar
            </button>
          </form>
        </div>
        <span></span>
      </article>
    </div>
    <div class="gallery-area" x-data="{
      galleryModalSwiper: new Swiper('.gallery-modal .swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        navigation: {
          nextEl: '.gallery-modal .swiper-button-next',
          prevEl: '.gallery-modal .swiper-button-prev',
        },
        shortSwipes: true,
        breakpoints: {
          1: {
            slidesPerView: 1,
            spaceBetween: 0
          }
        }
      }),
      clickedGalleryItem: 0,
      gallerySwiper: new Swiper('.gallery .swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        shortSwipes: true,
        breakpoints: {
          1: {
            slidesPerView: 2,
            spaceBetween: 0
          },
          600: {
            slidesPerView: 4,
            spaceBetween: 0
          },
          1000: {
            slidesPerView: 6,
            spaceBetween: 0
          }
        }
      }),
      timesModalSwiperWasUpdated: 0,
    }" x-init="
    gallerySwiper.on('click', ()=>{
      clickedGalleryItem = gallerySwiper.clickedIndex;
      console.log(clickedGalleryItem);
      galleryModalSwiper.slideTo(clickedGalleryItem);
      
      timesModalSwiperWasUpdated = 0;
      timesModalSwiperWasUpdated += 1;
      if (timesModalSwiperWasUpdated < 3) {
        galleryModalSwiper.emit('slideChange');
      }
      // galleryModalSwiper.navigation.update();
    });

    galleryModalSwiper.on('slideChange', function() {
      if (timesModalSwiperWasUpdated < 3) {
        this.update();
      }
    })
    ">
      <article class="gallery-modal" x-show="isGalleryModalOpen">
          <button class="close-modal" @click="isGalleryModalOpen = false" x-ref="closeModalBtn"><i class="fa-solid fa-x"></i></button>

          <button class="prev-slide" @click="$refs.gallerySlidePrevBtn.click()"><i class="fa-solid fa-arrow-left"></i></button>

          <div class="swiper">
            <div class="swiper-wrapper img-frame">
            <?php
            foreach($gallery_image_list as $gallery_image):
              $gallery_img_file_name = $gallery_image["Descricao"];
              $alternative_text = $gallery_image["Legenda"];
              echo <<<IMAGE_ELEMENT
              <img src="$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$gallery_img_file_name" class="swiper-slide" alt="$alternative_text" >
              IMAGE_ELEMENT;
            endforeach;
            ?>
            </div>

            <div x-ref="gallerySlidePrevBtn" class="swiper-button-prev"></div>
            <div x-ref="gallerySlideNextBtn" class="swiper-button-next"></div>
          </div>

          <button class="next-slide" @click="$refs.gallerySlideNextBtn.click()"><i class="fa-solid fa-arrow-right"></i></button>
      </article>
      <section class="gallery">
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_2g.jpg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_3g.jpg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

<?php
  else:
    echo '<p>Um erro ocorreu buscar os dados dessa página. Entre em contato com nosso suporte.</p>';
  endif;
}
?>