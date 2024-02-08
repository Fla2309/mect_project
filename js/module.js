function reloadModules() {
    generateModulesPage();
}

function reloadModule() {
    fillModuleDetails();
}

function prepareUrl(data, module_id) {
    let result = [];
    result.push('userId' + '=' + data[1].attributes['placeholder'].value);
    result.push('module' + '=' + module_id);
    return result.join('&');
}

function showModuleHtml(button) {
    var module_id = getModuleId(button);
    var url = prepareUrl(document.getElementsByClassName("user_properties"), module_id);
    $.ajax({
        method: "GET",
        url: "../view/module.php?" + url
    }).done(function (data) {
        $('#modulos').html(data);
        fillModuleDetails();
    }).fail({

    })
}

function fillModuleDetails() {
    var module_id = document.getElementById('moduleId').value;
    var url = prepareUrl(document.getElementsByClassName("user_properties"), module_id) + '&dataType=all';
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/moduleController.php?" + url
    }).done(function (data) {
        setModuleFrame(data);
        console.log(data)
    }).fail({

    })
}

function getModuleId(htmlElement) {
    currentElement = $(htmlElement);
    while (currentElement.length > 0) {
        var currentId = currentElement.attr('id');
        if (currentId && currentId.includes('idModule-')) {
            return currentId.replace('idModule-', '');
        }
        currentElement = currentElement.parent();
    }
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

function setModuleFrame(json) {
    setTrabajosFrame(json.works);
    setTareasFrame(json.homeworks);
    setFeedbackFrame(json.feedback);
}

function getTrabajos() {
    var module_id = getModuleId(button);
    var url = prepareUrl(document.getElementsByClassName("user_properties"), module_id) + '&dataType=works';
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?" + url
    }).done(function (data) {
        return data;
    }).fail(function (data) {
        console.log('Error al obtener los trabajos: ' + data)
    })
}

function getTareas() {
    var module_id = getModuleId(button);
    var url = prepareUrl(document.getElementsByClassName("user_properties"), module_id) + '&dataType=homeworks';
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?" + url
    }).done(function (data) {
        return data;
    }).fail(function (data) {
        console.log('Error al obtener las tareas: ' + data)
    })
}

function getFeedback() {
    var module_id = getModuleId(button);
    var url = prepareUrl(document.getElementsByClassName("user_properties"), module_id) + '&dataType=feedback';
    $.ajax({
        method: "GET",
        url: "../php/moduleController.php?" + url
    }).done(function (data) {
        return data;
    }).fail(function (data) {
        console.log('Error al obtener feedback: ' + data)
    })
}

