$(document).ready(function () {
    "use strict"; // Start of use strict    
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //Performance Chart
    	var chart_labels ="";
    	var temp_dataset ="";
    	let admin_slug = document.getElementById('admin_slug').value;
		$.ajax({
		 headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		 url:"/"+admin_slug+"/get_views",
		 type:"post",
		 dataType:"html",
		 success:function(res){
		 }
		}).done(function(resp){
			resp = JSON.parse(resp);
			chart_labels = resp.d;
			temp_dataset = resp.v;
		    _show(chart_labels, temp_dataset);
		});
    var ctx = document.getElementById("forecast").getContext('2d');
    var config = {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                    type: 'line',
                    label: "Views",
                    borderColor: "rgb(55, 160, 0)",
                    fill: true,
                    data: temp_dataset
                }]
        },
        options: {
            legend: false,
            scales: {
                yAxes: [{
                        gridLines: {
                            color: "#e6e6e6",
                            zeroLineColor: "#e6e6e6",
                            borderDash: [2],
                            borderDashOffset: [2],
                            drawBorder: true,
                            drawTicks: true
                        },
                        ticks: {
                            padding: 20
                        }
                    }],

                xAxes: [{
                        maxBarThickness: 50,
                        gridLines: {
                            lineWidth: [0]
                        },
                        ticks: {
                            padding: 20,
                            fontSize: 14,
                            fontFamily: "'Nunito Sans', sans-serif"
                        }
                    }]
            }
        }
    };
    var forecast_chart = new Chart(ctx, config);
    $(".c-nav .nav-link").on("click", function () {
    	var v = $(this).attr("data-v");
    	$.ajax({
			 headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	         url:"/"+admin_slug+"/get_views",
	         type:"post",
	         data:{v:v},
	         dataType:"html",
	         success:function(res){
	         }
			}).done(function(resp){
				resp = JSON.parse(resp);
				chart_labels = resp.d;
        		temp_dataset = resp.v;
		        _show(chart_labels, temp_dataset);
			});
        
    });

 	function _show(labels, cdata){
 		var chart_labels = labels;
        var temp_dataset = cdata;
        var data = forecast_chart.config.data;
        data.datasets[0].data = temp_dataset;
        data.labels = chart_labels;
        forecast_chart.update();
 	}
});