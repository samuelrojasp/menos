<?php

use Illuminate\Database\Seeder;
use App\Banco;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bancos')->delete();
        $json = File::get("database/data/bancos.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Banco::create(array(
                'tipo' => $obj->tipo,
                'codigoSBIF' => $obj->codigoSBIF,
                'codigoRegistro' => $obj->codigoRegistro,
                'nombre' => $obj->nombre,
            ));
        }
    }
}
