const File = require("laravel-mix/src/File");
const mix = require('laravel-mix');
const fs = require("fs")
const path = require("path");
const compress_images = require("compress-images");
const md5 = require("md5");

/**
 * Returns a Hash based on the name of the file and the current time.
 * Used for production builds only.
 *
 * @param string
 * @returns {*}
 */
function hash(string) {
    return md5(string + Date.now().toString(36));
}

mix.setPublicPath("dist/public");

/**
 * Extends the webpack config
 */
mix.webpackConfig({
    "watchOptions": {
        "ignored": ['./node_modules/', "./src/vendor", "./dist/vendor"]
    }
})

mix.copyDirectory("src/app", "dist/app");
mix.copyDirectory("src/bin", "dist/bin");
mix.copyDirectory("src/bootstrap", "dist/bootstrap");
mix.copyDirectory("src/public", "dist/public");
mix.copyDirectory("src/routes", "dist/routes");
mix.copyDirectory("src/translations", "dist/translations");
mix.copyDirectory("src/database", "dist/database");
mix.copyDirectory("src/var", "dist/var");
mix.copyDirectory("src/upload", "dist/upload");
mix.copyDirectory("src/resources/vendor", "dist/public/assets/vendor");
mix.copyDirectory("src/resources/fonts", "dist/public/assets/fonts");
mix.copyDirectory("src/resources/media/*", "dist/public/assets/media/")

/**
 * BrowserSync config
 */
mix.browserSync({
    proxy: "localhost",
    files: [
        "dist/(app|bin|bootstrap|public|resources|routes|translations|upload|var|views)/**/*"
    ],

})

/**
 * Load all JS files in the /resources/js directory.
 * ! NOT RECRUSIVE, just the files directly in the directory.
 */
let js_path = "src/resources/js/";
let js_files = fs.readdirSync(js_path);
if (js_files.length > 0) {
    js_files.forEach(function (filename) {
        if (!fs.statSync(js_path + filename).isDirectory()) {
            if(mix.inProduction()) {
                let filename_new = path.basename(filename, ".js");
                mix.js(js_path + filename, "dist/public/assets/js/" + filename_new + "." + hash(filename) + ".min.js").vue();
            }
            else {
                mix.js(js_path + filename, "dist/public/assets/js/").vue();
            }
        }
    });
}

/**
 * Load all SASS files in the /resources/js directory
 * ! NOT RECRUSIVE, just the files directly in the directory.
 */
let sass_path = "src/resources/sass/";
let sass_files = fs.readdirSync(sass_path);
if (sass_files.length > 0) {
    sass_files.forEach(function (filename) {
        if (!fs.statSync(sass_path + filename).isDirectory()) {
            if(mix.inProduction()) {
                let filename_new = path.basename(filename, ".sass");
                mix.sass(sass_path + filename, "dist/public/assets/css/" + filename_new + "." + hash(filename) + ".min.css");
            }
            else {
                mix.sass(sass_path + filename, "dist/public/assets/css/");
            }
        }
    });
}

/**
 * Image compression
 */
if (mix.inProduction()) {
    compress_images(
        "src/resources/media/img/**/*.{jpg,JPG,jpeg,JPEG,png,svg,gif}",
        "dist/public/assets/img/",
        { compress_force: false, statistic: true, autoupdate: true },
        false,
        { jpg: { engine: "mozjpeg", command: ["-quality", "60"] } },
        { png: { engine: "pngquant", command: ["--quality=20-50", "-o"] } },
        { svg: { engine: "svgo", command: "--multipass" } },
        { gif: { engine: "gifsicle", command: ['--colors', '64', '--use-col=web', '--scale', ' 0.8'] } },
        function (err, completed) {}
    );
} else {
    mix.copyDirectory("src/resources/media/img/", "dist/public/assets/img/")
}

/**
 * Twig minifier
 */
if (!mix.inProduction()) {
    mix.copyDirectory("src/views", "dist/views");
}