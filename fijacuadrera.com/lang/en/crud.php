<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'caballos' => [
        'name' => 'Caballos',
        'index_title' => 'Caballos List',
        'new_title' => 'New Caballo',
        'create_title' => 'Create Caballo',
        'edit_title' => 'Edit Caballo',
        'show_title' => 'Show Caballo',
        'inputs' => [
            'nombre' => 'Nombre',
            'edad' => 'Edad',
            'Raza' => 'Raza',
        ],
    ],

    'carreras' => [
        'name' => 'Carreras',
        'index_title' => 'Carreras List',
        'new_title' => 'New Carrera',
        'create_title' => 'Create Carrera',
        'edit_title' => 'Edit Carrera',
        'show_title' => 'Show Carrera',
        'inputs' => [
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'hipico_id' => 'Hipico',
        ],
    ],

    'contactos' => [
        'name' => 'Contactos',
        'index_title' => 'Contactos List',
        'new_title' => 'New Contacto',
        'create_title' => 'Create Contacto',
        'edit_title' => 'Edit Contacto',
        'show_title' => 'Show Contacto',
        'inputs' => [
            'celular' => 'Celular',
            'HoraDisponible' => 'Hora Disponible',
        ],
    ],

    'formapagos' => [
        'name' => 'Formapagos',
        'index_title' => 'Formapagos List',
        'new_title' => 'New Formapago',
        'create_title' => 'Create Formapago',
        'edit_title' => 'Edit Formapago',
        'show_title' => 'Show Formapago',
        'inputs' => [
            'cbu' => 'Cbu',
            'alias' => 'Alias',
        ],
    ],

    'hipicos' => [
        'name' => 'Hipicos',
        'index_title' => 'Hipicos List',
        'new_title' => 'New Hipico',
        'create_title' => 'Create Hipico',
        'edit_title' => 'Edit Hipico',
        'show_title' => 'Show Hipico',
        'inputs' => [
            'nombre' => 'Nombre',
            'direccion' => 'Direccion',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'admin' => 'Admin',
            'celular' => 'Celular',
            'cbu' => 'Cbu',
            'alias' => 'Alias',
            'saldo' => 'Saldo',
        ],
    ],

    'apuestamanomanos' => [
        'name' => 'Apuestamanomanos',
        'index_title' => 'Apuestamanomanos List',
        'new_title' => 'New Apuestamanomano',
        'create_title' => 'Create Apuestamanomano',
        'edit_title' => 'Edit Apuestamanomano',
        'show_title' => 'Show Apuestamanomano',
        'inputs' => [
            'carrera_id' => 'Carrera',
            'Ganancia' => 'Ganancia',
            'Caballo1' => 'Caballo1',
            'Caballo2' => 'Caballo2',
            'Tipo' => 'Tipo',
            'Estado' => 'Estado',
        ],
    ],

    'apuesta_pollas' => [
        'name' => 'Apuesta Pollas',
        'index_title' => 'ApuestaPollas List',
        'new_title' => 'New Apuesta polla',
        'create_title' => 'Create ApuestaPolla',
        'edit_title' => 'Edit ApuestaPolla',
        'show_title' => 'Show ApuestaPolla',
        'inputs' => [
            'carrera_id' => 'Carrera',
            'Ganancia' => 'Ganancia',
            'Caballo1' => 'Caballo1',
            'Monto1' => 'Monto1',
            'Caballo2' => 'Caballo2',
            'Monto2' => 'Monto2',
            'Caballo3' => 'Caballo3',
            'Monto3' => 'Monto3',
            'Caballo4' => 'Caballo4',
            'Monto4' => 'Monto4',
            'Caballo5' => 'Caballo5',
            'Monto5' => 'Monto5',
            'Estado' => 'Estado',
        ],
    ],

    'apuesta_polla_users' => [
        'name' => 'Apuesta Polla Users',
        'index_title' => 'ApuestaPollaUsers List',
        'new_title' => 'New Apuesta polla user',
        'create_title' => 'Create ApuestaPollaUser',
        'edit_title' => 'Edit ApuestaPollaUser',
        'show_title' => 'Show ApuestaPollaUser',
        'inputs' => [
            'apuesta_polla_id' => 'Apuesta Polla',
            'user_id' => 'User',
            'caballo_id' => 'Caballo',
            'Resultadoapuesta' => 'Resultadoapuesta',
        ],
    ],

    'apuestamanomano_users' => [
        'name' => 'Apuestamanomano Users',
        'index_title' => 'ApuestamanomanoUsers List',
        'new_title' => 'New Apuestamanomano user',
        'create_title' => 'Create ApuestamanomanoUser',
        'edit_title' => 'Edit ApuestamanomanoUser',
        'show_title' => 'Show ApuestamanomanoUser',
        'inputs' => [
            'apuestamanomano_id' => 'Apuestamanomano',
            'user_id' => 'User',
            'caballo_id' => 'Caballo',
            'resultadoapuesta' => 'Resultadoapuesta',
        ],
    ],
];
