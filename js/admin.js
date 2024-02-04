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
            if (alert("Usuario eliminado exitosamente.")) {
                generateUsersPage();
            } else {
                generateUsersPage();
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
    for (let i = 1; i < levelSelectElement.options.length; i++) {
        const option = levelSelectElement.options[i];
        if (option.id.replace('level_', '') == json['targetUserLevel']) {
            option.selected = true;
            break;
        }
    }
    console.log(json);
    $('#settingsModal .btn-primary').attr('onclick', 'saveUserChanges()');
    $('#settingsModal').modal('show');
}

function clearAndShowSettingsModal() {
    $('#targetUserId').val('');
    $('#targetUserName').val('');
    $('#targetUserLastname').val('');
    $('#targetUserPrefName').val('');
    $('#targetUserPlId').val('');
    const groupSelectElement = document.getElementById('groupsDropdown');
    groupSelectElement.options[0].selected = true;
    $('#targetUserDate').val('');
    $('#targetUserMail').val('');
    $('#targetUserPhone').val('');
    $('#targetUserLogin').val('');
    $('#userLevel').val('');
    const levelSelectElement = document.getElementById('levelsDropdown');
    levelSelectElement.options[0].selected = true;
    $('#settingsModal .btn-primary').attr('onclick', 'saveNewUser()');
    $('#settingsModal').modal('show');
}

function getCurrentDate() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    day = (day < 10) ? '0' + day : day;
    month = (month < 10) ? '0' + month : month;
    return year + '-' + month + '-' + day;
}

function showPaymentFrame(data, callback, isReload) {
    if (!isReload) {
        parent = $(data).parent();
        id = $(parent).attr('id').replace('user_', '');
        if (!$('#payments_frame_' + id).length) {
            targetUserIdString = "targetUser=" + id;
            $.ajax({
                method: "POST",
                url: "../php/usersController.php?data=get&dataType=payments&" + targetUserIdString + "&userId=" + $('#userId').val(),
                success: function (json) {
                    callback(json, $(parent).attr('id').replace('user_', ''));
                }
            });
        } else {
            $('#payments_frame_' + id).remove();
        }
    } else {
        $('#payments_frame_' + data).remove();
        targetUserIdString = "targetUser=" + data;
        $.ajax({
            method: "POST",
            url: "../php/usersController.php?data=get&dataType=payments&" + targetUserIdString + "&userId=" + $('#userId').val(),
            success: function (json) {
                callback(json, $(parent).attr('id').replace('user_', ''));
            }
        });
    }
}

function registerPayment() {
    paymentDate = $('#targetUserDatePayment').val();
    targetUserId = $('#targetUserIdPayment').val();
    targetUserAmount = $('#targetUserAmountPayment').val();
    targetUserReason = $('#targetUserReasonPayment').val();
    $.ajax({
        method: "POST",
        url: "../php/usersController.php?data=create&dataType=payments&targetUserId=" + targetUserId +
            "&userId=" + $('#userId').val() + '&paymentDate=' + paymentDate + '&targetUserAmount='
            + targetUserAmount + '&targetUserReason=' + targetUserReason
    }).done(function () {
        $('#paymentModal').modal('hide');
        $('#changesMadeModalBody').text('Pago registrado exitosamente');
        $('#changesMadeModal').modal('show');
        $('#changesMadeModal').on('shown.bs.modal', function () {
            var seconds = 3;
            function redirect() {
                if (seconds <= 0) {
                    $('#changesMadeModal').modal('hide');
                } else {
                    seconds--;
                }
            } setInterval(redirect, 1000);
            showPaymentFrame(targetUserId, setPaymentsFrameInUser, true);
        })
    });
}

function showPaymentModal(button) {
    userId = button.id.replace('payment_for_', '');
    getUserPaymentInfo(userId);
    $('#paymentModal').modal('show');
}

function getUserPaymentInfo(userId) {
    $.ajax({
        method: "GET",
        url: "../php/usersController.php?data=get&dataType=paymentInfo&targetUserId=" + userId + "&userId=" + $('#userId').val(),
        success: function (json) {
            setUserPaymentInfoInModal(json);
        }
    });
}

function setUserPaymentInfoInModal(json) {
    $('#targetUserIdPayment').val(json.userId);
    $('#targetUserNamePayment').val(json.userName);
    $('#targetUserLastnamePayment').val(json.userLastname);
    $('#targetUserMailPayment').val(json.userMail);
    $('#targetUserPhonePayment').val(json.userPhone);
    $('#targetUserDatePayment').val(getCurrentDate());
}

