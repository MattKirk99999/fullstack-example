class CountriesTable
{
    constructor(countries)
    {
        this.table = this.getCountriesAsTable(countries);
    }

    getTable()
    {
        return this.table;
    }

    getCountriesAsTable(countries)
    {
        var self = this;
        var table = $("<table></table>");

        countries.forEach(function(country)
        {
            table.append(self.getCountryAsRow(country));
        });

        return table;
    }

    getCountryAsRow(country)
    {
        var row = $("<tr></tr>");

        row.append($("<td>" + this.getImageHTML(country.flag, 300, 200) + "</td>"));

        var statsCell = $("<td></td>");

        statsCell.append(this._getCountryAsRow_getStats(country));

        row.append(statsCell);

        return row;
    }

    _getCountryAsRow_getStats(country)
    {
        var table = $("<table></table>");

        table.append(this.getNameRow(country));
        table.append(this.getAlphaCode2Row(country));
        table.append(this.getAlphaCode3Row(country));
        table.append(this.getRegionRow(country));
        table.append(this.getSubRegionRow(country));
        table.append(this.getLanguagesRow(country));

        return table;
    }

    getNameRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td colspan='2'><h3>" + country.name + "</b></h3>"));
        return row;
    }

    getAlphaCode2Row(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Alpha Code 2:" + "</i></td>"));
        row.append($("<td>" + country.alpha2Code + "</td>"));
        return row;
    }

    getAlphaCode3Row(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Alpha Code 3:" + "</i></td>"));
        row.append($("<td>" + country.alpha3Code + "</td>"));
        return row;
    }

    getRegionRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Region:" + "</i></td>"));
        row.append($("<td>" + country.region + "</td>"));
        return row;
    }

    getSubRegionRow(country)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Subregion:" + "</i></td>"));
        row.append($("<td>" + country.subregion + "</td>"));
        return row;
    }

    getLanguagesRow(country)
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

    getImageHTML(url, width, height)
    {
        return '<img src="' + url +'" alt="Flag" style="width:' + width +'px;height:' + height + 'px;">';
    }
}