<?php
/*
    Template Name: Registro QueensClub Template
*/
get_header(); ?>

<main>
  <header class="banner">
    <div class="title-area">
      <h1>Queens Club</h1>
      <strong>Cadastro</strong>
    </div>
  </header>
  <section class="form-area">
    <form id="m_f_queensberry_cadastro_adin" name="m_f_queensberry_cadastro_adin" method="POST" x-data="{
          isEmailPermissionChecked: false,
        }">
      <input type="hidden" name="action" value="queensberry_queensclub">

      <!-- Responsys -->
      <input type="hidden" name="_ri_"
        value="X0Gzc2X%3DAQjkPkSRWQG1MHj7nzbczggdi5zfzezdJu2NHizgzghzc5Yeq3VwjpnpgHlpgneHmgJoXX0Gzc2X%3DAQjkPkSRWQG0BfzdMpswzdMzcC0zgisFnrrAazceppJL7qs">
      <input type="hidden" name="_ei_" value="EYZdvELRM0pr2KjGqHesi5Y">
      <input type="hidden" name="_di_" value="tlbeb7sib7srs4hb3g3hiljo9d0hc596vidmbr8hd67sjghrtai0">
      <input type="hidden" name="FULL_PHONE_NUMBER" value="" id="fullPhoneNumber">
      <input type="hidden" name="MOBILE_PERMISSION_STATUS_" value="O" id="optInSMS">
      <input type="hidden" name="EMAIL_PERMISSION_STATUS_" x-bind:value="isEmailPermissionChecked ? 'I' : 'O'" id="optIn">
      <input type="hidden" name="ORIGEM_CADASTRO" value="Formulário Queensclub Cadastro Adin - Queensberry">
      <input type="hidden" id="URL_CADASTRO" name="URL_CADASTRO" onload="getURL">

      <!-- Formulário -->
      <!-- Dados Pessoais -->
      <div class="title">
        <h2> Dados Pessoais </h2>
        <p>* = preenchimento obrigatório</p>
      </div>

      <div class="column-100">
        <div class="row-100">
          <input type="text" placeholder="Nome*" required name="FIRST_NAME">
          <input type="text" placeholder="Sobrenome*" required name="LAST_NAME">
        </div>
        <div class="row-100">
          <input type="text" placeholder="CPF*" required name="CPF_USUARIO">
          <select id="ESTADO_CIVIL" placeholder="Estado Civil" required name="ESTADO_CIVIL">
            <option value="">Estado Civil</option>
            <option value="Solteiro">Solteiro(a)</option>
            <option value="Casado">Casado(a)</option>
            <option value="Divorciado">Divorciado(a)</option>
            <option value="Viuvo">Viuvo(a)</option>
          </select>
        </div>
        <div class="row-100">
          <input type="text" placeholder="DD/MM/AAAA" required name="DATA_NASCIMENTO" maxlength="10">
          <input type="text" placeholder="Telefone( )*" maxlength="20" required name="MOBILE_NUMBER_" id="celular">
        </div>
        <div class="row-100">
          <input type="text" placeholder="E-mail*" required name="EMAIL_ADDRESS_">
        </div>
      </div>

      <hr>

      <!-- Endereço  -->
      <h2> Endereço </h2>
      <div class="column-100">
        <div class="row-100">
          <input type="text" placeholder="CEP*" required name="CEP_CASA" id="CEP">
          <input type="text" placeholder="Bairro*" required name="BAIRRO" id="BAIRRO_AGENCIA">
        </div>
        <div class="row-100">
          <div class="row-50">
            <input type="text" placeholder="Rua/Av.*" required name="ENDERECO" id="RUA_AGENCIA">
          </div>

          <div class="row-50">
            <select name="ESTADO" id="ESTADO">
              <option value="">Selecione o Estado</option>
            </select>
            <select name="CIDADE" id="CIDADE">
              <option value="">Selecione a Cidade</option>
            </select>
          </div>
        </div>
        <div class="row-100">
          <div class="row-50">
            <input type="text" placeholder="Número*" required name="NUMERO_CASA">
            <input type="text" placeholder="Complemento" required name="COMPLEMENTO">
          </div>
          <div class="row-50">
            <input type="text" placeholder="País*" value="BRASIL" required name="PAIS">
          </div>
        </div>
      </div>

      <!-- Agencia onde compra suas Viagens -->
      <h2> AGÊNCIA ONDE COMPRA SUAS VIAGENS </h2>
      <div class="column-100">
        <div class="row-100">
          <input type="text" placeholder="Agência" required name="AGENCIA">
          <input type="text" placeholder="Atendente" required name="ATENDENTE">
        </div>
        <div class="row-100">
          <input type="email" placeholder="E-mail do Atendente" required name="EMAIL_ADDRESS_ATENDENTE">
          <input type="text" placeholder="Complemento" required name="COMPLEMENTO_ATENDENTE">
        </div>
        <div class="row-100">
          <input type="text" placeholder="E-mail do Atendente" required name="EMAIL_ADDRESS_ATENDENTE2">
        </div>
      </div>


      <!-- Como conheceu  -->
      <h2> COMO CONHECEU A QUEENSBERRY? </h2>
      <div class="row-100 cluster">
        <div>
          <div>
            <input name="COMO_CONHECEU" id="agentesViagens" type="radio" value="Agentes de Viagens">
            <label for="agentesViagens">Agentes de Viagens</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" id="jornal" type="radio" value="Jornal">
            <label for="jornal">Jornal</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" id="siteQtravel" type="radio" value="Site Q Travel">
            <label for="siteQtravel">Site Q Travel</label>
          </div>
        </div>
        <div>
          <div>
            <input name="COMO_CONHECEU" id="amigos" type="radio" value="Amigos">
            <label for="amigos">Amigos</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" id="maladireta" type="radio" value="Mala-Direta">
            <label for="maladireta">Mala Direta</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" id="website" type="radio" value="Web-Site">
            <label for="website">Web Site</label>
          </div>
        </div>
        <div>
          <div>
            <input name="COMO_CONHECEU" id="familiares" type="radio" value="Familiares">
            <label for="familiares">Familiares</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" type="radio" id="revistaQtravelexp" value="Revista-Q-Travel-Experiences">
            <label for="revistaQtravelexp">Revista Q Travel Experiences</label>
          </div>
          <div>
            <input name="COMO_CONHECEU" id="outros" type="radio" value="Outros">
            <label for="outros">Outros</label>
          </div>
        </div>
      </div>
      <!-- Com que frequência você viaja ao exterior? -->
      <h2> Com que frequência você viaja ao exterior? </h2>
      <div class="row-100 cluster">
        <div>
          <div>
            <input name="FREQUENCIA_VIAJA" id="umavez" type="radio" value="Uma vez por ano">
            <label for="umavez">Uma vez por ano</label>
          </div>
          <div>
            <input name="FREQUENCIA_VIAJA" type="radio" id="maisdeduas" value="Mais de duas vezes ao ano">
            <label for="maisdeduas">Mais de duas vezes ao ano</label>
          </div>
        </div>
        <div>
          <div>
            <input name="FREQUENCIA_VIAJA" type="radio" id="duasvezes" value="Duas vezes ao ano">
            <label for="duasvezes">Duas vezes ao ano</label>
          </div>
          <div>
            <input name="FREQUENCIA_VIAJA" type="radio" id="umavezcadadoisanos" value="Uma vez a cada dois anos">
            <label for="umavezcadadoisanos">Uma vez a cada dois anos</label>
          </div>
        </div>
      </div>
      <!-- Costuma viajar em qual época do ano? -->
      <h2> Costuma viajar em qual época do ano? </h2>
      <div class="row-100 cluster">
        <div>
          <div>
            <input name="EPOCA_VIAGEM" type="checkbox" id="janmar" value="Janeiro - Março">
            <label for="janmar">Janeiro - Março</label>
          </div>
          <div>
            <input name="EPOCA_VIAGEM" type="checkbox" id="jul" value="Julho">
            <label for="jul">Julho</label>
          </div>
          <div>
            <input name="EPOCA_VIAGEM" type="checkbox" id="reveillon" value="Réveillon">
            <label for="reveillon">Réveillon</label>
          </div>
        </div>
        <div>
          <div>
            <input name="EPOCA_VIAGEM" type="checkbox" id="abrjun" value="Abril - Junho">
            <label for="abrjun">Abril - Junho</label>
          </div>
          <div>
            <input name="EPOCA_VIAGEM" type="checkbox" id="agonov" value="Agosto - Novembro">
            <label for="agonov">Agosto - Novembro</label>
          </div>
        </div>
      </div>
      <!--  Você tem algum interesse pelas seguintes áreas?  -->
      <div>
        <h2> Você tem algum interesse pelas seguintes áreas?
          <br> Caso positivo, marque em quais:
        </h2>
      </div>
      <div class="row-100 cluster">
        <div>
          <div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxcru" value="Cruzeiros marítimos ou fluviais">
              <label for="chkboxcru">Cruzeiros marítimos ou fluviais</label>
            </div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxgas" value="Gastronomia">
              <label for="chkboxgas">Gastronomia</label>
            </div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxciv" value="Civilizações Antigas">
              <label for="chkboxciv">Civilizações Antigas</label>
            </div>
          </div>
          <div class="margin"></div>
        </div>
        <div>
          <div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxgol" value="Golfe">
              <label for="chkboxgol">Golfe</label>
            </div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxvin" value="Vinhos e Vinícolas">
              <label for="chkboxvin">Vinhos e Vinícolas</label>
            </div>
            <div>
              <input name="INTERESSE_AREA" type="checkbox" id="chkboxexo" value="Destinos Exóticos">
              <label for="chkboxexo">Destinos Exóticos</label>
            </div>
          </div>
        </div>
        <div>
          <div>
            <input name="INTERESSE_AREA" type="checkbox" id="chkboxpra" value="Praia e Mar">
            <label for="chkboxpra">Praia e Mar</label>
          </div>

          <div>
            <input name="INTERESSE_AREA" type="checkbox" id="chkboxhis" value="História da Arte">
            <label for="chkboxhis">História da Arte</label>
          </div>
          <div>
            <input name="INTERESSE_AREA" type="checkbox" id="chkboxtrem" value="Trens">
            <label for="chkboxtrem">Trens</label>
          </div>
        </div>
      </div>
      <div>
        <div>
          <input name="outroCheck" type="checkbox" id="outroCheck" value="Outros">
          <label for="outroCheck">Outros</label>
        </div>
        <div>
          <input name="Outros" type="text" maxlength="40" value="">
        </div>
      </div>

      <!--  -->

      <div class="aceito">
        <input type="checkbox" @change="isEmailPermissionChecked = !isEmailPermissionChecked" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
        <label for="RECEBER_COMUNICACOES">Aceito receber comunicações e
          informações da Queensberry</label>

      </div>

      <div class="submit-area">
        <button class="submit-btn">Cadastrar</button>
      </div>
    </form>

    <script>
      // SCRIPT PARA CARREGAR ESTADOS E CIDADES
      document.addEventListener("DOMContentLoaded", function() {
        const estadoSelect = document.getElementById("ESTADO");
        const cidadeSelect = document.getElementById("CIDADE");

        // Carregar estados na lista
        fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados")
          .then(response => response.json())
          .then(estados => {
            estados.sort((a, b) => a.nome.localeCompare(b.nome));
            estados.forEach(estado => {
              const option = document.createElement("option");
              option.value = estado.sigla;
              option.textContent = estado.nome;
              estadoSelect.appendChild(option);
            });
          });

        // Evento para carregar cidades ao selecionar estado
        estadoSelect.addEventListener("change", function() {
          const uf = estadoSelect.value;
          cidadeSelect.innerHTML = '<option value="">Carregando...</option>';

          if (uf) {
            fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
              .then(response => response.json())
              .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                cidades.forEach(cidade => {
                  const option = document.createElement("option");
                  option.value = cidade.nome;
                  option.textContent = cidade.nome;
                  cidadeSelect.appendChild(option);
                });
              });
          } else {
            cidadeSelect.innerHTML = '<option value="">Cidade</option>';
          }
        });
      });
    </script>
    <script>
      // SCRIPT PARA AUTOCOMPLETAR ENDEREÇO PELO CEP
      document.addEventListener("DOMContentLoaded", function() {
        const cepInput = document.getElementById("CEP");
        const bairroInput = document.getElementById("BAIRRO_AGENCIA");
        const ruaInput = document.getElementById("RUA_AGENCIA");
        const estadoSelect = document.getElementById("ESTADO");
        const cidadeSelect = document.getElementById("CIDADE");

        // Função para limpar os campos de endereço
        function limparCampos() {
          bairroInput.value = "";
          ruaInput.value = "";
          estadoSelect.value = "";
          cidadeSelect.innerHTML = '<option value="">Selecione a Cidade</option>';
        }

        // Função para buscar dados do CEP
        function buscarCEP(cep) {
          const cepFormatado = cep.replace(/\D/g, '');
          if (cepFormatado.length === 8) {
            fetch(`https://viacep.com.br/ws/${cepFormatado}/json/`)
              .then(response => response.json())
              .then(dados => {
                if (!("erro" in dados)) {
                  bairroInput.value = dados.bairro;
                  ruaInput.value = dados.logradouro;

                  const estado = dados.uf;
                  estadoSelect.value = estado;
                  const evento = new Event('change');
                  estadoSelect.dispatchEvent(evento);

                  setTimeout(() => {
                    cidadeSelect.value = dados.localidade;
                  }, 1000);
                } else {
                  alert("CEP não encontrado.");
                  limparCampos();
                }
              })
              .catch(() => {
                alert("Erro ao buscar CEP.");
                limparCampos();
              });
          } else {
            limparCampos();
          }
        }

        // Evento ao sair do campo de CEP
        cepInput.addEventListener("blur", function() {
          buscarCEP(cepInput.value);
        });

        // Evento para verificar se o campo de CEP está vazio
        cepInput.addEventListener("input", function() {
          if (cepInput.value.trim() === "") {
            limparCampos();
          }
        });
      });
    </script>
    <script>
      $(document).ready(() => {

        var formData = new FormData($("#m_f_queensberry_cadastro_adin")[0]); // Use FormData para incluir anexos

        $("#celular").mask("(00) 00000-0000");

        $("#celular").on("blur", () => {
          let nationalCelNumber = $("#celular").val();
          let cleanNumber = nationalCelNumber.replace(/\D/g, "");
          let fullNumber = `55${cleanNumber}`;
          $("#fullPhoneNumber").val(fullNumber);
        })

        $("#m_f_queensberry_cadastro_adin").on("submit", (e) => {
          e.preventDefault();

          let nationalCelNumber = $("#celular").val();
          let cleanNumber = nationalCelNumber.replace(/\D/g, "");
          let fullNumber = `55${cleanNumber}`;
          $("#fullPhoneNumber").val(fullNumber);

          grecaptcha.ready(function() {
            grecaptcha.execute('6LfF5yArAAAAAF7g7tpSGhzeicUlwwQH6mDxEV6y', {
              action: 'submit'
            }).then(function(token) {
              console.log(token);
              jQuery.post(
                "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha", {
                  "g-recaptcha-response": token
                }
              ).done((res) => {
                jQuery("#actionField").val("queensberry_fale_conosco");
                if (res.data.message === "OK") {
                  $("#actionField").val("queensberry_queensclub");
                  jQuery.post(
                    "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_queensclub",
                    $("#m_f_queensberry_cadastro_adin").serialize(),
                    function(data) {
                      console.log(data);
                      alert("Envio realizado com sucesso");
                    }
                  )
                } else {
                  console.log("Recaptcha error")
                }
              })
            });
          });


        });
      });
    </script>

    <script>
      /*Script para verificar se o usuario
      marcou o aceite de recebimento de e-mails ou nao (opt-in/opt-out)*/
      $(function($) { // on DOM ready (when the DOM is finished loading)
        $('#agree').click(function() { // when the checkbox is clicked
          var checked = $('#agree').is(':checked'); // check the state
          $('#optIn').val(checked ? "I" : "O"); // set the value
          $('#optInSMS').val(checked ? "I" : "O"); // set the value

        });
        $('#optIn').triggerHandler("click"); // initialize the value
        $('#optInSMS').triggerHandler("click"); // initialize the value
      });
    </script>
    <script>
      $(function getURL() {
        var url_cadastro = window.location.href;
        document.getElementById('URL_CADASTRO').value = url_cadastro;
      });
    </script>

    <style>
      #m_f_queensberry_cadastro_adin {
        display: flex;
        flex-direction: column;
      }

      #m_f_queensberry_cadastro_adin h2 {
        font-size: 22px;
      }

      .title {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }

      .title p {
        font-family: "Montserrat", sans-serif;
        font-weight: 400;
        font-size: 12px;
      }

      #m_f_queensberry_cadastro_adin {
        display: flex;
        flex-direction: column;
      }

      #m_f_queensberry_cadastro_adin .column-100 {
        display: flex;
        flex-direction: column;
        margin-bottom: 31px;
      }

      #m_f_queensberry_cadastro_adin .row-100 {
        display: flex;
        flex-direction: row;
        column-gap: 104px;
        width: 100%;
        margin-top: 31px;
      }

      #m_f_queensberry_cadastro_adin .margin {
        margin-bottom: 31px;
      }

      #m_f_queensberry_cadastro_adin .cluster div div {
        margin-bottom: 15px;
      }

      #m_f_queensberry_cadastro_adin .row-50 {
        display: flex;
        flex-direction: row;
        gap: 32px;
        width: 50%;
      }

      #m_f_queensberry_cadastro_adin h2,
      h3 {
        color: #04004f;
        font-family: "Tenor Sans", sans-serif;
        font-weight: 400;
        font-size: 23px;
        line-height: 28px;
        letter-spacing: -1px;
        text-transform: uppercase;
        margin: 0;
        margin-top: 31px;
      }

      #m_f_queensberry_cadastro_adin .aceito {
        margin-top: 31px;
        margin-bottom: 31px;
      }

      #m_f_queensberry_cadastro_adin h3 {
        margin-bottom: 31px;
      }

      #m_f_queensberry_cadastro_adin input,
      select {
        border: none;
        border-bottom: 1px solid #E5E9EF;
        border-radius: 0;
        width: 100%;
        font-family: "Montserrat", sans-serif;
        padding: 6px 2px;
        outline: none;
      }

      #m_f_queensberry_cadastro_adin input:focus,
      select:focus {
        border-bottom: 1px solid #04004f;
      }

      #m_f_queensberry_cadastro_adin input::placeholder,
      select::placeholder,
      select {
        font-size: 14px;
        font-family: "Montserrat", sans-serif;
        font-weight: 400;

      }

      #m_f_queensberry_cadastro_adin hr {
        fill: #9ad128;
        color: #9ad128;
        background-color: #9ad128;
        height: 3px;
      }


      #m_f_queensberry_cadastro_adin button:hover {
        background-color: #04004f;
        color: #ffffff;
      }

      #m_f_queensberry_cadastro_adin input[type="radio"] {
        display: none;
        /* Oculta o input padrão */
      }

      #m_f_queensberry_cadastro_adin input[type="radio"]+label {
        position: relative;
        padding-left: 30px;
        /* Espaço para o círculo */
        cursor: pointer;
        font-size: 12px;
      }

      #m_f_queensberry_cadastro_adin input[type="radio"]+label::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        border-radius: 50%;
        border: 2px solid #999;
        /* Cor da borda quando não está selecionado */
        background: transparent;
        transition: all 0.3s ease;
      }

      #m_f_queensberry_cadastro_adin input[type="radio"]:checked+label::before {
        background: #9ad128;
        /* Cor ao selecionar */
        border-color: #9ad128;
      }

      [type="radio"]:checked+label:before {
        background: #9ad128;
      }

      #m_f_queensberry_cadastro_adin input[type="radio"]+label::after {
        content: "";
        position: absolute;
        left: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background: #9ad128;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      #m_f_queensberry_cadastro_adin input[type="radio"]:checked+label::after {
        opacity: 1;
      }

      /* Oculta o checkbox padrão */
      #m_f_queensberry_cadastro_adin input[type="checkbox"] {
        display: none;
      }

      /* Estiliza o label para posicionamento correto */
      #m_f_queensberry_cadastro_adin input[type="checkbox"]+label {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
        font-size: 12px;
        color: #333;
      }

      /* Caixa do checkbox antes de ser clicado */
      #m_f_queensberry_cadastro_adin input[type="checkbox"]+label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        border: 2px solid #d7dfe4;
        /* Cor da borda padrão */
        border-radius: 4px;
        background: #fff;
        transition: all 0.2s ease;
      }

      /* Marca interna do checkbox (inicialmente invisível) */
      #m_f_queensberry_cadastro_adin input[type="checkbox"]+label::after {
        content: '';
        position: absolute;
        width: 6px;
        height: 6px;
        background: white;
        top: 50%;
        left: 6px;
        transform: translateY(-50%);
        border-radius: 2px;
        opacity: 0;
        transition: all 0.2s ease;
      }

      /* Mudança ao selecionar o checkbox */
      #m_f_queensberry_cadastro_adin input[type="checkbox"]:checked+label::before {
        background: #9ad128;
        /* Verde ao selecionar */
        border-color: #9ad128;
      }

      /* Exibir a marca branca dentro do checkbox ao selecionar */
      #m_f_queensberry_cadastro_adin input[type="checkbox"]:checked+label::after {
        opacity: 1;
      }






      @media screen and (max-width: 1024px) {
        .title {
          display: flex;
          flex-direction: column-reverse;
          gap: 12px;
          justify-content: space-between;
        }

        .title p {
          font-family: "Montserrat", sans-serif;
          font-weight: 400;
          font-size: 12px;
          text-align: end;
        }


        #m_f_queensberry_cadastro_adin .row-100 {
          display: flex;
          flex-direction: column;
          gap: 31px;
          width: 100%;
        }

        #m_f_queensberry_cadastro_adin .row-50 {
          display: flex;
          flex-direction: column;
          gap: 31px;
          width: 100%;
        }

        #m_f_queensberry_cadastro_adin input[type="submit"] {
          background-color: #280071;
          border: none;
          border-radius: 5px;
          text-transform: uppercase;
          width: 100%;
          padding: 16px;
          color: #ffffff;
          font-family: "Montserrat", sans-serif;
          font-weight: 700;
          font-size: 12px;
          margin-top: 32px;
        }

        #agentes-container button {
          background-color: #280071;
          width: 60%;
          border: none;
          border-radius: 5px;
          text-transform: uppercase;
          padding: 16px;
          color: #ffffff;
          font-family: "Montserrat", sans-serif;
          font-weight: 700;
          font-size: 12px;
        }
      }
    </style>
  </section>
</main>

<?php get_footer(); ?>