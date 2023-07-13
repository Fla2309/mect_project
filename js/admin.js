$(function () {
    let data = [];
    const $selects = $('#groupSelects select');
    $selects.on('change', event => {
        const query = $selects.map((i, e) => e.selectedIndex > 0 ? (`${e.id}=${encodeURIComponent(e.value)}`) : []).get().join('&');
        const url = `/php/getGroups.php?${query}`;
        $.ajax({
            method: "GET",
            url: url,
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
        }).done(function (response) {
            $('#groupsFrame').html(decodeURIComponent(response));
        });
    });
});

groupHtml = "";

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function prepareUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['value'].value + '=' + element.value)
    });
    return result.join('&');
}

function goToTab(link) {
    id = link.getAttribute("href").replace('#', "") + "NavItem";
    document.getElementById(id).getElementsByTagName("a")[0].click();
}

function searchInList(txtName, ulName) {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById(txtName);
    filter = input.value.toUpperCase();
    ul = document.getElementById(ulName);
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function deleteStudent(data) {
    parent = $(data).parent();
    idString = "targetUser=" + $(parent).attr('id').replace('user_', '');
    console.log("../php/usersController.php?" + idString + "&userId=" + $('#userId').val() + "&data=delete");
    if (confirm("¿Eliminar usuario " + $(parent).find('a:first-of-type').text() + "? Esta acción no se puede deshacer")) {
        $.ajax({
            method: "POST",
            url: "../php/usersController.php?" + idString + "&userId=" + $('#userId').val() + "&data=delete"
        }).done(function () {
            if (alert("Usuario eliminado exitosamente. Serás redirigido a la pantalla de inicio")) {
                window.location = './index.php';
            } else {
                window.location = './index.php';
            }
        }).fail(function () {
            alert("Hubo un problema al eliminar el usuario. Inténtalo más tarde o contacta a soporte");
        });
    }
}

function showUserSettings(data, callback) {
    parent = $(data).parent();
    idString = "targetUser=" + $(parent).attr('id').replace('user_', '');
    $.ajax({
        method: "POST",
        url: "../php/settingsController.php?type=4&" + idString + "&userId=" + $('#userId').val(),
        success: function (json) {
            callback(json);
        }
    });
}

function setParametersInSettingsModal(json) {
    $('#targetUserId').val(json['targetUserId']);
    $('#targetUserName').val(json['targetUserName']);
    $('#targetUserLastname').val(json['targetUserLastname']);
    $('#targetUserPrefName').val(json['targetUserPrefName']);
    $('#targetUserPlId').val(json['targetUserPlId']);
    const groupSelectElement = document.getElementById('groupsDropdown');
    for (let i = 0; i < groupSelectElement.options.length; i++) {
        const option = groupSelectElement.options[i];
        if (option.value === json['targetUserGroupName']) {
            option.selected = true;
            break;
        }
    }
    $('#targetUserDate').val(json['targetUserDate']);
    $('#targetUserMail').val(json['targetUserMail']);
    $('#targetUserPhone').val(json['targetUserPhone']);
    $('#targetUserLogin').val(json['targetUserLogin']);
    $('#userLevel').val(json['userLevel']);
    const levelSelectElement = document.getElementById('levelsDropdown');
    for (let i = 0; i < levelSelectElement.options.length; i++) {
        const option = levelSelectElement.options[i];
        if (option.value === json['targetUserLevel']) {
            option.selected = true;
            break;
        }
    }
    $('#settingsModal').modal('show');
}

function showPaymentFrame(data, callback) {
    parent = $(data).parent();
    id = $(parent).attr('id').replace('user_', '');
    if (!$('#payments_frame_' + id).length) {
        idString = "targetUser=" + id;
        console.log("../php/usersController.php?data=payments&" + idString + "&userId=" + $('#userId').val());
        $.ajax({
            method: "POST",
            url: "../php/usersController.php?data=payments&" + idString + "&userId=" + $('#userId').val(),
            success: function (html) {
                callback(html, $(parent).attr('id').replace('user_', ''));
            }
        });
    } else {
        $('#payments_frame_' + id).remove();
    }
}

function setPaymentsFrameInUser(html, id) {
    var div = document.createElement("div");
    div.id = "payments_frame_" + id;
    div.innerHTML = html
    document.getElementById('user_' + id).appendChild(div);
}

function showStudentSchoolProfile(data) {

}

function saveUserChanges() {
    var url = "";
    data = [
        "userId=" + document.getElementById('targetUserId').value,
        "userName=" + document.getElementById('targetUserName').value,
        "userLastname=" + document.getElementById('targetUserLastname').value,
        "userPL=" + document.getElementById('targetUserPlId').value,
        "userGroup=" + $('#groupsDropdown option:selected').attr('id').replace('group_', ''),
        "userDate=" + document.getElementById('targetUserDate').value,
        "userAlias=" + document.getElementById('targetUserPrefName').value,
        "userLevel=" + $('#levelsDropdown option:selected').attr('id').replace('level_', ''),
        "userLogin=" + document.getElementById('targetUserLogin').value,
        "userMail=" + document.getElementById('targetUserMail').value,
        "userPhone=" + document.getElementById('targetUserPhone').value
    ];
    url = "../php/settingsController.php?type=5&" + data.join('&');
    console.log(url);
    $.ajax({
        method: "POST",
        url: url
    }).done(function () {
        $('#settingsModal').modal('hide');
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