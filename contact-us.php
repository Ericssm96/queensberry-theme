<?php 
/*
    Template Name: Fale Conosco Template
*/
get_header(); ?>

<main>
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
  <section class="banner">
      <h1>Fale Conosco</h1>
  </section>
  <section class="form-area">
      <div class="wrapper">
        <div class="form-info">
          <p>Bem-vindo ao canal de atendimento Queensberry. Para enviar sugestões, obter informações ou esclarecer
            dúvidas, selecione um assunto no formulário ao lado. Se preferir, entre em contato também por telefone
            (atendimento de segunda à sexta, das 9h às 18h).</p>
        </div>
        <article class="form-container">
          <form id="f_queensberry_fale_conosco" name="f_queensberry_fale_conosco" method="POST" x-data="{
          isEmailPermissionChecked: false,
        }">
            <input type="hidden" id="actionField" name="action" value="queensberry_fale_conosco_recaptcha">

            <!-- Eloqua -->
            <input type="hidden" name="elqFormName" value="queensberry-fale-conosco">
            <input type="hidden" name="elqSiteID" value="2864845">
            <input type="hidden" name="elqCustomerGUID" value="">
            <input type="hidden" name="elqCookieWrite" value="0">


            <!-- Responsys -->
            <input type="hidden" name="_ri_"
              value="X0Gzc2X%3DAQjkPkSRWQG1SszaHvzcXON5k0mzaSKb4cfIpfK4zbHDCVwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQG2e9n6TJuwEzb8zgdnknUzazbyzcsdkPM7pza">
            <input type="hidden" name="_ei_" value="EYl0W1v1-DnBaKPyOAQ9eNc">
            <input type="hidden" name="_di_" value="u609bmeb2lpifgqckful95hnl4g4djuv8rh5sa7qh3771chd5eog">
            <input type="hidden" name="EMAIL_PERMISSION_STATUS_" x-bind:value="isEmailPermissionChecked ? 'I' : 'O'" id="optIn">
            <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
            <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Fale Conosco - Queensberry">
            <input type="hidden" id="URL_CADASTRO" name="URL_CADASTRO" onload="getURL">
            <input type="hidden" name="FULL_PHONE_NUMBER" value="" id="fullPhoneNumber">

            <!-- Formulário -->
            <label for="ASSUNTO">Assunto</label>
            <select required name="ASSUNTO" id="ASSUNTO">
              <option value="">- Selecione o Assunto - </option>
              <option value="Assessoria de Imprensa">Assessoria de Imprensa</option>
              <option value="Atendimento ao Agente de Viagens">Atendimento ao Agente de Viagens</option>
              <option value="Atendimento ao Passageiro">Atendimento ao Passageiro</option>
              <option value="Pós Vendas">Pós Vendas</option>
              <option value="Viagens de Incentivo">Viagens de Incentivo</option>
            </select>

            <input type="text" placeholder="Nome*" required name="FIRST_NAME">
            <input type="text" placeholder="Sobrenome*" required name="LAST_NAME">
            <input type="text" placeholder="CPF" id="iptCpf" maxlength="14" name="CPF_USUARIO">
            <input type="text" placeholder="E-mail*" required name="EMAIL_ADDRESS_">
            <input type="text" placeholder="Telefone()*" required maxlength="14" name="MOBILE_NUMBER_" id="celular">
            <textarea placeholder="Mensagem*" required name="MENSAGEM"></textarea>

            <div class="checkbox-area">
              <span class="custom-checkbox">
                <input type="checkbox" @change="isEmailPermissionChecked = !isEmailPermissionChecked" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
                <label for="RECEBER_COMUNICACOES" class="checkmark"></label>
              </span>
              <label for="RECEBER_COMUNICACOES" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
            </div>

            <div class="submit-area">
              <button type="submit" class="submit-btn">Enviar</button>
            </div>
          </form>
          <script>
            $(document).ready(() => {
              $("#celular").mask("(00) 00000-0000");
              $("#iptCpf").mask("000.000.000-00");

              $("#celular").on("blur", () => {
                let nationalCelNumber = $("#celular").val();
                let cleanNumber = nationalCelNumber.replace(/\D/g, "");
                let fullNumber = `55${cleanNumber}`;
                $("#fullPhoneNumber").val(fullNumber);
              })

              $("#f_queensberry_fale_conosco").on("submit", (e) => {
                e.preventDefault();
                let nationalCelNumber = $("#celular").val();
                let cleanNumber = nationalCelNumber.replace(/\D/g, "");
                let fullNumber = `55${cleanNumber}`;
                let subject = $("#ASSUNTO").val();
                $("#fullPhoneNumber").val(fullNumber);



                grecaptcha.ready(function() {
                  grecaptcha.execute('6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y', {action: 'submit'}).then(function(token) {
                    console.log(token);
                    jQuery.post(
                      "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha",
                      {
                        "g-recaptcha-response": token
                      }
                    ).done((res) => {
                      jQuery("#actionField").val("queensberry_fale_conosco");
                      if(res.data.message === "OK") {
                        if(subject === 'Atendimento ao Passageiro') {
                          jQuery.post(
                              "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_fale_conosco",
                            $("#f_queensberry_fale_conosco").serialize(),
                            function (data) {
                              console.log(data); // Exibe a resposta no console
                              alert("Envio realizado com sucesso!");
                            }
                          )
                        } else {
                          jQuery
                            .ajax({
                              type: "POST",
                              url: "https://s2864845.t.eloqua.com/e/f2",
                              data: jQuery("#f_queensberry_fale_conosco").serialize(),
                              success: () => {
                                // jQuery("#actionField").val("envio_seja_parceiro");
                                // formData = new FormData(this);
                                console.log("Eloqua ok");
                                alert("Envio realizado com sucesso!");
                                // console.log(document.querySelector("#actionField").value);
                              },
                              error: (res) => {
                                console.log("Eloqua fail", res);
                              },
                          })
                        }
                      } else {
                        console.log("Recaptcha error")
                      }
                    })
                  });
                });



                
              })
            }) 
          </script>
          <script>
            $(function getURL() {
              var url_cadastro = window.location.href;
              document.getElementById('URL_CADASTRO').value = url_cadastro;
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
                  document.forms["f_queensberry_fale_conosco"].elements["elqCustomerGUID"].value = GetElqCustomerGUID();
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

          <style>
            #f_queensberry_fale_conosco {
              display: flex;
              flex-direction: column;
            }

            #f_queensberry_fale_conosco h2 {
              font-size: 22px;
            }

            #f_queensberry_fale_conosco label {
              margin-bottom: 5px;
            }

            #f_queensberry_fale_conosco {
              display: flex;
              flex-direction: column;
            }

            #f_queensberry_fale_conosco .column-100 {
              display: flex;
              flex-direction: column;
              gap: 31px;
            }

            #f_queensberry_fale_conosco .row-100 {
              display: flex;
              flex-direction: row;
              gap: 104px;
              width: 100%;
            }

            #f_queensberry_fale_conosco .row-50 {
              display: flex;
              flex-direction: row;
              gap: 32px;
              width: 50%;
            }

            #f_queensberry_fale_conosco h2,
            h3 {
              color: #04004f;
              font-family: "Tenor Sans", sans-serif;
              font-weight: 400;
              font-size: 23px;
              line-height: 28px;
              letter-spacing: -1px;
              text-transform: uppercase;
              margin: 0;
            }

            #f_queensberry_fale_conosco h3 {
              margin-bottom: 31px;
            }

            #f_queensberry_fale_conosco input,
            select,
            textarea {
              border: none;
              border-bottom: 1px solid #E5E9EF;
              border-radius: 0;
              padding: 6px 2px;
              outline: none;
              margin-bottom: 31px;
            }

            #f_queensberry_fale_conosco input:focus,
            select:focus {
              border-bottom: 1px solid #04004f;
            }

            #f_queensberry_fale_conosco input::placeholder,
            select::placeholder,
            select {
              font-size: 14px;
              font-family: "Sora", sans-serif;
              font-weight: 400;

            }

            #f_queensberry_fale_conosco hr {
              fill: #9ad128;
              color: #9ad128;
              background-color: #9ad128;
              height: 3px;
            }


            #f_queensberry_fale_conosco input[type="radio"] {
              display: none;
              /* Oculta o input padrão */
            }

            #f_queensberry_fale_conosco label {
              font-size: 14px;
              font-family: "Roboto", sans-serif;
              color: #99d02c;
            }

            #f_queensberry_fale_conosco textarea {
              height: 80px;
              font-family: "Roboto", sans-serif;
              font-size: 1.4rem;
              line-height: 1.5;
            }

            #f_queensberry_fale_conosco .checkbox-area {
              display: flex;
              column-gap: 5px;
              align-items: center;
              margin-bottom: 30px;
            }

            #f_queensberry_fale_conosco .checkbox-area .text-label {
              font-size: 1.4rem;
              font-family: "Roboto", sans-serif;
              color: #656565;
              line-height: 1.5;
              margin-bottom: 0;
            }

            #f_queensberry_fale_conosco .custom-checkbox {
              height: 18px;
              width: 18px;
              cursor: pointer;
              display: inline-block;
            }

            #f_queensberry_fale_conosco .custom-checkbox input {
              display: none;
            }

            #f_queensberry_fale_conosco .custom-checkbox input:checked ~ .checkmark {
              -webkit-box-shadow: inset 0px 0px 3px 5px #99D20C;
              -moz-box-shadow: inset 0px 0px 3px 5px #99D20C;
              box-shadow: inset 0px 0px 3px 5px #99D20C;
            }

            #f_queensberry_fale_conosco .checkmark {
              width: 100%;
              height: 100%;
              border: 1px solid rgba(80, 80, 80, 0.356);
              display: inline-block;
              border-radius: 4px;       
              margin-bottom: 0;       
            }

            #f_queensberry_fale_conosco .submit-area {
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
              row-gap: 50px;
            }

            
            #f_queensberry_fale_conosco .submit-area .submit-btn {
              background-color: #9ad128;
              border: none;
              border-radius: 5px;
              text-transform: uppercase;
              width: 100%;
              padding: 16px;
              color: #000000;
              font-family: "Roboto", sans-serif;
              font-weight: 700;
              font-size: 12px;
              cursor: pointer;
            }

            @media screen and (min-width: 768px) {
              #f_queensberry_fale_conosco .submit-area .submit-btn {
                width: calc(50% - 2.5px);
              }
            }

            @media screen and (min-width: 1260px) {
              #f_queensberry_fale_conosco .submit-area .submit-btn {
                width: calc(100% - 305px);
              }
            }

            #f_queensberry_fale_conosco .submit-btn:hover {
              background-color: #04004f;
              color: #ffffff;
            }

            @media screen and (min-width: 768px) {
              #f_queensberry_fale_conosco .submit-area {
                flex-direction: row;
                row-gap: 0;
                column-gap: 5px;
              }
            }

            #f_queensberry_fale_conosco .submit-area .recaptcha-box {
              height: 74px;
              /* background-color: #656565; */
              width: 80%;
            }

            @media screen and (min-width: 768px) {
              #f_queensberry_fale_conosco .submit-area .recaptcha-box {
                height: 74px;
                background-color: #656565;
                width: calc(50% - 2.5px);
              }
            }

            @media screen and (min-width: 1260px) {
              #f_queensberry_fale_conosco .submit-area .recaptcha-box {
                height: 74px;
                background-color: #656565;
                width: 300px;
              }
            }

            @media screen and (max-width: 1024px) {
              .title {
                display: flex;
                flex-direction: column-reverse;
                gap: 12px;
                justify-content: space-between;
              }

              .title p {
                font-family: "Sora", sans-serif;
                font-weight: 400;
                font-size: 12px;
                text-align: end;
              }


              #f_queensberry_fale_conosco .row-100 {
                display: flex;
                flex-direction: column;
                gap: 31px;
                width: 100%;
              }

              #f_queensberry_fale_conosco .row-50 {
                display: flex;
                flex-direction: column;
                gap: 31px;
                width: 100%;
              }

              
            }
          </style>
        </article>
      </div>
    </section>
  <section class="contact-list">
    <div class="wrapper">
      <div class="main-branch-info">
        <h2 class="title">Queensberry São Paulo</h2>
        <div class="two-cols">
          <span class="phone-number">
            <p>
              ¹¹ 3217-7100
            </p>
          </span>
      
          <span class="phone-number">
            <p>
              ¹¹ 3217-7600
            </p>
          </span>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">NOSSOS REPRESENTANTES COMERCIAIS</strong>
        <div class="info-cluster">
          <p>Atendimento ao Agente de Viagens</p>
        </div>
      <div class="branch-info">
        <strong class="title">DF - BRASÍLIA | GO - GOIÂNIA</strong>
        <div class="info-cluster">
          <p>Atendimento PIER VIAGENS:</p>
          <p>Brasília – Tel.: 61 3298-1515 | Goiânia – Tel.: 62 4016-2535</p>
          <br/>
          <p>João Jatobá</p>
          <p>Tel.: 61 3298-1504 ou 61 98116-7780 </p> 
          <p> E-mail: joao@pierviagens.com.br</p>
        </div>
        <div class="info-cluster">
          <p>Daniel Marrocos</p>
          <p>Tel.: 61 3298-1519 ou 61 98252-7980</p>
          <p>E-mail: daniel@pierviagens.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">ES – VITÓRIA | PR – CURITIBA</strong>
        <div class="info-cluster">
          <p>Brunna Soares</p>
          <p>Tel.: 11 3217-7111</p>
          <p>E-mail: brunna.soares@queensberry.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">MG - BELO HORIZONTE</strong>
        <div class="info-cluster">
          <p>Juliana Tavares Piancastelli</p>
          <p>Tel.: 11 3217-7105</p>
          <p>E-mail: juliana.piancastelli@queensberry.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">NORTE E NORDESTE</strong>
        <div class="info-cluster">
          <p>Rubens Peixoto</p>
          <p>Tels.: 84 99101-3363</p>
          <p>E-mail: rubens.peixoto@queensberry.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">RJ – RIO DE JANEIRO | MG – JUÍZ DE FORA</strong>
        <div class="info-cluster">
          <p>Elton Anselmo</p>
          <p>Tel.: 11 3217-7128  | 21 99294-5718</p>
          <p>E-mail: elton.anselmo@queensberry.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">RS – PORTO ALEGRE</strong>
        <div class="info-cluster">
          <p>Maria Amélia</p>
          <p>Tel.: 51 99707-5459</p>
          <p>E-mail: amelia.queensberry@gmail.com</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">SC – FLORIANÓPOLIS</strong>
        <div class="info-cluster">
          <p>Adriana Taranto</p>
          <p>Tel.: 48 99980-2163</p>
          <p>E-mail: adriana.queensberry@gmail.com</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">SP – CAMPINAS E RIBEIRÃO PRETO</strong>
        <div class="info-cluster">
          <p>Valéria Cazetto</p>
          <p>Tel.: 19 3231-9004 e 19 99475-5438</p>
          <p>E-mail: valeria@accpq.com.br</p>
        </div>
        <div class="info-cluster">
          <p>Alvimar Cazetto</p>
          <p>E-mail: alvimar@accpq.com.br</p>
        </div>
      </div>
      <div class="branch-info">
        <strong class="title">SP – SÃO PAULO (CAPITAL)</strong>
        <div class="info-cluster">
          <p>Paulus Anjos</p>
          <p>Tel.: 11 98802-6357</p>
          <p>E-mail: paulus.anjos@queensberry.com.br</p>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>