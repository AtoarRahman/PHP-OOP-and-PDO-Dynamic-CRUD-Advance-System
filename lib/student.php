<?php
    $filepath = realpath(dirname(__FILE__));
    include $filepath . "/Database.php";
    include $filepath . "/Session.php";
    Session::init();
    $db = new Database();
    $table = "tbl_student";

    if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
        if($_REQUEST['action'] == 'add'){
            $studentData = array(
                'name' => $_POST['name'],
                'email'=> $_POST['email'],
                'phone'=> $_POST['phone']
            );
            $insertData = $db->insert($table, $studentData);
            if($insertData){
                $msg = "Data Insert Successfull";
            }else{
                $msg = "Data Not Inserted !!";
            }
            Session::set('msg', $msg);
            $home_url = '../index.php';
            header("Location:$home_url");


        }elseif($_REQUEST['action'] == 'edit'){
            $id = $_POST['id'];
            if(!empty($id)){
                $studentData = array(
                    'name' => $_POST['name'],
                    'email'=> $_POST['email'],
                    'phone'=> $_POST['phone']
                );
                $table      = "tbl_student";
                $condition  = array('id' => $id);
                $updateData = $db->update($table, $studentData, $condition);
                if($updateData){
                    $msg = "Data Update Successfull";
                }else{
                    $msg = "Data Not Updated !!";
                }
                Session::set('msg', $msg);
                $home_url = '../index.php';
                header("Location:$home_url");
            }


        }elseif($_REQUEST['action'] == 'delete'){
            $id = $_GET['id'];
            if(!empty($id)){
                $table      = "tbl_student";
                $condition  = array('id' => $id);
                $deleteData = $db->delete($table, $condition);
                if($deleteData){
                    $msg = "Data Delete Successfull";
                }else{
                    $msg = "Data Not Deleted !!";
                }
                Session::set('msg', $msg);
                $home_url = '../index.php';
                header("Location:$home_url");
            }
        }
    }



