<?php

class Kayttaja extends BaseModel {

    public $id, $username, $password, $teacher;

    public function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttaja WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        if ($row) {
            $user = new Kayttaja(array('id' => $row['id'], 'username' => $row['username'], 'teacher' => $row['teacher']));
            return $user;
        }
        return null;
    }

    public function authenticate($etunimi, $sukunimi, $password) {
        $username = $etunimi . ' ' . $sukunimi;
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE username = :username AND password = :password LIMIT 1');
        $query->execute(array("username" => $username, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $kayttaja = new Kayttaja(array('id' => $row['id'], 'username' => $username, 'teacher' => $row['teacher']));
            return $kayttaja;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (username, password, teacher) VALUES (:username, :password, :teacher) RETURNING id');
        $query->execute(array('username' => $this->username, 'password' => $this->password, 'teacher' => $this->teacher));
        $row = $query->fetch();
        $this->id = $row['id'];
        return $this;
    }

    private static function getIdentity($row) {
        $user_id = $row['id'];
        if ($row['teacher'] === true) {
            $query_opettaja = DB::connection()->prepare('SELECT * FROM Opettaja WHERE opettajatunnus = :user_id LIMIT 1');
            $query_opettaja->execute(array('user_id' => $user_id));
            $row_opettaja = $query_opettaja->fetch();
            if ($row_opettaja) {
                $kayttaja = new Kayttaja(array('id' => $row_opettaja['opettajatunnus'], 'username' => $username, 'teacher' => $row['teacher']));
                return $kayttaja;
            }
        } else {
            $query_opiskelija = DB::connection()->prepare('SELECT * FROM Oppilas WHERE opiskelijanumero = :user_id LIMIT 1');
            $query_opiskelija->execute(array('user_id' => $user_id));
            $row_opiskelija = $query_opiskelija->fetch();
            if ($row_opiskelija) {
                $kayttaja = new Kayttaja(array('id' => $row_opiskelija['opiskelijanumero'], 'username' => $username, 'teacher' => $row['teacher']));
                return $kayttaja;
            }
        }
        return null;
    }

}
