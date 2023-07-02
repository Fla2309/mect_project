function addActivity() {

}

function addHomework() {

}

function showEditPanel(data) {
    $('#editModal').modal('show');
    var parent = $(data).parent();
    var type;
    var idString;
    if ($(parent).attr('id').includes("mod_hw_")) {
        type = 1;
        idString = "hwId=" + type;
    }
    else if ($(parent).attr('id').includes("mod_act_")) {
        type = 2;
        idString = "actId=" + type;
    }
    console.log(type);
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?type=" + type + "&" + idString
    }).done(function (data) {
        $('#actId').attr('value',data['actId']);
        $('#actType').attr('value',data['actType']);
        $('#actName').attr('value',data['actName']);
        $('#moduleName').attr('value',data['moduleName']);
        $('#comments').attr('value',data['comments']);
        $('#spinner').modal('hide');
        $('#editModal').modal('show');
    }).fail(function () {

    });
}

function saveChanges() {

}