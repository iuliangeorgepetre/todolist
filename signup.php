<?php
// Pentru a ma asigura ca nu trebuie sa creez o sectiune header a site-ului pe mai multe pagini, o sa creez un header HTML intr-un fisier separat pe care il voi atasa in partea de sus a fiecarei pagini HTML a site-ului web.In acest mod, daca o sa fac vreo modificare in header nu trebuie sa mai modific peste tot!
  require "header.php";
?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <h1>Signup</h1>
          <?php
          // Aici creem un mesaj de eroare daca utilizatorul a facut o eroare cand incearca sa se inregistreze.
          if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyfields") {
              echo '<p class="signuperror">Fill in all fields!</p>';
            }
            else if ($_GET["error"] == "invaliduidmail") {
              echo '<p class="signuperror">Invalid username and e-mail!</p>';
            }
            else if ($_GET["error"] == "invaliduid") {
              echo '<p class="signuperror">Invalid username!</p>';
            }
            else if ($_GET["error"] == "invalidmail") {
              echo '<p class="signuperror">Invalid e-mail!</p>';
            }
            else if ($_GET["error"] == "passwordcheck") {
              echo '<p class="signuperror">Your passwords do not match!</p>';
            }
            else if ($_GET["error"] == "usertaken") {
              echo '<p class="signuperror">Username is already taken!</p>';
            }
          }
          // Aici creem un mesaj de "success" daca utilizatorul a creat un nou user.
          else if (isset($_GET["signup"])) {
            if ($_GET["signup"] == "success") {
              echo '<p class="signupsuccess">Signup successful!</p>';
            }
          }
          ?>
          <form class="form-signup" action="includes/signup.inc.php" method="post">
            <?php
            // Aici verificam daca utilizatorul a incercat deja sa introduca date.

            // Verificam username-ul.
            if (!empty($_GET["uid"])) {
              echo '<input type="text" name="uid" placeholder="Username" value="'.$_GET["uid"].'">';
            }
            else {
              echo '<input type="text" name="uid" placeholder="Username">';
            }

            // Verificam e-mailul.
            if (!empty($_GET["mail"])) {
              echo '<input type="text" name="mail" placeholder="E-mail" value="'.$_GET["mail"].'">';
            }
            else {
              echo '<input type="text" name="mail" placeholder="E-mail">';
            }
            ?>
            <input type="password" name="pwd" placeholder="Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat password">
            <button type="submit" name="signup-submit">Signup</button>
          </form>



          <!--Aici se creeaza formularul care incepe procesul de recuperare a parolei!-->
          <?php
          if (isset($_GET["newpwd"])) {
            if ($_GET["newpwd"] == "passwordupdated") {
              echo '<p class="signupsuccess">Your password has been reset!</p>';
            }
          }
          ?>

          <a class="p-forgetpwd" href="reset-password.php">Forgot your password?</a>
        </section>
      </div>
    </main>



<?php
  // La fel cum am introdus headerul dintr-un fisier separat, fac la fel si cu footerul.
  require "footer.php";
?>
