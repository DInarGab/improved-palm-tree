<?

namespace Reaspekt\Resizers;

use Reaspekt\File\Adapters\BitrixImgAdapter;
use Reaspekt\File\ImgFile;

class ResizerBitrix implements ResizerInterface
{
    /**
     * Resizer, uses Bitrix ResizeImgGet method from CFile class
     * @param \Reaspekt\File\ImgFile $imageFile must be BitrixImgAdapter object 
     * @param mixed $width width of returned file
     * @param mixed $height height of returned file
     * @throws \Exception
     * @return ImgFile Resized ImgFile
     */
    public function resize(ImgFile $imageFile, $width, $height)
    {
        if (!method_exists("CFile", "ResizeImageGet")) {
            throw new \Exception("Bitrix Framework not found");
        }
        if (!($imageFile instanceof BitrixImgAdapter)) {
            throw new \Exception("Bitrix Resizer works only with BitrixImgAdapter objects");
        }
        $resizedFile = CFile::ResizeImageGet(
            $imageFile->getBitrixFile(),
            ['width' => $width, 'height' => $height],
            BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
            true
        );
        return new ImgFile($resizedFile['src'], true);
    }
}