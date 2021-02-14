<?php

require_once __DIR__ . '/src/router.php';

Router::dirController('controller');

Router::post('/api/{id_persona}/{id_institucion}' , function( $data ){
  
    Returns::JSON( 200 , $data );

});

Router::get('/api/{id_persona}/{id_institucion}' , 'Persona@getPersona:data' , function ( $data , $resp )
{

    Returns::JSON( 200 , $resp );
exit();
});

Router::get('/{nombre_visitante}', function( $data )
{
    
    Returns::VIEW( 200 ,'public/index.php' , [ 
                                            'data' => $data , 
                                            'miVariable' => "Versión de router 0.1",
                                            'titulo' => "Router simple, efectivo y sin dependencias"
                                            ]);

});