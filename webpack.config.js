const path = require('path');

module.exports = {
    entry: './src/block/admin.js',
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'admin.js',
        libraryTarget: 'var',
        library: 'reelEmailTemplateEditor',
    },
    module: {
        rules: [
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: 'babel-loader',
            },
        ],
    },
    externals: {
        react: 'React',
        'react-dom': 'ReactDOM',
        '@wordpress/blocks': ['wp', 'blocks'],
        '@wordpress/element': ['wp', 'element'],
        '@wordpress/components': ['wp', 'components'],
        '@wordpress/api-fetch': ['wp', 'apiFetch'],
        '@wordpress/data': ['wp', 'data'],
        '@wordpress/compose': ['wp', 'compose'],
        '@wordpress/navigation': ['wp', 'navigation'],
        '@wordpress/dom-ready': ['wp', 'domReady'],
        '@wordpress/block-editor': ['wp', 'blockEditor'],
    },
    mode: 'production',
};
