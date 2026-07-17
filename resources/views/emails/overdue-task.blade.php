@component('mail::message')
# ⏰ You missed your planned start time!

You planned to start **"{{ $task->title }}"** but it's still pending.

**Planned start:** {{ \Carbon\Carbon::parse($task->start_time)->format('h:i A') }}

@component('mail::button', ['url' => config('app.url') . '/dashboard', 'color' => 'red'])
Go to Dashboard Now →
@endcomponent

Don't let procrastination win. Start now — even 60 seconds is enough!

— {{ config('app.name') }}
@endcomponent