<?php

namespace app\model;

class Malus
{

    public $spreadSheet;
    public $vehicle;

    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
        $this->spreadSheet = json_decode(file_get_contents("spreadSheet/malus.json"), true);
    }

    /**
     * Calcul du malus appliqué en wallonie concernant les émissions de CO2
     */
    public function computeMalus()
    {
        if($this->vehicle->region != "wallonia")
            return 0;
        foreach ($this->spreadSheet as $key => $val) {
            $range = explode('-', $key);
                if ($this->vehicle->co2 >= $range[0] && $this->vehicle->co2 <= $range[1]) {
                    return $this->spreadSheet[$key];
                }
        }
    }
}
