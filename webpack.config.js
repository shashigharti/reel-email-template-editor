const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  entry: { admin: "./src/block/admin.js" },
  output: {
    filename: "[name].js",
    path: path.resolve(__dirname, "build"),
    clean: true,
  },
  module: {
    rules: [
       {
        test: /\.svg$/,
        type: 'asset/source',              
        include: /@ckeditor\/ckeditor5-[^/]+\/theme\/icons/, 
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
      },
      {
        test: /\.css$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader"],
      },
      {
        test: /\.scss$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "[name].css",
    }),
  ],
  externals: {
    react: "React",
    "react-dom": "ReactDOM",
    "@wordpress/blocks": ["wp", "blocks"],
    "@wordpress/element": ["wp", "element"],
    "@wordpress/components": ["wp", "components"],
    "@wordpress/api-fetch": ["wp", "apiFetch"],
    "@wordpress/data": ["wp", "data"],
    "@wordpress/compose": ["wp", "compose"],
    "@wordpress/navigation": ["wp", "navigation"],
    "@wordpress/dom-ready": ["wp", "domReady"],
    "@wordpress/block-editor": ["wp", "blockEditor"],
  },
  mode: "production",
};
