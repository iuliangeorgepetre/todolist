<?php

// Prima data verificam daca formularul a fost trimis.
if (isset($_POST['reset-request-submit'])) {

  /* Primul lucru pe care ar trebui să știi despre resetarea parolelor este că trebuie să-l facem cât mai sigur posibil. Pentru a face acest lucru, vom crea "tokene" pentru a ne asigura că este utilizatorul corect care încearcă să reseta parola.

  Tokenele sunt folosite pentru a vă asigura că utilizatorul corect încearcă să reseta parola. Voi explic mai multe despre aceasta mai târziu.

  Atunci când creăm cele două jetoane, folosim random_bytes() și bin2hex(), care sunt funcții construite în PHP. random_bytes () generează bytes pseudo-aleatoare securizate criptografic, pe care apoi le convertim la valori hexazecimale, astfel încât să le putem folosi de fapt. În momentul de față, vom folosi doar bin2hex () pe "selector" deoarece mai târziu trebuie să inserăm "token" în baza de date în binar.

  // Mai târziu, vom include și aceste tokene într-o legătură pe care o vom trimite apoi prin poștă, astfel încât să își poată reseta parola. * /

  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);

  // Motivul pentru care trebuie să avem un "selector" și un "token" este să împiedicăm atacurile de sincronizare, adică când limităm viteza cu care un hacker poate încerca să ne spargă scriptul. Voi ajunge mai mult în acest lucru mai târziu în scenariul următor.

  // Apoi vom crea link-ul URL pe care îl vom trimite prin poștă, pentru a-și putea reseta parola.
  // Observați că convertim și "token" în hexadecimale aici, pentru a face URL-ul utilizabil.

  $url = "www.mmtuts.net/forgottenpwd/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

  // Apoi setăm marcajul de timp și adăugăm încă o oră la ora curentă și apoi trecem în formatul pe care l-am definit.

  // Then we set the timestamp and add another hour to the current time, and then pass it into the format we defined.
  $expires = date("U") + 1800;

  // Apoi ștergem orice tokene existente care ar putea fi în baza de date. Nu vrem să umplem baza de date cu date inutile de care nu mai avem nevoie.

  // Mai întâi trebuie să ne conectăm baza de date.
  require 'dbh.inc.php';

  // Apoi luam e-mailul trimis de utilizator din formular.
  $userEmail = $_POST["email"];

  // În final, ștergem toate intrările existente.
  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  // Aici avem, de asemenea, token-ul pentru al face necitit, în cazul în care un hacker accesează baza de date.
  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    // Here we also hash the token to make it unreadable, in case a hacker accessess our database.
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }

  // Aici inchidem instructiunea si conexiunea.
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  // Ultimul lucru pe care trebuie să-l facem este să formăm un e-mail și să îl trimitem utilizatorului, astfel încât să poată da clic pe un link care îi permite să-și reinițializeze parola.

  // Cui ii trimitem e-mailul.
  $to = $userEmail;

  // Subiect
  $subject = 'Reset your password for mmtuts';

  // Mesaje
  $message = '<p>We recieved a password reset request. The link to reset your password is below. ';
  $message .= 'If you did not make this request, you can ignore this email</p>';
  $message .= '<p>Here is your password reset link: </br>';
  $message .= '<a href="' . $url . '">' . $url . '</a></p>';

  // Headers
  $headers = "From: mmtuts <usemmtuts@gmail.com>\r\n";
  $headers .= "Reply-To: usemmtuts@gmail.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  // Trimite e-mail
  mail($to, $subject, $message, $headers);

  // In final ii trimitem la pagina care le spune sa isi verifice e-mailul.
  header("Location: ../reset-password.php?reset=success");
} else {
  header("Location: ../signup.php");
  exit();
}
