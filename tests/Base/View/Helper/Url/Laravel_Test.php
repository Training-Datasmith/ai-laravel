<?php

declare(strict_types=1);

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2026
 */

namespace Aimeos\Base\View\Helper\Url;

class LaravelTest extends \PHPUnit\Framework\TestCase
{
    private $object;
    private $mock;

    protected function setUp(): void
    {
        if (!class_exists('\\Illuminate\\Routing\\UrlGenerator')) {
            $this->markTestSkipped('\\Illuminate\\Routing\\UrlGenerator is not available');
        }

        $view = new \Aimeos\Base\View\Standard();
        $this->mock = $this->getMockBuilder('\\Illuminate\\Routing\\UrlGenerator')
            ->disableOriginalConstructor()->getMock();

        $this->object = new \Aimeos\Base\View\Helper\Url\Laravel($view, $this->mock, []);
    }

    protected function tearDown(): void
    {
        unset($this->object, $this->mock);
    }

    public function testTransform()
    {
        $this->mock->expects($this->once())->method('route')
            ->with($this->equalTo('route'), $this->equalTo([ 'key' => 'value' ]), $this->equalTo(false));

        $this->object->transform('route', 'catalog', 'lists', [ 'key' => 'value' ]);
    }

    public function testTransformAbsolute()
    {
        $this->mock->expects($this->once())->method('route')
            ->with($this->equalTo('route'), $this->equalTo([]), $this->equalTo(true));

        $options = [ 'absoluteUri' => true ];
        $this->object->transform('route', 'catalog', 'lists', [], [], $options);
    }
}
