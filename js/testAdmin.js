function loadTestsPage() {
    retrieveGroups(setGroupSelects);
    retrieveExams(setExamsHtml);
}

function setExamsHtml(json) {
    document.getElementById('testsList').innerHTML = '';
    setActiveExamsHtml(json.active);
    setOpenExamsHtml(json.open);
    setFinishedExamsHtml(json.finished);
}

function retrieveGroups(callback) {
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/testsController.php?type=2&userId=" + $('#userId').val(),
        success: function (json) {
            callback(json);
        }
    });
}

function retrieveExams(callback) {
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/testsController.php?type=4&userId=" + $('#userId').val(),
        success: function (json) {
            callback(json);
        }
    });
}

function setOpenExamsHtml(json) {
    const jsonData = json;
    if (Object.keys(jsonData).length !== 0) {
        const h2 = document.createElement('h2');
        h2.classList.add('mt-3');
        h2.textContent = 'Exámenes abiertos';
        document.getElementById('testsList').append(h2);
    }
    jsonData.forEach((item) => {
        const listGroupItem = document.createElement('a');
        listGroupItem.classList.add('list-group-item');
        listGroupItem.classList.add('list-group-item-action');
        listGroupItem.classList.add('align-items-center');
        listGroupItem.id = item.egId;

        const p = document.createElement('p');
        p.classList.add('fw-bold');
        p.textContent = item.testName;
        listGroupItem.appendChild(p);

        const div = document.createElement('div');
        div.classList.add('justify-content-between');

        const group = document.createElement('div');
        group.classList.add('d-flex', 'pr-2');
        group.textContent = `Grupo: `;

        const p1 = document.createElement('p');
        p1.classList.add('fw-bold');
        p1.textContent = `${item.groupLocation} - ${item.groupNumber} ${item.groupName}`;
        group.appendChild(p1);

        const div2 = document.createElement('div');
        div2.classList.add('pr-2');

        const small = document.createElement('small');
        small.classList.add('text-muted');
        small.style.fontSize = '10px';
        small.textContent = 'Abierto: ' + item.dateApplied;

        const div3 = document.createElement('div');
        div3.className = 'pr-2 text-end';

        const button = document.createElement('button');
        button.className = 'btn btn-primary mt-2';
        button.textContent = 'Activar';
        button.addEventListener('click', () => showActivateExamModal(item.egId, `${item.testName} (${item.groupLocation} - ${item.groupNumber} ${item.groupName})`))
        div3.appendChild(button);

        div2.appendChild(small);
        div.appendChild(group);
        div.appendChild(div2);
        div.appendChild(div3);

        listGroupItem.appendChild(div);
        document.getElementById('testsList').append(listGroupItem);
    });
}

function setActiveExamsHtml(json) {
    const jsonData = json;
    if (Object.keys(jsonData).length !== 0) {
        const h2 = document.createElement('h2');
        h2.textContent = 'Exámenes activos';
        document.getElementById('testsList').append(h2);
    }
    jsonData.forEach((item) => {
        const listGroupItem = document.createElement('a');
        listGroupItem.classList.add('list-group-item');
        listGroupItem.classList.add('list-group-item-action');
        listGroupItem.classList.add('align-items-center');
        listGroupItem.id = item.id;

        const p = document.createElement('p');
        p.classList.add('fw-bold');
        p.textContent = item.testName;
        listGroupItem.appendChild(p);

        const div = document.createElement('div');
        div.classList.add('justify-content-between');

        const group = document.createElement('div');
        group.classList.add('d-flex', 'pr-2');
        group.textContent = `Grupo: `;

        const p1 = document.createElement('p');
        p1.classList.add('fw-bold');
        p1.textContent = `${item.groupLocation} - ${item.groupNumber} ${item.groupName}`;
        group.appendChild(p1);

        const div2 = document.createElement('div');
        div2.classList.add('pr-2');

        const small = document.createElement('small');
        small.classList.add('text-muted');
        small.style.fontSize = '10px';
        small.textContent = 'Abierto: ' + item.dateApplied;

        const div3 = document.createElement('div');
        div3.className = 'pr-2 text-end';

        const button = document.createElement('button');
        button.className = 'btn btn-warning mt-2';
        button.textContent = 'Cerrar';
        button.addEventListener('click', () => showActivateExamModal(item.egId, `${item.testName} (${item.groupLocation} - ${item.groupNumber} ${item.groupName})`, true))
        div3.appendChild(button);

        div2.appendChild(small);
        div.appendChild(group);
        div.appendChild(div2);
        div.appendChild(div3);

        listGroupItem.appendChild(div);
        document.getElementById('testsList').append(listGroupItem);
    });
}

