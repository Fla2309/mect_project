var html = "";

function prepareUrl(data, module_id) {
    let result = [];
    result.push('userId' + '=' + data[1].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function showModuleHtml(button) {
    var module_id = button.id.replace("but_mod_", "");
    var url =
        prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    html = $('#modulos').html();
    $.ajax({
        method: "GET",
        url: "../view/module.php?" + url
    }).done(function (data) {
        $('#modulos').html(data)
    }).fail({

    })
}

function reloadModules() {
    $('#modulos').html(html);
}


function pushStateHistoryTab(event) {
    const tab = event.target;
    const tabId = tab.getAttribute('data-bs-target');
    history.pushState({ tabId: tabId }, '', `${tabId}`);
}
const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', pushStateHistoryTab);
});

function selectNavItemFromURL() {
    const hash = window.location.hash;
    const navItem = $(`a[href="${hash}"]`);
    if (navItem) {
        $(navItem).click();
    }
}

function navigateBackEventHandler(event) {
    selectNavItemFromURL();
}
selectNavItemFromURL();
window.addEventListener('popstate', navigateBackEventHandler);