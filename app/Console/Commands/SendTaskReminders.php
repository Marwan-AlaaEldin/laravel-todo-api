<?php

namespace App\Console\Commands;

use App\Mail\TaskReminderMail;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    /**
     * اسم الـ command اللي هنشغله
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * وصف الـ command
     */
    protected $description = 'Send reminders for tasks due soon';

    public function handle()
    {
        // جيب الـ tasks اللي:
        // 1. due_date خلال 24 ساعة الجاية
        // 2. مش اتبعتلها reminder قبل كده
        // 3. مش مكتملة
        $tasks = Task::where('status', '!=', 'done')
            ->whereNotNull('due_date')
            ->whereNull('reminder_sent_at')
            ->where('due_date', '<=', now()->addHours(24))
            ->where('due_date', '>=', now())
            ->with('user') // جيب الـ user مع الـ task
            ->get();

        foreach ($tasks as $task) {
            // بعت الإيميل
            Mail::to($task->user->email)->send(new TaskReminderMail($task));

            // حفظ وقت إرسال الـ reminder عشان متتبعتش تاني
            $task->update(['reminder_sent_at' => now()]);

            $this->info("Reminder sent for task: {$task->title}");
        }

        $this->info('All reminders sent!');
    }
}