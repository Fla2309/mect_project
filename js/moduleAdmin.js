function showModuleHtmlAdmin(button) {
    var module_id = getModuleId(button);
    var url = 'userId=' + $('#userId.user_properties').val() + '&module=' + module_id;
    html = $('#modulos').html();
    $.ajax({
        method: "GET",
        url: "../view/module.php?" + url
    }).done(function (data) {
        $('#modulos').html(data);
        fillModuleDetails();
    }).fail({

    })
}

function reloadModules() {
    generateModulesPage();
}

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

function getModuleId(htmlElement) {
    currentElement = $(htmlElement);
    while (currentElement.length > 0) {
        var currentId = currentElement.attr('id');
        if (currentId && currentId.includes('idModule-')) {
            return currentId.replace('idModule-', '');
        }
        currentElement = currentElement.parent();
    }
}

function fillModuleDetails() {
    var module_id = document.getElementById('moduleId').value;
    var url = 'userId=' + $('#userId.user_properties').val() + '&module=' + module_id + '&dataType=all';
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/moduleController.php?" + url
    }).done(function (data) {
        setModuleFrame(data);
        console.log(data)
    }).fail({

    })
}

function setModuleFrame(json) {
    setTrabajosFrame(json.works);
    setTareasFrame(json.homeworks);
}

function setTrabajosFrame(json) {
    if (Object.keys(json).length === 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay trabajos para mostrar';
        document.getElementById('trabajos').appendChild(h5);
        return;
    }
    json.forEach(jsonRow => {
        const aListGroupItem = document.createElement('a');
        const divTitle = document.createElement('div');
        const h5 = document.createElement('h5');
        const aEdit = document.createElement('a');
        const imgEdit = document.createElement('img');
        const aDelete = document.createElement('a');
        const imgDelete = document.createElement('img');
        aListGroupItem.classList.add('list-group-item');
        aListGroupItem.classList.add('list-group-item-action');
        divTitle.id = 'mod_act_' + jsonRow.workId;
        divTitle.classList.add('d-flex');
        divTitle.classList.add('w-100');
        divTitle.classList.add('justify-content-start');
        h5.classList.add('mb-1');
        h5.textContent = jsonRow.workName;
        imgEdit.classList.add('dashboard_icon');
        imgEdit.classList.add('m-2');
        imgEdit.src = 'img/edit.png';
        aEdit.title = 'Editar';
        aEdit.setAttribute('onclick', 'showEditPanel(this)');
        aEdit.appendChild(imgEdit);
        imgDelete.classList.add('dashboard_icon');
        imgDelete.classList.add('m-2');
        imgDelete.src = 'img/delete.png';
        aDelete.title = 'Eliminar';
        aDelete.setAttribute('onclick', 'deleteActivity(this)');
        aDelete.appendChild(imgDelete);
        divTitle.appendChild(h5);
        divTitle.appendChild(aEdit);
        divTitle.appendChild(aDelete);
        aListGroupItem.appendChild(divTitle);
        aListGroupItem.innerHTML += '<hr class="divider">';
        document.getElementById('trabajos').appendChild(aListGroupItem);
    })
}

function setTareasFrame(json) {
    if (Object.keys(json).length === 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay tareas para mostrar';
        document.getElementById('tareas').appendChild(h5);
        return;
    }
    json.forEach(jsonRow => {
        const aListGroupItem = document.createElement('a');
        const divTitle = document.createElement('div');
        const h5 = document.createElement('h5');
        const aEdit = document.createElement('a');
        const imgEdit = document.createElement('img');
        const aDelete = document.createElement('a');
        const imgDelete = document.createElement('img');
        aListGroupItem.classList.add('list-group-item');
        aListGroupItem.classList.add('list-group-item-action');
        divTitle.id = 'mod_hw_' + jsonRow.homeworkId;
        divTitle.classList.add('d-flex');
        divTitle.classList.add('w-100');
        divTitle.classList.add('justify-content-start');
        h5.classList.add('mb-1');
        h5.textContent = jsonRow.homeworkName;
        imgEdit.classList.add('dashboard_icon');
        imgEdit.classList.add('m-2');
        imgEdit.src = 'img/edit.png';
        aEdit.title = 'Editar';
        aEdit.setAttribute('onclick', 'showEditPanel(this)');
        aEdit.appendChild(imgEdit);
        imgDelete.classList.add('dashboard_icon');
        imgDelete.classList.add('m-2');
        imgDelete.src = 'img/delete.png';
        aDelete.title = 'Eliminar';
        aDelete.setAttribute('onclick', 'deleteActivity(this)');
        aDelete.appendChild(imgDelete);
        divTitle.appendChild(h5);
        divTitle.appendChild(aEdit);
        divTitle.appendChild(aDelete);
        aListGroupItem.appendChild(divTitle);
        aListGroupItem.innerHTML += '<hr class="divider">';
        document.getElementById('tareas').appendChild(aListGroupItem);
    })
}