$(function () {
    let data = [];
    const $selects = $('#groupSelects select');
    $selects.on('change', event => {
        const query = $selects.map((i, e) => e.selectedIndex > 0 ? (`${e.id}=${encodeURIComponent(e.value)}`) : []).get().join('&');
        const url = `/php/getGroups.php?${query}`;
        $.ajax({
            method: "GET",
            url: url,
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
        }).done(function (response) {
            $('#groupsFrame').html(decodeURIComponent(response));
        });
    });
});

groupHtml = "";

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function prepareUrl(data) {
    let result = [];
    $.each(data, function (key, element) {
        result.push(element.attributes['value'].value + '=' + element.value)
    });
    return result.join('&');
}