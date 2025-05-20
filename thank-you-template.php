<?php
/*
    Template Name: Obrigado Template
*/
get_header ();?>

  <div class="stand-in-navbar">
    <img class="logo" src="<?= get_template_directory_uri(); ?>/src/img/logo.png" alt="Queensberry Viagens">
  </div>

  <main>
    <section class="core">
      <article>
        <img src="<?= get_template_directory_uri(); ?>/src/img/success-box.png" alt="">
        <p class="highlight">Obrigada por entrar em contato com a Queensberry</p>
        <p class="regular-text">Recebemos sua mensagem e logo entraremos em contato com você. Enquanto isso, sinta-se à vontade para explorar mais sobre nossos destinos e experiências.</p>
      </article>
      <a href="<?= home_url(); ?>" class="home-link"><span class="ico"><i class="fa-solid fa-arrow-left-long"></i></span> <span>Voltar para a página inicial</span></a>
    </section>
  </main>

<?php get_footer(); ?>