<?php

namespace app\model;

class TMC
{

    public $spreadSheet;
    public $vehicle;

    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
        $this->spreadSheet = json_decode(file_get_contents("spreadSheet/tmc.json"), true);
    }

    /**
     * Calcul de la taxe de mise en circulation
     */
    public function computeTMC()
    {
        $tcTotal = 0;
        if ($this->vehicle->vehicleType == "utility")
            return $tcTotal;

        switch ($this->vehicle->fuel) {
            case 'lpg':
                $type = 'lpg';
                break;
            case 'electric':
                $type = 'electric';
                break;
            default:
                $type = 'generic';
                break;
        }

        if ($type == "electric")
            return  $this->spreadSheet["electric"];

        $cvVal = 0;
        $kwVal = 0;
        $age = $this->vehicle->age;

        /**
         * On parcours le tableau et récupère le montant de la puissance dans le quel on se trouve.
         */
        foreach ($this->spreadSheet["others"] as $key => $val) {
            $cvRange = explode('-', $val["cv"]);
            $kwRange = explode('-', $val["kw"]);

            if ($type == "generic") :
                $count = count($val["generic"]) - 1;
            elseif ($type == "lpg") :
                $count = count($val["lpg"]) - 1;
            else :
                $count = null;
            endif;

            if ($this->vehicle->age > $count):
                $age = $count;
            else:
                $age = $this->vehicle->age;
            endif;

            if ($this->vehicle->cv >= $cvRange[0] && $this->vehicle->cv <= $cvRange[1]) {
                $cvVal = $val[$type][$age];
            }

            if ($this->vehicle->kw >= $kwRange[0] && $this->vehicle->kw <= $kwRange[1]) {
                $kwVal = $val[$type][$age];
            }
        }

        /**
         * On renvoie la valeur la plus élevée des deux
         */
        if ($cvVal >= $kwVal) {
            return $cvVal;
        } elseif ($kwVal > $cvVal) {
            return $kwVal;
        } else {
            return null;
        }
    }
}
