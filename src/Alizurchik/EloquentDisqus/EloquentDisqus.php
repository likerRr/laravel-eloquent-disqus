<?php namespace Alizurchik\EloquentDisqus;

use Illuminate\View\Factory;

class EloquentDisqus {

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var Factory
	 */
	private $view;

	const THREAD_HASH = '#disqus_thread';

	/**
	 * @param Factory $view
	 */
	public function __construct(Factory $view) {
		$this->view = $view;
		$this->config = \Config::get('eloquent-disqus::disqus');
	}

	/**
	 * Get configuration key by dot notation
	 * @param $path
	 * @param null $default
	 *
	 * @return mixed
	 */
	public function getConfig($path, $default = null) {
		return array_get($this->config, $path, $default);
	}

	/**
	 * @param null $title - Tells the Disqus service the title of the current page. This is used when creating the
	 * thread on Disqus for the first time. By default, Disqus will use the <title> attribute of the page. If that
	 * attribute could not be used, Disqus will use the URL of the page.
	 * @param null $url - Tells the Disqus service the URL of the current page. By default, Disqus will take the
	 * window.location.href. This URL is used to look up or create a thread if disqus_identifier is undefined.
	 * In addition, this URL is always saved when a thread is being created so that Disqus knows what page a thread
	 * belongs to.
	 * @param null $identifier - Tells the Disqus service how to identify the current page. When the Disqus embed is
	 * loaded, the identifier is used to look up the correct thread. By default, the page's URL
	 * will be used. The URL can be unreliable, such as when renaming an article slug or changing domains, so we
	 * recommend using your own unique way of identifying a thread.
	 *
	 * @return $this
	 */
    public function begin($title = null, $url = null, $identifier = null) {
	    return $this->view->make('eloquent-disqus::discussion')->with([
		    'shortname' => $this->getConfig('app.shortname'),
		    'category' => $this->getConfig('app.category'),
		    'title' => $title,
		    'url' => $url,
		    'identifier' => $identifier,
	    ]);
    }

	/**
	 * Init javascript code for comments counter
	 * @return mixed
	 */
	public function initCounter() {
		return $this->view->make('eloquent-disqus::counter')->with([
				'shortname'  => $this->getConfig('app.shortname'),
			]
		);
	}

	/**
	 * Get span element with comments count
	 * @param $url
	 * @param array $attributes
	 * @param null $identifier - disqu`s thread identifier
	 *
	 * @return string
	 */
	public function counter($url, $attributes = array(), $identifier = null) {
		$dataAttr = 'data-disqus-url="'. $url.'"';
		$attributes['class'] = array_get($attributes, 'class') . ' ' . 'disqus-comment-count';
		$attributes = \HTML::attributes($attributes);

		if ($identifier !== null) {
			$dataAttr = 'data-disqus-identifier="'.$url.'"';
		}

		return '<span '.$dataAttr.' '.$attributes.'>' . $this->getConfig('html.default_counter') . '</span>';
	}

	/**
	 * Generate a HTML link with comments counter.
	 *
	 * @param string $url
	 * @param array $attributes
	 * @param null $identifier - disqu`s thread identifier
	 * @param bool $secure
	 *
	 * @return string
	 * @static
	 */
	public function counterLink($url, $attributes = array(), $identifier = null, $secure = null) {
		if ($identifier === null) {
			$attributes['data-disqus-url'] = $url;
		}
		else {
			$attributes['data-disqus-identifier'] = $identifier;
		}

		return \HTML::link($url, $this->getConfig('html.default_counter'), $attributes, $secure);
	}

	/**
	 * Generate a HTML link to a controller action with comments counter.
	 *
	 * @param string $action
	 * @param array $parameters
	 * @param array $attributes
	 * @param null $identifier - disqu`s thread identifier
	 *
	 * @return string
	 * @static
	 */
	public function counterLinkAction($action, $parameters = array(), $attributes = array(), $identifier = null) {
		$url = \URL::action($action, $parameters);
		if ($identifier === null) {
			$attributes['data-disqus-url'] = $url;
		}
		else {
			$attributes['data-disqus-identifier'] = $identifier;
		}

		return \Html::linkAction($action, $this->getConfig('html.default_counter'), $parameters, $attributes);
	}

	/**
	 * Generate a HTML link to a named route with comments counter.
	 *
	 * @param string $name
	 * @param array $parameters
	 * @param array $attributes
	 * @param null $identifier - disqu`s thread identifier
	 *
	 * @return string
	 * @static
	 */
	public function counterLinkRoute($name, $parameters = array(), $attributes = array(), $identifier = null) {
		$url = \URL::route($name, $parameters);
		if ($identifier === null) {
			$attributes['data-disqus-url'] = $url;
		}
		else {
			$attributes['data-disqus-identifier'] = $identifier;
		}

		return \Html::linkRoute($name, $this->getConfig('html.default_counter'), $parameters, $attributes);
	}

}
