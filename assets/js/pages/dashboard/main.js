var warehouse = 0;
var workgroup = 0;
var level = 0;
var kpi = 0;
var point = 0;
var bench_mode;

$(function() {
    $("._warehouse").select2({
        placeholder: "Filter by Warehouse",
        allowClear: true,
        containerCssClass: 'warehouse_select',
        theme: "bootstrap"
    });

    bench_mode = $('input[name=bench_mode]').val();

    if (bench_mode == 1) {
        get_graph_data();
    }

    function get_graph_data(){
      $.ajax({
              url: window.location + "&chart=1",
              type: 'get',
              dataType: 'json'
          })
          .done(function(data) {
              //console.log(data.canvas);
              create_chart2(data.canvas, "kpi", "chartContainer","KPI Benchmark","%");
              create_chart2(data.canvas, "mo", "chartContainer2","MOTIVATION Benchmark","Point");
          })
          .fail(function() {
              console.log("error");
          })
          .always(function() {
              console.log("complete");
          });
    }

    function create_chart(param, key, name) {
        var doughnutData = {
            labels: param[1].labels,
            datasets: [param[0][key]]
        };
        var doughnutOptions = {
            responsive: true
        };
        var ctx4 = document.getElementById(name).getContext("2d");
        new Chart(ctx4, {
            type: 'doughnut',
            data: doughnutData,
            options: doughnutOptions
        });
    }

    function create_chart2(param, key, name, title, unit) {
        var chart = new CanvasJS.Chart(name, {
            title: {
                text: title
            },
            backgroundColor: "transparent",
            animationEnabled: true,
            theme: "theme2",
            data: [{
                type: "doughnut",
                 showInLegend: true,
                indexLabelFontFamily: "Kanit",
                indexLabelFontSize: 10,
                startAngle: 0,
                indexLabelFontColor: "dimgrey",
                indexLabelLineColor: "darkgrey",
                toolTipContent: "{y} "+unit,
                dataPoints: param[key]
            }]
        });
        console.log(param);
        chart.render();
    }

    $('._print').on('click',function(){
      $('.container').css('width',"970px");
      window.print();
    });




    if ($('input[name=warehouse_id]').length > 0) {
        warehouse = $('input[name=warehouse_id]').val();
    }
    if ($('input[name=workgroup_id]').length > 0) {
        workgroup = $('input[name=workgroup_id]').val();
    }
    if ($('input[name=level_id]').length > 0) {
        level = $('input[name=level_id]').val();
    }
    if ($('input[name=kpi_default]').length > 0) {
        kpi = $('input[name=kpi_default]').val();
    }
    if ($('input[name=point_default]').length > 0) {
        point = $('input[name=point_default]').val();
    }
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    $.ajax({
            url: base_url + 'pcgceo/welcome/staff_chart',
            type: 'POST',
            dataType: 'json',
            data: "mode=2&warehouse=" + warehouse + "&workgroup=" + workgroup + "&kpi=" + kpi + "&point=" + point + "&level=" + level
        })
        .done(function(data) {
            try {
                Morris.Bar({
                    element: 'morris-bar-chart',
                    data: data,
                    barSize: 30,
                    xkey: 'y',
                    ykeys: ['x'],
                    labels: ['KPI'],
                    hideHover: 'auto',
                    hoverCallback: function(index, options, content) {
                        content = "<a href='" + base_url + "pcgceo/welcome.html?id=" + data[index].id + "'><img class='img-responsive' src='" + data[index].img + "' style='width:100px;'></a>" + content;
                        return content;
                    },
                    resize: true,
                    barColors: ['#ED5565'],
                });
            } catch (e) {

            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    $.ajax({
            url: base_url + 'pcgceo/welcome/staff_chart',
            type: 'POST',
            dataType: 'json',
            data: "mode=1&warehouse=" + warehouse + "&workgroup=" + workgroup + "&kpi=" + kpi + "&point=" + point + "&level=" + level
        })
        .done(function(data) {
            console.log(data);
            try {
                Morris.Bar({
                    element: 'morris-bar-chart-2',
                    data: data,
                    barSize: 50,
                    xkey: 'y',
                    ykeys: ['x'],
                    labels: ['POINT'],
                    hideHover: 'auto',
                    hoverCallback: function(index, options, content) {
                        content = "<a href='" + base_url + "pcgceo/welcome.html?id=" + data[index].id + "'><img class='img-responsive' src='" + data[index].img + "' style='width:100px;'></a>" + content;
                        return content;
                    },
                    resize: true,
                    barColors: ['#1c84c6'],
                }).on('click', function(i, row) {
                    console.log(i, row);
                });
            } catch (e) {

            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    $('select[name=by_quarter]').on('change', function() {
        $('select[name=by_month]').val(0);
    });
    $('select[name=by_month]').on('change', function() {
        $('select[name=by_quarter]').val(0);
    });
});

function preloadImages(array) {
    if (!preloadImages.list) {
        preloadImages.list = [];
    }
    var list = preloadImages.list;
    for (var i = 0; i < array.length; i++) {
        var img = new Image();
        img.onload = function() {
            var index = list.indexOf(this);
            if (index !== -1) {
                // remove image from the array once it's loaded
                // for memory consumption reasons
                list.splice(index, 1);
            }
        }
        list.push(img);
        img.src = array[i];
    }
}
