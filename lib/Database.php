<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath . "/../config/config.php");
Class Database{
    private $host   = DB_HOST;
    private $user   = DB_USER;
    private $pass   = DB_PASS;
    private $dbname = DB_NAME;

    private $pdo;

    public function __construct(){
        if(!isset($this->pdo)){
            try {
                $link = new PDO("mysql:host=".$this->host."; dbname=".$this->dbname, $this->user, $this->pass);
                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link->exec("SET CHARACTER SET utf8");
                $this->pdo = $link;
            }catch (PDOException $e){
                die("Failed to connect database".$e->getMessage());
            }
        }
    }

    // Read Data
    /*
        $order_by = array('order_by' => 'id DESC');
        $selectCondition = array('select' => 'name');

        $limit = array('start' => '2', 'limit' => '3');
        $limit = array('limit' => '3');
        $whereCondition = array(
            'where' => array('id' => '2', 'email' => 'info@gmail.com'),
            'return_type' => 'single'
          );

        //////////////////////////////////////

        $sql = "SELECT * FROM table_name WHERE id=:id AND email=:email LIMIT 3,7";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            return true;
        }else{
            return false;
        }
    */

    public function select($table, $data = array()){
        $sql  = 'SELECT ';
        $sql .= array_key_exists('select', $data) ? $data['select'] : '*';
        $sql .= ' FROM '.$table;
        if(array_key_exists('where', $data)){
            $sql .= " WHERE ";
            $i = 0;
            foreach($data['where'] as $key => $value){
                $and = ($i > 0) ? ' AND ' : '';
                $sql .= "$and"."$key=:$key";
                $i++;
            }
        }
        if(array_key_exists('order_by', $data)){
            $sql .= ' ORDER BY '.$data['order_by'];
        }

        if(array_key_exists('start', $data) && array_key_exists('limit', $data)){
            $sql.= ' LIMIT '.$data['start'].',' .$data['limit'];
        }elseif(!array_key_exists('start', $data) && array_key_exists('limit', $data)){
            $sql.= ' LIMIT '.$data['limit'];
        }

        $stmt = $this->pdo->prepare($sql);
        if(array_key_exists('where', $data)){
            foreach($data['where'] as $key => $value){
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->execute();

        if(array_key_exists('return_type', $data)){
            switch ($data['return_type']){
                case 'count':
                    $result = $stmt->rowCount();
                    break;
                case 'single':
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $result = '';
                    break;
            }
        }else{
            if($stmt->rowCount() > 0){
                $result = $stmt->fetchAll();
            }
        }
        return !empty($result) ? $result : false;
    }


    // Insert Data
    /*
        $sql = "INSERT INTO tbl_user (name, email, phone) VALUES (:name, :email, :phone)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $result = $stmt->execute();
    */
    public function insert($table, $data){
        if(!empty($data) && is_array($data)){
            $keys = '';
            $values = '';
            $keys   = implode(',', array_keys($data));
            $values = ":".implode(', :', array_keys($data));
            $sql    = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";
            $stmt   = $this->pdo->prepare($sql);
            foreach ($data as $key => $value){
                $stmt->bindValue(":$key", $value);
            }
            $result = $stmt->execute();
            if($result){
                $lastId = $this->pdo->lastInsertId();
                return $lastId;
            }else{
                return false;
            }
        }
    }

    // Update Data
    /*
        $sql = "UPDATE table_name SET name=:name, email=:email, phone=:phone WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
    */
    public function update($table, $data, $cond){
        if(!empty($data) && is_array($data)){
            $keyvalue  = '';
            $whereCond = '';

            $i = 0;
            foreach($data as $key => $val){
                $coma = ($i > 0) ? ', ' : '';
                $keyvalue .= "$coma"."$key=:$key";
                $i++;
            }

            if(!empty($cond) && is_array($cond)){
                $i = 0;
                foreach($cond as $key => $val){
                    $and = ($i > 0) ? ' AND ' : '';
                    $whereCond .= "$and"."$key=:$key";
                    $i++;
                }
            }
            $sql = "UPDATE ".$table." SET ".$keyvalue." WHERE ".$whereCond;
            $stmt   = $this->pdo->prepare($sql);

            foreach ($data as $key => $value){
                $stmt->bindValue(":$key", $value);
            }
            foreach ($cond as $key => $value){
                $stmt->bindValue(":$key", $value);
            }

            $result = $stmt->execute();
            return $result ? $stmt->rowCount() : false;

        }else{
            return false;
        }
    }


    // Delete Data
    /*
        $sql = "DELETE FROM table_name  WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
    */
    public function delete($table, $cond){
        if(!empty($cond) && is_array($cond)){
            $whereCond = '';
            $i = 0;
            foreach($cond as $key => $val){
                $and = ($i > 0) ? ' AND ' : '';
                //$whereCond .= $and.$key."= '".$val."'";
                $whereCond .= "$and"."$key=:$key";
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table." WHERE ".$whereCond;
        //$result = $this->pdo->exec($sql);
        //return $result ? true : false;

        $stmt   = $this->pdo->prepare($sql);
        foreach ($cond as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        $result = $stmt->execute();
        return $result ? true : false;
    }


}