function setPaymentsFrameInUser(json, id) {
    const div = document.createElement("div");
    const button = document.createElement("button");
    div.id = "payments_frame_" + id;
    button.classList.add('btn');
    button.classList.add('btn-primary');
    button.classList.add('ms-4');
    button.classList.add('mb-2');
    button.id = "payment_for_" + id;
    button.onclick = function () { showPaymentModal(this); };
    button.textContent = "Registrar Pago";
    div.appendChild(button);
    if (json.length !== 0) {
        const ul = document.createElement('ul');
        json.forEach(jsonRow => {
            const li = document.createElement('li');
            li.className = "list-group-item";
            li.id = "payment_" + jsonRow.paymentId;

            const a1 = document.createElement('a');
            a1.textContent = jsonRow.userFullName;
            li.appendChild(a1);

            const a2 = document.createElement('a');
            const img = document.createElement('img');
            img.src = "img/eye.png";
            img.title = "Ver detalles";
            img.className = "dashboard_icon ms-4 me-1";
            a2.appendChild(img);
            li.appendChild(a2);

            const p = document.createElement('p');
            p.innerHTML = '<strong>Concepto: </strong>' + jsonRow.reason +
                '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Importe: </strong>' + jsonRow.amount +
                '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha: </strong>' + jsonRow.paymentDate +
                '<br><strong>Teléfono: </strong>' + jsonRow.phone +
                '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Correo: </strong>' + jsonRow.email;
            li.appendChild(p);
            ul.appendChild(li);
            div.appendChild(ul);
        });
    } else {
        const h5 = document.createElement('h5');
        h5.textContent = "No hay pagos para mostrar";
        div.appendChild(h5);
    }
    document.getElementById('user_' + id).appendChild(div);
}

function showStudentSchoolProfile(data) {
    parent = $(data).parent();
    id = $(parent).attr('id').replace('user_', '');
    $.ajax({
        method: "POST",
        url: "../php/usersController.php?data=payments&" + idString + "&userId=" + $('#userId').val(),
    }).done({

    });
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
    $.ajax({
        method: "POST",
        url: url
    }).done(function () {
        $('#settingsModal').modal('hide');
        $('#changesMadeModalBody').text('Información de usuario actualizada con éxito');
        $('#changesMadeModal').modal('show');
        $('#changesMadeModal').on('shown.bs.modal', function () {
            var seconds = 3;
            function redirect() {
                if (seconds <= 0) {
                    $('#changesMadeModal').modal('hide');
                } else {
                    seconds--;
                }
            } setInterval(redirect, 1000);
        })
    });
}

function saveNewUser() {
    var url = "";
    data = [
        "userId=" + document.getElementById('userId').value,
        "targetUserName=" + document.getElementById('targetUserName').value,
        "targetUserLastname=" + document.getElementById('targetUserLastname').value,
        "targetUserPL=" + document.getElementById('targetUserPlId').value,
        "targetUserGroup=" + $('#groupsDropdown option:selected').attr('id').replace('group_', ''),
        "targetUserDate=" + document.getElementById('targetUserDate').value,
        "targetUserAlias=" + document.getElementById('targetUserPrefName').value,
        "targetUserLevel=" + $('#levelsDropdown option:selected').attr('id').replace('level_', ''),
        "targetUserLogin=" + document.getElementById('targetUserLogin').value,
        "targetUserMail=" + document.getElementById('targetUserMail').value,
        "targetUserPhone=" + document.getElementById('targetUserPhone').value
    ];
    url = "../php/settingsController.php?type=create&" + data.join('&');
    $.ajax({
        method: "POST",
        url: url
    }).done(function () {
        $('#settingsModal').modal('hide');
        $('#changesMadeModalBody').text('Usuario creado exitosamente');
        $('#changesMadeModal').modal('show');
        $('#changesMadeModal').on('shown.bs.modal', function () {
            var seconds = 3;
            function redirect() {
                if (seconds <= 0) {
                    $('#changesMadeModal').modal('hide');
                } else {
                    seconds--;
                }
            } setInterval(redirect, 1000);
            generateUsersPage();
        })
    });
}

