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
            <li><a href="<?= home_url(); ?>/fale-conosco">Fale Conosco</a></li>
            <li><a href="<?= home_url(); ?>/trabalhe-conosco">Trabalhe Conosco</a></li>
            <li><a href="<?= home_url(); ?>/politica-de-privacidade">Política de Privacidade</a></li>
            <li><a href="<?= home_url(); ?>/termos-e-condicoes">Termos e Condições de Uso</a></li>
            <li><a href="https://befly.com.br/fale-com-o-presidente/" target="_blank" rel="noopener">Fale com o presidente</a></li>
            <li><a href="https://www.contatoseguro.com.br/pt/befly/codigo-de-etica-e-conduta" target="_blank" rel="noopener">Canal de Ética</a></li>
            <li><a href="https://flytour.feedback.house/ouvidoria" target="_blank" rel="noopener">Ouvidoria</a></li>
          </ul>
        </div>
        <div class="nav-col">
          <div>
            <h2>Serviços</h2>
            <ul class="nav-links">
              <li><a href="<?= home_url(); ?>/folhetos-e-cadernos">Folhetos & Cadernos</a></li>
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
        <form id="f_queensberry_receba_novidades" action="/" class="newsletter-form" x-data="{
          isEmailPermissionChecked: false,
        }">
          <input type="hidden" id="actionField3" name="action" value="queensberry_verify_recaptcha">

          <!-- Eloqua -->
          <input type="hidden" name="elqFormName" value="queensberry-newsletter">
          <input type="hidden" name="elqSiteID" value="2864845">
          <input type="hidden" name="elqCustomerGUID" value="">
          <input type="hidden" name="elqCookieWrite" value="0">

          <!-- Responsys -->
          <input type="hidden" name="_ri_"
            value="X0Gzc2X%3DAQjkPkSRWQG3IHmhTHzcn8K72I2zfGItDUp4G4jzf5RzaVwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQG5YElTlcCLrzf3j23eojPBzcP6kufR8zbb">
          <input type="hidden" name="_ei_" value="EZG5N9k5REf3zveZ6bm0rcg">
          <input type="hidden" name="_di_" value="lfbgbm7m1bbva1iuk9gjbrdj77s9ndl30c1bjvbem2898cehfk10">
          <input type="hidden" name="EMAIL_PERMISSION_STATUS_" x-bind:value="isEmailPermissionChecked ? 'I' : 'O'" id="optIn">
          <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
          <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Newsletter Receba Novidades - Queensberry">
          <input type="hidden" value="<?= home_url(); ?>" id="URL_CADASTRO" name="URL_CADASTRO">
          <div class="fillable-fields">
            <header class="title-area">
              <h2>Receba Novidades</h2>
              <p>Cadastre seu e-mail</p>
            </header>
            <input type="text" name="NAME" placeholder="Nome" />
            <input type="text" name="EMAIL_ADDRESS_" placeholder="E-mail" />
            <select name="PERFIL" id="slctPerfil">
              <option value="PASSAGEIRO" selected>Passageiro</option>
              <option value="AGENTE">Agente</option>
            </select>
            <div class="checkbox-field">
              <input @change="isEmailPermissionChecked = !isEmailPermissionChecked" type="checkbox" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
              <label for="RECEBER_COMUNICACOES">Aceito receber comunicações e informações da Queensberry</label>
            </div>
          </div>
          <div class="submit-area">
            <button type="submit" class="submit-btn">Cadastrar</button>
          </div>
        </form>
        <div class="safety-watermark">
          <span class="divider"></span>
          <img src="<?= get_template_directory_uri(); ?>/src/img/sectigo-watermark.jpg" alt="Image with text: Secured by Sectigo">
        </div>
        <script>
          $(document).ready(() => {

            function updateOptInField() {
              const isChecked = $('#RECEBER_COMUNICACOES').is(':checked');
              const value = isChecked ? 'I' : 'O';
              $('#optIn').val(value);
              console.log('EMAIL_PERMISSION_STATUS_ atualizado para:', value);
            }

            updateOptInField();
            $('#RECEBER_COMUNICACOES').on('change', updateOptInField);


            (function getURL() {
              const url_cadastro = window.location.href;
              $('#URL_CADASTRO').val(url_cadastro);
              console.log('URL_CADASTRO preenchido com:', url_cadastro);
            })();


            $("#f_queensberry_receba_novidades").on("submit", function(e) {
              e.preventDefault();

              const perfil = $("#slctPerfil").val();
              console.log(perfil);
              
              grecaptcha.ready(function() {
                grecaptcha.execute('6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y', {
                  action: 'submit'
                }).then(function(token) {
                  console.log('reCAPTCHA token:', token);

                  
                  $.post("<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha", {
                    "g-recaptcha-response": token
                  }).done((res) => {
                    if (res.data && res.data.message === "OK") {
                      console.log(res.data);
                      
                      $("#actionField3").val("queensberry_receba_novidades")
                      
                      
                      const formData = $("#f_queensberry_receba_novidades").serialize();

                      if (perfil === "PASSAGEIRO") {
                        // Envio para Responsys
                        $.post(
                          "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_receba_novidades",
                          formData
                        ).done((data) => {
                          console.log("Responsys sucesso:", data);
                          alert('Formulário enviado com sucesso!');
                        }).fail((err) => {
                          console.error("Responsys erro:", err);
                          alert('O formulário não foi submetido devido a um erro.');
                        });

                      } else {
                        // Envio para Eloqua
                        $.ajax({
                          type: "POST",
                          url: "https://s2864845.t.eloqua.com/e/f2",
                          data: formData,
                          success: () => {
                            console.log("Eloqua sucesso");
                            alert('Formulário enviado com sucesso!');
                          },
                          error: (err) => {
                            console.error("Eloqua erro:", err);
                            alert('O formulário não foi submetido devido a um erro.');
                          }
                        });
                      }

                    } else {
                      console.error("Erro ao verificar o reCAPTCHA:", res);
                      alert('Erro na verificação de segurança. Tente novamente.');
                    }
                  });
                });
              });
            });
          });
        </script>

        <script type="text/javascript">
          var timerId = null,
            timeout = 5;

          function WaitUntilCustomerGUIDIsRetrieved() {
            if (!!(timerId)) {
              if (timeout === 0) {
                return;
              }
              if (typeof this.GetElqCustomerGUID === 'function') {
                document.forms["f_queensberry_receba_novidades"].elements["elqCustomerGUID"].value = GetElqCustomerGUID();
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
            $(function getURL() {
                var url_cadastro = window.location.href;
                document.getElementById('URL_CADASTRO').value = url_cadastro;
            });
        </script>
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
