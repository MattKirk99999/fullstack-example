/**
 * SearchStatsTable generates a table of stats given a list of countries.
 *
 */
class SearchStatsTable
{
    constructor(countries)
    {
        this.table = this.getSearchStatsAsTable(countries);
    }

    getTable()
    {
        return this.table;
    }

    getSearchStatsAsTable(countries)
    {
        var table = $("<table></table>");

        table.append(this.getStatsTitleAsRow());
        table.append(this.getTotalCountAsRow(countries));
        table.append(this.getRegionsCountAsRow(countries));
        table.append(this.getSubRegionsCountAsRow(countries));

        return table;
    }

    getRegionsCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Regions in search:" + "</i></td>"));

        var regions = this.getAttributeCount(countries, 'region');

        var contentCell = $("<td></td>");
        contentCell.append(this._getRegionsCountAsRow_getContentAsTable(regions));
        row.append(contentCell);
        return row;
    }

    getSubRegionsCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Subregions in search:" + "</i></td>"));

        var regions = this.getAttributeCount(countries, 'subregion');

        var contentCell = $("<td></td>");
        contentCell.append(this._getRegionsCountAsRow_getContentAsTable(regions));
        row.append(contentCell);
        return row;
    }

    _getRegionsCountAsRow_getContentAsTable(regions)
    {
        var table = $("<table></table>");

        for (var k in regions)
        {
            table.append(this.getRegionCountAsRown(k, regions[k]));
        }

        return table;
    }

    getRegionCountAsRown(name, count)
    {
        var row = $("<tr></tr>");
        row.append($("<td><b>" + name + "</b></td>"));
        row.append($("<td>(" + count + ")</td>"));
        return row;
    }

    getAttributeCount(countries, attribute)
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

    getStatsTitleAsRow()
    {
        var row = $("<tr></tr>");
        row.append($("<td colspan='2'><u><h3>" + "Search results" + "</h3></u></td>"));
        return row;
    }

    getTotalCountAsRow(countries)
    {
        var row = $("<tr></tr>");
        row.append($("<td><i>" + "Total number of countries:" + "</i></td>"));
        row.append($("<td>" + countries.length + "</td>"));
        return row;
    }
}