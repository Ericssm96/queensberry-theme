<?php

function qb_assets_queue()
{
    wp_enqueue_style('qb-fonts', get_template_directory_uri() . "/src/css/fonts.css", [], '1.0.0', 'all');
    wp_enqueue_style('qb-root', get_template_directory_uri() . "/src/css/root.css", ['qb-fonts'], '1.0.0', 'all');
    wp_enqueue_style('qb-general', get_template_directory_uri() . "/src/css/output.css", ['qb-fonts', 'qb-root'], '1.0.0', 'all');
    wp_enqueue_style('qb-navbar', get_template_directory_uri() . "/src/css/navbar-styles.css", ['qb-fonts', 'qb-root', 'qb-general'], "1.0.0", "all");
    wp_enqueue_style('qb-swiper', get_template_directory_uri() . "/src/css/swiper-bundle.css", ['qb-fonts', 'qb-root', 'qb-general', 'qb-navbar'], "1.0.0", "all");
    wp_enqueue_style('qb-single-post', get_template_directory_uri() . "/src/css/post-content.css", ['qb-fonts', 'qb-root', 'qb-general', 'qb-navbar'], "1.0.0", "all");
    wp_enqueue_script('qb-scripts', get_template_directory_uri() . "/src/js/scripts.js", [], '1.0.0', ["in_footer" => true, "strategy" => "defer"]);
    wp_enqueue_script('qb-swiper-bundle', "https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js", [], '1.0.0', ["in_footer" => false]);

    wp_enqueue_script('qb-swiper-scripts', get_template_directory_uri() . "/src/js/swiper-config.js", ['qb-swiper-bundle'], '1.0.0', ["in_footer" => false, "strategy" => "defer"]);
    wp_enqueue_script('qb-alpine-scripts', "https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js", [], '1.0.0', ["in_footer" => false, "strategy" => "defer"]);
    wp_enqueue_script('icon-scripts', "https://kit.fontawesome.com/76e78a6b9f.js", [], '1.0.0', ["in_footer" => false, "strategy" => "defer"]);


}

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

function qb_dynamic_meta_description() {
    global $post;

    $meta_description = get_post_meta($post->ID, 'meta_description', true);

    if (empty($meta_description)) {
        $meta_description = wp_strip_all_tags(get_the_content());
        $meta_description = substr($meta_description, 0, 160);
    }

    echo '<meta name="description" content="' . esc_attr($meta_description) . '" />' . "\n";
}
add_action('wp_head', 'qb_dynamic_meta_description');


add_action("wp_enqueue_scripts", "qb_assets_queue");
add_action("after_setup_theme", "qb_setup");