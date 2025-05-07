<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <?php wp_head(); ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://www.google.com/recaptcha/api.js?render=6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Roboto:wght@100..900&family=Tenor+Sans&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link rel="icon" href="<?= get_template_directory_uri(); ?>/src/img/favicon-queensberry-viagens.png">
  <?php
  $site_title = get_bloginfo('name');

  if (is_front_page()) {
    $page_title = $site_title;
    $full_title = $site_title;
  } else if (is_category()) {
    $page_title = single_cat_title('', false);
    $full_title = $page_title . " - " . $site_title;
  } else if (is_tag()) {
    $page_title = single_tag_title('', false);
    $full_title = $page_title . " - " . $site_title;
  } else if (is_single()) {
    // $page_title = single_tag_title('', false);
    // $page_title = wp_title('');
    $page_title = get_the_title();
    $full_title = $page_title . " - " . $site_title;
  } else {
    $page_title = get_the_title();
    $full_title = $page_title . " - " . $site_title;
  }

  $page_title = strtoupper($page_title);
  $site_title = strtoupper($site_title);
  $full_title = strtoupper($full_title)
  

  ?>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <meta name="adopt-website-id" content="2c707e8a-d87e-41de-b892-ddea7690a799" />
  <script src="//tag.goadopt.io/injector.js?website_code=2c707e8a-d87e-41de-b892-ddea7690a799" 
  class="adopt-injector"></script>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-MG9V8HG');</script>
  <!-- End Google Tag Manager -->
</head>

<?php

// Carrega informações de câmbio
$dolar_currency_info = require __DIR__ . "/dolar-currency-conversion-info.php";
$euro_currency_info = require __DIR__ . "/euro-currency-conversion-info.php";

// Inicializa valores padrões
$dolar_price = "N/D";
$euro_price = "N/D";
$formatted_conversion_date = "Data indisponível";
$last_dolar_conversion_update_time = "--:--";

// Se os dados forem carregados corretamente
if (is_array($dolar_currency_info) && isset($dolar_currency_info["DataAtualizacao"], $dolar_currency_info["ValorCambio"])) {
  $last_dolar_conversion_update_date = explode("T", $dolar_currency_info["DataAtualizacao"])[0];
  $last_dolar_conversion_update_time = explode("T", $dolar_currency_info["DataAtualizacao"])[1];
  $dolar_price = substr(str_replace(".", ",", $dolar_currency_info["ValorCambio"]), 0, 4);
}

if (is_array($euro_currency_info) && isset($euro_currency_info["DataAtualizacao"], $euro_currency_info["ValorCambio"])) {
  $last_conversion_update_date = explode("T", $euro_currency_info["DataAtualizacao"])[0];
  $last_conversion_date_obj = new DateTime($last_conversion_update_date);
  $formatted_conversion_date = $last_conversion_date_obj->format('d/m/Y');
  $euro_price = substr(str_replace(".", ",", $euro_currency_info["ValorCambio"]), 0, 4);
}


?>


