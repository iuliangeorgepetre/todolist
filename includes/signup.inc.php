<?php
// Aici verificăm dacă utilizatorul a ajuns la această pagină făcând clic pe butonul corespunzător de înscriere.
if (isset($_POST['signup-submit'])) {

  // Include scriptul de conexiune pentru a-l putea folosi ulterior.
  // Nu trebuie să închidem conexiunea MySQLi, deoarece aceasta se face automat, dar este un obicei bun pentru a face acest lucru oricum, deoarece aceasta va reveni imediat resursele în PHP și MySQL, ceea ce poate îmbunătăți performanța.
  require 'dbh.inc.php';

  // Am luat toate datele pe care le-am trecut din formularul de înscriere, astfel încât să putem folosi mai târziu.
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  // erori
  // Verificam daca sunt campuri goale
  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  // Verificam daca usernameul si e-mailul este valid.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invaliduidmail");
    exit();
  }
  // Verificam un username invalid. Folosim doar litere si cifere.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invaliduid&mail=".$email);
    exit();
  }
  // Verificam un e-mail invalid.
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail&uid=".$username);
    exit();
  }
  // Verificăm dacă parola repetată nu este aceeași.
  else if ($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  else {

    // Trebuie, de asemenea, să includeți un alt dispozitiv de gestionare a erorilor aici, care să verifice dacă numele de utilizator este deja luat. Avem de a face acest lucru folosind declarații pregătite pentru că este mai sigur!

    // Mai întâi vom crea instrucțiunea care caută tabelul de baze de date pentru a verifica dacă există nume de utilizator identice.
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
    // Creem o instructiune
    $stmt = mysqli_stmt_init($conn);
    // Apoi pregatim instructiunea SQL siverificam daca are erori.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // Daca exista erori, intoarcem utilizatorul la pagina de signup.
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      // Apoi trebuie să legăm tipul de parametri pe care se așteaptă să treacă în instrucțiune și să lege datele de la utilizator.
      // "s" inseamna "string", "i" inseamna "integer", "b" inseamna "blob", "d" inseamna "double"
      mysqli_stmt_bind_param($stmt, "s", $username);
      // Apoi vom executa instrucțiunea pregătită și o vom trimite la baza de date!
      mysqli_stmt_execute($stmt);
      // Atunci vom stoca rezultatul din instrucțiune.
      mysqli_stmt_store_result($stmt);
      // Atunci obținem numărul de rezultate pe care le-am primit din declarația noastră. Acest lucru ne spune dacă numele de utilizator există deja sau nu!
      $resultCount = mysqli_stmt_num_rows($stmt);
      // Apoi încheiem declarația pregătită!
      mysqli_stmt_close($stmt);
      // Aici verificăm dacă există numele de utilizator.
      if ($resultCount > 0) {
        header("Location: ../signup.php?error=usertaken&mail=".$email);
        exit();
      }
      else {
        // Dacă am ajuns la acest punct, înseamnă că utilizatorul nu a făcut o eroare! :)

        // Următorul lucru pe care îl facem este să pregătim instrucțiunea SQL care va introduce informațiile despre utilizatori în baza de date. Avem de a face acest lucru folosind declarații pregătite pentru a face acest proces mai sigur. NU TRIMITEM DATELE RAW ​​DE LA UTILIZATOR DIRECT ÎN BAZA DE DATE!

        // Precizările pregătite funcționează prin trimiterea mai întâi la SQL a bazei de date SQL și apoi completam placeholderul prin trimiterea datelor utilizatorilor.
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?);";
        // Aici inițializăm o nouă declarație folosind conexiunea din fișierul dbh.inc.php.
        $stmt = mysqli_stmt_init($conn);
        // Atunci vom pregăti instrucțiunea SQL și verificăm dacă există erori cu ea.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          // Dacă apare o eroare, trimitem utilizatorul înapoi la pagina signup.
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {

          // Dacă nu există nicio eroare, continuăm scriptul!

          // Înainte de a trimite NICIODATĂ la baza de date trebuie să executăm parola utilizatorilor pentru al face să nu fie citit în cazul în care cineva accesează baza noastră de date fără permisiune!
          // Metoda de criptare pe care o voi folosi aici este cea mai recentă versiune și va fi mereu actualizată automat.
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          // Apoi trebuie să legăm tipul de parametri pe care se așteaptă să treacă în instrucțiune și să lege datele de la utilizator.
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
          // Apoi vom executa instrucțiunea pregătită și o vom trimite la baza de date!
          // Aceasta înseamnă că utilizatorul este înregistrat acum!
          mysqli_stmt_execute($stmt);
          // Lastly we send the user back to the signup page with a success message!
          header("Location: ../signup.php?signup=success");
          exit();

        }
      }
    }
  }
  // Apoi închidem declarația pregătită și conexiunea bazei de date!
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // Dacă utilizatorul încearcă să acceseze această pagină într-un mod inoperant, le trimitem înapoi la pagina de înscriere.
  header("Location: ../signup.php");
  exit();
}
