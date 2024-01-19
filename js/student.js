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

function showCoachingModal(newCoaching) {
    if (newCoaching) {
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        day = (day < 10) ? '0' + day : day;
        month = (month < 10) ? '0' + month : month;
        var dateFormatted = year + '-' + month + '-' + day;
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
    var row = '<tr id="idCoaching-' + data.idCoaching + '">';
    row += '<h2 class="accordion-header" id="heading-' + data.idCoaching + '">';
    row += '<td>';
    row += '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#collapse-' + data.idCoaching + '" aria-expanded="false" aria-controls="collapse-' + data.idCoaching + '">' + data.nameCoaching + '</button>';
    row += '</td>';
    row += '</h2>';
    row += '<td>' + data.coacheeName + '</td>';
    row += '<td>' + data.date + '</td>';
    row += '<td>';
    // Agrega las opciones que desees aquí
    row += '<button class="btn btn-primary" onclick="setCoachingModal(this)">Editar</button>';
    row += '<button class="btn btn-danger">Borrar</button>';
    // ...
    row += '</td>';
    row += '</tr>';
    row += '<tr>';
    row += '<td colspan="3" class="p-0">';
    row += '<div class="accordion-collapse collapse" id="collapse-' + data.idCoaching + '">';
    row += '<div class="accordion-body mt-2">';
    // Añade más contenido del accordion según tus necesidades
    row += '<p class="ms-5"><strong>Lugar:</strong><br>' + data.place + '</p>';
    row += '<p class="ms-5"><strong>Descripción del lugar:</strong><br>' + data.placeDesc + '</p>';
    row += '<p class="ms-5"><strong>Tiempo de interacción:</strong><br>' + data.timeOfInteraction + '</p>';
    row += '<p class="ms-5"><strong>¿Cuál fue el quiebre declarado?:</strong><br>' + data.topicDeclared + '</p>';
    row += '<p class="ms-5"><strong>¿Cuál fue el quiebre que se trabajó?:</strong><br>' + data.topicHandled + '</p>';
    row += '<p class="ms-5"><strong>¿Cómo fue el proceso de indagación? ¿Qué valor le agregó a la conversación?:</strong><br>' + data.process + '</p>';
    row += '<p class="ms-5"><strong>¿Cuál fue la interpretación que tuviste del quiebre?:</strong><br>' + data.interpretation + '</p>';
    row += '<p class="ms-5"><strong>¿Cómo fue la emoción de la interacción?:</strong><br>' + data.interactionEmotions + '</p>';
    row += '<p class="ms-5"><strong>¿Cómo fue la corporalidad del coachee durante la interacción?:</strong><br>' + data.bodyLang + '</p>';
    row += '<p class="ms-5"><strong>¿Qué nuevas acciones son posibles para el coachee después de tu intervención?:</strong><br>' + data.newActions + '</p>';
    row += '<p><h5 class="ms-4">REFLEXIONES POSTERIORES AL COACHING</h5></p>';
    row += '<p class="ms-5"><strong>¿Qué emociones vivencié?:</strong><br>' + data.myEmotions + '</p>';
    row += '<p class="ms-5"><strong>¿Qué áreas de aprendizaje puedo declarar?:</strong><br>' + data.areasOfOportunity + '</p>';
    row += '<p class="ms-5"><strong>¿Qué nuevas preguntas surgen a partir de esta experiencia?:</strong><br>' + data.newQuestions + '</p>';
    row += '</div></div></td></tr>';
    return row;
}

function setCoachingModal(button) {
    coachingId = getCoachingId(button);
    setCoachingDataInModal(coachingId);
    showCoachingModal(false);
}

function getCoachingId(button) {
    currentElement = $(button);
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