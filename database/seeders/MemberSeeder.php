<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = Member::factory()->defaultMobileMember();

        foreach ($members as $member) {
            Member::factory()->create($member);
        }
    }
}
