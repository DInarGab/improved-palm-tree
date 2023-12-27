<?


namespace Reaspekt\File\Adapters;

use InvalidArgumentException;
use Reaspekt\File\AbstractImgFile;
/**
 * Use for Bitrix
 */
class BitrixImgAdapter extends AbstractImgFile
{
    private array $bitrixFile;
    
    public function __construct(array | int $bitrixFile)
    {
        if (is_int($bitrixFile) && method_exists("CFile", "GetFileArray")) {
            $this->bitrixFile = \CFile::GetFileArray($bitrixFile);
        } elseif (is_array($bitrixFile) && isset($bitrixFile["SRC"])) {
            $this->bitrixFile = $bitrixFile;
        } else {
            throw new InvalidArgumentException("Argument must be id of image in bitrix system or File Array");
        }
        $this->absolutePath = $_SERVER["DOCUMENT_ROOT"] . (string) $this->bitrixFile["SRC"];
        $this->path = (string) $this->bitrixFile["SRC"];
        $this->width = (int) $this->bitrixFile["WIDTH"];
        $this->height = (int) $this->bitrixFile["HEIGHT"];
        $this->mimeType = $this->bitrixFile["CONTENT_TYPE"];
        $this->fileName = $this->bitrixFile["FILE_NAME"];
    }

}