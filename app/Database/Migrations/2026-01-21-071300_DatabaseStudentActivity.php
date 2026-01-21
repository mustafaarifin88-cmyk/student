<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class DatabaseStudentActivity extends Migration
{
    public function up()
    {
        // Disable Foreign Key Checks sementara agar urutan create table tidak error
        $this->db->disableForeignKeyChecks();

        // --------------------------------------------------------------------
        // 1. Tabel Sekolah
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false, // Sesuai dump (int(11))
                'auto_increment' => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => 'default_logo.png',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sekolah', true);

        // Insert Data Sekolah
        $this->db->table('sekolah')->insert([
            'id' => 1,
            'nama_sekolah' => 'SMA Unggulan',
            'logo' => '1768911447_5cb35e104ab36b660865.png',
            'alamat' => 'Jl. Pendidikan No. 1',
            'updated_at' => '2026-01-20 19:17:27'
        ]);

        // --------------------------------------------------------------------
        // 2. Tabel Users
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'default'    => 'default.png',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'walas', 'siswa'],
                'default'    => 'siswa',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Insert Data Users
        $dataUsers = [
            [
                'id' => 1, 'nama_lengkap' => 'Administrator', 'username' => 'admin', 
                'password' => '$2y$10$nOrn10U7vVZmYMQIiQ30euac4uuHzjHoziyIZ4eG80XqNyLCJPaXO', 
                'foto' => '1768911411_923fab8274485336e34d.png', 'role' => 'admin', 
                'created_at' => '2026-01-19 13:32:07', 'updated_at' => '2026-01-20 12:16:51'
            ],
            [
                'id' => 2, 'nama_lengkap' => 'Ayu Pebri', 'username' => 'guru', 
                'password' => '$2y$10$CR2HtzUJTqPxK2hvpx9b9e1nDdiLQ5bBAPznl3nxKXLYFFIutwoDS', 
                'foto' => '1768964002_e8c21cde6d279aefaaa3.jpeg', 'role' => 'walas', 
                'created_at' => '2026-01-20 12:23:34', 'updated_at' => '2026-01-21 02:53:22'
            ],
            [
                'id' => 3, 'nama_lengkap' => 'Joni Agustin', 'username' => 'siswa', 
                'password' => '$2y$10$c/jsUpb20tAaDsPbKZ9J2.AE/9Bmci8kD4rEm9Cssfpo9FRhn/lNa', 
                'foto' => '1768971565_db74b336d63e29031d4f.jpeg', 'role' => 'siswa', 
                'created_at' => '2026-01-20 13:06:05', 'updated_at' => '2026-01-21 04:59:25'
            ],
            [
                'id' => 4, 'nama_lengkap' => 'Mustafa', 'username' => 'mustafa', 
                'password' => '$2y$10$Hkuq.b6qm/VUSfFWxL4iSOHTYjqo.nxpJQsOTsfNSjyfol7PUqv82', 
                'foto' => 'default.png', 'role' => 'walas', 
                'created_at' => '2026-01-20 13:08:12', 'updated_at' => '2026-01-20 13:08:12'
            ],
            [
                'id' => 5, 'nama_lengkap' => 'Jaya', 'username' => 'siswa2', 
                'password' => '$2y$10$HWau8D7926wtaFjaI/sq2e7aBoC26njyIlamSa/.19QHyLPDMHSeK', 
                'foto' => 'default.png', 'role' => 'siswa', 
                'created_at' => '2026-01-20 13:09:00', 'updated_at' => '2026-01-20 13:09:00'
            ],
            [
                'id' => 6, 'nama_lengkap' => 'Budi Santoso', 'username' => 'siswa3', 
                'password' => '$2y$10$UzRKKlFKIZoSSRdCO0qw4.r6Wf3NJ2mcho2SPTmIhtcCurrodg1Je', 
                'foto' => 'default.png', 'role' => 'siswa', 
                'created_at' => '2026-01-21 04:05:41', 'updated_at' => '2026-01-21 05:00:33'
            ],
        ];
        $this->db->table('users')->insertBatch($dataUsers);

        // --------------------------------------------------------------------
        // 3. Tabel Guru
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guru', true);

        // Insert Data Guru
        $dataGuru = [
            ['id' => 1, 'user_id' => 2, 'nip' => '196603151988022003'],
            ['id' => 2, 'user_id' => 4, 'nip' => '123456'],
        ];
        $this->db->table('guru')->insertBatch($dataGuru);

        // --------------------------------------------------------------------
        // 4. Tabel Kelas
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'wali_kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('wali_kelas_id', 'guru', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('kelas', true);

        // Insert Data Kelas
        $dataKelas = [
            ['id' => 1, 'nama_kelas' => 'X TKJ 1', 'wali_kelas_id' => 1, 'created_at' => '2026-01-20 12:23:12', 'updated_at' => '2026-01-20 12:23:34'],
            ['id' => 2, 'nama_kelas' => 'X IPA 1', 'wali_kelas_id' => 2, 'created_at' => '2026-01-20 13:07:20', 'updated_at' => '2026-01-20 13:25:51'],
            ['id' => 3, 'nama_kelas' => 'X IPAS 1', 'wali_kelas_id' => null, 'created_at' => '2026-01-20 13:07:20', 'updated_at' => '2026-01-20 13:07:20'],
        ];
        $this->db->table('kelas')->insertBatch($dataKelas);

        // --------------------------------------------------------------------
        // 5. Tabel Siswa
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'nisn' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'total_poin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('siswa', true);

        // Insert Data Siswa
        $dataSiswa = [
            ['id' => 1, 'user_id' => 3, 'nisn' => '1234567890', 'kelas_id' => 1, 'total_poin' => 20],
            ['id' => 2, 'user_id' => 5, 'nisn' => '12365128', 'kelas_id' => 1, 'total_poin' => 30],
            ['id' => 3, 'user_id' => 6, 'nisn' => '1234567890', 'kelas_id' => 1, 'total_poin' => 10],
        ];
        $this->db->table('siswa')->insertBatch($dataSiswa);

        // --------------------------------------------------------------------
        // 6. Tabel Kegiatan
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'wali_kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'instruksi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_dibuat' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('wali_kelas_id', 'guru', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kegiatan', true);

        // Insert Data Kegiatan
        $this->db->table('kegiatan')->insert([
            'id' => 1,
            'wali_kelas_id' => 1,
            'judul' => 'Sholat Zuhur Berjamaah',
            'instruksi' => 'Melakukan Sholat Zuhur',
            'tanggal_dibuat' => '2026-01-20 13:57:17'
        ]);

        // --------------------------------------------------------------------
        // 7. Tabel Kriteria Penilaian
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kegiatan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'deskripsi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'poin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kegiatan_id', 'kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kriteria_penilaian', true);

        // Insert Data Kriteria
        $dataKriteria = [
            ['id' => 1, 'kegiatan_id' => 1, 'deskripsi' => 'Tepat Waktu', 'poin' => 10],
            ['id' => 2, 'kegiatan_id' => 1, 'deskripsi' => 'Di Mesjid', 'poin' => 10],
            ['id' => 3, 'kegiatan_id' => 1, 'deskripsi' => 'Berjamaah', 'poin' => 10],
        ];
        $this->db->table('kriteria_penilaian')->insertBatch($dataKriteria);

        // --------------------------------------------------------------------
        // 8. Tabel Log Aktivitas
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kegiatan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total_poin_diperoleh' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'tanggal_dikerjakan' => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null'    => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kegiatan_id', 'kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('siswa_id', 'siswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('log_aktivitas', true);

        // Insert Data Log Aktivitas
        $dataLog = [
            ['id' => 1, 'kegiatan_id' => 1, 'siswa_id' => 1, 'total_poin_diperoleh' => 20, 'tanggal_dikerjakan' => '2026-01-21 04:26:04'],
            ['id' => 2, 'kegiatan_id' => 1, 'siswa_id' => 2, 'total_poin_diperoleh' => 30, 'tanggal_dikerjakan' => '2026-01-21 05:01:02'],
            ['id' => 3, 'kegiatan_id' => 1, 'siswa_id' => 3, 'total_poin_diperoleh' => 10, 'tanggal_dikerjakan' => '2026-01-21 05:01:36'],
        ];
        $this->db->table('log_aktivitas')->insertBatch($dataLog);

        // --------------------------------------------------------------------
        // 9. Tabel Detail Log Aktivitas
        // --------------------------------------------------------------------
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'log_aktivitas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'kriteria_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('log_aktivitas_id', 'log_aktivitas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kriteria_id', 'kriteria_penilaian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_log_aktivitas', true);

        // Insert Data Detail Log
        $dataDetailLog = [
            ['id' => 1, 'log_aktivitas_id' => 1, 'kriteria_id' => 1],
            ['id' => 2, 'log_aktivitas_id' => 1, 'kriteria_id' => 3],
            ['id' => 3, 'log_aktivitas_id' => 2, 'kriteria_id' => 1],
            ['id' => 4, 'log_aktivitas_id' => 2, 'kriteria_id' => 2],
            ['id' => 5, 'log_aktivitas_id' => 2, 'kriteria_id' => 3],
            ['id' => 6, 'log_aktivitas_id' => 3, 'kriteria_id' => 1],
        ];
        $this->db->table('detail_log_aktivitas')->insertBatch($dataDetailLog);

        // Re-enable Foreign Key Checks
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        // Hapus tabel dengan urutan terbalik dari pembuatan untuk menghindari masalah referensi,
        // meskipun disableForeignKeyChecks sudah dipanggil untuk keamanan ekstra.
        $this->forge->dropTable('detail_log_aktivitas', true);
        $this->forge->dropTable('log_aktivitas', true);
        $this->forge->dropTable('kriteria_penilaian', true);
        $this->forge->dropTable('kegiatan', true);
        $this->forge->dropTable('siswa', true);
        $this->forge->dropTable('kelas', true);
        $this->forge->dropTable('guru', true);
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('sekolah', true);

        $this->db->enableForeignKeyChecks();
    }
}