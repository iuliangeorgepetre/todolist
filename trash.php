<?php
include "header.php";
require "includes/dbh.inc.php";
$uid = $_SESSION['id'];
$query = $conn->query("SELECT * FROM 'user_task_leg' WHERE idUsers = $uid");




if (!$query->fetch_array()) {
    echo 'No items in the trash';
} else {
    if (isset($_POST['save'])) {
        $checkbox = $_POST['check'];
        for ($i = 0; $i < count($checkbox); $i++) {
            $del_id = $checkbox[$i];
            mysqli_query($conn, "DELETE FROM tasks WHERE idTask='" . $del_id . "'");
            $message = "Data deleted successfully !";
        }
    }
    $result = mysqli_query($conn, "SELECT * FROM tasks");
    
    ?>
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
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><input type="checkbox" id="checkItem" name="check[]" value="<?php echo $row["idTask"]; ?>"></td>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td>
                                <a href="deleteonlyone.php?id=<?php echo $row["idTask"]; ?>"><span class="glyphicon glyphicon-trash"></span></a>


                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </table>
            <?php
            if ($query->fetch_array())
                echo '<button type="submit" class="btn btn-danger" name="save">Permanently delete<span class="glyphicon glyphicon-trash"></span></button>';
            ?>

        </form>
    </div>
</div>



<script>
    $("#checkAl").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>