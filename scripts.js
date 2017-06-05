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
            if (data.length === 0)
            {
                var msg = {};
                msg.error = "No countries found that match your query";
                return failure(msg);
            }

            notice("/api/v1/country/" + inputs.type);

            results(data);
        })
        .fail(function(msg)
        {
            failure(msg.responseJSON);
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

        $('div.output-area div#results').append(getCountriesAsTable(countries));

        $('div.output-area div#results').append(getSearchStatsAsTable(countries));

        console.log(countries);
    }

    function getSearchStatsAsTable(countries)
    {
        var table = $("<table></table>");

        table.append(getStatsTitleAsRow());
        table.append(getTotalCountAsRow(countries));
        table.append(getRegionsCountAsRow(countries));
        table.append(getSubRegionsCountAsRow(countries));

        return table;
    }

    function getRegionsCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Regions in search:" + "</i></td>"));

        var regions = getAttributeCount(countries, 'region');

        var contentCell = $("<td></td>");
        contentCell.append(_getRegionsCountAsRow_getContentAsTable(regions));
        row.append(contentCell);
        return row;
    }

    function getSubRegionsCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Subregions in search:" + "</i></td>"));

        var regions = getAttributeCount(countries, 'subregion');

        var contentCell = $("<td></td>");
        contentCell.append(_getRegionsCountAsRow_getContentAsTable(regions));
        row.append(contentCell);
        return row;
    }

    function _getRegionsCountAsRow_getContentAsTable(regions)
    {
        var table = $("<table></table>");

        for (var k in regions)
        {
            table.append(getRegionCountAsRown(k, regions[k]));
        }

        return table;
    }

    function getRegionCountAsRown(name, count)
    {
        var row = $("<tr></tr>");
        row.append($("<td><b>" + name + "</b></td>"));
        row.append($("<td>(" + count + ")</td>"));
        return row;
    }

    function getAttributeCount(countries, attribute)
    {
        var regions = {};

        countries.forEach(function(country)
        {
            if (regions[country[attribute]] === undefined)
            {
                regions[country[attribute]] = 0;
            }

            regions[country[attribute]]++;
        });

        return regions;
    }

    function getStatsTitleAsRow()
    {
        var row = $("<tr></tr>");
        row.append($("<td colspan='2'><u><h3>" + "Search results" + "</h3></u></td>"));
        return row;
    }

    function getTotalCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Total number of countries:" + "</i></td>"));
        row.append($("<td>" + countries.length + "</td>"));
        return row;
    }

    // TODO: Move all CountriesAsTable functionality to object.

    function getCountriesAsTable(countries)
    {
        var table = $("<table></table>");

        countries.forEach(function(country)
        {
            table.append(getCountryAsRow(country));
        });

        return table;
    }

    function getCountryAsRow(country)
    {
        var row = $("<tr></tr>");

        row.append($("<td>" + getImageHTML(country.flag, 300, 200) + "</td>"));

        var statsCell = $("<td></td>");

        statsCell.append(_getCountryAsRow_getStats(country));

        row.append(statsCell);

        return row;
    }

    function _getCountryAsRow_getStats(country)
    {
        var table = $("<table></table>");

        table.append(getNameRow(country));
        table.append(getAlphaCode2Row(country));
        table.append(getAlphaCode3Row(country));
        table.append(getRegionRow(country));
        table.append(getSubRegionRow(country));
        table.append(getLanguagesRow(country));

        return table;
    }

    function getNameRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td colspan='2'><h3>" + country.name + "</b></h3>"));
        return row;
    }

    function getAlphaCode2Row(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Alpha Code 2:" + "</i></td>"));
        row.append($("<td>" + country.alpha2Code + "</td>"));
        return row;
    }

    function getAlphaCode3Row(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Alpha Code 3:" + "</i></td>"));
        row.append($("<td>" + country.alpha3Code + "</td>"));
        return row;
    }

    function getRegionRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Region:" + "</i></td>"));
        row.append($("<td>" + country.region + "</td>"));
        return row;
    }

    function getSubRegionRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Subregion:" + "</i></td>"));
        row.append($("<td>" + country.subregion + "</td>"));
        return row;
    }

    function getLanguagesRow(country)
    {
        var languagesString = country.languages.pop().name;

        country.languages.forEach(function (language)
        {
            languagesString += ", " + language.name;
        });

        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Language(s):" + "</i></td>"));
        row.append($("<td>" + languagesString + "</td>"));
        return row;
    }

    function getImageHTML(url, width, height)
    {
        return '<img src="' + url +'" alt="Flag" style="width:' + width +'px;height:' + height + 'px;">';
    }
});