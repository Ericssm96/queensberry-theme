<?php 
  $post_id = get_the_ID();
  $api_data = get_post_meta(get_the_ID(), 'api_data', true);

  $product_code = '';
  $tower = '';
  $product_name = '';
  $travel_log_image_directory = '';
  $category_image_directory = '';
  $program_image_directory = '';
  $banner_file_name = '';
  $banner_description = '';
  $visiting_info = '';
  $outings_info = '';
  $nights_in_numbers = '';
  $days_in_numbers = '';
  $weather_info = '';
  $complementary_info = [];
  $gallery_photo_files = [];
  $price_table_files = [];
  $card_info = [];
  $log_card_picture_file = '';
?>

<?php get_header(); ?>

  <main>
    <div class="banner-overlay">
    </div>
    <header class="product-page-banner">
      <div>
        <strong>Férias na Neve</strong>
        <h1>Aspen Snowmass</h1>
        <p>Quatro montanhas, dois encantadores vilarejos e uma experiência memorável.</p>
      </div>
    </header>
    <section class="quick-info">
      <div class="wrapper">
        <div class="info-area">
          <strong>Duração</strong>
          <p>8 dias / 7 noites</p>
        </div>
        <div class="info-area">
          <strong>Visitando</strong>
          <p>Aspen Snowmass, no Colorado, Estados Unidos</p>
        </div>
        <div class="info-area">
          <strong>Saídas</strong>
          <p>Dez ‘2024 a Mar ‘2025</p>
        </div>
        <div class="info-area">
          <strong>Tempo e clima</strong>
          <p>ASPEN</p>
        </div>
      </div>
    </section>

    <section class="general-info">
      <div class="container">
        <div class="itinerary-image-wrapper">
          <img class="itinerary-image" src="./src/img/NEVE002_MAPA_ROTEIRO.jpeg" alt="Imagem Roteiro Viagem">
        </div>

        <article class="info-text" x-data="{
          selectedTab: 'attractions',
        }">
          <ul class="tab-select" id="infoTabs">
            <li @click="selectedTab = 'attractions'" x-bind:class="selectedTab === 'attractions' ? 'selected' : ''"><i class="fa-solid fa-gift"></i> Atrações</li>
            <li @click="selectedTab = 'itinerary'" x-bind:class="selectedTab === 'itinerary' ? 'selected' : ''"><i class="fa-regular fa-calendar"></i> Roteiro</li>
            <li @click="selectedTab = 'services'" x-bind:class="selectedTab === 'services' ? 'selected' : ''"><i class="fa-solid fa-bell-concierge"></i> Serviços</li>
            <li @click="$refs.priceTableModal.showModal()"><i class="fa-solid fa-dollar-sign"></i> Preços</li>
          </ul>
          <div class="details">
            <div class="tab" x-show="selectedTab === 'attractions'">
              <div class="topic">
                <h2>Atrações</h2>
                <p>
                  Localizado no coração das Montanhas Rochosas, Aspen Snowmass é um destino como nenhum outro. Por mais de 75 anos, a natureza, cultura e a recreação se uniram, para proporcionar momentos e experiências inesquecíveis. Venha ver com seus próprios olhos neste inverno!
                  • ASPEN: é muito conhecida pelos seus eventos culturais e gastronômicos e considerada uma das mais elegantes e sofisticadas estações de esqui do mundo. Tem uma mistura charmosa de construções do século 19 e do melhor da arquitetura contemporânea. Sua montanha possui diferentes níveis de dificuldade, mas não é para iniciantes, pois metade das pistas são difíceis e algumas reservadas para experts. Mas ainda assim, é possível esquiar nas vizinhas Snowmass, Aspen Highlands e Buttermilk.
                  • SNOWMASS: é a versão família e tranquila da badalada Aspen, com sua infraestrutura totalmente preparada para receber as famílias. Além de hotéis e apartamentos que acomodam com conforto e restaurantes family-friendly. É aqui que fica o Treehouse Kids’ Adventure Center, o maior complexo infantil do Colorado. Sua montanha é ideal para os iniciantes e intermediários, além de apresentar diversas atividades além do ski.
                </p>
              </div>
            </div>
            <div class="tab" x-show="selectedTab === 'itinerary'">
              <div class="topic">
                <h2>1º DIA - ASPEN SNOWMASS</h2>

                <p>
                  Chegada ao Aeroporto de Aspen/Eagle/Denver e traslado privativo ao hotel em Aspen ou Snowmass para acomodação por 07 noites.
                  Caso forem esquiar, sugerimos retirada dos passes de ski e retirada dos equipamentos alugados para deixá-los prontos para o dia seguinte.
                  À noite, sugerimos jantar no Bosq, o único restaurante em Aspen premiado com uma estrela no Guia Michelin, com uma culinária de inspiração sazonal e menu degustação com foco na produção de alimentos local.
                </p>
              </div>
              <div class="topic">
                <h2>2º DIA - ASPEN SNOWMASS</h2>

                <p>
                  Dia livre para atividades de interesse pessoal.
                  Para os amantes do esporte, que tal aproveitar o dia esquiando nas pistas de uma das quatro montanhas de Aspen Snowmass?
                  Se o seu plano não é esquiar, mas aproveitar o clima de uma estação de esqui, Snowmass Mountain é seu destino de hoje, pois há muitas atividades de montanha para aproveitar por lá, como a nova estrutura em Elk Camp Gondola com bares (inclusive a céu aberto, com presença de DJs) e restaurantes, tubbing (pista de neve em que é possível deslizar com boias - as crianças adoram), e a divertida Breathtaker Alpine Coaster, uma montanha-russa com trilhos suspensos sob o morro.
                </p>
              </div>
              <div class="topic">
                <h2>3º DIA - ASPEN SNOWMASS</h2>

                <p>
                  Dia livre para atividades de interesse pessoal.
                  Para os amantes do esporte, aproveite o dia esquiando nas pistas das quatro montanhas de Aspen Snowmass.

                  Outra sugestão é conhecer Aspen Village, uma pequena vila que serviu de base para exploração de minérios e que hoje concentra o burburinho turístico de Aspen Mountain, onde você pode fazer compras nas lojas de grife, imergir na cultura e na natureza local e, acima de tudo, aproveitar o après-ski (como é chamado o happy hour na neve) e pela noite com diversas atrações/eventos durante o inverno.
                </p>
              </div>
              <div class="topic">
                <h2>4º DIA - ASPEN SNOWMASS</h2>
                <p>
                  Dia livre para atividades de interesse pessoal.
                  São várias as opções de pistas de esqui e níveis diferentes. Que tal arriscar um novo percurso?

                  Para quem não esquia, aproveite o dia para fazer snowshoes (trilhas com calçados de neve) e visitar o Sundeck Restaurant, que fica no alto da Aspen Mountain.
                </p>
              </div>
              <div class="topic">
                <h2>5º DIA - ASPEN SNOWMASS</h2>
                <p>
                  Dia livre para atividades de interesse pessoal.
                  Para os amantes do esporte, aproveite o dia esquiando nas pistas das quatro montanhas de Aspen Snowmass.

                  Em Aspen Village, a elegância se sobressai graças a presença não apenas das vitrines luxuosas, mas também de inúmeras galerias de arte e do Aspen Art Museum, que foi projetado pelo renomado arquiteto japonês Shigeru Ban. Inovador, o edifício foi concebido como uma caixa de vidro envolvida por uma treliça. É belíssimo por fora e por dentro!
                </p>
              </div>
              <div class="topic">
                <h2>6º DIA - ASPEN SNOWMASS</h2>
                <p>
                  Dia livre para atividades de interesse pessoal.
                  Para os amantes do esporte, aproveite o dia esquiando nas pistas das quatro montanhas de Aspen Snowmass.

                  Conheça também Snowmass Village, pequena e não tem tantas lojas como em Aspen Village, mas tão charmosa quanto, garantindo diversão para toda a família. Há um rinque de patinação no gelo, parede de escalada e uma área com jogos eletrônicos para crianças, bem como diversos playgrounds ao ar livre.
                </p>
              </div>
              <div class="topic">
                <h2>7º DIA - ASPEN SNOWMASS</h2>
                <p>
                  Dia livre para atividades de interesse pessoal.
                  Lembre-se que hoje é o último em Aspen Snowmass. Se você ainda não esquiou, aproveite ou, se você é daqueles apaixonados pelo esporte desfrute ao máximo deste último dia.

                  Para encerrar a incrível aventura na neve, conheça o lendário Cloud Nine Alpine Bistro com um divertido passeio em snowcat (trator de neve) até o restaurante para jantar. Chegue em uma cabana aconchegante localizada no meio de Aspen Highlands para uma experiência gastronômica incomparável e com vista para os icônicos Maroon Bells - os picos de montanha mais conhecidos e perfeitos para cartões postais do oeste americano - e uma aconchegante lareira a lenha. O jantar é uma experiência inesquecível!
                </p>
              </div>
              <div class="topic">
                <h2>8º DIA - ASPEN SNOWMASS</h2>
                <p>
                  Em horário a ser informado localmente, traslado ao Aeroporto de Aspen/Eagle/Denver para embarque ao seu próximo destino.
                  Até a próxima viagem!
                </p>
              </div>
            </div>
            <div class="tab" x-show="selectedTab === 'services'">
              <div class="topic">
                <h2>SERVIÇOS INCLUÍDOS</h2>
                <p>
                  * 07 noites de hospedagem em Aspen ou Snowmass;
                  * Traslado oferecido pelo hotel de chegada e saída do Aeroporto de Aspen (ASE);
                  * Shuttle cortesia oferecido pela estação entre as quatro montanhas de Aspen Snowmass.
                </p>
              </div>
              <div class="topic">
                <h2>SERVIÇOS NÃO INCLUÍDOS</h2>
                <p>
                  * Cobrança do imposto sobre remessa ao exterior (IRRF) sobre o valor total da viagem;
                  * Bilhetes aéreos internacionais e internos (consulte-nos sobre as melhores tarifas);
                  * Taxas de embarque nos aeroportos;
                  * Despesas com documentação e vistos consulares;
                  * Passeios opcionais;
                  * Extras de caráter pessoal (bebidas, lavanderia, telefone, etc);
                  * A tradicional gorjeta ao guia e/ou motorista, carregadores de malas, camareiras e etc., a critério de cada passageiro;
                  * Qualquer serviço não mencionado em “Serviços incluídos”.
                </p>
              </div>
              <div class="topic">
                <h2>DOCUMENTAÇÃO</h2>
                <p>
                  O passageiro é inteiramente responsável pela obtenção dos documentos necessários para a viagem, devendo possuir passaporte com validade mínima de seis meses a contar da data de retorno ao Brasil, com os devidos vistos e vacinas em dia. Lembrando que para viagens internacionais não serão aceitos os documentos como RG, RNE, CPF, Carteira de Motorista (CNH), Carteiras de Classe CRM (médicos), CREA (engenheiros, arquitetos), OAB (advogados), etc.

                  VISTOS
                  Para os Estados Unidos é necessário visto para portadores de passaporte brasileiro. O passaporte deve possuir validade mínima de seis meses e duas folhas em branco para o controle de imigração. Passageiros estrangeiros devem consultar diretamente o Consulado ou Embaixada do país a ser visitado.
                </p>
              </div>
              <div class="topic">
                <h2>VACINAS</h2>
                <p>
                  Alguns países exigem o Certificado Internacional de Vacinação contra Febre Amarela, consulte diretamente o(s) Consulado(s) ou Embaixada(s) do(s) país(es) a ser(em) visitado(s) para obter a informação de que será necessário ou não o certificado de vacina contra febre amarela que deverá ser tomada com pelo menos 11 dias de antecedência da data do embarque. Levando em conta que estas regras mudam, às vezes, sem aviso prévio, recomendamos a todos manter sempre seu certificado em dia e levá-lo junto com o passaporte.
                  Atenção, se seu certificado é antigo (amarelo/laranja), recomendamos atualizar, pois não é mais aceito.
                  Consulte a documentação exigida com o consulado ou embaixada do(s) destino(s) de sua viagem.
                </p>
              </div>
              <div class="topic">
                <h2>SEGURO VIAGEM</h2>
                <p>
                  No programa acima está incluído seguro-viagem para 07 dias de viagem. É obrigatório que o início e término da vigência do seguro sejam exatamente as datas de saída e chegada ao Brasil.
                  Por favor consulte-nos sobre as condições gerais, coberturas deste plano e tarifas de diárias extras.
                </p>
              </div>
            </div>
            <dialog class="price-table-modal" x-ref="priceTableModal">
              <div class="modal-header">
                <h2>Aspen Snowmass</h2>
                <strong>(Férias na Neve)</strong>
                <span class="close-icon"><i class="fa-solid fa-x" @click="$refs.priceTableModal.close()"></i></span>
              </div>
              <div class="modal-content">
                <img src="./src/img/NEVE002_TAB.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB2.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB3.jpeg" alt="">
                <img src="./src/img/NEVE002_TAB4.jpeg" alt="">
              </div>
            </dialog>
          </div>
          <div class="share-links">
            <p>Compartilhe:</p>
            <a href="#"><i class="fa-regular fa-envelope"></i></a>
            <a href="#"><i class="fa-solid fa-print"></i></i></a>
          </div>
        </article>
      </div>
    </section>
    <div class="price-info" x-data="{
      isPriceTagOpen: false,
      productHasPriceInfo: false,
    }">
      <button class="price-info-toggle" @click="isPriceTagOpen = true" x-show="!isPriceTagOpen">Solicitar <br/> v</button>
      <article class="price" x-show="isPriceTagOpen">
        <span @click="isPriceTagOpen = false" class="close-icon"><i class="fa-solid fa-x"></i></span>
        <div class="get-more-info" x-show="!productHasPriceInfo">
          <p>Gostou deste roteiro? Solicite mais informações.</p>
          <a href="#" class="cta">Solicitar</a>
        </div>
        <div class="additional-info" x-show="productHasPriceInfo">
          <div class="value-box">
            <p class="highlighted-text">a partir de:</p>

            <div>
              <strong class="value">R$27.492,08</strong>
              <small class="small-text">
                EM 6X IGUAIS <br/>
                (US$ 4463,00 Câmbio R$ 6,1600)
              </small>
            </div>
          </div>
          <form>
            <select name="" id="">
              <option value="">Selecione</option>
            </select>
            <button class="buy-btn">
              Comprar
            </button>
          </form>
        </div>
        <span></span>
      </article>
    </div>
    <div class="gallery-area" x-data="{
      galleryModalSwiper: new Swiper('.gallery-modal .swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        navigation: {
          nextEl: '.gallery-modal .swiper-button-next',
          prevEl: '.gallery-modal .swiper-button-prev',
        },
        shortSwipes: true,
        breakpoints: {
          1: {
            slidesPerView: 1,
            spaceBetween: 0
          }
        }
      }),
      clickedGalleryItem: 0,
      gallerySwiper: new Swiper('.gallery .swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        shortSwipes: true,
        breakpoints: {
          1: {
            slidesPerView: 2,
            spaceBetween: 0
          },
          600: {
            slidesPerView: 4,
            spaceBetween: 0
          },
          1000: {
            slidesPerView: 6,
            spaceBetween: 0
          }
        }
      }),
      timesModalSwiperWasUpdated: 0,
    }" x-init="
    gallerySwiper.on('click', ()=>{
      clickedGalleryItem = gallerySwiper.clickedIndex;
      console.log(clickedGalleryItem);
      galleryModalSwiper.slideTo(clickedGalleryItem);
      
      timesModalSwiperWasUpdated = 0;
      timesModalSwiperWasUpdated += 1;
      if (timesModalSwiperWasUpdated < 3) {
        galleryModalSwiper.emit('slideChange');
      }
      // galleryModalSwiper.navigation.update();
    });

    galleryModalSwiper.on('slideChange', function() {
      if (timesModalSwiperWasUpdated < 3) {
        this.update();
      }
    })
    ">
      <article class="gallery-modal" x-show="isGalleryModalOpen">
          <button class="close-modal" @click="isGalleryModalOpen = false" x-ref="closeModalBtn"><i class="fa-solid fa-x"></i></button>

          <button class="prev-slide" @click="$refs.gallerySlidePrevBtn.click()"><i class="fa-solid fa-arrow-left"></i></button>

          <div class="swiper">
            <div class="swiper-wrapper img-frame">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg" class="swiper-slide" alt="Foto Galeria" >
              <img src="./src/img/NEVE002_GALERIA_2g.jpg" class="swiper-slide" alt="Foto Galeria" >
              <img src="./src/img/NEVE002_GALERIA_3g.jpg" class="swiper-slide" alt="Foto Galeria" >
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg" class="swiper-slide" alt="Foto Galeria" >
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg" class="swiper-slide" alt="Foto Galeria" >
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg" class="swiper-slide" alt="Foto Galeria" >
            </div>

            

            <div x-ref="gallerySlidePrevBtn" class="swiper-button-prev"></div>
            <div x-ref="gallerySlideNextBtn" class="swiper-button-next"></div>
          </div>

          <button class="next-slide" @click="$refs.gallerySlideNextBtn.click()"><i class="fa-solid fa-arrow-right"></i></button>
      </article>
      <section class="gallery">
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_2g.jpg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_3g.jpg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
            <div class="swiper-slide" @click="isGalleryModalOpen = true">
              <img src="./src/img/NEVE002_GALERIA_1g.jpeg"alt="Foto Galeria" >
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php get_footer(); ?>