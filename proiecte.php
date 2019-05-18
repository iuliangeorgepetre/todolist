<?php
// Pentru a ma asigura ca nu trebuie sa creez o sectiune header a site-ului pe mai multe pagini, o sa creez un header HTML intr-un fisier separat pe care il voi atasa in partea de sus a fiecarei pagini HTML a site-ului web.In acest mod, daca o sa fac vreo modificare in header nu trebuie sa mai modific peste tot!
require "header.php";
?>

<head>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<main>
  <div class="text-center ">

    <!--
      Pot alege daca sa afiseze orice continut pe pagina, depinzand daca sunt logged in sau logged out. Am detaliat mai mult despre variabile in fisierul login.inc.php !
      -->
    <div class="container">
      <div class="col-md-2"></div>
      <div class="col-md-8 well">
        <div class="text-center">
          <h3 class="text-primary">Projects</h3>
          <hr style="border-top:1px dotted #ccc;">
          <button type="button" class="btn-lg btn-primary btn" data-toggle="modal" data-target="#myModal">Add Project </button>
         
          <br>
          <!-- The Modal Project -->
          <form method="POST" class="form" action="add_project.php">

            <div class="modal" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Add Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                    <label for="task">Project Name</label>
                    <input type="text" class="form-control" name="project" required>
                    <br>
                    <label for="deadline">Deadline</label>
                    <input type="date" class="form-control" name="deadline" required>



                    <br>
                    <button class="btn btn-primary form-control" name="add">Add Project</button>
                    <br><br>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

        </div>
        <!-- afisare proiecte -->
        <table class="table table-hover">
          <thead class="">
            <tr class="text-center">
              <th scope="col text-center">#</th>
              <th scope="col text-center">Task</th>
              <th scope="col text-center">Deadline</th>
              <th scope="col text-center  ">Status</th>

            </tr>
          </thead>
          <tbody class="">
            <?php
            require "includes/dbh.inc.php";

            $are = 0;

            $id = $_SESSION['id'];

            $interogare = $conn->query("SELECT * FROM `project_user_leg` WHERE idUsers = $id ");

            $count = 1;
            while ($iadate = $interogare->fetch_array()) {
              $idProject = $iadate['idProject'];


              $query = $conn->query("SELECT * FROM `projects` WHERE idProiect = $idProject");

              while ($fetch = $query->fetch_array()) {
                # if($fetch[])
                ?>
                <tr class="text-center">
                  <td><?php echo $count++ ?></td>
                  <td><?php echo
                        '<a href="project.php?project_id=' . $fetch['idProiect'] . '" class="btn btn-success btn-block" title=" Task">'.$fetch['name'].'</a> ';  ?></td>
                  <td><?php echo $fetch['deadline'] ?></td>
                  <td><?php echo $fetch['status'] ?></td>

                </tr>




                </tr>
              <?php
            }
          }

          ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>



</main>


<script>
  // When the user clicks on <div>, open the popup
  $('#myModal').modal(options);

  function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
  }
</script>
<script>
  $('.collapse').collapse({
    toggle: false
  });

  $(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<?php
// La fel cum introduc headerul dintr-un fisier separat, fac la fel si cu footerul.
require "footer.php";
?>