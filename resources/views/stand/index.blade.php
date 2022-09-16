@extends('app')

@section('content')


    @foreach ($templates as $template)
        <div class='d-flex align-items-center justify-content-between mt-40 mb-20'>
            <h4>
                {{-- fix date week --}}
                 {{ \App\Enums\WeekDaysEnum::getWeekDay($template->day) }} 
                 {{ \App\Enums\WeekDaysEnum::getWeekDayDate($template->day) }}
                <span> "{{ $template->stand->name }}" </span>
            </h4>
          </div>
           
          <div class='card'>
            <div class='card-body pa-0'>
               <div class='table-wrap'>
                 <div class='table-responsive'>
                    <table class='table table-sm table-hover mb-0'>
                        <thead>
                            <tr>
                                <th class='not-sortable'>время</th>
                                <th class='not-sortable'>возвещатель"</th>
                                <th class='not-sortable'>возвещатель"</th>
                                <th class='not-sortable'>отчет</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($template->times_range as $time_range)
                            <tr>
                                <th>{{ $time_range }}</th>
                                @if(isset($template->standPublishers))
                                    @foreach ($template->standPublishers as $record)
                                        @if($record->time === $time_range)
                                            <th>{{ isset($record->user) ? $record->user->name : '-'}}</th>
                                            <th>{{ isset($record->user2) ? $record->user2->name : '-'}}</th>
                                        @endif
                                    @endforeach
                                @else
                                <th>-</th>
                                @endif
                                <th>-</th>
                                <th>-</th>
                                <th>-</th>
                            </tr>
                            @endforeach
                        </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
    @endforeach

@endsection