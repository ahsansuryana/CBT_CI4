<?php

namespace App\Models;

use CodeIgniter\Model;

class CronjobScheduleModel extends Model
{
    protected $table = 'cronjob_schedules';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'job_name',
        'description',
        'controller_name',
        'method_name',
        'parameters',
        'schedule_type',
        'interval_minutes',
        'target_time',
        'target_day',
        'specific_datetime',
        'next_run',
        'is_active',
        'created_by'
    ];

    /**
     * Tambah schedule baru
     */
    public function addSchedule($data)
    {
        // Hitung next_run pertama kali
        $data['next_run'] = $this->calculateFirstRun($data);

        return $this->insert($data);
    }

    /**
     * Hitung kapan first run
     */
    private function calculateFirstRun($data)
    {
        $now = new \DateTime();

        switch ($data['schedule_type']) {
            case 'once':
                return $data['specific_datetime'] ?? date('Y-m-d H:i:s');

            case 'interval':
                // Langsung jalan sekarang atau tunggu interval?
                // Opsi 1: Langsung jalan
                return date('Y-m-d H:i:s');

                // Opsi 2: Tunggu interval
                // $minutes = (int)$data['interval_minutes'];
                // return $now->modify("+{$minutes} minutes")->format('Y-m-d H:i:s');

            case 'daily':
                $targetTime = $data['target_time'];
                $today = date('Y-m-d') . ' ' . $targetTime;

                // Jika hari ini belum lewat, jalankan hari ini
                if (strtotime($today) > time()) {
                    return $today;
                }
                // Jika sudah lewat, jalankan besok
                return date('Y-m-d', strtotime('tomorrow')) . ' ' . $targetTime;

            case 'weekly':
                $targetDay = $data['target_day'];
                $targetTime = $data['target_time'];
                $nextRun = new \DateTime('next ' . $targetDay . ' ' . $targetTime);
                return $nextRun->format('Y-m-d H:i:s');

            case 'specific':
                return $data['specific_datetime'];

            default:
                return date('Y-m-d H:i:s');
        }
    }

    /**
     * Get active schedules yang ready to run
     */
    public function getReadySchedules()
    {
        return $this->where('is_active', 1)
            ->where('next_run <=', date('Y-m-d H:i:s'))
            ->findAll();
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $schedule = $this->find($id);
        if (!$schedule) return false;

        return $this->update($id, [
            'is_active' => !$schedule['is_active']
        ]);
    }
}
