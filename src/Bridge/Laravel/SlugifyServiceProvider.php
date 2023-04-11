<?php

/**
 * This file is part of bingogg/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify\Bridge\Laravel;

use Bingogg\Slugify\Slugify;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * SlugifyServiceProvider
 *
 * @package    Bingogg/slugify
 * @subpackage bridge
 * @author     Pavlo Harashchenko <bingogg14@gmail.com>
 * @author     Colin Viebrock
 * @copyright  2012-2014 Pavlo Harashchenko
 * @license    http://www.opensource.org/licenses/MIT The MIT License
 */
class SlugifyServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('slugify', function () {
            return new Slugify();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['slugify'];
    }
}
