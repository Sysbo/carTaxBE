<?php

namespace app\model;

use \Datetime;

class Vehicle
{

    /**
     * Type of vehicle
     * [car, utility]
     * @var string
     */
    public $vehicleType;

    /**
     * Region
     * [wallonia, brussels]
     * @var string
     */
    public $region;

    /**
     * @var boolean
     */
    public $new;

    /**
     * First registration
     * DD/MM/YYYY
     * @var date
     */
    public $firstRegis;

    /**
     * Type of fuel
     * @var string
     */
    public $fuel;

    /**
     * Cylindré
     * @var int
     */
    public $cm3;

    /**
     * Chevaux fiscaux
     * @var int
     */
    public $cv;

    /**
     * co2 emission
     * @var int
     */
    public $co2;

    /**
     * kilowatts
     * @var int
     */
    public $kw;

    /**
     * Masse Maximal Autorisée
     * ["0-500","501-1000","1001-1500","1501-2000","2001-2500","2501-3000","3001-3501"]
     * @var string
     */
    public $mma;

    /**
     * Age du véhicule
     * @var int
     */
    public $age = 0;

    /**
     * Nom du véhicule
     * @var String
     */
    public $name;



    public function __construct()
    {
    }

    /**
     * Remplissage de l'objet sur base d'une chaine JSON
     */
    public function populateFromJson($json)
    {
        $data = json_decode($json);
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'vehicleType':
                    $this->vehicleType = $val;
                    break;
                case 'region':
                    $this->region = $val;
                    break;
                case 'new':
                    $this->new = $val;
                    break;
                case 'firstRegis':
                    $this->firstRegis = $val;
                    break;
                case 'fuel':
                    $this->fuel = $val;
                    break;
                case 'cm3':
                    $this->cm3 = $val;
                    break;
                case 'cv':
                    $this->cv = $val;
                    break;
                case 'co2':
                    $this->co2 = $val;
                    break;
                case 'kw':
                    $this->kw = $val;
                    break;
                case 'mma':
                    $this->mma = $val;
                    break;
                case 'age':
                    $this->age = $val;
                    break;
                case 'name':
                    $this->name = $val;
                    break;
            }
        }
    }

    /**
     * Calcul de la taxe de circulation
     */
    public function calcTC()
    {
        $tc = new TC($this);
        return $tc->computeTC();
    }

    /**
     * Calcul de la taxe de mise en circulation
     */
    public function calcTMC()
    {
        $tmc = new TMC($this);
        return $tmc->computeTMC();
    }

    /**
     * Calcul du malus CO2
     */
    public function calcMalus()
    {
        $malus = new Malus($this);
        return $malus->computeMalus();
    }

    /**
     * Ajout de la cylindré du véhicule et calcul des chevaux fiscaux sur cette base
     */
    public function setCm3($cyl)
    {
        $this->cm3 = $cyl;
        $cvCalc = new CV();
        $this->cv = $cvCalc->calcCV($cyl);
    }

    /**
     * Calcul de l'age du véhicule sur base de sa date de première immatriculation
     */
    public function setAge($date)
    {
        $date = str_replace('/', '-', $date);
        $regist = new DateTime($date);
        $today     = new DateTime();
        $interval  = $today->diff($regist);
        $this->age = $interval->y;
    }

    /**
     * Calcul du total des taxes
     */
    public function getTotalTaxes()
    {
        return $total = $this->calcTC() + $this->calcTMC() + $this->calcMalus();
    }

    /**
     * calcul du coût sur plusieurs années
     */
    public function getLongTermCost($year)
    {
        return $this->calcTMC() + $this->calcMalus() + ($this->calcTC() * $year);
    }

    /**
     * Récupérer le type du véhicule en français
     */
    public function getVehicleType()
    {
        if (!empty($this->vehicleType)) {
            switch ($this->vehicleType) {
                case 'car':
                    return "Voiture";
                    break;
                case 'utility':
                    return "Véhicule utilitaire";
                    break;
            }
        } else {
            return null;
        }
    }

    /**
     * Récupérer la région en français
     */
    public function getRegion()
    {
        if (!empty($this->region)) {
            switch ($this->region) {
                case 'wallonia':
                    return "Wallonie";
                    break;
                case 'brussels':
                    return "Bruxelles";
                    break;
            }
        } else {
            return null;
        }
    }

    /**
     * Récupérer le type de "carburant" en français
     */
    public function getFuel()
    {
        if (!empty($this->fuel)) {
            switch ($this->fuel) {
                case 'essence':
                    return "Essence";
                    break;
                case 'diesel':
                    return "Diesel";
                    break;
                case 'LPG':
                    return "LPG";
                    break;
                case 'electric':
                    return "100% électrique";
                    break;
            }
        } else {
            return null;
        }
    }
}
