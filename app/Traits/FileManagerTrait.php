<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

trait FileManagerTrait
{
    // public $storage =  config('filesystems.disk.default') ?? 'public';

    protected function uploadFile(string $dir, $image = null): string
    {
        $storage = config('filesystems.disk.default') ?? 'public';

        if (!is_null($image)) {
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $image->getClientOriginalExtension;

            if (!$this->checkFileExists($dir)['status']) {
                Storage::disk($storage)->makeDirectory($dir);
            }

            Storage::disk($storage)->put($dir . $imageName, file_get_contents($image));

            return $imageName;
        }

        return 'def.png';
    }

    protected function updateFile(string $dir, $oldImage, $image = null): string
    {
        $storage = $this->storage;
        if (!$this->checkFileExists(filePath: $dir . $oldImage)['status']) {

            Storage::disk($this->checkFileExists(filePath: $dir . $oldImage)['disk'])->delete($dir . $oldImage);
        }
        return $this->uploadFile(dir: $dir, image: $image);
    }

    protected function deleteFile(string $filePath): array
    {
        if (!$this->checkFileExists(filePath: $filePath)['status']) {

            Storage::disk($this->checkFileExists(filePath: $filePath)['disk'])->delete($filePath);
        }
        return [
            'status' => 1,
            'message' => 'Deleted'
        ];
    }

    private function checkFileExists(string $filePath): array
    {
        if (Storage::disk('public')->exists($filePath)) {
            return [
                'status' => true,
                'disk' => 'public'
            ];
        } elseif (config('filesystems.disks.default') == 's3' && Storage::disk('s3')->exists($filePath)) {
            return [
                'status' => true,
                'disk' => 's3'
            ];
        } else {
            return [
                'status' => false,
                'disk' => config('filesystems.disks.default') ?? 'public'
            ];
        }
    }
}
