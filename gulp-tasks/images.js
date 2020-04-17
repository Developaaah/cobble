const gulp = require('gulp');
const imagemin = require('gulp-imagemin');

let srcdir = "./src/";
let distdir = "./dist/";

gulp.task('images', function() {
    return gulp.src(srcdir + 'resources/media/*')
        .pipe(imagemin())
        .pipe(gulp.dest(distdir + 'public/assets/img'));
});