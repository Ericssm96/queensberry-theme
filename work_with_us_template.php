<?php 
/*
    Template Name: Trabalhe Conosco Template
*/
get_header(); ?>

<main>
    <div class="shaded-overlay"></div>
    <header class="banner">
      <h1>Trabalhe <br> Conosco</h1>
    </header>
    <section class="form-area">
      <div class="wrapper">
        <article class="contact-info">
          <strong>Queensberry São Paulo</strong>
          <p>¹¹ 3217-7100</p>
        </article>
        <form class="work-with-us-form" id="queensberry_trabalhe_conosco" name="queensberry_trabalhe_conosco" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="actionField" name="action" value="queensberry_verify_recaptcha">
      
          <input type="text" placeholder="Nome*" required name="FIRST_NAME">
          <input type="email" placeholder="E-mail*" required name="EMAIL_ADDRESS_">
          <input type="text" placeholder="Telefone()*" required maxlength="15" name="MOBILE_NUMBER_" id="celular">
          <input type="text" placeholder="Cargo Pretendido*" required name="CARGO">
          <input type="file" required name="CURRICULO">
      
          <div class="checkbox-area">
            <span class="custom-checkbox">
              <input type="checkbox" value="Sim" name="RECEBER_COMUNICACOES" id="RECEBER_COMUNICACOES">
              <label for="RECEBER_COMUNICACOES" class="checkmark"></label>
            </span>
            <label for="RECEBER_COMUNICACOES" class="text-label">Aceito receber comunicações e informações da Queensberry</label>
          </div>
      
          <div class="submit-area">
            <div class="recaptcha-box">
              <!-- <div class="g-recaptcha" data-sitekey="6Lfq8_sqAAAAAAKKFvBPoQyDNvYJEcf5JRrffil3"></div> -->
               <div id="recaptcha-box-2"></div>
            </div>
            <button class="submit-btn" type="submit">Enviar</button>
          </div>
        </form>

        <script>
            /* $(document).ready(() => {
                $("#celular").mask("(00) 00000-0000");
        
                $("#queensberry_trabalhe_conosco").on("submit", function (e) {
                    e.preventDefault();

        
                    var formData = new FormData(this); // Criar FormData DENTRO do evento submit
                    let captchaResponse = grecaptcha.getResponse();

                    if(captchaResponse.length <= 0) {
                      alert("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.")

                      throw new Error("Erro ao confirmar a resposta do reCaptcha. Se o erro persistir, recarregue a página e tente novamente.");
                    } else {
                      jQuery.post(
                        "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_verify_recaptcha",
                        // formData,
                        $("#queensberry_trabalhe_conosco").serialize(),
                        function(res) {      
                          console.log(res);
                          if(res.data.message === "OK") {
                            formData.set("action", "queensberry_trabalhe_conosco");
                            $("#actionField").val("queensberry_trabalhe_conosco");
                            $.ajax({
                              url: "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_trabalhe_conosco",
                              type: "POST",
                              data: formData,
                              // data: $("#queensberry_trabalhe_conosco").serialize(),
                              processData: false, // Não processar os dados
                              contentType: false, // Não definir contentType
                              success: function (response) {
                                  console.log(response);
                                  // window.location.replace("<?= home_url(); ?>/obrigado/");
                                  alert("Envio realizado com sucesso");
                              },
                              error: function (xhr, status, error) {
                                  console.error("Erro ao enviar:", error);
                              }
                            });
                          }
                        }
                      )
                      .fail((res)=>{
                        console.log("Recaptcha verification fail");
                      })
                    }
        
                    
                });
            }); */

            $(document).ready(() => {
                $("#celular").mask("(00) 00000-0000");
        
                $("#queensberry_trabalhe_conosco").on("submit", function (e) {
                    e.preventDefault();

        
                    var formData = new FormData(this); // Criar FormData DENTRO do evento submit
                    
                    formData.set("action", "queensberry_trabalhe_conosco");
                    $("#actionField").val("queensberry_trabalhe_conosco");
                    $.ajax({
                      url: "<?= home_url(); ?>/wp-admin/admin-post.php?action=queensberry_trabalhe_conosco",
                      type: "POST",
                      data: formData,
                      // data: $("#queensberry_trabalhe_conosco").serialize(),
                      processData: false, // Não processar os dados
                      contentType: false, // Não definir contentType
                      success: function (response) {
                          console.log(response);
                          // window.location.replace("<?= home_url(); ?>/obrigado/");
                          alert("Envio realizado com sucesso");
                      },
                      error: function (xhr, status, error) {
                          console.error("Erro ao enviar:", error);
                      }
                    });
        
                    
                });
            });
        </script>
      </div>
    </section>
  </main>

<?php get_footer(); ?>