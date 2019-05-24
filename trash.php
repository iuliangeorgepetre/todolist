<?php
include "header.php";
require "includes/dbh.inc.php";
$este = 0;
$uid = $_SESSION['id'];
$rez = $conn->query("SELECT * FROM 'user_task_leg' WHERE idUsers = $uid ");
$taskId = $rez['idTask'];
$query = $conn->query("SELECT * FROM `tasks` WHERE status = 'inTrash' ");




if (!$query->fetch_array()) {
    echo '<div class="text-center">
             <h1 style="margin-top: 40vh;">No items in the trash...</h1>
         </div>';
} else {

    if (isset($_POST['save'])) {
        $checkbox = $_POST['check'];
        for ($i = 0; $i < count($checkbox); $i++) {
            $del_id = $checkbox[$i];
            mysqli_query($conn, "DELETE FROM tasks WHERE idTask='" . $del_id . "'");

            
    }
    header("Refresh:0");
}
     if (isset($_POST['restore'])) {
        $checkbox = $_POST['check'];
        for ($i = 0; $i < count($checkbox); $i++) {
            $del_id = $checkbox[$i];
            mysqli_query($conn, "UPDATE `tasks` SET `status` = 'Undone' WHERE `idTask` ='" . $del_id . "'");
            
    }
}




    $result = mysqli_query($conn, "SELECT * FROM tasks WHERE status = 'inTrash'");
    ?>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> 
    </head>
    <br>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary" style="text-align: center">Deleted Tasks</h3>
        <hr style="border-top:1px dotted #ccc;" />
        <div class="col-md-2"></div>
        <div class="col-md-8 center">
            <form method="post" action="">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAl" style="margin-left:50px"> Select All</th>
                            <th>Id</th>
                            <th>Task</th>
                        </tr>
                    </thead>
                    <br><br><br>
                    <tbody class="text-center">
                        <?php
                        require "includes/dbh.inc.php";

                        $id = $_SESSION['id'];

                        $interogare = $conn->query("SELECT * FROM `user_task_leg` WHERE idUsers = $id ");


                        $count = 1;
                        while ($iadate = $interogare->fetch_array()) {
                            $idTask = $iadate['idTask'];

                            $query = $conn->query("SELECT * FROM `tasks` WHERE idTask = $idTask AND status = 'inTrash'");



                            while ($fetch = $query->fetch_array()) {
                                $este = 1;
                                ?>
                                <tr>
                                    <td><input type="checkbox" id="checkItem" name="check[]" value="<?php echo $fetch["idTask"]; ?>"></td>
                                    <td><?php echo $count++ ?></td>
                                    <td><?php echo $fetch['name'] ?></td>
                                    <td><a href="deleteonlyone.php?id=<?php echo $fetch["idTask"]; ?>"><span class="glyphicon glyphicon-trash"></span></a></td>


                                </tr>

                            <?php
                        }
                    }
                }
                    ?>
                    </tbody>
                </table>
                <?php
                if ($este)

                {
                    echo '<button type="submit" class="btn btn-danger" name="save">Permanently delete <span class="glyphicon 
                    glyphicon-trash"></span></button>';   
                    echo '<br><br>';
                    echo '<button type="submit" class="btn btn-primary" name="restore">Restore <span class="glyphicon 
                    glyphicon-refresh"></span></button>';    
                }?>


        </form>
        </div>
    </div>



    <script>
        $("#checkAl").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>