$(function() 
{
    $('form#search').on("submit",function(e) 
    {
        e.preventDefault();

        var inputs = $(this).serializeArray();

        inputs[0].value;
        
        $.post( "/api/v1/test", inputs)
        .done(function( data ) 
        {
            console.log( data );
        })
        .fail(function() 
        {
            console.log( "error" );
        })
        .always(function() 
        {
            console.log( "finished" );
        });
    });
});