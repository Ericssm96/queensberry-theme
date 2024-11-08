<?php
get_header();

$posts_query_args = [
    'post_type' => 'post'
];
$posts_query = new WP_Query($posts_query_args);
?>

<?php get_footer(); ?>