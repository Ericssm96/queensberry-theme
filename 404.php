<?php get_header ();?>

  <div class="stand-in-navbar">
    <img class="logo" src="<?= get_template_directory_uri(); ?>/src/img/logo.png" alt="Queensberry Viagens">
  </div>

  <main>
    <section class="core">
      <article>
        <img src="<?= get_template_directory_uri(); ?>/src/img/404.png" alt="">
        <p class="highlight">Ops! Parece que você se perdeu na viagem...</p>
        <p class="regular-text">A página que você procura não existe ou foi movida. Mas não se preocupe, temos muitos destinos incríveis esperando por você.</p>
      </article>
      <a href="<?= home_url(); ?>" class="home-link"><span class="ico"><i class="fa-solid fa-arrow-left-long"></i></span> <span>Voltar para a página inicial</span></a>
    </section>
  </main>

<?php get_footer(); ?>