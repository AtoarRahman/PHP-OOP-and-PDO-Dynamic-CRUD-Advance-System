<?php
    $filepath = realpath(dirname(__FILE__));
    include $filepath . "/inc/header.php";

?>

    <div class="panel panel-default" style="background: #313131; border-color: #423f3f; color:#2cd8ff;">
        <div class="panel-heading" style="background: #313131; border-color: #423f3f; color:#df2cff;">
            <h2>
                <h3>Add Student
                    <a class="btn btn-success pull-right" href="index.php">Back</a></h3>
            </h2>
        </div>
        <div class="panel-body">
            <form action="lib/student.php" method="post">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input class="form-control" type="text" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Student Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="phone">Student Phone</label>
                    <input class="form-control" type="text" name="phone" id="phone">
                </div>
                <div class="form-group">
                    <input type="hidden" name="action" value="add">
                    <input class="btn btn-primary" type="submit" name="submit" value="Add Student">
                </div>
            </form>
        </div>
    </div>

<?php include "inc/footer.php"; ?>