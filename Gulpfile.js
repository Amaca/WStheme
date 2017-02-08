'use strict';

var es6promise = require('es6-promise'),
    gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    rename = require("gulp-rename"),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    cssmin = require('gulp-cssmin'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    concat = require('gulp-concat');


/***********
*** SASS ***
************/ 
gulp.task('sass', function () {
        console.log('COMPILING SASS');
        return gulp.src(
            './src/scss/**/*.scss'
        )
        .pipe(plumber(function (error) { 
            console.log('sass error: compile plumber', error);
        }))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions', 'Explorer >= 10', 'Android >= 4.1', 'Safari >= 7', 'iOS >= 7'],
            cascade: false
        })) 
        .pipe(sourcemaps.write())
        .pipe(rename({ dirname: '' }))
        .pipe(gulp.dest('./dist/css/'))
        // minify
        .pipe(cssmin())
		.pipe(rename({ suffix: '.min' })) 
        .pipe(gulp.dest('./dist/css/'));
});


/*****************
*** SASS WATCH ***
******************/
gulp.task('sass:watch', function () {
    var watcher = gulp.watch('./src/scss/**/*.scss', ['sass']);  
    watcher.on('change', function (e) {
        console.log('watcher.on.change type: ' + e.type + ' path: ' + e.path);
    });
    return watcher;
});


/*********************
*** SASS BOOTSTRAP ***
**********************/
gulp.task('sass:bootstrap', function () {
    console.log('COMPILING SASS');
    return gulp.src('.src/scss/bootstrap/bootstrap.scss')
        .pipe(plumber(function (error) {
            console.log('sass error: compile plumber', error);
        }))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions', 'Explorer >= 10', 'Android >= 4.1', 'Safari >= 7', 'iOS >= 7'],
            cascade: false
        }))
        .pipe(sourcemaps.write())
        .pipe(rename({ dirname: '' }))
        .pipe(gulp.dest('./dist/css'))
        // minify
        .pipe(cssmin())
		.pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./dist/css'));

});


/*********
*** JS ***
**********/
gulp.task('js', function () { 
    console.log('MINIFYING JS');
    return gulp.src([
            'src/js/vendor/isMobile.js',
            'src/js/vendor/jquery.easing.min.js',
            'src/js/vendor/slick.js',
            'src/js/vendor/tether.js',
            'src/js/vendor/bootstrap.js',
            'src/js/main.js'
        ])
        //concat
        .pipe(sourcemaps.init()) 
        .pipe(concat('main.js'))
        .pipe(sourcemaps.write())
        // minify
        .pipe(uglify())
		.pipe(rename({ suffix: '.min' })) 
        .pipe(gulp.dest('./dist/js/'));
});



/*************** 
*** JS WATCH ***
****************/
gulp.task('js:watch', function () {
    var watcher = gulp.watch('./src/js/**/*.js', ['js']);
    watcher.on('change', function (e) {
        console.log('watcher.on.change type: ' + e.type + ' path: ' + e.path);
    });
    return watcher; 
});


/*************
*** IMAGES ***
**************/
gulp.task('images', function () {
    return gulp.src('./src/img/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(imagemin())
        .pipe(gulp.dest('./dist/img'));
});

/*********
*** JS ***
**********/
gulp.task('jquery', function () {
    return gulp.src('./src/js/vendor/jquery-3.1.0.min.js')
        .pipe(gulp.dest('./dist/js/vendor'));
});


/************
*** START ***
*************/
gulp.task('start', ['sass', 'sass:watch', 'js:watch']);
gulp.task('publish', ['sass', 'js', 'images', 'jquery']);