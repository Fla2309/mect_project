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

function setFinishedExamsHtml(){

}