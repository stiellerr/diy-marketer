import gulp from "gulp";
import yargs from "yargs";
import sass from "gulp-sass";
import cleanCSS from "gulp-clean-css";
import gulpif from "gulp-if";
import sourcemaps from "gulp-sourcemaps";
import imagemin from "gulp-imagemin";
import del from "del";
import webpack from "webpack-stream";
import named from "vinyl-named";
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json";
import rename from "gulp-rename";
import autoprefixer from "autoprefixer";
import MiniCSSExtractPlugin from "mini-css-extract-plugin";
import OptimizeCSSAssetsPlugin from "optimize-css-assets-webpack-plugin";
import TerserPlugin from "terser-webpack-plugin";
const CleanPlugin = require("clean-webpack-plugin").CleanWebpackPlugin;
import postcss from "gulp-postcss";
import htmlmin from "gulp-htmlmin";
//import { phpMinify } from "@cedx/gulp-php-minify";

const server = browserSync.create();

const PRODUCTION = yargs.argv.prod;

const paths = {
    php: {
        src: ["header.php"],
        dest: "dist/assets/php"
    },
    styles: {
        src: ["src/assets/scss/bundle.scss", "src/assets/scss/admin.scss"],
        dest: "dist/assets/css"
    },
    images: {
        src: ["src/assets/images/**/*.{jpg,jpeg,png,svg,gif,JPG}"],
        dest: "dist/assets/images"
    },
    scripts: {
        src: ["src/assets/js/bundle.js", "src/assets/js/admin.js"],
        dest: "dist/assets/js"
    },
    blocks: {
        src: ["src/assets/blocks/index.js"],
        dest: "dist/assets/blocks"
    },
    other: {
        src: [
            "src/assets/**/*",
            "!src/assets/{images,js,scss}",
            "!src/assets/{images,js,scss}/**/*"
        ],
        dest: "dist/assets"
    },
    package: {
        src: [
            "**/*",
            "!.vscode",
            "!node_modules{,/**}",
            "!packaged{,/**}",
            "!src{,/**}",
            "!.babelrc",
            "!.gitignore",
            "!gulpfile.babel.js",
            "!package.json",
            "!package-lock.json",
            "!.eslintrc.js",
            "!.prettierignore",
            "!.prettierrc"
        ],
        dest: "packaged"
    }
};

export const styles = () => {
    return gulp
        .src(paths.styles.src)
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on("error", sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulpif(PRODUCTION, cleanCSS()))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(server.stream());
};

export const php = () => {
    return (
        gulp
            .src(paths.php.src)

            .pipe(
                htmlmin({
                    collapseWhitespace: true,
                    removeComments: true
                    //ignoreCustomFragments: [/<%[\s\S]*?%>/, /<\?[=|php]?[\s\S]*?\?>/]
                })
            )
            //.pipe(phpMinify())
            .pipe(gulp.dest(paths.php.dest))
    );
};

export const serve = done => {
    server.init({
        proxy: "http://localhost/"
    });
    done();
};

export const reload = done => {
    server.reload();
    done();
};

export const clean = () => {
    return del(["dist"]);
};

export const images = () => {
    return gulp
        .src(paths.images.src)
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(gulp.dest(paths.images.dest));
};

export const watch = () => {
    gulp.watch("src/assets/scss/**/*.scss", styles);
    gulp.watch("src/assets/js/**/*.js", gulp.series(scripts, reload));
    gulp.watch("**/*.php", reload);
    gulp.watch(paths.images.src, gulp.series(images, reload));
    gulp.watch(paths.other.src, gulp.series(copy, reload));
};

export const copy = () => {
    return gulp.src(paths.other.src).pipe(gulp.dest(paths.other.dest));
};

export const compress = () => {
    return gulp
        .src(paths.package.src)
        .pipe(
            rename(function (path) {
                path.dirname = `${info.name}/` + path.dirname;
            })
        )
        .pipe(zip(`${info.name}.zip`))
        .pipe(gulp.dest(paths.package.dest));
};

export const blocks = () => {
    return gulp
        .src(paths.blocks.src)
        .pipe(named())
        .pipe(
            webpack({
                output: {
                    filename: "[name].js",
                    // used for the clean plugin (delete)
                    path: __dirname + "/dist/assets/blocks"
                },
                optimization: {
                    minimizer: [
                        new TerserPlugin({
                            sourceMap: true
                        }),
                        new OptimizeCSSAssetsPlugin({
                            /*
                            for source mapping in prod mode
                            cssProcessorOptions: {
                                map: {
                                    inline: false,
                                    annotation: true
                                }
                            }
                            */
                        })
                    ]
                },
                plugins: [
                    new CleanPlugin(),
                    new MiniCSSExtractPlugin({
                        moduleFilename: ({ name }) => `${name.replace("script", "style")}.css`
                    })
                ],
                devtool: !PRODUCTION ? "cheap-module-source-map" : false,
                module: {
                    rules: [
                        {
                            test: /\.js$/,
                            exclude: /node_modules/,
                            use: [
                                {
                                    loader: "babel-loader",
                                    options: {
                                        presets: [
                                            "@babel/preset-env",
                                            [
                                                "@babel/preset-react",
                                                {
                                                    //pragma: "wp.element.createElement",
                                                    pragma: "React.createElement",
                                                    //pragmaFrag: "wp.element.Fragment",
                                                    pragmaFrag: "React.Fragment",
                                                    development: !PRODUCTION
                                                }
                                            ]
                                        ]
                                    }
                                },
                                "eslint-loader"
                            ]
                        },
                        {
                            test: /\.(sa|sc|c)ss$/,
                            use: [
                                MiniCSSExtractPlugin.loader,
                                "css-loader",
                                {
                                    loader: "postcss-loader",
                                    options: {
                                        plugins: [autoprefixer()]
                                    }
                                },
                                "sass-loader"
                            ]
                        }
                    ]
                },
                /*
                externals: {
                    jquery: "jQuery"
                },
                */
                mode: PRODUCTION ? "production" : "development"
            })
        )
        .pipe(gulp.dest(paths.blocks.dest));
};

export const scripts = () => {
    return gulp
        .src(paths.scripts.src)
        .pipe(named())
        .pipe(
            webpack({
                module: {
                    rules: [
                        {
                            test: /\.js$/,
                            exclude: /node_modules/,
                            use: [
                                {
                                    loader: "babel-loader",
                                    options: {
                                        presets: ["@babel/preset-env"]
                                    }
                                },
                                "eslint-loader"
                            ]
                        }
                    ]
                },
                output: {
                    filename: "[name].js"
                },
                externals: {
                    jquery: "jQuery"
                },
                devtool: !PRODUCTION ? "inline-source-map" : false,
                mode: PRODUCTION ? "production" : "development"
            })
        )
        .pipe(gulp.dest(paths.scripts.dest));
};

export const build = gulp.series(clean, gulp.parallel(styles, scripts, images, copy));
export const dev = gulp.series(clean, gulp.parallel(styles, scripts, images, copy), serve, watch);
export const bundle = gulp.series(build, compress);
export default dev;
