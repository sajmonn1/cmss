<?php
class User {
    //właściwości klasy User czyli "co użytkownik MA"
    private $id;
    private $email;
    private $password;

    //metody klasy User czyli "co użytkownik ROBI"

    //konstruktor
    public function __construct(int $id, string $email)
    {
        //this oznacza tworzony właśnie obiekt lub instancję klasy do której się odnosimy
        $this->id = $id;
        $this->email = $email;
    }


    public static function Register(string $email, string $password) : bool {
        //funkcja rejestruje nowego użytkownika do bazy danych....
        //funkcja zwraca true jeśli się udało lub false jeśli się nie udało
        $db = new mysqli('localhost', 'root', '', 'cms');
        $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
        $q = $db->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $email, $passwordHash);
        $result = $q->execute();
        return $result;
    }
    public static function Login(string $email, string $password) : bool {
        //funkcja loguje istniejacego uzytkownika do bazy danych...
        //funkcja zapisuje użytkownika do sesji i zwraca true jeśli użytkownik istnieje
        //funkcja zwraca false jeśli użytkownik o takim haśle nie istnieje
        $db = new mysqli('localhost', 'root', '', 'cms');
        $sql = "SELECT * FROM user WHERE email = ? LIMIT 1";
        $q = $db->prepare($sql);
        $q->bind_param("s", $email);
        $q->execute();
        $result = $q->get_result();
        $row = $result->fetch_assoc();
        //tu muszą się nazwy w nawiasach [] zgadzać z nazwą kolumny w bazie danych
        $id = $row['ID'];
        $passwordHash = $row['password'];
        if(password_verify($password, $passwordHash)) {
            //hasło się zgadza
            //zapisz dane użytkownika do sesji
            $user = new User($id, $email);
            $_SESSION['user'] = $user;
            return true;
        } else {
            //hasło się nie zgadza
            return false;
        }
    }
    public function Logout() {
        //funkcja wylogowuje użytkownika

    }
}

?>