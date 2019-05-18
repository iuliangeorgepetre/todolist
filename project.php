<?php
// Pentru a ma asigura ca nu trebuie sa creez o sectiune header a site-ului pe mai multe pagini, o sa creez un header HTML intr-un fisier separat pe care il voi atasa in partea de sus a fiecarei pagini HTML a site-ului web.In acest mod, daca o sa fac vreo modificare in header nu trebuie sa mai modific peste tot!
require "header.php";
$project_id = $_GET['project_id'];
$query = $conn->query("SELECT * FROM projects WHERE idProiect = $project_id");
$fetch = $query->fetch_array();
?>
<head>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<main>

</main>
<div class="text-center">

<body>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">Project: <?php echo  $fetch['name'] ?></h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8 center">

            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                Add Task
            </button>
            <?php
            if($fetch['uid_admin'] == $_SESSION['id']){
                echo '<button type="button" class="btn-lg btn-primary btn" data-toggle="modal" data-target="#myModalUser">Add User </button>';
                
            }
            ?>
            


            <?php
                require "modals.php";
            ?>

        </div>
        <div class="col-md-2"></div>
        <br /><br /><br />
        <table class="table table-hover">
            <thead class="text-center">
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Task</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                require "includes/dbh.inc.php";

                $are = 0;



                $interogare = $conn->query("SELECT * FROM `project_task_leg` WHERE idProject = $project_id ");

                $count = 1;
                while ($iadate = $interogare->fetch_array()) {
                    $idTask = $iadate['idTask'];


                    $query = $conn->query("SELECT * FROM `tasks` WHERE idTask = $idTask AND status !='inTrash' AND parent_ID = '0'");

                    while ($fetch = $query->fetch_array()) {
                        # if($fetch[])
                        ?>
                        <tr class="text-center">
                            <td><?php echo $count++ ?></td>
                            <td><?php echo $fetch['name'] ?></td>
                            <td><?php echo $fetch['deadline'] ?></td>
                            <td><?php echo $fetch['status'] ?></td>
                            <td colspan="3">
                                <?php
                                if ($fetch['status'] == "Undone") {
                                    echo
                                        '<a href="update_task.php?task_id=' . $fetch['idTask'] . '" class="btn btn-success" title="Complete Task"><span class="glyphicon glyphicon-check"></span></a> |';
                                }
                                if ($fetch['status'] == "Done") {
                                    echo
                                        '<a href="update_task2.php?task_id=' . $fetch['idTask'] . '" class="btn btn-primary" title="Restore Task"><span class="glyphicon 
                                        glyphicon-refresh"></span></a> |';
                                }
                                ?>
                                <a href="ToTrash.php?task_id=<?php echo $fetch['idTask'] ?>" class="btn btn-danger" title="Delete Task"><span class="glyphicon glyphicon-remove"></span></a><span>|</span>

                                <button class="btn btn-primary" data-toggle="collapse" title="About..." data-target="#collapseExample<?php echo $count - 1 ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </button><span>|</span>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModalSubtask" data-book-id="<?php echo $fetch['idTask']?> " title="Add Subtask">
                                    <span class="glyphicon glyphicon-plus-sign"></span>

                                </button><span>|</span>
                                <button type-="button" class="btn btn-info" data-toggle="modal" data-target="#myModalEdit" data-book-id="<?php echo $fetch['idTask'] ?> " title="Edit Task"><span class="glyphicon glyphicon-edit"></span></button>

                            </td>
                            <td>
                                <div class="collapse" id="collapseExample<?php echo $count - 1 ?>">
                                    <div class="text-center">
                                        <?php echo $fetch['descriere']; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php
                        $query = $conn->query("SELECT * FROM `tasks` WHERE parent_ID = $idTask");
                        if ($fetch = $query->fetch_array()) {
                            $are = 1;
                            echo '
                                <div>
                               
                                
                                ';
                        }
                        $query = $conn->query("SELECT * FROM `tasks` WHERE parent_ID = $idTask");
                        while ($fetch = $query->fetch_array()) {
                            ?>

                            <tr class="text-center">

                                <td> </td>
                                <td style="font-weight:bold; background-color:#EA2027; color:white;"><?php echo $fetch['name'] ?></td>
                                <td style="font-weight:bold; background-color:#EA2027; color:white;"><?php echo $fetch['deadline'] ?></td>
                                <td style="font-weight:bold; background-color:#EA2027; color:white;"><?php echo $fetch['status'] ?></td>
                                <td>
                                    <?php
                                    if ($fetch['status'] == "Undone") {
                                        echo
                                            '<a href="update_task.php?task_id=' . $fetch['idTask'] . '" class="btn btn-success" title="Complete Task"><span class="glyphicon glyphicon-check"></span></a> ';
                                    }
                                    if ($fetch['status'] == "Done") {
                                        echo
                                            '<a href="update_task2.php?task_id=' . $fetch['idTask'] . '" class="btn btn-primary" title="Restore Task"><span class="glyphicon 
                                        glyphicon-refresh"></span></a> ';
                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php
                    }
                    echo "</div>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</body>



</div>


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
    $('#myModalSubtask').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var bookId = $(e.relatedTarget).data('book-id');
        //populate the textbox
        $(e.currentTarget).find('input[name="bookId"]').val(bookId);
    });
    $('#myModalEdit').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var bookId = $(e.relatedTarget).data('book-id');

        //populate the textbox
        $(e.currentTarget).find('input[name="bookId"]').val(bookId);
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    
</script>
<?php
// La fel cum introduc headerul dintr-un fisier separat, fac la fel si cu footerul.
require "footer.php";
?>