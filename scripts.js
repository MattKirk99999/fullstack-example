$(function()
{
    $('form#search').on("submit",function(e)
    {
        e.preventDefault();

        var inputs = getFormInputs(this);

        if (inputs.query.length === 0) return invalidInput();

        $.post( "/api/v1/country/" + inputs.type, inputs)
        .done(function( data )
        {
            console.log( data );
        })
        .fail(function(msg)
        {
            console.log( msg );
        })
        .always(function()
        {
            console.log( "finished" );
        });
    });

    function getFormInputs(form)
    {
        var inputs = {};

        $(form).serializeArray().forEach(function(input)
        {
            inputs[input.name] = input.value;
        });

        return inputs;
    }

    function invalidInput()
    {
        return invalid("Enter some text and try again!");
    }

    function invalid(msg)
    {
        return "Error: " + msg;
    }
});