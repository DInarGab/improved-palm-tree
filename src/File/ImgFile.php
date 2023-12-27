<?


namespace Reaspekt\File;

use Reaspekt\File\Interfaces\ImgFileInterface;


class ImgFile extends AbstractImgFile
{
    /**
     * Summary of __construct
     * @param mixed $path
     * @param mixed $setAttributes
     * @throws \InvalidArgumentException
     */
    public function __construct($path, $setAttributes = true)
    {
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . $path)) {
            throw new \InvalidArgumentException;
        }
        $this->path = $path;
        $this->fileName = basename($this->path);

        if ($setAttributes) {
            $imageAttributes = getimagesize($this->getAbolutePath());
            $this->width = $imageAttributes[0];
            $this->height = $imageAttributes[1];
            $this->mimeType = $imageAttributes["mime"];
        }
    }
}