var html="";

function prepareUrl(data, module_id) {
    let result = [];
    result.push('user' + '=' + data[0].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function showModuleHtml(button) {
    var module_id = button.id.replace("but_mod_","");
    var url = 
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    html=$('#modulos').html();
    $('#modulos').load("../view/module.php?" + url);
}

function reloadModules(){
    ;
    $('#modulos').html(html);
}