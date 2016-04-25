<?php
// Route for assets
kirby()->routes(array(
	array(
		'pattern' => '(.+).(css|js)',
		'action' => function($uri) {
			$extension = PluginAssetsRefresh::serverPathExtension();
			$uri = $uri . '.' . PluginAssetsRefresh::serverPathExtension();

			$path = PluginAssetsRefresh::uriToPath( $uri );
			$explode_dash = explode( '-', $path );
			$explode_dot = explode('.', end($explode_dash));
			$time = $explode_dot[0];

			$original = str_replace( '-' . $time, '', $path );
			
			if( $extension == 'css') {
				header('Content-type: text/css; charset: UTF-8');
			} elseif( $extension == 'js') {
				header('Content-Type: application/javascript');
			}
			echo file_get_contents($original);
			die;
		}
	)
));


// Css refresh if logged in
function cssr($paths, $media = null) {
	return css(PluginAssetsRefresh::suffixPaths( $paths ), $media );
}

// Js refresh if logged in
function jsr($paths, $async = null) {
	return js( PluginAssetsRefresh::suffixPaths( $paths ), $async );
}

class PluginAssetsRefresh {
	// Get extension by server
	public static function serverPathExtension() {
		$pathinfo = pathinfo( $_SERVER['REQUEST_URI'] );
		$extension = $pathinfo['extension'];
		return $extension;
	}

	// Suffix all items in an array or as string and return
	public static function suffixPaths( $uris ) {
		if( is_array( $uris ) ) {
			if( ! empty( $uris ) ) {
				foreach( $uris as $key => $uri ) {
					
					$fullpath = self::uriToPath( $uri );
					$hash = self::hash($fullpath);
					$uri = self::hashToUrl( $uri, $hash );
					$uris[$key] = $uri;
				}
			}
		} else {
			$fullpath = self::uriToPath( $uris );
			$hash = self::hash($fullpath);
			$uri = self::hashToUrl( $uris, $hash );
			$uris = $uri;
		}
		return $uris;
	}

	// Add hash to url
	public static function hashToUrl( $uri, $hash ) {
		if( ! empty( $hash ) ) {
			$explode = explode( '.', $uri );
			$explode[count( $explode ) - 2] .= '-' . $hash;
			$uri = implode('.', $explode );
		}
		return $uri;
	}

	// Convert uri to path
	public static function uriToPath( $uri ) {
		return kirby()->roots()->index() . DS . str_replace('/', DS, $uri);
	}

	// Get modified date from file
	public static function hash( $fullpath ) {
		$hash = '';
		if( file_exists($fullpath )) {
			$hash = filemtime($fullpath);
		}
		return $hash;
	}

	// Convert url to relative url
	public static function urlToRelative( $url ) {
		$relative = str_replace( u(), '', $url );
		return substr( $relative, 1 );
	}
}