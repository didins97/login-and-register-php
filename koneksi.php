<?php 

class Database
{
    private $host = "localhost",
            $username = "root",
            $password = "",
            $database = "db_user",
            $koneksi = "";

    public function __construct()
    {
        $this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->koneksi) {
            echo 'koneksi gagal : '.mysqli_connect_errno();
        }
    }

    public function register($username, $password, $name)
    {
        $insert = mysqli_query($this->koneksi, "INSERT INTO tb_user VALUES ('','$username', '$password', '$name')");
        return $insert;
    }

    public function login($username, $password, $remember)
    {
        $query = mysqli_query($this->koneksi, "SELECT * FROM tb_user WHERE username='$username'");
        $data_user = $query->fetch_array(); // menangkap data dari query dan membentuknya kedalam array
        if (password_verify($password,$data_user['password'])) {
            if ($remember) {
                setcookie('username', $username, time() + (60*60*24*5),'/');
                setcookie('name', $data_user['name'], time() + (60*60*24*5),'/');
            }
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $data_user['name'];
            $_SESSION['is_login'] = TRUE; // jika berhasil login buatkan session is_login
            return TRUE;
        }
    }

    public function reLogin($username)
    {
        $query = mysqli_query($this->koneksi, "SELECT * FROM tb_user WHERE username='$username'");
        $data_user = $query->fetch_array();
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $data_user['name'];
        $_SESSION['is_login'] = TRUE;

    }
}


?>