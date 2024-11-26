const path = require("path");
const glob = require("glob");

module.exports = {
  entry: () => {
    const entries = {
      settings: "./src/settings/index.js", // Add your static entry point
    };

    // Dynamically add block entries
    const blockDirs = glob.sync("./src/blocks/*/index.js");
    blockDirs.forEach((filePath) => {
      const blockName = filePath.match(/\/blocks\/([^\/]+)\//)[1]; // Extract block name
      entries[blockName] = filePath;
    });

    return entries;
  },
  output: {
    path: path.resolve(__dirname, "assets/js/build"),
    filename: "[name].js", // Each block gets its own file: login.js, register.js, etc.
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
    "@wordpress/blocks": ["wp", "blocks"],
    "@wordpress/block-editor": ["wp", "blockEditor"],
    "@wordpress/element": ["wp", "element"],
    "@wordpress/i18n": ["wp", "i18n"],
  },
  mode: "development", // Change to "production" for optimized builds
};
