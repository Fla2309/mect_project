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