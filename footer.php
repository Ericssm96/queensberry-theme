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
            <li><a href="<?= home_url(); ?>/quem-somos">Quem Somos</a></li>
            <li><a href="<?= home_url(); ?>/dados-cadastrais">Dados Cadastrais</a></li>
            <li><a href="<?= home_url(); ?>/fale-conosco">Fale Conosco</a></li>
            <li><a href="<?= home_url(); ?>/trabalhe-conosco">Trabalhe Conosco</a></li>
            <li><a href="<?= home_url(); ?>/politica-de-privacidade">Política de Privacidade</a></li>
            <li><a href="<?= home_url(); ?>/termos-e-condições-de-uso">Termos e Condições de Uso</a></li>
            <li><a href="https://befly.com.br/fale-com-o-presidente/" target="_blank" rel="noopener">Fale com o presidente</a></li>
            <li><a href="https://www.contatoseguro.com.br/pt/befly/codigo-de-etica-e-conduta" target="_blank" rel="noopener">Canal de Ética</a></li>
            <li><a href="https://flytour.feedback.house/ouvidoria" target="_blank" rel="noopener">Ouvidoria</a></li>
          </ul>
        </div>
        <div class="nav-col">
          <div>
            <h2>Serviços</h2>
            <ul class="nav-links">
              <li><a href="<?= home_url(); ?>">Folhetos & Cadernos</a></li>
              <li><a href="<?= home_url(); ?>/formularios">Formulários</a></li>
              <li><a href="<?= home_url(); ?>/queensclub/">Queens Club</a></li>
              <li><a href="https://blog.queensberry.com.br/" target="_blank" rel="noopener">Blog</a></li>
            </ul>
          </div>
          <ul class="network-icons">
            <li><a href="https://www.facebook.com/queensberry.viagens/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook"></a></i></li>
            <li><a href="https://www.instagram.com/queensberryviagens/" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="https://www.youtube.com/q1viagens" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a></li>
            <li><a href="https://www.glassdoor.com.br/Vis%C3%A3o-geral/Trabalhar-na-Queensberry-Viagens-EI_IE2624710.13,32.htm" target="_blank" rel="noopener"><img src="<?= get_template_directory_uri(); ?>/src/img/glassdoor-icon.png" alt="Perfil do Queensberry no Glassdoor"></a></li>
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