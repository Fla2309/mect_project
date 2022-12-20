$(function () {
    let data = [];
    const $selects = $('#groupSelects select');
    $selects.on('change', event => {
        const query = $selects.map((i, e) => e.selectedIndex > 0 ? (`${e.id}=${encodeURIComponent(e.value)}`) : []).get().join('&');
        const url = `/php/getGroups.php?${query}`;
        $.ajax({
            method: "GET",
            url: url
        }).done(function (response) {
            $('#groupsFrame').html(decodeURIComponent(response));
        });
    });
})

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function showGroupHtml(button) {
    var module_id = button.id.replace("but_gr_", "");
    var url =
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    $('#grupos').load("../view/group.php?" + url);
}

function prepareUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['value'].value + '=' + element.value)
    });
    return result.join('&');
}