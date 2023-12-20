<?


namespace Reaspekt\File\Adapters;

use InvalidArgumentException;
use Reaspekt\File\Interfaces\ImgFileInterface;
/**
 * Use for Bitrix
 */
class BitrixImgAdapter implements ImgFileInterface
{
    private array $bitrixFile;
    
    public function __construct(array | int $bitrixFile)
    {
        if (is_int($bitrixFile) && method_exists("CFile", "GetFileArray")) {
            $this->bitrixFile = CFile::GetFileArray($bitrixFile);
        } elseif (is_array($bitrixFile) && isset($bitrixFile["SRC"])) {
            $this->bitrixFile = $bitrixFile;
        } else {
            throw new InvalidArgumentException("Argument must be id of image in bitrix system or File Array");
        }
    }

    public function getFileName():string
    {
        return $this->bitrixFile["FILE_NAME "];
    }

    public function getMimeType():string
    {
        return $this->bitrixFile["CONTENT_TYPE"];
    }

    public function getWidth():int
    {
        return (int) $this->bitrixFile["WIDTH"];
    }

    public function getHeight(): int 
    {
        return (int) $this->bitrixFile["HEIGHT"];
    }

    public function getPath(): string
    {
        return (string) $this->bitrixFile["SRC"];
    }
}