"use strict";
//===========================================================
// APIS
//===========================================================

function loadApisCursos() {
    apiView = server + "cursos/getAllCursos.php";
    apiEdit = server + "cursos/editCursos.php";
    apiGetOne = server + "cursos/getOneCursos.php";
    apiDelete = server + "includes/eliminar.php";

    apiEditHtml = "../pages/editCursos.html";
}

//===========================================================
// CRUD
//===========================================================

function viewCursos() {
    let htmlTableHead = `
        <div class='p-5 mb-4 bg-light rounded-3'>
            <div class='container-fluid py-2'>
                <h1 class='display-5 fw-bold'>Cursos</h1>
                <div class='table-responsive mt-5'>
                    <table class='table '>
                        <thead>
                            <tr>
                                <th scope='col'>Clave</th>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Duración</th>
                                <th scope='col' width=170></th>
                            </tr>
                        </thead>
                        <tbody class="listCursos">
                        
                        
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

    //========================= Recibimos los datos del API
    fetch(apiView)
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            //========================= Dibujamos el head de la tabla
            main.innerHTML = htmlTableHead;

            //========================= Comprobar si hubo datos en la DB
            if (datos[0].ok) {
                //========================= Leemos todas las filas de la DB y la asignamos a una variable
                datos.forEach((dato) => {
                    htmlTableBody += loadTableCursos(dato);
                });

                //========================= Dibujamos el contenido de todas las filas en la tabla
                document.querySelector(".listCursos").innerHTML = htmlTableBody;

                //========================= Dibujamos los botones de acciones
                buttonDeleteCursos();
                buttonEditCursos();
            } else {
                //========================= Dibujamos el  mensaje si la DB esta vacia
                document.querySelector(".listCursos").innerHTML = "Sin datos";
            }

            //========================= Dibujamos el boton crear
            buttonNewCursos();
        })
        .catch(function (error) {
            console.log(error);
        });
}

function deleteCursos(id) {
    //========================= Preparamos los datos a enviar
    let datos = new FormData();
    datos.append("id", id);
    datos.append("idTabla", "clave");
    datos.append("tabla", "cursos");

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
                viewCursos();
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

function editCursos(id) {
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
            let form = document.querySelector("#form-cursos");

            //========================= Dibujamos todos los select
            // let p1 = loadSelect(apiCursos, "cursos");

            //========================= Dibujamos los datos de la DB en los inputs del form si esta editando
            if (editar) {
                // Promise.all([p1]).then((responses) => {
                loadForm(form, id, apiGetOne);
                // });
            }

            //========================= Input bandera editar o crear
            document.querySelector("#edit").value = id;

            //========================= Accion al guardar form
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                sendForm(form, apiEdit, viewCursos);
            });
        })
        .catch(function (error) {
            console.log(error);
        });
}

//===========================================================
// Funciones
//===========================================================

function loadTableCursos(dato) {
    let id = dato.id;
    let nombre = dato.nombre;
    let duracion = dato.duracion;

    let html = `
    <tr>
        <th scope="row">${id}</th>
        <td>${nombre}</td>
        <td>${duracion}</td>
        <td class="table-acciones">
            <button data-id="${id}" type="button" class="btn btn-primary">Editar</button>
            <button data-id="${id}"type="button" class="btn btn-danger">Eliminar</button>
        </td>
    </tr>
    `;

    return html;
}

//===========================================================
// Botones
//===========================================================

function buttonDeleteCursos() {
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
                    deleteCursos(id);
                }
            });
        });
    });
}

function buttonNewCursos() {
    document.querySelector(".btn-new").addEventListener("click", function () {
        let id = this.dataset.id;
        editCursos(id);
    });
}

function buttonEditCursos() {
    document.querySelectorAll(".btn-primary").forEach(function (item) {
        item.addEventListener("click", function () {
            let id = this.dataset.id;
            editCursos(id);
        });
    });
}
