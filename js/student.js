function generatePresentationsPage(){
    $.ajax({
        method: "GET",
        url: "../php/presentationsController.php?type=0&userId=" + document.getElementById("userId").value,
    }).done(function (data) {
        if(data.length == 0){
            $('#presentationsTable').html('<h4 class="ms-3">No hay contenido para mostrar</h4>');
        }
        else{
            $('#presentationsTableBody').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function generateTestsPage(){
    getFinishedTests(document.getElementById("userId").value);
    getActiveTests(document.getElementById("userId").value);
}

function getFinishedTests(userId){
    $.ajax({
        method: "GET",
        url: "../php/testsController.php?type=0&userId=" + userId,
    }).done(function (data) {
        if(data.length == 0){
            $('#finishedTests').html('<h4 class="ms-3">No hay exámenes para mostrar</h4>');
        }
        else{
            $('#finishedTests').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function getActiveTests(userId){
    $.ajax({
        method: "GET",
        url: "../php/testsController.php?type=1&userId=" + userId,
    }).done(function (data) {
        if(data.length == 0){
            $('#activeTests').html('<h4 class="ms-3">No hay exámenes activos</h4>');
        }
        else{
            $('#activeTests').html(data);
        }
    }).fail(function (result) {
        console.log(result);
    });
}

function goToTab(link) {
    id=link.getAttribute("href").replace('#',"") + "NavItem";
    document.getElementById(id).getElementsByTagName("a")[0].click();
}

function showCoachingModal(){
    $('#coachingModal').modal('show');
}