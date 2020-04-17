const gulp = require('gulp');
const clean = require('gulp-clean');
const browserSync = require('browser-sync').create();
const watch = require('gulp-watch');

require('require-dir')('./gulp-tasks');

let distdir = "./dist/";
let srcdir = "./src/";

gulp.task('clean', function() {
    return gulp.src(distdir)
        .pipe(clean());
});

gulp.task('bs-reload', function(cb) {
    browserSync.reload();
    cb();
});

gulp.task('build:dev', gulp.parallel(
    "sass",
    "scripts",
    "move",
    "create-missing",
    "images",
    "views"
));

gulp.task('build:prod', gulp.series(
    "clean",
    gulp.parallel(
        "sass:prod",
        "scripts:prod",
        "move:prod",
        "create-missing", 
        "images",
        "views:prod"
    )
));

gulp.task('watch', gulp.series('build:dev', function (cb) {
    browserSync.init({
        proxy: "localhost"
    });
    gulp.watch(srcdir + "app/**/*.*", gulp.series('move-app', 'bs-reload'));
    gulp.watch(srcdir + "bootstrap/**/*.*", gulp.series('move-bootstrap', 'bs-reload'));
    gulp.watch(srcdir + "database/**/*.*", gulp.series('move-database', 'bs-reload'));
    gulp.watch(srcdir + "public/**/*.*", gulp.series('move-public', 'bs-reload'));
    gulp.watch(srcdir + "routes/**/*.*", gulp.series('move-routes', 'bs-reload'));
    gulp.watch(srcdir + "vendor/**/*.*", gulp.series('move-vendor', 'bs-reload'));
    gulp.watch(srcdir + "resources/views/**/*.twig", gulp.series('views', 'bs-reload'));
    gulp.watch(srcdir + "resources/js/*.js", gulp.series('scripts', 'bs-reload'));
    gulp.watch(srcdir + "resources/sass/*.sass", gulp.series('sass', 'bs-reload'));
    gulp.watch(srcdir + "resources/media/**/*.*", gulp.series('images', 'bs-reload'));
    cb();
}));

gulp.task('default', gulp.series(
    'build:dev'
));