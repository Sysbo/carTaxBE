<?php

namespace app\model;

class CV
{
    public $fiscalPower;

    public function __construct()
    {
        $this->fiscalPower = json_decode(file_get_contents("spreadSheet/cv.json"), true);
    }

    /**
     * Calcul des chevaux fiscaux sur base de la cylindré
     */
    public function calcCV($cm3)
    {
        $array_keys = array_keys($this->fiscalPower);
        $last_key = end($array_keys);

        foreach ($this->fiscalPower as $key => $val) {
            $range = explode('-', $key);
            if ($cm3 >= $range[0] && $cm3 <= $range[1]) {
                return intval($this->fiscalPower[$key]);
            } elseif ($key == $last_key) {
                return intval(ceil((($cm3 - $range[1]) / 200) + $this->fiscalPower[$key]));
            }
        }

        return null;
    }
}
