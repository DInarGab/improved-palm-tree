<?

namespace Reaspekt\File\Adapters;

use InvalidArgumentException;
use Reaspekt\File\Interfaces\ImgFileInterface;


class WordPressImgAdapter implements ImgFileInterface
{

    private array $wordPressFile;

    public function __construct(array | int $bitrixFile)
    {
        throw new \Exception("Not Implemented");
    }
}