import resolve from '@rollup/plugin-node-resolve'
import commonjs from '@rollup/plugin-commonjs'
import { terser } from "rollup-plugin-terser"
import buble from '@rollup/plugin-buble';

export default [{
    input: 'src/js/script.js',
    output: [{
        file: 'dist/script.js',
        format: 'iife',
        sourcemap: true
    }, {
        file: 'dist/script.min.js',
        format: 'iife',
        plugins: [
            terser()
        ]
    }],
    plugins: [
        resolve(),
        commonjs(),
        buble()
    ]
}]