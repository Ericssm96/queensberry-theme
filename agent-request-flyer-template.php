<?php
/*
    Template Name: Sol. Folheto (Agente)
*/

get_header();
?>


<main>
  <header class="banner">
      <div class="title-area">
      <h1>Folhetos & Cadernos</h1>
      <strong>Solicitar</strong>
      </div>
  </header>
  <section class="form-area">
      <div class="wrapper">
      <form id="solicitar_folheto_agente" action="/">
        <input type="hidden" name="action" id="actionField" value="queensberry_verify_recaptcha">
          <h2>Dados da Agência</h2>
          <div class="grid-two-cols">
          <div class="input-area first-col">
              <input type="text" name="CNPJ" placeholder="CNPJ*">
          </div>
          <div class="input-area second-col">
              <input type="text" name="RAZAO_SOCIAL" placeholder="Razão Social*">
          </div>
          <div class="input-area first-col">
              <input type="text" name="NOME_FANTASIA" placeholder="Nome Fantasia">
          </div>
          <div class="input-area second-col">
              <input type="text" name="INSC_EST" placeholder="Inscrição Estadual">
          </div>
          <div class="input-area first-col">
              <input type="text" name="CADASTUR" placeholder="Cadastur">
          </div>
          <div class="input-area second-col">
              <input type="text" name="AGENT_NAME" placeholder="Nome do Agente*">
          </div>
          <div class="input-area first-col">
              <input type="text" name="TELEFONE" placeholder="Telefone (DDD + Número)">
          </div>
          <div class="input-area second-col">
              <input type="email" name="EMAIL_AGENCIA" placeholder="E-mail">
          </div>
          <div class="input-area first-col">
              <input type="text" name="PAGINA_WEB" placeholder="Página Web">
          </div>
          </div>
          <hr color="#99D02C" class="divider">
          <h2>Endereço</h2>
          <div class="grid-two-cols">
          <div class="input-area first-col">
              <input type="text" name="CEP" placeholder="CEP*">
          </div>
          <div class="input-area second-col">
              <input type="text" name="BAIRRO" placeholder="Bairro">
          </div>
          </div>
          <div class="grid-one-col">
          <div class="input-area first-col">
              <input type="text" name="RUA" placeholder="Rua/Av.*">
          </div>
          </div>
          <div class="grid-four-cols">
          <div class="input-area first-col">
              <input type="text" name="NUMERO" placeholder="Número">
          </div>
          <div class="input-area second-col">
              <input type="text" name="COMPLEMENTO" placeholder="Complemento">
          </div>
          <div class="input-area third-col">
              <input type="text" name="CIDADE" placeholder="Cidade">
          </div>
          <div class="input-area fourth-col">
              <input type="text" name="ESTADO" placeholder="Estado">
          </div>
          </div>
          <hr color="#99D02C" class="divider">
          <h2>Mensagem <span>(Opcional)</span></h2>
          <div class="grid-one-col">
          <div class="input-area first-col">
              <textarea name="MENSAGEM" id="iptMsg" placeholder="Digite sua mensagem"></textarea>
          </div>
          </div>
          <div class="submit-area">
          <button class="submit-btn" type="submit">Solicitar</button>
          </div>
      </form>
      <script>
        $(document).ready(() => {
          $("#solicitar_folheto_agente").on("submit", function(e) {
            e.preventDefault();
            
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
                    
                    $("#actionField").val("queensberry_solicitar_folheto_agente");
                    
                    // Envio para Eloqua
                    $.ajax({
                      type: "POST",
                      url: "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_solicitar_folheto_agente",
                      data: $("#solicitar_folheto_agente").serialize(),
                      success: (res) => {
                        console.log(res);
                        alert('Formulário enviado com sucesso!');
                      },
                      error: (err) => {
                        console.error("Ocorreu um erro:", err);
                        alert('O formulário não foi submetido devido a um erro.');
                      }
                    });
                    

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
      </div>
  </section>
</main>


<?php get_footer(); ?>