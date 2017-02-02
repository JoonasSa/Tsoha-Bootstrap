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
}