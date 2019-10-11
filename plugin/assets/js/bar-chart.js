if ($('#socialads').length) {

    Highcharts.chart('socialads', {
        chart: {
            type: 'column'
        },
        title: false,
        xAxis: {
            categories: ['testing-purpose-used', 'testing-purpose-used', 'testing-purpose-used', 'testing-purpose-used', 'testing-purpose-used-testing-purpose-used']
        },
        colors: ['#F5CA3F', '#E5726D', '#12C599', '#5F73F2'],
        yAxis: {
            min: 0,
            title: false
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'column'
            }
        },
        series: [{
                name: 'Closed',
                data: [51, 48, 64, 48, 84]
            }, {
                name: 'Hold',
                data: [83, 84, 53, 81, 88]
            }, {
                name: 'Pending',
                data: [93, 84, 53, 53, 48]
            },
            {
                name: 'Active',
                data: [430, 312, 348, 254, 258]
            }
        ]
    });
}