(function ($) {
    "use strict";
    var apexCharts = {
        initialize: function () {
            this.apexLineChart();
        },
        apexLineChart: function () {
            var options = {
                chart: {
                    height: 320,
                    type: 'line',
                    fontFamily: 'Nunito Sans, sans-serif',
                    zoom: {
                        enabled: false
                    },
                },
                colors: ['#37a000'],
                fill: {
                    type: "solid"
                },
                stroke: {
                    width: 4,
                    curve: 'smooth'
                },
                series: [{
                        name: "Views",
                        data: $("#apexLineChart").data("views")
                    }],
                xaxis: {
                    categories: $("#apexLineCharts").data("days"),
                }
            }
            var chart = new ApexCharts(
                    document.querySelector("#apexLineChart"),
                    options
                    );

            chart.render();
        },
    };
    // Initialize
    $(document).ready(function () {
        "use strict";
        apexCharts.initialize();
    });
}(jQuery));