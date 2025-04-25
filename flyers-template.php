<?php
/*
    Template Name: Folhetos e Cadernos Template
*/
get_header();

$flyers_array = get_flyers_array();


$flyer_img_url_prefix = "https://www.queensberry.com.br/imagens//Folhetos";

?>

<main>
  <header class="banner">
      <h1>Folhetos & Cadernos</h1>
  </header>
  <section class="cards-area-a">
    <div class="wrapper">
      <div class="alert">
        <p>* Preencha a quantidade de um ou mais cadernos.</p>
      </div>
      <div class="gbm-area">
        <h2>GBM - Grupos Brasileiros no Mundo</h2>
        <div class="cards-grid gbm">
        <?php 
        foreach($flyers_array as $flyer) {
          $img_file_name = $flyer["ImagemFolheto"];
          $flyer_description = $flyer["Descricao"];
          $flyer_file_link = $flyer["ArquivoFolheto"];
          $flyer_pdf_link = $flyer["ArquivoPDF"];
          $full_img_url = "$flyer_img_url_prefix/$img_file_name";
          $sanitized_description = sanitize_title($flyer_description);

          if(str_contains($flyer["ArquivoFolheto"], "GBM")) {
            echo <<<CARD
            <div class="card">
              <a href="$flyer_file_link" class="card-img">
                <img src="$full_img_url" alt="">
              </a>
              <h3>$flyer_description</h3>
              <div class="action-icons">
                <a href="$flyer_pdf_link" class="action-icon"><i class="fa-regular fa-file-pdf"></i></a>
                <a href="$flyer_file_link" class="action-icon"><i class="fa-solid fa-download"></i></a>
                <a href="#" class="action-icon"><i class="fa-solid fa-share-nodes"></i></a>
              </div>
              <div class="qtty-setter">
                <button type="button">-</button>
                <input type="number" value="0" name="FLYER_QTTY" id="$sanitized_description">
                <button type="button">+</button>
              </div>
            </div>
            CARD;
          }
        }
        ?>
        </div>
      </div>
    </div>
  </section>
  <div class="cards-area-b">
    <div class="wrapper">
      <div class="general-area">
        <h2>Outros</h2>
        <div class="cards-grid general">

        <?php 
        foreach($flyers_array as $flyer) {
          $img_file_name = $flyer["ImagemFolheto"];
          $flyer_description = $flyer["Descricao"];
          $flyer_file_link = $flyer["ArquivoFolheto"];
          $flyer_pdf_link = $flyer["ArquivoPDF"];
          $full_img_url = "$flyer_img_url_prefix/$img_file_name";
          $sanitized_description = sanitize_title($flyer_description);

          if(!str_contains($flyer["ArquivoFolheto"], "GBM")) {
            echo <<<CARD
            <div class="card">
              <a href="$flyer_file_link" class="card-img">
                <img src="$full_img_url" alt="">
              </a>
              <h3>$flyer_description</h3>
              <div class="action-icons">
                <a href="$flyer_pdf_link" class="action-icon"><i class="fa-regular fa-file-pdf"></i></a>
                <a href="$flyer_file_link" class="action-icon"><i class="fa-solid fa-download"></i></a>
                <a href="#" class="action-icon"><i class="fa-solid fa-share-nodes"></i></a>
              </div>
              <div class="qtty-setter">
                <button type="button">-</button>
                <input type="number" value="0" name="FLYER_QTTY" id="$sanitized_description">
                <button type="button">+</button>
              </div>
            </div>
            CARD;
          }
        }
        ?>
        </div>
      </div>
      <button class="request-btn" @click="isModalOpen = true;">Solicitar</button>
    </div>
  </div>
  <div class="modal-overlay" x-show="isModalOpen">
    <div class="request-flyer-modal">
      <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false"></i>
      <div class="title-area">
        <h2>Selecione o seu Perfil</h2>
      </div>
      <div class="selection-area">
        <div class="radio-field">
          <span class="custom-radio">
            <input type="radio" value="AGENTE_VIAGENS" name="PERFIL_USUARIO" id="iptAgenteViagens">
            <label for="iptAgenteViagens" class="radio-circle"></label>
          </span>
          <label class="text-label" for="iptAgenteViagens">Agente de Viagens</label>
        </div>
        <div class="radio-field">
          <span class="custom-radio">
            <input type="radio" value="PASSAGEIRO" name="PERFIL_USUARIO" id="iptPassageiro">
            <label for="iptPassageiro" class="radio-circle"></label>
          </span>
          <label class="text-label" for="iptPassageiro">Passageiro</label>
        </div>
      </div>
    </div>
  </div>
</main>


<?php get_footer(); ?>