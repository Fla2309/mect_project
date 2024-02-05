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
    <script src="../js/file.js"></script>
    <title>Portal del alumno</title>
</head>

<body>
    <?php include_once('view/navbar.php') ?>
    <table hidden="true">
        <tr>
            <td><input type="text" id="user" placeholder="<?php echo $_SESSION['user'] ?>"
                    value="<?php echo $_SESSION['user'] ?>" class="user_properties"></td>
            <td><input type="text" id="userId" placeholder="<?php echo $_SESSION['userId'] ?>"
                    value="<?php echo $_SESSION['userId'] ?>" class="user_properties"></td>
            <td><input type="text" id="userFullName" placeholder="<?php echo $_SESSION['userId'] ?>"
                    value="<?php echo $_SESSION['fullname'] ?>" class="user_properties"></td>
        </tr>
    </table>

    <div class="row g-0">
        <div style="width: 55px;" class="col-auto">
            <ul class="nav nav-pills mb-1 flex-column">
                <li id="inicioNavItem" class="nav-item active">
                    <a class="nav-link active" title="Inicio" data-bs-target="#inicio" data-bs-toggle="tab"><img
                            src="../img/home.png" class="left_bar_icon"></a>
                </li>
                <li id="modulosNavItem" class="nav-item">
                    <a class="nav-link" title="Módulos" data-bs-target="#modulos" data-bs-toggle="tab"><img
                            src="../img/book.png" class="left_bar_icon" onclick="generateModulesPage()"></a>
                </li>
                <li id="coachingNavItem" class="nav-item">
                    <a class="nav-link" title="Coaching" onclick="generateCoachingPage()" data-bs-target="#coaching"
                        data-bs-toggle="tab"><img src="../img/coaching.png" class="left_bar_icon"></a>
                </li>
                <li id="presentacionesNavItem" class="nav-item">
                    <a class="nav-link" title="Presentaciones" data-bs-target="#presentaciones"
                        data-bs-toggle="tab"><img src="../img/presentation.png" class="left_bar_icon"
                            onclick="generatePresentationsPage()"></a>
                </li>
                <li id="examenesNavItem" class="nav-item">
                    <a class="nav-link" title="Exámenes" data-bs-target="#examen" data-bs-toggle="tab"><img
                            src="../img/test.png" class="left_bar_icon" onclick="generateTestsPage()"></a>
                </li>
            </ul>
        </div>
        <div class="tab-content col-auto">
            <div class="tab-pane fade show active" style="width: auto;" id="inicio">
                <div class="d-flex mt-2 ms-2">
                    <img src="../<?php echo $_SESSION['foto_perfil'] !== 'none' ? $_SESSION['foto_perfil'] : '../img/user_pic.png' ?>"
                        class="img-fluid profile_pic" alt="Foto de Perfil">
                    <h2 style="padding: 2rem;">Bienvenid@,
                        <?php echo $_SESSION['pref_name'] ?>
                    </h2>
                </div>
                <div class="row">
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Módulos Activos</h4>
                            <small><a class="nav-link col-md-1" onclick="goToTab(this)" href="#modulos">Ir→</a></small>
                        </div>
                        <hr class="divider">
                        <div class="px-3 py-2">
                            <div class="list-group" id="modules-list-tab" role="tablist">
                                <?php
                                include_once('./php/dashboard.php');
                                $dashboard = new Dashboard();
                                echo $dashboard->generateModulesFrame($_SESSION['grupo']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Coaching Recientes</h4>
                            <small><a class="nav-link col-md-1" onclick="goToTab(this)" href="#coaching">Ir→</a></small>
                        </div>
                        <hr class="divider">
                        <div class="px-3 py-2">
                            <div class="list-group" id="coaching-list-tab" role="tablist">
                                <?php
                                echo $dashboard->generateCoachingFrame($_SESSION['userId']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-2" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Feedback</h4>
                        </div>
                        <hr class="divider">
                        <div class="px-3 py-2">
                            <div class="accordion" id="feedback-accordion">
                                <?php
                                echo $dashboard->generateFeedbackFrame($_SESSION['userId']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../js/module.js" type="text/javascript"></script>
            <div class="tab-pane fade" id="modulos">
                
            </div>

            <div class="tab-pane fade" role="tabpanel" id="coaching">
                <div class="mx-3 my-5" style="background-color: white">
                    <h2 class="px-3 py-3">Coachings Registrados</h2>
                    <hr class="divider">
                    <table class="table table-hover">
                        <thead>
                            <th scope="col" class="align-middle">Nombre de la sesión</th>
                            <th scope="col" class="align-middle">Coachee</th>
                            <th scope="col" class="align-middle">Fecha de subida</th>
                            <th scope="col" class="align-middle">Opciones <a href="resources/templates/prueba 2.docx"
                                    download="plantilla coaching.docx"><img src="img/template.png"
                                        class="dashboard_icon m-2" title="Descargar plantilla"></a>
                    <input type="button" class="btn btn-primary ms-2" value="+ Agregar Sesión"
                        onclick="showCoachingModal(true)"></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="presentaciones">
                <div class="mx-3 my-5" style="background-color: white">
                    <h2 class="px-3 py-3">Presentaciones y Feedback</h2>
                    <hr class="divider">
                    <table class="table table-hover" id="presentationsTable">
                        <thead>
                            <th scope="col">Nombre del feedback</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Fecha de subida</th>
                            <th scope="col">Archivo</th>
                        </thead>
                        <tbody id="presentationsTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="examen">
                <div class="row w-100">
                    <div class="col-sm mx-3 my-5" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Exámenes Terminados</h4>
                        </div>
                        <hr class="divider">
                        <div class="px-3 py-2">
                            <div class="list-group" id="finishedTests" role="tablist">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm mx-3 my-5" style="background-color: white">
                        <div class="d-flex align-items-center" style="margin: 0">
                            <h4 class="col-md-11 mt-3 ms-2">Exámenes Activos</h4>
                        </div>
                        <hr class="divider">
                        <div class="px-3 py-2">
                            <div class="list-group" id="activeTests" role="tablist">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modals-->
    <div class="modal fade" id="coachingModal" tabindex="-1" aria-labelledby="coachingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar coaching</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="coachingBody">
                    <div class="input-group mb-2" hidden="true">
                        <span class="input-group-text bg-primary text-white">ID</span>
                        <input type="text" id="coachingId" class="form-control" placeholder="">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Nombre de la sesión</span>
                        <input type="text" id="coachingName" class="form-control" placeholder="Nombre de la sesión...">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Coach</span>
                        <input type="text" id="coachingUserName" class="form-control" placeholder="Nombre..." disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Fecha</span>
                        <input type="text" id="coachingDate" class="form-control" placeholder="Fecha..." disabled>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Lugar</span>
                        <input type="text" id="coachingPlace" class="form-control" placeholder="Lugar...">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Descripción del lugar</span>
                        <input type="text" id="placeDesc" class="form-control" placeholder="Descripción...">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Tiempo de interacción</span>
                        <input type="text" id="timeOfInteraction" class="form-control" placeholder="Tiempo...">
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">Coachee</span>
                        <input type="text" id="coacheeName" class="form-control" placeholder="Nombre...">
                    </div>
                    <div class="mt-5 text-center">
                        <h5>SOBRE LA SESIÓN</h5>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cuál fue el quiebre declarado?</span>
                        <textarea type="password" id="topicDeclared" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cuál fue el quiebre que se trabajó?</span>
                        <textarea type="password" id="topicHandled" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cómo fue el proceso de indagación? ¿Qué
                            valor le agregó a la conversación?</span>
                        <textarea type="password" id="coachingProcess" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cuál fue la interpretación que tuviste del
                            quiebre?</span>
                        <textarea type="password" id="coachingInterpretation" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cómo fue la emoción de la
                            interacción?</span>
                        <textarea type="password" id="interactionEmotions" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Cómo fue la corporalidad del coachee
                            durante la interacción?</span>
                        <textarea type="password" id="bodyLang" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Qué nuevas acciones son posibles para el
                            coachee después de tu intervención?</span>
                        <textarea type="password" id="newActions" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="mt-5 text-center">
                        <h5>REFLEXIONES POSTERIORES AL COACHING (información de la experiencia del coach)</h5>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Qué emociones vivencié?</span>
                        <textarea type="password" id="myEmotions" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Qué áreas de aprendizaje puedo
                            declarar?</span>
                        <textarea type="password" id="areasOfOportunity" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-primary text-white">¿Qué nuevas preguntas surgen a partir de
                            esta experiencia?</span>
                        <textarea type="password" id="newQuestions" class="form-control"
                            placeholder="Escriba una descripción..."></textarea>
                    </div>
                    <p id="errorPassword" class="text-danger" hidden></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveCoaching()">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('view/footer.html') ?>
</body>

</html>