function generateModulesPage() {
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?type=0&user=" + document.getElementById("user").value + "&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if (data.length == 0) {
            $('#modulos').html('<h4 class="ms-3">No hay contenido para mostrar</h4>');
        }
        else {
            setModulesHtml(JSON.parse(data));
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function setModulesHtml(json) {
    count = 1;
    $('#modulos').html('');
    for (let i = 0; i < json.length; i++) {
        if (i % 3 === 0) {
            var divRow = document.createElement('div');
            divRow.className = 'row';
            divRow.style.alignContent = 'center';
        }

        let module = json[i];
        let divCol = document.createElement('div');
        let divP1 = document.createElement('div');
        let h2 = document.createElement('h2');
        let h4 = document.createElement('h4');
        let button = document.createElement('button');
        divCol.className = 'col-sm p-5 m-3';
        divCol.style.backgroundColor = 'white';
        divCol.id = 'idModule-' + module.moduleId;
        divP1.className = 'p-1';
        button.className = 'btn btn-primary';
        button.type = 'button';
        button.style.width = '120px';
        button.style.textAlign = 'left';
        h2.textContent = module.moduleName;
        h4.textContent = module.description;
        button.setAttribute('onclick', 'showModuleHtmlAdmin(this)');
        button.textContent = 'Ver Módulo';
        divP1.append(h2, h4, button);
        divCol.appendChild(divP1);
        divRow.appendChild(divCol);

        if (i % 3 === 2 || i === json.length - 1) {
            document.getElementById('modulos').appendChild(divRow);
        }
    }
}

function generateUsersPage() {
    $.ajax({
        method: "GET",
        url: "../php/usersController.php?userId=" + document.getElementById("userId").value + '&data=get',
    }).done(function (data) {
        setUsersHtml(data);
    }).fail(function (result) {
        console.log(result);
    });
}



function setUsersHtml(json) {
    if (Object.keys(json).length == 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay usuarios para mostrar';
        document.getElementById('usersDetails').appendChild(h5);
        return;
    } else {
        let usersList = $("#usersList");
        if (usersList.length) {
            usersList.remove();
        }
        const ul = document.createElement('ul');
        ul.classList.add('list-group');
        ul.id = 'usersList';
        json.forEach(user => {
            let li = document.createElement('li');
            li.className = "list-group-item";
            li.id = "user_" + user.userId;

            let a1 = document.createElement('a');
            a1.textContent = user.userName + ' ' + user.userLastName + '\u00A0\u00A0';
            li.appendChild(a1);

            let em = document.createElement('em');
            em.className = "text-muted";
            em.textContent = 'MECT ' + user.groupId + ' ' + user.groupName;
            a1.appendChild(em);

            user.options.forEach(option => {
                switch (option) {
                    case 1:
                        let a2 = document.createElement('a');
                        a2.href = "#";
                        a2.onclick = function () { deleteStudent(this); };
                        let img1 = document.createElement('img');
                        img1.src = "img/del_user.png";
                        img1.title = "Eliminar usuario";
                        img1.className = "dashboard_icon ms-4 me-1";
                        a2.appendChild(img1);
                        li.appendChild(a2);

                        break;

                    case 2:
                        let a3 = document.createElement('a');
                        a3.href = "#";
                        a3.onclick = function () { showUserSettings(this, setParametersInSettingsModal); };
                        let img2 = document.createElement('img');
                        img2.src = "img/settings.png";
                        img2.title = "Configuración";
                        img2.className = "dashboard_icon m-1";
                        a3.appendChild(img2);
                        li.appendChild(a3);

                        break;
                    case 3:
                        let a4 = document.createElement('a');
                        a4.href = "#";
                        a4.onclick = function () { showPaymentFrame(this, setPaymentsFrameInUser, false); };
                        let img3 = document.createElement('img');
                        img3.src = "img/payment.png";
                        img3.title = "Pagos";
                        img3.className = "dashboard_icon m-1";
                        a4.appendChild(img3);
                        li.appendChild(a4);

                        break;
                    case 4:
                        let a5 = document.createElement('a');
                        a5.href = "#";
                        a5.onclick = function () { showStudentSchoolProfile(this); };
                        let img4 = document.createElement('img');
                        img4.src = "img/books.png";
                        img4.title = "Perfil académico";
                        img4.className = "dashboard_icon m-1";
                        a5.appendChild(img4);
                        li.appendChild(a5);

                        break;
                }
            });
            ul.appendChild(li);
        });
        document.getElementById('usersDetails').appendChild(ul);
        console.log(json);
    }
}