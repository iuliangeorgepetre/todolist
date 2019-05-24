<?php
// Pentru a ma asigura ca nu trebuie sa creez o sectiune header a site-ului pe mai multe pagini, o sa creez un header HTML intr-un fisier separat pe care il voi atasa in partea de sus a fiecarei pagini HTML a site-ului web.In acest mod, daca o sa fac vreo modificare in header nu trebuie sa mai modific peste tot!
require "header.php";
$project_id = $_GET['project_id'];
$query = $conn->query("SELECT * FROM projects WHERE idProiect = $project_id");
$fetch = $query->fetch_array();
?>
<head>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> 
</head>
<main>

</main>
<div class="text-center">

<body>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">Project: <?php echo $fetch['name']?></h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8 center">
            
            <button type="button" class="btn btn-primary btn-lg btn-lg btn-lg btn-lg" data-toggle="modal" data-target="#myModal">
            Add Task
            </button>
            <!-- The Modal Task -->
            <form method="POST" class="form" action="add_query.php">
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add Task</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <label for="task">Task</label>
                                <input type="text" class="form-control" name="task" required>
                                <br>
                                <label for="descriere">Description</label>
                                <input type="text" class="form-control" name="descriere" required>
                                <br>
                                <label for="deadline">Deadline</label>
                                <input type="date" class="form-control" name="deadline" required>
                                <input type="hidden" class="form-control" name="bookId" value="0">
                                <br>
                                <button class="btn btn-primary btn-lg form-control" name="add">Add Task</button>
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
            <!-- The Modal Subtask -->
            <form method="POST" class="form" action="add_query.php">
                <div class="modal" id="myModalSubtask">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add SubTask</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <label for="task">SubTask</label>
                                <input type="text" class="form-control" name="task" required>
                                <br>
                                <label for="descriere">Description</label>
                                <input type="text" class="form-control" name="descriere" required>
                                <br>
                                <label for="deadline">Deadline</label>
                                <input type="date" class="form-control" name="deadline" required>
                                <br>
                                <input type="hidden" class="form-control" name="bookId" value="">
                                <button class="btn btn-primary btn-lg form-control" name="add">Add SubTask</button>
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
            <!-- Modal Edit -->
            
            <form method="POST" class="form" action="edit_task.php">
                <div class="modal" id="myModalEdit">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Task</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <label for="task">Edit Task</label>
                                <input type="text" class="form-control" name="task" required>
                                <br>
                                <label for="deadline">Edit Deadline</label>
                                <input type="date" class="form-control" name="deadline" required>
                                <br>
                                <input type="hidden" class="form-control" name="bookId" value="">
                                <button class="btn btn-primary btn-lg form-control" name="edit">EditTask</button>
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
        <br /><br /><br />
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h3>
                        Tasks
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require "includes/dbh.inc.php";
        $id = $_SESSION['id'];
        $interogare = $conn->query("SELECT * FROM `project_task_leg` WHERE idProject = $project_id ");
        $count = 1;
        while ($iadate = $interogare->fetch_array()) {
        $idTask = $iadate['idTask'];
        $query = $conn->query("SELECT * FROM `tasks` WHERE idTask = $idTask AND status !='inTrash' AND parent_ID = '0'");
        while ($fetch = $query->fetch_array()) {
        # if($fetch[])
        ?>
        <div class="row">
            <div class="col-md-1">
                <?php
                if ($fetch['status'] == "Undone") {
                echo
                '<a href="update_task.php?task_id=' . $fetch['idTask'] . '" class="btn btnoutline-success" title="Complete Task" style="margin-top:50%;"><span class="glyphicon glyphicon-ok"></span></a> ';
                }
                if ($fetch['status'] == "Done") {
                echo
                '<a href="update_task2.php?task_id=' . $fetch['idTask'] . '" class="btn btn-outline-primary" title="Restore Task" style="margin-top:50%;"><span class="glyphicon
                glyphicon-refresh"></span></a> ';
                }
                ?>
            </div>
            <div class="col-md-8">
                <button id="wrap" class="accordion"><?php echo $fetch['name'] ?></button>
                <div class="panel">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Description</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <?php echo $fetch['descriere']; ?></td>
                                <td> <?php echo $fetch['deadline'] ?></td>
                                <td><?php echo $fetch['status'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    $query = $conn->query("SELECT * FROM `tasks` WHERE parent_ID = $idTask");
                    while($fetch2 = $query->fetch_array()){
                    ?>
                    <div class="row">
                        
                        <div class="col-md-12">
                            
                            <table class="table">
                                <thead>
                                    <tr style="background-color: lightgrey;">
                                        <th></th>
                                        <th scope="col">Subtask</th>
                                        <th scope="col">Deadline</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php
                                            if ($fetch2['status'] == "Undone") {
                                            echo
                                            '<a href="update_task.php?task_id=' . $fetch2['idTask'] . '" class="btn btnoutline-success" title="Complete Task" ><span class="glyphicon glyphicon-ok"></span></a> ';
                                            }
                                            if ($fetch2['status'] == "Done") {
                                            echo
                                            '<a href="update_task2.php?task_id=' . $fetch2['idTask'] . '" class="btn btn-outline-primary" title="Restore Task" ><span class="glyphicon
                                            glyphicon-refresh"></span></a> ';
                                            }
                                            ?>
                                        </td>
                                        <td> <?php echo $fetch2['name']; ?></td>
                                        <td> <?php echo $fetch2['deadline']; ?></td>
                                        <td><?php echo $fetch2['status']; ?></td>
                                        <td>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="ToTrash.php?task_id=<?php echo $fetch2['idTask']; ?>" class="btn btn-outline-danger" > <span class="glyphicon glyphicon-remove" ></span></a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a type-="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModalEdit" data-book-id="<?php echo $fetch2['idTask']; ?> " ><span class="glyphicon glyphicon-edit"></span></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            
            <div class="col-md-1">
                <a href="ToTrash.php?task_id=<?php echo $fetch['idTask']?>" class="btn btn-outline-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                    <div class="btn-group dropright">
                        <button class="btn btn-primary btn-lg dropdown-toggle " type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-option-vertical"></span></button>
                        <ul class="dropdown-menu">
                            <li><a type="button" class="dropdown-item" data-toggle="modal" data-target="#myModalSubtask" data-book-id="<?php echo $fetch['idTask'] ?> "><span class="glyphicon glyphicon-plus-sign"></span> Add SubTask</a></li>
                            <li><a type-="button" class="dropdown-item" data-toggle="modal" data-target="#myModalEdit" data-book-id="<?php echo $fetch['idTask'] ?> "><span class="glyphicon glyphicon-edit"></span> Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
        <?php }
        }
        ?>
        </div>
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
<script>
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
        panel.style.display = "none";
        } else {
        panel.style.display = "block";
        }
        });
        }
        </script>
<?php
// La fel cum introduc headerul dintr-un fisier separat, fac la fel si cu footerul.
require "footer.php";
?>