<?php

// logo que entra no template, antes de qualquer if:
global $wp, $wp_query;
error_log('---------------------------------------------------------');
// error_log( 'matched_rule: '. print_r( $wp->matched_rule, true ) );
// error_log( 'matched_query: '. print_r( $wp->matched_query, true ) );
// error_log( 'query_vars: '. print_r( $wp_query->query_vars, true ) );
error_log( 'is_404: '. (int)$wp_query->is_404 );
error_log( 'is_single: '. (int)is_single() );

$custom_data = $GLOBALS['custom_forfait_data'] ?? null;

// 1️⃣ Detecta URL custom
if ( get_query_var('custom_forfait') ) {
  // 2️⃣ Extrai suas vars
  $type       = get_query_var('type');        // gbm ou forfait
  $continente = get_query_var('continente');
  $codigo     = get_query_var('codigo');
  $slug       = get_query_var('slug');

  // 3️⃣ Carrega os dados de cache
  $all_programs          = require get_template_directory() . '/cached-programs-list.php';
  $categories_list       = require get_template_directory() . '/cached-categories.php';
  $active_programs_info  = require get_template_directory() . '/cached-active-programs-info.php';
  $active_programs_list  = require get_template_directory() . '/cached-active-programs-list.php';
  $countries_list        = require get_template_directory() . '/cached-countries-list.php';
  $world_regions         = require get_template_directory() . '/cached-world-regions.php';

  // 4️⃣ Função de busca
  if ( ! function_exists('array_find') ) {
    function array_find(array $array, callable $cb) {
      foreach($array as $item) {
        if ($cb($item)) return $item;
      }
      return null;
    }
  }

  // 5️⃣ Busca o programa
  $found = array_find($all_programs, function($p) use($codigo) {
    $programCode = trim($p['CodigoPrograma']);
    $searchCode = trim($codigo);

    if (stripos($programCode, $searchCode) !== false) {
        error_log("🟡 Possível match parcial: [$programCode] contém [$searchCode]");
    }

    if (strcasecmp($programCode, $searchCode) === 0) {
        error_log("✅ Match exato (case-insensitive): $programCode === $searchCode");
        return true;
    }

    return false;
  });

  if (isset($found['ProgramInfo'])) {
    $custom_data = $found;
  } else {
    error_log('⚠️ Estrutura do programa é simples, montando estrutura simulada');
    $custom_data = [
        'ProgramInfo' => $found,
        'ProgramAddInfo' => [],
        'CategoryInfo' => [],
        'ProgramLogInfo' => [],
        'ProgramNotes' => [],
        'ImageGalleryFiles' => [],
        'PriceTableImageFiles' => [],
        'RegionInfo' => [],
    ];

    // 🔄 Enriquecimento via API para dados ausentes
$program_code = $found['CodigoPrograma'] ?? null;

if ($program_code) {
  error_log("⚙️ Iniciando enriquecimento via API para código: $program_code");

  $program_additional_info = get_specific_active_program_info($program_code);
  $program_notes = get_program_notes($program_code)['ProgramasNotas']['ProgramasNotas'] ?? [];
  $image_gallery_files = get_program_images_file_names($program_code)['ProgramasImagens']['ProgramaImagens'] ?? [];
  $price_table_image_files = get_program_price_table_image_file_names($program_code)['ProgramasPrecos']['ProgramaPrecos'] ?? [];
  $region_info = get_program_region_data($program_code)['ProgramasCidades']['ProgramasCidades'] ?? [];

  // Reforça as pastas de imagem
  $custom_data['ProgramInfo']['PastaImagensCategoria'] = $program_additional_info['PastaImagensCategoria'] ?? '';
  $custom_data['ProgramInfo']['PastaImagensLog'] = $program_additional_info['PastaImagensLog'] ?? '';

  // Enriquecimento nos campos correspondentes
  $custom_data['ProgramAddInfo'] = [
    'CadernoTitulo' => $program_additional_info['Torre'] ?? $program_additional_info['DescricaoPortal'] ?? '',
  ];
  $custom_data['ProgramNotes'] = $program_notes;
  $custom_data['ImageGalleryFiles'] = $image_gallery_files;
  $custom_data['PriceTableImageFiles'] = $price_table_image_files;
  $custom_data['RegionInfo'] = $region_info;

  // Categoria
  $categoria_codigo = $found['CategoriaCodigo'] ?? '';
  $category_info = array_find($categories_list, function($cat) use ($categoria_codigo) {
    return $cat['CategoriaCodigo'] === $categoria_codigo;
  });

  if ($category_info) {
      error_log('🔍 Categoria encontrada: ' . print_r($category_info, true));
    } else {
      error_log("❌ Nenhuma categoria encontrada com o código: $categoria_codigo");
    }

  $custom_data['CategoryInfo'] = $category_info ?? [];

  // Log Info (pela torre)
  $torre_titulo = $found['Torre'] ?? $found['DescricaoPortal'] ?? '';
  $log_info = array_find($categories_list, function($cat) use ($torre_titulo) {
    return isset($cat['CadernoTitulo']) && $cat['CadernoTitulo'] === $torre_titulo;
  });
  $custom_data['ProgramLogInfo'] = $log_info ? [$log_info] : [];

  error_log("✅ Enriquecimento via API finalizado.");
}

  }

  // 6️⃣ Monta estrutura completa se estiver simples
if (!isset($custom_data['ProgramInfo'])) {
  error_log('⚠️ Estrutura do programa é simples, montando estrutura simulada');

  $program_info = $custom_data;

  // Fallback: tentar buscar dados mais completos nos outros arquivos de cache
  $extra_sources = [
    require get_template_directory() . '/cached-active-programs-info.php',
    require get_template_directory() . '/cached-active-programs-list.php'
  ];

  foreach ($extra_sources as $source) {
    $match = array_find($source, function($item) use ($program_info) {
      return isset($item['CodigoPrograma']) &&
             strcasecmp(trim($item['CodigoPrograma']), trim($program_info['CodigoPrograma'] ?? '')) === 0;
    });

    if ($match) {
      error_log('🧩 Dados adicionais encontrados no fallback!');
      $program_info = array_merge($match, $program_info);
      break;
    }
  }

  // 6.1 Recupera dados adicionais
  $categoria_codigo = $program_info['CategoriaCodigo'] ?? '';
  $torre_titulo     = $program_info['Torre'] ?? $program_info['DescricaoPortal'] ?? '';

  // Busca nas categorias
  $category_info = array_find($categories_list, function($cat) use ($categoria_codigo) {
    return $cat['CategoriaCodigo'] === $categoria_codigo;
  });

  $log_info = array_find($categories_list, function($cat) use ($torre_titulo) {
    return isset($cat['CadernoTitulo']) && $cat['CadernoTitulo'] === $torre_titulo;
  });

  $custom_data = [
    'ProgramInfo'          => $program_info,
    'ProgramAddInfo'       => [ 'CadernoTitulo' => $torre_titulo ],
    'CategoryInfo'         => $category_info ?? [],
    'ProgramLogInfo'       => $log_info ? [ $log_info ] : [],
    'ProgramNotes'         => [],
    'ImageGalleryFiles'    => [],
    'PriceTableImageFiles' => [],
    'RegionInfo'           => [],
  ];
}

  
  // 7️⃣ Simula um post “vazio” para disparar o single.php
  global $post;
  $post = (object) [
    'ID'           => 0,
    'post_title'   => $custom_data['ProgramInfo']['Descricao'] ?? 'Programa Queensberry',
    'post_content' => '',
    'post_type'    => 'custom_forfait',
  ];
  setup_postdata($post);
}

