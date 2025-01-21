<?php wp_footer(); ?>
<footer class="site-footer">
  <div class="footer-top">
    <div class="wrapper">
      <nav class="footer-nav">
        <div class="nav-col address-col">
          <h2>
            QUEENSBERRY AGÊNCIA DE VIAGENS E
            TURISMO LTDA.
          </h2>
          <address>
            Alameda Campinas, 1.070 - Jd. Paulista - 01404-200 - São Paulo/SP<br />
            +55 (11) 3217-7100 / (11) 3217-7600<br />
            portalq1@queensberry.com.br<br />
            CNPJ 45.575.958/0001-49
          </address>
        </div>
        <div class="nav-col">
          <h2>Institucional</h2>
          <ul class="nav-links">
            <li><a href="<?= home_url(); ?>">Quem Somos</a></li>
            <li><a href="<?= home_url(); ?>">Dados Cadastrais</a></li>
            <li><a href="<?= home_url(); ?>">Fale Conosco</a></li>
            <li><a href="<?= home_url(); ?>">Trabalhe Conosco</a></li>
            <li><a href="<?= home_url(); ?>">Política de Privacidade</a></li>
            <li><a href="<?= home_url(); ?>">Termos e Condições de Uso</a></li>
            <li><a href="<?= home_url(); ?>">Recuperação Judicial</a></li>
            <li><a href="<?= home_url(); ?>">Fale com o presidente</a></li>
            <li><a href="<?= home_url(); ?>">Canal de Ética</a></li>
          </ul>
        </div>
        <div class="nav-col">
          <div>
            <h2>Serviços</h2>
            <ul class="nav-links">
              <li><a href="<?= home_url(); ?>">Folhetos & Cadernos</a></li>
              <li><a href="<?= home_url(); ?>">Formulários</a></li>
              <li><a href="<?= home_url(); ?>">Queens Club</a></li>
              <li><a href="<?= home_url(); ?>">Blog</a></li>
            </ul>
          </div>
          <ul class="network-icons">
            <li><a href="<?= home_url(); ?>"><i class="fa-brands fa-facebook"></a></i></li>
            <li><a href="<?= home_url(); ?>"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="<?= home_url(); ?>"><i class="fa-brands fa-youtube"></i></a></li>
            <li><a href="<?= home_url(); ?>"><img src="<?= get_template_directory_uri(); ?>/src/img/glassdoor-icon.png" alt="Perfil do Queensberry no Glassdoor"></a></li>
          </ul>
        </div>
      </nav>
      <section class="form-section">
        <form action="/" class="newsletter-form">
          <div class="fillable-fields">
            <header class="title-area">
              <h2>Receba Novidades</h2>
              <p>Cadastre seu e-mail</p>
            </header>
            <input type="text" placeholder="Nome" />
            <input type="email" placeholder="E-mail" />
            <select name="TIPO_USUARIO" id="">
              <option value="PASSAGEIRO" selected>Passageiro</option>
              <option value="AGENTE">Agente</option>
            </select>
            <div class="checkbox-field">
              <input type="checkbox" name="RECEBER_COMUNICACOES" id="iptContactAcceptance">
              <label for="iptContactAcceptance">Aceito receber comunicações e informações da Queensberry</label>
            </div>
          </div>
          <div class="submit-area">
            <div class="squarey-recaptcha-box"></div>
            <button class="submit-btn">Cadastrar</button>
          </div>
        </form>
        <div class="safety-watermark">
          <span class="divider"></span>
          <img src="<?= get_template_directory_uri(); ?>/src/img/sectigo-watermark.jpg" alt="Image with text: Secured by Sectigo">
        </div>
      </section>
    </div>
  </div>
  <div class="footer-bottom">
    <p>Uma empresa do ecossistema</p>
    <img src="<?= get_template_directory_uri(); ?>/src/img/befly-logo.png" alt="Imagem com texto: BeFly">
  </div>
</footer>
</body>
</html>