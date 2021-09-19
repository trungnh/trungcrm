const path = require('path');
const webpack = require('webpack');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/'),
            'admin': path.resolve(__dirname, 'resources/js/pages/admin'),
            'corp': path.resolve(__dirname, 'resources/js/pages/corp'),
            'partner': path.resolve(__dirname, 'resources/js/pages/partner'),
            'exam': path.resolve(__dirname, 'resources/js/pages/exam'),
        }
    }
};
