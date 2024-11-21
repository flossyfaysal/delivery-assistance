const path = require("path");

module.exports = {
  entry: "./src/index.js", // Path to your entry file
  output: {
    path: path.resolve(__dirname, "assets/js"), // Path where the compiled JS will be placed
    filename: "settings.js", // Output JS filename
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env", "@babel/preset-react"], // For React JSX and modern JS
          },
        },
      },
    ],
  },
  resolve: {
    extensions: [".js", ".jsx"], // Allow imports without specifying extensions
  },
  devtool: "source-map",
  externals: {
    react: "React", // Tell Webpack not to bundle React (it's already provided by WordPress)
    "react-dom": "ReactDOM", // Same for ReactDOM
    "@wordpress/element": "wp.element", // WordPress provides this globally
  },
  mode: "development", // Change to "production" for optimized builds
};
