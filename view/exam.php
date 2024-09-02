<?php

include_once('../php/connection.php');
session_start();

$conn = (new DB)->connect();
$query = $conn->query("SELECT * FROM examenes_usuarios WHERE id_usuario={$_GET['userId']} AND id_examen={$_GET['examId']}") or die($conn->error);
if ($query->num_rows > 0) {
    header("Location: unavailable.php");
}

?>

<html>

<head>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap-5.2.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.scss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="../bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/student.js"></script>
    <script src="../js/testStudent.js" type="text/javascript"></script>
    <title>Examen</title>
</head>

<body style="background-color: #e2e2e2">
    <?php include_once('navbar.php') ?>
    <table hidden="true">
        <tr>
            <td><input type="text" id="user" placeholder="<?php echo $_SESSION['user'] ?>"
                    value="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            <td><input type="text" id="userId" placeholder="<?php echo $_SESSION['userId'] ?>"
                    value="<?php echo $_SESSION['userId'] ?>" class="user_properties"></td>
            <td><input type="text" id="userFullName" placeholder="<?php echo $_SESSION['fullname'] ?>"
                    value="<?php echo $_SESSION['fullname'] ?>" class="user_properties"></td>
        </tr>
    </table>

    <div class="m-5" style="background-color: white">
        <div class="text-center px-5">
            <h2 class="py-3" id="examNameTitle"></h2>
            <small class="text-muted" id="examComments"></small>
        </div>
        <div class="mx-3 pt-3 px-3 accordion" id="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="instructions">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#instructionsAccordion" aria-expanded="true"
                        aria-controls="instructionsAccordion">
                        Instrucciones (Click para minimizar)
                    </button>
                </h2>
                <div id="instructionsAccordion" class="accordion-collapse collapse show" aria-labelledby="instructions"
                    data-bs-parent="#accordion">
                    <div class="accordion-body">
                        <h5>Antes de empezar con tu examen, asegúrate de leer las siguientes instrucciones:</h5>
                        <ul>
                            <li>Este examen debe ser realizado en el tiempo indicado por tu observador/coach.</li>
                            <li>Si sales de esta página, perderás el progreso de tu examen.</li>
                            <li>Una vez hayas contestado las preguntas del examen, <mark>asegúrate de enviar el
                                    examen</mark>, de lo
                                contrario, tu progreso se perderá cuando salgas de este.</li>
                            <li><mark>No envíes tu examen hasta haber terminado</mark>.</li>
                            <li>Una vez que tu observador/coach cierre el examen, ya no tendrás manera de acceder a
                                él. Así que asegúrate de acabarlo en tiempo.</li>
                        </ul>
                        <strong class="text-primary">¡Éxito!</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 questions">
        </div>

        <div class="modal fade" id="changesMadeModal" tabindex="-1" aria-labelledby="changesMadeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changesMadeModalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="changesMadeModalBody">
                    </div>
                    <div class="modal-footer" id="changesMadeModalFooter">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>