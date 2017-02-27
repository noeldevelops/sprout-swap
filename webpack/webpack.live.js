output: {
	path: helpers.root('public_html/dist'),
		publicPath: 'dist',
		filename: '[name].[hash].js',
		chunkFilename: '[id].[hash].chunk.js'
}