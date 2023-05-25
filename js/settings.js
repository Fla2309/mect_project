function saveSettings(type) {
    data = type == 1 ? getPasswordTextboxes() : getSettings();
    if (type == 1) {
        savePasswordChanged(data);
    }
    else if (formChanged(data)) {
        saveGeneralSettings(data);
    }
    else
        goHome();
    console.log("");
}

function saveGeneralSettings(data) {
    $('#loadingSpinner').removeClass('visually-hidden');
    $.ajax({
        method: "GET",
        url: "../php/settingsController.php?type=0&" + prepareUrl(data[0].value, getFormChanges(data))
    }).done(function (response) {
        if (response != 200) {
            $('#usernameErrorModalBody').html(response);
            $('#usernameErrorModal').modal('show');
            $('#loadingSpinner').addClass('visually-hidden');
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

function savePasswordChanged(data) {
    if (validateNewPassword(data)) {
        $('#loadingSpinner').removeClass('visually-hidden');
        $.ajax({
            method: "GET",
            url: "../php/settingsController.php?type=1&" + prepareUrl(data[0].value, data),
        }).done(function () {
            $('#passModal').hide();
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
        }).fail(function () {
            $('p#errorPassword').html("La contraseña actual es incorrecta")
                .removeAttr('hidden');
            $('#loadingSpinner').addClass('visually-hidden');
        });
    } else {
        $('p#errorPassword').html("La nueva contraseña no coincide en los campos")
            .removeAttr('hidden');
        $('#loadingSpinner').addClass('visually-hidden');
    }
}

function validateNewPassword(data) {
    return data[2].value == data[3].value;
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

function getPasswordTextboxes() {
    return $('form#settingsForm div.input-group > input#userId,div#passwordChange div.input-group > input[id]');
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
        try {
            element.attributes['id'];
            result.push(element.attributes['id'].value + '=' + element.value)
        } catch (e) {
            console.log(e)
        }
    });
    return result.join('&');
}

function getPersonalModuleDocuments() {
    $.ajax({
        method: "GET",
        url: "../php/settingsController.php?type=2&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if (data['cvName'] != null)
            $('#userResume').attr('value', data['cvName']);
        else {
            $('#userResume').attr('value', "No hay documentos para mostrar");
            $('#download-resume').prop('hidden', true);
        }
        if (data['registrationName'] != null)
            $('#userRegistration').attr('value', data['registrationName']);
        else {
            $('#userRegistration').attr('value', "No hay documentos para mostrar");
            $('#download-registration').prop('hidden', true);
        }
        if (data['idFrontName'] != null)
            $('#userIdFront').attr('value', data['idFrontName']);
        else {
            $('#userIdFront').attr('value', "No hay documentos para mostrar");
            $('#download-id-front').prop('hidden', true);
        }
        if (data['idBackName'] != null)
            $('#userIdBack').attr('value', data['idBackName']);
        else {
            $('#userIdBack').attr('value', "No hay documentos para mostrar");
            $('#download-id-back').prop('hidden', true);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function goHome() {
    window.location = '/index.php';
}