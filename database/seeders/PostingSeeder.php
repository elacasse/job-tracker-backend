<?php

namespace Database\Seeders;

use App\Models\Posting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->all();

        // If there are no users, create one so we don't crash
        if (empty($userIds)) {
            $this->command?->warn('No users found, creating a default user for postings...');
            $userIds[] = User::factory()->create()->id;
        }

        Posting::factory()
            ->count(50)
            ->make()
            ->each(function (Posting $posting) use ($userIds) {
                $posting->user_id = Arr::random($userIds);
                $posting->save();
            });
    }
}
