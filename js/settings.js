function saveSettings() {
    $('#loadingSpinner').removeClass('visually-hidden');
    data = getSettings();
    if (formChanged(data)) {
        console.log(prepareUrl(data[0].value, getFormChanges(data)));
        $.ajax({
            method: "GET",
            url: "../php/settingsController.php?" + prepareUrl(data[0].value, getFormChanges(data))
        }).done(function (response) {
            if (response != 200) {
                $('#usernameErrorModalBody').html(response);
                $('#usernameErrorModal').modal('show');
            }
            else
                $('#changesMadeModal').modal('show');
            $('#changesMadeModal').on('shown.bs.modal', function () {
                var seconds = 3;
                function redirect() {
                    if (seconds <= 0) {
                        goHome();
                    } else {
                        seconds--;
                        document.getElementById("modal-footer_text").innerHTML = "Serás redirigido al inicio en " + seconds + " segundos"
                    }
                } setInterval(redirect, 1000);
            })
        });
    }
    else
        goHome();
}

function getSettings() {
    return $('form#settingsForm div.input-group > input[id]');
}

function discardSettings() {
    if (formChanged(getSettings())) {
        $('#discardChangesModal').modal('show');
    }
    else
        goHome();

}

function formChanged(data) {
    for (let index = 0; index < data.length; index++) {
        if (data[index].defaultValue != data[index].value) {
            return true;
        }
    }
    return false;
}

function getFormChanges(data) {
    let changes = [];
    $.each(data, function (key, element) {
        if (element.defaultValue != element.value) {
            changes.push(element);
        }
    });
    return changes;
}

function prepareUrl(userId, data) {
    let result = [];
    result.push("userId=" + userId);
    $.each(data, function (key, element) {
        result.push(element.attributes['id'].value + '=' + element.value)
    });
    return result.join('&');
}

function goHome() {
    window.location = '/index.php';
}