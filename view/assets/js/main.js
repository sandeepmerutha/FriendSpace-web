$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 30 // Creates a dropdown of 15 years to control year
});

$(document).ready(function() {
    $('select').material_select();
});