<?


namespace Reaspekt\File;

use Reaspekt\File\Interfaces\ImgFileInterface;


class ImgFile implements ImgFileInterface
{
    protected string $fileName;
    protected string $path;
    protected int $width;
    protected int $height;
    protected string $mimeType;

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

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Returns relative Image Path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param mixed $width
     * @return self
     */
    public function setWidth($width): self
    {
        if (empty($this->width == null)) {
            $this->width = $width;
        }
        return $this;
    }

    /**
     * @param mixed $height
     * @return self
     */
    public function setHeight($height): self
    {
        if (empty($this->height)) {
            $this->height = $height;
        }
        return $this;
    }

    /**
     * @param mixed $mimeType
     * @return self
     */
    public function setMimeType($mimeType): self
    {
        if (empty($this->mimeType)) {
            $this->mimeType = $mimeType;
        }
        return $this;
    }
    /**
     * Returns Absolute Image Path
     * @return string
     */
    public function getAbolutePath(): string
    {
        return $_SERVER["DOCUMENT_ROOT"] . $this->path;
    }

}