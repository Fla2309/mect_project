var groupHtml = "";

function showGroupHtml(button) {
    var group_id = button.id.replace("but-gr-", "");
    var url =
        prepareUrlGroups(document.getElementsByClassName("user_properties"), group_id);
    groupHtml = $('#grupos').html();
    $('#grupos').load("../view/group.php?" + url);
}

function reloadGroups() {
    generateGroupsPage();
}

function prepareGroupUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['placeholder'].value + '=' + element.value)
    });
    return result.join('&');
}

function prepareUrlGroups(data, group_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('group' + '=' + group_id);
    return result.join('&');
}