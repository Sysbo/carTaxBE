<div class="tax-result">
    <div class="tax-receipt-header">
        <h3 class="m-0"><i class="fa-solid fa-receipt text-primary"></i> Taxes</h3>
    </div>
    <?php if ($vehicle) : ?>
        <div class="tax-receipt-body">
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
        <div class="tax-receipt-body mb-2">
            <h6 class="m-0"><label for="long-term-cost-slider-main" class="form-label"><i class="fa-solid fa-calendar text-primary"></i> Coût sur plusieurs années</label></h6>
            <input onchange="longTermSlider(this)" type="range" class="form-range" min="2" max="20" step="1" id="long-term-cost-slider-main" name="long-term-slider" value="2" data-tmc="<?php echo $vehicle->calcTMC() ?>" data-tc="<?php echo $vehicle->calcTC() ?>" data-malus="<?php echo $vehicle->calcMalus() ?>">
            <div class="d-flex">
                <div class="col-4 long-term-cost-year">2 ans</div>
                <div class="col-8 text-end long-term-cost-result"><?php echo number_format($vehicle->getLongTermCost(2), 2, ',', ' '); ?> €</div>
            </div>
        </div>
        <div class="tax-receipt-footer">

            <form class="needs-validation" id="save-vehicle" method="post" onsubmit="saveVehicle(this, event)" novalidate>
                <div class="d-grid gap-2">

                    <h6 class="m-0"><label for="name" class="form-label"><i class="fa-solid fa-tag text-primary"></i> Donnez un nom à votre véhicule</label></h6>
                    <input class="form-control form-control-sm" type="text" id="name" name="name" placeholder="Ex: Marque et modèle" required>
                    <input type="hidden" id="vehicle" name="vehicle" value='<?php echo json_encode($vehicle); ?>' required>
                    <button class="btn btn-primary btn-sm" type="submit" data-vehicle='<?php echo json_encode($vehicle); ?>'><i class="fa-solid fa-bookmark"></i> Sauvegarder ce véhicule</button>

                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="tax-receipt-body">
            <div class="alert alert-light" role="alert">
                <div class="d-flex">
                    <div class="fs-2 me-2">
                        <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                    </div>
                    <div class="">
                        <!--Entrez les données du véhicule afin de générer le calcul des taxes.</br>--> Complétez ou modifiez les données du formulaire pour générer le calcul des taxes.
                    </div>
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>