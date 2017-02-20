@extends('layouts.app')

@section('styles')
    <link href="{{ asset('/vendor/im_vk/css/im_vk.css') }}" rel='stylesheet' type='text/css'>
@endsection

@section('content')

    <script type="text/javascript">
        var pusher_key = "{{ env('PUSHER_KEY') }}";
        var pusher_cluster = "{{ env('PUSHER_CLUSTER') }}";
    </script>

    <chat-messages :messages="{{ $messages }}" :for_user="{{ $for_user }}" :from_user="{{ $from_user }}"></chat-messages>

@endsection