// 8️⃣ Garante que o $custom_data esteja presente para URL dinâmica
if ( get_query_var('custom_forfait') || is_single() ) {
  if (get_query_var('custom_forfait')) {
    if (!$custom_data) {
      wp_redirect(home_url('/404'));
      exit;
    }

    global $post;
    $post = (object) [
      'ID'           => 999999,
      'post_title'   => $custom_data['ProgramInfo']['Descricao'] ?? 'Programa Queensberry',
      'post_content' => '',
      'post_type'    => 'custom_forfait',
    ];
    setup_postdata($post);
  } else {
    $page_id = get_the_ID();
    $custom_data = get_post_meta($page_id, 'custom_data', true);
  }
}



// A partir daqui o restante do template continua exatamente como já estava
// Ou seja, com $custom_data já definido, seja pela URL dinâmica ou post comum

  // Check if the custom data exists
  if (!empty($custom_data)):
  
    if (empty($custom_data['ProgramLogInfo'])) {
    $fallback_log_response = get_program_with_log($program_code, '0');
    error_log('✅ descobrindo get_program_with_log' . print_r(get_program_with_log($program_code), true));
    $log_items = $fallback_log_response['ProgramasCadernos']['ProgramasCadernos'] ?? [];
    error_log('❌ Conteudo do log_items: '. print_r($log_items, true));

    if (!empty($log_items)) {
        error_log('✅ Inserindo log info manual via get_program_with_log');
        $custom_data['ProgramLogInfo'] = $log_items;
    } else {
        error_log('❌ Nenhum log encontrado via get_program_with_log');
    }
}

    // Access the data com fallback defensivo
$program_info = $custom_data['ProgramInfo'] ?? [];

