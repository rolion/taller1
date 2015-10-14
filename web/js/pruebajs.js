$('#myId').change(function(){
    var ci=$(this).val();
    $.get('index.php?r=inscripcion-examen/get-persona-by-ci',{ci:ci},function(data){
        if(data!=null){
            var persona= $.parseJSON(data);
            $('#persona-nombre').attr('value',persona.nombre);
            $('#persona-apellido').attr('value',persona.apellido);
            $('#persona-telefono').attr('value',persona.telefono);
            //$('#persona-id_colegio').attr('placeholder',persona.id_colegio);
        }

    });
    
});

