<?php

class Toteutus extends BaseModel {
    
    public $tote_id, $periodi, $alkupvm, $koepvm, $info, $vastuu_id, $kurssi_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Toteutus");
        $query->execute();
        $rows = $query->fetchAll();
        $toteutukset = array();
        
        foreach ($rows as $row) {
            $toteutukset[] = new Toteutus(array(
                "tote_id" => $row["tote_id"],
                "periodi" => $row["periodi"],
                "alkupvm" => $row["alkupvm"],
                "koepvm" => $row["koepvm"],
                "info" => $row["info"],
                "vastuu_id" => $row["vastuu_id"],
                "kurssi_id" => $row["kurssi_id"]
            ));
        }
        
        return $toteutukset;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Toteutus WHERE tote_id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
  
        if ($row) {
            $toteutus = new Toteutus(array(
                "tote_id" => $row["tote_id"],
                "periodi" => $row["periodi"],
                "alkupvm" => $row["alkupvm"],
                "koepvm" => $row["koepvm"],
                "info" => $row["info"],
                "vastuu_id" => $row["vastuu_id"],
                "kurssi_id" => $row["kurssi_id"]
            ));
            return $toteutus;
        }
        
        return null;
    }
}

