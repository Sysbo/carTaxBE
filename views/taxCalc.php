<?php include "components/header.php"; ?>

<div class="container">
    <div class="row justify-content-center">
        <main class="col-md-7 col-lg-6 mt-5 mb-5">
            <div class="calc-header text-center mb-4">
                <div class="fs-1"><i class="fa-solid fa-car text-primary"></i></div>
                <h1>Calculez les taxes de votre véhicule</h1>
                <h4>Belgique</h4>
                <small>Uniquement véhicule particulier</small>
            </div>
            <div class="text-center mb-2 d-flex justify-content-center">
                <div class="col-9">
                    <small><i class="fa-solid fa-circle-exclamation"></i> Vous trouverez ces informations sur le certificat d'immatriculation, le certificat de conformité ou la fiche produit du véhicule</small>
                </div>
            </div>
            <form class="needs-validation" id="form-taxes" method="post" novalidate>
                <div class="step " data-attribute="step" data-step="vehicle-type" data-child="mma" data-childtrigger="utility">
                    <div class="step-title">
                        Quel type de véhicule souhaitez-vous immatriculer ?
                    </div>
                    <div class="step-data">
                        <input type="radio" class="btn-check" name="vehicleType" id="car" value="car" checked required>
                        <label class="btn btn-outline-primary" for="car">Voiture</label>
                        <input type="radio" class="btn-check" name="vehicleType" id="utility" value="utility">
                        <label class="btn btn-outline-primary" for="utility">Véhicule utilitaire</label>
                    </div>
                </div>
                <div class="step hidden-step" data-attribute="step" data-step="mma">
                    <div class="step-title">
                        Quel est la masse maximale autorisée de votre véhicule ?
                    </div>
                    <div class="step-data">
                        <select class="form-select" aria-label="mma" name="mma" disabled>
                            <option selected value="0-500">0-500</option>
                            <option value="501-1000">501-1000</option>
                            <option value="1001-1500">1001-1500</option>
                            <option value="1501-2000">1501-2000</option>
                            <option value="2001-2500">2001-2500</option>
                            <option value="2501-3000">2501-3000</option>
                            <option value="3001-3501">3001-3501</option>
                        </select>
                    </div>
                </div>
                <div class="step" data-attribute="step" data-step="car-condition" data-child="registration-date" data-childtrigger="no">
                    <div class="step-title">
                        Est-ce une première immatriculation ?
                    </div>
                    <div class="step-data">
                        <input type="radio" class="btn-check" name="new" id="yes" value="yes" checked required>
                        <label class="btn btn-outline-primary" for="yes">Oui</label>
                        <input type="radio" class="btn-check" name="new" id="no" value="no">
                        <label class="btn btn-outline-primary" for="no">non</label>
                    </div>
                </div>
                <div class="step hidden-step" data-attribute="step" data-step="registration-date">
                    <div class="step-title">
                        Quel est date de première immatriculation de votre véhicule ?
                    </div>
                    <div class="step-data">
                        <input type="text" class="form-control datepicker" value="" name="registration-date" id="registration-date" disabled>
                    </div>
                </div>
                <div class="step" data-attribute="step" data-step="fuel">
                    <div class="step-title">
                        Quel est le type de carburant de votre véhicule ?
                    </div>
                    <div class="step-data">
                        <input type="radio" class="btn-check" name="fuel" id="essence" value="essence" checked required>
                        <label class="btn btn-outline-primary" for="essence">Essence</label>
                        <input type="radio" class="btn-check" name="fuel" id="diesel" value="diesel">
                        <label class="btn btn-outline-primary" for="diesel">Diesel</label>
                        <input type="radio" class="btn-check" name="fuel" id="lpg" value="lpg">
                        <label class="btn btn-outline-primary" for="lpg">LPG</label>
                        <input type="radio" class="btn-check" name="fuel" id="electric" value="electric">
                        <label class="btn btn-outline-primary" for="electric">100% électrique</label>
                    </div>
                </div>
                <div class="step" data-attribute="step" data-step="region" data-child="power" data-childtrigger="wallonia">
                    <div class="step-title">
                        Dans quelle région immatriculez-vous votre véhicule ?
                    </div>
                    <div class="step-data">
                        <input type="radio" class="btn-check" name="region" id="wallonie" value="wallonia" checked required>
                        <label class="btn btn-outline-primary" for="wallonie">Wallonne</label>
                        <input type="radio" class="btn-check" name="region" id="bruxelles" value="brussels">
                        <label class="btn btn-outline-primary" for="bruxelles">Bruxelles-Capitale</label>
                    </div>
                    <div class="step-extra">
                        <div class="step-alert">
                            <i class="fa-solid fa-circle-exclamation"></i> Pour la région flamande veuillez vous rendre à cette adresse : <a href="https://belastingen.fenb.be" target="_blank">https://belastingen.fenb.be</a>
                        </div>
                    </div>
                </div>
                <div class="step" data-attribute="step" data-step="power">
                    <div class="step-title">
                        Quelles sont les émissions de CO<sub>2</sub> de votre véhicule ?
                    </div>
                    <div class="step-data">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="co2">CO<sub>2</sub></span>
                            <input type="number" min="0" class="form-control" name="co2" placeholder="161" aria-label="" aria-describedby="co2" required>
                        </div>
                    </div>
                </div>

                <div class="step" data-attribute="step" data-step="cm3">
                    <div class="step-title">
                        Quelle est la cylindré de votre véhicule ?
                        <!--<i class="fa-solid fa-circle-info"></i>-->
                    </div>
                    <div class="step-data">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="cylinder">cm<sup>3</sup></span>
                            <input type="number" min="0" class="form-control" placeholder="1161" name="cm3" aria-label="" aria-describedby="cylinder" required>
                        </div>
                    </div>
                </div>
                <div class="step" data-attribute="step" data-step="kw">
                    <div class="step-title">
                        Quelle est la puisance en kW de votre véhicule ?
                    </div>
                    <div class="step-data">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="kw">kW</span>
                            <input type="number" min="0" class="form-control" name="kw" placeholder="81" aria-label="" aria-describedby="kw" required>
                        </div>
                    </div>
                </div>
                <!--<div class="col-12">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-block btn-lg" type="submit">Calculer les taxes</button>
                    </div>
                </div>-->
            </form>
        </main>
        <aside class="col-md-5 col-lg-4">
            <div class="sticky-top">
                <div id="tax-result">
                    <div id="tax-result-ajax">
                        <?php $vehicle = null ?>
                        <?php require('views/components/taxResult.php'); ?>
                    </div>
                </div>

                <div class="saved-vehicle" id="saved-vehicles">
                    <?php require('views/components/savedVehicles.php'); ?>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'fr',
            autoclose: true
        }).on("changeDate", function(e) {
            $("#form-taxes").submit();
        });
    });
</script>

<?php include "components/footer.php";
