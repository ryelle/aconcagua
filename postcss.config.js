module.exports = ( { env } ) => ( {
	map: 'production' !== env,
	plugins: [
		require('postcss-short'),
		require('postcss-import'),
		require('postcss-custom-properties')
	]
} );
