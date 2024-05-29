<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\PurchasedBook;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class updateDoctorId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:doctor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $doctorsBooks = PurchasedBook::all();

            foreach ($doctorsBooks as $doctors) {
                $doctor = Doctor::where('user_id',$doctors->user_id)->first();
                if($doctor){
                    $doctors->doctor_id = $doctor->id;
                    $doctors->save();
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
