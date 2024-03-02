var groupHtml = "";

function showGroupHtml(button) {
    var group_id = button.id.replace("but-gr-", "");
    var url =
        prepareUrlGroups(document.getElementsByClassName("user_properties"), group_id);
    groupHtml = $('#grupos').html();
    $('#grupos').load("../view/group.php?" + url);
}

function reloadGroups() {
    generateGroupsPage();
}

function prepareGroupUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['placeholder'].value + '=' + element.value)
    });
    return result.join('&');
}

function prepareUrlGroups(data, group_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('group' + '=' + group_id);
    return result.join('&');
}

//ToDo
function enableModule(moduleId, status) {
    groupId = $('div[id*=groupId_]').attr('id').replace('groupId_', '');
    $.ajax({
        method: 'POST',
        url: '../php/moduleController.php?data=status&moduleId=' + moduleId + '&status=' + status + '&groupId=' + groupId + '&userId=' + $('#userId').val(),
    }).done(function (data) {
        if (status) {
            alert('Módulo habilitado');
        } else {
            alert('Módulo deshabilitado');
        }
    }).fail(function () {
        if (status) {
            alert('Hubo un problema al habilitar el módulo');
        } else {
            alert('Hubo un problema al deshabilitar el módulo');
        }
    });
}