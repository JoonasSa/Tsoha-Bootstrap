<?php

class Kurssi extends BaseModel {

    public $kurssi_id, $nimi, $opintopisteet, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Kurssi");
        $query->execute();
        $rows = $query->fetchAll();
        $kurssit = array();

        foreach ($rows as $row) {
            $kurssit[] = new Kurssi(array(
                "kurssi_id" => $row["kurssi_id"],
                "nimi" => $row["nimi"],
                "opintopisteet" => $row["opintopisteet"],
                "kuvaus" => $row["kuvaus"]
            ));
        }

        return $kurssit;
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kurssi WHERE kurssi_id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();

        if ($row) {
            $kurssi = new Kurssi(array(
                "kurssi_id" => $row["kurssi_id"],
                "nimi" => $row["nimi"],
                "opintopisteet" => $row["opintopisteet"],
                "kuvaus" => $row["kuvaus"]
            ));
            return $kurssi;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kurssi (nimi, opintopisteet, kuvaus) VALUES (:nimi, :opintopisteet, :kuvaus) RETURNING kurssi_id');
        $query->execute(array('nimi' => $this->nimi, 'opintopisteet' => $this->opintopisteet, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->kurssi_id = $row['kurssi_id'];
    }

}
