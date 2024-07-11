const path = require("path");
const webpack = require("webpack");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const ReactRefreshWebpackPlugin = require("@pmmmwh/react-refresh-webpack-plugin");

module.exports = {
  entry: {
    admin: "./assets/src/index.js",
  },
  mode: process.env.NODE_ENV === "production" ? "production" : "development",
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, "assets/dist/js"),
    publicPath: "http://localhost:3000/assets/dist/js/",
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env", "@babel/preset-react"],
            plugins: [
              process.env.NODE_ENV === "development" &&
                require.resolve("react-refresh/babel"),
            ].filter(Boolean),
          },
        },
      },
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader"],
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(),
    process.env.NODE_ENV === "development" &&
      new webpack.HotModuleReplacementPlugin(),
    process.env.NODE_ENV === "development" &&
      new ReactRefreshWebpackPlugin({
        overlay: false,
      }),
  ].filter(Boolean),
  devServer: {
    port: 3000,
    headers: { "Access-Control-Allow-Origin": "*" },
    allowedHosts: ["masteriyo.local"],
    host: "localhost",
    hot: true,
    devMiddleware: {
      writeToDisk: true,
    },
  },
};