// 🔁 Enriquecimento via API para complementar dados do custom_data
error_log("⚙️ Iniciando enriquecimento via API para código: " . ($program_info['CodigoPrograma'] ?? ''));

$codigo_programa = $program_info['CodigoPrograma'] ?? '';

// Complementa dados adicionais via API
$program_notes = get_program_notes($codigo_programa)['ProgramasNotas']['ProgramasNotas'] ?? [];
$image_gallery_files = get_program_images_file_names($codigo_programa)['Imagens']['Imagens'] ?? [];
$price_table_image_files = get_program_price_table_image_file_names($codigo_programa)['Tabela']['Tabela'] ?? [];
$region_info = get_program_region_data($codigo_programa)['Programas']['Programas'] ?? [];


// Tenta buscar log detalhado via get_program_with_log
$program_log_info_api = get_program_with_log($codigo_programa)['Caderno']['Caderno'] ?? [];

// Se não houver $program_logs_info ainda, insere via API
if (empty($custom_data['ProgramLogInfo']) && !empty($program_log_info_api)) {
  $custom_data['ProgramLogInfo'] = $program_log_info_api;
}

// Substitui os dados de imagem e notas se ainda estiverem vazios
if (empty($custom_data['ImageGalleryFiles']) && !empty($image_gallery_files)) {
  $custom_data['ImageGalleryFiles'] = $image_gallery_files;
}

if (empty($custom_data['PriceTableImageFiles']) && !empty($price_table_image_files)) {
  $custom_data['PriceTableImageFiles'] = $price_table_image_files;
}

if (empty($custom_data['ProgramNotes']) && !empty($program_notes)) {
  $custom_data['ProgramNotes'] = $program_notes;
}

if (empty($custom_data['RegionInfo']) && !empty($region_info)) {
  $custom_data['RegionInfo'] = $region_info;
}

error_log("✅ Enriquecimento via API finalizado.");

$test_log = get_program_with_log('IAF168', '0');
// error_log('🧪 Teste manual via get_program_with_log: ' . print_r($test_log, true));

$additional_program_info = $custom_data['ProgramAddInfo'] ?? [];
$current_category_info = $custom_data['CategoryInfo'] ?? [];
$program_logs_info = $custom_data['ProgramLogInfo'] ?? [];
$program_notes = $custom_data['ProgramNotes'] ?? [];
$image_gallery_files = $custom_data['ImageGalleryFiles'];
$price_table_image_files = $custom_data['PriceTableImageFiles'] ?? [];
$region_info = $custom_data['RegionInfo'] ?? [];
// error_log('🧩 Dados Brutos Price_table: ' . print_r($custom_data, true));

$data = get_program_images_file_names($program_code);

$program_name = $program_info["Descricao"] ?? '';
$log_name = $additional_program_info["CadernoTitulo"] ?? '';
$program_code = $program_info["CodigoPrograma"] ?? '';
$category_code = $program_info["CategoriaCodigo"] ?? '';
$category_name = $current_category_info["CategoriaDescricao"] ?? '';
$program_tower = $program_info["Torre"] ?? '';

// error_log('🧪 Conteúdo completo de $program_logs_info: ' . print_r($program_logs_info, true));

// Buscar o log info mais apropriado
$program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
  $lower_log_name = trim(mb_strtolower($log_name));
  $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"] ?? ''));

  return $lower_log_name === $current_item_name
      && ($program_log_info["CadernoStatus"] ?? '') !== "I"
      && !empty($program_log_info["CadernoPastaImagens"]);
});

$program_log_info = null;

if (!empty($program_logs_info)) {
    foreach ($program_logs_info as $log) {
        if (
            isset($log['CadernoStatus']) &&
            strtoupper($log['CadernoStatus']) === 'A' &&
            !empty($log['CadernoFoto'])
        ) {
            $program_log_info = $log;
            error_log('✅ Log info com status A e imagem encontrado: ' . print_r($program_log_info, true));
            break;
        }
    }

    // Fallback se nenhum log válido for encontrado
    if (!$program_log_info) {
        $program_log_info = $program_logs_info[0]; 
        error_log('⚠️ Fallback para o primeiro log info disponível: ' . print_r($program_log_info, true));
    }
} else {
    error_log('❌ Nenhum log info encontrado.');
}


$quick_description = $program_info["DescricaoResumida"] ?? '';
$days_qtty = $program_info["QtdDiasViagem"] ?? '';
$nights_qtty = $program_info["QtdNoitesViagem"] ?? '';
$visit_details_quick_info = $program_info["Detalhes"] ?? '';
$program_outings_info = $program_info["SaidasPrograma"] ?? '';

$images_folder_prefix_url = "https://img.queensberry.com.br/imagens/";
$category_image_folder = $current_category_info["PastaImagens"];
$program_log_image_folder = $program_log_info["CadernoPastaImagens"] ?? '';

