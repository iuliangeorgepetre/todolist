
<head>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>





</head>

<body>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">To Do List</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8 center">

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
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

                                <input type="text" class="form-control" name="bookId" value="0">

                                <br>
                                <button class="btn btn-primary form-control" name="add">Add Task</button>
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
                                <button class="btn btn-primary form-control" name="add">Add SubTask</button>
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
                                <input type="text" class="form-control" name="bookId" value="">
                                <button class="btn btn-primary form-control" name="edit">EditTask</button>
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

                $are=0;

                $id = $_SESSION['id'];

                $interogare = $conn->query("SELECT * FROM `user_task_leg` WHERE idUsers = $id ");

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
                                if ($fetch['status'] != "Done") {
                                    echo
                                        '<a href="update_task.php?task_id=' . $fetch['idTask'] . '" class="btn btn-success"><span class="glyphicon glyphicon-check"></span></a> |';
                                }
                                ?>
                                <a href="ToTrash.php?task_id=<?php echo $fetch['idTask'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a><span>|</span>

                                <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseExample<?php echo $count - 1 ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </button><span>|</span>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModalSubtask" data-book-id="<?php echo $fetch['idTask'] ?> ">
                                    <span class="glyphicon glyphicon-plus-sign"></span>

                              </button><span>|</span>
                                 <button type-="button" class="btn btn-info"data-toggle="modal" data-target="#myModalEdit" data-book-id="<?php echo $fetch['idTask'] ?> "><span class="glyphicon glyphicon-edit"></span></button>
                                
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
                            if($fetch = $query->fetch_array()){
                                $are=1;
                                echo'
                                <div>
                                <tr>
                                    <td> </td><td> </td>
                                    <td style = "font-weight:bold; background-color:#EA2027; color:white;"> Subtasks:</td>
                                    
                                </tr>
                                <tr style="">
                                <td> </td><td> </td>
                                <td style = "font-weight:bold; background-color:#EA2027; color:white;"> Nume: </td>
                                <td style = "font-weight:bold; background-color:#EA2027; color:white;"> Deadline: </td>
                                <td style = "font-weight:bold; background-color:#EA2027; color:white;"> Status: </td>
                                </tr>
                                ';
                            }
                            $query = $conn->query("SELECT * FROM `tasks` WHERE parent_ID = $idTask");
                            while($fetch = $query->fetch_array()){
                        ?>
                        
                        <tr class="text-center">
                            <td></td>
                            <td> </td>
                            <td><?php echo $fetch['name'] ?></td>
                            <td><?php echo $fetch['deadline'] ?></td>
                            <td><?php echo $fetch['status'] ?></td>

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


</script>
