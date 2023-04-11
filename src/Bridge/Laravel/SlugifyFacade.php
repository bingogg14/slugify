<?php

/**
 * This file is part of bingogg14/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify\Bridge\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * SlugifyFacade
 *
 * @package    bingogg14/slugify
 * @subpackage bridge
 * @author     Pavlo Harashchenko <bingogg14@gmail.com>
 * @copyright  2023 Pavlo Harashchenko
 * @license    http://www.opensource.org/licenses/MIT The MIT License
 */
class SlugifyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'slugify';
    }
}
