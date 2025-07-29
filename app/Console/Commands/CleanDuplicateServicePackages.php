<?php

namespace App\Console\Commands;

use App\Models\ServicePackage;
use Illuminate\Console\Command;

class CleanDuplicateServicePackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-packages:clean-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean duplicate service packages for the same freelancer and subcategory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to clean duplicate service packages...');

        // Cari semua duplikat
        $duplicates = ServicePackage::select('freelancer_id', 'subcategory_id', 'title')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('MIN(id) as min_id')
            ->groupBy('freelancer_id', 'subcategory_id', 'title')
            ->having('count', '>', 1)
            ->get();

        $totalCleaned = 0;

        foreach ($duplicates as $duplicate) {
            // Hapus duplikat, simpan yang paling awal
            $deleted = ServicePackage::where('freelancer_id', $duplicate->freelancer_id)
                ->where('subcategory_id', $duplicate->subcategory_id)
                ->where('title', $duplicate->title)
                ->where('id', '!=', $duplicate->min_id)
                ->delete();

            $totalCleaned += $deleted;
            $this->info("Cleaned {$deleted} duplicates for freelancer {$duplicate->freelancer_id} in subcategory {$duplicate->subcategory_id}");
        }

        $this->info("Total cleaned: {$totalCleaned} duplicate service packages");
    }
}
