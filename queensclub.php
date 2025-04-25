<?php
/*
    Template Name: Queens club Template
*/
get_header(); ?>

<main>
  <header class="banner">
    <h1>Queens Club</h1>
  </header>
  <article class="introduction-cards">
    <div class="wrapper">
      <div class="card">
        <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic1.png" alt="">
        <p class="card-text">Embarque em uma viagem GBM - Grupos Brasileiros no Mundo</p>
      </div>
      <div class="separator">
        <i class="fa-solid fa-chevron-down mb-separator"></i>
        <i class="fa-solid fa-chevron-right lg-separator"></i>
      </div>
      <div class="card">
        <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic2.png" alt="">
        <p class="card-text">Cadastre-se no Queens Club</p>
      </div>
      <div class="separator">
        <i class="fa-solid fa-chevron-down mb-separator"></i>
        <i class="fa-solid fa-chevron-right lg-separator"></i>
      </div>
      <div class="card">
        <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic3.png" alt="">
        <p class="card-text">Acumule pontos a cada viagem</p>
      </div>
      <div class="separator">
        <i class="fa-solid fa-chevron-down mb-separator"></i>
        <i class="fa-solid fa-chevron-right lg-separator"></i>
      </div>
      <div class="card">
        <img class="card-icon" src="<?= get_template_directory_uri(); ?>/src/img/qclb-ic4.png" alt="">
        <p class="card-text">Troque por descontos progressivos em seus futuros embarques</p>
      </div>
    </div>
  </article>
  <article class="first-cta-area">
    <div class="wrapper">
      <div class="content-area">
        <strong>JÁ SÃO MAIS DE 13 MIL CLIENTES CADASTRADOS. FAÇA PARTE VOCÊ TAMBÉM DESTE CLUBE EXCLUSIVO.</strong>
        <a href="<?= home_url() ?>/queensclub-cadastro" class="btn">Cadastre-se</a>
      </div>
      <div class="img-area">
        <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-IMAGEM1.jpg" alt="Casal sorrindo no meio da árvores">
      </div>
    </div>
  </article>
  <article class="second-cta-area">
    <div class="wrapper">
      <div class="img-area">
        <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-IMAGEM2.jpg" alt="Casal remando um um caiaque.">
      </div>
      <div class="content-area">
        <strong>ACUMULE PONTOS A CADA VIAGEM E TROQUE POR DESCONTOS PROGRESSIVOS EM SEUS FUTUROS EMBARQUES.</strong>
        <a href="<?= get_template_directory_uri(); ?>/src/doc/REGULAMENTO_QC_2023_24.pdf" target="_blank" class="btn">
          Veja o regulamento
        </a>

      </div>
    </div>
  </article>
  <article class="points-cta">
    <div class="overlay"></div>
    <div class="wrapper">
      <strong>Quem já viajou possui pontos acumulados. <br> Quanto mais você viajar, mais você vai ganhar.</strong>
      <button class="btn button" onclick="abrirModal()">Consulte seus pontos</button>
    </div>
  </article>
  <section class="testimonials" x-data="{
    gallerySwiper: new Swiper('.testimonials .swiper', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,
      shortSwipes: true,
      breakpoints: {
        1: {
          slidesPerView: 1,
          spaceBetween: 0
        },
        768: {
          navigation: {
            nextEl: '.testimonials .swiper-button-next',
            prevEl: '.testimonials .swiper-button-prev',
          },
          pagination: {
            el: '.testimonials .swiper-pagination',
            clickable: true
          }
        }
      }
    }),
  }">
    <div class="wrapper swiper">
      <h2>Depoimentos</h2>
      <div class="swiper-wrapper slider-presentation">
        <div class="swiper-slide">
          <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide1.jpg" alt="Egito e Dubai e seus contrastes">
          <div class="text">
            <blockquote>Excelente excursão. Ótimo grupo de participantes. Alegre, unido e agradável. Parabéns aos guias. Parabéns à Queensberry.</blockquote>
            <div class="quote-info">
              <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
              <p>G.G. - São Paulo - SP</p>
              <p>Fevereiro/2022</p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide2.jpg" alt="Egito e Dubai e seus contrastes">
          <div class="text">
            <blockquote>Viagem ótima! O nosso guia foi muito bom durante todo o percurso. O grupo foi muito unido! Obrigada e até a próxima viagem!</blockquote>
            <div class="quote-info">
              <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
              <p>D.S. – Guaratinguetá – SP</p>
              <p>Fevereiro/2022</p>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <img src="<?= get_template_directory_uri(); ?>/src/img/qclb-slide3.jpg" alt="Egito e Dubai e seus contrastes">
          <div class="text">
            <blockquote>Fazer esta viagem foi realizar o sonho de uma vida. Conhecer o Egito foi mágico! O grupo de pessoas que conheci foi muito especial. Vou levar muitas lembranças deste convívio tão alegre e festivo.</blockquote>
            <div class="quote-info">
              <strong>Roteiro: Egito e Dubai e seus contrastes</strong>
              <p>M.B.C.P. – Volta Redonda – RJ</p>
              <p>Fevereiro/2022</p>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>

