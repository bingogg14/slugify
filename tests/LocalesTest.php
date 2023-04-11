<?php

/**
 * This file is part of Bingogg/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify\Tests;

use Bingogg\Slugify\Slugify;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * SlugifyTest
 *
 * @category  test
 * @package   org.Bingogg.slugify
 * @author    Pavlo Harashchenko <bingogg14@gmail.com>
 * @author    Ivo Bathke <ivo.bathke@gmail.com>
 * @author    Marchenko Alexandr
 * @copyright 2012-2014 Pavlo Harashchenko
 * @license   http://www.opensource.org/licenses/MIT The MIT License
 */
class LocalesTest extends MockeryTestCase
{
    /**
     * @var Slugify
     */
    private $slugify;

    /**
     * @var \Bingogg\Slugify\RuleProvider\RuleProviderInterface|\Mockery\MockInterface
     */
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Mockery::mock('\Bingogg\Slugify\RuleProvider\RuleProviderInterface');
        $this->provider->shouldReceive('getRules')->andReturn([]);

        $this->slugify = new Slugify([], $this->provider);
    }

    public function testReplaceWhitespacesWithReplacement()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar-baz', $slugify->slugify('foo bar baz'));
        $this->assertSame('foo_bar_baz', $slugify->slugify('foo bar baz', ['replacement' => '_']));
    }

    public function testRemoveDuplicatesOfTheReplacementCharacter()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar', $slugify->slugify('foo , bar'));
    }

    public function testRemoveTrailingSpaceIfAny()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar-baz', $slugify->slugify(' foo bar baz '));
    }

    public function testRemoveNotAllowedChars()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar-baz', $slugify->slugify('foo, bar baz'));
        $this->assertSame('foo-bar-baz', $slugify->slugify('foo- bar baz'));
        $this->assertSame('foo-bar-baz', $slugify->slugify('foo] bar baz'));
        $this->assertSame('foo-bar-baz', $slugify->slugify('foo  bar--baz'));
    }

    public function testLeaveAllowedChars()
    {
        $slugify = new Slugify();

        $allowed = ['*', '+', '~', '.', '(', ')', '\'', '"', '!', ':', '@'];
        foreach ($allowed as $symbol) {
            $this->assertSame('foo-'.$symbol.'-bar-baz', $slugify->slugify('foo '.$symbol.' bar baz'));
        }
    }

    public function testOptionsReplacement()
    {
        $slugify = new Slugify();

        $this->assertSame('foo_bar_baz', $slugify->slugify('foo bar baz', ['replacement' => '_']));
    }

    public function testOptionsReplacementEmptyString()
    {
        $slugify = new Slugify();

        $this->assertSame('foobarbaz', $slugify->slugify('foo bar baz', ['replacement' => '']));
    }

    // //    public function testOptionsRemove() {}

}
