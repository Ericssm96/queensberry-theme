<?php
// Ensure this is a single page
if (is_single()) {
  // Get the current post ID
  $page_id = get_the_ID();

  // Retrieve the custom metadata
  $custom_data = get_post_meta($page_id, 'custom_data', true);

  // Check if the custom data exists
  if (!empty($custom_data)):
    // Access the data
    $program_info = $custom_data['ProgramInfo'];
    $additional_program_info = $custom_data['ProgramAddInfo'];
    $current_category_info = $custom_data['CategoryInfo'];
    $program_logs_info = $custom_data['ProgramLogInfo'];
    $program_notes = $custom_data['ProgramNotes'];
    $image_gallery_files = $custom_data['ImageGalleryFiles'];
    $price_table_image_files = $custom_data['PriceTableImageFiles'];
    $region_info = $custom_data['RegionInfo'];

    $program_name = $program_info["Descricao"];
    $log_name = $additional_program_info["CadernoTitulo"];
    $program_code = $program_info["CodigoPrograma"];
    $category_code = $program_info["CategoriaCodigo"];
    /* $current_category_info = array_find($categories_info, function($category_info) use ($category_code) {
      return $category_info["CategoriaCodigo"] == $category_code;
    }); */
    $category_name = $current_category_info["CategoriaDescricao"];
    $program_tower = $program_info["Torre"];
    /* $program_log_info = array_find($program_logs_info, function($program_log) use ($program_tower) {
      return $program_log[""];
    }); */
    $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
      $lower_log_name = trim(mb_strtolower($log_name));
      $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

      return $lower_log_name == $current_item_name && $program_log_info["CadernoPastaImagens"] !== "";
    });
    $quick_description = $program_info["DescricaoResumida"];
    $days_qtty = $program_info["QtdDiasViagem"];
    $nights_qtty = $program_info["QtdNoitesViagem"];
    $visit_details_quick_info = $program_info["Detalhes"];
    $program_outings_info = $program_info["SaidasPrograma"];

    $images_folder_prefix_url = "https://www.queensberry.com.br/imagens/";
    $category_image_folder = $current_category_info["PastaImagens"]; // Ex.: FERIAS_NA_NEVE
    $program_log_image_folder = $program_log_info["CadernoPastaImagens"]; // Ex.: AMERICAS


    if(sanitize_title($program_name) === "nova-zelandia-de-norte-a-sul") {
      $program_log_image_folder = "AUSTRALIA_E_NOVA_ZELANDIA";
    }


    $url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]); // Ex.: NEVE002
    $banner_img_file_name = $program_info["Banner"]; // Ex.: DESTAQUE_NEVE002.JPG
    $banner_img_file_name = rawurlencode($banner_img_file_name);
    $log_img_file_name = $image_gallery_files[0]['Descricao'];
    
    $attraction_description_list = array_filter($program_notes, function($note) {
      return $note["NotaDescricao"] == "ATRAÇÕES";
    });
    $itinerary_info_list = array_filter($program_notes, function($note) {
      return $note["ProgramaDescricao"] == "Roteiro Dia-a-Dia";
    });
    $itinerary_info_list = array_values($itinerary_info_list);
    $services_info_list = array_filter($program_notes, function($note) {
      return $note["ProgramaDescricao"] == "Serviços";
    });

    /* $services_note_contents = [];
    $temporary_index = [];

    foreach ($services_info_list as $service_info) {
        $service_title = $service_info['NotaDescricao'];
        
        if (isset($temporary_index[$title])) {
            // Append to existing text
            $services_note_contents[$temporary_index[$service_title]]['NotaTextoDescricao'] .= $service_info['NotaTextoDescricao'];
        } else {
            // Add new entry
            $temporary_index[$service_title] = count($services_note_contents);
            $services_note_contents[] = [
                'TituloNota' => $title,
                'ConteudoNota' => $service_info['NotaTextoDescricao']
            ];
        }
    }

    unset($temporary_index); */

    $services_note_contents = [];
