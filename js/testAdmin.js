function loadTestsPage(){
    retrieveTests(setTestsHtml);
    retrieveFinishedExams(setFinishedExamsHtml);
}

function retrieveTests(callback) {
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/testsController.php?type=3&userId=" + $('#userId').val(),
        success: function (json) {
            callback(json);
        }
    });
}

function retrieveFinishedExams(callback) {
    $.ajax({
        method: "GET",
        dataType: 'JSON',
        url: "../php/testsController.php?type=4&userId=" + $('#userId').val(),
        success: function (json) {
            callback(json);
        }
    });
}

function setTestsHtml(json) {
    document.getElementById('testsAccordion').innerHTML = '';
    const jsonData = json;
    jsonData.forEach(jsonRow => {
        const accordion = document.createElement('div');
        accordion.classList.add('accordion');
        accordion.id = `tests${jsonRow['testId']}Accordion`;
        const accordionItem = document.createElement('div');
        accordionItem.classList.add('accordion-item');
        const accordionHeader = document.createElement('h2');
        accordionHeader.classList.add('accordion-header');
        accordionHeader.id = `heading-${jsonRow['testId']}`;
        const accordionHeaderButton = document.createElement('button');
        accordionHeaderButton.classList.add('accordion-button');
        accordionHeaderButton.classList.add('collapsed');
        accordionHeaderButton.setAttribute('type', 'button');
        accordionHeaderButton.setAttribute('data-bs-toggle', 'collapse');
        accordionHeaderButton.setAttribute('data-bs-target', `#collapse-${jsonRow['testId']}`);
        accordionHeaderButton.setAttribute('aria-expanded', 'false');
        accordionHeaderButton.setAttribute('aria-controls', `collapse-${jsonRow['testId']}`);
        accordionHeaderButton.textContent = jsonRow['testName'];
        accordionHeader.appendChild(accordionHeaderButton);
        accordionItem.appendChild(accordionHeader);
        const collapse = document.createElement('div');
        collapse.classList.add('collapse');
        collapse.classList.add('accordion-collapse');
        collapse.setAttribute('aria-labelledby', `heading-${jsonRow['testId']}`);
        collapse.id = `collapse-${jsonRow['testId']}`;
        const accordionBody = document.createElement('div');
        accordionBody.classList.add('accordion-body');
        const questions = jsonRow['questions'];
        const listGroup = document.createElement('div');
        listGroup.classList.add('list-group');
        listGroup.id = `list-tab-${jsonRow['testId']}`;
        listGroup.setAttribute('role', 'tablist');
        questions.forEach(question => {
            const listGroupItem = document.createElement('a');
            listGroupItem.classList.add('list-group-item');
            listGroupItem.classList.add('list-group-item-action');
            listGroupItem.id = `list-home-list-${question['questionId']}`;
            listGroupItem.setAttribute('role', 'button');
            listGroupItem.textContent = question['question'];

            listGroup.appendChild(listGroupItem);
        });
        accordionBody.appendChild(listGroup);
        collapse.appendChild(accordionBody);
        accordionItem.appendChild(collapse);
        accordion.appendChild(accordionItem);
        document.getElementById('testsAccordion').append(accordion);
    });
}

function setFinishedExamsHtml(json){
    document.getElementById('testsList').innerHTML = '';
    const jsonData = json;
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
        document.getElementById('testsList').append(listGroupItem);
      });
}