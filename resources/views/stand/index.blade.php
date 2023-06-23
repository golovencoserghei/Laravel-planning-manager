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
                            @if (!empty($template->standPublishers->toArray()))
                            @php
                                $standPublishers = $template->standPublishers[$time_range] ?? null;
                            @endphp
                                    @if(isset($standPublishers->user, $standPublishers->user2))
                                    <tr>
                                        <th>{{ $time_range }}</th>
                                        <th>{{$standPublishers->user->name}}</th>
                                        <th>{{$standPublishers->user2->name}}</th>
                                        <th>-</th>
                                        <th>-</th>    
                                    </tr>
                                    @elseif(isset($standPublishers->user) || isset($standPublishers->user2))
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