function setTrabajosFrame(json) {
    document.getElementById('trabajos').innerHTML = '';
    if (Object.keys(json).length === 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay trabajos para mostrar';
        document.getElementById('trabajos').appendChild(h5);
        return;
    }
    json.forEach(jsonRow => {
        const aListGroupItem = document.createElement('a');
        const divTitle = document.createElement('div');
        const h5 = document.createElement('h5');
        const smallDate = document.createElement('small');
        const span = document.createElement('span');
        const divInline = document.createElement('div');
        const divStatus = document.createElement('div');
        const smallStatus = document.createElement('small');
        const form = document.createElement('form');
        const aDownload = document.createElement('a');
        const imgTemplate = document.createElement('img');
        aListGroupItem.classList.add('list-group-item');
        aListGroupItem.classList.add('list-group-item-action');
        divTitle.classList.add('d-flex');
        divTitle.classList.add('w-100');
        divTitle.classList.add('justify-content-between');
        h5.classList.add('mb-1');
        h5.textContent = jsonRow.workName;
        smallDate.textContent = jsonRow.dateUploaded;
        switch (jsonRow.status) {
            case '0':
                span.textContent = 'Pendiente';
                break;
            case '1':
                span.style.color = 'goldenrod';
                span.style.fontWeight = 'bold';
                span.textContent = 'En revisión';
                break;
            case '2':
                span.style.color = 'darkred';
                span.style.fontWeight = 'bold';
                span.textContent = 'Rechazado';
                break;
            case '3':
                span.style.color = 'dodgerblue';
                span.style.fontWeight = 'bold';
                span.textContent = 'Revisado';
                break;
        }
        divInline.style = 'display: inline-block';
        divStatus.classList.add('d-flex');
        divStatus.classList.add('justify-content-center');
        smallStatus.classList.add('text-muted');
        smallStatus.textContent = 'Estado: ';
        smallStatus.appendChild(span);
        imgTemplate.classList.add('dashboard_icon');
        imgTemplate.classList.add('m-2');
        imgTemplate.src = 'img/template.png';
        imgTemplate.title = 'Descargar plantilla';
        if (jsonRow.template != 'Sin plantilla') {
            aDownload.href = jsonRow.template;
            aDownload.download = jsonRow.template;
        }
        else
            imgTemplate.title = 'No hay plantilla disponible';
        divTitle.appendChild(h5, smallDate);
        divInline.appendChild(smallStatus);
        aDownload.appendChild(imgTemplate);
        form.appendChild(aDownload);
        if (jsonRow.options.find(x => x == 'upload')) {
            let inputMaxFile;
            let label;
            let imgUpload;
            let inputUpload;
            inputMaxFile = document.createElement('input');
            inputMaxFile.hidden = 'true';
            inputMaxFile.name = 'MAX_FILE_SIZE';
            inputMaxFile.value = '10485760';
            label = document.createElement('label');
            label.setAttribute('for', 'trabajos-file-input-' + jsonRow.workId);
            label.setAttribute('onclick', 'selectFile(this)');
            imgUpload = document.createElement('img');
            imgUpload.classList.add('dashboard_icon');
            imgUpload.classList.add('m-2');
            imgUpload.src = 'img/upload.png';
            imgUpload.title = 'Subir Trabajo';
            inputUpload = document.createElement('input');
            inputUpload.id = 'trabajos-file-input-' + jsonRow.workId;
            inputUpload.style = 'display: none;';
            inputUpload.name = 'foto';
            inputUpload.type = 'file';
            inputUpload.setAttribute('onchange', 'uploadFile(this, \'work\')');
            label.appendChild(imgUpload);
            form.appendChild(inputMaxFile);
            form.appendChild(label);
            form.appendChild(inputUpload);
        }
        if (jsonRow.options.find(x => x == 'download')) {
            let aAttachment;
            let imgDownload;
            aAttachment = document.createElement('a');
            aAttachment.href = jsonRow.userLocalPath + 'trabajos/' + jsonRow.file;
            aAttachment.download = jsonRow.file;
            imgDownload = document.createElement('img');
            imgDownload.classList.add('dashboard_icon');
            imgDownload.classList.add('m-2');
            imgDownload.title = 'Descargar Trabajo'
            imgDownload.src = 'img/download.png';
            aAttachment.appendChild(imgDownload);
            form.appendChild(aAttachment);
        }
        divInline.appendChild(form);
        aListGroupItem.appendChild(divTitle);
        aListGroupItem.appendChild(divInline);
        aListGroupItem.innerHTML += '<hr class="divider">';
        document.getElementById('trabajos').appendChild(aListGroupItem);
    })
}

