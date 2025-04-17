<?php

if (!function_exists('array_find')) {
    /**
     * Finds the first element in an array that satisfies a given condition.
     *
     * @param array $array The input array.
     * @param callable $callback The callback function to apply to each element.
     * @return mixed|null The first element that satisfies the condition, or null if none is found.
     */
    function array_find(array $array, callable $callback) {
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
        return null;
    }
}

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string) {
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }
}

if (!function_exists('mb_strcasecmp') && function_exists('mb_strtolower')) {
    function mb_strcasecmp($str1, $str2, $encoding = 'UTF-8') {
        return strcmp(
            mb_strtolower($str1, $encoding),
            mb_strtolower($str2, $encoding)
        );
    }
}

function capitalize_pt_br_string($str) {
    $lowercase_str = mb_strtolower($str);
    $words = explode(" ", $lowercase_str);
    
    $exceptions = array("no", "na", "da", "do", "de");
    
    $capitalized_words = array_map(function($word) use ($exceptions) {
        if (!in_array($word, $exceptions)) {
            if (strlen($word) > 0) {
                return mb_ucfirst($word);
            }
        }
        return $word;
    }, $words);
    
    return implode(" ", $capitalized_words);
}

require_once "form-handler.php";

function convert_string_to_uppercase_url($string) {
    // Convert the string to uppercase
    $string = mb_strtoupper($string);
    
    // Replace spaces with underscores
    $string = str_replace(' ', '_', $string);
    
    // Remove all special characters and keep only alphanumeric and underscores
    $string = preg_replace('/[^A-Z0-9_]/', '', $string);
    
    // Remove multiple consecutive underscores
    $string = preg_replace('/_+/', '_', $string);
    
    // Trim underscores from the beginning and end
    $string = trim($string, '_');
    
    return $string;
}

function convert_string_to_lowercase_slug($string) {
    // Convert the string to uppercase
    $string = mb_strtolower($string);
    
    // Replace spaces with underscores
    $string = str_replace(' ', '_', $string);
    
    // Remove all special characters and keep only alphanumeric and underscores
    $string = preg_replace('/[^A-Z0-9_]/', '', $string);
    
    // Remove multiple consecutive underscores
    $string = preg_replace('/_+/', '_', $string);
    
    // Trim underscores from the beginning and end
    $string = trim($string, '_');
    
    return $string;
}

