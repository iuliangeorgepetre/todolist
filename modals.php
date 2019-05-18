<!-- The Modal Task -->
<form method="POST" class="form" action="add_task_in_project.php?project_id=<?php echo $_GET['project_id']?>">

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
                <input type="hidden" class="form-control"  name="projectId" value="<?php echo $project_id ?>">

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
                <input type="hidden" class="form-control" name="bookId" value="">
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

<!-- The Modal USER -->
<form method="POST" class="form" action="add_user_in_project.php?project_id=<?php echo $_GET['project_id']?>">

<div class="modal" id="myModalUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <label for="task">User</label>
                <select class="form-control" name="username" required>
                    <?php 
                        $query = $conn->query("SELECT * FROM `users` ORDER BY idUsers ASC");
                        while($fetch = $query->fetch_array()){
                        ?>
                        <option value="<?php echo $fetch['uidUsers'] ?>"><?php echo $fetch['uidUsers'] ?> </option>
                        <?php
                        }
                    ?>
                </select>
                <br>
                
                <input type="hidden" class="form-control"  name="projectId" value="<?php echo $project_id ?>">

                <br>
                <button class="btn btn-primary form-control" name="add">Add User</button>
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