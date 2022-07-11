"use strict";

$('[data-attribute="step"]').on('change', function (e) {
    activateChild(this);
});

function activateChild(step) {
    var child = $(step).attr("data-child");

    if (child) {
        var dataTrigger = $(step).attr("data-childtrigger");
        var selectVal = $(step).find('input:checked').val();

        if (dataTrigger == selectVal) {
            $('[data-step="' + child + '"]').show();
            $('[data-step="' + child + '"]').find("input, textarea, select").each(function (index) {
                $(this).prop('required', true);
                $(this).prop('disabled', false);
            });
        } else {
            $('[data-step="' + child + '"]').hide();
            $('[data-step="' + child + '"]').find("input, textarea, select").each(function (index) {
                $(this).prop('disabled', true);
                $(this).prop('required', false);
            });
        }

    }
}

$("#form-taxes").on("change submit", function (event) {
    event.preventDefault()
    event.stopPropagation()
    if (this.checkValidity()) {
        calcTaxes($(this).serializeArray());
    }
    this.classList.add('was-validated')
});

function calcTaxes(formData) {

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "calc.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            document.getElementById("tax-result-ajax").innerHTML = this.responseText;
        }
    };

    xhttp.send(JSON.stringify(formData));
}

function saveVehicle(element, event) {
    event.preventDefault()
    event.stopPropagation()
    var data = $(element).serializeArray();
    if (element.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "saveVehicle.php", true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Response
                document.getElementById("saved-vehicles").innerHTML = this.responseText;
            }
        };
        xhttp.send(JSON.stringify(data));
    }
    element.classList.add('was-validated')

}

function longTermSlider(el) {
    var tmc = parseFloat($(el).attr("data-tmc"));
    var tc = parseFloat($(el).attr("data-tc"));
    var malus = parseFloat($(el).attr("data-malus"));
    var year = parseFloat($(el).val());
    var total = tmc + malus + (tc * year);
    total = total.toLocaleString('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2    
    });
    $(el).parent().find(".long-term-cost-result").html(total + " €");
    $(el).parent().find(".long-term-cost-year").html(year + " ans");

}