<?php

/**
 * This file is part of Bingogg/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify\Tests\Bridge\Laravel;

use Bingogg\Slugify\Bridge\Laravel\SlugifyServiceProvider;
use Illuminate\Foundation\Application;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * SlugifyServiceProviderTest
 *
 * @category   test
 * @package    Bingogg/slugify
 * @subpackage bridge
 * @author     Pavlo Harashchenko <bingogg14@gmail.com>
 * @author     Colin Viebrock
 * @copyright  2012-2014 Pavlo Harashchenko
 * @license    http://www.opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class SlugifyProviderTest extends MockeryTestCase
{
    /** @var Application */
    private $app;

    /** @var SlugifyServiceProvider */
    private $provider;

    protected function setUp(): void
    {
        $this->app = new Application();
        $this->provider = new SlugifyServiceProvider($this->app);
    }

    /**
     * @covers \Bingogg\Slugify\Bridge\Laravel\SlugifyServiceProvider::register()
     */
    public function testRegisterRegistersTheServiceProvider()
    {
        $this->provider->register();

        // the service provider is deferred, so this forces it to load
        $this->app->make('slugify');

        $this->assertArrayHasKey('slugify', $this->app);
        $this->assertInstanceOf('Bingogg\Slugify\Slugify', $this->app['slugify']);
    }

    /**
     * @covers \Bingogg\Slugify\Bridge\Laravel\SlugifyServiceProvider::provides()
     */
    public function testContainsReturnsTheNameOfThProvider()
    {
        $this->assertContains('slugify', $this->provider->provides());
    }
}
