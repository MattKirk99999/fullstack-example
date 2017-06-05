$(function()
{
    // Form controller
    $('form#search').on("submit",function(e)
    {
        e.preventDefault();

        var inputs = getFormInputs(this);

        if (inputs.query.length === 0) return invalidInput();

        // API service.
        $.post( "/api/v1/country/" + inputs.type, inputs)
        .done(function( data )
        {
            if (data.length === 0)
            {
                var msg = {};
                msg.error = "No countries found that match your query";
                return failure(msg);
            }

            notice("success");

            results(data);
        })
        .fail(function(msg)
        {
            failure(msg.responseJSON);
        })
        .always(function()
        {
            // do nothing.
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

    function failure(msg)
    {
        return error(msg.error);
    }

    function invalidInput()
    {
        return error("Enter some text and try again!");
    }

    function error(msg)
    {
        return notice("Error: " + msg);
    }

    function notice(msg)
    {
        $('div.output-area div#notices').text(msg);

        return msg;
    }

    function results(countries)
    {
        $('div.output-area div#results').html('');

        var countriesTable = new CountriesTable(countries);
        var searchStats = new SearchStatsTable(countries);

        $('div.output-area div#results').append(countriesTable.getTable());
        $('div.output-area div#results').append(searchStats.getTable());
    }
});