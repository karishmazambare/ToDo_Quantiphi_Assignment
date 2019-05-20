<?php

namespace{

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if (!isset($_SESSION)) {
        session_start();
    }

    /**
     * This class is used for database operations.
     */
    class DBconnect
    {
        protected $DBconnection;
        protected $DBname;
        private static $obj;

        /**
         * Constructer is used for database connection.
         */
        private function __construct()
        {
        }

        public function createConnection()
        {

            try {
                $this->DBname="todo_list";
                $this->DBconnection = new PDO('mysql:host=localhost;port=3306;', 'root', '');
                $this->DBconnection->query("CREATE DATABASE IF NOT EXISTS $this->DBname");
                $this->DBconnection->query("use $this->DBname");
                // Create Login Table
                $stmt = $this->DBconnection->prepare('CREATE TABLE IF NOT EXISTS login(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, Name varchar(30) NOT NULL, username varchar(20) NOT NULL UNIQUE, password varchar(20) NOT NULL, email varchar(50) NOT NULL UNIQUE)');
                $stmt->execute();

                // Create Task Table
                $stmt = $this->DBconnection->prepare('CREATE TABLE IF NOT EXISTS task(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, task_detail varchar(200) NOT NULL, user_id int NOT NULL,is_complete boolean)');
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public static function createObj()
        {
            if (!self::$obj) {
                self::$obj=new self();
                self::$obj->createConnection();
            }
            return self::$obj;
        }

        /**
         * This function is used for login authentication.
         * @param  [string] $user [username of user]
         * @param  [string] $pass [password of user]
         * @return [type]       [description]
         */
        public function login($user, $pass)
        {
            try {
                $stmt = $this->DBconnection->prepare('SELECT id,Name,username,password FROM login WHERE username=:uname AND password=:pass');
                $stmt->bindParam(':uname', $user);
                $stmt->bindParam(':pass', $pass);
                $stmt->execute();
                $row = $stmt->fetch();
                $this->DBconnection = null;   /*** close the database connection ***/
                if ($user== $row['username'] && $pass==$row['password']) {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['name'] = $row['Name'];
                    $_SESSION['id'] = $row['id'];
                    header('Location: home.php'); /* Redirect browser to home after login */
                     exit();
                } else {
                    echo 'Invalid Username or Password';
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * [This function is used to insert data in database]
         * @param  [String] $name  [Name of user]
         * @param  [String] $uname [username of user]
         * @param  [String] $pwd   [password of user]
         * @param  [String] $email [email of user]
         * @return [String]        [description]
         */
        public function reg($name, $uname, $pwd, $email)
        {
            try {
                /***Code to check unique username and email***/

                $stmt = $this->DBconnection->prepare('SELECT username,email FROM login where username=:uname && email=:mail');
                $stmt->bindParam(':uname', $uname);
                $stmt->bindParam(':mail', $email);
                $count = $stmt->execute();
                while ($row = $stmt->fetch()) {
                    if ($uname == $row['username'] || $email == $row['email']) {
                        echo 'Username or email already registered';
                        return;
                    }
                }

            // Insert Query
                $stmt = $this->DBconnection->prepare('INSERT INTO login(Name,username,password,email) VALUES (:name, :uname, :pwd, :email)');
            //Bind Parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':uname', $uname);
                $stmt->bindParam(':pwd', $pwd);
                $stmt->bindParam(':email', $email);
                // var_dump($stmt);
                $count = $stmt->execute();

                $_SESSION['username'] = $uname;  //Update session variable
                $_SESSION['name'] = $name;
                $_SESSION['id'] = $this->DBconnection->lastInsertId();       //Update session variable


                header('Location: home.php'); /* Redirect browser to home after login */
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            /*** close the database connection ***/
                $this->DBconnection = null;
        }

        public function insertTask($task)
        {
            try {

            // Insert Query
                $stmt = $this->DBconnection->prepare('INSERT INTO task(task_detail,user_id,is_complete) VALUES (:task, :uid, 0)');
            //Bind Parameters
                $stmt->bindParam(':task', $task);
                $stmt->bindParam(':uid', $_SESSION['id']);
                // var_dump($stmt);
                $count = $stmt->execute();
                $insertID = $this->DBconnection->lastInsertId();
                echo json_encode(array ('status' => 'success',
                'insertId' => $insertID
                ));
                // header('Location: home.php'); /* Redirect browser to home after adding task */
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            /*** close the database connection ***/
                $this->DBconnection = null;
        }

        public function fetchTask()
        {
            $stmt = $this->DBconnection->prepare('SELECT * FROM task where user_id=:uid');
            $stmt->bindParam(':uid', $_SESSION['id']);
            $stmt->execute();
            $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if (null != $row) {
                return $row;
            }
            /*** close the database connection ***/
                $this->DBconnection = null;
        }

        public function deleteTask($id)
        {
            $stmt = $this->DBconnection->prepare('DELETE FROM task WHERE id = :task_id');
            $stmt->bindParam(':task_id', $id);
            $stmt->execute();
            echo json_encode(array ('status' => 'success',
                'deleteId' => $id
                ));
        }

        public function markComplete($id, $completeStatus)
        {
            $stmt = $this->DBconnection->prepare('UPDATE task SET is_complete=:complete_status WHERE id = :task_id');
            $stmt->bindParam(':complete_status', $completeStatus);
            $stmt->bindParam(':task_id', $id);
            // $stmt->bindParam(':uid', $_SESSION['id']);
            $stmt->execute();
        }

        public function updateTask($task, $id)
        {
            $stmt = $this->DBconnection->prepare('UPDATE task SET task_detail=:task_detail WHERE id = :task_id AND user_id = :uid');
            $stmt->bindParam(':task_detail', $task);
            $stmt->bindParam(':task_id', $id);
            $stmt->bindParam(':uid', $_SESSION['id']);
            $stmt->execute();
            $insertID = $this->DBconnection->lastInsertId();
                echo json_encode(array ('status' => 'success',
                'insertId' => $insertID
                ));
        }

    }
}
