<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Http;
use Statamic\Events\AssetUploaded;

class RemovePlayerBackground
{
    public function handle(AssetUploaded $event): void
    {
        $asset = $event->asset;

        if ($asset->container()->handle() !== 'assets') {
            return;
        }

        if (! str_starts_with($asset->path(), 'spiller/')) {
            return;
        }

        if (! in_array($asset->extension(), ['jpg', 'jpeg', 'png', 'webp'])) {
            return;
        }

        $apiKey = config('services.remove_bg.key');

        if (! $apiKey) {
            return;
        }

        $response = Http::withHeaders(['X-Api-Key' => $apiKey])
            ->attach('image_file', file_get_contents($asset->resolvedPath()), basename($asset->path()))
            ->post('https://api.remove.bg/v1.0/removebg', [
                'size' => 'auto',
            ]);

        if (! $response->successful()) {
            return;
        }

        $newPath = preg_replace('/\.[^.]+$/', '.png', $asset->resolvedPath());
        file_put_contents($newPath, $response->body());

        if ($newPath !== $asset->resolvedPath()) {
            unlink($asset->resolvedPath());
            $asset->path(preg_replace('/\.[^.]+$/', '.png', $asset->path()));
        }

        $asset->save();
    }
}
