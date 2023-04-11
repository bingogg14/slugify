<?php

/**
 * This file is part of bingogg14/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify;

/**
 * SlugifyInterface
 *
 * @package   bingogg14/slugify
 * @author    Pavlo Harashchenko <bingogg14@gmail.com>
 * @copyright 2012-2014 Pavlo Harashchenko
 * @license   http://www.opensource.org/licenses/MIT The MIT License
 */
interface SlugifyInterface
{
    /**
     * Return a URL safe version of a string.
     *
     * @param string            $string
     * @param string|array|null $options
     *
     * @return string
     *
     * @api
     */
    public function slugify($string, $options = null);
}