function setTareasFrame(json) {
    document.getElementById('tareas').innerHTML = '';
    if (Object.keys(json).length === 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay tareas para mostrar';
        document.getElementById('tareas').appendChild(h5);
        return;
    }
    json.forEach(jsonRow => {
        const aListGroupItem = document.createElement('a');
        const divTitle = document.createElement('div');
        const h5 = document.createElement('h5');
        const smallDate = document.createElement('small');
        const span = document.createElement('span');
        const divInline = document.createElement('div');
        const divStatus = document.createElement('div');
        const smallStatus = document.createElement('small');
        const form = document.createElement('form');
        const aDownload = document.createElement('a');
        const imgTemplate = document.createElement('img');
        aListGroupItem.classList.add('list-group-item');
        aListGroupItem.classList.add('list-group-item-action');
        divTitle.classList.add('d-flex');
        divTitle.classList.add('w-100');
        divTitle.classList.add('justify-content-between');
        h5.classList.add('mb-1');
        h5.textContent = jsonRow.homeworkName;
        smallDate.textContent = jsonRow.dateUploaded;
        switch (jsonRow.status) {
            case '0':
                span.textContent = 'Pendiente';
                break;
            case '1':
                span.style.color = 'goldenrod';
                span.style.fontWeight = 'bold';
                span.textContent = 'En revisión';
                break;
            case '2':
                span.style.color = 'darkred';
                span.style.fontWeight = 'bold';
                span.textContent = 'Rechazado';
                break;
            case '3':
                span.style.color = 'dodgerblue';
                span.style.fontWeight = 'bold';
                span.textContent = 'Revisado';
                break;
        }
        divInline.style = 'display: inline-block';
        divStatus.classList.add('d-flex');
        divStatus.classList.add('justify-content-center');
        smallStatus.classList.add('text-muted');
        smallStatus.textContent = 'Estado: ';
        smallStatus.appendChild(span);
        imgTemplate.classList.add('dashboard_icon');
        imgTemplate.classList.add('m-2');
        imgTemplate.src = 'img/template.png';
        imgTemplate.title = 'Descargar plantilla';
        if (jsonRow.template != 'Sin plantilla') {
            aDownload.href = jsonRow.template;
            aDownload.download = jsonRow.template;
        }
        else
            imgTemplate.title = 'No hay plantilla disponible';
        divTitle.appendChild(h5, smallDate);
        divInline.appendChild(smallStatus);
        aDownload.appendChild(imgTemplate);
        form.appendChild(aDownload);
        if (jsonRow.options.find(x => x == 'upload')) {
            let inputMaxFile;
            let label;
            let imgUpload;
            let inputUpload;
            inputMaxFile = document.createElement('input');
            inputMaxFile.hidden = 'true';
            inputMaxFile.name = 'MAX_FILE_SIZE';
            inputMaxFile.value = '10485760';
            label = document.createElement('label');
            label.setAttribute('for', 'tareas-file-input-' + jsonRow.homeworkId);
            label.setAttribute('onclick', 'selectFile(this)');
            imgUpload = document.createElement('img');
            imgUpload.classList.add('dashboard_icon');
            imgUpload.classList.add('m-2');
            imgUpload.src = 'img/upload.png';
            imgUpload.title = 'Subir Tarea';
            inputUpload = document.createElement('input');
            inputUpload.id = 'tareas-file-input-' + jsonRow.homeworkId;
            inputUpload.style = 'display: none;';
            inputUpload.name = 'foto';
            inputUpload.type = 'file';
            inputUpload.setAttribute('onchange', 'uploadFile(this, \'homework\')');
            label.appendChild(imgUpload);
            form.appendChild(inputMaxFile);
            form.appendChild(label);
            form.appendChild(inputUpload);
        }
        if (jsonRow.options.find(x => x == 'download')) {
            let aAttachment;
            let imgDownload;
            aAttachment = document.createElement('a');
            aAttachment.href = jsonRow.userLocalPath + 'tareas/' + jsonRow.file;
            aAttachment.download = jsonRow.file;
            imgDownload = document.createElement('img');
            imgDownload.classList.add('dashboard_icon');
            imgDownload.classList.add('m-2');
            imgDownload.title = 'Descargar Tarea'
            imgDownload.src = 'img/download.png';
            aAttachment.appendChild(imgDownload);
            form.appendChild(aAttachment);
        }
        divInline.appendChild(form);
        aListGroupItem.appendChild(divTitle);
        aListGroupItem.appendChild(divInline);
        aListGroupItem.innerHTML += '<hr class="divider">';
        document.getElementById('tareas').appendChild(aListGroupItem);
    })
}

function setFeedbackFrame(json) {
    document.getElementById('feedback').innerHTML = '';
    if (Object.keys(json).length === 0) {
        const h5 = document.createElement('h5');
        h5.textContent = 'No hay feedback para mostrar';
        document.getElementById('feedback').appendChild(h5);
        return;
    }
}