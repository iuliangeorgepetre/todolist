<?php
// Pentru a ma asigura ca nu trebuie sa creez o sectiune header a site-ului pe mai multe pagini, o sa creez un header HTML intr-un fisier separat pe care il voi atasa in partea de sus a fiecarei pagini HTML a site-ului web.In acest mod, daca o sa fac vreo modificare in header nu trebuie sa mai modific peste tot!
require "header.php";
?>

<main>

</main>
<div class="text-center">

  <!--
        Pot alege daca sa afiseze orice continut pe pagina, depinzand daca sunt logged in sau logged out. Am detaliat mai mult despre variabile in fisierul login.inc.php !
        -->

  <div class="text-center">
    <h1 style="margin-top: 30vh;" >Projects Coming Soon...</h1>
  </div>

</div>

<?php
// La fel cum introduc headerul dintr-un fisier separat, fac la fel si cu footerul.
require "footer.php";
?>