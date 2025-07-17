@extends('layouts.app')

@section('content')
    <p>This is my body content.</p>
    <livewire:counter />

    <button onclick="handelClick()">sdfsdf</button>
@endsection

@push('scripts')
    <script>
        function handelClick () {
            console.log('1')
            new FilamentNotification()
    .title('Saved successfully')
    .success()
    .body('Changes to the post have been saved.')
    .actions([
        new FilamentNotificationAction('view')
            .button()
            .url('/view')
            .openUrlInNewTab(),
        new FilamentNotificationAction('undo')
            .color('gray'),
    ])
    .send()
        }

    </script>
@endpush
