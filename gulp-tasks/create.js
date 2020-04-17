const gulp = require('gulp');

let srcdir = "./src/";
let distdir = "./dist/";

gulp.task('create-missing', function() {
    return gulp.src('*.*', {read: false})
        .pipe(gulp.dest(distdir + 'storage/views'));
});