function setFinishedExamsHtml(json) {
    const jsonData = json;
    const testsList = document.getElementById('testsList');
    const pendingRevisionList = document.getElementById('pendingRevisionList');
    pendingRevisionList.innerHTML = '';
    const h4 = document.createElement('h4');
    h4.classList.add('mt-3');
    h4.textContent = 'Exámenes Terminados';
    document.getElementById('testsList').append(h4);
    jsonData.forEach((item) => {
        const listGroupItem = document.createElement('a');
        listGroupItem.classList.add('list-group-item');
        listGroupItem.classList.add('list-group-item-action');
        listGroupItem.classList.add('align-items-center');
        listGroupItem.id = item.id;

        const p = document.createElement('p');
        p.classList.add('fw-bold');
        p.textContent = item.testName;
        listGroupItem.appendChild(p);

        const div = document.createElement('div');
        div.classList.add('justify-content-between');

        const student = document.createElement('div');
        student.classList.add('d-flex', 'pr-2');
        student.textContent = 'Alumno: ';

        const p1 = document.createElement('p');
        p1.classList.add('fw-bold');
        p1.textContent = item.userName;
        student.appendChild(p1);

        const result = document.createElement('div');
        result.classList.add('d-flex', 'pr-2');
        result.textContent = 'Calificación: ';

        const p2 = document.createElement('p');
        p2.classList.add('fw-bold');
        p2.textContent = item.result;
        result.appendChild(p2);

        const div2 = document.createElement('div');
        div2.classList.add('pr-2');

        const small = document.createElement('small');
        small.classList.add('text-muted');
        small.style.fontSize = '10px';
        small.textContent = 'Terminado: ' + item.dateApplied;
        div2.appendChild(small);

        div.appendChild(student);
        div.appendChild(result);
        div.appendChild(div2);

        listGroupItem.appendChild(div);

        if (item.result == 0) {
            const buttonDiv = document.createElement('div');
            buttonDiv.className = 'd-flex justify-content-end p-3';
            const reviewButton = document.createElement('button');
            reviewButton.className = 'btn btn-primary';
            reviewButton.textContent = 'Revisar';
            reviewButton.addEventListener('click', () => finishExam());
            buttonDiv.appendChild(reviewButton);
            listGroupItem.appendChild(buttonDiv);
            pendingRevisionList.appendChild(listGroupItem);
        } else {
            document.getElementById('testsList').appendChild(listGroupItem);
        }
    });
}

function setGroupSelects(json) {
    const createTestDiv = document.getElementById('createTest');
    createTestDiv.innerHTML = '';
    const select = document.createElement('select');
    select.className = 'form-select';
    select.setAttribute('id', 'groupSelect');
    const placeholderOption = document.createElement('option');
    placeholderOption.textContent = 'Elige un grupo';
    placeholderOption.setAttribute('selected', true);
    placeholderOption.setAttribute('disabled', true);
    select.appendChild(placeholderOption);
    json.forEach(item => {
        const option = document.createElement('option');
        option.value = item.groupId;
        option.textContent = `${item.groupNumber} - ${item.groupName} (${item.groupLocation})`;
        select.appendChild(option);
    });
    select.addEventListener('change', function () {
        const selectedGroupId = select.value;
        getAvailableTests(selectedGroupId);
    });

    createTestDiv.appendChild(select);
}

