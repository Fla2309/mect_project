function addActivity(typeInt) {
    var type = typeInt == 1 ? 'homework' : 'activity';
    $('#actType').attr('value', type);
    const selectElement = document.getElementById('modulesDropdown');
    for (let i = 0; i < selectElement.options.length; i++) {
        const option = selectElement.options[i];
        if (option.id === 'mod_' + $('#moduleId.module_properties').val()) {
            option.selected = true;
            break;
        }
    }
    $('#editModal').modal('show');
}

function showEditPanel(data) {
    $('#editModal').modal('show');
    parent = $(data).parent();
    type = 0;
    idString = "";
    if ($(parent).attr('id').includes("mod_hw_")) {
        type = 1;
        idString = "actId=" + $(parent).attr('id').replace('mod_hw_', '');
    }
    else if ($(parent).attr('id').includes("mod_act_")) {
        type = 2;
        idString = "actId=" + $(parent).attr('id').replace('mod_act_', '');
    }
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?type=" + type + "&" + idString
    }).done(function (data) {
        $('#actId').attr('value', data['actId']);
        $('#actType').attr('value', data['actType']);
        $('#actName').attr('value', data['actName']);
        const selectElement = document.getElementById('modulesDropdown');
        for (let i = 0; i < selectElement.options.length; i++) {
            const option = selectElement.options[i];
            if (option.value === data['moduleName']) {
                option.selected = true;
                break;
            }
        }
        $('#templateName').attr('value', data['templateName']);
        if (data['templateName'] == "Sin plantilla") {
            $('#editModule a.template').attr('hidden', true);
        } else {
            $('#editModule a.template').attr('href', 'resources/templates/' + data['templateName']);
            $('#editModule a.template').attr('download', 'plantilla_' + data['actName']);
        }
        $('#comments').val(data['comments']);
        $('#spinner').modal('hide');
        $('#editModal').modal('show');
    }).fail(function () {

    });
}

function deleteActivity(data) {
    parent = $(data).parent();
    type = 0;
    idString = "";
    if ($(parent).attr('id').includes("mod_hw_")) {
        type = 1;
        idString = "actId=" + $(parent).attr('id').replace('mod_hw_', '');
    }
    else if ($(parent).attr('id').includes("mod_act_")) {
        type = 2;
        idString = "actId=" + $(parent).attr('id').replace('mod_act_', '');
    }

    if (confirm("¿Eliminar " + $(parent).find('h5').text() + "? Esta acción no se puede deshacer")) {
        $.ajax({
            method: "POST",
            url: "../php/moduleController.php?type=" + type + "&" + idString + "&userId=" + $('#userId').val() + "&data=delete"
        }).done(function () {
            if (alert("Actividad eliminada exitosamente. Serás redirigido a la pantalla de módulo")) {
                reloadModules();
            } else {
                reloadModules();
            }
        }).fail(function () {
            alert("Hubo un problema al eliminar la actividad. Inténtalo más tarde o contacta a soporte");
        });
    }
}

function saveChanges() {
    var url = "";
    var type = $('#actType').attr('value') == 'activity' ? 2 : 1;
    data = typeof $('#actId').attr('value') != 'undefined' ? [
        "actId=" + $('#actId').attr('value'),
        "actName=" + $('#actName').attr('value'),
        "moduleId=" + $('#modulesDropdown option:selected').attr('id').replace('mod_', ''),
        "templateName=" + $('#templateName').attr('value'),
        "comments=" + $('#comments').val(),
        "userId=" + $('#userId').val(),
        "data=update"
    ] :
        [
            "actName=" + $('#actName').val(),
            "moduleId=" + $('#modulesDropdown option:selected').attr('id').replace('mod_', ''),
            "templateName=" + $('#templateName').val(),
            "comments=" + $('#comments').val(),
            "userId=" + $('#userId').val(),
            "data=create"
        ];
    url = "../php/moduleController.php?type=" + type + "&" + data.join('&');
    console.log(url);
    $.ajax({
        method: "POST",
        url: url
    }).done(function () {
        $('#editModal').modal('hide');
        $('#changesMadeModal').modal('show');
        $('#changesMadeModal').on('shown.bs.modal', function () {
            var seconds = 3;
            function redirect() {
                if (seconds <= 0) {
                    window.location = '/index.php';
                } else {
                    seconds--;
                    document.getElementById("modal-footer_text").innerHTML = "Serás redirigido al inicio en " + seconds + " segundos"
                }
            } setInterval(redirect, 1000);
        })
    });
}