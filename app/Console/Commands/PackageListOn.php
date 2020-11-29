<?php

namespace App\Console\Commands;

use App\Enums\PackageEnum;
use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Console\Command;

class PackageListOn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voc-package:list-on';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Package list_on_datetime to set list_status to 0';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param PackageRepository $repository
     *
     * @return int
     */
    public function handle(PackageRepository $repository)
    {
        // 未上架，上架时间在5分钟内的统一处理
        $packageWaitToExecute = $repository->newQuery()
            ->where('list_status', PackageEnum::LIST_STATUS_DISABLED)
            ->whereNotNull('list_on_datetime')
            ->where('list_on_datetime', '<', now()->toDateTimeString())
            ->where('list_on_datetime', '>', now()->subMinutes(5)->toDateTimeString())
            ->get();
        ;

        if ($packageWaitToExecute->isNotEmpty()) {
            /** @var Package $item */
            foreach ($packageWaitToExecute as $item) {
                $item->setAttribute('list_status', PackageEnum::LIST_STATUS_NORMAL);
                $item->save();
            }
        }

        return 0;
    }
}
