var gulp = require('gulp'),
  sass = require('gulp-sass'),
  plumber = require('gulp-plumber'),
  autoprefixer = require('gulp-autoprefixer'),
  sourcemaps = require('gulp-sourcemaps'),
  browser = require('browser-sync'),
  cssNano = require('gulp-cssnano')

const path = {
  assets : './assets/',
  dist : './d/',
}

gulp.task('server', () => {
  browser.init({
    server : {
      baseDir : "./"
    },
    files : ['./*']
  })
})

function cssTranspile(srcPath, distDir) {
  gulp.src(srcPath)
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(cssNano(), {
      safe : true
    })
    .pipe(sourcemaps.write("./maps"))
    .pipe(gulp.dest(distDir))
    .pipe(browser.reload({
      stream : true
    }))
}

gulp.task('sass-transpile', () => {
  cssTranspile(path.assets + 'styles/style.scss', path.dist + 'styles');
})

gulp.task('watch', () => {
  gulp.watch(path.assets + 'styles/**/*.scss', ['sass-transpile'])
})

gulp.task('build', () => {
  gulp.start('sass-transpile')
})

gulp.task('default', ['server'], () => {
  gulp.start('build')
  gulp.start('watch')
})
