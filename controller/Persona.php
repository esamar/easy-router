<?php

class Persona
{
    public function getPersona( $data )
    {

        $persona = [ 
                    'idpersona' => (int)$data->params->id_persona,
                    'nombre' => 'Raul',
                    'apellido_paterno' => 'Manrique',
                    'apellido_materno' => 'Rodriguez',
                    'edad' => 32,
                    'idinstitucion' => (int)$data->params->id_institucion ];
        return $persona;

    }
}