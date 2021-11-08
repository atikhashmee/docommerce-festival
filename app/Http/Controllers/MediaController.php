<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController
{
    public $basePath = '';
    public $originalPath = '';
    public $file = '';
    public $name = '';
    public $thumbPath = '';
    public $thumb = false;
    public $storageFolder = 'storage/';
    public $imageResize = [];
    public $thumbResize = [300, 300];

    // Common File Upload Function...
    private function upload(): array
    {
        $file = $this->file;
        if ($this->name) {
            $fileName = Str::slug($this->name, '-').'.'.$file->getClientOriginalExtension();
        } else {
            $newName = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            $fileName = time().'-'.Str::slug($newName, '-').'.'.$file->getClientOriginalExtension();
        }
        $data['name'] = $fileName;
        $data['originalName'] = $file->getClientOriginalName();
        $data['size'] = $file->getSize();
        $data['mime_type'] = $file->getMimeType();
        $data['ext'] = $file->getClientOriginalExtension();
        $data['url'] = url($this->storageFolder.$this->originalPath.$data['name']);
        $data['width'] = Image::make($file)->width();
        $data['height'] = Image::make($file)->height();

        //If real image need to resize...
        if (!empty($this->imageResize)) {
            $file = Image::make($file)->resize($this->imageResize[0], $this->imageResize[1]);
            Storage::put($this->originalPath.'/'.$fileName, (string) $file->encode());
        } else {
            Storage::putFileAs($this->originalPath, $file, $data['name']);
        }

        if ($this->thumb) {
            $image = Image::make($this->storageFolder.$this->originalPath.$data['name'])
                ->resize($this->thumbResize[0], $this->thumbResize[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $background = Image::canvas($this->thumbResize[0], $this->thumbResize[1]);
            $background->insert($image, 'center');
            $background->save($this->storageFolder.$this->thumbPath.'/'.$data['name']);
        }
        return $data;
    }

    // Upload Image ("$definePath" and "$definePath/thumb") folder....
    public function imageUpload($requestFile, $path, $thumb = false, $name = null, $imageResize = [], $thumbResize = [300, 300]): array
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath, 0777);
        }

        if (!Storage::exists($realPath.'thumb') && $thumb) {
            Storage::makeDirectory($realPath.'thumb', 0777);
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->thumbPath = $realPath.'thumb';
        $this->thumb = $thumb;
        $this->name = $name;
        $this->imageResize = $imageResize;
        $this->thumbResize = $thumbResize;
        return $this->upload();
    }

    // Upload Image ("$definePath" and "$definePath/thumb") folder....
    public function base64ImageUpload($requestFile, $path, $thumb = false, $name = null, $imageResize = [], $thumbResize = [300, 300]): string
    {
        $extension = explode('/', mime_content_type($requestFile))[1];
        $fileName = uniqid() . ".$extension";
        $fullPath = $path . '/' . $fileName;
        $data = explode(';base64,', $requestFile, 2)[1];
        Storage::put($fullPath, base64_decode($data));

        if ($thumb) {
            if (!Storage::exists($path.'/thumb') && $thumb) {
                Storage::makeDirectory($path.'/thumb', 0777);
            }

            $image = Image::make("storage/$fullPath")
                ->resize($thumbResize[0], $thumbResize[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $background = Image::canvas($thumbResize[0], $thumbResize[1]);
            $background->insert($image, 'center');
            $background->save("storage/$path" . '/thumb/' . $fileName);
        }

        return $fileName;
    }

    // Upload Image ("$definePath" and "$definePath/thumb") folder....
    public function imageUploadFromUrl($requestFile, $path, $thumb = false, $name = null, $imageResize = [], $thumbResize = [300, 300]): string
    {
        $extension = pathinfo($requestFile, PATHINFO_EXTENSION);
        $fileName = uniqid() . ".$extension";
        $fullPath = $path . '/' . $fileName;
        $data = file_get_contents($requestFile);
        Storage::put($fullPath, $data);

        if ($thumb) {
            if (!Storage::exists($path.'/thumb') && $thumb) {
                Storage::makeDirectory($path.'/thumb', 0777);
            }

            $image = Image::make("storage/$fullPath")
                ->resize($thumbResize[0], $thumbResize[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $background = Image::canvas($thumbResize[0], $thumbResize[1]);
            $background->insert($image, 'center');
            $background->save("storage/$path" . '/thumb/' . $fileName);
        }

        return $fileName;
    }

    // Upload Video in "$definePath" folder....
    public function videoUpload($requestFile, $path, $name = null): array
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath, 0777);
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->name = $name;
        return $this->upload();
    }

    // Upload AnyFile in "$definePath" folder....
    public function anyUpload($requestFile, $path, $name = null): array
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath, 0777);
        }

        $this->file = $requestFile;
        $this->originalPath = $realPath;
        $this->name = $name;
        return $this->upload();
    }


    // Upload Content in "$definePath" folder....
    public function contentUpload($content, $path, $name): array
    {
        //Path Create...
        $realPath = $this->basePath.$path.'/';
        if (!Storage::exists($realPath)) {
            Storage::makeDirectory($realPath, 0777);
        }

        Storage::put($name, $content);

        $data['name'] = $name;
        $data['url'] = $path.'/'.$name;
        return $data;
    }

    // Only thumb image create in "$definePath/thumb" folder....
    public function thumb($path, $file, $thumbPath = false, $thumbWidth = 300, $thumbHeight = 300): bool
    {
        $realPath = $this->basePath.$path;
        if (!$thumbPath) {
            $thumbPath = $this->basePath.$path.'/thumb';
        }

        if (!Storage::exists($thumbPath)) {
            Storage::makeDirectory($thumbPath, 0777);
        }

        $image = Image::make($this->storageFolder.$realPath.'/'.$file)
            ->resize($thumbWidth, $thumbHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $background = Image::canvas($thumbWidth, $thumbHeight);
        $background->insert($image, 'center');
        $background->save($this->storageFolder.$thumbPath.'/'.$file);

        if (isset($image->filename)) {
            return true;
        } else {
            return false;
        }
    }

    // Delete file "$definePath" folder....
    public function delete($path, $file, $thumb = false): bool
    {
        $path = $this->basePath.$path.'/';
        if (Storage::exists($path.'/'.$file)) {
            Storage::delete($path.'/'.$file);

            if ($thumb) {
                Storage::delete($path.'/thumb/'.$file);
            }
            return true;
        }
        return false;
    }
}
