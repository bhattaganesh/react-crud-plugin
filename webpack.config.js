const path = require("path");

module.exports = {
  entry: {
    admin: "./assets/src/index.js",
  },
  mode: process.env.NODE_ENV === "production" ? "production" : "development",
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, "assets/dist/js"),
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
          },
        },
      },
     {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
    ],
  },
  plugins: [],
};
