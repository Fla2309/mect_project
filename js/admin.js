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
    // groupSelectElement.options[0].selected = true;
    $('#targetUserDate').val('');
    $('#targetUserMail').val('');
    $('#targetUserPhone').val('');
    $('#targetUserLogin').val('');
    $('#userLevel').val('');
    document.querySelector('#settingsModal #errorSettings').hidden = true;
    const levelSelectElement = document.getElementById('levelsDropdown');
    // levelSelectElement.options[0].selected = true;
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

function showStudentAcademicProfile(data) {
    parent = $(data).parent();
    id = $(parent).attr('id').replace('user_', '');
    $.ajax({
        method: "GET",
        url: "../php/usersController.php?data=get&dataType=userLogin&targetUserId=" + id + "&userId=" + $('#userId').val(),
    }).done(function (data) {
        window.location = '/view/academicProfile.php?user=' + data;
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
    if (document.getElementById('userId').value.length == 0 || document.getElementById('targetUserName').value.length == 0 || document.getElementById('targetUserLastname').value.length == 0 || document.getElementById('targetUserPlId').value.length == 0 || document.getElementById('targetUserDate').value.length == 0 || document.getElementById('targetUserPrefName').value.length == 0 || document.getElementById('targetUserLogin').value.length == 0 || document.getElementById('targetUserMail').value.length == 0 || document.getElementById('targetUserPhone').valu == "") {
        alert('Todos los campos deben llenarse');
        return;
    }
    var url = "";
    data = {
        targetUserName: document.getElementById('targetUserName').value,
        targetUserLastname: document.getElementById('targetUserLastname').value,
        targetUserPL: document.getElementById('targetUserPlId').value,
        targetUserGroup: $('#groupsDropdown option:selected').attr('id').replace('group_', ''),
        targetUserDate: document.getElementById('targetUserDate').value,
        targetUserAlias: document.getElementById('targetUserPrefName').value,
        targetUserLevel: $('#levelsDropdown option:selected').attr('id').replace('level_', ''),
        targetUserLogin: document.getElementById('targetUserLogin').value,
        targetUserMail: document.getElementById('targetUserMail').value,
        targetUserPhone: document.getElementById('targetUserPhone').value
    };
    url = "../php/settingsController.php?type=create&userId=" + document.getElementById('userId').value;
    $.ajax({
        method: "POST",
        url: url,
        data: data
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
            $('#changesMadeModal').on('hide.bs.modal', function () { generateUsersPage() });
        })
    }).fail(function (json) {
        if (json.responseJSON.errorMessage) {
            errorMessage = document.querySelector('#settingsModal #errorSettings');
            errorMessage.textContent = json.responseJSON.errorMessage;
            errorMessage.hidden = false;
        } else {
            window.alert("Ha ocurrido un error en el servidor al intentar crear el usuario. Por favor, contacte al administrador del sitio");
        }
    });
}

