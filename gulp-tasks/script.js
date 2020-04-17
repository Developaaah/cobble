const gulp = require('gulp');
const browserify = require('gulp-browserify');
const uglify = require('gulp-uglify-es').default;
const hash = require('gulp-hash-filename');
const strip = require('gulp-strip-comments');

let srcdir = "./src/";
let distdir = "./dist/";

gulp.task('scripts', function() {
    return gulp.src(srcdir + "resources/js/*.js")
        .pipe(browserify())
        .pipe(gulp.dest(distdir + "public/assets/js"));
});

gulp.task('scripts:prod', function() {
    return gulp.src(srcdir + "resources/js/*.js")
        .pipe(browserify())
        .pipe(hash({
            "format": "{name}.{hash}.min{ext}"
        }))
        .pipe(strip())
        .pipe(uglify())
        .pipe(gulp.dest(distdir + "public/assets/js"));
});