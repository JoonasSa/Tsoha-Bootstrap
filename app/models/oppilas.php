<?php

class Oppilas extends BaseModel {
    
    public $opiskelijanumero, $etunimi, $sukunimi, $opintopisteet, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Oppilas");
        $query->execute();
        $rows = $query->fetchAll();
        $students = array();
        
        foreach ($rows as $row) {
            $students[] = new Oppilas(array(
                "opiskelijanumero" => $row["opiskelijanumero"],
                "etunimi" => $row["etunimi"],
                "sukunimi" => $row["sukunimi"],
                "opintopisteet" => $row["opintopisteet"],
                "password" => $row["password"]
            ));
        }
        
        return $students;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Oppilas WHERE opiskelijanumero = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        
        if ($row) {
            $student = new Oppilas(array(
                "opiskelijanumero" => $row["opiskelijanumero"],
                "etunimi" => $row["etunimi"],
                "sukunimi" => $row["sukunimi"],
                "opintopisteet" => $row["opintopisteet"],
                "password" => $row["password"]
            ));
            return $student;
        }
        
        return null;
    }
}