function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    console.log(data['placeholder'])
    return result.join('&');
}

function showModuleHtml(button) {
    var module_id = button.id.replace("but_mod_","");
    console.log($(this).attr("id"));
    var url = 
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    $('#modulos').load("../php/module.php?" + url);
}