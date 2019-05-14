<?php

// Prima data verificam daca formularul a fost trimis.
if (isset($_POST['reset-password-submit'])) {

  // Aici luam datele din formular.
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  if (empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?newpwd=empty");
    exit();
  } else if ($password != $passwordRepeat) {
    header("Location: ../signup.php?newpwd=pwdnotsame");
    exit();
  }

  // Avem data si ora curenta.
  $currentDate = date('U');

  // Avem conexiunea la baza de date.
  require 'dbh.inc.php';

  /* Acum trebuie sa obtinem tokenul din baza de date.

  Cand ne uitam la token folosim selectorul pe care l-am creat.

  Deoarece separam cautarea (select) si validatorul (tokenul), prevenim atacurile. Acesta este motivul pentru care utilizez selectorul pentru a lua tokenul din baza de date. Aceasta este o metoda de securitate. */

  $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= $currentDate";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $selector);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
      echo "You need to re-submit your reset request.";
      exit();
    } else {

      // Acum verificam daca tokenul din url se potriveste cu cel din baza de date.

      // Prima data convertim tokenul din url inapoi in binar.
      $tokenBin = hex2bin($validator);

      // Apoi verificam daca acesta se potriveste cu cel din baza de date.
      $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

      // Apoi daca ele se potrivesc luam e-mailul utilizatorului din baza de date.
      if ($tokenCheck === false) {
        echo "There was an error!";
      } elseif ($tokenCheck === true) {

        // Inainte sa obtinem informatia utilizatorului din tabela user, trebuie sa stocam tokenul de pe e-mail pentru mai tarziu.
        $tokenEmail = $row['pwdResetEmail'];

        // Aici interogam tabela user pentru a verifica daca e-mailul pe care il avem in tabela pwdReset exista.
        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "There was an error!";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error!";
            exit();
          } else {

            // In final, updatam tabela user cu noua parola creata.
            $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error!";
              exit();
            } else {
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
              mysqli_stmt_execute($stmt);

              // Apoi stergem orice tokene ramase din tabela pwdReset.
              $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There was an error!";
                exit();
              } else {
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                header("Location: ../signup.php?newpwd=passwordupdated");
              }

            }

          }
        }

      }

    }
  }

} else {
  header("Location: www.mmtuts.net");
  exit();
}
