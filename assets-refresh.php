<?php
// Css refresh if logged in
function cssr($paths, $media = null) {
	return css(PluginAssetsRefresh::suffixPaths( $paths ), $media );
}

// Js refresh if logged in
function jsr($paths, $async = null) {
	return js( PluginAssetsRefresh::suffixPaths( $paths ), $async );
}

class PluginAssetsRefresh {
	// Suffix if logged in
	public static function suffix() {
		return ( site()->user() ) ? '?r=' . time() : '';
	}

	// Suffix all items in an array or as string and return
	public static function suffixPaths( $paths ) {
		if( is_array( $paths ) ) {
			if( ! empty( $paths ) ) {
				foreach( $paths as $key => $path ) {
					$paths[$key] = $path . self::suffix();
				}
			}
		} else {
			$paths = $paths . self::suffix();
		}
		return $paths;
	}
}