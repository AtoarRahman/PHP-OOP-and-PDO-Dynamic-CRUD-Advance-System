<?php
    $filepath = realpath(dirname(__FILE__));
    include $filepath . "/lib/Session.php";
    include $filepath . "/inc/header.php";
    include $filepath . "/lib/Database.php";
    Session::init();

?>
<?php
    $msg = Session::get('msg');
    if(!empty($msg)){
        echo "<p class='alert alert-info text-center'>$msg</p>";
        Session::set('msg', NULL);
    }
?>

<div class="panel panel-default" style="background: #313131; border-color: #423f3f; color:#2cd8ff;">
    <div class="panel-heading" style="background: #313131; border-color: #423f3f; color:#df2cff;">
        <h2>
            <h4>Student List
            <a class="btn btn-success pull-right" href="addstudent.php">Add Student</a></h4>
        </h2>
    </div>
    <div class="panel-body">
        <form action="" method="post">
            <table class="table table-striped">
                <tr>
                    <th width="10%">SL</th>
                    <th width="25%">Name</th>
                    <th width="25%">Email</th>
                    <th width="20%">Phone</th>
                    <th width="20%">Action</th>
                </tr>

                <?php
                    $db = new Database();
                    $table = "tbl_student";
                    $order_by = array('order_by' => 'id DESC');

                    $studentData = $db->select($table, $order_by);

                    if($studentData){
                        $i = 0;
                        foreach ($studentData as $data){
                            $i++ ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $data['name']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['phone']; ?></td>
                    <td>
                        <a href="editstudent.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="lib/student.php?action=delete&id=<?php echo $data['id']; ?>"
                           onclick="return confirm('Are you sure to delete?')" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } }else{ ?>
                   <tr><td colspan="5"><h3 style="color:red;">Student Data Not Found ...</h3></td></tr>
            <?php } ?>

            </table>
        </form>
    </div>
</div>

<?php include "inc/footer.php"; ?>