<?php

namespace App\Services;

use File, Image;

class ImageUploader
{
    public static function upload($file, $directory)
    {
        $ext = $file->getClientOriginalExtension();
        $filename = create_filename($ext);

        $base_directory = 'storage/'.$directory.'/'.date('Ymd');
        $thumbnail_directory = "{$base_directory}/thumbnails";
        $resized_directory = "{$base_directory}/resized";

        // check if file uploaded is an image.
        // if not matched, return an empty array.
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = 'File format not supperted.';
        }

        if (count($errors ?? [])) {
            return $errors[0];
        }

        if (! File::exists($base_directory)) {
            File::makeDirectory($base_directory, $mode = 0777, true, true);
        }

        if (! File::exists($resized_directory)) {
            File::makeDirectory($resized_directory, $mode = 0777, true, true);
        }

        if (! File::exists($thumbnail_directory)) {
            File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
        }

        $path = $file->move($base_directory, $filename);

        Image::make("{$base_directory}/{$filename}")
            ->fit(500, null, function ($constraint) {
                $constraint->upsize();
            })
            ->save("{$resized_directory}/{$filename}", 95);

        Image::make("{$base_directory}/{$filename}")
            ->fit(500, null, function ($constraint) {
                $constraint->upsize();
            })
            ->crop(350, 350)
            ->save("{$thumbnail_directory}/{$filename}", 95);

        return [
            'path' => url($path),
            'directory' => $base_directory,
            'filename' => $filename
        ];
    }
}