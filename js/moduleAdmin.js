function addActivity() {

}

function addHomework() {

}

function showEditPanel(data) {
    var parent = $(data).parent();
    var type;
    var idString;
    if ($(parent).id().contains("mod_hw_")) {
        type = 1;
        idString = "hwId=" + type;
    }
    else if ($(parent).id().contains("mod_act_")) {
        type = 2;
        idString = "actId=" + type;
    }
    console.log(type);
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?type=" + type + "&" + idString
    }).done(function () {

    }).fail(function () {

    });
    $('#editModal').modal('show');
}

function saveChanges() {

}