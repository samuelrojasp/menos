<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use Illuminate\Support\Facades\DB;
use DateTime;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $deadline = (new DateTime())->modify('-5 minutes')->format('Y-m-d H:i:s');

            $usuario_huerfano = User::where('binary_parent_id', null)
                                ->where('id', '!=', 28)
                                ->first();

            dump($usuario_huerfano);

            if($usuario_huerfano != null && $usuario_huerfano->affiliated_at < $deadline){

                $query = DB::table('users')
                    ->where('binary_parent_id', $usuario_huerfano->sponsor_id)
                    ->unionAll(
                        DB::table('users')
                            ->select('users.*')
                            ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
                    );

                $tree = DB::table('tree')
                    ->withRecursiveExpression('tree', $query)
                    ->pluck('id');

                $tree->push($usuario_huerfano->sponsor_id);

                $binary_parent = User::whereIn('id', $tree)
                                    ->has('binaryChildren', '<', '2')
                                    ->orderBy('created_at', 'asc')
                                    ->first();

                $children = $binary_parent->binaryChildren->first();

                $usuario_huerfano->binary_parent_id = $binary_parent->id;

                if(count($children) == 0){
                    $usuario_huerfano->binary_side = 0;
                }else{
                    $usuario_huerfano->binary_side = 1;
                }

                $usuario_huerfano->save();
            }
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
