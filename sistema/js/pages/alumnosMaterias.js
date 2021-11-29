"use strict";
//===========================================================
// APIS
//===========================================================

function loadApisAlumnosMaterias() {
    apiView = server + "alumnosMaterias/getAllAlumnosMaterias.php";
    apiEdit = server + "alumnosMaterias/editAlumnosMaterias.php";
    apiDelete = server + "includes/eliminar.php";

    apiEditHtml = "../pages/editAlumnosMaterias.html";
    apiMaterias = server + "materias/getAllMaterias.php";
}

let idAlumnosMaterias;

//===========================================================
// CRUD
//===========================================================

function viewAlumnosMaterias(alumnos) {
    console.log(alumnos);
    idAlumnosMaterias = alumnos;
    let htmlTableHead = `
        <div class='p-5 mb-4 bg-light rounded-3'>
            <div class='container-fluid py-2'>
                <h1 class='display-5 fw-bold'>Alumnos - Materias</h1>
                <div class='table-responsive mt-5'>
                    <table class='table '>
                        <thead>
                            <tr>
                                <th scope='col'>ID</th>
                                <th scope='col'>Matricula Alumno</th>
                                <th scope='col'>Materia</th>
                                <th scope='col' width=170></th>
                            </tr>
                        </thead>
                        <tbody class="listAlumnosMaterias">
                        
                        
                        </tbody>
                    </table>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button data-id="0" class="btn btn-dark btn-new" type="button">Agregar nuevo</button>
                </div>
            </div>
        </div>
        `;
    let htmlTableBody = "";

    //========================= Preparamos los datos a enviar
    let datos = new FormData();
    datos.append("alumnos", alumnos);

    //========================= Enviamos los datos al API
    fetch(apiView, {
        method: "POST",
        body: datos,
    })
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            console.log(datos);
            //========================= Dibujamos el head de la tabla
            main.innerHTML = htmlTableHead;

            //========================= Comprobar si hubo datos en la DB
            if (datos[0].ok) {
                //========================= Leemos todas las filas de la DB y la asignamos a una variable
                datos.forEach((dato) => {
                    htmlTableBody += loadTableAlumnosMaterias(dato);
                });

                //========================= Dibujamos el contenido de todas las filas en la tabla
                document.querySelector(".listAlumnosMaterias").innerHTML = htmlTableBody;

                //========================= Dibujamos los botones de acciones
                buttonDeleteAlumnosMaterias();
                // buttonEditAlumnosMaterias();
            } else {
                //========================= Dibujamos el  mensaje si la DB esta vacia
                document.querySelector(".listAlumnosMaterias").innerHTML = "Sin datos";
            }

            //========================= Dibujamos el boton crear
            buttonNewAlumnosMaterias(alumnos);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function deleteAlumnosMaterias(id) {
    //========================= Preparamos los datos a enviar
    let datos = new FormData();
    datos.append("id", id);
    datos.append("idTabla", "idalumnos_materias");
    datos.append("tabla", "alumnos_materias");

    //========================= Enviamos los datos al API
    fetch(apiDelete, {
        method: "POST",
        body: datos,
    })
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            if (datos.ok) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Eliminado correctamente",
                    showConfirmButton: false,
                    timer: 1000,
                });
                viewAlumnosMaterias(idAlumnosMaterias);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Este item esta siendo usado en el sistema",
                });
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

function editAlumnosMaterias(id, alumnos) {
    //========================= Si esta editando o creando
    let editar = id !== "0" ? true : false;

    //========================= Recibimos los datos del API
    fetch(apiEditHtml)
        .then(function (respuesta) {
            return respuesta.text();
        })
        .then(function (datos) {
            //========================= Dibujamos el html del formulario
            main.innerHTML = datos;
            let form = document.querySelector("#form-alumnosMaterias");

            //========================= Dibujamos todos los select
            let p1 = loadSelect(apiMaterias, "materias");

            //========================= Dibujamos los datos de la DB en los inputs del form si esta editando
            // if (editar) {
            //     // Promise.all([p1]).then((responses) => {
            //     loadForm(form, id, apiGetOne);
            //     // });
            // }

            //========================= Input bandera editar o crear
            document.querySelector("#edit").value = id;
            document.querySelector("#alumnos").value = alumnos;
            // document.querySelector("#profesores").value = profesores;

            //========================= Accion al guardar form
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                sendForm(form, apiEdit, function () {
                    viewAlumnosMaterias(alumnos);
                });
            });
        })
        .catch(function (error) {
            console.log(error);
        });
}

//===========================================================
// Funciones
//===========================================================

function loadTableAlumnosMaterias(dato) {
    let id = dato.id;
    let alumnos = dato.alumnos;
    let materias = dato.materias;

    let html = `
    <tr>
        <th scope="row">${id}</th>
        <td>${alumnos}</td>
        <td>${materias}</td>
        <td class="table-acciones">
            <button data-id="${id}" type="button" class="btn btn-danger">Eliminar</button>
        </td>
    </tr>
    `;

    return html;
}

//===========================================================
// Botones
//===========================================================

function buttonDeleteAlumnosMaterias() {
    document.querySelectorAll(".btn-danger").forEach(function (item) {
        item.addEventListener("click", function () {
            let id = this.dataset.id;
            Swal.fire({
                title: "Desea eliminarlo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteAlumnosMaterias(id);
                }
            });
        });
    });
}

function buttonNewAlumnosMaterias(profesores) {
    document.querySelector(".btn-new").addEventListener("click", function () {
        let id = this.dataset.id;
        editAlumnosMaterias(id, profesores);
    });
}
