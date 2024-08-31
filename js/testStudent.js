const url = new URL(window.location.href);
const examId = url.searchParams.get("examId");
const userId = url.searchParams.get("userId");
window.onload = function () {
    getQuestionsByExam();
};

function getQuestionsByExam() {
    $.ajax({
        method: "GET",
        url: "../php/testsController.php?data=getExamQuestions&examId=" + examId + "&userId=" + userId,
        success: function (response) {
            populateExamPage(response);
        }
    });
}

function populateExamPage(json) {
    document.getElementById('examNameTitle').textContent = json.name;
    document.getElementById('examComments').textContent = json.comments;
    const questionsDiv = document.querySelector('.questions');
    const listGroup = document.createElement('ul');
    listGroup.className = 'list-group list-group-flush';
    json.questions.forEach(question => {
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item fw-bold my-2';
        const label = document.createElement('label');
        label.textContent = question.question;
        label.setAttribute('for', `answer-${question.id}`);
        listItem.appendChild(label);
        const textarea = document.createElement('textarea');
        textarea.className = 'form-control mt-2';
        textarea.id = `answer-${question.id}`;
        textarea.setAttribute('rows', '3');
        listItem.appendChild(textarea);
        listGroup.appendChild(listItem);
    });
    const buttonDiv = document.createElement('div');
    buttonDiv.className = 'd-flex justify-content-end p-3';
    const button = document.createElement('button');
    button.className = 'btn btn-primary';
    button.textContent = 'Enviar examen';
    button.addEventListener('click', () => finishExam());
    const cancel = document.createElement('button');
    cancel.className = 'btn btn-light me-3';
    cancel.textContent = 'Regresar';
    cancel.addEventListener('click', () => window.location.href = '../index.php');
    buttonDiv.appendChild(cancel);
    buttonDiv.appendChild(button);
    questionsDiv.appendChild(listGroup);
    questionsDiv.appendChild(buttonDiv);
}

function finishExam() {
    var textareas = document.querySelectorAll('.list-group-flush .list-group-item textarea');
    var answers = [];
    textareas.forEach(textarea => {
        console.log(textarea.id);
        console.log(textarea.value);
        answers.push({
            'id': textarea.id.replace('answer-', ''),
            'answer': textarea.value
        });
    });
    $.ajax({
        method: "POST",
        url: "../php/testsController.php?data=finishExam&examId=" + examId + "&userId=" + userId,
        data: { answers },
        success: function (response) {
            document.getElementById('changesMadeModalTitle').textContent = 'Examen Registrado Exitosamente';
            document.getElementById('changesMadeModalBody').textContent =
                'Tu examen ha sido terminado exitosamente. Este será revisado por tu máster coach y te hará saber cuando esté disponible la calificación';
            $('#changesMadeModal').modal('show');
            var seconds = 5;
            function redirect() {
                if (seconds <= 0) {
                    $('#changesMadeModal').modal('hide');
                } else {
                    seconds--;
                    document.getElementById('changesMadeModalFooter').textContent =
                        'Serás redirigido automáticamente en ' + seconds + ' segundos';
                }
            } setInterval(redirect, 1000);
            $('#changesMadeModal').on('hide.bs.modal', function () { window.location.href = '../index.php?' });
        }
    });
}