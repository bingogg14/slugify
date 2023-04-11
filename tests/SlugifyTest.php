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
class SlugifyTest extends MockeryTestCase
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

    public function testOptionsRemoveRegexWithoutGFlag()
    {
        $slugify = new Slugify();
        $this->assertSame('foo-bar-bar-foo-foo-bar',
            $slugify->slugify('foo bar, bar foo, foo bar', ['remove' => '/[^a-zA-Z0-9 -]/']));
    }

    public function testOptionsLower()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar-baz', $slugify->slugify('Foo bAr baZ', ['lower' => true]));
    }

    public function testOptionsStrict()
    {
        $slugify = new Slugify();

        $this->assertSame('foobar-baz', $slugify->slugify('foo_bar. -@-baz!', ['strict' => true]));
    }

    public function testOptionsStrictRemoveDuplicatesOfTheReplacementCharacter()
    {
        $slugify = new Slugify();

        $this->assertSame('foo-bar', $slugify->slugify('foo @ bar', ['strict' => true]));
    }

    public function testOptionsReplacementAndOptionsStrict()
    {
        $slugify = new Slugify();

        $this->assertSame('foo_barbaz', $slugify->slugify('foo_@_bar-baz!', [
            'replacement' => '_',
            'strict'      => true
        ]));
    }

    public function testReplaceCurrencies()
    {
        $slugify = new Slugify();

        $charMap = [
            '€'  => 'euro', '₢' => 'cruzeiro', '₣' => 'french franc', '£' => 'pound',
            '₤'  => 'lira', '₥' => 'mill', '₦' => 'naira', '₧' => 'peseta', '₨' => 'rupee',
            '₩'  => 'won', '₪' => 'new shequel', '₫' => 'dong', '₭' => 'kip', '₮' => 'tugrik',
            '₸'  => 'kazakhstani tenge',
            '₯'  => 'drachma', '₰' => 'penny', '₱' => 'peso', '₲' => 'guarani', '₳' => 'austral',
            '₴'  => 'hryvnia', '₵' => 'cedi', '¢' => 'cent', '¥' => 'yen', '元' => 'yuan',
            '円' => 'yen', '﷼' => 'rial', '₠' => 'ecu', '¤' => 'currency', '฿' => 'baht',
            '$'  => 'dollar', '₽' => 'russian ruble', '₿' => 'bitcoin', "₺" => "turkish lira"
        ];

        foreach ($charMap as $symbol => $result) {

            $result = str_replace(' ', '-', $result);
            $this->assertSame('foo-' . $result . '-bar-baz', $slugify->slugify('foo '. $symbol .' bar baz'));
        }
    }

    public function testReplaceSymbols()
    {
        $slugify = new Slugify();

        $charMap = [
            '©' => '(c)', 'œ' => 'oe', 'Œ' => 'OE', '∑' => 'sum', '®' => '(r)', '†' => '+',
            '“' => '"', '”' => '"', '‘' => "'", '’' => "'", '∂' => 'd', 'ƒ' => 'f', '™' => 'tm',
            '℠' => 'sm', '…' => '...', '˚' => 'o', 'º' => 'o', 'ª' => 'a', '•' => '*',
            '∆' => 'delta', '∞' => 'infinity', '♥' => 'love', '&' => 'and', '|' => 'or',
            '<' => 'less', '>' => 'greater'
        ];

        foreach ($charMap as $symbol => $result) {
            $this->assertSame('foo-' . $result . '-bar-baz', $slugify->slugify('foo '.$symbol.' bar baz'));
        }
    }

    public function testReplaceCustomCharacters()
    {
        $slugify = new Slugify();

        $slugify->addRule('☢', 'radioactive');

        $this->assertSame('unicode-love-is-radioactive', $slugify->slugify('unicode ♥ is ☢'));
    }

    public function testReplaceCustomCharactersWithoutRules()
    {
        $slugify = new Slugify();

        $this->assertSame('unicode-love-is', $slugify->slugify('unicode ♥ is ☢'));
    }

    public function testConsolidatesRepeatedReplacementCharactersFromExtend()
    {
        $slugify = new Slugify();

        $slugify->addRule('+', '-');
        $this->assertSame('day-night', $slugify->slugify('day + night'));
    }

    public function testNormalize()
    {
        $slugify = new Slugify();
        $slug = urldecode('a%CC%8Aa%CC%88o%CC%88-123'); //åäö-123

        $this->assertSame('aao-123', $slugify->slugify($slug, ['remove' => '/[*+~.()\'"!:@]/']));
    }

    public function replacesLeadingAndTrailingReplacementChars()
    {
        $slugify = new Slugify();

        $this->assertSame('Come-on-fhqwhgads', $slugify->slugify('-Come on, fhqwhgads-'));
    }

    public function testReplacesLeadingAndTrailingReplacementCharsInStrictMode()
    {
        $slugify = new Slugify();

        $this->assertSame('Come-on-fhqwhgads', $slugify->slugify('! Come on, fhqwhgads !', ['strict' => true]));
    }

    public function testShouldPreserveLeadingTrailingReplacementCharactersIfOptionSet()
    {
        $slugify = new Slugify();

        $this->assertSame('-foo-bar-baz-', $slugify->slugify(' foo bar baz ', ['trim' => false]));
    }

    public function ShouldCorrectlyHandleEmptyStringsInCharmaps()
    {
        $slugify = new Slugify();

        $slugify->addRule('ъ', '');

        $this->assertSame('ya', $slugify->slugify('ъяъ'));
        $this->assertSame('ya', $slugify->slugify('ъяъ', ['remove' => '/[]/g']));
    }
}
