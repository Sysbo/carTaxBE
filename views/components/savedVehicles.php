<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once($class . '.php');
});

use app\model\Vehicle;

if (!isset($_SESSION["vehicles"])) {
    $_SESSION["vehicles"] = array();
}

?>

<div class="mt-4 mb-4">
    <h5><i class="fa-solid fa-car text-primary"></i> Véhicules sauvegardés</h5>
    <div class="mb-2">
        <small><i class="fa-solid fa-circle-exclamation"></i> Les véhicules enregistrés seront supprimés une fois votre session terminée.</small>
    </div>
    <?php if (!empty($_SESSION["vehicles"])) : ?>
        <div class="d-grid gap-2">
            <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#compare-vehicles">
                <i class="fa-solid fa-table-list"></i> Comparer les véhicules
            </button>
        </div>
        <div>
            <div class="accordion accordion-flush" id="vehicle-list">
                <?php foreach ($_SESSION["vehicles"] as $key => $val) : ?>
                    <?php
                    $vehicle = new Vehicle();
                    $vehicle->populateFromJson($val[1]->value);
                    $vehicle->name = $val[0]->value;
                    ?>

                    <div class="accordion-item mb-1">
                        <h2 class="accordion-header" id="vehicle-heading-<?php echo $key ?>">
                            <button class="saved-vehicle-button accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#vehicle-collapse-<?php echo $key ?>" aria-expanded="false" aria-controls="vehicle-collapse-<?php echo $key ?>">
                                <?php echo number_format($vehicle->getTotalTaxes(), 2, ',', ' ') . " € - " . $vehicle->name; ?>
                            </button>
                        </h2>
                        <div id="vehicle-collapse-<?php echo $key ?>" class="accordion-collapse collapse" aria-labelledby="vehicle-heading-<?php echo $key ?>" data-bs-parent="#vehicle-list">
                            <div class="saved-vehicle-body">
                                <div class="saved-vehicle-data">
                                    <?php if ($vehicle->vehicleType) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->getVehicleType() . '</span>'; ?>
                                    <?php if ($vehicle->region) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->getRegion() . '</span>'; ?>
                                    <?php if ($vehicle->fuel) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->getFuel() . '</span>'; ?>
                                    <?php if ($vehicle->firstRegis) echo '<span class="badge rounded-pill bg-primary">1<sup>re</sup> immat. : ' . $vehicle->firstRegis . '</span>'; ?>
                                    <?php if ($vehicle->new) echo '<span class="badge rounded-pill bg-primary">1<sup>re</sup> immat.</span>'; ?>
                                    <?php if ($vehicle->cv) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->cv . ' cv</span>'; ?>
                                    <?php if ($vehicle->cm3) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->cm3 . ' cm<sup>3</sup></span>'; ?>
                                    <?php if ($vehicle->kw) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->kw . ' kW</span>'; ?>
                                    <?php if ($vehicle->co2) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->co2 . ' CO<sub>2</sub></span>'; ?>
                                    <?php if ($vehicle->mma) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->mma . ' mma</span>'; ?>
                                    <?php if ($vehicle->age) echo '<span class="badge rounded-pill bg-primary">' . $vehicle->age . ' an(s)</span>'; ?>
                                </div>
                                <div class="d-flex">
                                    <div class="col-8">
                                        <b>Taxe de mise en circulation</b>
                                    </div>
                                    <div class="col-4 text-end">
                                        <?php echo number_format($vehicle->calcTMC(), 2, ',', ' '); ?> €
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="col-8">
                                        <b>Taxe de circulation</b>
                                    </div>
                                    <div class="col-4 text-end">
                                        <?php echo number_format($vehicle->calcTC(), 2, ',', ' '); ?> €
                                    </div>
                                </div>
                                <?php if ($vehicle->region == "wallonia") : ?>
                                    <div class="d-flex">
                                        <div class="col-8">
                                            <b>Malus CO<sub>2</sub></b>
                                        </div>
                                        <div class="col-4 text-end">
                                            <?php echo number_format($vehicle->calcMalus(), 2, ',', ' '); ?> €
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <hr>
                                </div>
                                <div class="d-flex">
                                    <div class="col-8">
                                        <h5>Total</h5>
                                    </div>
                                    <div class="col-4 text-end">
                                        <h5><?php echo number_format($vehicle->getTotalTaxes(), 2, ',', ' '); ?> €</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="saved-vehicle-body dotted-border mb-2">
                                <h6 class="m-0"><label for="long-term-cost-slider-<?php echo $key; ?>" class="form-label"><i class="fa-solid fa-calendar text-primary"></i> Coût sur plusieurs années</label></h6>

                                <input onchange="longTermSlider(this)" onload="longTermSlider(this)" type="range" class="form-range" min="2" max="20" step="1" id="long-term-cost-slider-<?php echo $key; ?>" name="long-term-slider" value="2" data-tmc="<?php echo $vehicle->calcTMC() ?>" data-tc="<?php echo $vehicle->calcTC() ?>" data-malus="<?php echo $vehicle->calcMalus() ?>">
                                <div class="d-flex">
                                    <div class="col-4 long-term-cost-year">2 ans</div>
                                    <div class="col-8 text-end long-term-cost-result"><?php echo number_format($vehicle->getLongTermCost(2), 2, ',', ' '); ?> €</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <div>
            Aucun véhicules enregistrés
        </div>
    <?php endif; ?>

</div>

<?php
$longTermArray = array();
foreach ($_SESSION["vehicles"] as $key => $val) :
    $vehicle = new Vehicle();
    $vehicle->populateFromJson($val[1]->value);
    $vehicle->name = $val[0]->value;
    $max = $vehicle->calcTMC() + $vehicle->calcMalus() + ($vehicle->calcTC() * 6);
    $longTermArray[$key]["max"] = $max;
    $longTermArray[$key]["name"] = $vehicle->name;
    for ($i = 1; $i <= 6; $i++) {
        $longTermArray[$key]["data"][] = $vehicle->calcTMC() + $vehicle->calcMalus() + ($vehicle->calcTC() * $i);
    }
endforeach;
asort($longTermArray);
?>

<!-- Modal -->
<div class="modal fade" id="compare-vehicles" tabindex="-1" aria-labelledby="compare-vehicles-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="compare-vehicles-label"><i class="fa-solid fa-award text-primary"></i> Tableau comparatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">1 an</th>
                                <th scope="col">2 ans</th>
                                <th scope="col">3 ans</th>
                                <th scope="col">4 ans</th>
                                <th scope="col">5 ans</th>
                                <th scope="col">6 ans</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($longTermArray as $key => $val) : ?>
                                <tr <?php if ($i == 1) echo 'class="table-primary"' ?>>
                                    <th scope="row"><?php echo "#" . $i; ?></th>
                                    <td><b>
                                            <?php
                                            if ($i == 1)
                                                echo '<i class="fa-solid fa-trophy text-primary"></i> ';
                                            echo $val["name"];
                                            ?></b>
                                    </td>
                                    <?php foreach ($val["data"] as $k => $v) : ?>
                                        <td><?php echo number_format($v, 2, ',', ' '); ?> €</td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>