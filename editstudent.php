<?php
    $filepath = realpath(dirname(__FILE__));
    include $filepath . "/inc/header.php";
    include $filepath . "/lib/Database.php";
?>

    <div class="panel panel-default" style="background: #313131; border-color: #423f3f; color:#2cd8ff;">
        <div class="panel-heading" style="background: #313131; border-color: #423f3f; color:#df2cff;">
            <h2>
                <h3>Update Student
                    <a class="btn btn-success pull-right" href="index.php">Back</a></h3>
            </h2>
        </div>
        <?php
            $db = new Database();
            $id = $_GET['id'];
            $table = "tbl_student";
            $whereCondition = array(
                'where' => array('id' => $id),
                'return_type' => 'single'
            );
            $data = $db->select($table, $whereCondition);
            if(!empty($data)){
        ?>
        <div class="panel-body">
            <form action="lib/student.php" method="post">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $data['name'];?>">
                </div>
                <div class="form-group">
                    <label for="email">Student Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="<?php echo $data['email'];?>">
                </div>
                <div class="form-group">
                    <label for="phone">Student Phone</label>
                    <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $data['phone'];?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                    <input type="hidden" name="action" value="edit">
                    <input class="btn btn-primary" type="submit" name="submit" value="Update Student">
                </div>
            </form>
        </div>
        <?php } ?>
    </div>

<?php include "inc/footer.php"; ?>