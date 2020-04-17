const gulp = require('gulp');

let srcdir = "./src/";
let distdir = "./dist/";

gulp.task("move-app", function() {
    return gulp.src(srcdir + "app/**/**.*")
        .pipe(gulp.dest(distdir + "app"))
});

gulp.task("move-bootstrap", function() {
    return gulp.src(srcdir + "bootstrap/**/**.*")
        .pipe(gulp.dest(distdir + "bootstrap"))
});

gulp.task("move-database", function() {
    return gulp.src(srcdir + "database/**/**.*")
        .pipe(gulp.dest(distdir + "database"))
});

gulp.task("move-public", function(cb) {
    gulp.src(srcdir + "public/**/**.*")
        .pipe(gulp.dest(distdir + "public"));
    gulp.src(srcdir + "public/.htaccess")
        .pipe(gulp.dest(distdir + "public"));
    cb();
});

gulp.task("move-routes", function() {
    return gulp.src(srcdir + "routes/**/**.*")
        .pipe(gulp.dest(distdir + "routes"))
});

gulp.task("move-vendor", function() {
    return gulp.src(srcdir + "vendor/**/**.*")
        .pipe(gulp.dest(distdir + "vendor"))
});

gulp.task("move-autoload", function() {
    return gulp.src(srcdir + "autoload.php")
        .pipe(gulp.dest(distdir))
});

gulp.task("move-env", function() {
    return gulp.src(srcdir + ".env")
        .pipe(gulp.dest(distdir))
});

gulp.task("move-env-example", function() {
    return gulp.src(srcdir + ".env.example")
        .pipe(gulp.dest(distdir))
});

gulp.task("move", gulp.parallel(
    "move-app",
    "move-bootstrap",
    "move-database",
    "move-public",
    "move-routes",
    "move-vendor",
    "move-autoload",
    "move-env"
));

gulp.task("move:prod", gulp.parallel(
    "move-app",
    "move-bootstrap",
    "move-database",
    "move-public",
    "move-routes",
    "move-vendor",
    "move-autoload"
));