<?php
namespace Sleek\GoogleMaps;

####################
# Add settings field
add_action('admin_init', function () {
	\Sleek\Settings\add_setting('google_maps_api_key', 'text', __('Google Maps API Key', 'sleek_admin'));
});

##########################
# Add Google Maps callback
add_action('wp_footer', function () {
	if ($key = \Sleek\Settings\get_setting('google_maps_api_key')) {
		?>
		<script>
			SLEEK_GOOGLE_MAPS_API_KEY = '<?php echo $key ?>';
		</script>
		<?php
	}
});

############################
# Include google maps JS api
add_action('wp_enqueue_scripts', function () {
	if ($key = \Sleek\Settings\get_setting('google_maps_api_key')) {
		$url = 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&callback=googleMapsInit';
		$url = apply_filters('sleek/google_maps/js_api_url', $url);

		wp_register_script('sleek_google_maps', $url, ['sleek'], null, true);
		wp_enqueue_script('sleek_google_maps');
	}
});

################################
# Add Google Maps API Key to ACF
add_action('init', function () {
	if ($key = \Sleek\Settings\get_setting('google_maps_api_key')) {
		add_filter('acf/fields/google_map/api', function ($api) use ($key) {
			$api['key'] = $key;

			return $api;
		});
	}
});
