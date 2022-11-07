function selectFilter(){

}

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function showGroupHtml(button) {
    var module_id = button.id.replace("but_gr_","");
    var url = 
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    $('#grupos').load("../view/group.php?" + url);
}