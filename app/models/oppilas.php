<?php

class Oppilas extends BaseModel {

    public $opiskelijanumero, $etunimi, $sukunimi, $opintopisteet;

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
                "opintopisteet" => $row["opintopisteet"]
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
                "opintopisteet" => $row["opintopisteet"]
            ));
            return $student;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Oppilas (etunimi, sukunimi, opintopisteet, opiskelijanumero) VALUES (:etunimi, :sukunimi, :opintopisteet, :opiskelijanumero)');
        $query->execute(array('etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'opintopisteet' => $this->opintopisteet, 'opiskelijanumero' => $this->opiskelijanumero));
    }
    
    public static function get_op($id) {
        $student = self::find($id);
        return $student->opintopisteet;
    } 

}