/* 
    foreach ($services_info_list as $service_info) {
        $title = $service_info['NotaDescricao'];
        $text = $service_info['NotaTextoDescricao'];
        
        // Check if this title already exists in the new array
        $found = false;
        foreach ($services_note_contents as &$note_content) {
            if ($note_content['NotaDescricao'] === $title) {
                $note_content['NotaTextoDescricao'] .= $text; // Append the text
                $found = true;
            }
        }
        
        // If title wasn't found, add a new entry
        if (!$found) {
            $services_note_contents[] = [
                'Titulo' => $title,
                'Conteudo' => $text
            ];
        }
    } */

    foreach ($services_info_list as $service_info) {
        $title = $service_info['NotaDescricao'];
        $text = $service_info['NotaTextoDescricao'];
        
        // Check if this title already exists in $post_contents
        $found_key = null;
        foreach ($services_note_contents as $key => $post) {
            if ($post['NotaDescricao'] === $title) {
                $found_key = $key;
                break;
            }
        }
        
        if ($found_key !== null) {
            // Append the text to the existing entry
            $services_note_contents[$found_key]['NotaTextoDescricao'] .= $text;
        } else {
            // Add a new entry
            $services_note_contents[] = [
                'NotaDescricao' => $title,
                'NotaTextoDescricao' => $text
            ];
        }
    }
  

    $gallery_image_list = array_slice($image_gallery_files, 1);

    get_header();
