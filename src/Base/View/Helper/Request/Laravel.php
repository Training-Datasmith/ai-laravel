<?php

declare (strict_types=1);
/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2026
 * @package Base
 * @subpackage View
 */
namespace Aimeos\Base\View\Helper\Request;

/**
 * View helper class for retrieving request data.
 *
 * @package Base
 * @subpackage View
 */
class Laravel extends \Aimeos\Base\View\Helper\Request\Standard implements \Aimeos\Base\View\Helper\Request\Iface
{
    private \Illuminate\Http\Request $request;
    /**
     * Initializes the request view helper.
     *
     * @param \\Aimeos\Base\View\Iface $view View instance with registered view helpers
     * @param \Illuminate\Http\Request $request Laravel request object
     */
    public function __construct(\Aimeos\Base\View\Iface $view, \Illuminate\Http\Request $request)
    {
        $this->request = $request;
        parent::__construct($view, $this->create_request($request));
    }
    /**
     * Returns the client IP address.
     *
     * @return string Client IP address
     */
    public function get_client_address(): string
    {
        return $this->request->ip();
    }
    /**
     * Returns the current page or route name
     *
     * @return string|null Current page or route name
     */
    public function get_target(): ?string
    {
        if (($route = $this->request->route()) !== null) {
            return $route->get_name();
        }
        return null;
    }
    /**
     * Transforms a Symfony request into a PSR-7 request object
     *
     * @param \Illuminate\Http\Request $nativeRequest Laravel request object
     * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
     */
    protected function create_request(\Illuminate\Http\Request $native_request): \Psr\Http\Message\Server_Request_Interface
    {
        $files = $this->get_files($native_request->files->all());
        $headers = $native_request->headers->all();
        $server = $native_request->server->all();
        $method = $native_request->get_method();
        $uri = $native_request->get_uri();
        $request = new \Nyholm\Psr7\Server_Request($method, $uri, $headers, $native_request->get_content(), '1.1', $server);
        $request = $request->with_cookie_params($native_request->cookies->all())->with_parsed_body($native_request->request->all())->with_query_params($native_request->query->all())->with_uploaded_files($files);
        foreach ($native_request->attributes->all() as $key => $value) {
            $request = $request->with_attribute($key, $value);
        }
        return $request;
    }
    /**
     * Converts Symfony uploaded files array to the PSR-7 one.
     *
     * @param array $files Multi-dimensional list of uploaded files from Symfony request
     * @return array Multi-dimensional list of uploaded files as PSR-7 objects
     */
    protected function get_files(array $files): array
    {
        $list = [];
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
        foreach ($files as $key => $value) {
            if ($value instanceof \Symfony\Component\Http_Foundation\File\Uploaded_File) {
                $list[$key] = $psr17Factory->create_uploaded_file($psr17Factory->create_stream_from_file($value->get_real_path()), $value->get_size(), $value->get_error(), $value->get_client_original_name(), $value->get_client_mime_type());
            } elseif (is_array($value)) {
                $list[$key] = $this->get_files($value);
            }
        }
        return $list;
    }
}