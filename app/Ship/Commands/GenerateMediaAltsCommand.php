<?php

namespace App\Ship\Commands;

use App\Ship\Parents\Commands\Command;
use App\Ship\Services\MediaAltGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class GenerateMediaAltsCommand extends Command
{
    protected $signature = 'media:generate-alts {--force : Перезаписать уже заполненные alt}';

    protected $description = 'Generate alt custom properties for Spatie Media images.';

    public function __construct(
        private readonly MediaAltGenerator $mediaAltGenerator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $force = (bool)$this->option('force');
        $updated = 0;
        $skipped = 0;

        Media::query()
            ->where('mime_type', 'like', 'image/%')
            ->with('model')
            ->orderBy('id')
            ->chunkById(100, function ($mediaItems) use ($force, &$updated, &$skipped): void {
                foreach ($mediaItems as $media) {
                    if ($this->mediaAltGenerator->apply($media, $force)) {
                        $updated++;
                    } else {
                        $skipped++;
                    }
                }
            });

        $this->info("Alt generation completed. Updated: {$updated}. Skipped: {$skipped}.");

        return self::SUCCESS;
    }
}
