@extends('layouts.app')

@section('content')
    @forelse($ims as $im)
        @if($im->messages->last()->pm_read == 'no' && $im->messages->last()->folder == 'inbox')
            @php($cls = 'yellow lighten-3')
        @else
            @php($cls = 'grey lighten-5 z-depth-1')
        @endif
        <div class="row">
            <div class="card-panel col m8 offset-m2 {{ $cls }}">
                <div class="valign-wrapper" style="padding: 10px;">
                    <a href="/im/{{ $im->im_user_id }}" class="col m12">
                        <div class="col s2">
                            <img src="/uploads/avatars/{{ $im->user->first()->image }}" alt="" class="circle responsive-img">
                        </div>
                        @if($im->messages->last()->pm_read == 'no' && $im->messages->last()->folder == 'outbox')
                            @php($cls2 = 'yellow lighten-3')
                        @else
                            @php($cls2 = '')
                        @endif
                        <div class="col s10 {{ $cls2 }}" style="padding: 10px;">
                            <div class="row">
                                <div class="col m12 name">
                                    {{ $im->user->first()->first_name }} {{ $im->user->first()->last_name }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m12 black-text">
                                    @if($im->messages->last()->folder == 'outbox')
                                        <div class="col m1"><img src="/uploads/avatars/{{ $im->user->first()->image }}" alt="" class="circle responsive-img"></div> <div class="col m11"> {{ $im->messages->last()->text }}</div>
                                    @else
                                        {{ $im->messages->last()->text }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="row">
            <div class="card-panel grey lighten-5 z-depth-1 col m8 offset-m2">
                <div class="valign-wrapper" style="padding: 30px 10px;">
                    Нічого не знайдено
                </div>
            </div>
        </div>
    @endforelse

@endsection