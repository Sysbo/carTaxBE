<?php

namespace app\model;

class TC
{

    public $spreadSheet;
    public $vehicle;

    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
        $this->spreadSheet = json_decode(file_get_contents("spreadSheet/tc.json"), true);
    }

    /**
     * Calcul de la taxe de circulation
     */
    public function computeTC()
    {
        if ($this->vehicle->vehicleType != "utility") {
            return $this->calcGenericTC();
        } else {
            return $this->calcUtilityTC();
        }
    }

    /**
     * Calcul de la taxe de circulation des véhicules utilitaires
     */
    private function calcUtilityTC()
    {
        $tcTotal = 0;
        $tcTotal = $this->spreadSheet["utilityVehicle"][$this->vehicle->mma];
        return $tcTotal;
    }

    /**
     * Calcul de la taxe de circulation des véhicules classiques
     */
    private function calcGenericTC()
    {
        $countVal = count($this->spreadSheet["generic"]["base"]);
        $tcTotal = 0;
        if ($this->vehicle->cv < 1 || empty($this->vehicle->fuel))
            return null;

        if ($this->vehicle->cv <= $countVal) {
            $tcTotal += $this->spreadSheet["generic"]["base"][$this->vehicle->cv];
        } else {
            $tcTotal += $this->spreadSheet["generic"]["base"][$countVal] + ($this->spreadSheet["generic"]["extra"] * ($this->vehicle->cv - $countVal) );
        }

        if ($this->vehicle->fuel == "lpg") {
            foreach ($this->spreadSheet["lpg"] as $key => $val) {
                $range = explode('-', $key);
                if ($this->vehicle->cv >= $range[0] && $this->vehicle->cv <= $range[1]) {
                    $tcTotal += $val;
                    break;
                }
            }
        }

        return $tcTotal;
    }
}