error_log('🖼️ Teste pasta log  ,' . print_r($program_log_image_folder, true));

$url_friendly_program_code = convert_string_to_uppercase_url($program_info["CodigoPrograma"]);
$banner_img_file_name = rawurlencode($program_info["Banner"] ?? '');

// error_log('🖼️ Program Info ,' . print_r($program_info, true));

if (empty($image_gallery_files)) {
    $image_gallery_files = get_program_images_file_names($program_code)["ProgramasImagens"]["ProgramaImagens"] ?? [];
    $custom_data['ImageGalleryFiles'] = $image_gallery_files; // atualiza para reuso
}


// Fallback defensivo para imagem da galeria
$log_img_file_name = $image_gallery_files[0]['Descricao'] ?? '';

if (empty($category_image_folder) || empty($program_log_image_folder)) {
    $category_image_folder = $category_info['PastaImagens'] ?? '';
    $program_log_image_folder = $program_log_info['CadernoPastaImagens'] ?? '';

    // Se ainda estiver vazio, tenta resgatar via lista de categorias
    if (empty($program_log_image_folder)) {
        $log_info_via_torre = array_find($categories_list, function($cat) use ($log_name) {
            return isset($cat['CadernoTitulo']) && $cat['CadernoTitulo'] === $log_name;
        });

        if ($log_info_via_torre && !empty($log_info_via_torre['CadernoPastaImagens'])) {
            $program_log_image_folder = $log_info_via_torre['CadernoPastaImagens'];
            error_log("✅ Pasta do log recuperada via torre nas categorias: $program_log_image_folder");
        } else {
            error_log("❌ Ainda sem pasta do log mesmo após torre nas categorias.");
        }
    }

    error_log("⚠️ Fallback via API: Pasta categoria = $category_image_folder | Pasta log = $program_log_image_folder");
}

if (empty($program_log_image_folder)) {
    $log_api_response = get_program_with_log($program_code);
    $log_data = $log_api_response['Caderno']['Caderno'] ?? [];

    if (!empty($log_data) && isset($log_data['CadernoPastaImagens'])) {
        $program_log_image_folder = $log_data['CadernoPastaImagens'];
        error_log("✅ Pasta do log preenchida via API direta: $program_log_image_folder");
    } else {
        error_log("❌ Pasta do log continua vazia após tentativa direta via API.");
    }
}

// error_log('🖼️ Teste de Imagens ,' . print_r($image_gallery_files, true));
// error_log('🖼️ Teste pasta log  ,' . print_r($program_log_image_folder, true));

$banner_image_url = "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$banner_img_file_name";
$itinerary_image_url = "$images_folder_prefix_url/Programas/$category_image_folder/$program_log_image_folder/$url_friendly_program_code/$log_img_file_name";

error_log("🧩 Montagem imagem:");
error_log("🧩 Pasta categoria: $category_image_folder");
error_log("🧩 Pasta log: $program_log_image_folder");
error_log("🧩 Código programa: $url_friendly_program_code");
error_log("🧩 Banner: $banner_img_file_name");
error_log("🧩 Imagem galeria: $log_img_file_name");
error_log("📸 URL da imagem montada: $banner_image_url");
error_log("🗺️ URL da imagem mapa: $itinerary_image_url");

    
$attraction_description_list = array_filter($program_notes, function($note) {
  return $note["ProgramaDescricao"] == "Atrações" && $note["NotaDescricao"] !== "DESATIVADO";
});
$itinerary_info_list = array_filter($program_notes, function($note) {
  return $note["ProgramaDescricao"] == "Roteiro Dia-a-Dia" && $note["NotaDescricao"] !== "DESATIVADO" && str_contains($note["NotaDescricao"], "DIA");
});
$itinerary_info_list = array_values($itinerary_info_list);
$services_info_list = array_filter($program_notes, function($note) {
  return $note["ProgramaDescricao"] == "Serviços" && $note["NotaDescricao"] !== "DESATIVADO";
});

$attractions_note_contents = [];
$services_note_contents = [];
$itinerary_note_contents = [];

foreach ($attraction_description_list as $attraction_info) {
  $title = $attraction_info['NotaDescricao'];
  $text = $attraction_info['NotaTextoDescricao'];
  $found_key = null;
  foreach ($attractions_note_contents as $key => $post) {
    if ($post['NotaDescricao'] === $title) {
      $found_key = $key;
      break;
    }
  }
  if ($found_key !== null) {
    $attractions_note_contents[$found_key]['NotaTextoDescricao'] .= $text;
  } else {
    $attractions_note_contents[] = [
      'NotaDescricao' => $title,
      'NotaTextoDescricao' => $text
    ];
  }
}