function qb_assets_queue()
{
    /* wp_enqueue_style('qb-fonts', get_template_directory_uri() . "/src/css/fonts.css", [], '1.0.0', 'all'); */
    wp_enqueue_style('qb-root', get_template_directory_uri() . "/src/css/root.css", [], '1.0.0', 'all');
    /* wp_enqueue_style('qb-fonts', "https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto:wght@400;500;600;700;800&family=Tenor+Sans&display=swap", [], '1.0.0', 'all'); */
    /* wp_enqueue_style('qb-fonts', "https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Roboto:wght@100..900&family=Tenor+Sans&display=swap", [], '1.0.0', 'all'); */
    wp_enqueue_style('qb-fa', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css", [], '6.0.0', 'all');
    wp_enqueue_style('qb-navigation', get_template_directory_uri() . "/src/css/main_navigation.css", ['qb-root', 'qb-fa'], '1.0.0', 'all');
    wp_enqueue_style('qb-home-page', get_template_directory_uri() . "/src/css/home-page.css", ['qb-root', 'qb-navigation', 'qb-fa'], "1.0.0", "all");
    wp_enqueue_style('qb-swiper', get_template_directory_uri() . "/src/css/swiper-bundle.css", ['qb-navigation', 'qb-root'], "1.0.0", "all");
    wp_enqueue_style('qb-search', get_template_directory_uri() . "/src/css/search-page.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");

    if(is_category()) {
        wp_enqueue_style('qb-products-page', get_template_directory_uri() . "/src/css/products-page.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_single()) {
        wp_enqueue_style('qb-program-page', get_template_directory_uri() . "/src/css/program-page.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('quem-somos')) {
        wp_enqueue_style('qb-about-us', get_template_directory_uri() . "/src/css/group-identity.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('folhetos-e-cadernos')) {
        wp_enqueue_style('qb-flyers-page', get_template_directory_uri() . "/src/css/flyers-and-logs.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('queensclub')) {
        wp_enqueue_style('qb-about-us', get_template_directory_uri() . "/src/css/queensclub.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('trabalhe-conosco')) {
        wp_enqueue_style('qb-join-us', get_template_directory_uri() . "/src/css/join-us.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('fale-conosco')) {
        wp_enqueue_style('qb-contact-us', get_template_directory_uri() . "/src/css/contact-us.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('queensclub-cadastro')) {
        wp_enqueue_style('qb-quennsclub-register', get_template_directory_uri() . "/src/css/queensclub-register.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('formularios')) {
        wp_enqueue_style('qb-download-forms', get_template_directory_uri() . "/src/css/download-forms.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('termos-e-condicoes')) {
        wp_enqueue_style('qb-termos', get_template_directory_uri() . "/src/css/terms-conditions.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_page('politica-de-privacidade')) {
        wp_enqueue_style('qb-politica-privacidade', get_template_directory_uri() . "/src/css/privacy-policy.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }

    if(is_tag()) {
        wp_enqueue_style('qb-tag-styles', get_template_directory_uri() . "/src/css/tag-page.css", ['qb-navigation', 'qb-root', 'qb-fa'], "1.0.0", "all");
    }
    
    /* if(is_search()) {
        wp_enqueue_style('qb-search', get_template_directory_uri() . "/src/css/search-page.css", ['qb-navigation', 'qb-root', 'qb-fa', 'qb-fonts'], "1.0.0", "all");
    } */


    wp_enqueue_script('qb-alpine-intersect', "https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js", [], '1.0.0', ["in_footer" => false, "strategy" => "defer"]);
    wp_enqueue_script('qb-axios', "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js", [], '1.0.0', ["in_footer" => false]);
    wp_enqueue_script('qb-alpine-scripts', "https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js", [], '1.0.0', ["in_footer" => false, "strategy" => "defer"]);
    /* wp_enqueue_script('qb-scripts', get_template_directory_uri() . "/src/js/scripts.js", [], '1.0.0', ["in_footer" => true, "strategy" => "defer"]); */
    wp_enqueue_script('qb-swiper-bundle', "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js", [], '1.0.0', ["in_footer" => false]);
    /* wp_enqueue_script('qb-recaptcha', "https://www.google.com/recaptcha/api.js", [], '1.0.0', ["in_footer" => false, "strategy" => "defer"]); */
    /* wp_enqueue_script('qb-axios', "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js", [], '1.0.0', ["in_footer" => false]); */
    /* wp_enqueue_script('qb-swiper-scripts', get_template_directory_uri() . "/src/js/swiper-config.js", ['qb-swiper-bundle'], '1.0.0', ["in_footer" => false, "strategy" => "defer"]); */

    // https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js
}

function desktop_header_search() {
    ob_start();
    ?>
    <form role="search" action="<?php echo esc_url(home_url('/')); ?>" mathod="get" class="search-field">
        <input type="search" x-on:blur="isNavSelected = false" x-on:focus="isNavSelected = true"
        placeholder="BUSCA" value="<?php echo get_search_query(); ?>" name="s" /><button type="submit" class="search-btn" x-on:focus="isNavSelected = true"
        x-on:blur="isNavSelected = false">
        <i class="fa-solid fa-magnifying-glass btn-ico"></i>
        </button>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('desktop_header_search', 'desktop_header_search');

function mobile_header_search() {
    ob_start();
    ?>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mobile-global-search">
      <div class="wrapper">
        <input type="search" value="<?php echo get_search_query(); ?>" placeholder="Busca" x-on:click="isMobileSearchOpen = !isMobileSearchOpen"
          name="s" />
        <button type="submit">OK</button>
      </div>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode('mobile_header_search', 'mobile_header_search');

function qb_setup()
{
    add_theme_support('menus');
    register_nav_menu("primary", "Header Navigation Menu");

    add_theme_support('post-thumbnails');
    add_theme_support('html5', array("search-form"));
}

function qb_post_formats_support()
{
    add_theme_support('post-formats', ['aside', 'image', 'video', 'link', 'gallery']);
}

function qb_numeric_posts_nav()
{

    if (is_singular())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="qb-page-navigation"><ul>' . "\n";

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

        if (!in_array(2, $links))
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    echo '</ul></div>' . "\n";

}

function qb_numeric_archive_posts_nav()
{
    if (is_singular() || is_front_page())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="qb-page-navigation"><ul>' . "\n";

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

        if (!in_array(2, $links))
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    echo '</ul></div>' . "\n";
}

add_action("wp_enqueue_scripts", "qb_assets_queue");
add_action("after_setup_theme", "qb_setup");

function get_active_programs_list() {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasAtivos";

    $program_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_programs_request = curl_init();

    curl_setopt($curl_programs_request, CURLOPT_URL, $url);
    curl_setopt($curl_programs_request, CURLOPT_POST, true);
    curl_setopt($curl_programs_request, CURLOPT_POSTFIELDS, json_encode($program_req_payload));
    curl_setopt($curl_programs_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_programs_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_programs_request);
    $response = json_decode($response_json, true);

    curl_close($curl_programs_request);

    return $response;
}

function get_overall_program_info($program_code = "", $pagination_start = "1", $pagination_end = "200") {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramas";

    $program_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "ProgramaCodigo" => $program_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_programs_request = curl_init();

    curl_setopt($curl_programs_request, CURLOPT_URL, $url);
    curl_setopt($curl_programs_request, CURLOPT_POST, true);
    curl_setopt($curl_programs_request, CURLOPT_POSTFIELDS, json_encode($program_req_payload));
    curl_setopt($curl_programs_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_programs_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_programs_request);
    $response = json_decode($response_json, true);

    curl_close($curl_programs_request);

    return $response;
}

function get_specific_category_info($category_code = "") {
    $pagination_start = "1";
    $pagination_end = "200";
    $url = "https://gx.befly.com.br/bsi/rest/wsCategorias";

    $category_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "&CategoriaCodigo" => $category_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_category_request = curl_init();

    curl_setopt($curl_category_request, CURLOPT_URL, $url);
    curl_setopt($curl_category_request, CURLOPT_POST, true);
    curl_setopt($curl_category_request, CURLOPT_POSTFIELDS, json_encode($category_req_payload));
    curl_setopt($curl_category_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_category_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_category_request);
    $response = json_decode($response_json, true);

    curl_close($curl_category_request);

    // return $category_req_payload;

    return $response;
}

function get_program_images_file_names($program_code = "") {
    $pagination_start = 1;
    $pagination_end = 200;
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasImagens";

    $images_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "ProgramaCodigo" => $program_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_images_request = curl_init();

    curl_setopt($curl_images_request, CURLOPT_URL, $url);
    curl_setopt($curl_images_request, CURLOPT_POST, true);
    curl_setopt($curl_images_request, CURLOPT_POSTFIELDS, json_encode($images_req_payload));
    curl_setopt($curl_images_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_images_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_images_request);
    $response = json_decode($response_json, true);

    curl_close($curl_images_request);

    return $response;

    // return $images_req_payload;
}

function get_program_price_table_image_file_names($program_code = "") {
    $pagination_start = 1;
    $pagination_end = 200;
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasPrecos";

    $table_images_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "ProgramaCodigo" => $program_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_table_images_request = curl_init();

    curl_setopt($curl_table_images_request, CURLOPT_URL, $url);
    curl_setopt($curl_table_images_request, CURLOPT_POST, true);
    curl_setopt($curl_table_images_request, CURLOPT_POSTFIELDS, json_encode($table_images_req_payload));
    curl_setopt($curl_table_images_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_table_images_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_table_images_request);
    $response = json_decode($response_json, true);

    curl_close($curl_table_images_request);

    // return $table_images_req_payload;

    return $response;
}

function get_program_notes($program_code = "") {
    $pagination_start = "1";
    $pagination_end = "200";
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasNotas";

    $notes_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "ProgramaCodigo" => $program_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_notes_request = curl_init();

    curl_setopt($curl_notes_request, CURLOPT_URL, $url);
    curl_setopt($curl_notes_request, CURLOPT_POST, true);
    curl_setopt($curl_notes_request, CURLOPT_POSTFIELDS, json_encode($notes_req_payload));
    curl_setopt($curl_notes_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_notes_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_notes_request);
    $response = json_decode($response_json, true);

    curl_close($curl_notes_request);

    return $response;

    // return $notes_req_payload;
}

function get_program_with_log($program_code = "", $log_code = "0") {
    $pagination_start = "1";
    $pagination_end = "200";
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasCaderno";

    $logs_info_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
        "ProgramaCodigo" => $program_code,
        "CadernoCodigo" => $log_code,
        "RegistroInicial" => $pagination_start,
        "RegistroFinal" => $pagination_end
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_logs_info_request = curl_init();

    curl_setopt($curl_logs_info_request, CURLOPT_URL, $url);
    curl_setopt($curl_logs_info_request, CURLOPT_POST, true);
    curl_setopt($curl_logs_info_request, CURLOPT_POSTFIELDS, json_encode($logs_info_req_payload));
    curl_setopt($curl_logs_info_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_logs_info_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_logs_info_request);
    $response = json_decode($response_json, true);

    curl_close($curl_logs_info_request);

    return $response;
    // return $logs_info_req_payload;
}

function get_featured_videos_array() {
    $url = "https://gx.befly.com.br/bsi/rest/wsVideos";

    $featured_videos_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_featured_videos_request = curl_init();

    curl_setopt($curl_featured_videos_request, CURLOPT_URL, $url);
    curl_setopt($curl_featured_videos_request, CURLOPT_POST, true);
    curl_setopt($curl_featured_videos_request, CURLOPT_POSTFIELDS, json_encode($featured_videos_req_payload));
    curl_setopt($curl_featured_videos_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_featured_videos_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_featured_videos_request);
    $response = json_decode($response_json, true);

    curl_close($curl_featured_videos_request);

    return $response["Videos"]; 
}

function get_form_files_array() {
    $url = "https://gx.befly.com.br/bsi/rest/wsFormularios";

    $forms_files = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_forms_files_data = curl_init();

    curl_setopt($curl_forms_files_data, CURLOPT_URL, $url);
    curl_setopt($curl_forms_files_data, CURLOPT_POST, true);
    curl_setopt($curl_forms_files_data, CURLOPT_POSTFIELDS, json_encode($forms_files));
    curl_setopt($curl_forms_files_data, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_forms_files_data, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_forms_files_data);
    $response = json_decode($response_json, true);

    curl_close($curl_forms_files_data);

    return $response["Formularios"]["Formularios"]; 
}

function get_flyers_array() {
    $url = "https://gx.befly.com.br/bsi/rest/wsFolhetos";

    $flyers_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_flyers_req = curl_init();

    curl_setopt($curl_flyers_req, CURLOPT_URL, $url);
    curl_setopt($curl_flyers_req, CURLOPT_POST, true);
    curl_setopt($curl_flyers_req, CURLOPT_POSTFIELDS, json_encode($flyers_req_payload));
    curl_setopt($curl_flyers_req, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_flyers_req, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_flyers_req);
    $response = json_decode($response_json, true);

    curl_close($curl_flyers_req);

    return $response["Folhetos"]["Folhetos"]; 
}

function get_dolar_currency_conversion() {
    $url = "https://gx.befly.com.br/bsi/rest/wsCambio";
    $today = date("Y-m-d");

    $currency_conversion_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698",
		"Moeda" => "US$",
		"DataInicial" => $today,
		"DataFinal" => $today
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_currency_conversion_request = curl_init();

    curl_setopt($curl_currency_conversion_request, CURLOPT_URL, $url);
    curl_setopt($curl_currency_conversion_request, CURLOPT_POST, true);
    curl_setopt($curl_currency_conversion_request, CURLOPT_POSTFIELDS, json_encode($currency_conversion_req_payload));
    curl_setopt($curl_currency_conversion_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_currency_conversion_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_currency_conversion_request);
    $response = json_decode($response_json, true);

    curl_close($curl_currency_conversion_request);

    return $response["sdtCambio"]["SdtCambio"][0]; 
}

function get_euro_currency_conversion() {
    $url = "https://gx.befly.com.br/bsi/rest/wsCambio";
    $today = date("Y-m-d");

    $currency_conversion_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698",
		"Moeda" => "euro",
		"DataInicial" => $today,
		"DataFinal" => $today
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_currency_conversion_request = curl_init();

    curl_setopt($curl_currency_conversion_request, CURLOPT_URL, $url);
    curl_setopt($curl_currency_conversion_request, CURLOPT_POST, true);
    curl_setopt($curl_currency_conversion_request, CURLOPT_POSTFIELDS, json_encode($currency_conversion_req_payload));
    curl_setopt($curl_currency_conversion_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_currency_conversion_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_currency_conversion_request);
    $response = json_decode($response_json, true);

    curl_close($curl_currency_conversion_request);

    return $response["sdtCambio"]["SdtCambio"][0]; 
}

function get_world_regions() {
    $url = "https://gx.befly.com.br/bsi/rest/wsRegiaoMundial";

    $world_regions_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698",
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_world_regions_request = curl_init();

    curl_setopt($curl_world_regions_request, CURLOPT_URL, $url);
    curl_setopt($curl_world_regions_request, CURLOPT_POST, true);
    curl_setopt($curl_world_regions_request, CURLOPT_POSTFIELDS, json_encode($world_regions_req_payload));
    curl_setopt($curl_world_regions_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_world_regions_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_world_regions_request);
    $response = json_decode($response_json, true);

    curl_close($curl_world_regions_request);

    return $response;
}

function get_program_region_data($program_code) {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasCidades";

    $program_regions_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698",
        "ProgramaCodigo" => $program_code,
        "RegistroInicial" => "1",
        "RegistroFinal" => "200"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];
    
    $curl_program_regions_request = curl_init();

    curl_setopt($curl_program_regions_request, CURLOPT_URL, $url);
    curl_setopt($curl_program_regions_request, CURLOPT_POST, true);
    curl_setopt($curl_program_regions_request, CURLOPT_POSTFIELDS, json_encode($program_regions_req_payload));
    curl_setopt($curl_program_regions_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_program_regions_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_program_regions_request);
    $response = json_decode($response_json, true);

    curl_close($curl_program_regions_request);

    return $response;
}

function get_all_programs() {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramas";
    $pagination_start = 1;
    $pagination_end = 200;
    $found_programs_qtty = "200";
    $programs = [];

    while($found_programs_qtty == "200") {
        $program_req_payload = [
            "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
            "ProgramaCodigo" => "",
            "RegistroInicial" => $pagination_start,
            "RegistroFinal" => $pagination_end
        ];
    
        $req_headers = [
            "Content-Type: application/json"
        ];
        
        $curl_programs_request = curl_init();
    
        curl_setopt($curl_programs_request, CURLOPT_URL, $url);
        curl_setopt($curl_programs_request, CURLOPT_POST, true);
        curl_setopt($curl_programs_request, CURLOPT_POSTFIELDS, json_encode($program_req_payload));
        curl_setopt($curl_programs_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_programs_request, CURLOPT_HTTPHEADER, $req_headers);
    
        $response_json = curl_exec($curl_programs_request);
        $program_response = json_decode($response_json, true);
    
        curl_close($curl_programs_request);

        $program_list = $program_response["Programas"]["Programas"];
        $pagination_start += 200;
        $pagination_end += 200;
        $found_programs_qtty = $program_response["Programas"]["Paginacao"]["TotalRegistro"];

        foreach($program_list as $program) {
            
            $programs[] = $program;
        }
    }

    return $programs;
}

function get_all_logs() {
    $url = "https://gx.befly.com.br/bsi/rest/wsCaderno";
    $pagination_start = 1;
    $pagination_end = 200;
    $found_logs_qtty = "200";
    $logs = [];

    while($found_logs_qtty == "200") {
        $logs_req_payload = [
            "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698", 
            "CadernoCodigoInicial" => "1",
            "CadernoCodigoFinal" => "1000",
            "RegistroInicial" => $pagination_start,
            "RegistroFinal" => $pagination_end
        ];
    
        $req_headers = [
            "Content-Type: application/json"
        ];
        
        $curl_logs_request = curl_init();
    
        curl_setopt($curl_logs_request, CURLOPT_URL, $url);
        curl_setopt($curl_logs_request, CURLOPT_POST, true);
        curl_setopt($curl_logs_request, CURLOPT_POSTFIELDS, json_encode($logs_req_payload));
        curl_setopt($curl_logs_request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_logs_request, CURLOPT_HTTPHEADER, $req_headers);
    
        $response_json = curl_exec($curl_logs_request);
        $logs_response = json_decode($response_json, true);
    
        curl_close($curl_logs_request);

        $log_list = $logs_response["Caderno"]["Caderno"];
        $pagination_start += 200;
        $pagination_end += 200;
        $found_logs_qtty = $logs_response["Caderno"]["Paginacao"]["TotalRegistro"];

        foreach($log_list as $log_info) {
            
            $logs[] = $log_info;
        }
    }

    return $logs;
}

function get_active_programs_info() {
    $all_programs_info_list = require 'cached-programs-list.php';
    $active_programs_list = require 'cached-active-programs-list.php';
    $active_programs_info_list = [];

    $code_lookup = array_flip(array_column($active_programs_list, 'ProgramaCodigo'));

    foreach($all_programs_info_list as $program_info) {
        if(isset($code_lookup[$program_info["CodigoPrograma"]])) {
            $active_programs_info_list[] = $program_info;
        }
    }

    return $active_programs_info_list;
}

function get_specific_active_program_info($program_code) {
    $programs =  require 'cached-active-programs-list.php';
    $program_info_in_active_programs_table = array_find($programs, function($program) use ($program_code) {
        return $program["ProgramaCodigo"] == $program_code;
    });

    return $program_info_in_active_programs_table;
}

function create_posts_from_api_data_batches() {
    ob_start();
    $programs = require_once "cached-active-programs-info.php";
    $world_regions = require_once "cached-world-regions.php";

    if (empty($programs)) {
        return;
    }

    $programs_batches = array_chunk($programs, 50);

    foreach ($programs_batches as $program_batch) {
        foreach($program_batch as $program) {
            $category_code = $program["CategoriaCodigo"];
            $program_code = $program["CodigoPrograma"];
            $program_countries = [];
            $program_world_regions = [];
            
            $categories_info = require 'cached-categories.php';
            $category_info = array_find($categories_info, function($category_info) use ($category_code) {
                return $category_info["CategoriaCodigo"] == $category_code;
            });
            $program_additional_info = get_specific_active_program_info($program_code);
            $program_log_info = get_program_with_log($program_code, "0")["ProgramasCadernos"]["ProgramasCadernos"];
            $program_notes = isset(get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"]) ? get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"] : [];
            $program_images_file_names = get_program_images_file_names($program_code)["ProgramasImagens"]["Paginacao"]["RegistroTotal"] == 0 ? [] : get_program_images_file_names($program_code)["ProgramasImagens"]["ProgramaImagens"];
            $program_price_table_image_file_names = get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["Paginacao"]["TotalRegistro"] == 0 ? [] : get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["ProgramaPrecos"];
            $program_region_data = get_program_region_data($program_code)["ProgramasCidades"]["Paginacao"]["TotalRegistros"] == 0 ? [] : get_program_region_data($program_code)["ProgramasCidades"]["ProgramasCidades"];
    
            foreach($program_region_data as $program_region) {
                $program_countries[] = trim($program_region["NomePais"]);
                $program_world_regions[] = trim($program_region["RegiaoMundial"]);
            }
    
            $program_countries = array_unique($program_countries);
            $program_world_regions = array_unique($program_world_regions);
    
            $program_metadata = [
                "ProgramInfo" => $program,
                "ProgramAddInfo" => $program_additional_info,
                "CategoryInfo" => $category_info,
                "ProgramLogInfo" => $program_log_info,
                "ProgramNotes" => $program_notes,
                "ImageGalleryFiles" => $program_images_file_names,
                "PriceTableImageFiles" => $program_price_table_image_file_names,
                "RegionInfo" => $program_region_data
            ];
    
            $post_id;
            $program_page_title = $program["Descricao"];
            $program_page_description = $program["DescricaoResumida"];
    
            // Use WP_Query to check if a page with the title already exists
            $query = new WP_Query(array(
                'post_type' => 'post',
                'title' => wp_strip_all_tags($program_page_title),
                'post_status' => 'publish',
                'posts_per_page' => 1
            ));
            $category_title = $category_info["Titulo"];
            $current_category = get_term_by('name', $category_title, 'category');
    
            if ($query->have_posts()) {
                print_r("Post com o título $program_page_title foi encontrada. Atualizando os dados.");
                $existing_page = $query->posts[0];
                $post_id = $existing_page->ID;
                update_post_meta($post_id, 'custom_data', $program_metadata);
    
                foreach($program_countries as $program_country) {
                    $country_tag = term_exists( $program_country, "post_tag", true );
    
                    if($country_tag) {
                        wp_set_post_tags( $post_id, $program_country, true );
                    } else {
                        wp_create_tag( $program_country );
                        wp_set_post_tags( $post_id, $program_country, true );
                    }
                }
    
                foreach($program_world_regions as $program_world_region) {
                    $world_region_tag = term_exists( $program_world_region, "post_tag", true );
    
                    if($world_region_tag) {
                        wp_set_post_tags( $post_id, $program_world_region, true );
                    } else {
                        wp_create_tag( $program_world_region );
                        wp_set_post_tags( $post_id, $program_world_region, true );
                    }
                }
    
                if ($current_category) {
                    wp_set_post_terms($post_id, array($current_category->term_id), 'category', true);
                } else {
                    error_log('Erro ao atribuir a cateogoria ao post. Categoria: ' . $category_title);
                }
            } else {
                print_r("Post com o título $program_page_title não encontrada. Criando post.");
                $post_id = wp_insert_post(array(
                    'post_title'    => wp_strip_all_tags($program_page_title),
                    'post_content'  => $program_page_description,
                    'post_status'   => 'publish',
                    'post_type'     => 'post'
                ));
    
                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'custom_data', $program_metadata);
    
                    foreach($program_countries as $program_country) {
                        $country_tag = term_exists( $program_country, "post_tag", true );
        
                        if($country_tag) {
                            wp_set_post_tags( $post_id, $program_country, true );
                        } else {
                            wp_create_tag( $program_country );
                            wp_set_post_tags( $post_id, $program_country, true );
                        }
                    }
        
                    foreach($program_world_regions as $program_world_region) {
                        $world_region_tag = term_exists( $program_world_region, "post_tag", true );
        
                        if($world_region_tag) {
                            wp_set_post_tags( $post_id, $program_world_region, true );
                        } else {
                            wp_create_tag( $program_world_region );
                            wp_set_post_tags( $post_id, $program_world_region, true );
                        }
                    }
    
                    if ($current_category) {
                        wp_set_post_terms($post_id, array($current_category->term_id), 'category', true);
                    } else {
                        error_log('Erro ao atribuir a cateogoria ao post. Categoria: ' . $category_title);
                    }
    
                    print_r("Criação de página: $program_page_title - $program_code. \n Tags:");
                    print_r($program_countries);
                    print_r($program_world_regions);
                    print_r("<br />");
                } else {
                    print_r("Problema na criação de página: $program_page_title - $program_code. \n Tags:");
                    print_r($program_countries);
                    print_r($program_world_regions);
                    print_r("<br />");
                }
            }
            wp_reset_postdata();
        }
        sleep(1);
    }
    ob_end_flush();
}



function generate_countries_list() {
    setlocale(LC_COLLATE, 'pt_BR.utf8');
    $active_programs = require "cached-active-programs-list.php";
    $countries_list = [];

    foreach($active_programs as $active_program) {
        $current_program_code = $active_program["ProgramaCodigo"];
        $current_program_regions_infos = get_program_region_data($current_program_code);
        $current_program_regions = $current_program_regions_infos["ProgramasCidades"]["Paginacao"]["TotalRegistros"] == 0 ? [] : $current_program_regions_infos["ProgramasCidades"]["ProgramasCidades"];

        foreach($current_program_regions as $program_region) {
            $countries_list[] = ["pais" => trim($program_region["NomePais"]), "regiao" => trim($program_region["RegiaoMundial"])];
        }
    }

    $countries_list = array_unique($countries_list, SORT_REGULAR);
    usort($countries_list, function($a, $b) {
        $alphabet = 'áabcćçdeéfghiíjklłmnnoóqprstuvwxyz'; 
        $a = mb_strtolower($a['pais']);
        $b = mb_strtolower($b['pais']);

        for ($i = 0; $i < mb_strlen($a); $i++) {
            if (mb_substr($a, $i, 1) == mb_substr($b, $i, 1)) {
                continue;
            }
            if ($i > mb_strlen($b)) {
                return 1;
            }
            if (mb_strpos($alphabet, mb_substr($a, $i, 1)) > mb_strpos($alphabet, mb_substr($b, $i, 1))) {
                return 1;
            } else {
                return -1;
            }
        }
    });

    $cached_countries_list_file = get_template_directory() . '/cached-countries-list.php';

    file_put_contents($cached_countries_list_file, '<?php return ' . var_export($countries_list, true) . ';');
}

function delete_orphaned_posts() {
    $active_programs = require_once "cached-active-programs-list.php";
    $programs_slugs = [];
    $orphaned_posts = [];
    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_key' => 'source_api',
        'meta_value' => 'true'
    );
    

    foreach($active_programs as $active_program) {
        $programs_slugs[] = sanitize_title( $active_program['ProgramaDescricao'] );
    }

    $existing_posts = new WP_Query($query_args);

    if ($existing_posts->have_posts()) {
        while ($existing_posts->have_posts()) {
            $existing_posts->the_post();
            $post_slug = $existing_posts->post->post_name; // slug
    
            if (!in_array($post_slug, $programs_slugs)) {
                $orphaned_posts[] = get_the_ID();
                print_r("Post a ser apagado: $post_slug");
            }
        }
    }

    wp_reset_postdata();

    foreach ($orphaned_posts as $post_id) {
        wp_delete_post($post_id, true);
    }
}

function create_posts_from_api_data() {
    $programs = get_active_programs_info();
    $world_regions = require_once "cached-world-regions.php";

    if (empty($programs)) {
        return;
    }

    /* $programs_batches = array_chunk($programs, 50);

    foreach ($programs_batches as $program_batch) {
        foreach ($program_batch as $program) {
            $category_code = $program["CategoriaCodigo"];
            $program_code = $program["CodigoPrograma"];
            
            $category_info = require 'cached-categories.php';
            $program_additional_info = get_specific_active_program_info($program_code);
            $program_log_info = get_program_with_log($program_code, "0")["ProgramasCadernos"]["ProgramasCadernos"];
            $program_notes = isset(get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"]) ? get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"] : [];
            $program_images_file_names = get_program_images_file_names($program_code)["ProgramasImagens"]["ProgramaImagens"];
            $program_price_table_image_file_names = get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["Paginacao"]["TotalRegistro"] == 0 ? [] : get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["ProgramaPrecos"];

            $program_metadata = [
                "ProgramInfo" => $program,
                "ProgramAddInfo" => $program_additional_info,
                "CategoryInfo" => $category_info,
                "ProgramLogInfo" => $program_log_info,
                "ProgramNotes" => $program_notes,
                "ImageGalleryFiles" => $program_images_file_names,
                "PriceTableImageFiles" => $program_price_table_image_file_names
            ];

            $program_page_title = $program["Descricao"];
            $program_page_description = $program["DescricaoResumida"];

            // Use WP_Query to check if a page with the title already exists
            $query = new WP_Query(array(
                'post_type' => 'page',
                'title' => $program_page_title,
                'post_status' => 'publish',
                'posts_per_page' => 1
            ));

            if ($query->have_posts()) {
                $existing_page = $query->posts[0];
                $page_id = $existing_page->ID;
                update_post_meta($page_id, 'custom_data', $program_metadata);
            } else {
                $page_id = wp_insert_post(array(
                    'post_title'    => $program_page_title,
                    'post_content'  => $program_page_description,
                    'post_status'   => 'publish',
                    'post_type'     => 'page'
                ));

                if ($page_id) {
                    // Save additional data as post meta
                    update_post_meta($page_id, 'custom_data', $program_metadata); // Store the entire object as post meta
                }
            }
        }

        // Optional: Add a delay between batches to avoid overloading the server
        sleep(1);
    } */

    foreach($programs as $program) {
        $category_code = $program["CategoriaCodigo"];
        $program_code = $program["CodigoPrograma"];
        $program_countries = [];
        $program_world_regions = [];
        
        
        $categories_info = require 'cached-categories.php';
        $category_info = array_find($categories_info, function($category_info) use ($category_code) {
            return $category_info["CategoriaCodigo"] == $category_code;
        });
        $program_additional_info = get_specific_active_program_info($program_code);
        $program_log_info = get_program_with_log($program_code, "0")["ProgramasCadernos"]["ProgramasCadernos"];
        $program_notes = isset(get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"]) ? get_program_notes($program_code)["ProgramasNotas"]["ProgramasNotas"] : [];
        $program_images_file_names = get_program_images_file_names($program_code)["ProgramasImagens"]["Paginacao"]["RegistroTotal"] == 0 ? [] : get_program_images_file_names($program_code)["ProgramasImagens"]["ProgramaImagens"];
        $program_price_table_image_file_names = get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["Paginacao"]["TotalRegistro"] == 0 ? [] : get_program_price_table_image_file_names($program_code)["ProgramasPrecos"]["ProgramaPrecos"];
        $program_region_data = get_program_region_data($program_code)["ProgramasCidades"]["Paginacao"]["TotalRegistros"] == 0 ? [] : get_program_region_data($program_code)["ProgramasCidades"]["ProgramasCidades"];

        foreach($program_region_data as $program_region) {
            $program_countries[] = trim($program_region["NomePais"]);
            $program_world_regions[] = trim($program_region["RegiaoMundial"]);
        }

        $program_countries = array_unique($program_countries);
        $program_world_regions = array_unique($program_world_regions);
        $is_featured_program = $program["DestaquePortal"] === "S";

        $program_metadata = [
            "ProgramInfo" => $program,
            "ProgramAddInfo" => $program_additional_info,
            "CategoryInfo" => $category_info,
            "ProgramLogInfo" => $program_log_info,
            "ProgramNotes" => $program_notes,
            "ImageGalleryFiles" => $program_images_file_names,
            "PriceTableImageFiles" => $program_price_table_image_file_names,
            "RegionInfo" => $program_region_data
        ];

        $post_id;
        $program_page_title = $program["Descricao"];
        $program_page_description = $program["DescricaoResumida"];

        // Use WP_Query to check if a page with the title already exists
        $query = new WP_Query(array(
            'post_type' => 'post',
            'title' => wp_strip_all_tags($program_page_title),
            'post_status' => 'publish',
            'posts_per_page' => 1
        ));
        $category_title = $category_info["CategoriaDescricao"];
        $current_category = get_term_by('name', $category_title, 'category');
        /* print_r("Criação de página: $program_page_title - $program_code. \n Tags:");
        print_r($program_countries);
        print_r($program_world_regions);
        print_r("<br />"); */

        if ($query->have_posts()) {
            $existing_page = $query->posts[0];
            $post_id = $existing_page->ID;
            update_post_meta($post_id, 'custom_data', $program_metadata);
            update_post_meta($post_id, 'is_featured', $is_featured_program);

            foreach($program_countries as $program_country) {
                $country_tag = term_exists( $program_country, "post_tag", true );

                if($country_tag) {
                    wp_set_post_tags( $post_id, $program_country, true );
                } else {
                    wp_create_tag( $program_country );
                    wp_set_post_tags( $post_id, $program_country, true );
                }
            }

            foreach($program_world_regions as $program_world_region) {
                $world_region_tag = term_exists( $program_world_region, "post_tag", true );

                if($world_region_tag) {
                    wp_set_post_tags( $post_id, $program_world_region, true );
                } else {
                    wp_create_tag( $program_world_region );
                    wp_set_post_tags( $post_id, $program_world_region, true );
                }
            }

            if ($current_category) {
                wp_set_post_terms($post_id, array($current_category->term_id), 'category', true);
            } else {
                error_log('Erro ao atribuir a cateogoria ao post. Categoria: ' . $category_title);
            }
        } else {
            $post_id = wp_insert_post(array(
                'post_title'    => wp_strip_all_tags($program_page_title),
                'post_content'  => $program_page_description,
                'post_status'   => 'publish',
                'post_type'     => 'post'
            ));

            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, 'custom_data', $program_metadata);
                update_post_meta($post_id, 'is_featured', $is_featured_program);

                foreach($program_countries as $program_country) {
                    $country_tag = term_exists( $program_country, "post_tag", true );
    
                    if($country_tag) {
                        wp_set_post_tags( $post_id, $program_country, true );
                    } else {
                        wp_create_tag( $program_country );
                        wp_set_post_tags( $post_id, $program_country, true );
                    }
                }
    
                foreach($program_world_regions as $program_world_region) {
                    $world_region_tag = term_exists( $program_world_region, "post_tag", true );
    
                    if($world_region_tag) {
                        wp_set_post_tags( $post_id, $program_world_region, true );
                    } else {
                        wp_create_tag( $program_world_region );
                        wp_set_post_tags( $post_id, $program_world_region, true );
                    }
                }

                if ($current_category) {
                    wp_set_post_terms($post_id, array($current_category->term_id), 'category', true);
                } else {
                    error_log('Erro ao atribuir a cateogoria ao post. Categoria: ' . $category_title);
                }

                print_r("Criação de página: $program_page_title - $program_code. \n Tags:");
                print_r($program_countries);
                print_r($program_world_regions);
                print_r("<br />");
            } else {
                print_r("Problema na criação de página: $program_page_title - $program_code. \n Tags:");
                print_r($program_countries);
                print_r($program_world_regions);
                print_r("<br />");
            }
        }
    }
}

function create_category_pages_with_api_data() {
    $categories_list =  require 'cached-categories.php';
    $logs_list = require 'cached-logs.php';
    $valid_categories_list = array_filter($categories_list, function($category_info) {
        return $category_info["CategoriaStatus"] == "A";
    });

    foreach($valid_categories_list as $valid_category) {
        $category_title = $valid_category["Titulo"];
        $category_description = $valid_category["CategoriaDescricao"];
        $category_subtitle = $valid_category["SubTitulo"];
        $formatted_category_description = trim(mb_strtolower($category_description));
        $logs_related_to_category = array_filter($logs_list, function($log) use ($formatted_category_description) {
            $formatted_log_category_title = trim(mb_strtolower($log["CategoriaDescricao"]));

            return ($formatted_category_description == $formatted_log_category_title) && $log["Status"] == "A";
        });
        $slugified_category_title = sanitize_title($category_title);
        $category_page_data = [
            "CategoryInfo" => $valid_category,
            "RelatedLogs" => $logs_related_to_category
        ];

         
        if (!term_exists($category_title, 'category')) {
            $term = wp_insert_term(
                wp_strip_all_tags($category_title),
                'category',
                array(
                    'slug' => $slugified_category_title,
                    'description' => $category_subtitle
                )
            );


            if (!is_wp_error($term)) {
                add_term_meta($term['term_id'], 'api_data', $category_page_data, true);
            }
        }

    }
}

function create_tags_from_world_regions() {
    $world_regions = require "cached-world-regions.php";
    
    foreach($world_regions as $world_region) {
        $world_region_name = trim($world_region['NomeRegiao']);
    
        if (!term_exists($world_region_name, 'post_tag')) {
            wp_insert_term(
                $world_region_name,
                'post_tag',
                array(
                    'description' => 'Programas que visitam o continente ' . $world_region_name . '.',
                    'slug' => sanitize_title($world_region_name)
                )
            );
        }
    }
}

function create_tags_from_countries_list() {
    $countries_list = require "cached-countries-list.php";
    
    foreach($countries_list as $country_name) {
        if (!term_exists($country_name, 'post_tag')) {
            wp_insert_term(
                $country_name,
                'post_tag',
                array(
                    'description' => 'Programas que visitam o país ' . $country_name . ".",
                    'slug' => sanitize_title($country_name)
                )
            );
        }
    }
}

/* add_action('init', 'create_tags_from_world_regions'); */
/* add_action('init', 'create_tags_from_countries_list'); */

// add_action('init', 'create_posts_from_api_data');

// add_action('init', 'fetch_data_and_update_cached_items');

function fetch_data_and_update_cached_items() {
    $cached_all_programs_file = get_template_directory() . '/cached-programs-list.php';
    $cached_active_programs_file = get_template_directory() . '/cached-active-programs-list.php';
    $cached_categories_file = get_template_directory() . '/cached-categories.php';
    $cache_lifetime = 24 * 60 * 60;

    if ((file_exists($cached_all_programs_file) && (time() - filemtime($cached_all_programs_file)) < $cache_lifetime)
    && (file_exists($cached_active_programs_file) && (time() - filemtime($cached_active_programs_file)) < $cache_lifetime)
    && (file_exists($cached_categories_file) && (time() - filemtime($cached_categories_file)) < $cache_lifetime)) {
        $all_programs_list = include $cached_all_programs_file;
        $actives_programs_list = include $cached_active_programs_file;
        $categories_list = include $cached_categories_file;

    } else {
        $all_programs_list = get_all_programs();
        $actives_programs_list = get_active_programs_list()["ProgramasAtivosPortal"]["ProgramasAtivoPortal"];
        $categories_list = get_specific_category_info("")["CategoriasGrupo"]["Categorias"];

        file_put_contents($cached_all_programs_file, '<?php return ' . var_export($all_programs_list, true) . ';');
        file_put_contents($cached_active_programs_file, '<?php return ' . var_export($actives_programs_list, true) . ';');
        file_put_contents($cached_categories_file, '<?php return ' . var_export($categories_list, true) . ';');
    }
}

function update_cache_files() {
    $cached_all_programs_file = get_template_directory() . '/cached-programs-list.php';
    $cached_active_programs_file = get_template_directory() . '/cached-active-programs-list.php';
    $cached_categories_file = get_template_directory() . '/cached-categories.php';
    $cached_logs_file = get_template_directory() . '/cached-logs.php';
    $cached_active_programs_detailed_info_file = get_template_directory() . '/cached-active-programs-info.php';
    $cached_videos_urls = get_template_directory() . '/cached-videos-urls.php';
    $cached_dolar_currency_conversion = get_template_directory() . '/dolar-currency-conversion-info.php';
    $cached_euro_currency_conversion = get_template_directory() . '/euro-currency-conversion-info.php';
    // $cache_lifetime = 24 * 60 * 60;

    $all_programs_list = get_all_programs();
    $videos_urls = get_featured_videos_array()["Videos"];
    $active_programs_list = get_active_programs_list()["ProgramasAtivosPortal"]["ProgramasAtivoPortal"];
    $categories_list = get_specific_category_info("")["CategoriasGrupo"]["Categorias"];
    $all_logs_list = get_all_logs();
    $active_programs_info_list = [];

    $dolar_currency_conversion_info = get_dolar_currency_conversion();
    $euro_currency_conversion_info = get_euro_currency_conversion();

    $code_lookup = array_flip(array_column($active_programs_list, 'ProgramaCodigo'));

    foreach($all_programs_list as $program_info) {
        if(isset($code_lookup[$program_info["CodigoPrograma"]])) {
            $active_programs_info_list[] = $program_info;
        }
    }


    file_put_contents($cached_all_programs_file, '<?php return ' . var_export($all_programs_list, true) . ';');
    file_put_contents($cached_active_programs_file, '<?php return ' . var_export($active_programs_list, true) . ';');
    file_put_contents($cached_categories_file, '<?php return ' . var_export($categories_list, true) . ';');
    file_put_contents($cached_logs_file, '<?php return ' . var_export($all_logs_list, true) . ';');
    file_put_contents($cached_active_programs_detailed_info_file, '<?php return ' . var_export($active_programs_info_list, true) . ';');
    file_put_contents($cached_videos_urls, '<?php return ' . var_export($videos_urls, true) . ';');
    file_put_contents($cached_dolar_currency_conversion, '<?php return ' . var_export($dolar_currency_conversion_info, true) . ';');
    file_put_contents($cached_euro_currency_conversion, '<?php return ' . var_export($euro_currency_conversion_info, true) . ';');
}

function update_world_regions() {
    $cached_world_regions_file = get_template_directory() . '/cached-world-regions.php';
    
    $world_regions_list = get_world_regions()["RegiaoMundial"]["Regiao"];

    file_put_contents($cached_world_regions_file, '<?php return ' . var_export($world_regions_list, true) . ';');
}

function my_custom_admin_menu() {
    add_menu_page(
        'Atualizar Cache de Requisições', // Page title
        'Atualizar Cache de Requisições',     // Menu title
        'manage_options', // Capability required to access
        'refresh-requests-cache',  // Menu slug
        'refresh_cache_plugin_content', // Callback function to display content
        'dashicons-admin-generic', // Icon (optional)
        6                  // Position in the menu
    );

    add_menu_page(
        'Atualizar páginas de categorias', // Page title
        'Atualizar páginas de categorias',     // Menu title
        'manage_options', // Capability required to access
        'refresh-category-pages',  // Menu slug
        'refresh_category_pages_plugin_content', // Callback function to display content
        'dashicons-admin-generic', // Icon (optional)
        7                  // Position in the menu
    );

    add_menu_page(
        'Atualizar páginas de programa', // Page title
        'Atualizar páginas de programa',     // Menu title
        'manage_options', // Capability required to access
        'refresh-program-pages',  // Menu slug
        'refresh_program_pages_plugin_content', // Callback function to display content
        'dashicons-admin-generic', // Icon (optional)
        8                  // Position in the menu
    );

    
}

add_action('admin_menu', 'my_custom_admin_menu');

function refresh_cache_plugin_content() {
    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 20px;">Atualizar Cache de Programas</h1>
        <p style="margin-bottom: 30px;">Puxe as informações da API e atualize o arquivo de cache que guarda os programas.</p>
        <form method="post">
            <input type="submit" name="refresh_cache_btn" value="Atualizar Cache" class="button button-primary">
        </form>
    </div>
    <?php
}

function refresh_program_pages_plugin_content() {
    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 20px;">Atualizar páginas de programas usando as informações em cache</h1>
        <p style="margin-bottom: 30px;">Esse processo preferencialmente deve ser feito após atualizar o cache das requisições para a API.</p>
        <form method="post">
            <input type="submit" name="refresh_program_pages_btn" value="Atualizar Páginas de Programas" class="button button-primary">
        </form>
    </div>
    <?php
}

function refresh_category_pages_plugin_content() {
    ?>
    <div class="wrap">
        <h1 style="margin-bottom: 20px;">Atualizar páginas de categorias usando as informações em cache</h1>
        <p style="margin-bottom: 30px;">Esse processo preferencialmente deve ser feito após atualizar o cache das requisições para a API.</p>
        <form method="post">
            <input type="submit" name="refresh_category_pages_btn" value="Atualizar Páginas de Categorias" class="button button-primary">
        </form>
    </div>
    <?php
}

function handle_custom_button_click() {
    if (isset($_POST['refresh_cache_btn'])) {
        update_cache_files(); // Call your custom function here
        update_world_regions();
        generate_countries_list();

        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>Cache de requisições atualizado!</p></div>';
        });
    }

    if (isset($_POST['refresh_program_pages_btn'])) {
        delete_orphaned_posts();
        /* create_posts_from_api_data(); */
        create_posts_from_api_data_batches();
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>Páginas de programas atualizadas!</p></div>';
        });
    }

    if (isset($_POST['refresh_category_pages_btn'])) {
        create_category_pages_with_api_data();
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>Páginas de programas atualizadas!</p></div>';
        });
    }
}

add_action('admin_init', 'handle_custom_button_click');

function custom_api_endpoints() {
    register_rest_route('api/v1', '/search/', array(
        'methods'  => 'GET',
        'callback' => 'custom_search_results',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('api/v1', '/tagfilter/', array(
        'methods'  => 'GET',
        'callback' => 'custom_tag_filter_results',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('api/v1', '/categoryfilter/', array(
        'methods'  => 'GET',
        'callback' => 'custom_category_filter_results',
        'permission_callback' => '__return_true'
    ));
}

add_action('rest_api_init', 'custom_api_endpoints');

function custom_search_results($request) {
    $search_query = sanitize_text_field($request->get_param('s'));

    // Query posts based on the search term
    $args = array(
        's'              => $search_query,
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'post_type' => 'post',
        'post_status' => 'publish'
    );
    $query = new WP_Query($args);

    // Prepare the results array
    $results = array();

    if ($query->have_posts()) {
        $counter = 1;
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $metadata = get_post_meta($post_id, 'custom_data', true);
            /* foreach($metadata["ProgramInfo"] as $program_info) {
                if(gettype($program_info) == "string") {
                $program_info = str_replace('"', "'", $program_info);
                }
            } */
            $additional_program_info = $metadata['ProgramAddInfo'];
            $program_logs_info = $metadata['ProgramLogInfo'];
            $program_info = $metadata['ProgramInfo'];
            $category_info = $metadata["CategoryInfo"];
            $log_name = $additional_program_info["CadernoTitulo"]; 
            $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
                $lower_log_name = trim(mb_strtolower($log_name));
                $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

                return $lower_log_name == $current_item_name;
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
                "Key" => $counter
            ];

            $counter += 1;
        }
    }

    // Reset the post data
    wp_reset_postdata();

    $json_posts_meta = json_encode($posts_metadata, JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);

    // Return the results as JSON
    return rest_ensure_response($posts_metadata);
    // return $json_posts_meta;
}

function custom_tag_filter_results($request) {
    $tag_slugs = $request->get_param('tags');
    $category_slugs = $request->get_param('categories');
    $search_query = sanitize_text_field($request->get_param('search'));

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, 
        'post_status'    => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    );

    if(!empty($search_query) && trim($search_query) !== "") {
        $args['s'] = $search_query;
    }

    if (!empty($tag_slugs)) {
        $args['tag_slug__and'] = explode(',', $tag_slugs);
    }

    if (!empty($category_slugs)) {
        $cat_slugs_array = explode(',', $category_slugs);
        $query_formatted_cat_slugs = implode("+", $cat_slugs_array);
        $args['category_name'] = $query_formatted_cat_slugs;
    }

    if(empty($tag_slugs) && empty($category_slugs)) {
        return rest_ensure_response([]);
    }

    $query = new WP_Query($args);

    // Prepare the response
    $posts_metadata = array();
    if ($query->have_posts()) {
        $counter = 1;
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $metadata = get_post_meta($post_id, 'custom_data', true);
            $additional_program_info = $metadata['ProgramAddInfo'];
            $program_logs_info = $metadata['ProgramLogInfo'];
            $program_info = $metadata['ProgramInfo'];
            $category_info = $metadata["CategoryInfo"];
            $log_name = $additional_program_info["CadernoTitulo"]; 
            $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
                $lower_log_name = trim(mb_strtolower($log_name));
                $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

                return $lower_log_name == $current_item_name;
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
                "Key" => $counter
            ];

            $counter += 1;
        }
    }

    // Reset post data
    wp_reset_postdata();

    // Return the response
    return rest_ensure_response($posts_metadata);
}

function custom_category_filter_results($request) {
    $tag_slugs = $request->get_param('tags');
    $category_slug = $request->get_param('category');
    $text_filter = $request->get_param('textFilter');

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1, 
        'post_status'    => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    );

    if (!empty($text_filter)) {
        $args['s'] = $text_filter;
    }

    if (!empty($tag_slugs)) {
        $args['tag_slug__in'] = explode(',', $tag_slugs);
    }

    if (!empty($category_slug)) {
        $args['category_name'] = $category_slug;
    }

    if(empty($tag_slugs) && empty($category_slug) && empty($text_filter)) {
        return rest_ensure_response([]);
    }

    $query = new WP_Query($args);

    $posts_metadata = array();

    if ($query->have_posts()) {
        $counter = 1;
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $metadata = get_post_meta($post_id, 'custom_data', true);
            $additional_program_info = $metadata['ProgramAddInfo'];
            $program_logs_info = $metadata['ProgramLogInfo'];
            $program_info = $metadata['ProgramInfo'];
            $category_info = $metadata["CategoryInfo"];
            $log_name = $additional_program_info["CadernoTitulo"]; 
            $program_log_info = array_find($program_logs_info, function($program_log_info) use ($log_name) {
                $lower_log_name = trim(mb_strtolower($log_name));
                $current_item_name = trim(mb_strtolower($program_log_info["CadernoTitulo"]));

                return $lower_log_name == $current_item_name;
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
                "Key" => $counter,
            ];

            $counter += 1;
        }
    }

    wp_reset_postdata();

    
    return rest_ensure_response($posts_metadata);
}