<body x-data="{
  isModalOpen: false,
}" x-bind:style="isModalOpen ? 'overflow: hidden;' : 'overflow: auto;'">

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MG9V8HG"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <nav
    x-bind:class="isNavSelected || isMouseOverNav || isWindowScrolledPastThreshold ? 'desktop-navigation white-nav' : 'desktop-navigation'"
    x-data="{
    isNavActive: false,
    isMouseOverNav: false,
    isNavSelected: false,
    isWindowScrolledPastThreshold: false
  }" x-on:mouseover="isMouseOverNav = true" x-on:mousemove="isMouseOverNav = true"
    x-on:mouseout="isMouseOverNav = false"
    x-init="window.addEventListener('scroll', () => isWindowScrolledPastThreshold = window.scrollY > 150)">
    <div class="nav-a">
      <div class="wrapper">
        <?php echo do_shortcode('[desktop_header_search]'); ?>
        <h1 class="site-logo">
          <a href="<?= home_url() ?>"><img
              x-bind:src="isNavSelected || isMouseOverNav || isWindowScrolledPastThreshold ? '<?= get_template_directory_uri(); ?>/src/img/logo-escuro.png' : '<?= get_template_directory_uri(); ?>/src/img/logo.png'"
              alt="Queensberry Viagens" title="Queensberry Viagens" class="logo-img" /></a>
        </h1>
        <div class="upper-right">
          <span x-show="!isWindowScrolledPastThreshold" class="green-highlight currency-field">
            <strong class="bold">US$ 1 = R$<?= $dolar_price ?> | € 1 = R$<?= $euro_price ?></strong>
            <p class="data">
              <span class="bold">Data:</span><?= $formatted_conversion_date ?> às <?= $last_dolar_conversion_update_time ?>
            </p>
          </span>
          <a href="https://agentes.queensberry.com.br/" class="green-highlight agent-field">
            <svg width="13" class="user-icon" height="14" viewBox="0 0 13 14" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M8.90764 8.09375C10.7865 8.09375 12.3354 9.64258 12.3354 11.5215V12.1562C12.3354 12.8418 11.7768 13.375 11.1166 13.375H2.17913C1.49358 13.375 0.960375 12.8418 0.960375 12.1562V11.5215C0.960375 9.64258 2.48381 8.09375 4.36272 8.09375C5.09905 8.09375 5.42913 8.5 6.64788 8.5C7.84123 8.5 8.17131 8.09375 8.90764 8.09375ZM11.1166 12.1562V11.5215C11.1166 10.3027 10.1264 9.3125 8.90764 9.3125C8.52678 9.3125 7.9428 9.71875 6.64788 9.71875C5.32756 9.71875 4.74358 9.3125 4.36272 9.3125C3.14397 9.3125 2.17913 10.3027 2.17913 11.5215V12.1562H11.1166ZM6.64788 7.6875C4.61663 7.6875 2.99163 6.0625 2.99163 4.03125C2.99163 2.02539 4.61663 0.375 6.64788 0.375C8.65373 0.375 10.3041 2.02539 10.3041 4.03125C10.3041 6.0625 8.65373 7.6875 6.64788 7.6875ZM6.64788 1.59375C5.30217 1.59375 4.21038 2.71094 4.21038 4.03125C4.21038 5.37695 5.30217 6.46875 6.64788 6.46875C7.96819 6.46875 9.08538 5.37695 9.08538 4.03125C9.08538 2.71094 7.96819 1.59375 6.64788 1.59375Z"
                fill="white" />
            </svg>
            Área do Agente
          </a>
        </div>
      </div>
    </div>
    <div class="nav-b">
      <div class="wrapper">
        <ul class="nav-links">
          <li class="nav-link destinos-dt">
            <a href="#"><span class="dot-ref">Destinos</span></a>
            <div class="mega-box">
              <div class="content-a">
                <div class="row">
                  <h3>
                    <header>
                      <h3><a href="<?= home_url(); ?>/destino/africa" class="title-link">África</a></h3>
                    </header>
                  </h3>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/africa-do-sul">África do Sul</a></li>
                    <li><a href="<?= home_url(); ?>/destino/egito">Egito</a></li>
                    <li><a href="<?= home_url(); ?>/destino/marrocos">Marrocos</a></li>
                    <li><a href="<?= home_url(); ?>/destino/quenia">Quênia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/tanzania">Tanzânia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/africa" class="plus">[+]</a></li>
                  </ul>
                </div>
                <div class="row">
                  <header>
                    <h3><a href="<?= home_url(); ?>/destino/americas" class="title-link">Américas</a></h3>
                  </header>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/argentina">Argentina</a></li>
                    <li><a href="<?= home_url(); ?>/destino/brasil">Brasil</a></li>
                    <li><a href="<?= home_url(); ?>/destino/canada">Canadá</a></li>
                    <li><a href="<?= home_url(); ?>/destino/chile">Chile</a></li>
                    <li><a href="<?= home_url(); ?>/destino/estados-unidos">Estados Unidos</a></li>
                    <li><a href="<?= home_url(); ?>/destino/mexico">México</a></li>
                    <li><a href="<?= home_url(); ?>/destino/peru">Peru</a></li>
                    <li><a href="<?= home_url(); ?>/destino/americas" class="plus">[+]</a></li>
                  </ul>
                </div>
                <div class="row">
                  <header>
                    <h3><a href="<?= home_url(); ?>/destino/asia" class="title-link">Ásia</a></h3>
                  </header>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/china">China</a></li>
                    <li><a href="<?= home_url(); ?>/destino/india">Índia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/japao">Japão</a></li>
                    <li><a href="<?= home_url(); ?>/destino/maldivas">Maldivas</a></li>
                    <li><a href="<?= home_url(); ?>/destino/tailandia">Tailândia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/asia" class="plus">[+]</a></li>
                  </ul>
                </div>
                <div class="row">
                  <header>
                    <h3><a href="<?= home_url(); ?>/destino/europa" class="title-link">Europa</a></h3>
                  </header>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/alemanha">Alemanha</a></li>
                    <li><a href="<?= home_url(); ?>/destino/croacia">Croácia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/espanha">Espanha</a></li>
                    <li><a href="<?= home_url(); ?>/destino/grecia">Grécia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/italia">Itália</a></li>
                    <li><a href="<?= home_url(); ?>/destino/portugal">Portugal</a></li>
                    <li><a href="<?= home_url(); ?>/destino/russia">Rússia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/turquia">Turquia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/europa" class="plus">[+]</a></li>
                  </ul>
                </div>
                <div class="row">
                  <header>
                    <h3><a href="<?= home_url(); ?>/destino/oceania" class="title-link">Oceania</a></h3>
                  </header>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/australia">Austrália</a></li>
                    <li><a href="<?= home_url(); ?>/destino/nova-zelandia">Nova Zelândia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/oceania" class="plus">[+]</a></li>
                  </ul>
                </div>
                <div class="row">
                  <header>
                    <h3><a href="<?= home_url(); ?>/destino/oriente-medio" class="title-link">Oriente Médio</a></h3>
                  </header>
                  <ul class="mega-links">
                    <li><a href="<?= home_url(); ?>/destino/emirados-arabes">Emirados Árabes</a></li>
                    <li><a href="<?= home_url(); ?>/destino/ira">Irã</a></li>
                    <li><a href="<?= home_url(); ?>/destino/israel">Israel</a></li>
                    <li><a href="<?= home_url(); ?>/destino/jordania">Jordânia</a></li>
                    <li><a href="<?= home_url(); ?>/destino/libano">Líbano</a></li>
                    <li><a href="<?= home_url(); ?>/destino/emirados-arabes" class="plus">[+]</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-link">
            <a href="#"><span class="dot-ref">Produtos</span></a>
            <div class="mega-box">
              <div class="content-b">
                <ul class="left-col">
                  <li><a href="<?= home_url(); ?>/categoria/ferias-na-neve">Férias na neve</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/walt-disney-world-resort">Walt Disney World Resort</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/driveness-experience">Driveness Experience</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/viagens-personalizadas">Viagens personalizadas</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/tours-regulares">Tours Regulares</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/brasil-in">Brasil In</a></li>
                  <li><a href="<?= home_url(); ?>/categoria/cruzeiros">Cruzeiros</a></li>
                </ul>
                <div class="right-col">
                  <header>
                    <h3><a href="<?= home_url(); ?>/categoria/gbm-grupos-brasileiros-no-mundo">GBM - Grupos Brasileiros No Mundo</a></h3>
                  </header>
                  <ul class="cards-area">
                    <li>
                      <a href="<?= home_url(); ?>/categoria/gbm-grupos-brasileiros-no-mundo?checked_log=4-continentes-2025-log">
                        <img src="<?= get_template_directory_uri(); ?>/src/img/gbm-4-continentes.png" alt="Imagem Promocional Grupo Brasil no Mundo - 4 Continentes" />
                      </a>
                      <p>4 continentes 2025</p>
                    </li>
                    <li>
                      <a href="<?= home_url(); ?>/categoria/gbm-grupos-brasileiros-no-mundo?checked_log=europa-2025-log">
                        <img src="<?= get_template_directory_uri(); ?>/src/img/gbm-europa.png" alt="Imagem Promocional Grupo Brasil no Mundo - Europa" />
                      </a>
                      <p>Europa 2025</p>
                    </li>
                    <li>
                      <a href="<?= home_url(); ?>/categoria/gbm-grupos-brasileiros-no-mundo?checked_log=baixa-temporada-2025-log">
                        <img src="<?= get_template_directory_uri(); ?>/src/img/gbm-baixa-temporada.png" alt="Imagem Promocional Grupo Brasil no Mundo - Baixa Temporada" />
                      </a>
                      <p>Baixa Temporada 2025</p>
                    </li>
                    <li>
                      <a href="<?= home_url(); ?>/categoria/gbm-grupos-brasileiros-no-mundo?checked_log=slow-travel-2025-log">
                        <img src="<?= get_template_directory_uri(); ?>/src/img/gbm-slow-travel.png" alt="Imagem Promocional Grupo Brasil no Mundo - Slow Travel" />
                      </a>
                      <p>Slow Travel 2025</p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-link"><a href="https://disney.queensberry.com.br/" target="_blank">Disney</a></li>
          <li class="nav-link"><a href="https://blog.queensberry.com.br/" target="_blank" rel="noopener">Blog</a></li>
          <li class="nav-link"><a href="https://www.queensberryincentivos.com.br/" target="_blank" rel="noopener">Viagens de Incentivo</a></li>
          <li class="nav-link"><a href="<?= home_url() ?>/quem-somos/">Quem Somos</a></li>
          <li class="nav-link"><a href="<?= home_url() ?>/fale-conosco">Fale Conosco</a></li>
          <li class="nav-link"><a href="https://agentes.queensberry.com.br/seja-um-parceiro/" target="_blank" rel="noopener">Seja um Parceiro</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <nav class="mobile-navigation" x-data="{
    isMobileNavOpen: false,
    isMobileSearchOpen: false,
    isWindowScrolledPastThreshold: false
  }" x-init="window.addEventListener('scroll', () => isWindowScrolledPastThreshold = window.scrollY > 150)">
    <div
      x-bind:class="isMobileNavOpen || isMobileSearchOpen || isWindowScrolledPastThreshold ? 'nav-c white-mobile-nav' : 'nav-c'">
      <h1>
        <a href="<?= home_url() ?>"><img
            x-bind:src="isMobileNavOpen || isMobileSearchOpen || isWindowScrolledPastThreshold ? '<?= get_template_directory_uri(); ?>/src/img/logo-escuro.png' : '<?= get_template_directory_uri(); ?>/src/img/logo.png'"
            alt="Home - Queensberry" title="Home - Queensberry" /></a>
      </h1>

      <div class="light-buttons">
        <label class="search-btn" id="whiteSearchBtnMb" for="mobile-search-toggle"><i
            class="fa-solid fa-magnifying-glass"></i></label>
        <label class="menu-btn" for="mobile-menu-toggle"><i class="fa-solid fa-bars"></i></label>
      </div>
    </div>
    <input type="checkbox" id="mobile-menu-toggle" class="mobile-menu-toggle"
      x-on:change="isMobileNavOpen = !isMobileNavOpen" />
    <div class="nav-d">
      <div class="dark-buttons">
        <label class="search-btn" id="blackSearchBtnMb" for="mobile-search-toggle"><i
            class="fa-solid fa-magnifying-glass"></i></label>
        <label class="menu-btn" for="mobile-menu-toggle"><i class="fa-solid fa-bars"></i></label>
      </div>
      <ul class="menu-items-mb">
        <li>
          <label class="parent-item" for="destinos-mb"><span>Destinos</span><span class="icon"><i
                class="fa-solid fa-caret-down"></i></span></label>
          <input type="checkbox" name="dropdown-mb" id="destinos-mb" />
          <ul class="destinos-items-mb">
            <li><a href="<?= home_url(); ?>/destino/africa">África</a></li>
            <li><a href="<?= home_url(); ?>/destino/americas">Américas</a></li>
            <li><a href="<?= home_url(); ?>/destino/asia">Ásia</a></li>
            <li><a href="<?= home_url(); ?>/destino/europa">Europa</a></li>
            <li><a href="<?= home_url(); ?>/destino/oceania">Oceania</a></li>
            <li><a href="<?= home_url(); ?>/destino/oriente-medio">Oriente Médio</a></li>
          </ul>
        </li>
        <li>
          <label class="parent-item" for="produtos-mb">Produtos<span class="icon"><i
                class="fa-solid fa-caret-down"></i></span></label>
          <input type="checkbox" name="dropdown-mb" id="produtos-mb" />
          <ul class="produtos-items-mb">
            <li><a href="<?= home_url(); ?>/categoria/ferias-na-neve">Férias na neve</a></li>
            <li><a href="<?= home_url(); ?>/categoria/walt-disney-world-resort">Walt Disney World Resort</a></li>
            <li><a href="<?= home_url(); ?>/categoria/viagens-personalizadas">Viagens personalizadas</a></li>
            <li><a href="<?= home_url(); ?>/categoria/tours-regulares">Tours regulares</a></li>
            <li><a href="<?= home_url(); ?>/categoria/brasil-in">Brasil in</a></li>
            <li><a href="<?= home_url(); ?>/categoria/cruzeiros">Cruzerios</a></li>
          </ul>
        </li>
        <li><a href="https://blog.queensberry.com.br/" target="_blank" rel="noopener">Blog</a></li>
        <li><a href="https://www.queensberryincentivos.com.br/" target="_blank" rel="noopener">Viagens de Incentivo</a></li>
        <li><a href="<?= home_url() ?>/quem-somos/">Quem Somos</a></li>
        <li><a href="<?= home_url() ?>/fale-conosco/">Fale Conosco</a></li>
        <li><a href="https://agentes.queensberry.com.br/seja-um-parceiro/" target="_blank" rel="noopener">Seja um Parceiro</a></li>
      </ul>
      <div class="bottom-wrapper">
        <a href="https://agentes.queensberry.com.br/" target="_blank" class="green-highlight agent-field">
          <svg width="13" class="user-icon" height="14" viewBox="0 0 13 14" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M8.90764 8.09375C10.7865 8.09375 12.3354 9.64258 12.3354 11.5215V12.1562C12.3354 12.8418 11.7768 13.375 11.1166 13.375H2.17913C1.49358 13.375 0.960375 12.8418 0.960375 12.1562V11.5215C0.960375 9.64258 2.48381 8.09375 4.36272 8.09375C5.09905 8.09375 5.42913 8.5 6.64788 8.5C7.84123 8.5 8.17131 8.09375 8.90764 8.09375ZM11.1166 12.1562V11.5215C11.1166 10.3027 10.1264 9.3125 8.90764 9.3125C8.52678 9.3125 7.9428 9.71875 6.64788 9.71875C5.32756 9.71875 4.74358 9.3125 4.36272 9.3125C3.14397 9.3125 2.17913 10.3027 2.17913 11.5215V12.1562H11.1166ZM6.64788 7.6875C4.61663 7.6875 2.99163 6.0625 2.99163 4.03125C2.99163 2.02539 4.61663 0.375 6.64788 0.375C8.65373 0.375 10.3041 2.02539 10.3041 4.03125C10.3041 6.0625 8.65373 7.6875 6.64788 7.6875ZM6.64788 1.59375C5.30217 1.59375 4.21038 2.71094 4.21038 4.03125C4.21038 5.37695 5.30217 6.46875 6.64788 6.46875C7.96819 6.46875 9.08538 5.37695 9.08538 4.03125C9.08538 2.71094 7.96819 1.59375 6.64788 1.59375Z"
              fill="white" />
          </svg>
          Área do Agente
        </a>
      </div>
    </div>
    <input type="checkbox" id="mobile-search-toggle" x-on:change="isMobileSearchOpen = !isMobileSearchOpen" />
    <?php echo do_shortcode('[mobile_header_search]'); ?>
  </nav>
