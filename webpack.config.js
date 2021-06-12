const HTMLPlugin =require('html-webpack-plugin')//подключить класс HTML plugin

module.exports = {
    entry: ['@babel/polyfill', './src/index.js'],//входная точка приложения

    output:{
        path: __dirname + '/dist',
        filename: 'bundle.js'//куда складывать работу
    },

    devServer: {
        contentBase: __dirname + '/dist'//сервер для разработки
    },

    plugins:[
        new HTMLPlugin({//создаём новые экземпляры класса HTMLPlugin
            filename: 'index.html',
            template: './src/index.html'
        })
    ],

    resolve: {//отбросим тип файла ,js
        extensions: ['.js']
    },

    module: {
        rules: [
          { test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader' }
        ]
      }

}