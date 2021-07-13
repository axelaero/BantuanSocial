$(document).ready(function() {


})

function checkboxFunctionAcc(penduduk_id) {
    if ($('#checkbox-acc-' + penduduk_id).is(':checked')) {
        console.log("acc")
    } else {
        console.log("removeacc")
    }
    if ($('#checkbox-rej-' + penduduk_id).is(':checked')) {
        console.log("active-rej")
        $('#checkbox-rej-' + penduduk_id).prop('checked', false)
    } else {
        console.log("nonactive-rej")
    }
}

function checkboxFunctionRej(penduduk_id) {
    if ($('#checkbox-acc-' + penduduk_id).is(':checked')) {
        console.log("active-acc")
        $('#checkbox-acc-' + penduduk_id).prop('checked', false)
    } else {
        console.log("nonactive-acc")
    }
    if ($('#checkbox-rej-' + penduduk_id).is(':checked')) {
        console.log("rej")
        $('#checkbox-rej-' + penduduk_id).prop('checked', true)
    } else {
        console.log("removerej")
    }
}