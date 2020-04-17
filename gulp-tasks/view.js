const gulp = require('gulp');
const htmlmin = require('gulp-htmlmin');
const minifyInline = require('gulp-minify-inline');
const browserSync = require('browser-sync');

let srcdir = "./src/";
let distdir = "./dist/";

gulp.task('views', function() {
    return gulp.src(srcdir + "resources/views/**/*.twig")
        .pipe(gulp.dest(distdir + "resources/views/"))
});

gulp.task('views:prod', function() {
    return gulp.src(srcdir + "resources/views/**/*.twig")
        .pipe(minifyInline())
        .pipe(htmlmin({ collapseWhitespace: true }))
        .pipe(gulp.dest(distdir + "resources/views/"))
});