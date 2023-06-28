@extends('app')

@section('content')


    @foreach ($template->week_schedule as $day => $time_ranges)
        <div class='d-flex align-items-center justify-content-between mt-40 mb-20'>
            <h4>
                 {{ \App\Enums\WeekDaysEnum::getWeekDay($day) }}
                 {{ \App\Enums\WeekDaysEnum::getWeekDayDate($day) }}
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
                        @foreach ($time_ranges as $time_range)
                            @if (!empty($template->standPublishers->toArray()))
                            @php
                                $key = $day . '_' . $time_range;
                                $standPublishers = $template->standPublishers[$key] ?? null;
                            @endphp
                                    @if(
                                        isset($standPublishers->user, $standPublishers->user2)
                                        && $standPublishers->day === $day
                                    )
                                    <tr>
                                        <th>{{ $time_range }}</th>
                                        <th>{{$standPublishers->user->name}}</th>
                                        <th>{{$standPublishers->user2->name}}</th>
                                        <th>-</th>
                                        <th>-</th>
                                    </tr>
                                    @elseif((isset($standPublishers->user) || isset($standPublishers->user2)) && $standPublishers->day === $day)
                                    <tr>
                                        <th>{{ $time_range }}</th>
                                        <th>{{$standPublishers->user?->name}}</th>
                                        <th>{{$standPublishers->user2?->name}}</th>
                                        <th>-</th>
                                        <th>-</th>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>{{ $time_range }}</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                    </tr>
                                    @endif
                            @else
                                <tr>
                                    <th>{{ $time_range }}</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
    @endforeach

@endsection
