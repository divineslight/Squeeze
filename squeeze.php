<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Squeeze Class
 *
 * Makes asset management, minifying easy
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Philip Sturgeon
 * @created			04/06/2009
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link			http://github.com/philsturgeon/codeigniter-restclient
 */

class Squeeze
{
	protected $_CI;
	
	protected $_js = array(), $_css = array();

	protected $_minify_base;

	private $_minify_url;
	
	function __construct( $config = array() )
	{
    $this->_CI =& get_instance();


		$this->_minify_base = $config['minify_base'];
		$this->_js_base = $config['js_base'];
		$this->_css_base = $config['css_base'];
		$this->_minify_url = base_url().$this->_minify_base.'index.php?';
	}
	
	function js( $js )
	{
		if ( is_array($js) )
		{
			$this->_js = array_merge( $this->_js, $js );
			return;
		}

		$this->_js[] = $js;
	}

	
	function css( $css )
	{
		if ( is_array($css) )
		{
			$this->_css = array_merge( $this->_css, $css );
			return;
		}

		$this->_css[] = $css;
	}


	function render( $debug = false )
	{
		$debug = $debug ? '&debug=1' : '';

		$js_url = $css_url = $final = NULL;

		if ( count($this->_js) )
		{
			$js_url = $this->_minify_url.'b='.$this->_js_base.'&f='.implode( ",", $this->_js ).$debug; //jquery-1.4.4.min.js,jquery.cookie.js.... etc
			$final = '<script type="text/javascript" src="'.$js_url.'"></script>'.PHP_EOL;
		}
		if ( count($this->_css) )
		{
			$css_url 	= $this->_minify_url.'b='.$this->_css_base.'&f='.implode( ",",$this->_css ).$debug;   //styles/ui.notify.css,images/slider/theme/default/default.css...etc
			$final .= '<link href="'.$css_url.'" type="text/css" rel="stylesheet">'.PHP_EOL;
		}

		$this->_css = $this->_js = array();

		return $final;
	}
	
	
}
