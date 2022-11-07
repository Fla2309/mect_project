<?php

include_once('connection.php');

class Module extends DB
{

    public function retrieveModules($group)
    {
        $query = $this->connect()->query('SELECT * FROM modulos WHERE id_modulo IN (SELECT id_modulo FROM modulos_grupos WHERE id_grupo = '.$group.' AND disponible > 0)');
        $cardHtml = "";
        $count = 1;

        while ($row = mysqli_fetch_array($query)) {
            if ($count == 1) {
                $cardHtml = $cardHtml .
                    "<div class=\"row\" style=\"align-content: center;\">
                            <div id=\"mod_".$row['id_modulo']."\" class=\"col-sm px-5 py-5 mx-3 mt-4\" style=\"background-color: white;\">
                                <div class=\"p-1\">
                                    <h1>" . $row['nombre_modulo'] . "</h1>
                                    <h4>" . $row['descripcion'] . "</h4>
                                    <p>0% completado</p>
                                    <button id=\"but_mod_".$row['id_modulo']."\" type=\"button\" onclick=\"showModuleHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">
                                    Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>
                                </div>
                            </div>";
            }
            else if ($count == 3) {
                $cardHtml = $cardHtml .
                    "<div id=\"mod_".$row['id_modulo']."\" class=\"col-sm px-5 py-5 mx-3 mt-4\" style=\"background-color: white;\">
                            <div class=\"p-1\">
                                <h1>" . $row['nombre_modulo'] . "</h1>
                                <h4>" . $row['descripcion'] . "</h4>
                                <p>0% completado</p>
                                <button id=\"but_mod_".$row['id_modulo']."\" type=\"button\" onclick=\"showModuleHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">
                                Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>
                            </div>
                        </div>
                    </div>";
                $count = 0;
            }
            else {
                $cardHtml = $cardHtml .
                    "<div id=\"mod_".$row['id_modulo']."\" class=\"col-sm px-5 py-5 mx-3 mt-4\" style=\"background-color: white;\">
                            <div class=\"p-1\">
                                <h1>" . $row['nombre_modulo'] . "</h1>
                                <h4>" . $row['descripcion'] . "</h4>
                                <p>0% completado</p>
                                <button id=\"but_mod_".$row['id_modulo']."\" type=\"button\" onclick=\"showModuleHtml(this);\" class=\"btn btn-primary\" style=\"width: 120px; text-align: left;\">
                                Entrar<img src=\"../img/right-arrow.png\" style=\"float: right;\" width=\"20\"></button>
                            </div>
                        </div>";
            }

            $count++;
        }
        if ($count != 0) {
            $cardHtml = $cardHtml . "</div>";
        }

        return $cardHtml;
    }
}

?>