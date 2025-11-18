<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCronjobSchedulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'job_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Controller dan method yang akan dipanggil
            'controller_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'Nama controller dengan namespace lengkap',
            ],
            'method_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'Nama method yang akan dipanggil',
            ],
            'parameters' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'JSON format untuk parameter method',
            ],

            // Tipe schedule
            'schedule_type' => [
                'type' => 'ENUM',
                'constraint' => ['once', 'interval', 'daily', 'weekly', 'specific'],
                'null' => false,
                'comment' => 'Tipe penjadwalan: once, interval, daily, weekly, specific',
            ],

            // Konfigurasi schedule
            'interval_minutes' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'Interval dalam menit (untuk type interval)',
            ],
            'target_time' => [
                'type' => 'TIME',
                'null' => true,
                'comment' => 'Waktu target (untuk type daily/weekly)',
            ],
            'target_day' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'comment' => 'Hari target: Monday-Sunday (untuk weekly)',
            ],
            'specific_datetime' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Tanggal dan waktu spesifik (untuk type specific)',
            ],

            // Runtime info
            'next_run' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu eksekusi berikutnya',
            ],
            'last_run' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Waktu eksekusi terakhir',
            ],
            'last_status' => [
                'type' => 'ENUM',
                'constraint' => ['success', 'failed', 'running'],
                'null' => true,
                'comment' => 'Status eksekusi terakhir',
            ],
            'last_error' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Pesan error terakhir (jika ada)',
            ],
            'last_execution_time' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'comment' => 'Waktu eksekusi dalam detik',
            ],

            // Counters
            'run_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
                'comment' => 'Jumlah eksekusi sukses',
            ],
            'error_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
                'comment' => 'Jumlah error',
            ],

            // Status
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'null' => false,
                'comment' => '1 = aktif, 0 = non-aktif',
            ],

            // Audit
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID user yang membuat schedule',
            ],
        ]);

        // Primary Key
        $this->forge->addKey('id', true);

        // Indexes
        $this->forge->addKey(['next_run', 'is_active'], false, false, 'idx_next_run');
        $this->forge->addKey('is_active', false, false, 'idx_active');

        // Create Table
        $this->forge->createTable('cronjob_schedules', true);
    }

    public function down()
    {
        $this->forge->dropTable('cronjob_schedules', true);
    }
}
