var groupHtml = "";

function showGroupHtml(button) {
    var module_id = button.id.replace("but_gr_", "");
    console.log(module_id);
    var url =
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    groupHtml=$('#grupos').html();
    $('#grupos').load("../view/group.php?" + url);
}

function reloadGroups(){
    $('#grupos').html(groupHtml);
}

function prepareGroupUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['placeholder'].value + '=' + element.value)
    });
    return result.join('&');
}

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}