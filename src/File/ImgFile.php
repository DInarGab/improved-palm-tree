<?


namespace Reaspekt\File;
use Reaspekt\File\Interfaces\ImgFileInterface;


class ImgFile implements ImgFileInterface
{
    private string $fileName;
    private string $path;
    private int $width;
    private int $height;
    private string $mimeType;

    private function __construct($path, $setAttributes = true) {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . $path)) {
            throw new \InvalidArgumentException;
        }
        $this->path = $path;
        $this->fileName = basename($this->path);

        if ($setAttributes) {
            $imageAttributes = getimagesize($_SERVER["DOCUMENT_ROOT"] . $this->path);
            $this->width = $imageAttributes[0];
            $this->height = $imageAttributes[1];
            $this->mimeType = $imageAttributes["mime"];
        }
    }
    /**
     * @return mixed
     */
    public function getFileName():string {
        return $this->fileName;
    }

    /**
     * @return mixed
     */
    public function getPath():string {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getWidth():int {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight():int {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getMimeType():string {
        return $this->mimeType;
    }

    /**
     * @param mixed $width
     * @return self
     */
    public function setWidth($width): self {
        if (empty($this->width == null)) {
            $this->width = $width;
        }
        return $this;
    }

    /**
     * @param mixed $height
     * @return self
     */
    public function setHeight($height): self {
        if (empty($this->height)) {
            $this->height = $height;
        }
        return $this;
    }

    /**
     * @param mixed $mimeType
     * @return self
     */
    public function setMimeType($mimeType): self {
        if (empty($this->mimeType)) {
            $this->mimeType = $mimeType;
        }
        return $this;
    }
}