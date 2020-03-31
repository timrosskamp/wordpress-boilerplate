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
        buble(),
        resolve(),
        commonjs()
    ]
}, {
    input: 'src/blocks/blocks.js',
    output: {
        file: 'dist/blocks.js',
        format: 'iife',
        sourcemap: true
    },
    plugins: [
        buble(),
        resolve(),
        commonjs()
    ]
}]