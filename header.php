<?php
// Prima data pornim sesiunea care ne permite stocarea informatiilor ca variabile ale sesiunii.
session_start();
// "require" creeaza un mesaj de eroare si opreste scriptul. "include" creeaza o eroare si continua scriptul.
require "includes/dbh.inc.php";
?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="description" content="This is an example of a meta description. This will often show up in search results.">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <!-- Aici este headerul unde am decis sa includ formularul de login. -->
  <header>
    <nav class="nav-header-main">
      <a class="header-logo" href="index.php">
        <img src="img/logo.png" alt="mmtuts logo">
      </a>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="proiecte.php">Proiecte</a></li>
        <li><a href="#">About me</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
    <div class="header-login">
      <!--
        Aici este formularul Login HTML.
        Putem observa ca metoda este "post" deoarece datele pe care le trimit sunt cu caracter sensitive.
        Inputurile pe care am decis sa le folosesc in formular sutn username/e-mail and password. Utilizatorul va putea sa aleaga cum sa se loggeze, folosind  e-mail-ul sau username-ul.

        De asemenea, putem alege daca sa afiseze sau nu formularul login/signup, sau sa afiseze formularul logout, daca suntem loggati sau nu. Se face asta pe baza variabilelor din sesiune. Am detaliat mai mult in fisierul login.inc.php !
        -->
      <?php
      if (!isset($_SESSION['id'])) {
        echo '<form action="includes/login.inc.php" method="post">
            <input type="text" name="mailuid" placeholder="E-mail/Username">
            <input type="password" name="pwd" placeholder="Password">
            <button type="submit" name="login-submit">Login</button>
          </form>
          <a href="signup.php" class="header-signup">Signup</a>';
      } else if (isset($_SESSION['id'])) {
        echo '<p class="login-status">Logged In as ' . $_SESSION['uid'] . '</p>';
        echo '<form action="includes/logout.inc.php" method="post">
            <button type="submit" name="login-submit">Logout</button>
          </form>';
      }
      ?>
    </div>
  </header>