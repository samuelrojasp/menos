<?php

return [
    /** Tenemos las distintas configuraciones del sistema de MLM */
    'mlm_settings' => [
        'mlm_top_user' => '140202428',
    ],

    /** Definicion de compensaciones */
    'compensations' => [
        'rango' => [
            'name' => 'Cambio de Rango',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => 'cumulative_from_start',
            'compensation_type' => 'status',
            'minimum_range' => 'asociado',
            'payment_frecuency' => null,
        ],
        'calificar' => [
            'name' => 'Calificar a las Comisiones',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'status',
            'minimum_range' => 'emprendedor',
            'payment_frecuency' => null,
        ],
        'comercios_asociados' => [
            'name' => 'Comisión por Venta en Comercios Asociados',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'minimum_range' => 'emprendedor_senior',
            'payment_frecuency' => 'monthly',
        ],
        'exito' => [
            'name' => 'Bono Éxito',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'bonus',
            'minimum_range' => 'asociado',
            'payment_frecuency' => 'monthly',
        ],
        'bono_rango' => [
            'name' => 'Bono por alcanzar Rango',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'bonus',
            'minimum_range' => 'director',
            'payment_frecuency' => 'once',
        ],
        'bono_equipo' => [
            'name' => 'Bono por Equipo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'minimum_range' => 'emprendedor',
            'payment_frecuency' => 'monthly',
        ],
        'venta_directa' => [
            'name' => 'Bono por ventas en mis e-commerce',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'commision',
            'minimum_range' => 'asociado',
            'payment_frecuency' => 'monthly',
        ],
        'bono_liderazgo' => [
            'name' => 'Bono Liderazgo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'minimum_range' => 'boss',
            'payment_frecuency' => 'monthly',
        ],
        'activo' => [
            'name' => 'Permanecer activo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'status',
            'minimum_range' => 'asociado',
            'payment_frecuency' => null,
        ],
    ],
];