?>

  <main x-data="{
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
      phoneNumberA: '',
      fullPhoneNumberA: '',
      phoneNumberB: '',
      fullPhoneNumberB: '',
      modalType: '',
      formType: 'recomendar',
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
    <?php
    if(is_user_logged_in()) {
      echo <<<ELEMENT
      <div class="banner-overlay" style="top: 32px;">
      </div>
      ELEMENT;
    } else {
      echo <<<ELEMENT
      <div class="banner-overlay" style="top: 0px;">
      </div>
      ELEMENT;
    }
    ?>


    
    <header style="background-image: url(<?= "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$banner_img_file_name" ?>);" class="product-page-banner">
      <div>
        <strong><?= $category_name ?></strong>
        <h1><?= $program_name ?></h1>
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
          <div class="weather-area">
            <span class="areas">
              <?php 
              for($counter = 0; $counter < count($region_info); $counter++) {
                $location_name = $region_info[$counter]["CidadeNome"];
                $location_weather_link = $region_info[$counter]["ClimaTempo"] !== "" ? $region_info[$counter]["ClimaTempo"] : "#";

                echo <<<LOCATION_LINK
                  <a href="$location_weather_link">$location_name</a>
                LOCATION_LINK;

                if($counter !== (count($region_info) - 1)) {
                  echo <<<DOT
                    <span class="separator">●</span>
                  DOT;
                }
              }
              ?>
            </span>
          </div>
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
                $attraction_description = str_replace("\n", "<br />", $attraction_description);

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
                $itinerary_daily_info = str_replace("\n", "<br />", $itinerary_daily_info);

                echo <<<ITEM_DESCRIPTION
                <div class="topic">
                  <h2>$topic_title</h2>

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
              foreach($services_note_contents as $service_note):
                $service_topic = $service_note["NotaDescricao"];
                $info_text = $service_note["NotaTextoDescricao"];

                $info_text = str_replace("\n", "<br />", $info_text);

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
                <h2><?= $program_name ?></h2>
                <strong>(<?= $category_name ?>)</strong>
                <span class="close-icon"><i class="fa-solid fa-x" @click="$refs.priceTableModal.close()"></i></span>
              </div>
              <div class="modal-content">
                <?php
                foreach($price_table_image_files as $price_table_image_file) {
                  $price_img_file_name = $price_table_image_file["ImagemPrecoPrograma"];
                  echo <<<IMG_ELEMENT
                    <img src="$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$price_img_file_name" alt="">
                  IMG_ELEMENT;
                }
                ?>
              </div>
            </dialog>
          </div>
          <div class="share-links">
            <p>Compartilhe:</p>
            <button @click="isModalOpen = true; modalType = 'form'; formType = 'recomendar'" class="trigger"><i class="fa-regular fa-envelope"></i></button>
            <button class="trigger"><i class="fa-solid fa-print"></i></i></button>
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
          <button @click="isModalOpen = true; modalType = 'form'; formType = 'saber-mais'" class="cta">Solicitar</button>
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
    <div class="gallery-area">
      <article class="gallery-modal" x-show="isModalOpen && modalType === 'gallery'">
          <button class="close-modal" @click="isModalOpen = false; modalType = ''" x-ref="closeModalBtn"><i class="fa-solid fa-x"></i></button>

          <button class="prev-slide" @click="$refs.gallerySlidePrevBtn.click()"><i class="fa-solid fa-arrow-left"></i></button>

          <div class="swiper">
            <div class="swiper-wrapper img-frame">
            <?php
            foreach($gallery_image_list as $gallery_image):
              $file_name_in_array = explode(".", $gallery_image["Descricao"]);
              $current_file_name = $file_name_in_array[0] . "g";
              $file_format = $file_name_in_array[1];

              $gallery_img_file_name = "$current_file_name.$file_format";
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
            <?php
            foreach($gallery_image_list as $gallery_image):
              $file_name_in_array = explode(".", $gallery_image["Descricao"]);
              $current_file_name = $file_name_in_array[0] . "g";
              $file_format = $file_name_in_array[1];

              $gallery_img_file_name = "$current_file_name.$file_format";
              $alternative_text = $gallery_image["Legenda"];
              echo <<<IMAGE_ELEMENT
              <div class="swiper-slide" @click="isModalOpen = true; modalType='gallery'">
                <img src="$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$gallery_img_file_name" alt="$alternative_text" >
              </div>
              IMAGE_ELEMENT;
            endforeach;
            ?>
            </div>
          </div>
        </div>
      </section>
    </div>
    <section class="form-overlay" x-transition.duration.500ms x-show="isModalOpen && modalType === 'form'">
      <form id="f_queensberry_programa" x-show="formType === 'saber-mais'" name="f_queensberry_programa" method="POST">
        <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false; modalType = ''; formType = ''"></i>
        <h2>Solicitar informações do programa</h2>

        <input type="hidden" id="actionField" name="action" value="queensberry_verify_recaptcha_b">

        <!-- Eloqua -->
        <input type="hidden" name="elqFormName" value="queensberry-programa">
        <input type="hidden" name="elqSiteID" value="2864845">
        <input type="hidden" name="elqCustomerGUID" value="">
        <input type="hidden" name="elqCookieWrite" value="0">

        <!-- Responsys -->
        <input type="hidden" name="_ri_"
            value="X0Gzc2X%3DAQjkPkSRWQG3dzeR9L6zbBNsuhuiwzf1GoooFvtzam293VwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQGwMvLlYX8dzgFvyzdNnBml9mE4zaI3Pu6h">
        <input type="hidden" name="_ei_" value="EMsDHZOiLRwcDIic0BS0IpQ">
        <input type="hidden" name="_di_" value="k61r2sn2j55sonuocuf01h8r250hjaj2g2gumhl7p9pms8941fcg">
        <input type="hidden" name="EMAIL_PERMISSION_STATUS_" value="O" id="optIn">
        <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
        <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Programa - Queensberry">
        <input type="hidden" id="URL_CADASTRO" name="URL_CADASTRO" onload="getURL">
        <input type="hidden" name="FULL_PHONE_NUMBER" x-bind:value="fullPhoneNumberA" id="fullPhoneNumber">


        <!-- Formulário -->
        <div class="inner-form">
          <div class="input-area">
            <label for="FIRST_NAME">Nome</label>
            <input type="text" placeholder="Nome*" required id="FIRST_NAME" name="FIRST_NAME">
          </div>
          <div class="input-area">
            <label for="EMAIL_ADDRESS_">E-mail</label>
            <input type="text" placeholder="E-mail*" required id="EMAIL_ADDRESS_" name="EMAIL_ADDRESS_">
          </div>
          <div class="input-area">
            <label for="MOBILE_NUMBER_">Telefone</label>
            <input type="text" placeholder="Telefone()*" @change="fullPhoneNumberA = '55' + phoneNumberA" x-model="phoneNumberA" required maxlength="14" id="MOBILE_NUMBER_" name="MOBILE_NUMBER_" id="celular">
          </div>
          <div class="input-area">
            <label for="iptEstado">Estado</label>
            <select required name="ESTADO" id="iptEstado">
                <option value="">Selecione um Estado</option>
            </select>
          </div>
          <div class="input-area">
            <label for="iptCidade">Cidade</label>
            <select name="CIDADE" id="iptCidade" required>
                <option value="">Selecione uma Cidade</option>
            </select>
          </div>
          <div class="input-area">
            <label for="PERFIL">Perfil</label>
            <select required id="PERFIL" name="PERFIL">
                <option value="">- Selecione o Assunto - </option>
                <option value="passageiro">Passageiro</option>
                <option value="agente">Agente de Viagens</option>
            </select>
          </div>
          <div class="input-area">
            <label for="MENSAGEM">Mensagem</label>
            <textarea required id="MENSAGEM" name="MENSAGEM" placeholder="Digite aqui sua mensagem..."></textarea>
          </div>
          <div class="checkbox-area">
            <span class="custom-checkbox">
              <input type="checkbox" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
              <label for="RECEBER_COMUNICACOES" class="checkmark"></label>
            </span>
            <label for="RECEBER_COMUNICACOES" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
          </div>
          <div class="recaptcha-box">
            <div id="recaptcha-box-2"></div>
          </div>
          <button class="submit-btn" type="submit">Enviar</button>
        </div>
      </form>

    
      <script>
          // SCRIPT PARA CARREGAR ESTADOS E CIDADES
          document.addEventListener("DOMContentLoaded", function () {
              const estadoSelect = document.getElementById("iptEstado");
              const cidadeSelect = document.getElementById("iptCidade");

              // Carregar estados na lista
              fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados")
                  .then(response => response.json())
                  .then(estados => {
                      estados.sort((a, b) => a.nome.localeCompare(b.nome));
                      estados.forEach(estado => {
                          const option = document.createElement("option");
                          option.value = estado.sigla;
                          option.textContent = estado.nome;
                          estadoSelect.appendChild(option);
                      });
                  });

              // Evento para carregar cidades ao selecionar estado
              estadoSelect.addEventListener("change", function () {
                  const uf = estadoSelect.value;
                  cidadeSelect.innerHTML = '<option value="">Carregando...</option>';

                  if (uf) {
                      fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
                          .then(response => response.json())
                          .then(cidades => {
                              cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                              cidades.forEach(cidade => {
                                  const option = document.createElement("option");
                                  option.value = cidade.nome;
                                  option.textContent = cidade.nome;
                                  cidadeSelect.appendChild(option);
                              });
                          });
                  } else {
                      cidadeSelect.innerHTML = '<option value="">Cidade</option>';
                  }
              });
          });
      </script>
      <script>
          /* var formData = new FormData(jQuery("#f_queensberry_programa")[0]); // Use FormData para incluir anexos

          $(document).ready(() => {

              // AJUSTANDO A MÁSCARA

              $("#celular").mask("(00) 00000-0000");

              $("#f_queensberry_programa").on("submit", (e) => {
                  e.preventDefault();

                  grecaptcha.reset(clientId1);
                  grecaptcha.reset(clientId2); 
                  grecaptcha.reset(clientId3);

                  const captchaResponse2 = grecaptcha.getResponse(clientId2);

                  if(captchaResponse2.length <= 0) {
                    alert("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.")

                    throw new Error("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.");
                  } else {
                    jQuery.post(
                      "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha_b",
                      $("#f_queensberry_programa").serialize(),
                      function(data) {
                        if(data.data.message === "OK") {
                          $("#actionField").val("queensberry_programa");
                          formData.set("action", "queensberry_programa");
                          console.log(data);

                          const perfil = $("select[name='PERFIL']").val();

                          if (!perfil || perfil == "") {
                              // Se não houver perfil selecionado, exibe o alert
                              alert("Por favor, selecione um perfil válido (Passageiro ou Agente).");
                              return;  // Interrompe o envio do formulário
                          }

                          if (perfil === "passageiro") {
                              // Se for "passageiro", envia para o backend (Responsys)
                              jQuery.post(
                                  "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_programa",
                                  $("#f_queensberry_programa").serialize(),
                                  function (data) {
                                      // Callback para lidar com a resposta
                                      console.log(data); // Exibe a resposta no console
                                  }
                              ).done(() => {
                                  // Redireciona para a página de "Obrigado" após o envio
                                  // window.location.replace("<?= home_url(); ?>/obrigado/");
                                  alert("Envio realizado com sucesso");
                              });
                          } else if (perfil === "agente") {
                              // Se for "agente", envia para Eloqua
                              jQuery.ajax({
                                  type: "POST",
                                  url: "https://s2864845.t.eloqua.com/e/f2",
                                  data: jQuery("#f_queensberry_programa").serialize(),
                                  success: () => {
                                      console.log("Eloqua ok");
                                  },
                                  error: (res) => {
                                      console.log("Eloqua fail", res);
                                  },
                              }).done(() => {
                                  // Redireciona para a página de "Obrigado" após o envio
                                  // window.location.replace("<?= home_url(); ?>/obrigado/");
                                  alert("Envio realizado com sucesso");
                              });
                          }
                        }
                      }
                    )
                    .fail((res) => {
                      console.log("Recaptcha verification fail");
                    })
                  }    
              });
          }); */


          
          $(document).ready(() => {
             var formData = new FormData(jQuery("#f_queensberry_programa")[0]); // Use FormData para incluir anexos

              // AJUSTANDO A MÁSCARA

              $("#celular").mask("(00) 00000-0000");

              $("#f_queensberry_programa").on("submit", (e) => {
                  e.preventDefault();

                    $("#actionField").val("queensberry_programa");
                    formData.set("action", "queensberry_programa");

                    const perfil = $("select[name='PERFIL']").val();

                    if (!perfil || perfil == "") {
                        // Se não houver perfil selecionado, exibe o alert
                        alert("Por favor, selecione um perfil válido (Passageiro ou Agente).");
                        return;  // Interrompe o envio do formulário
                    }

                    if (perfil === "passageiro") {
                        // Se for "passageiro", envia para o backend (Responsys)
                        jQuery.post(
                            "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_programa",
                            $("#f_queensberry_programa").serialize(),
                            function (data) {
                                // Callback para lidar com a resposta
                                console.log(data); // Exibe a resposta no console
                                /* alert("Envio realizado com sucesso!") */
                            }
                        ).done(() => {
                            // Redireciona para a página de "Obrigado" após o envio
                            // window.location.replace("<?= home_url(); ?>/obrigado/");
                            alert("Envio realizado com sucesso");
                        });
                    } else if (perfil === "agente") {
                        // Se for "agente", envia para Eloqua
                        jQuery.ajax({
                            type: "POST",
                            url: "https://s2864845.t.eloqua.com/e/f2",
                            data: jQuery("#f_queensberry_programa").serialize(),
                            success: () => {
                                console.log("Eloqua ok");
                                /* alert("Envio realizado com sucesso!") */
                            },
                            error: (res) => {
                                console.log("Eloqua fail", res);
                            },
                        }).done(() => {
                            // Redireciona para a página de "Obrigado" após o envio
                            // window.location.replace("<?= home_url(); ?>/obrigado/");
                            alert("Envio realizado com sucesso");
                        });
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
                      document.forms["f_queensberry_programa"].elements["elqCustomerGUID"].value = GetElqCustomerGUID();
                      return;
                  }
                  timeout -= 1;
              }
              timerId = setTimeout("WaitUntilCustomerGUIDIsRetrieved()", 500);
              return;
          }

          window.onload = WaitUntilCustomerGUIDIsRetrieved;
          _elqQ = _elqQ || [];
          _elqQ.push(['elqGetCustomerGUID']);
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


      <form id="f_queensberry_recomendar_programa" name="f_queensberry_recomendar_programa" method="POST" x-show="isModalOpen && modalType === 'form' && formType === 'recomendar'">
          <input type="hidden" id="actionField2" name="action" value="queensberry_verify_recaptcha_c">
          <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false; modalType = ''; formType = ''"></i>
          <h2>Recomendar Programa</h2>

          <!-- Responsys -->
          <input type="hidden" name="_ri_"
              value="X0Gzc2X%3DAQjkPkSRWQGvd46H8AazcAfgLBPKA19XWHehXFudc5VwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQGzeCj2E6OlFDyIUPtO6kwzd9AoaTLlUYs">
          <input type="hidden" name="_ei_" value="ET7obVahR1vnJMcvllB-uxg">
          <input type="hidden" name="_di_" value="il13bar20jj92v93jquln3o9t91ml5b13dqjrnk5jso1031f734g">
          <input type="hidden" name="EMAIL_PERMISSION_STATUS_" value="O" id="optIn">
          <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Recomendar Programa - Queensberry">
          <input type="hidden" id="URL_CADASTRO" name="URL_CADASTRO" onload="getURL">

          <!-- Formulário -->
          <div class="inner-form">
            <div class="input-area">
              <label for="iptNome">Nome*</label>
              <input type="text" placeholder="Nome" required name="FIRST_NAME">
            </div>
            <div class="input-area">
            <label for="iptRemetente">Remetente* (e-mail)</label>
              <input type="text" placeholder="Remetente" required name="EMAIL_ADDRESS_">
            </div>
            <div class="input-area">
              <label for="iptDestino">Destino*</label>
              <input type="text" id="iptDestino" required name="DESTINO" placeholder="Destinatário">
            </div>
            <div class="input-area">
              <label for="iptMsg">Mensagem*</label>
              <textarea required id="iptMsg" name="MENSAGEM" placeholder="Digite aqui sua mensagem..."></textarea>
            </div>
            <div class="checkbox-area">
              <span class="custom-checkbox">
                <input type="checkbox" value="Sim" name="RECEBER_COMUNICACOES" id="checkReceberComunicacoes">
                <label for="checkReceberComunicacoes" class="checkmark"></label>
              </span>
              <label for="checkReceberComunicacoes" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
            </div>
            <div class="recaptcha-box">
              <div id="recaptcha-box-3"></div>
            </div>
            <button class="submit-btn" type="submit">Enviar</button>
          </div>
      </form>

      <script>
/*           var formData2 = new FormData(jQuery("#f_queensberry_recomendar_programa")[0]); // Use FormData para incluir anexos

          $(document).ready(() => {

              $("#f_queensberry_recomendar_programa").on("submit", (e) => {
                  e.preventDefault();

                  let captchaResponse2 = grecaptcha.getResponse();

                  console.log(captchaResponse2)

                  if(captchaResponse2.length <= 0) {
                    alert("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.")

                    throw new Error("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.");
                  } else {
                    jQuery.post(
                        "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha",
                        $("#f_queensberry_recomendar_programa").serialize(),
                        function (data) {
                          $("#actionField2").val("queensberry_recomendar_programa");
                          formData2.set("action", "queensberry_recomendar_programa");
                          console.log(data);
                          if(data.data.message === "OK") {
                            jQuery.post(
                                "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_recomendar_programa",
                                $("#f_queensberry_recomendar_programa").serialize(),
                                function (data) {
                                    // Callback para lidar com a resposta
                                    console.log(data); // Exibe a resposta no console
                                }
                            )
                          }
                        }
                    ).fail((res)=>{

                    }).done(() => {
                        // Redireciona para a página de "Obrigado" após o envio
                        // window.location.replace("<?= home_url(); ?>/obrigado/");
                        alert("Envio realizado com sucesso");
                    });
                  }
                 

              });
          }); */






/* 
          $(document).ready(() => {

              // AJUSTANDO A MÁSCARA

              $("#celular").mask("(00) 00000-0000");

              $("#f_queensberry_recomendar_programa").on("submit", (e) => {
                  e.preventDefault();

                  const captchaResponse3 = grecaptcha.getResponse(clientId3);

                  if(captchaResponse3.length <= 0) {
                    alert("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.")

                    throw new Error("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.");
                  } else {
                    jQuery.post(
                      "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha_c",
                      $("#f_queensberry_recomendar_programa").serialize(),
                      function(data) {
                        if(data.data.message === "OK") {
                          $("#actionField").val("queensberry_recomendar_programa");
                          formData.set("action", "queensberry_recomendar_programa");
                          console.log(data);

                          jQuery.post(
                              "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_recomendar_programa",
                              $("#f_queensberry_recomendar_programa").serialize(),
                              function (data) {
                                  // Callback para lidar com a resposta
                                  console.log(data); // Exibe a resposta no console
                              }
                          )
                        }
                      }
                    )
                    .fail((res) => {
                      console.log("Recaptcha verification fail");
                    })
                  }    
              });
          }); */


          
          $(document).ready(() => {

// AJUSTANDO A MÁSCARA

$("#celular").mask("(00) 00000-0000");

$("#f_queensberry_recomendar_programa").on("submit", (e) => {
    e.preventDefault();

    
    $("#actionField2").val("queensberry_recomendar_programa");

      jQuery.post(
          "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_recomendar_programa",
          $("#f_queensberry_recomendar_programa").serialize(),
          function (data) {
              // Callback para lidar com a resposta
              console.log(data); // Exibe a resposta no console
              alert("Envio realizado com sucesso!")
          }
      )
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
                      document.forms["f_queensberry_programa"].elements["elqCustomerGUID"].value = GetElqCustomerGUID();
                      return;
                  }
                  timeout -= 1;
              }
              timerId = setTimeout("WaitUntilCustomerGUIDIsRetrieved()", 500);
              return;
          }

          window.onload = WaitUntilCustomerGUIDIsRetrieved;
          _elqQ = _elqQ || [];
          _elqQ.push(['elqGetCustomerGUID']);
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

<?php
    get_footer();
  else:
    echo '<p>Um erro ocorreu buscar os dados dessa página. Entre em contato com nosso suporte.</p>';
  endif;
}
?>