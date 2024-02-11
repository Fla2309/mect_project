var image;
var cropper;

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
    }).done(function () {
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
    }).fail(function (response) {
        $('#usernameErrorModalBody').html(response);
        $('#usernameErrorModal').modal('show');
        $('#loadingSpinner').addClass('visually-hidden');
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
        if (data.documents.cvName != null)
            $('#userResume').attr('value', data.documents.cvName);
        else {
            $('#userResume').attr('value', "No hay documentos para mostrar");
            $('#download-resume').prop('hidden', true);
        }
        if (data.documents.registrationName != null)
            $('#userRegistration').attr('value', data.documents.registrationName);
        else {
            $('#userRegistration').attr('value', "No hay documentos para mostrar");
            $('#download-registration').prop('hidden', true);
        }
        if (data.documents.idFrontName != null)
            $('#userIdFront').attr('value', data.documents.idFrontName);
        else {
            $('#userIdFront').attr('value', "No hay documentos para mostrar");
            $('#download-id-front').prop('hidden', true);
        }
        if (data.documents.idBackName != null)
            $('#userIdBack').attr('value', data.documents.idBackName);
        else {
            $('#userIdBack').attr('value', "No hay documentos para mostrar");
            $('#download-id-back').prop('hidden', true);
        }
        $("#userProcessB1").val(data.userProcess.B1);
        $("#userProcessB2").val(data.userProcess.B2);
        $("#userProcessContract").val(data.userProcess.contract);
        $("#userProcessTrainingB2").val(data.userProcess.trainingB2);
        $("#userProcessB2Song").val(data.userProcess.songB2);
        $("#userProcessPL").val(data.userProcess.am);
        $("#userProcessSource").val(data.userProcess.sourceOf);
        $("#userProcessTrainingPL").val(data.userProcess.trainingAm);
        $("#userProcessPLSong").val(data.userProcess.songAm);
    }).fail(function (result) {
        console.log(result);
    });
}

function showImage(input) {
    clearImageCanvas();
    var src = URL.createObjectURL(input.files[0]);
    var image = new Image();
    image.src = src;
    $('#profilePicModal .modal-dialog').addClass('modal-xl');
    $("#imageUploaded").attr('src', src);
    $("#profilePicInput").attr('value', input.files[0].name);
    $("#imageViewer").removeClass("visually-hidden");
    this.image = document.getElementById("imageUploaded");
    this.cropper = new Cropper(this.image, {
        aspectRatio: 1,
        viewMode: 0
    });
}

function saveProfilePic() {
    $('#loadingSpinner').removeClass('visually-hidden');
    this.cropper.getCroppedCanvas().toBlob((blob) => {
        $.ajax({
            method: 'POST',
            url: "../php/settingsController.php?type=3&userId=" + document.getElementById("userId").value +
                '&pictureName=' + $("#profilePicInput").attr('value'),
            data: blob,
            processData: false,
            contentType: false,
        }).done((data) => {
            $('#profilePic').attr('value', data['profilePicName']);
            $('img.settings_profile_pic').attr('src', data['profilePicPath']);
            $('#profilePicChangedModal .modal-title.output_title').html('¡Listo!');
            $('#profilePicChangedModal .output_message').html('Foto de perfil cambiada con éxito');
            $('#profilePicModal').modal('hide');
            $('#profilePicChangedModal').modal('show');
        }).fail(function () {
            $('#profilePicChangedModal .output_title').html('Error al cambiar foto');
            $('#profilePicChangedModal .output_message').html('Hubo un problema al guardar la nueva foto. Si el problema persis, contacta al soporte del sitio');
            $('#profilePicModal').modal('hide');
            $('#profilePicChangedModal').modal('show');
        });
    });
    $('#loadingSpinner').addClass('visually-hidden');
}

function clearImageCanvas() {
    if (this.cropper != null)
        this.cropper.destroy();
    $('#profilePicModal .modal-dialog').removeClass('modal-xl');
    $("#imageUploaded").attr('src', '');
    $("#profilePicInput").attr('value', '');
    $("#imageViewer").addClass("visually-hidden");
}

function goHome() {
    window.location = '/index.php';
}