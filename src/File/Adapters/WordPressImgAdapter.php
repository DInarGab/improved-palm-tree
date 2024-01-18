<?

namespace Reaspekt\File\Adapters;

use InvalidArgumentException;
use Reaspekt\File\ImgFile;
use Reaspekt\File\Interfaces\ImgFileInterface;


class WordPressImgAdapter extends ImgFile
{

    private array $wordPressFile;

    public function __construct(array | int $bitrixFile)
    {
        throw new \Exception("Not Implemented");
    }
}