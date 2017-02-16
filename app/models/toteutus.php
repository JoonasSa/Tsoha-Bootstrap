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
    
    public static function oneLeftJoinKurssiOpe($id) {
        $query = DB::connection()->prepare("SELECT * FROM Toteutus LEFT JOIN Kurssi ON "
                . "(Toteutus.kurssi_id = Kurssi.kurssi_id) LEFT JOIN Opettaja ON "
                . "(Toteutus.vastuu_id = Opettaja.opettajatunnus) WHERE tote_id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();
        $toteutusjoin = array();
        
        if ($row) {
            $toteutusjoin[] = array(
                "tote_id" => $row["tote_id"],
                "periodi" => $row["periodi"],
                "alkupvm" => $row["alkupvm"],
                "koepvm" => $row["koepvm"],
                "info" => $row["info"],
                "vastuu_id" => $row["vastuu_id"],
                "kurssi_id" => $row["kurssi_id"],
                "nimi" => $row["nimi"],
                "opettaja" => $row["etunimi"] . " " . $row["sukunimi"],
                "opintopisteet" => $row["opintopisteet"]);
        }    
        
        return $toteutusjoin;
    }

    public static function allLeftJoinKurssiOpe() {
        $query = DB::connection()->prepare("SELECT * FROM Toteutus LEFT JOIN Kurssi ON "
                . "(Toteutus.kurssi_id = Kurssi.kurssi_id) LEFT JOIN Opettaja ON "
                . "(Toteutus.vastuu_id = Opettaja.opettajatunnus) ORDER BY Toteutus.periodi ASC, "
                . "Kurssi.nimi ASC");
        $query->execute();
        $rows = $query->fetchAll();
        $toteutusjoin = array();
        
        foreach ($rows as $row) {
            $toteutusjoin[] = array(
                "tote_id" => $row["tote_id"],
                "periodi" => $row["periodi"],
                "alkupvm" => $row["alkupvm"],
                "koepvm" => $row["koepvm"],
                "info" => $row["info"],
                "vastuu_id" => $row["vastuu_id"],
                "kurssi_id" => $row["kurssi_id"],
                "nimi" => $row["nimi"],
                "opettaja" => $row["etunimi"] . " " . $row["sukunimi"],
                "opintopisteet" => $row["opintopisteet"]
            );
        }
        
        return $toteutusjoin;
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Toteutus SET periodi = :periodi, alkupvm = :alkupvm, koepvm = :koepvm, '
                . 'info = :info, vastuu_id = :vastuu_id, kurssi_id = :kurssi_id WHERE tote_id = :tote_id');
        $query->execute(array('tote_id' => $this->tote_id, 'periodi' => $this->periodi, 'alkupvm' => $this->alkupvm, 'koepvm' => $this->koepvm, 
                'info' => $this->info, 'vastuu_id' => $this->vastuu_id, 'kurssi_id' => $this->kurssi_id));
    }
    
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Toteutus WHERE tote_id = :tote_id');
        $query->execute(array('tote_id' => $this->tote_id));
    }
}