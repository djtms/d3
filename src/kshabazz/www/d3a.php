<?php namespace kshabazz\d3a;
/**
 * Diablo 3 Assistant core load script.
 *
 * Requirements:
 *  PHP 5.6+
 *  Use of .user.ini feature
 *  Composer
 *  Write permissions in the media/images directory
 */

// composer auto-loader.
require_once __DIR__ . '/../../../vendor/autoload.php';

// Get the attribute map file.
$d3a = new Application( new SuperGlobals() );

\Kshabazz\Slib\checkPhpVersion( 5, 6 );

// TODO change convertToClassName to convertRouteToClassName and move to application class.
$page = basename( $_SERVER['SCRIPT_FILENAME'] );
$routeName = \Kshabazz\Slib\convertToClassName( $page );
$d3a->store( 'routeName', $routeName );
$GLOBALS[ 'application' ] = $d3a;

// Load the Route controller.
$className = __NAMESPACE__ . '\\Controller\\' . $d3a->retrieve( 'routeName' );
$model = null;
if ( class_exists($className) )
{
	// Page controller
	$ctrlr = new $className( $d3a->superGlobals() );
	// Business model
	$model = $ctrlr->getModel();
	$model->pageTitle = 'Diablo 3 Assitant';
} else {
	// Load the Route page.
	$className = __NAMESPACE__ . '\\Page\\' . $d3a->retrieve( 'routeName' );
	$model = null;
	if ( class_exists($className) )
	{
		// Page
		$page = new $className( $d3a );
		$view = $page->getView();
		// Setup Twig template engine.
		$twigLoader = new \Twig_Loader_String();
		$twig = new \Twig_Environment( $twigLoader );
		// Access any function defined, from Twig, without having to add each one.
		$twig->addFunction(new \Twig_SimpleFunction('func', function ($function) {
			$params = \func_get_args();
			// handle methods of objects and params.
			if ( is_object($function) )
			{
				$function = [
					array_shift( $params ),
					array_shift( $params )
				];
			} // handle regular function params
			else if ( count($params) > 1 )
			{
				array_shift( $params );
			}
			return \call_user_func_array( $function, $params );
		}));
		// start output buffering.
		\ob_start();
		// Turn on D3 error handling.
		\set_error_handler( [$d3a, 'errorHandlerNotice'], E_NOTICE );
		// Set output buffer to be sent through the Twig Engine on shutdown.
		// We use 'shutdown' because you can even catch most errors and output them how you like.
		\register_shutdown_function( [$d3a, 'renderView'], $view, $twig );
	}
}

// Processing route view by passing the model to the template engine,
// which in turn, fill in all holes within the view.
if ( $model !== null )
{
	// Setup Twig template engine.
	$twigLoader = new \Twig_Loader_String();
	$twig = new \Twig_Environment( $twigLoader );
	// start output buffering.
	\ob_start();
	// Turn on D3 error handling.
	\set_error_handler( [$d3a, 'errorHandlerNotice'], E_NOTICE );
	// Set output buffer to be sent through the Twig Engine on shutdown.
	// We use 'shutdown' because you can even catch most errors and output them how you like.
	\register_shutdown_function([$d3a, 'render'], $model, $twig );

	$twig->addFunction(new \Twig_SimpleFunction('isArray', function ($pVariable) {
		return isArray( $pVariable );
	}));

	$twig->addFunction(new \Twig_SimpleFunction('sessionTimeLeft', function ($pTime) {
		return \kshabazz\d3a\displaySessionTimer( $pTime );
	}));

	$twig->addFunction(new \Twig_SimpleFunction('output', function ($pHtml, $listItems) {
		return \kshabazz\d3a\output( $pHtml, $listItems );
	}));

	$twig->addFunction(new \Twig_SimpleFunction('translateSlotName', function ($slot) {
		return \kshabazz\d3a\translateSlotName( $slot );
	}));

	$twig->addFunction(new \Twig_SimpleFunction('str_replace', function ($needle, $replace, $haystack) {
		return \str_replace($needle, $replace, $haystack);
	}));

	$twig->addFunction(new \Twig_SimpleFunction('getItemSlot', function ($key) {
		return \kshabazz\d3a\getItemSlot($key);
	}));

	$twig->addFunction(new \Twig_SimpleFunction('substr', function ($subject, $index) {
		return \substr($subject, $index);
	}));

	// Access any function in the PHP global namespace from Twig.
	$twig->addFunction(new \Twig_SimpleFunction('func', function ($function) {
		$params = \func_get_args();
		// handle methods of objects and params.
		if ( is_object($function) )
		{
			$function = [
				array_shift( $params ),
				array_shift( $params )
			];
		} // handle regular function params
		else if ( count($params) > 1 )
		{
			array_shift( $params );
		}
		return \call_user_func_array( $function, $params );
	}));
}
// unset any undesired global variables made in this script.
unset(
$controller,
$ctrlr,
	$model,
$nameSpace,
	$page,
	$view
);
//DO NOT PUT ANY CHARACTERS OR EVEN WHITE-SPACE after the closing PHP tag, or headers may be sent before intended.
?>