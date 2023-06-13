<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA KARDEX</title>
    <link rel="stylesheet" href="css/index-styles.css">
    <link rel="shortcut icon" href="assets/LOGO_ITSPR.jpg" type="image/x-icon">
</head>

<body>
    <header>
        <div class="tira-header">
            <img class="tira-header__img" src="assets/Tira_logo.jpg">
        </div>
        <div id="nav-sup" class="navegacion">
            <ul class="navegacion__navegacion-list navegacion__menu">
                <li>
                    <a href="index.php" class="active">INICIO</a>
                </li>
                <li>
                    <a href="registro.php">REGISTRO</a>
                </li>
                <li>
                    <a href="login.php">INICIAR SESION</a>
                </li>
            </ul>
        </div>
        <section class="textos-header">
            <h1 class="titulo"><span>JEFATURA DE SISTEMAS PARA ALUMNOS</span></h1>
        </section>
        </header>
  <div id="slide-container" class="slide-container">
    <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider1.jpg');">
    </div>

    <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider2.jpg');">
    </div>

    <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider3.jpg');">
    </div>
    
        <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider4.jpg');">
    </div>
    
        <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider5.jpg');">
    </div>
    
        <div class="slide-container__slide-item slide-container__bgimg slide-container__fx"
      style="background-image: url('assets/bg_slider6.jpg');">
    </div>

    <div id="slide-container__slide-control" class="slide-container__slide-control">
      <span class="slide-container__dot" onclick="chooseSlide(0)"></span>
      <span class="slide-container__dot" onclick="chooseSlide(1)"></span>
      <span class="slide-container__dot" onclick="chooseSlide(2)"></span>
      <span class="slide-container__dot" onclick="chooseSlide(3)"></span>
      <span class="slide-container__dot" onclick="chooseSlide(4)"></span>
      <span class="slide-container__dot" onclick="chooseSlide(5)"></span>
    </div>
  </div>
    <script src="js/index.js"></script>
</body>

</html>