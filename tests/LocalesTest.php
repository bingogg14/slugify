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
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * LocalesTest
 *
 * @category  test
 * @package   bingogg14/slugify
 * @author    Pavlo Harashchenko <bingogg14@gmail.com>
 * @copyright 2023 Pavlo Harashchenko
 * @license   http://www.opensource.org/licenses/MIT The MIT License
 */
class LocalesTest extends MockeryTestCase
{
    public function testBgBulgarian()
    {
        $slugify = new Slugify();

        $alphabet = 'А а, Б б, В в, Г г, Д д, Е е, Ж ж, З з, И и, Й й, ' .
            'К к, Л л, М м, Н н, О о, П п, Р р, С с, Т т, У у, ' .
            'Ф ф, Х х, Ц ц, Ч ч, Ш ш, Щ щ, Ъ ъ, ѝ ь, Ю ю, Я я';

        $this->assertSame('A-a-B-b-V-v-G-g-D-d-E-e-Zh-zh-Z-z-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-C-c-Ch-ch-Sh-sh-Sh-sh-U-u-u-Yu-yu-Ya-ya', $slugify->slugify($alphabet));
    }

    public function testSrCSerbianCyrillic()
    {
        $slugify = new Slugify();

        $alphabet = 'А а, Б б, В в, Г г, Д д, Ђ ђ, Е е, Ж ж, З з, И и, ' .
            'Ј ј, К к, Л л, Љ љ, М м, Н н, Њ њ, О о, П п, Р р, ' .
            'С с, Т т, Ћ ћ, У у, Ф ф, Х х, Ц ц, Ч ч, Џ џ, Ш ш';

        $this->assertSame('A-a-B-b-V-v-G-g-D-d-DJ-dj-E-e-Zh-zh-Z-z-I-i-J-j-K-k-L-l-LJ-lj-M-m-N-n-NJ-nj-O-o-P-p-R-r-S-s-T-t-C-c-U-u-F-f-H-h-C-c-Ch-ch-DZ-dz-Sh-sh', $slugify->slugify($alphabet));

    }

    public function testSrLSerbianLatin()
    {
        $slugify = new Slugify();

        $alphabet = 'A a, B b, V v, G g, D d, Đ đ, E e, Ž ž, Z z, I i, ' .
            'J j, K k, L l, Lj lj, M m, N n, Nj nj, O o, P p, R r, ' .
            'S s, T t, Ć ć, U u, F f, H h, C c, Č č, Dž dž, Š š';

        $this->assertSame('A-a-B-b-V-v-G-g-D-d-DJ-dj-E-e-Z-z-Z-z-I-i-J-j-K-k-L-l-Lj-lj-M-m-N-n-Nj-nj-O-o-P-p-R-r-S-s-T-t-C-c-U-u-F-f-H-h-C-c-C-c-Dz-dz-S-s', $slugify->slugify($alphabet));
    }

    public function testTrTurkish()
    {
        $slugify = new Slugify();

        $alphabet = 'A a, B b, C c, Ç ç, D d, E e, F f, G g, Ğ ğ, H h, ' .
            'I ı, İ i, J j, K k, L l, M m, N n, O o, Ö ö, P p, ' .
            'R r, S s, Ş ş, T t, U u, Ü ü, V v, Y y, Z z';

        $this->assertSame('A-a-B-b-C-c-C-c-D-d-E-e-F-f-G-g-G-g-H-h-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-O-o-P-p-R-r-S-s-S-s-T-t-U-u-U-u-V-v-Y-y-Z-z', $slugify->slugify($alphabet));
    }

    public function testKaGeorgian()
    {
        $slugify = new Slugify();

        $alphabet = 'ა, ბ, გ, დ, ე, ვ, ზ, თ, ი, კ, ლ, ' .
            'მ, ნ, ო, პ, ჟ, რ, ს, ტ, უ, ფ, ქ, ' .
            'ღ, ყ, შ, ჩ, ც, ძ, წ, ჭ, ხ, ჯ, ჰ';

        $this->assertSame('a-b-g-d-e-v-z-t-i-k-l-m-n-o-p-zh-r-s-t-u-f-k-gh-q-sh-ch-ts-dz-ts-ch-kh-j-h', $slugify->slugify($alphabet));

    }

    public function testKkKazakhCyrillic()
    {
        $slugify = new Slugify();

        $alphabet = 'Ә ә, Ғ ғ, Қ қ, Ң ң, Ү ү, Ұ ұ, Һ һ, Ө ө';

        $this->assertSame('AE-ae-GH-gh-KH-kh-NG-ng-UE-ue-U-u-H-h-OE-oe', $slugify->slugify($alphabet));

    }

    public function testViVietnamese()
    {
        $slugify = new Slugify();

        $alphabet = 'Đ đ';

        $this->assertSame('DJ-dj', $slugify->slugify($alphabet));
        $this->assertSame('D-d', $slugify->slugify($alphabet, ['locale' => 'vi']));
    }


    public function testDeGerman()
    {
        $slugify = new Slugify();

        $alphabet = 'Ä ä Ö ö Ü ü';

        $this->assertSame('A-a-O-o-U-u', $slugify->slugify($alphabet));
        $this->assertSame('AE-ae-OE-oe-UE-ue', $slugify->slugify($alphabet, ['locale' => 'de']));

    }
}
