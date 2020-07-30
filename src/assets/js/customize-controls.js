/* global diymBgColors */
/* eslint no-unused-vars: off */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

//alert("hello world");

wp.customize.bind("ready", () => {
    wp.customize("accent_hue", value => {
        value.bind(to => {
            //console.log(to);
            // Update the value for our accessible colors for all areas.
            for (let context of Object.keys(diymBgColors)) {
                let backgroundColorValue;
                console.log(context);
            }

            /*
			Object.keys( diymBgColors ).forEach( function( context ) {
				var backgroundColorValue;
				console.log( twentyTwentyBgColors[ context ].color );
				if ( twentyTwentyBgColors[ context ].color ) {
					console.log( 'hello' );
					backgroundColorValue = twentyTwentyBgColors[ context ].color;
				} else {
					console.log( 'world' );
					backgroundColorValue = wp.customize( twentyTwentyBgColors[ context ].setting ).get();
				}
				
				console.log( backgroundColorValue );
				twentyTwentySetAccessibleColorsValue( context, backgroundColorValue, to );
			});
			*/
        });
    });
});
