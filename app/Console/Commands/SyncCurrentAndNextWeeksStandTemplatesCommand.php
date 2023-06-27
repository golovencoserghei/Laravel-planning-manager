<?php

namespace App\Console\Commands;

use App\Enums\WeekStatusesEnum;
use App\Models\StandPublishers;
use App\Models\StandTemplate;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncCurrentAndNextWeeksStandTemplatesCommand extends Command
{
    protected $signature = 'stand:sync-stand-template-weeks';

    protected $description = 'Command for syncing current and next week template data every end of the week';

    public function handle(): void
    {
        $isDaysOrTimesRangeChanged = false;

        // @todo - test it with many stands/congregations
        $standTemplatesForTheNextWeekQuery = StandTemplate::query()
            ->select(['id', 'days', 'times_range', 'stand_id', 'congregation_id'])
            ->where('type', WeekStatusesEnum::NEXT->value)
            ->groupBy(['stand_id', 'congregation_id']);

        $currentWeekTeplatesIdsToUpdate = [];
        $standPublishersFromCurrentWeekToRemove = [];
        foreach($standTemplatesForTheNextWeekQuery->get() as $standTemplateForTheNextWeek) {
            $standTemplateForTheCurrentWeek = StandTemplate::query()
                ->select(['id', 'days', 'times_range', 'type'])
                ->where([
                    'stand_id' => $standTemplateForTheNextWeek->stand_id,
                    'congregation_id' => $standTemplateForTheNextWeek->congregation_id,
                    'type' => WeekStatusesEnum::CURRENT->value,
                ])
                ->with('standPublishers')
                ->first();

            if ($standTemplateForTheCurrentWeek->days !== $standTemplateForTheNextWeek->days) {
                $standTemplateForTheCurrentWeek->days = $standTemplateForTheNextWeek->days;

                $isDaysOrTimesRangeChanged = true;
            }

            if ($standTemplateForTheCurrentWeek->times_range !== $standTemplateForTheNextWeek->times_range) {
                $standTemplateForTheCurrentWeek->times_range = $standTemplateForTheNextWeek->times_range;

                $isDaysOrTimesRangeChanged = true;
            }

            if ($isDaysOrTimesRangeChanged) {
                $standTemplateForTheCurrentWeek->save();
            }

            $standPublishersFromCurrentWeekToRemove[] = $standTemplateForTheCurrentWeek->standPublishers->pluck('id')->all();

            $currentWeekTeplatesIdsToUpdate[] = $standTemplateForTheCurrentWeek->id;
        }

        // @todo - add removing publishers records or saving them in reports? or move in logs
        $standPublishersToRemove = array_merge([], ...$standPublishersFromCurrentWeekToRemove);

        DB::beginTransaction();
        try {
            $standTemplatesForTheNextWeekQuery->update(['type' => WeekStatusesEnum::CURRENT->value]);

            StandTemplate::query()->whereIn('id', $currentWeekTeplatesIdsToUpdate)->update(['type' => WeekStatusesEnum::NEXT->value]);
            StandPublishers::query()->whereIn('id', $standPublishersToRemove)->delete();

            DB::commit();
        } catch (Exception $exception) {
            Log::critical('[Stand Templates Sync error]', [
                'category' => __CLASS__,
                'exception' => $exception->getMessage(),
                'trace' => $exception,
            ]);

            DB::rollBack();
        }
    }
}
