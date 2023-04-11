<?php

/**
 * This file is part of Bingogg/slugify.
 *
 * (c) Pavlo Harashchenko <bingogg14@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bingogg\Slugify;

use Bingogg\Slugify\SlugifyInterface;
use Normalizer;
use function Symfony\Component\Translation\t;

/**
 * Slugify
 *
 * @package   Bingogg\Slugify
 * @author    Pavlo Harashchenko <bingogg14@gmail.com>
 * @author    Ivo Bathke <ivo.bathke@gmail.com>
 * @author    Marchenko Alexandr
 * @copyright 2012-2015 Pavlo Harashchenko
 * @license   http://www.opensource.org/licenses/MIT The MIT License
 */
class Slugify implements SlugifyInterface
{
    /**
     * @var array<string,string>
     */
    protected $rules = [];

    /**
     * @var array<string,mixed>
     */
    protected $options = [
        'replacement' => '-',  // replace spaces with replacement character, defaults to `-`
        'remove' => null,      // remove characters that match regex, defaults to `undefined`
        'lower' => false,      // convert to lower case, defaults to `false`
        'strict' => false,     // strip special characters except replacement, defaults to `false`
        'locale' => null,      // language code of the locale to use
        'trim' => true         // trim leading and trailing replacement chars, defaults to `true`
    ];

    /**
     * @param array                 $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Returns the slug-version of the string.
     *
     * @param string            $string  String to slugify
     * @param string|array|null $options Options
     *
     * @return string Slugified version of the string
     */
    public function slugify($string, $options = null)
    {
        $charMap = json_decode(file_get_contents(__DIR__.'/../config/charmap.json'), true);
        $locales = json_decode(file_get_contents(__DIR__.'/../config/locales.json'), true);

        // BC: the second argument used to be the separator
        if (is_string($options)) {
            $replacement            = $options;
            $options                = [];
            $options['replacement'] = $replacement;
            $options['trim']        = true;
        }

        $charMap = array_merge($charMap, $this->rules);
        $options = array_merge($this->options, (array) $options);

        // Add a custom ruleset without touching the default rules
        if (isset($options['locale'])) {
            $locale = $locales[$options['locale']];
        } else {
            $locale = [];
        }

        // Normalize
        $string = $this->str_split_unicode(Normalizer::normalize($string, Normalizer::NFC));
        try {


            $string = array_reduce($string, function ($result, $ch) use ($locale, $options, $charMap) {
                $appendChar = $locale[$ch] ?? null;

                if ($appendChar === null) {
                    $appendChar = $charMap[$ch] ?? null;
                }

                if ($appendChar === null) {
                    $appendChar = $ch;
                }

                if ($appendChar === $options['replacement']) {
                    $appendChar = ' ';
                }

                $stringPart = $result . $appendChar;
                $patternRemove = $options['remove'] ?? '/[^\w\s$*_+~.()\'"!\-:@]+/';

                // remove didn't allow characters
                return $patternRemove ? preg_replace($patternRemove, '', $stringPart): $stringPart;
            });
        } catch (\Exception $exception) {
            dd($exception);
        }

        unset($charMap);
        unset($locale);
        unset($locales);

        if ($options['strict']) {
            $string = preg_replace('/[^A-Za-z0-9\s]/', '', $string);
        }

        if ($options['trim']) {
            $string = trim($string);
        }

        // Replace spaces with replacement character, treating multiple consecutive
        // spaces as a single space.
        $string = preg_replace('/\s+/', $options['replacement'], $string);

        if ($options['lower']) {
            $string = mb_strtolower($string);
        }

        return $string;
    }

    /**
     * Adds a custom rule to Slugify.
     *
     * @param string $character   Character
     * @param string $replacement Replacement character
     *
     * @return Slugify
     */
    public function addRule($character, $replacement)
    {
        $this->rules[$character] = $replacement;

        return $this;
    }

    /**
     * Adds multiple rules to Slugify.
     *
     * @param array <string,string> $rules
     *
     * @return Slugify
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $character => $replacement) {
            $this->addRule($character, $replacement);
        }

        return $this;
    }

    /**
     * Static method to create new instance of {@see Slugify}.
     *
     * @param array <string,mixed> $options
     *
     * @return Slugify
     */
    public static function create(array $options = [])
    {
        return new static($options);
    }

    /**
     * Method for convert string with unicode to array with chars
     *
     * @link https://stackoverflow.com/questions/33054762/str-split-not-working-properly-in-php-when-using-string-with-special-character
     *
     * @param $str
     * @param $l
     * @return array|false|string[]
     */
    private function str_split_unicode($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }

        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}
