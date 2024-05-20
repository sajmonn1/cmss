<?php
class User {
    private $id;
    private $login;
    private $password;

    public function __construct(int $id, string $login, string $password) {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    public static function Register(string $login, string $password) : bool {
        $db = new mysqli("localhost", "root", "", "cms");
        if ($db->connect_errno) {
            echo "Failed to connect to MySQL: ". $db->connect_error;
            exit();
        }

        $sql = "INSERT INTO user (login, password) VALUES (?,?)";
        $q = $db->prepare($sql);
        if (!$q) {
            echo "Error preparing query: ". $db->error;
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $login, $passwordHash);
        $result = $q->execute();

        if (!$result) {
            echo "Error executing query: ". $db->error;
            exit();
        }

        $db->close();
        return $result;
    }

    public static function Login(string $login, string $password) : bool {
        $db = new mysqli("localhost", "root", "", "cms");
        if ($db->connect_errno) {
            echo "Failed to connect to MySQL: ". $db->connect_error;
            exit();
        }

        $sql = "SELECT password FROM user WHERE login =?";
        $q = $db->prepare($sql);
        if (!$q) {
            echo "Error preparing query: ". $db->error;
            exit();
        }

        $q->bind_param("s", $login);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return false;
        }

        if (password_verify($password, $row['password'])) {
            return true;
        } else {
            return false;
        }

        $db->close();
    }

    public function Logout() {
        session_destroy();
    }

    public function ChangePassword(string $oldLogin, string $newPassword) : bool {
        $db = new mysqli("localhost", "root", "", "cms");
        if ($db->connect_errno) {
            echo "Failed to connect to MySQL: ". $db->connect_error;
            exit();
        }

        $sql = "SELECT password FROM user WHERE login =?";
        $q = $db->prepare($sql);
        if (!$q) {
            echo "Error preparing query: ". $db->error;
            exit();
        }

        $q->bind_param("s", $this->login);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {
            return false;
        }

        if (password_verify($oldLogin, $row['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_ARGON2I);
            $sql = "UPDATE user SET password =? WHERE login =?";
            $q = $db->prepare($sql);
            if (!$q) {
                echo "Error preparing query: ". $db->error;
                exit();
            }

            $q->bind_param("si", $newPasswordHash, $this->login);
            $result = $q->execute();

            if (!$result) {
                echo "Error executing query: ". $db->error;
                exit();
            }

            return true;
        } else {
            return false;
        }

        $db->close();
    }

    public static function isLogged() {
        if(isset($_SESSION['user']))
            return true;
        else 
            return false;
    }
}
?>