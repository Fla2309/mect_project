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

function prepareUrl(data, group_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('group' + '=' + group_id);
    return result.join('&');
}

function searchUser() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("txtUser");
    filter = input.value.toUpperCase();
    ul = document.getElementById("usersList");
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