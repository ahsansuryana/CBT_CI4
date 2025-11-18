<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CronjobSchedulesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Daily cleanup jam 12 malam
            [
                'job_name' => 'Daily Cleanup',
                'description' => 'Pembersihan data lama setiap hari jam 00:00',
                'controller_name' => 'App\Controllers\Cronjob',
                'method_name' => 'cleanupCli',
                'parameters' => null,
                'schedule_type' => 'daily',
                'interval_minutes' => null,
                'target_time' => '00:00:00',
                'target_day' => null,
                'specific_datetime' => null,
                'next_run' => date('Y-m-d') . ' 00:00:00',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // Check ujian setiap 5 menit
            [
                'job_name' => 'Check Upcoming Exams',
                'description' => 'Cek ujian yang akan dimulai setiap 5 menit',
                'controller_name' => 'App\Controllers\Cronjob',
                'method_name' => 'checkExamsCli',
                'parameters' => null,
                'schedule_type' => 'interval',
                'interval_minutes' => 5,
                'target_time' => null,
                'target_day' => null,
                'specific_datetime' => null,
                'next_run' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // Send push notification setiap 10 menit
            [
                'job_name' => 'Send Push Notifications',
                'description' => 'Kirim push notification ke subscriber setiap 10 menit',
                'controller_name' => 'App\Controllers\Cronjob',
                'method_name' => 'sendPushCli',
                'parameters' => null,
                'schedule_type' => 'interval',
                'interval_minutes' => 10,
                'target_time' => null,
                'target_day' => null,
                'specific_datetime' => null,
                'next_run' => date('Y-m-d H:i:s'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // Morning reminder jam 8 pagi
            [
                'job_name' => 'Morning Reminder',
                'description' => 'Kirim reminder pagi untuk ujian hari ini',
                'controller_name' => 'App\Controllers\Cronjob',
                'method_name' => 'morningReminderCli',
                'parameters' => null,
                'schedule_type' => 'daily',
                'interval_minutes' => null,
                'target_time' => '08:00:00',
                'target_day' => null,
                'specific_datetime' => null,
                'next_run' => date('Y-m-d') . ' 08:00:00',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // Weekly report setiap Senin jam 9 pagi
            [
                'job_name' => 'Weekly Report',
                'description' => 'Generate dan kirim laporan mingguan setiap hari Senin',
                'controller_name' => 'App\Controllers\Cronjob',
                'method_name' => 'weeklyReportCli',
                'parameters' => null,
                'schedule_type' => 'weekly',
                'interval_minutes' => null,
                'target_time' => '09:00:00',
                'target_day' => 'Monday',
                'specific_datetime' => null,
                'next_run' => date('Y-m-d H:i:s', strtotime('next Monday 09:00:00')),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('cronjob_schedules')->insertBatch($data);

        echo "Cronjob schedules seeded successfully!\n";
    }
}
