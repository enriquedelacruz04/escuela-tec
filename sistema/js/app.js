"use strict";

//===========================================================
// Ruta del servidor y API
//===========================================================

const server = "http://localhost/escuela/sistema/php/";
// const server = "https://escuelaemsad.000webhostapp.com/php/";

let apiView;
let apiEdit;
let apiGetOne;
let apiDelete;
let apiEditHtml;

let apiCursos;
let apiTrabajos;
let apiMaterias;
let apiGetOneMaterias;
let apiAlumnos;

//===========================================================
// Contenedor
//===========================================================

const main = document.querySelector("main .container");

//===========================================================
// Cargar menu
//===========================================================

document.querySelector(".nav-item--1").addEventListener("click", function () {
    loadApisAlumnos();
    viewAlumnos();
});

document.querySelector(".nav-item--2").addEventListener("click", function () {
    loadApisProfesores();
    viewProfesores();
});

document.querySelector(".nav-item--3").addEventListener("click", function () {
    loadApisCursos();
    viewCursos();
});

document.querySelector(".nav-item--4").addEventListener("click", function () {
    loadApisMaterias();
    viewMaterias();
});

document.querySelector(".nav-item--5").addEventListener("click", function () {
    loadApisTrabajos();
    viewTrabajos();
});

//===========================================================
// Funciones
//===========================================================

function obtenerDatos(form) {
    let formulario = form;
    let datos = new FormData();

    for (var elemento of formulario) {
        if (elemento.tagName == "INPUT" || elemento.tagName == "TEXTAREA" || elemento.tagName == "SELECT") {
            datos.append(elemento.name, elemento.value);
        }
    }
    return datos;
}

function loadSelect(api, id) {
    return new Promise(function (resolve) {
        fetch(api)
            .then(function (respuesta) {
                return respuesta.json();
            })
            .then(function (datos) {
                let select = document.querySelector("#" + id);
                loadOptions(datos, select);
                resolve("ok");
            })
            .catch(function (error) {
                console.log(error);
            });
    });
}

function loadOptions(datos, select) {
    datos.forEach((element) => {
        let option = document.createElement("option");
        option.value = element.id;
        option.text = element.nombre;
        select.appendChild(option);
    });
}

function loadForm(form, id, api) {
    //========================= Preparamos los datos a enviar
    let datos = new FormData();
    datos.append("id", id);

    //========================= Enviamos los datos al API
    fetch(api, {
        method: "POST",
        body: datos,
    })
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            // console.log(datos);

            //========================= Obtenemos array de los datos
            let arrayData = Object.values(datos);

            //========================= Iteramos el form
            for (let index = 0; index < form.length; index++) {
                let elementForm = form[index];
                let valueData = arrayData[index + 1];

                //========================= Asignamos el dato en el value de cada input
                if (elementForm.tagName == "INPUT" && elementForm.type !== "hidden") {
                    elementForm.value = valueData;
                }

                //========================= Asignamos el option seleccionado
                if (elementForm.tagName == "SELECT") {
                    for (let index = 0; index < elementForm.length; index++) {
                        var elementOption = elementForm[index];

                        if (elementOption.value == valueData) {
                            elementOption.selected = true;
                        }
                    }
                }
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

function sendForm(form, api, view) {
    //========================= Preparamos los datos a enviar
    let datos = obtenerDatos(form);
    console.log(...datos);

    //========================= Enviamos los datos al API
    fetch(api, {
        method: "POST",
        body: datos,
    })
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            view();
            if (datos.ok) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Guardado correctamente",
                    showConfirmButton: false,
                    timer: 1000,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Hubo un error al guardar",
                });
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

