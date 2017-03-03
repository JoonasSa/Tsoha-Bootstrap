<?php

class Kayttaja extends BaseModel {

    public $id, $username, $password, $teacher, $admin;

    public function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttaja WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        if ($row) {
            $user = new Kayttaja(array('id' => $row['id'], 'username' => $row['username'], "admin" => $row['admin'], 'teacher' => $row['teacher']));
            return $user;
        }
        return null;
    }
    
    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Kayttaja");
        $query->execute();
        $rows = $query->fetchAll();
        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = new Kayttaja(array(
                "id" => $row["id"],
                "username" => $row['username'],
                "password" => $row["password"],
                "admin" => $row['admin'],
                "teacher" => $row["teacher"]
            ));
        }
        return $kayttajat;
    }

    public function authenticate($etunimi, $sukunimi, $password) {
        $username = $etunimi . ' ' . $sukunimi;
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array("username" => $username, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja(array('id' => $row['id'], 'username' => $username, 'admin' => $row['admin'], 'teacher' => $row['teacher']));
            return $kayttaja;
        }
        return null;
    }
    
    public function update_password($password) {
        $query = DB::connection()->prepare('UPDATE Kayttaja SET password = :password WHERE id = :id');
        $query->execute(array('password' => $password, 'id' => $this->id));
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (username, password, teacher) VALUES (:username, :password, :teacher) RETURNING id');
        $query->bindValue(":teacher", $this->teacher, PDO::PARAM_INT);
        $query->execute(array('username' => $this->username, 'password' => $this->password, 'teacher' => $this->teacher));
        $row = $query->fetch();
        $this->id = $row['id'];
        return $this;
    }

}
