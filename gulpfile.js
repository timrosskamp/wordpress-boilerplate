const gulp = require('gulp')
const pump = require('pump')
const rename = require('gulp-rename')
const sass = require('gulp-sass')
const postcss = require('gulp-postcss')
const autoprefixer = require('autoprefixer')
const cssnano = require('cssnano')

gulp.task('sass', done => {
	pump([
		gulp.src(['src/scss/style.scss'], {
			sourcemaps: true
		}),
		sass.sync({
			outputStyle: 'expanded'
		}),
		postcss([
			autoprefixer()
        ]),
		gulp.dest('dist/', {
			sourcemaps: '.'
		})
	], done)
})

gulp.task('sassmin', done => {
	pump([
		gulp.src(['dist/style.css']),
		postcss([
			cssnano()
		]),
		rename({
			extname: '.min.css'
		}),
		gulp.dest('dist/')
	], done)
})

gulp.task('default', gulp.series('sass', 'sassmin', () => {
	gulp.watch(['src/scss/**'], gulp.series('sass', 'sassmin'))
}))