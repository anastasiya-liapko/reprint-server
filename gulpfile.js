'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var gulpIf = require('gulp-if');
var del = require('del');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var autoprefixer = require ('autoprefixer');
var minify = require('gulp-csso');
var rename = require('gulp-rename');
var browserSync = require('browser-sync').create();
var imagemin = require('gulp-imagemin');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

var isDevelopment = !process.env.NODE_ENV || process.env.NODE_ENV == 'development';

gulp.task('styles', function() {

  return gulp.src('src/sass/style.sass')
    .pipe(gulpIf(isDevelopment, sourcemaps.init()))
    .pipe(plumber())
    .pipe(sass())
    .pipe(postcss([
      autoprefixer()
      ]))
    .pipe(gulpIf(isDevelopment, sourcemaps.write()))
    .pipe(minify())
    .pipe(rename('style.min.css'))
    .pipe(gulp.dest('assets/css'));

});

gulp.task('css', function () {
  return gulp.src('src/css/**/*.css')
    .pipe(minify())
    .pipe(gulp.dest('assets/css'));
});

gulp.task('js', function () {
  return gulp.src('src/js/**/*.js')
    // .pipe(sourcemaps.init())
    // .pipe(concat('script.min.js'))
    .pipe(uglify())
    // .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('assets/js'));
});

gulp.task('images', function() {
  return gulp.src('src/img/*.{png,jpg,svg}')
  // .pipe(imagemin([
  //   imagemin.optipng({optimizationLevel: 3}),
  //   imagemin.jpegtran({progressive: true}),
  //   imagemin.svgo()
  //   ]))
    .pipe(gulp.dest('assets/img'));
})

gulp.task('fonts', function () {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('assets/fonts'));
});

gulp.task('clean', function() {
  return del('assets');
});

gulp.task('build', gulp.series('clean', 'images', gulp.parallel('styles', 'js', 'fonts', 'css')));

gulp.task('watch', function() {
  gulp.watch('src/sass/**/*.*', gulp.series('styles'));
  gulp.watch('src/js/**/*.*', gulp.series('js'));
  gulp.watch('src/fonts/**/*.*', gulp.series('fonts'));
  gulp.watch('src/img/**/*.*', gulp.series('images'));
  gulp.watch('src/css/**/*.*', gulp.series('images'));
})

gulp.task('serve', function() {
  browserSync.init({
    server: 'public'
  });
  browserSync.watch('src/!**/!*.*').on('change', browserSync.reload);
}); 

gulp.task('dev', gulp.series('build', gulp.parallel('watch', 'serve')));