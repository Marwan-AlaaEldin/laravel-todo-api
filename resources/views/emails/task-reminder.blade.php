@component('mail::message')

# Task Reminder ⏰

Hello **{{ $task->user->name }}**,

This is a friendly reminder that you have a task due within the next **24 hours**.

---

@component('mail::panel')
## 📌 {{ $task->title }}

{{ $task->description ?? 'No description provided.' }}
@endcomponent

@component('mail::table')
| Detail | Info |
|:--|:--|
| **Priority** | {{ ucfirst($task->priority) }} |
| **Status** | {{ ucfirst(str_replace('_', ' ', $task->status)) }} |
| **Due Date** | {{ \Carbon\Carbon::parse($task->due_date)->format('D, M d Y \a\t h:i A') }} |
| **Category** | {{ $task->category->name ?? 'No Category' }} |
@endcomponent

Please make sure to complete your task on time. Stay productive! 💪

@component('mail::button', ['url' => '', 'color' => 'primary'])
Open Smart Todo
@endcomponent

Best regards,
**{{ config('app.name') }}** Team

@component('mail::subcopy')
You are receiving this email because you have a task due soon in your Smart Todo account.
@endcomponent

@endcomponent