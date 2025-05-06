<?php
/*
  Template Name: Formulários
*/

$forms_data = get_form_files_array();
$form_file_url_prefix = "https://img.queensberry.com.br/imagens//Formularios/GERAL";



get_header(); ?>

<main>
  <header class="banner">
    <h1>Formulários</h1>
  </header>
  <article class="form-tag-selector">
    <div class="wrapper">
      <button class="selector-btn">Geral</button>
    </div>
  </article>
  <section class="btns-area">
    <div class="wrapper">
      <h2>Geral</h2>
      <div class="btn-grid">
        <?php
        foreach($forms_data as $form_data) {
          $file_name = $form_data["NomeArquivo"];
          $file_url = "$form_file_url_prefix/$file_name";
          $form_name = $form_data["Descricao"];

          echo <<<FORM_LINK
          <a href="$file_url" class="file-link" target="_blank">
            <p>$form_name</p>
            <div class="download-cta">
              <strong>Download</strong>
              <i class="fa-solid fa-download"></i>
            </div>
          </a>
          FORM_LINK;
        }
        ?>
        <!-- <a href="#" class="file-link">
          <p>Contrato de Intermediação de Viagens</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Autorização de Cartão de Crédito</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Ficha de Financiamento</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Visto Irã</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Cobertura Seguro de Viagem IFASEG GBM</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Contrato WindStar</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a>

        <a href="#" class="file-link">
          <p>Formulário de Dados Pessoais</p>
          <div class="download-cta">
            <strong>Download</strong>
            <i class="fa-solid fa-download"></i>
          </div>
        </a> -->
      </div>
    </div>
</main>


<?php get_footer(); ?>