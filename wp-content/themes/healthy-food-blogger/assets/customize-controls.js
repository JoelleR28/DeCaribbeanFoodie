( function( api ) {

	// Extends our custom "healthy-food-blogger" section.
	api.sectionConstructor['healthy-food-blogger'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );