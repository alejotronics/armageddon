<?php

use Illuminate\Database\Seeder;

class TiendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * DATOS
         */

        $datos = [
            [
                'nombre' => 'Cafe Sedo',
                'id_propietario' => 5,
                'longitud' => 41.555983,
                'latitud' => 2.085601,
                'imagen' => 'https://dosg.net/wp-content/uploads/2018/03/cafeteria.jpg'
            ],
            [
                'nombre' => 'Panaderia Baker',
                'id_propietario' => 6,
                'longitud' => 41.554279,
                'latitud' => 2.085989,
                'imagen' => ''
            ],
            [
                'nombre' => 'Bar Parada',
                'id_propietario' => 7,
                'longitud' => 40.554279,
                'latitud' => 2.885989,
                'imagen' => ''
            ],
            [
                'nombre' => 'Panaderia Baker',
                'id_propietario' => 6,
                'longitud' => 41.554279,
                'latitud' => 2.085989,
                'imagen' => ''
            ]
        ];

        $i = 1;
        foreach($datos as $k => $item) {
            $item['id'] = $i;
            $item['created_at'] = date("Y-m-d H:i:s");

            $datos[$k] = $item;
            $i++;
        }

        /*
         * INSERTAR
         */

        foreach($datos as $item) {
            DB::table('tiendas')->insert($item);
        }
    }
}
