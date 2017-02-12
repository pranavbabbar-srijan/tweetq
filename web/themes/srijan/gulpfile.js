var gulp = require('gulp');
var sass = require('gulp-sass');
// var browserSync = require('browser-sync').create();
var livereload = require('gulp-livereload');

gulp.task('sass',function(){
    return gulp.src('sass/*.scss')
    .pipe(sass())
        .pipe(gulp.dest('css/'))
        .pipe(livereload());
        // .pipe(browserSync.reload({
        //     stream: true
        // }))
});
gulp.task('watch',['sass'],function(){
   var server = livereload();
   gulp.watch('sass/**/*.scss',['sass']);
});

gulp.task('default', ['sass', 'watch']);

// CSS lint added.
var csslint = require('gulp-csslint');
 
gulp.task('css', function() {
  gulp.src('css/*.css')
    .pipe(csslint())
    .pipe(csslint.reporter());
});

// gulp.task('browserSync',function(){
//     browserSync.init({
//         server:{
//           baseDir: '/css/'
//         },
//     })
// });

// gulp.task('browserSync',function(){
//     browserSync.init({
//         proxy: "https://dotsrijan.local.com"
//     });
// });