function getAvailableTests(groupId) {
    $.ajax({
        method: "POST",
        dataType: 'JSON',
        url: "../php/testsController.php?data=availableTests",
        data: {
            'groupId': groupId,
            'userId': $('#userId').val()
        },
        success: function (tests) {
            const existingTestsDiv = document.getElementById('testsSelectContainer');
            if (existingTestsDiv) {
                existingTestsDiv.remove();
            }
            const createTestDiv = document.getElementById('createTest');
            const testsDiv = document.createElement('div');
            testsDiv.setAttribute('id', 'testsSelectContainer');
            testsDiv.className = 'mt-2';
            const select = document.createElement('select');
            select.className = 'form-select';
            select.setAttribute('id', 'testSelect');
            const placeholderOption = document.createElement('option');
            placeholderOption.textContent = 'Elige un examen';
            placeholderOption.setAttribute('selected', true);
            placeholderOption.setAttribute('disabled', true);
            select.appendChild(placeholderOption);
            tests.forEach(test => {
                const option = document.createElement('option');
                option.value = test.testId;
                option.textContent = test.comments != 'Sin comentarios' ?
                    `${test.testName} - ${test.comments}` :
                    `${test.testName}`;
                select.appendChild(option);
            });
            select.addEventListener('change', function () {
                const selectedTestId = select.value;
                const selectedTest = tests.find(test => test.testId === selectedTestId);
                const existingButton = document.getElementById('openTestButton');
                if (existingButton) {
                    existingButton.remove();
                }
                const button = document.createElement('button');
                button.className = 'btn btn-primary mt-2';
                button.setAttribute('id', 'openTestButton');
                button.textContent = 'Abrir Examen';
                button.setAttribute('onclick', `setTestByGroup(${selectedTestId}, ${groupId})`);
                testsDiv.appendChild(button);
            });
            testsDiv.appendChild(select);
            createTestDiv.appendChild(testsDiv);
            var event = new MouseEvent('mousedown', {
                'view': window,
                'bubbles': true,
                'cancelable': true
            });
        }
    });
}

function setTestByGroup(testId, groupId) {
    $.ajax({
        method: "POST",
        dataType: 'JSON',
        url: "../php/testsController.php?data=setExamByGroup",
        data: {
            'groupId': groupId,
            'testId': testId,
            'userId': $('#userId').val()
        },
        success: function () {
            showMessageModal('Examen Abierto', 'El examen ha sido creado satisfactoriamente', retrieveExams(setExamsHtml), true);
            retrieveGroups(setGroupSelects);
        },
        error: function (error) {
            showMessageModal('Error al abrir examen', error.error);
        }
    });
}

function showActivateExamModal(examId, examDescription, setClose = false) {
    const confirmButton = document.getElementById('confirmExam');
    const modal = new bootstrap.Modal(document.getElementById('activateExamModal'));
    document.querySelector('#activateExamModal .modal-body').innerHTML = setClose ?
        '¿Estás seguro de que quieres cerrar el examen?<br>' + examDescription + '<br><p class="text-danger">Esta acción no se puede deshacer<p>' :
        '¿Estás seguro de que quieres activar el examen?<br>' + examDescription;

    confirmButton.onclick = () => {
        activateExam(examId, setClose);
        modal.hide();
    };

    modal.show();
}

function activateExam(examId, setClose = false) {
    const status = setClose ? 'closeExam' : 'activateExam';
    const modalTitle = setClose ? 'Examen Cerrado' : 'Examen Activado';
    const modalMessage = setClose ?
        'El examen ha sido cerrado. Ya no puede ser accedido' :
        'El examen se ha activado. Ya puede ser accedido por los estudiantes';
    $.ajax({
        method: "POST",
        dataType: 'JSON',
        url: "../php/testsController.php?data=" + status,
        data: {
            'examId': examId,
            'userId': $('#userId').val()
        },
        success: function () {
            showMessageModal(modalTitle, modalMessage, retrieveExams(setExamsHtml), true);
            retrieveGroups(setGroupSelects);
        },
        error: function (error) {
            showMessageModal('Error al activar examen', error.error);
        }
    });
}