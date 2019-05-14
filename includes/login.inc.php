<?php
// Aici verificam daca utilizatorul a ajuns la aceasta pagina apasand butonul Login.
if (isset($_POST['login-submit'])) {

  // Includem scriptul de conexiune.
  require 'dbh.inc.php';

  // Luam datele din formularul signup pentru a le folosi mai tarziu.
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  // Aici voi afisa cateva posibile erori ale utilizatorului.

  // Aici verific daca exista campuri goale.
  if (empty($mailuid) || empty($password)) {
    header("Location: ../index.php?error=emptyfields&mailuid=".$mailuid);
    exit();
  }
  else {


    // Acum trebuie sa verific parola utilizatorului in baza de date care are acelasi nume de utilizator. Iar apoitrebuie sa decripteze parola si sa verifice daca corespunde parolei introduse de utilizator in formularul de Login.

    // Ne vom conecta la baza de date folosind instructiunile pregatite care vor trimite mai intai baza de date sql si apoi va completa campurile trimitand datele utilizatorului.
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    // Aici initializam o noua instructiune utilizand conexiunea din dbh.inc.php file.
    $stmt = mysqli_stmt_init($conn);
    // Apoi pregatim instructiunea SQL si verificam daca are vreo eroare.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // Daca are vreo eroare trimitem utilizatorul inapoi la pagina de Signup.
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {

      // Daca nu exista erori, atunci vom continua scriptul.

      // Apoi trebuie sa legam tipul de parametru pe care il asteptam sa treaca in instructiune si sa lege datele de la utilizator.
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      // Acum trebuie executata instructiunea si trimisa la baza de date.
      mysqli_stmt_execute($stmt);
      // Si obtinem rezultatul instructiunii.
      $result = mysqli_stmt_get_result($stmt);
      // Apoi stocam rezulatul intr-o variabila.
      if ($row = mysqli_fetch_assoc($result)) {
        // Acum verificam daca parola din baza de date se potriveste cu cea introdusa de utilizator. Rezultatul este returnat ca boolean.
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        // Daca nu se potriveste, vom crea un mesaj de eroare!
        if ($pwdCheck == false) {
          // Daca este o eroare trimitem utilizatorul inapoi la pagina de signup.
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
        // Daca se potriveste, atunci stim ca este utilizatorul corect care incearca sa se loggeze!
        else if ($pwdCheck == true) {

          // Urmatorul pas este sa creem o sesiune de variabile bazata pe informatia utilizatorului din baza de date. Daca sesiunea de variabile exista, atunci websiteul va sti ca utilizatorul este logged in.

          // Acum ca avem datele in baza de date, trebuie sa le stocam in sesiunea de avriabile care este un tip de variabile pe care le putem folosi pe toate paginile care ruleaza o sesiune.
          // Acest lucru inseamna ca vom incepe o sesiune aici pentru a crea variabilele!
          session_start();
          // Acum vom crea variabilele.
          $_SESSION['id'] = $row['idUsers'];
          $_SESSION['uid'] = $row['uidUsers'];
          $_SESSION['email'] = $row['emailUsers'];
          // Acum utilizatorul este inregistrat ca Logged in si il putem trmite la pagina principala.
          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else {
        header("Location: ../index.php?login=wronguidpwd");
        exit();
      }
    }
  }
  // Apoi inchidem instructiunea si conexiunea la baza de date.
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // Daca utilizatorul incearca sa acceseze pagina intr-un mod necorespunzator, il vom trimite inapoi la pagina de Signup.
  header("Location: ../signup.php");
  exit();
}
