<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php
    $site_title = get_bloginfo('name');
    ?>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
  <title><?= is_front_page() ? $site_title : strtoupper(get_the_title()) .  " - " . $site_title ?></title>
</head>
<body <?php body_class(["relative", "font-accord"]); ?>>