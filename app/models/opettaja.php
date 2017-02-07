<?php

class Opettaja extends BaseModel {
    
    public $opettajatunnus, $etunimi, $sukunimi, $admin, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Opettaja");
        $query->execute();
        $rows = $query->fetchAll();
        $opettajat = array();
        
        foreach ($rows as $row) {
            $opettajat[] = new Opettaja(array(
                "opettajatunnus" => $row["opettajatunnus"],
                "etunimi" => $row["etunimi"],
                "sukunimi" => $row["sukunimi"],
                "admin" => $row["admin"],
                "password" => $row["password"]
            ));
        }
        
        return $opettajat;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Opettaja WHERE opettajatunnus = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        
        if ($row) {
            $opettaja = new Opettaja(array(
                "opettajatunnus" => $row["opettajatunnus"],
                "etunimi" => $row["etunimi"],
                "sukunimi" => $row["sukunimi"],
                "admin" => $row["admin"],
                "password" => $row["password"]
            ));
            return $opettaja;
        }
        
        return null;
    }
    
    //EI TESTATTU = EI VÄLTTÄMÄTTÄ TOIMI
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Opettaja (etunimi, sukunimi, admin, password) VALUES (:etunimi, :sukunimi, :admin, :password) RETURNING opettajatunnus');
        $query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'admin' => $this->admin, 'password' => $this->password));
        $row = $query->fetch();
        $this->opettajatunnus = $row['opettajatunnus'];
    }
}