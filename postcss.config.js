module.exports = ( { env } ) => ( {
	map: 'production' !== env,
	plugins: [
		require('postcss-import')(),
		require('postcss-short')(),
		require('postcss-preset-env')( { stage: 1 } ),
	]
} );
