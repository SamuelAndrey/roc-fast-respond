<?php

namespace Database\Seeders;

use App\Models\Closing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClosingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Closing::create([
            'group_name' => 'Support Team',
            'requester_identity' => 'John Doe - johndoe@example.com',
            'category' => 'Network Issue',
            'ticket' => 'T12345',
            'witel' => 'Jakarta',
            'reason' => 'Troubleshooting required',
            'status' => 1,
        ]);


    }
}
