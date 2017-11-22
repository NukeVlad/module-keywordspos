<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">{LANG.projects}</div>
    <div class="panel-body">
        <select class="form-control" id="projectid">
            <!-- BEGIN: projects -->
            <option value="{PROJECTS.id}"{PROJECTS.selected}>{PROJECTS.title}</option>
            <!-- END: projects -->
        </select>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <canvas id="myChart" width="400" height="150"></canvas>
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
<script type="text/javascript">
    var config_day_m = {
        type : 'line',
        data : {
            labels : {LABELS},
            datasets : {DATA}
        },
        options : {
            responsive : true,
            legend : {
                display : true
            },
            tooltips : {
                mode : 'index',
                intersect : false,
                titleMarginBottom : 2,
                callbacks : {
                    title : function(a, b) {
                        return 'Vị thứ ' + b.datasets[0].data[a[0].index]
                    },
                    label : function(a, b) {
                        return null;
                    }
                }
            },
            hover : {
                mode : 'nearest',
                intersect : true
            },
            scales : {
                xAxes : [ {
                    display : true,
                    scaleLabel : {
                        display : true,
                        labelString : 'Ngày báo cáo'
                    }
                } ],
                yAxes : [ {
                    display : true,
                    scaleLabel : {
                        display : true,
                        labelString : 'Vị thứ Google'
                    },
                    ticks : {
                    //stepSize: 1
                    }
                } ]
            }
        }
    };
    
    $(function() {
        new Chart(document.getElementById("myChart").getContext("2d"), config_day_m);
        
        $('#projectid').change(function(){
            window.location.href = '{BASE_URL}?projectid=' + $(this).val();
        });
    });
</script>
<!-- END: main -->