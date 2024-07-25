let paso = 1;
const pasoInicial=1;
const pasoFinal=3;

const cita={
    id:'',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();

});

function iniciarApp(){
    
    mostrarSeccion(); //Muestra y oculta las secciones 
    tabs();//Cambia la seccion cuando se presionen los tabs 
    botonesPaginador();//los botones antrior y siguiente
    paginaSiguiente();
    paginaAnterior();
    consultarAPI();//CONSULTA EL API EN BAKEND EN PHP
    idCliente();//id oculto
    nombreCliente();// a ñade elnombre del cliente al objeto de cita
    seleccionarFecha();//añade la cita al objeto 
    seleccionarHora();
    mostrarResumen();
}

function mostrarSeccion(){
    //ocultar la sección que tenga la calse mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
        
    }
    
    //selector la seccion con el paso...
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');
    //quita la clase del tab anteriro
    const tabAnterior= document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');

    }

    //resalta el tab actual
    const tab=document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton  =>{
        boton.addEventListener('click', function(e){
            
            
            
            paso =  parseInt(e.target.dataset.paso);//puedes hacer a tus atributos que bas creando ejemplo data-paso
            
            mostrarSeccion();
            botonesPaginador();
         



        });

    });

}


function botonesPaginador(){
    const paginadorAnterior=document.querySelector('#anterior');
    const paginadorSiguiente=document.querySelector('#siguiente');

    if(paso === 1){
        paginadorAnterior.classList.add('ocultar');
        paginadorSiguiente.classList.remove('ocultar');

    }
    else if(paso === 3){
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.add('ocultar');
        mostrarResumen();

    }else{
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();

    
}
function paginaAnterior() {
    const paginaAnterior =document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {
        if(paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    
    })
    
    
}

function paginaSiguiente() {
    const paginaSiguiente =document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {
     
       
        if(paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    
    })
    
}

async function consultarAPI() {
    try {
        const url=`${location.origin}/api/servicios`;//opcion 1 /api/servicios si quendan en elmismo dominio
        const resultado=  await fetch(url);
        const  servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
    
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio  => {//crear html
        const{id,nombre,precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent=`$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id; 
        servicioDiv.onclick =  function() {
            selecionarServico(servicio);
            
        }


        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        
       document.querySelector('#servicios').appendChild(servicioDiv);
    })
}

function selecionarServico(servicio) {
   const {id} = servicio;
    const {servicios} = cita;
    //identifica el elemnto que se ledara click
    const divServicio = document.querySelector(`[ data-id-servicio="${id}"]`);

     //servico ya fue agregado

     if(servicios.some(agregado => agregado.id === id)){
        //eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');


     }else{
        //agregar
        cita.servicios=[...servicios, servicio];//...ser es unacopia y lo pone en elnuevoa reglo servi
        divServicio.classList.add('seleccionado');
     }
     //console.log(cita);
   
   
    
   
   

    
    
}
    function idCliente() {
        cita.id = document.querySelector('#id').value;
        
    }

 function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
 }

 function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',function(e) {
        const dia = new Date(e.target.value).getUTCDay();

        if([6,0].includes(dia)){//0=domingo ,1=lunes 6=sabado
            e.target.value = '';
            mostrarAlerta('Fines de semanas no permitido','error','.formulario');
        }else{
            cita.fecha=e.target.value;
        }
        
    });
    
 }
 function seleccionarHora() {
    const inpuntHora=document.querySelector('#hora');
    inpuntHora.addEventListener('input',function (e) {
        const horaCita = e.target.value;
        const hora =horaCita.split(":")[0];
        if(hora < 10 || hora > 21 ){
            e.target.value = "";
            mostrarAlerta('Hora no Válida','error','.formulario');
        }else{
            cita.hora = e.target.value;
            //console.log(cita);
        }
    });
    
    

 }




 function mostrarAlerta(mensaje,tipo,elemento,desaparece = true) {
   
    //previene mas 1 una alerta 
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    };
    //Scripting par5acrear alerta
    const alerta =document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);// es con esto aparece arriba #paso-2 p'
    referencia.appendChild(alerta);
    
    if (desaparece) {
        //elimina la alerta
    setTimeout(() => {
        alerta.remove();
    }, 3000);

        
    }
    
    
    
 }

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //limpiar el contenido de resumen
while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
    
}




    if(Object.values(cita).includes('') || cita.servicios.length === 0){
        mostrarAlerta('Falta datos se servicios, fecha u hora','error','.contenido-resumen',false);
        return;

    }
    //formatear el div de resumen distorcion
    const{nombre,fecha,hora,servicios} = cita;


    //heading para Servicios  en Resumen
    const headingServicios  = document.createElement('H3');
    headingServicios.textContent = 'Resumen  de Servicios';
    resumen.appendChild(headingServicios);



    //interar y mostar los servicios
    servicios.forEach(servicio => {
        const{id,nombre,precio} = servicio;
        
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contener-servicio');
        
        const textoServico =document.createElement('P');
        textoServico.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML= `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServico);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);


        
    });

    //heading para cita en Resumen
    const headingCita  = document.createElement('H3');
    headingCita.textContent = 'Resumen  de Cita';
    resumen.appendChild(headingCita);



        
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML=`<span>Nombre:</span> ${nombre}`;

    //formatear la fecha
    const fechaObj = new Date(fecha); 
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year , mes ,dia));

    const opciones = {weekday:'long', year:'numeric',month:'long',day:'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX',opciones);
    
    
    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML=`<span>Fecha:</span> ${fechaFormateada}`;

    const horaCliente = document.createElement('P');
    
    const jornada = hora >= 12 ? 'a.m.' : 'p.m.';
    const hora12 = hora > 12 ? hora - 12 : hora;
    horaCliente.innerHTML = `<span>Hora:</span> ${hora12} ${ jornada }`;

    //craer un boton craer la cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;
    
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    
    resumen.appendChild(botonReservar);
    
    
}


  async function reservarCita() {
    
    const{nombre, fecha, hora,servicios,id} = cita;
    
    const idServicios = servicios.map(servicio => servicio.id);

    //console.log(idServicios);
    //return;
   
 

    const datos = new FormData();
    
    
    datos.append('fecha',fecha);
    datos.append('hora',hora);
    datos.append('usuarioId',id);
    datos.append('servicios',idServicios);
    //console.log([...datos]);
    //return;
    
    try {
        const url = `${location.origin}/api/citas`;//agrega el dominio 2opcion

    const respuesta = await fetch(url,{
        method: 'POST',
        body: datos

    });
    const resultado = await respuesta.json();
 
    console.log(resultado.resultado);
   

    if(resultado.resultado){
        Swal.fire({
            icon: "success",
            title: "Cita Creada",
            text: "Tu Cita fue creada corectamente",
            button: 'OK'
          }).then(()=>{ setTimeout(()=>{
            window.location.reload();

          },3000);
           
           

          })

    }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Hubo un error al guardar la cita",
            
          });
        
    }


    //Petición la api
    
    

    
    //tip para ver lo que bas enviara antes que lo envies console.log([...datos]);,http://127.0.0.1:30000/api/citas
    

    


    
}

