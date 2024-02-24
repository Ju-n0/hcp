<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./css/style.css" />
  <title>Héritage Conseil Patrimoine</title>
  <script src="./index.js" defer></script>
</head>

<body>
  <header>
    <div class="header-overlay">
      <div class="burger">
        <div class="burger-line"></div>
        <div class="burger-line"></div>
        <div class="burger-line"></div>
      </div>
      <div>
        <img class="logo-header" src="./images/logo.png" alt="forêt éclairée par le ciel" />
      </div>
      <div id="header-bottom">
        <div class="header-bottom-overlay">
          <nav>
            <div class="logo-floating-header-container">
              <a href="/">
                <img class="logo-floating-header" src="./images/logo.png" alt="forêt éclairée par le ciel" /></a>
            </div>
            <ul>
              <li class="nav-item">
                <a href="#cabinet">Notre cabinet</a>
              </li>
              <li class="nav-item">
                <a href="#accompagnement">Notre accompagnement</a>
              </li>
              <li class="nav-item">
                <a href="#objectifs">Vos objectifs</a>
              </li>
              <li class="nav-item">
                <a href="#certification">Nos certifications</a>
              </li>
              <li class="nav-item">
                <a href="#contact">Nous contacter</a>
              </li>
            </ul>
            <div class="logo-floating-header-container"></div>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="two-sections">
      <section class="presentation">
        <div class="img-part"><img src="./images/chemin.jpg" alt="chemin dans la forêt" /></div>
        <div class="text-part">
          <h2 id="cabinet">Notre cabinet</h2>
          <p>
            Héritage Conseil Patrimoine a été conçu pour conseiller spécifiquement les dirigeants
            d’entreprises dans l’optimisation et la transmission de leur patrimoine. Nous
            travaillons en totale indépendance et uniquement sur recommandation afin d’apporter à
            nos client disponibilité et réactivité. Notre objectif principal est de construire
            avec vous une relation de confiance afin de vous accompagner tout au long de votre
            vie.
          </p>

          <p class="italic">« Conseille ton client comme s’il était quelqu’un de ta famille »</p>
        </div>
        <img class="bcg-img bcg-img-left" src="./images/leave-left.png" alt="" />
        <img class="bcg-img bcg-img-right" src="./images/leave-right.png" alt="" />
      </section>

      <section class="presentation">
        <div class="text-part">
          <h2 id="accompagnement">Notre accompagnement</h2>
          <p class="">
            Connaître votre situation et comprendre vos objectifs sont les bases pour vous
            apporter le bon conseil. Pour cela, nous réalisons des bilans patrimoniaux permettant
            non seulement de vous faire un état de la situation (diagnostic patrimonial et
            successoral) mais également d’établir une stratégie répondant à vos demandes. Nous
            étudierons les aspects civils, fiscaux et financiers et vous délivrerons les
            préconisations les plus adaptées à vos besoins.
          </p>
        </div>
        <div class="img-part"><img src="./images/main.webp" alt="main tendue" /></div>
      </section>
    </div>
    <section class="objectifs">
      <h2 id="objectifs" class="">Vos objectifs</h2>
      <div class="card-container">
        <div class="card-overlay">
          <div class="card-width">
            <div class="card card-proteger card-part-one">
              <div><img src="./images/famille.jpg" alt="famille dans un champs" /></div>
              <p>Protéger votre famille</p>
            </div>
            <div class="card-part-two">
              <div class="card card-fructifier">
                <div><img src="./images/plante.jpg" alt="main avec une plante" /></div>
                <p>Fructifier et valoriser votre capital</p>
              </div>

              <div class="card card-transmettre">
                <div><img src="./images/entreprise.png" alt="supermarché" /></div>
                <p>Transmettre/céder une entreprise</p>
              </div>
            </div>
            <div class="card-part-three">
              <div class="card card-anticiper">
                <div><img src="./images/enfants.jpg" alt="enfants" /></div>
                <p>Anticiper la transmission</p>
              </div>

              <div class="card card-preparer">
                <div><img src="./images/couple.webp" alt="couple" /></div>
                <p>Préparer votre retraite</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="certifications">
      <h2 id="certification">Nos certifications</h2>
      <div class="certifications-container">
        <div><img src="./images/amf.png" alt="logo de l'AMF" /></div>
        <div><img src="./images/orias.jpg" alt="logo de l'orias" /></div>
        <div><img src="./images/Cncgp.png" alt="logo de CNCGP" /></div>
      </div>
      <div><img class="certification-separator" src="./images/separateur1.jpg" alt="" /></div>
    </section>
  </main>

  <footer id="contact">
    <div class="footer-overlay">
      <div class="sendEmail">
        <p>Pour nous contacter:&nbsp;</p>
        <a href="mailto:contact@heritage-conseil-patrimoine.fr">contact@heritage-conseil-patrimoine.fr</a>
      </div>
      <form action="/contact.php" method="post" id="contact-form">
        <div class="form-first-part">
          <div class="form-names">
            <div class="field-container">
              <input type="text" name="firstName" placeholder="Prénom" />
              <p class="error-message hidden" data-name="firstName">
                Veuillez renseigner ce champs.
              </p>
            </div>
            <div class="field-container">
              <input type="text" name="lastName" placeholder="Nom" />
              <p class="error-message hidden" data-name="lastName">
                Veuillez renseigner ce champs.
              </p>
            </div>
          </div>
          <div class="form-coordonates">
            <div class="field-container">
              <input type="text" name="phoneNumber" placeholder="Téléphone portable" />
              <p class="error-message hidden" data-name="phoneNumber">
                Veuillez renseigner ce champs.
              </p>
            </div>
            <div class="field-container">
              <input type="text" name="email" placeholder="Email" />
              <p class="error-message hidden" data-name="email">
                Veuillez renseigner ce champs.
              </p>
            </div>
          </div>
        </div>
        <div class="form-second-part">

          <div class="field-container">
            <label for="">Message</label>
            <textarea name="message" id=""></textarea>
            <p class="error-message hidden" data-name="message">
              Veuillez renseigner ce champs.
            </p>
          </div>
        </div>
        <button class="formButton">Nous contacter</button>
        <p id="response-form" class="hidden"></p>
      </form>
    </div>
  </footer>
</body>

</html>