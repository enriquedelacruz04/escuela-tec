//////////////////////////////////////// requires
//////////////////////////////////////// requires

const { series, src, dest, watch, parallel } = require("gulp");
const sass = require("gulp-sass")(require("sass")); // sass
// const concat = require("gulp-concat"); // concatenar archivos para compilar
const sourcemaps = require("gulp-sourcemaps"); // referencia a archivos originales
const rename = require("gulp-rename"); // renombrar archivos
const browserSync = require("browser-sync").create(); // browserSync
// const connect = require("gulp-connect-php"); //browserSync PHP

//----------------------Utilidades Imagenes
// const imagemin = require("gulp-imagemin"); // imagenes mas ligeras
// const webp = require("gulp-webp"); // version webp de imagenes

//----------------------Utilidades CSS
// const postcss = require("gulp-postcss"); //procesamiento a css (autoprefixer,cssnano)
// const autoprefixer = require("autoprefixer"); // autoprefixer al css
// const cssnano = require("cssnano"); // version optimizada del css

//----------------------Utilidades JS
// const terser = require("gulp-terser-js"); // version optimizada del js

//////////////////////////////////////// paths
//////////////////////////////////////// paths

// Directorios de origen
const paths = {
    imagenes: "src/img/**/*",
    imagenesPNG_JPG: "src/img/**/*.{png,jpg}",
    scss: "src/scss/**/*.scss",
    js: "src/js/**/*.js",
    php: "./**/*.php",
    html: "./**/*.html",
};

// Directorios de destino
const pathsBuild = {
    imagenes: "./build/img",
    css: "./build/css",
    js: "./build/js",
};

// Archivo de compilacion de JS
const buildJS = "bundle.js";

// Archivo de directorio de servidor
const localhost = "http://localhost/**/"; // Se remplaza con el directorio del archivo en el localhost

//////////////////////////////////////// Funciones
//////////////////////////////////////// Funciones

function produccionCSS() {
    return src(paths.scss)
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(rename({ suffix: ".min" }))
        .pipe(dest(pathsBuild.css));
}

function produccionJS() {
    return src(paths.js)
        .pipe(concat(buildJS))
        .pipe(terser())
        .pipe(rename({ suffix: ".min" }))
        .pipe(dest(pathsBuild.js));
}

function css() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(rename({ suffix: ".min" }))
        .pipe(sourcemaps.write("."))
        .pipe(dest(pathsBuild.css))
        .pipe(browserSync.stream());
}

function javascript() {
    return src(paths.js)
        .pipe(sourcemaps.init())
        .pipe(concat(buildJS))
        .pipe(rename({ suffix: ".min" }))
        .pipe(sourcemaps.write("."))
        .pipe(dest(pathsBuild.js))
        .pipe(browserSync.stream());
}

function minificarImagen() {
    return src(paths.imagenesPNG_JPG)
        .pipe(imagemin({ optimizationLevel: 3 }))
        .pipe(dest(pathsBuild.imagenes));
}

function versionWebp() {
    const opciones = {
        quality: 80,
    };
    return src(paths.imagenesPNG_JPG).pipe(webp(opciones)).pipe(dest(pathsBuild.imagenes));
}

function watchArchivos() {
    watch(paths.html, recargar);
    watch(paths.scss, css);
    watch(paths.js, javascript);
}

function watchArchivosPHP() {
    watch(paths.php, recargar);
    watch(paths.scss, css);
    watch(paths.js, javascript);
}

function syncDinamic() {
    connect.server({}, function () {
        browserSync.init({
            proxy: localhost,
        });
    });
}

function syncStatic() {
    browserSync.init({
        server: {
            baseDir: "./",
        },
    });
}

function recargar(cb) {
    browserSync.reload();
    cb();
}

exports.css = css;
exports.javascript = javascript;
exports.minificarImagen = minificarImagen;
exports.versionWebp = versionWebp;

exports.produccion = series(produccionJS, produccionCSS);
exports.estatico = parallel(minificarImagen, css, javascript, syncStatic, watchArchivos);
exports.dinamico = parallel(minificarImagen, css, javascript, syncDinamic, watchArchivosPHP);
exports.default = series(css, watchArchivos);
