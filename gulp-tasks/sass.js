const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const minifyCss = require('gulp-minify-css');
const hash = require('gulp-hash-filename');

gulp.task('sass', function () {
    return gulp.src('./src/resources/sass/*.sass')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('./dist/public/assets/css'))
        //.pipe(reload())
});

gulp.task('sass:prod', function () {
    return gulp.src('./src/resources/sass/*.sass')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(minifyCss())
        .pipe(hash({
            "format": "{name}.{hash}.min{ext}"
        }))
        .pipe(gulp.dest('./dist/public/assets/css'))
        //.pipe(reload())
});