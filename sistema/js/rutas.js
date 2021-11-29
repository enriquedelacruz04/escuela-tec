"use strict";

//===========================================================
// Rutas
//===========================================================

let routes = {
    currentRoute: window.location.pathname,
    indexRoute: "/escuela/sistema/",
    // indexRoute: "/",
    homeRoute: "/pages/home.html",
};

console.log(window.location.pathname);

//===========================================================
// Funciones
//===========================================================

function home() {
    document.querySelector(".btn-sesion").addEventListener("click", function (e) {
        console.log("sesion");
        // e.preventDefault();
        window.location.href = "pages/home.html";
    });
}

function closeSesion() {
    window.location.href = routes.indexRoute;
}

if (routes.currentRoute == routes.indexRoute) {
    home();
}
