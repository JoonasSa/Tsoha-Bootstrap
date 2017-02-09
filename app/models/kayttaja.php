<?php

class Kayttaja extends BaseModel {

    public $id, $username;

    public function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttaja WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        $row = $query->fetch();
        if ($row) {
            $user = new User(array(
                $id => $row['id'],
                $username => $username
            ));
            return $user;
        }
        return null;
    }

    public function authenticate($etunimi, $sukunimi, $password) {
        $username = $etunimi . ' ' . $sukunimi;
        $query1 = DB::connection()->prepare('SELECT * FROM Oppilas WHERE etunimi = :etunimi AND sukunimi = :sukunimi AND password = :password LIMIT 1');
        $query1->execute(array('etunimi' => $etunimi, 'sukunimi' => $sukunimi, 'password' => $password));
        $row1 = $query1->fetch();
        if ($row1) {
            $kayttaja = new Kayttaja(array(
                'id' => $row1['opiskelijanumero'],
                'username' => $username
            ));
            return $kayttaja;
        }
        $query2 = DB::connection()->prepare('SELECT * FROM Opettaja WHERE etunimi = :etunimi AND sukunimi = :sukunimi AND password = :password LIMIT 1');
        $query2->execute(array('etunimi' => $etunimi, 'sukunimi' => $sukunimi, 'password' => $password));
        $row2 = $query2->fetch();
        if ($row2) {
            $kayttaja = new Kayttaja(array(
                'id' => $row2['opettajatunnus'],
                'username' => $username
            ));
            return $kayttaja;
        }
        return null;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (username) VALUES (:username) RETURNING id');
        $query->execute(array('username' => $this->username));
        $row = $query->fetch();
        $this->id = $row['id'];
        return $this;
    }

}