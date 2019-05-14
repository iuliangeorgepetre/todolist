<head>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</head>

<body>

    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">To Do List</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8 center">

            <form method="POST" class="form" action="add_query.php">
                <br>
                <label for="task">Task</label>
                <input type="text" class="form-control" name="task" required>
                <br>
                <label for="descriere">Description</label>
                <input type="text" class="form-control" name="descriere" required>
                <br>
                <label for="deadline">Deadline</label>
                <input type="date" class="form-control" name="deadline" required>
                <br>
                <button class="btn btn-primary form-control" name="add">Add Task</button>
                <br><br>
            </form>

        </div>
        <br /><br /><br />
        <table class="table text-center">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                require "includes/dbh.inc.php";
                
                $id = $_SESSION['id'];
                
                $interogare = $conn->query("SELECT * FROM `user_task_leg` WHERE idUsers = $id ");

               
                $count = 1;
                while($iadate = $interogare->fetch_array()){
                    $idTask = $iadate['idTask'];
                    
                    $query = $conn->query("SELECT * FROM `tasks` WHERE idTask = $idTask ");
                    
                
                
                while ($fetch = $query->fetch_array()) {
                   # if($fetch[])
                    ?>
                    <tr>
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
                            <a href="delete_query.php?task_id=<?php echo $fetch['idTask'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $count-1?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Details
                            </a>

                        </td>
                        <td>
                        <div class="collapse" id="collapseExample<?php echo $count-1?>">
                            <div class="text-center">
                                 <?php echo $fetch['descriere']; ?>
                            </div>
                        </div>
                        </td>
                    </tr>

                <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
<script>
$('.collapse').collapse()
</script>
