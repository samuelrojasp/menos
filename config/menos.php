<?php

return [
    /** Tenemos las distintas configuraciones del sistema de MLM */
    'mlm_settings' => [
        'mlm_top_user' => '140202428',
        'prospect_activity_type' => [
            '0' =>  'email',
            '1' => 'llamada',
            '2' => 'en persona'
        ]
    ],
    
    /** Definicion de tipos de cuenta */
    'account_type' => [
        'primaria' => 0,
        'inversion' => 1,
        'consumo' => 2
    ],

    /** Definicion de compensaciones */
    'compensations' => [
        'rango' => [
            'name' => 'Cambio de Rango',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => 'cumulative_from_start',
            'compensation_type' => 'status',
            'amount' => null,
            'minimum_range' => 'asociado',
            'payment_frecuency' => null,
        ],
        'calificar' => [
            'name' => 'Calificar a las Comisiones',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'status',
            'amount' => null,
            'minimum_range' => 'emprendedor',
            'payment_frecuency' => null,
        ],
        'comercios_asociados' => [
            'name' => 'Comisión por Venta en Comercios Asociados',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'amount' => null,
            'minimum_range' => 'emprendedor_senior',
            'payment_frecuency' => 'monthly',
        ],
        'exito' => [
            'name' => 'Bono Éxito',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'bonus',
            'amount' => 100000,
            'minimum_range' => 'asociado',
            'payment_frecuency' => 'monthly',
        ],
        'bono_rango' => [
            'name' => 'Bono por alcanzar Rango',
            'evaluation_frecuency' => 'transactional',
            'evaluation_period' => null,
            'compensation_type' => 'bonus',
            'amount' => null,
            'minimum_range' => 'director',
            'payment_frecuency' => 'once',
        ],
        'bono_equipo' => [
            'name' => 'Bono por Equipo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'amount' => 0.1,
            'minimum_range' => 'emprendedor',
            'payment_frecuency' => 'monthly',
        ],
        'venta_directa' => [
            'name' => 'Bono por ventas en mis e-commerce',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'commision',
            'amount' => 0.85,
            'minimum_range' => 'asociado',
            'payment_frecuency' => 'monthly',
        ],
        'referido' => [
            'name' => 'Bono por referido',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'commision',
            'amount' => 0.02,
            'minimum_range' => 'emprendedor',
            'payment_frecuency' => 'monthly',
        ],
        'bono_liderazgo' => [
            'name' => 'Bono Liderazgo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'comision',
            'amount' => null,
            'minimum_range' => 'boss',
            'payment_frecuency' => 'monthly',
        ],
        'activo' => [
            'name' => 'Permanecer activo',
            'evaluation_frecuency' => 'monthly',
            'evaluation_period' => 'monthly',
            'compensation_type' => 'status',
            'amount' => null,
            'minimum_range' => 'asociado',
            'payment_frecuency' => null,
        ],
    ],

    /** rangos sistema MLM */
    'rangos' => [
        'asociado' => [
            'name' => 'asociado',
            'active' => 20000,
            'mlm_purchases' => 0,
            'qualify' => null,
            'rank_bonus' => null,
            'leadership_gen' => null,
            'leadership_percentage' => null,

        ],
        'emprendedor' => [
            'name' => 'emprendedor',
            'active' => 20000,
            'mlm_purchases' => 40000,
            'qualify' => 'asociado',
            'rank_bonus' => null,
            'leadership_gen' => null,
            'leadership_percentage' => null,
        ],
        'emprendedor_senior' => [
            'name' => 'emprendedor_senior',
            'active' => 20000,
            'mlm_purchases' => 500000,
            'qualify' => 'asociado',
            'rank_bonus' => null,
            'leadership_gen' => null,
            'leadership_percentage' => null,
        ],
        'boss' => [
            'name' => 'boss',
            'active' => 35000,
            'mlm_purchases' => 1000000,
            'qualify' => 'asociado',
            'rank_bonus' => null,
            'leadership_gen' => 1,
            'leadership_percentage' => 7,
        ],
        'director' => [
            'name' => 'director',
            'active' => 50000,
            'mlm_purchases' => 2500000,
            'qualify' => 'asociado',
            'rank_bonus' => 500000,
            'leadership_gen' => 2,
            'leadership_percentage' => 6,
        ],
        'senior_director' => [
            'name' => 'senior_director',
            'active' => 100000,
            'mlm_purchases' => 5000000,
            'qualify' => 'emprendedor',
            'rank_bonus' => 1000000,
            'leadership_gen' => 3,
            'leadership_percentage' => 5,
        ],
        'bronce' => [
            'name' => 'bronce',
            'active' => 200000,
            'mlm_purchases' => 8000000,
            'qualify' => 'emprendedor_senior',
            'rank_bonus' => 1500000,
            'leadership_gen' => 4,
            'leadership_percentage' => 4,
        ],
        'plata' => [
            'name' => 'plata',
            'active' => 250000,
            'mlm_purchases' => 10000000,
            'qualify' => 'boss',
            'rank_bonus' => 2000000,
            'leadership_gen' => 5,
            'leadership_percentage' => 3,
        ],
        'oro' => [
            'name' => 'oro',
            'active' => 250000,
            'mlm_purchases' => 15000000,
            'qualify' => 'director',
            'rank_bonus' => 2500000,
            'leadership_gen' => 6,
            'leadership_percentage' => 2,
        ],
        'diamante' => [
            'name' => 'diamante',
            'active' => 500000,
            'mlm_purchases' => 30000000,
            'qualify' => 'senior_director',
            'rank_bonus' => 5000000,
            'leadership_gen' => 7,
            'leadership_percentage' => 1,
        ],
        'diamante_azul' => [
            'name' => 'diamante_azul',
            'active' => 1000000,
            'mlm_purchases' => 35000000,
            'qualify' => 'senior_director',
            'rank_bonus' => 5000000,
            'leadership_gen' => 7,
            'leadership_percentage' => 1,
        ],
        'diamante_blanco' => [
            'name' => 'diamante_blanco',
            'active' => 1000000,
            'mlm_purchases' => 40000000,
            'qualify' => 'senior_director',
            'rank_bonus' => 5000000,
            'leadership_gen' => 7,
            'leadership_percentage' => 1,
        ],
        'diamante_negro' => [
            'name' => 'diamante_negro',
            'active' => 1000000,
            'mlm_purchases' => 50000000,
            'qualify' => 'diamante',
            'rank_bonus' => 10000000,
            'leadership_gen' => 7,
            'leadership_percentage' => 1,
        ]
    ]
];
