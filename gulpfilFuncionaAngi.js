import gulp from 'gulp';
const { src, dest, watch, parallel } = gulp;
import sass from 'gulp-sass';
import plumber from 'gulp-plumber';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import cache from 'gulp-cache';
import imagemin from 'gulp-imagemin';
import webp from 'gulp-webp';
import avif from 'gulp-avif';
import terser from 'gulp-terser-js';
import concat from 'gulp-concat';
import rename from 'gulp-rename';
import webpack from 'webpack-stream';


const paths = { 
    scss: 'gulp.src/scss/**/*.scss',
    js: 'gulp.src/js/**/*.js',
    imagenes: 'gulp.src/img/**/*'
};

function css() {
    return gulp.src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(postcss([autoprefixer()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/build/css'));
}

function javascript() {
    return gulp.src(paths.js)
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.css$/i,
                        use: ['style-loader', 'css-loader']
                    }
                ]
            },
            mode: 'production',
            watch: true,
        }))
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./public/build/js'));
    }

function imagenes() {
    return src(paths.imagenes)
    .pipe(cache(imagemin({ optimizationLevel: 3 })))
    .pipe(gulp.dest('public/build/img'));
}

function versionWebp( done ) {
    const opciones = {
        quality: 50
    };
    src('src/img/**/*.{png,jpg}')
    .pipe(webp(opciones))
    .pipe(gulp.dest('public/build/img'));
    done();
}

function versionAvif( done ) {
    const opciones = {
        quality: 50
    };
    src('src/img/**/*.{png,jpg}')
    .pipe(avif(opciones))
    .pipe(gulp.dest('public/build/img'));
    done();
}

function dev(done) {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.imagenes, imagenes);
    watch(paths.imagenes, versionWebp);
    watch(paths.imagenes, versionAvif);
    done();
}

// exports.css = css;
// exports.js = javascript;
// exports.imagenes = imagenes;
// exports.versionWebp = versionWebp;
// exports.versionAvif = versionAvif;
//exports.dev = parallel( css, imagenes, versionWebp, versionAvif, javascript, dev) ;
//exports.build = parallel( css, imagenes, versionWebp, versionAvif, javascript ) ;

export { css, javascript, imagenes, versionWebp, versionAvif, dev };