function generateModulesPage() {
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?data=get&user=" + document.getElementById("user").value + "&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if (data.length == 0) {
            $('#modulos').html('<h4 class="ms-3">No hay contenido para mostrar</h4>');
        }
        else {
            setModulesHtml(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function generateGroupsPage() {
    $.ajax({
        method: "GET",
        url: "../php/groupController.php?data=get&dataType=groups&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if (data.length == 0) {
            $('#grupos').html('<h4 class="ms-3">No hay contenido para mostrar</h4>');
        }
        else {
            setGroupsHtml(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function setModulesHtml(json) {
    count = 1;
    $('#modulos').html('');
    var divRow = document.createElement('div');
    divRow.className = 'row g-0 m-3 justify-content-center';
    divRow.style.alignContent = 'center';
    for (let i = 0; i < json.length; i++) {
        let module = json[i];
        let divCol = document.createElement('div');
        let divP1 = document.createElement('div');
        let h2 = document.createElement('h2');
        let h4 = document.createElement('h4');
        let button = document.createElement('button');
        divCol.className = 'col p-5 mb-3 me-3';
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
    }
    document.getElementById('modulos').appendChild(divRow);
}

function setGroupsHtml(json) {
    count = 1;
    groupsTab = document.getElementById('grupos');
    groupsTab.innerHTML = '';
    var divRow = document.createElement('div');
    var butCreate = document.createElement('button');
    divRow.className = 'row g-0 m-3 justify-content-center';
    divRow.style.alignContent = 'center';
    butCreate.className = 'btn btn-primary ms-3 mt-3 p-2';
    butCreate.type = 'button';
    butCreate.id = 'butCreateGroup';
    butCreate.setAttribute('data-bs-toggle', 'collapse');
    butCreate.setAttribute('data-bs-target', '#createGroup');
    butCreate.setAttribute('aria-expanded', 'false');
    butCreate.setAttribute('aria-controls', 'createGroup');
    butCreate.innerHTML = '<img src="../img/plus.png" width="20"> Crear Grupo';
    for (let i = 0; i < json.groups.length; i++) {
        let group = json.groups[i];
        let divCol = document.createElement('div');
        let divP1 = document.createElement('div');
        let h2 = document.createElement('h2');
        let h4 = document.createElement('h4');
        let buttonView = document.createElement('button');
        let buttonEdit = document.createElement('button');
        divCol.className = 'col p-5 mb-3 me-3';
        divCol.style.backgroundColor = 'white';
        divCol.id = 'idGroup-' + group.groupId;
        divP1.className = 'p-1';
        h2.textContent = 'MECT ' + group.groupNumber + ' ' + group.groupName;
        h2.className = 'group-header';
        h4.textContent = group.location;
        h4.className = 'group-location';
        buttonView.className = 'btn btn-primary module-button';
        buttonView.type = 'button';
        buttonView.id = 'but-gr-' + group.groupId;
        buttonView.style.textAlign = 'left';
        buttonView.setAttribute('onclick', 'showGroupHtml(this)');
        buttonView.innerHTML = '<img src="../img/eye.png" style="filter: invert(100%);" width="15"> Ver Grupo';
        buttonView.title = 'Ver Grupo';
        buttonEdit.className = 'btn btn-secondary module-button me-2';
        buttonEdit.type = 'button';
        buttonEdit.id = 'but-edit-' + group.groupId;
        buttonEdit.setAttribute('onclick', 'showEditGroupModal(this)');
        buttonEdit.innerHTML = '<img src="../img/edit.png" style="filter: invert(100%);" width="15">';
        buttonEdit.title = 'Editar Información de Grupo';
        divP1.append(h2, h4, buttonEdit, buttonView);
        divCol.appendChild(divP1);
        divRow.appendChild(divCol);

    }
    groupsTab.appendChild(butCreate);
    groupsTab.appendChild(generateCreateGroupFrame(json));
    groupsTab.appendChild(divRow);
}

function showEditGroupModal(button) {
    let groupNumber = button.id.replace('but-edit-', '')
    let location = button.previousElementSibling.textContent;
    $.ajax({
        method: "GET",
        url: "../php/groupController.php?data=get&dataType=group&groupNumber=" + groupNumber + "&location=" + location + "&userId=" + $("#userId").val(),
    }).done(function (data) {
        $('#groupIdModal').val(data.groupId);
        $('#groupNumberModal').val(data.groupNumber);
        $('#groupNameModal').val(data.groupName);
        $('#groupStartDateModal').val(data.startDate);
        $('#groupEndDateModal').val(data.endDate);
        $('#groupLocationModal').val(data.location);
        $('#editGroupModal').modal('show');
    }).fail(function (result) {
        console.log(result);
    });
}

function updateGroup() {
    let groupId = $('#groupIdModal').val();
    let groupNumber = $('#groupNumberModal').val();
    let groupName = $('#groupNameModal').val();
    let startDate = $('#groupStartDateModal').val();
    let endDate = $('#groupEndDateModal').val();
    let location = $('#groupLocationModal').val();

    $.ajax({
        method: "POST",
        url: "../php/groupController.php?data=update&groupId=" + groupId + "&userId=" + $("#userId").val(),
        data: {
            groupNumber: groupNumber,
            groupName: groupName,
            startDate: startDate,
            endDate: endDate,
            location: location
        }
    }).done(function () {
        $('#editGroupModal').modal('hide');
        $('#changesMadeModalBody').text('Grupo actualizado exitosamente');
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
            generateGroupsPage();
        })
    }).fail(function (result) {
        alert('Hubo un problema al actualizar el grupo');
    });
}

function sortGroupsByLocation(json) {
    json.groups.sort((a, b) => a.location.localeCompare(b.location));
    json.groups.sort((a, b) => b.groupId.localeCompare(a.groupId));
    if (json.hasOwnProperty('options')) {
        delete json['options'];
    }
    return json;
}

function getUniqueLocations(json) {
    const uniqueLocations = new Set();
    json.groups.forEach(item => {
        uniqueLocations.add(item.location);
    });
    return Array.from(uniqueLocations);
}

function generateCreateGroupFrame(json) {
    // Crear los elementos principales
    const createGroup = document.createElement('div');
    createGroup.id = 'createGroup';
    createGroup.className = 'accordion-collapse collapse';
    createGroup.setAttribute('aria-labelledby', 'headingOne');

    const accordionBody = document.createElement('div');
    accordionBody.className = 'accordion-body';

    const form = document.createElement('form');
    form.action = 'post';
    form.id = 'groupDetailsForm';

    const div = document.createElement('div');
    div.className = 'col mx-3 mt-3';

    // Crear los elementos de entrada
    const inputGroups = ['MECT #', 'Nombre', 'Fecha de Inicio', 'Fecha de Terminación'];
    const inputIds = ['groupId', 'groupName', 'startDate', 'endDate'];
    const inputGroupSelect = document.createElement('div');
    inputGroupSelect.className = 'input-group mt-2 mb-2';
    const select = document.createElement('select');
    const spanSelect = document.createElement('span');
    spanSelect.className = 'input-group-text bg-primary text-white';
    spanSelect.textContent = 'Sede';
    select.id = 'locationSelect';
    select.className = 'form-select';
    select.setAttribute('aria-label', 'Elige una sede');
    const optionSelected = document.createElement('option');
    optionSelected.textContent = 'Elige una sede';
    optionSelected.selected = true;
    select.appendChild(optionSelected);
    let sortedGroupsByLocation = sortGroupsByLocation(json);
    getUniqueLocations(sortedGroupsByLocation).forEach(item => {
        const option = document.createElement('option');
        option.textContent = item;
        option.value = item;
        select.appendChild(option);
    });
    inputGroupSelect.appendChild(spanSelect);
    inputGroupSelect.appendChild(select);
    form.appendChild(inputGroupSelect);

    for (let i = 0; i < inputGroups.length; i++) {
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mt-2 mb-2';
        inputGroup.setAttribute('hidden', '');

        const span = document.createElement('span');
        span.className = 'input-group-text bg-primary text-white';
        span.textContent = inputGroups[i];

        const input = document.createElement('input');
        input.type = 'text';
        input.id = inputIds[i];
        input.className = 'form-control';
        input.setAttribute('aria-label', inputGroups[i]);
        input.title = inputGroups[i];

        if (i === 0) {
            input.disabled = true;
        }

        inputGroup.appendChild(span);
        inputGroup.appendChild(input);
        form.appendChild(inputGroup);
        div.appendChild(form);
    }

    let butSaveChanges = document.createElement('button');
    butSaveChanges.className = 'btn btn-secondary mt-2 mb-2';
    butSaveChanges.textContent = 'Guardar Grupo';
    butSaveChanges.type = 'button';
    butSaveChanges.id = 'butSaveGroup';
    butSaveChanges.setAttribute('onclick', 'saveNewGroup()');
    butSaveChanges.hidden = true;
    form.appendChild(butSaveChanges);

    accordionBody.appendChild(div);
    createGroup.appendChild(accordionBody);

    select.addEventListener('change', function () {
        var groupIdInput = document.getElementById('groupId');
        var groupNameInput = document.getElementById('groupName');
        var startDateInput = document.getElementById('startDate');
        var endDateInput = document.getElementById('endDate');
        filteredValues =
            Object.values(sortedGroupsByLocation)[0].filter(function (item) {
                return item.location == select.value;
            });
        groupIdInput.value = parseInt(filteredValues[0].groupId) + 1;
        groupIdInput.parentElement.hidden = false;
        groupNameInput.parentElement.hidden = false;
        startDateInput.parentElement.hidden = false;
        endDateInput.parentElement.hidden = false;
        butSaveChanges.hidden = false;
        console.log('se removió hidden');
    });

    return createGroup;
}

function saveNewGroup() {
    var params = {
        groupId: document.getElementById('groupId').value,
        groupName: document.getElementById('groupName').value,
        startDate: document.getElementById('startDate').value,
        endDate: document.getElementById('endDate').value,
        location: document.getElementById('locationSelect').value
    };
    if (params.groupId == '' || params.groupName == ''
        || params.startDate == '' || params.endDate == ''
        || params.location == '') {
        alert('favor de llenar todos los campos')
    } else {
        $.ajax({
            method: "POST",
            url: "../php/groupController.php?data=insert&userId=" + document.getElementById("userId").value,
            data: params
        }).done(function (data) {
            if (data == 1) {
                alert('El grupo ya existe');
            } else {
                generateGroupsPage();
                alert('Grupo creado exitosamente');
            }
        }).fail(function (result) {
            console.log(result);
        });
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
            a1.innerHTML = '<strong>' + user.userName + ' ' + user.userLastName + '<strong>\u00A0';
            li.appendChild(a1);

            let em = document.createElement('em');
            em.className = "text-muted";
            em.textContent = 'MECT ' + user.groupId + ' ' + user.groupName + ' - ' + user.groupLocation;
            a1.appendChild(em);

            user.options.forEach(option => {
                switch (option) {
                    case 1:
                        let a2 = document.createElement('a');
                        a2.href = "#";
                        a2.setAttribute('onclick', 'deleteStudent(this)');
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
                        a3.setAttribute('onclick', 'showUserSettings(this, setParametersInSettingsModal)');
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
                        a4.setAttribute('onclick', 'showPaymentFrame(this, setPaymentsFrameInUser, false)');
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
                        a5.setAttribute('onclick', 'showStudentAcademicProfile(this);');
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

function reviewActivity(value, ulId) {
    ulIdParts = ulId.split('_');
    moduleId = ulIdParts[0].replace('mod-', '');
    activityId = ulIdParts[1].replace('act-', '').replace('hw-', '');
    activityType = ulIdParts[1].includes('act') ? '0' : '1';
    var params = {
        activityType: activityType,
        activityId: activityId,
        review: value,
        targetUserId: document.getElementById("currentUserId").textContent
    };
    console.log(params);
    $.ajax({
        method: "PUT",
        url: "../php/moduleController.php?dataType=activityReview&module=" + moduleId + "&userId=" + document.getElementById("userId").value,
        data: JSON.stringify(params),
    }).done(function (data) {
        alert('Actividad actualizada con éxito. Recarga la página para ver todos los cambios');
    }).fail(function (result) {
        console.log(result);
    });
}

function showMessageModal(title, message, callback = null, autodismiss = false) {
    $('#changesMadeModalTitle').text(title);
    $('#changesMadeModalBody').text(message);
    $('#changesMadeModal').modal('show');
    $('#changesMadeModal').on('shown.bs.modal', function () {
        if (autodismiss) {
            var seconds = 3;
            var interval = setInterval(function () {
                if (seconds <= 0) {
                    clearInterval(interval);  // Limpiar el intervalo cuando se alcance 0
                    $('#changesMadeModal').modal('hide');  // Esconder el modal
                } else {
                    seconds--;
                }
            }, 1000);
        }

        if (callback) {
            callback();
        }
    });
}