</main>

<!-- Modal -->
<div id="modalPontos" class="modal-lightbox fade d-none">
  <div class="modal-aberto">
    <div class="modal-conteudo">
      <div class="modal-header">
        <h5 class="modal-title">QueensClub - Consulta de Pontuação</h5>
        <button type="button" class="close" onclick="fecharModal()" aria-label="Fechar">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input name="cpf" id="paxCpf" class="form-control" placeholder="Informe seu CPF">
          <div id="pontuacaoSection"></div>

          <div class="text-center d-none loading-queensberry" id="buscarPontuacaoLoading">
            <div class="spinner-border text-dark" role="status">
              <span class="sr-only">Buscando pontuação do Passageiro...</span>
            </div>
            Buscando pontuação do Passageiro ...
          </div>

          <span class="text-danger d-none" id="errorMessage"></span> <br>

          <a id="buscarPontuacao" class="btn-queensberry" onclick="buscarPontuacao()">BUSCAR</a>
          <a id="resetarFormulario" class="btn-queensberry d-none" onclick="resetarFormulario()">VOLTAR</a>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .modal-lightbox {
    padding: 3em 0em;
    position: fixed;
    top: 30px;
    /* Adicionado o espaçamento de 30px do topo */
    left: 0;
    z-index: 1050;
    width: 100%;
    height: 100%;
    outline: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-aberto {
    width: 500px;
    height: 256px;
    display: flex;
    flex-direction: column;
    align-self: flex-start;
  }


  .modal-open .modal-lightbox {
    overflow-x: hidden;
    overflow-y: auto;
  }

  .fade {
    transition: opacity .15s linear;
  }

  @media screen and (max-width: 576px) {
    .modal-aberto {
      width: 90%;
      height: auto;
    }
  }

  .modal-lightbox.fade .modal-aberto {
    transition: transform .3s ease-out, -webkit-transform .3s ease-out;
  }

  .modal-lightbox.show .modal-aberto {
    transform: none;
  }

  .modal-conteudo {
    position: relative;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    outline: 0;
  }

  .modal-header {
    border-bottom-color: #EEEEEE;
    background-color: #FAFAFA;
  }

  .modal-header {
    display: flex;
    -ms-flex-align: start;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: .3rem;
    border-top-right-radius: .3rem;
  }

  .modal-header {
    padding: 20px;
  }


  .modal-title {
    margin-bottom: 0;
    color: #212529;
    font-weight: 700;
    font-size: 18px;
    font-family: "Roboto", sans-serif;
  }

  .modal-header .close {
    padding: 1rem 1rem;
  }

  [type=button]:not(:disabled),
  [type=reset]:not(:disabled),
  [type=submit]:not(:disabled),
  button:not(:disabled) {
    cursor: pointer;
  }

  button.close {
    padding: 0;
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
  }

  .close {
    float: right;
    font-size: 22px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
  }

  .modal-body {
    position: relative;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 20px;
  }

  .modal-body {
    padding: 20px;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
  }

  .form-group {
    justify-content: space-around;
    flex-direction: column;
    display: flex;
    margin-bottom: 1rem;
  }

  .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
  }

  .form-control {
    border: none;
    background-image: none;
    background-color: transparent;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
    outline: none;
    outline-color: none;
    font-size: 1.4em;
    border-bottom: 1px solid #e5e9ef;
    height: 30px;
    padding: 2px 2px;
    border-radius: 0;
  }

  #pontuacaoSection {
    margin-top: 20px;
    font-size: 1.4em;
  }

  .loading-queensberry {
    padding-right: 40px;
    margin-top: 15px;
    font-size: 1.4em;
    font-weight: bold;
    color: #99d02c;
  }

  .loading-queensberry .spinner-border {
    width: 15px;
    height: 15px;
    margin-right: 10px;
    color: #04004d !important;
  }

  .text-dark {
    color: #343a40 !important;
  }

  .spinner-border {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: text-bottom;
    border: .25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .75s linear infinite;
    animation: spinner-border .75s linear infinite;
  }

  .sr-only {
    border: 0;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  .text-danger {
    color: #dc3545 !important;
  }

  .d-none {
    display: none !important;
  }

  #pontuacaoModal .btn-queensberry {
    width: 140px;
    margin: 0 auto;
    margin-top: 30px;
  }

  a:not([href]):not([tabindex]) {
    color: inherit;
    text-decoration: none;
  }

  a.btn-queensberry {
    height: 50px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2em;
    font-weight: bold;
    color: #0c0150 !important;
    cursor: pointer;
    text-decoration: none !important;
  }

  .btn-queensberry {
    height: 50px;
    width: 100%;
    color: #0c0150;
    background-color: #99d02c;
    border-radius: 5px;
    text-transform: uppercase;
  }

  #pontuacaoModal .btn-queensberry {
    width: 140px;
    margin: 0 auto;
    margin-top: 30px;
  }

  a:not([href]):not([tabindex]) {
    color: inherit;
    text-decoration: none;
  }

  a.btn-queensberry {
    height: 50px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.2em;
    font-weight: bold;
    color: #0c0150 !important;
    cursor: pointer;
    text-decoration: none !important;
  }

  .btn-queensberry {
    height: 50px;
    width: 100%;
    color: #0c0150;
    background-color: #99d02c;
    border-radius: 5px;
    text-transform: uppercase;
  }

  .modal-lightbox {
    background-color: rgba(0, 0, 0, 0.5);
    /* overlay escuro */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-lightbox.d-none {
    display: none !important;
  }

  .inner-points {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .inner-points strong {
    font-weight: 500;
    font-family: "Roboto", sans-serif;
  }

  .inner-text {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: center;
    text-align: center;
    font-size: 14px;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
  }

  .inner-text h2 {
    font-weight: 500;
    font-family: "Roboto", sans-serif;
    font-size: 25px;
  }

  .inner-text strong {
    font-weight: 500;
    font-family: "Roboto", sans-serif;
  }
</style>

<script>
  function abrirModal() {
    const modal = document.getElementById("modalPontos");
    modal.classList.remove("d-none");
    modal.classList.add("show");
    document.body.classList.add("modal-open");
  }

  function fecharModal() {
    const modal = document.getElementById("modalPontos");
    modal.classList.add("d-none");
    modal.classList.remove("show");
    document.body.classList.remove("modal-open");
  }
</script>

<script>
  function buscarPontuacao() {
    const cpfInput = document.getElementById('paxCpf');
    const cpf = cpfInput.value.replace(/\D/g, '');
    const pontuacaoSection = document.getElementById('pontuacaoSection');
    const errorMessage = document.getElementById('errorMessage');
    const loading = document.getElementById('buscarPontuacaoLoading');
    const resetButton = document.getElementById('resetarFormulario');
    const buscarButton = document.getElementById('buscarPontuacao');

    if (!cpf) {
      errorMessage.textContent = "Por favor, informe um CPF válido.";
      errorMessage.classList.remove("d-none");
      return;
    }

    errorMessage.classList.add("d-none");
    pontuacaoSection.innerHTML = '';
    loading.classList.remove("d-none");
    buscarButton.classList.add("d-none");

    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=consultar_pontos_qc&cpf=${cpf}`
      })
      .then(res => res.json())
      .then(data => {
        console.log("Resposta da API:", data);
        loading.classList.add("d-none");

        if (
          data.PontosQc &&
          data.PontosQc.PontosQc &&
          data.PontosQc.PontosQc.length > 0
        ) {
          const info = data.PontosQc.PontosQc[0];
          const cpfFormatado = cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");

          pontuacaoSection.innerHTML = `
        <div class="inner-points">
        <p><strong>CPF:</strong> ${cpfFormatado}</p>
        <p><strong>Passageiro:</strong> ${info.NomePax.trim()}</p>
        <p><strong>Cartão QueensClub:</strong> ${info.CartaoQc}</p>
        <p><strong>Pontos:</strong> ${info.QcTotalPontos}</p>
        <p><strong>Descontos:</strong> ${info.QcPercDscCalculado}%</p>
        </div>
        <br>
        <div class="inner-text">
        <h2>Importante:</h2>
        
          <p>Pontuação mínima para obter desconto: 1.500 pontos</p>
          <p>Atualização da pontuação: após 30 dias do embarque.</p>
       
        <p><strong>Resgate válido para embarques a partir de <strong>dezembro de 2023</strong>,<br>
        limitado e sujeito à disponibilidade no tour.</strong></p>
        <div>
      `;

          resetButton.classList.remove("d-none");
        } else {
          errorMessage.textContent = "CPF não encontrado ou sem pontos.";
          errorMessage.classList.remove("d-none");
        }
      })
      .catch(() => {
        loading.classList.add("d-none");
        errorMessage.textContent = "Erro ao consultar. Tente novamente.";
        errorMessage.classList.remove("d-none");
      });
  }

  function resetarFormulario() {
    document.getElementById('paxCpf').value = '';
    document.getElementById('pontuacaoSection').innerHTML = '';
    document.getElementById('errorMessage').classList.add("d-none");
    document.getElementById('resetarFormulario').classList.add("d-none");
    document.getElementById('buscarPontuacao').classList.remove("d-none");
  }
</script>

<?php get_footer(); ?>