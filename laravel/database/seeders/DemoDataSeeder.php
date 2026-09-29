<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\CarePlan;
use App\Models\Patient;
use App\Models\ServiceItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $supervisor = User::where('role', 'supervisor')->first();
        $caregiver = User::where('role', 'caregiver')->first();

        $services = [
            ['name' => '助浴服务', 'unit' => '次', 'price_per_unit' => 80, 'description' => '上门协助沐浴、清洁'],
            ['name' => '康复训练', 'unit' => '次', 'price_per_unit' => 120, 'description' => '肢体功能康复训练'],
            ['name' => '陪同就医', 'unit' => '次', 'price_per_unit' => 100, 'description' => '陪诊、代取药'],
            ['name' => '生活照料', 'unit' => '小时', 'price_per_unit' => 50, 'description' => '日常起居、清洁照护'],
            ['name' => '健康监测', 'unit' => '次', 'price_per_unit' => 40, 'description' => '血压、血糖等体征监测'],
        ];
        foreach ($services as $s) {
            ServiceItem::firstOrCreate(['name' => $s['name']], $s);
        }

        $patients = [
            ['name' => '张桂芳', 'gender' => 'female', 'date_of_birth' => '1942-03-12', 'address' => '浦东新区 6 号楼 302', 'contact_phone' => '13812341234', 'emergency_contact_name' => '张伟（子）', 'emergency_contact_phone' => '13956785678'],
            ['name' => '李建国', 'gender' => 'male', 'date_of_birth' => '1945-07-20', 'address' => '杨浦区 12 号楼 501', 'contact_phone' => '13798769876', 'emergency_contact_name' => '李敏（女）', 'emergency_contact_phone' => '13611112222'],
            ['name' => '王秀兰', 'gender' => 'female', 'date_of_birth' => '1938-11-02', 'address' => '徐汇区 3 号楼 102', 'contact_phone' => '13512349876', 'emergency_contact_name' => '王强（子）', 'emergency_contact_phone' => '13899998888'],
            ['name' => '陈德明', 'gender' => 'male', 'date_of_birth' => '1940-05-15', 'address' => '静安区 8 号楼 201', 'contact_phone' => '13245674567', 'emergency_contact_name' => '陈静（女）', 'emergency_contact_phone' => '13933334444'],
        ];
        $patientIds = [];
        foreach ($patients as $p) {
            $p['supervisor_id'] = $supervisor->id;
            $patientIds[] = Patient::firstOrCreate(['name' => $p['name']], $p)->id;
        }

        $plans = [
            ['patient' => 0, 'service' => '生活照料', 'frequency' => '每周 3 次', 'duration' => 120, 'start' => '2026-09-01'],
            ['patient' => 0, 'service' => '助浴服务', 'frequency' => '每周 1 次', 'duration' => 60, 'start' => '2026-09-01'],
            ['patient' => 1, 'service' => '康复训练', 'frequency' => '每周 2 次', 'duration' => 60, 'start' => '2026-09-05'],
            ['patient' => 2, 'service' => '健康监测', 'frequency' => '每周 2 次', 'duration' => 30, 'start' => '2026-09-08'],
            ['patient' => 3, 'service' => '陪同就医', 'frequency' => '按需', 'duration' => 180, 'start' => '2026-09-10'],
        ];
        $planIds = [];
        foreach ($plans as $plan) {
            $service = ServiceItem::where('name', $plan['service'])->first();
            $planIds[] = CarePlan::firstOrCreate(
                ['patient_id' => $patientIds[$plan['patient']], 'service_item_id' => $service->id],
                [
                    'patient_id' => $patientIds[$plan['patient']],
                    'service_item_id' => $service->id,
                    'start_date' => $plan['start'],
                    'frequency' => $plan['frequency'],
                    'duration_minutes' => $plan['duration'],
                    'status' => 'active',
                ]
            )->id;
        }

        $assignments = [
            ['plan' => 0, 'start' => '2026-09-29 09:00:00', 'end' => '2026-09-29 11:00:00', 'status' => 'scheduled'],
            ['plan' => 1, 'start' => '2026-09-30 10:00:00', 'end' => '2026-09-30 11:00:00', 'status' => 'scheduled'],
            ['plan' => 2, 'start' => '2026-09-29 14:00:00', 'end' => '2026-09-29 15:00:00', 'status' => 'scheduled'],
            ['plan' => 3, 'start' => '2026-09-30 09:00:00', 'end' => '2026-09-30 09:30:00', 'status' => 'completed'],
            ['plan' => 4, 'start' => '2026-10-02 08:00:00', 'end' => '2026-10-02 11:00:00', 'status' => 'scheduled'],
        ];
        foreach ($assignments as $a) {
            Assignment::firstOrCreate(
                ['care_plan_id' => $planIds[$a['plan']], 'scheduled_start_at' => $a['start']],
                [
                    'care_plan_id' => $planIds[$a['plan']],
                    'assigned_to_user_id' => $caregiver->id,
                    'scheduled_start_at' => $a['start'],
                    'scheduled_end_at' => $a['end'],
                    'status' => $a['status'],
                    'is_confirmed' => $a['status'] !== 'scheduled',
                ]
            );
        }
    }
}
