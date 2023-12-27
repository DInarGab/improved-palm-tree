<?


namespace Reaspekt\File;

use Reaspekt\File\Interfaces\ImgFileInterface;


class AbstractImgFile implements ImgFileInterface
{
    protected string $fileName;
    protected string $path;
    protected int $width;
    protected int $height;
    protected string $mimeType;
    
    /**
     * @return mixed
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return mixed
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

    public function getAbolutePath()
    {
        return $_SERVER["DOCUMENT_ROOT"] . $this->path;
    }
}