function generateModulesPage() {
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?dataType=modules&user=" + document.getElementById("user").value + "&userId=" + document.getElementById("userId").value,
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

function generatePresentationsPage() {
    $.ajax({
        method: "GET",
        url: "../php/presentationsController.php?type=0&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if (data.length == 0) {
            $('#presentationsTable').html('<h4 class="ms-3">No hay contenido para mostrar</h4>');
        }
        else {
            $('#presentationsTableBody').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function generateTestsPage() {
    getFinishedTests(document.getElementById("userId").value);
    getActiveTests(document.getElementById("userId").value);
}

function getFinishedTests(userId) {
    $.ajax({
        method: "GET",
        url: "../php/testsController.php?type=0&userId=" + userId,
    }).done(function (data) {
        if (data.length == 0) {
            $('#finishedTests').html('<h4 class="ms-3">No hay exámenes para mostrar</h4>');
        }
        else {
            $('#finishedTests').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function getActiveTests(userId) {
    $.ajax({
        method: "GET",
        url: "../php/testsController.php?type=1&userId=" + userId,
    }).done(function (data) {
        if (data.length == 0) {
            $('#activeTests').html('<h4 class="ms-3">No hay exámenes activos</h4>');
        }
        else {
            $('#activeTests').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function goToTab(link) {
    id = link.getAttribute("href").replace('#', "") + "NavItem";
    document.getElementById(id).getElementsByTagName("a")[0].click();
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

function showCoachingModal(newCoaching) {
    if (newCoaching) {
        var dateFormatted = getCurrentDate();
        $('#coachingId').val('');
        $('#coachingName').val('');
        if ($('#coachingName').attr('disabled') !== undefined)
            $('#coachingName').removeAttr('disabled');
        $('#coachingUserName').val($('#userFullName').val());
        $('#coachingDate').val(dateFormatted);
        $('#coachingPlace').val('');
        $('#placeDesc').val('');
        $('#timeOfInteraction').val('');
        $('#coacheeName').val('');
        $('#topicDeclared').val('');
        $('#topicHandled').val('');
        $('#coachingProcess').val('');
        $('#coachingInterpretation').val('');
        $('#interactionEmotions').val('');
        $('#bodyLang').val('');
        $('#newActions').val('');
        $('#myEmotions').val('');
        $('#areasOfOportunity').val('');
        $('#newQuestions').val('');
    }
    $('#coachingModal').modal('show');
}

function dismissCoachingModal() {
    $('#coachingModal').modal('hide');
}

function generateCoachingPage() {
    var user = document.getElementById('user').getAttribute('value');
    var html = '';
    $.ajax({
        method: "GET",
        url: "../php/coachingController.php?type=1&user=" + user
    }).done(function (data) {
        if (data.length == 0) {
            $('#coaching tbody').html('<h4 class="ms-3">No hay sesiones registradas</h4>');
        }
        else {
            data.forEach(function (row) {
                html += convertCoachingJsonToHtml(row);
            });
            $('#coaching tbody').html(html);
        }
    }).fail(function (result) {
        alert(result);
    });
}

function convertCoachingJsonToHtml(data) {
    var row =
        row += '<tr id="idCoaching-' + data.idCoaching + '">';
    row += '<th>' + data.nameCoaching;
    row += '</th>';
    row += '<td>' + data.coacheeName + '</td>';
    row += '<td>' + data.date + '</td>';
    row += '<td>';
    row += '<button class="btn btn-outline-secondary collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#collapse-' + data.idCoaching + '" aria-expanded="false" aria-controls="collapse-' + data.idCoaching + '">Ver Contenido</button>';
    row += '<button class="btn btn-outline-primary ms-2" onclick="setCoachingModal(this)">Editar</button>';
    row += '<button class="btn btn-outline-danger ms-2" onclick="deleteCoaching(this)">Borrar</button>';
    row += '</td>';
    row += '</tr>';
    row += '<tr>';
    row += '<td colspan="4" class="p-0" style="width: auto;">';
    row += '<div class="accordion-collapse collapse" id="collapse-' + data.idCoaching + '">';
    row += '<div class="accordion-body pt-2">';
    row += '<p class="text-break ps-5"><strong>Lugar:</strong><br>' + data.place + '</p>';
    row += '<p class="text-break ps-5"><strong>Descripción del lugar:</strong><br>' + data.placeDesc + '</p>';
    row += '<p class="text-break ps-5"><strong>Tiempo de interacción:</strong><br>' + data.timeOfInteraction + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cuál fue el quiebre declarado?:</strong><br>' + data.topicDeclared + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cuál fue el quiebre que se trabajó?:</strong><br>' + data.topicHandled + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cómo fue el proceso de indagación? ¿Qué valor le agregó a la conversación?:</strong><br>' + data.process + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cuál fue la interpretación que tuviste del quiebre?:</strong><br>' + data.interpretation + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cómo fue la emoción de la interacción?:</strong><br>' + data.interactionEmotions + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Cómo fue la corporalidad del coachee durante la interacción?:</strong><br>' + data.bodyLang + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Qué nuevas acciones son posibles para el coachee después de tu intervención?:</strong><br>' + data.newActions + '</p>';
    row += '<p><h5 class="ms-4">REFLEXIONES POSTERIORES AL COACHING</h5></p>';
    row += '<p class="text-break ps-5"><strong>¿Qué emociones vivencié?:</strong><br>' + data.myEmotions + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Qué áreas de aprendizaje puedo declarar?:</strong><br>' + data.areasOfOportunity + '</p>';
    row += '<p class="text-break ps-5"><strong>¿Qué nuevas preguntas surgen a partir de esta experiencia?:</strong><br>' + data.newQuestions + '</p>';
    row += '</div></div></td></tr>';
    return row;
}

function setCoachingModal(button) {
    coachingId = getCoachingId(button);
    setCoachingDataInModal(coachingId);
    showCoachingModal(false);
}

function getCoachingId(htmlElement) {
    currentElement = $(htmlElement);
    while (currentElement.length > 0) {
        var currentId = currentElement.attr('id');
        if (currentId && currentId.includes('idCoaching-')) {
            return currentId.replace('idCoaching-', '');
        }
        currentElement = currentElement.parent();
    }
}

function setCoachingDataInModal(coachingId) {
    var user = document.getElementById('user').getAttribute('value');
    $.ajax({
        method: "GET",
        url: "../php/coachingController.php?type=1&coachingId=" + coachingId + "&user=" + user
    }).done(function (data) {
        $('#coachingId').val(data.idCoaching);
        $('#coachingName').val(data.nameCoaching);
        $('#coachingName').attr('disabled', '');
        $('#coachingUserName').val($('#userFullName').val());
        $('#coachingDate').val(data.date);
        $('#coachingPlace').val(data.place);
        $('#placeDesc').val(data.placeDesc);
        $('#timeOfInteraction').val(data.timeOfInteraction);
        $('#coacheeName').val(data.coacheeName);
        $('#topicDeclared').val(data.topicDeclared);
        $('#topicHandled').val(data.topicHandled);
        $('#coachingProcess').val(data.process);
        $('#coachingInterpretation').val(data.interpretation);
        $('#interactionEmotions').val(data.interactionEmotions);
        $('#bodyLang').val(data.bodyLang);
        $('#newActions').val(data.newActions);
        $('#myEmotions').val(data.myEmotions);
        $('#areasOfOportunity').val(data.areasOfOportunity);
        $('#newQuestions').val(data.newQuestions);
    }).fail(function (result) {
        alert(result);
    });
}

function saveCoaching() {
    if ($('#coachingId').val() != '') {
        updateCoaching($('#coachingId').val());
    } else {
        registerCoaching();
    }
}

function updateCoaching(coachingId) {
    var userId = document.getElementById('userId').getAttribute('value');
    var jsonBody = {
        idCoaching: coachingId,
        nameCoaching: $('#coachingName').val(),
        coachingUserName: $('#coachingUserName').val(),
        date: $('#coachingDate').val(),
        place: $('#coachingPlace').val(),
        placeDesc: $('#placeDesc').val(),
        timeOfInteraction: $('#timeOfInteraction').val(),
        coacheeName: $('#coacheeName').val(),
        topicDeclared: $('#topicDeclared').val(),
        topicHandled: $('#topicHandled').val(),
        process: $('#coachingProcess').val(),
        interpretation: $('#coachingInterpretation').val(),
        interactionEmotions: $('#interactionEmotions').val(),
        bodyLang: $('#bodyLang').val(),
        newActions: $('#newActions').val(),
        myEmotions: $('#myEmotions').val(),
        areasOfOportunity: $('#areasOfOportunity').val(),
        newQuestions: $('#newQuestions').val(),
    }
    $.ajax({
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        url: "../php/coachingController.php?type=3&userId=" + userId,
        data: JSON.stringify(jsonBody)
    }).done(function (data) {
        if (data == 1) {
            dismissCoachingModal();
            alert('Actualización de coaching exitoso');
            setTimeout(generateCoachingPage(), 1000);
        } else {
            alert('Fallo al actualizar coaching: ' + data);
        }
    }).fail(function (result) {
        alert(result);
    });
}

function registerCoaching() {
    var userId = document.getElementById('userId').getAttribute('value');
    var jsonBody = {
        nameCoaching: $('#coachingName').val(),
        coachingUserName: $('#coachingUserName').val(),
        date: $('#coachingDate').val(),
        place: $('#coachingPlace').val(),
        placeDesc: $('#placeDesc').val(),
        timeOfInteraction: $('#timeOfInteraction').val(),
        coacheeName: $('#coacheeName').val(),
        topicDeclared: $('#topicDeclared').val(),
        topicHandled: $('#topicHandled').val(),
        process: $('#coachingProcess').val(),
        interpretation: $('#coachingInterpretation').val(),
        interactionEmotions: $('#interactionEmotions').val(),
        bodyLang: $('#bodyLang').val(),
        newActions: $('#newActions').val(),
        myEmotions: $('#myEmotions').val(),
        areasOfOportunity: $('#areasOfOportunity').val(),
        newQuestions: $('#newQuestions').val(),
    }
    $.ajax({
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        url: "../php/coachingController.php?type=2&userId=" + userId,
        data: JSON.stringify(jsonBody)
    }).done(function (data) {
        if (data == 1) {
            dismissCoachingModal();
            alert('Registro de coaching exitoso');
            setTimeout(generateCoachingPage(), 1000);
        } else {
            alert('Fallo al registrar coaching: ' + data);
        }
    }).fail(function (result) {
        alert(result);
    });
}

function deleteCoaching(button) {
    var coachingId = getCoachingId(button);
    var userId = document.getElementById('userId').getAttribute('value');
    var confirm = window.confirm("¿Estás seguro de que quieres eliminar " + $('#idCoaching-' + coachingId + ' .accordion-button').text() + "?");
    if (confirm) {
        $.ajax({
            method: "POST",
            url: "../php/coachingController.php?type=4&coachingId=" + coachingId + "&userId=" + userId,
        }).done(function (data) {
            if (data == 1) {
                dismissCoachingModal();
                alert('La sesión de coaching fue eliminada con éxito');
                setTimeout(generateCoachingPage(), 1000);
            } else {
                alert('Fallo al eliminar coaching: ' + data);
            }
        }).fail(function (result) {
            alert(result);
        });
    }
}

function setModulesHtml(json) {
    count = 1;
    $('#modulos').html('');
    
    var divRow = document.createElement('div');
    divRow.className = 'row g-0';
    divRow.style.alignContent = 'center';
    for (let i = 0; i < json.length; i++) {
        if (i % 3 === 0) {
        }

        let module = json[i];
        let divCol = document.createElement('div');
        let divP1 = document.createElement('div');
        let h2 = document.createElement('h2');
        let h4 = document.createElement('h4');
        let p = document.createElement('p');
        let button = document.createElement('button');
        divCol.className = 'col-sm-3 p-5 m-3';
        divCol.style.backgroundColor = 'white';
        divCol.id = 'idModule-' + module.moduleId;
        divP1.className = 'p-1';
        button.className = 'btn btn-primary';
        button.type = 'button';
        button.onclick = "showModuleHtml(this)";
        button.style.width = '120px';
        button.style.textAlign = 'left';
        h2.textContent = module.moduleName;
        h4.textContent = module.description;
        p.textContent = module.progress + '% completado';
        button.setAttribute('onclick', 'showModuleHtml(this)');
        button.textContent = 'Ver Módulo';
        divP1.append(h2, h4, p, button);
        divCol.appendChild(divP1);
        divRow.appendChild(divCol);

        if (i % 3 === 2 || i === json.length - 1) {
            
        }
    }
    document.getElementById('modulos').appendChild(divRow);
}