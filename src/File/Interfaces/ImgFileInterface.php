<?

namespace Reaspekt\File\Interfaces;


interface ImgFileInterface
{
    public function getFileName(): string;

	public function getPath():string;

	public function getWidth(): int;
	public function getHeight(): int;
	
	public function getMimeType(): string;
}