function selectFile(label) {
    document.getElementById(label.getAttribute('for'));
}

function uploadFile(input, type) {
    if (input.files.length > 0) {
        var formData = new FormData();
        var userId = document.getElementById('userId').getAttribute('value');
        var activityId = input.getAttribute('id').replace('tareas-file-input-', '').replace('trabajos-file-input-', '');
        formData.append('userId', userId);
        formData.append('type', type);
        formData.append('activityId', activityId);
        formData.append('file', input.files[0]);

        fetch('../php/fileHandler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error del servidor:', data.error);
                } else {
                    alert('Archivo registrado correctamente. Será revisado por una persona autorizada, una vez que eso suceda, se verá reflejado en la actividad');
                    reloadModule();
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    } else {
        alert("Por favor, selecciona un archivo antes de intentar subirlo.");
    }
}