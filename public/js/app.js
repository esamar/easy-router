function getPersona()
{

    fetch('/api/1/3')
      .then(response => response.json())
      .catch(error => console.error('Error:', error))
      .then(response => 
        {

            console.log('Success:', response);

            const lista_persona =`
                                    <li><b>Código usuario:</b> ${ response.idpersona } </li>
                                    <li><b>Nombre:</b> ${ response.nombre } </li>
                                    <li><b>Apellido Paterno:</b> ${ response.apellido_paterno } </li>
                                    <li><b>Apellido Marterno:</b> ${ response.apellido_materno } </li>
                                    <li><b>Edad:</b> ${ response.edad } </li>
                                    <li><b>Código institución:</b> ${ response.idinstitucion } </li>`; 

            const app = document.querySelector('#lista');

            app.innerHTML=lista_persona;

        }
      );

}