if($program_info["DescricaoPortal"] !== "") {
  $opening_arr = [
    'NotaDescricao' => "Abertura",
    'NotaTextoDescricao' => $program_info["DescricaoPortal"]
  ];
  array_unshift($attractions_note_contents, $opening_arr);
}

foreach ($services_info_list as $service_info) {
  $title = $service_info['NotaDescricao'];
  $text = $service_info['NotaTextoDescricao'];
  $found_key = null;
  foreach ($services_note_contents as $key => $post) {
    if ($post['NotaDescricao'] === $title) {
      $found_key = $key;
      break;
    }
  }
  if ($found_key !== null) {
    $services_note_contents[$found_key]['NotaTextoDescricao'] .= $text;
  } else {
    $services_note_contents[] = [
      'NotaDescricao' => $title,
      'NotaTextoDescricao' => $text
    ];
  }
}

foreach ($itinerary_info_list as $itinerary_info) {
  $title = $itinerary_info['NotaDescricao'];
  $text = $itinerary_info['NotaTextoDescricao'];
  $found_key = null;
  foreach ($itinerary_note_contents as $key => $post) {
    if ($post['NotaDescricao'] === $title) {
      $found_key = $key;
      break;
    }
  }
  if ($found_key !== null) {
    $itinerary_note_contents[$found_key]['NotaTextoDescricao'] .= $text;
  } else {
    $itinerary_note_contents[] = [
      'NotaDescricao' => $title,
      'NotaTextoDescricao' => $text
    ];
  }
}


  if($program_info["DescricaoPortal"] !== "") {
    $opening_arr = [
      'NotaDescricao' => "Abertura",
      'NotaTextoDescricao' => $program_info["DescricaoPortal"]
    ];

    array_unshift($attractions_note_contents, $opening_arr);
  }


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

    foreach ($itinerary_info_list as $itinerary_info) {
        $title = $itinerary_info['NotaDescricao'];
        $text = $itinerary_info['NotaTextoDescricao'];
        
        // Check if this title already exists in $post_contents
        $found_key = null;
        foreach ($itinerary_note_contents as $key => $post) {
            if ($post['NotaDescricao'] === $title) {
                $found_key = $key;
                break;
            }
        }
        
        if ($found_key !== null) {
            // Append the text to the existing entry
            $itinerary_note_contents[$found_key]['NotaTextoDescricao'] .= $text;
        } else {
            // Add a new entry
            $itinerary_note_contents[] = [
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
        <h1 class="titulo-principal"><?= $program_name ?></h1>
        <p class="descricao-principal"><?= $quick_description ?></p>
      </div>
    </header>

    <section class="quick-info">
      <div class="wrapper">
        <div class="info-area">
          <strong>Duração</strong>
          <p class="duracao-conteudo"><?= $days_qtty ?> dias / <?= $nights_qtty ?> noites</p>
        </div>
        <div class="info-area">
          <strong>Visitando</strong>
          <p class="visitando-conteudo"><?= $visit_details_quick_info ?></p>
        </div>
        <div class="info-area">
          <strong>Saídas</strong>
          <p class="saida-conteudo"><?= $program_outings_info ?></p>
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
          <img class="itinerary-image" src="<?php echo $itinerary_image_url; ?>" alt="Imagem Roteiro Viagem">
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
              <?php 
              for($i = 0; $i < count($attractions_note_contents); $i++):
                $attraction_info = $attractions_note_contents[$i]['NotaTextoDescricao'];
                $topic_title = $attractions_note_contents[$i]['NotaDescricao'];
                $attraction_info = str_replace("\n", "<br />", $attraction_info);

                echo <<<ITEM_DESCRIPTION
                <div class="topic">
                  <h2>$topic_title</h2>

                  <p>
                    $attraction_info
                  </p>
                </div>
                ITEM_DESCRIPTION;
              endfor;
              ?>
            </div>
            <div class="tab roteiro" x-show="selectedTab === 'itinerary'">
              <?php 
              for($i = 0; $i < count($itinerary_note_contents); $i++):
                $itinerary_daily_info = $itinerary_note_contents[$i]['NotaTextoDescricao'];
                $topic_title = $itinerary_note_contents[$i]['NotaDescricao'];
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
            <div class="tab services" x-show="selectedTab === 'services'">
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
              <div class="modal-content imagem">
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
            <button @click="isModalOpen = true; modalType = 'form'; formType = 'recomendar'" class="trigger"><i class="fa-regular fa-envelope share"></i></button>
            <button class="trigger"><i class="fa-solid fa-print share"></i></i></button>
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
      <form id="f_queensberry_programa" x-show="formType === 'saber-mais'" name="f_queensberry_programa" method="POST" x-data="{
          isEmailPermissionChecked: false,
        }">
        <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false; modalType = ''; formType = ''"></i>
        <h2>Solicitar informações do programa</h2>

        <input type="hidden" id="actionField" name="action" value="queensberry_verify_recaptcha">

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
        <input type="hidden" name="EMAIL_PERMISSION_STATUS_" x-bind:value="isEmailPermissionChecked ? 'I' : 'O'" id="optIn">
        <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
        <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Programa - Queensberry">
        <input type="hidden" name="URL_CADASTRO" x-bind:value="window.location.href">
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
            <input type="text" placeholder="Telefone()*" @change="fullPhoneNumberA = '55' + phoneNumberA" x-model="phoneNumberA" required maxlength="14" id="MOBILE_NUMBER_" name="MOBILE_NUMBER_" id="celular1">
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
              <input type="checkbox" @change="isEmailPermissionChecked = !isEmailPermissionChecked" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
              <label for="RECEBER_COMUNICACOES" class="checkmark"></label>
            </span>
            <label for="RECEBER_COMUNICACOES" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
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
          $(document).ready(() => {
             var formData = new FormData(jQuery("#f_queensberry_programa")[0]);

              $("#celular1").mask("(00) 00000-0000");

              $("#f_queensberry_programa").on("submit", (e) => {
                e.preventDefault();

                var formData = new FormData($("#f_queensberry_programa")[0]);


                grecaptcha.ready(function() {
                  grecaptcha.execute('6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y', {action: 'submit'}).then(function(token) {
                    console.log(token);
                    jQuery.post(
                      "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha",
                      {
                        "g-recaptcha-response": token
                      }
                    ).done((res) => {
                      if(res.data.message === "OK") {
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
                                    console.log(data);
                                }
                            ).done(() => {
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
                                alert("Envio realizado com sucesso");
                            });
                        }                  
                      } else {
                        console.log("Recaptcha error")
                      }
                    })
                  });
                });



                 

                  
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
          // _elqQ = _elqQ || [];
          // _elqQ.push(['elqGetCustomerGUID']);
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


      <form id="f_queensberry_recomendar_programa" name="f_queensberry_recomendar_programa" method="POST" x-show="isModalOpen && modalType === 'form' && formType === 'recomendar'" x-data="{
          isEmailPermissionChecked: false,
        }">
          <input type="hidden" id="actionField2" name="action" value="queensberry_verify_recaptcha">
          <i class="fa-solid fa-xmark close-icon" @click="isModalOpen = false; modalType = ''; formType = ''"></i>
          <h2>Recomendar Programa</h2>

          <!-- Responsys -->
          <input type="hidden" name="_ri_"
              value="X0Gzc2X%3DAQjkPkSRWQGvd46H8AazcAfgLBPKA19XWHehXFudc5VwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQGzeCj2E6OlFDyIUPtO6kwzd9AoaTLlUYs">
          <input type="hidden" name="_ei_" value="ET7obVahR1vnJMcvllB-uxg">
          <input type="hidden" name="_di_" value="il13bar20jj92v93jquln3o9t91ml5b13dqjrnk5jso1031f734g">
          <input type="hidden" name="EMAIL_PERMISSION_STATUS_" x-bind:value="isEmailPermissionChecked ? 'I' : 'O'" id="optIn">
          <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Recomendar Programa - Queensberry">
          <input type="hidden" id="URL_CADASTRO" x-bind:value="window.location.href" name="URL_CADASTRO">

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
                <input type="checkbox" @change="isEmailPermissionChecked = !isEmailPermissionChecked" value="Sim" name="RECEBER_COMUNICACOES" id="checkReceberComunicacoes">
                <label for="checkReceberComunicacoes" class="checkmark"></label>
              </span>
              <label for="checkReceberComunicacoes" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
            </div>
            <button class="submit-btn" type="submit">Enviar</button>
          </div>
      </form>

      <script>

      $(document).ready(() => {

        $("#f_queensberry_recomendar_programa").on("submit", (e) => {
          e.preventDefault();

          grecaptcha.ready(function() {
            grecaptcha.execute('6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y', {action: 'submit'}).then(function(token) {
              console.log(token);
              jQuery.post(
                "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha",
                {
                  "g-recaptcha-response": token
                }
              ).done((res) => {
                if(res.data.message === "OK") {
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
                } else {
                  console.log("Recaptcha error")
                }
              })
            })
          })
        })
      })
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
          // _elqQ = _elqQ || [];
          // _elqQ.push(['elqGetCustomerGUID']);
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

    <script>

      /*Código de controle do gerador do PDF*/

      document.addEventListener("DOMContentLoaded", function () {
      const icon = document.querySelector(".fa-solid.fa-print");
      if (!icon) return;

      icon.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      const pageHeight = doc.internal.pageSize.height;
      const margin = 10;
      let y = 20;

      function checkPageSpace(lines, lineHeight = 6) {
      const requiredSpace = lines.length * lineHeight;
      if (y + requiredSpace > pageHeight - margin) {
        doc.addPage();
        y = margin;
      }
      }

      const dataHora = new Date().toLocaleString();
      const titulo = document.querySelector(".titulo-principal")?.innerText || '';
      const descricao = document.querySelector(".descricao-principal")?.innerText || '';
      const categoria = document.querySelector(".categoria")?.innerText || '';
      const visitando = document.querySelector(".visitando-conteudo")?.innerText || '';
      const saida = document.querySelector(".saida-conteudo")?.innerText || '';
      const duracao = document.querySelector(".duracao-conteudo")?.innerText || '';

      doc.setFontSize(10);
      doc.text(`Gerado em: ${dataHora}`, margin, 10);

      doc.setFont(undefined, "bold");
      doc.setFontSize(16);
      doc.text(titulo, margin, y);

      y += 8;
      doc.setFont(undefined, "normal");
      doc.setFontSize(11);
      let desc = doc.splitTextToSize(descricao, 180);
      checkPageSpace(desc);
      doc.text(desc, margin, y);
      y += desc.length * 6;

      const blocos = [
      { label: "CATEGORIA", text: categoria },
      { label: "VISITANDO", text: visitando },
      { label: "SAÍDA", text: saida },
      { label: "DURAÇÃO", text: duracao }
      ];

      blocos.forEach(({ label, text }) => {
      y += 10;
      doc.setFont(undefined, "bold");
      doc.setFontSize(12);
      doc.text(label, margin, y);
      y += 6;

      doc.setFont(undefined, "normal");
      doc.setFontSize(11);
      const lines = doc.splitTextToSize(text, 180);
      checkPageSpace(lines);
      doc.text(lines, margin, y);
      y += lines.length * 6;
      });

      // Atrações
      const atracoesContainer = document.querySelector('.topic');
      if (atracoesContainer) {
      const h2 = atracoesContainer.querySelector('h2')?.innerText.toUpperCase() || '';
      const paragrafos = atracoesContainer.querySelectorAll('p');

      y += 10;
      doc.setFont(undefined, "bold");
      doc.setFontSize(12);
      doc.text(h2, margin, y);
      y += 6;

      doc.setFont(undefined, "normal");
      doc.setFontSize(11);
      let atracoes = '';
      paragrafos.forEach(p => {
        atracoes += p.innerText + '\n\n';
      });
      const linhas = doc.splitTextToSize(atracoes.trim(), 180);
      checkPageSpace(linhas);
      doc.text(linhas, margin, y);
      y += linhas.length * 6;
      }

      // Serviços
      const servicosTab = document.querySelector('.tab.services');
      if (servicosTab) {
      const blocosServicos = servicosTab.querySelectorAll('.topic');

      blocosServicos.forEach(bloco => {
        const tituloServico = bloco.querySelector('h2')?.innerText.toUpperCase() || '';
        const textoServico = bloco.querySelector('p')?.innerText || '';

        y += 10;
        doc.setFont(undefined, "bold");
        doc.setFontSize(12);
        doc.text(tituloServico, margin, y);
        y += 6;

        doc.setFont(undefined, "normal");
        doc.setFontSize(11);
        const linhasTexto = doc.splitTextToSize(textoServico.trim(), 180);
        checkPageSpace(linhasTexto);
        doc.text(linhasTexto, margin, y);
        y += linhasTexto.length * 6;
      });
      }

      // Roteiro
      const roteiroTab = document.querySelector('.tab.roteiro');
      if (roteiroTab) {
      const blocosRoteiro = roteiroTab.querySelectorAll('.topic');

      y += 10;
      doc.setFont(undefined, "bold");
      doc.setFontSize(12);
      doc.setTextColor(85, 107, 47); // verde oliva
      doc.text("ROTEIRO DIA-A-DIA", margin, y);
      y += 6;
      doc.setTextColor(0, 0, 0); // reset cor para preto

      blocosRoteiro.forEach(bloco => {
        const tituloRoteiro = bloco.querySelector('h2')?.innerText || '';
        const textoRoteiro = bloco.querySelector('p')?.innerText || '';

        y += 10;
        doc.setFont(undefined, "bold");
        doc.setFontSize(12);
        doc.text(tituloRoteiro, margin, y);
        y += 6;

        doc.setFont(undefined, "normal");
        doc.setFontSize(11);
        const linhasTexto = doc.splitTextToSize(textoRoteiro.trim(), 180);
        checkPageSpace(linhasTexto);
        doc.text(linhasTexto, margin, y);
        y += linhasTexto.length * 6;
      });
      }

      const nomeArquivo = titulo.replace(/[^a-z0-9]/gi, '_').toLowerCase();

      // Tabelas de preço (imagens)
      const imagemContainer = document.querySelector('.modal-content.imagem');
      if (imagemContainer) {
      const imagens = imagemContainer.querySelectorAll('img');

      (async () => {
        for (const img of imagens) {
          await new Promise(resolve => {
            const image = new Image();
            image.crossOrigin = 'anonymous';

            image.onload = function () {
              const ratio = image.width / image.height;
              const targetWidth = 180;
              const targetHeight = targetWidth / ratio;

              if (y + targetHeight > pageHeight - margin) {
                doc.addPage();
                y = margin;
              }

              const canvas = document.createElement('canvas');
              canvas.width = image.width;
              canvas.height = image.height;
              const ctx = canvas.getContext('2d');
              ctx.drawImage(image, 0, 0);
              const imgData = canvas.toDataURL('image/jpeg');

              doc.addImage(imgData, 'JPEG', margin, y, targetWidth, targetHeight);
              y += targetHeight + 5;
              resolve();
            };

            image.src = img.src;
          });
        }

        
      const totalPages = doc.internal.getNumberOfPages();

      for (let i = 1; i <= totalPages; i++) {
      doc.setPage(i);
      doc.setFontSize(10);
      doc.setTextColor(150);
      doc.text(`Página ${i} de ${totalPages}`, 200, pageHeight - 10, { align: "right" });
      }

      let finalY = y + 20;
      if (finalY + 40 > pageHeight - margin) {
      doc.addPage();
      finalY = 40;
      }

      doc.setFont(undefined, "normal");
      doc.setFontSize(11);
      doc.setTextColor(0, 0, 0);
      doc.text("Veja este e outros roteiros no nosso site:", 105, finalY, { align: "center" });
      finalY += 6;

      doc.setTextColor(0, 0, 255);
      doc.textWithLink("www.queensberry.com.br", 105, finalY, { url: "https://www.queensberry.com.br", align: "center" });
      doc.setTextColor(0, 0, 0);
      finalY += 6;

      doc.text("Veja a versão ONLINE do folheto impresso:", 105, finalY, { align: "center" });
      finalY += 6;
      doc.text("Folhetos", 105, finalY, { align: "center" });
      finalY += 6;
      doc.text("Condições Gerais para Viagens Internacionais", 105, finalY, { align: "center" });
      finalY += 10;

      doc.setFont(undefined, "bold");
      doc.text("ATENÇÃO - Preços Sujeitos a Disponibilidade e Alteração Sem Aviso Prévio", 105, finalY, { align: "center" });

      doc.save(`${nomeArquivo}.pdf`);

      })();

      return;
      }


      const totalPages = doc.internal.getNumberOfPages();

      for (let i = 1; i <= totalPages; i++) {
      doc.setPage(i);
      doc.setFontSize(10);
      doc.setTextColor(150);
      doc.text(`Página ${i} de ${totalPages}`, 200, pageHeight - 10, { align: "right" });
      }

      let finalY = y + 20;
      if (finalY + 40 > pageHeight - margin) {
      doc.addPage();
      finalY = 40;
      }

      doc.setFont(undefined, "normal");
      doc.setFontSize(11);
      doc.setTextColor(0, 0, 0);
      doc.text("Veja este e outros roteiros no nosso site:", 105, finalY, { align: "center" });
      finalY += 6;

      doc.setTextColor(0, 0, 255);
      doc.textWithLink("www.queensberry.com.br", 105, finalY, { url: "https://www.queensberry.com.br", align: "center" });
      doc.setTextColor(0, 0, 0);
      finalY += 6;

      doc.text("Veja a versão ONLINE do folheto impresso:", 105, finalY, { align: "center" });
      finalY += 6;
      doc.text("Folhetos", 105, finalY, { align: "center" });
      finalY += 6;
      doc.text("Condições Gerais para Viagens Internacionais", 105, finalY, { align: "center" });
      finalY += 10;

      doc.setFont(undefined, "bold");
      doc.text("ATENÇÃO - Preços Sujeitos a Disponibilidade e Alteração Sem Aviso Prévio", 105, finalY, { align: "center" });

      doc.save(`${nomeArquivo}.pdf`);


      });
      });


    </script>
  </main>

<?php
    get_footer();
  else:
  status_header(404); // Isso garante que se cair aqui, a header seja 404
  nocache_headers();
  include( get_query_template( '404' ) );
  exit;
  endif;
?>

<style>
.share:hover{
  color: #99D02C;
}
</style>
