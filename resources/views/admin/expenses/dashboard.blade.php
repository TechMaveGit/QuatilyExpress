@extends('admin.layout')
@section('content')
<script src="{{ asset('assets/plugins/charts-c3/d3.v5.min.js')}}"></script>
<script src="{{ asset('assets/plugins/charts-c3/c3-chart.js')}}"></script>
<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Expense Dashboard</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Expenses</li>
            <li class="breadcrumb-item active" aria-current="page">Expense Dashboard</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->
 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid dashboard_expense">
        <div class="row">
        <div class="col-lg-12 mb-5">
                    <div class="card">
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Filter</h5>
                                </div>
                            </div>
                        <div class="card-body pb-0">
                            <form action="{{ route('expense-dashboard') }}" method="post"> @csrf
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Date Range</label>
                                        <input class="form-control expenseDatefilter" name="date_range" value="{{$date_range}}"  />
                                        
                                    </div>
                                </div>
                                
                                 <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Person Name</label>
                                        <div class="form-group">
                                            <select class="form-control select2 form-select" name="personName" data-placeholder="Choose one">
                                                <option value=""></option>
                                                @forelse ($person as $allperson)
                                                    <option value="{{ $allperson->id }}" {{ $personName == $allperson->id ? 'selected' : '' }}>
                                                        {{ $allperson->userName }} {{ $allperson->surname }} ({{ $allperson->email }})
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Rego</label>
                                        <div class="form-group">
                                            <select class="form-control select2 form-select" name="rego" data-placeholder="Choose one">
                                                <option value=""></option>
                                                @forelse ($rego as $allrego)
                                                    <option value="{{ $allrego->id }}">
                                                        {{ $allrego->rego }}
                                                    </option>
                                                @empty
                                                    {{-- Handle the case where $rego is empty --}}
                                                @endforelse
                                            </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 ">
                                 <div class="search_btn">
                                 <button type="submit" class="btn btn-primary srch_btn">Search</button>
                                 </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
        <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3 class="card-title">Overall Expense Graph</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-container">
                                            <!-- <canvas id="chartLine" class="h-275"></canvas> -->
                                            <div id="piechart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">General Expenses</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-bar-stacked" class="chartsh"></div>
                    </div>
                </div>
            </div>
               <!-- COL-END -->
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Toll Expenses</h3>
                        </div>
                        <div class="card-body">
                            <div id="chart-bar-rotated" class="chartsh"></div>
                        </div>
                    </div>
                </div>
                <!-- COL-END -->
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Operation Expenses</h3>
                        </div>
                        <div class="card-body">
                            <div id="chart-area" class="chartsh"></div>
                        </div>
                    </div>
                </div>
                <!-- col end -->
        </div>
     </div>
</div>
</div>
<script>
        /*LIne-Chart */
var ctx = document.getElementById("chartLine").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['{{$monthNames[0]}}', '{{$monthNames[1]}}', '{{$monthNames[2]}}', '{{$monthNames[3]}}', '{{$monthNames[4]}}', '{{$monthNames[5]}}', '{{$monthNames[6]}}', '{{$monthNames[7]}}', '{{$monthNames[8]}}', '{{$monthNames[9]}}', '{{$monthNames[10]}}', '{{$monthNames[11]}}'],
            datasets: [{
                label: 'Expenses',
                data: [{{ $totalExpense[0] }}, {{ $totalExpense[1] }}, {{ $totalExpense[2] }}, {{ $totalExpense[3] }}, {{ $totalExpense[4] }}, {{ $totalExpense[5] }}, {{ $totalExpense[6] }},{{ $totalExpense[7] }},{{ $totalExpense[8] }},{{ $totalExpense[9] }},{{ $totalExpense[10] }},{{ $totalExpense[11] }}],
                borderWidth: 2,
                backgroundColor: 'transparent',
                borderColor: '#f4c32b',
                borderWidth: 3,
                lineTension:0.3,
                pointBackgroundColor: '#ffffff',
                pointRadius: 2
            }
        ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        color: "#79818b",
                    },
                    display: true,
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                },
            },
            legend: {
                labels: {
                    fontColor: "#79818b"
                },
            },
        }
    });
</script>
<!---------------------------  General Expenses  -------------------->
<script>
    /*chart-bar-stacked*/
    var chart = c3.generate({
        bindto: '#chart-bar-stacked', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', {{$expenseReport[0]}}, {{$expenseReport[1]}}, {{$expenseReport[2]}}, {{$expenseReport[3]}}, {{$expenseReport[4]}}, {{$expenseReport[5]}}, {{$expenseReport[6]}} , {{$expenseReport[7]}}, {{$expenseReport[8]}}, {{$expenseReport[9]}}, {{$expenseReport[10]}}, {{$expenseReport[11]}}],
                // ['data2', {{$Clientrate[0]}}, {{$Clientrate[1]}}, {{$Clientrate[2]}}, {{$Clientrate[3]}}, {{$Clientrate[4]}}, {{$Clientrate[5]}}, {{$Clientrate[6]}} , {{$Clientrate[7]}}, {{$Clientrate[8]}}, {{$Clientrate[9]}}, {{$Clientrate[10]}}, {{$Clientrate[11]}}],
            ],
            type: 'bar', // default type of chart
            groups: [
                ['data1']
            ],
            colors: {
                data1: '#f2bf20',
            },
            names: {
                // name of each serie
                'data1': 'General Expenses',
            }
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['{{$monthNames[0]}}', '{{$monthNames[1]}}', '{{$monthNames[2]}}', '{{$monthNames[3]}}', '{{$monthNames[4]}}', '{{$monthNames[5]}}', '{{$monthNames[6]}}', '{{$monthNames[7]}}', '{{$monthNames[8]}}', '{{$monthNames[9]}}', '{{$monthNames[10]}}', '{{$monthNames[11]}}']
            },
        },
        bar: {
            width: 16
        },
        legend: {
            show: false, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });
</script>
<!------------------Toll Expenses----------------------------->
<script>
    /*chart-bar-rotated*/
    var chart = c3.generate({
           bindto: '#chart-bar-rotated', // id of chart wrapper
           data: {
               columns: [
                   // each columns data
                   ['data1', {{$tollexpense[0]}}, {{$tollexpense[1]}}, {{$tollexpense[2]}}, {{$tollexpense[3]}}, {{$tollexpense[4]}}, {{$tollexpense[5]}}, {{$tollexpense[6]}} , {{$tollexpense[7]}}, {{$tollexpense[8]}}, {{$tollexpense[9]}}, {{$tollexpense[10]}}, {{$tollexpense[11]}}],
                //    ['data2', {{$Clientrate[0]}}, {{$Clientrate[1]}}, {{$Clientrate[2]}}, {{$Clientrate[3]}}, {{$Clientrate[4]}}, {{$Clientrate[5]}}, {{$Clientrate[6]}} , {{$Clientrate[7]}}, {{$Clientrate[8]}}, {{$Clientrate[9]}}, {{$Clientrate[10]}}, {{$Clientrate[11]}}],
               ],
               type: 'bar', // default type of chart
               groups: [
                ['data1']
            ],
               colors: {
                   data1: '#f2bf20',
               },
               names: {
                   // name of each serie
                   'data1': 'Toll expense',
               }
           },
           axis: {
               x: {
                   type: 'category',
                   // name of each category
                   categories: ['{{$monthNames[0]}}', '{{$monthNames[1]}}', '{{$monthNames[2]}}', '{{$monthNames[3]}}', '{{$monthNames[4]}}', '{{$monthNames[5]}}', '{{$monthNames[6]}}', '{{$monthNames[7]}}', '{{$monthNames[8]}}', '{{$monthNames[9]}}', '{{$monthNames[10]}}', '{{$monthNames[11]}}']
               },
               rotated: true,
           },
           bar: {
               width: 15
           },
           legend: {
               show: false, //hide legend
           },
           padding: {
               bottom: 0,
               top: 0
           },
       });
  </script>
<script>
    /*chart-bar-rotated*/
    var chart = c3.generate({
        bindto: '#chart-scatter',
           data: {
               columns: [
                   // each columns data
                   ['data1', {{$operactionExp[0]}}, {{$operactionExp[1]}}, {{$operactionExp[2]}}, {{$operactionExp[3]}}, {{$operactionExp[4]}}, {{$operactionExp[5]}}, {{$operactionExp[6]}} , {{$operactionExp[7]}}, {{$operactionExp[8]}}, {{$operactionExp[9]}}, {{$operactionExp[10]}}, {{$operactionExp[11]}}],
                   ['data2', {{$Clientrate[0]}}, {{$Clientrate[1]}}, {{$Clientrate[2]}}, {{$Clientrate[3]}}, {{$Clientrate[4]}}, {{$Clientrate[5]}}, {{$Clientrate[6]}} , {{$Clientrate[7]}}, {{$Clientrate[8]}}, {{$Clientrate[9]}}, {{$Clientrate[10]}}, {{$Clientrate[11]}}],
               ],
               type: 'bar', // default type of chart
               colors: {
                   data1: '#f2bf20',
                   data2: '#05c3fb'
               },
               names: {
                   // name of each serie
                   'data1': 'Loss',
                   'data2': 'Profit'
               }
           },
           axis: {
               x: {
                   type: 'category',
                   // name of each category
                   categories: ['{{$monthNames[0]}}', '{{$monthNames[1]}}', '{{$monthNames[2]}}', '{{$monthNames[3]}}', '{{$monthNames[4]}}', '{{$monthNames[5]}}', '{{$monthNames[6]}}', '{{$monthNames[7]}}', '{{$monthNames[8]}}', '{{$monthNames[9]}}', '{{$monthNames[10]}}', '{{$monthNames[11]}}']
               },
               rotated: true,
           },
           bar: {
               width: 15
           },
           legend: {
               show: false, //hide legend
           },
           padding: {
               bottom: 0,
               top: 0
           },
       });
/*chart-area*/
var chart = c3.generate({
    bindto: '#chart-area', // id of chart wrapper
    data: {
        columns: [
            // each columns data
            ['data1', {{$operactionExp[0]}}, {{$operactionExp[1]}}, {{$operactionExp[2]}}, {{$operactionExp[3]}}, {{$operactionExp[4]}}, {{$operactionExp[5]}}, {{$operactionExp[6]}} , {{$operactionExp[7]}}, {{$operactionExp[8]}}, {{$operactionExp[9]}}, {{$operactionExp[10]}}, {{$operactionExp[11]}}],
        ],
        type: 'area', // default type of chart
        colors: {
            data1: '#6c5ffc',
        },
        names: {
            // name of each serie
            'data1': 'Operation Expenses',
        }
    },
    axis: {
        x: {
            type: 'category',
            // name of each category
            categories: ['{{$monthNames[0]}}', '{{$monthNames[1]}}', '{{$monthNames[2]}}', '{{$monthNames[3]}}', '{{$monthNames[4]}}', '{{$monthNames[5]}}', '{{$monthNames[6]}}', '{{$monthNames[7]}}', '{{$monthNames[8]}}', '{{$monthNames[9]}}', '{{$monthNames[10]}}', '{{$monthNames[11]}}']
        },
    },
    legend: {
        show: false, //hide legend
    },
    padding: {
        bottom: 0,
        top: 0
    },
});
</script>
<script>
        // Sample data for the pie chart
        var data = {
            columns: [
                ['Overall Expense', {{$overrallExpenseGraph}}],
                ['General Expenses', {{$totalexpenseQuery}}],
                ['Toll Expenses', {{$generalExpenses}}],
                ['Operation Expenses', {{$totalOperActionExp}}]
            ],
            type: 'donut',
            colors: {
                'Overall Expense': '#6b5ffc',
                'General Expenses': '#19dc3c',
                'Toll Expenses': '#57b8ff',
                'Operation Expenses': '#f1c129'
            }
        };
        // Configuration options for the chart
        var chartConfig = {
            bindto: '#piechart',
            data: data,
            legend: {
                position: 'top'
            },
            pie: {
                label: {
                    format: function (value, ratio, id) {
                        return value;
                    }
                }
            },
        };
        // Generate the pie chart
        var chart = c3.generate(chartConfig);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
    <script>
    $(".expenseDatefilter").flatpickr({
        altFormat: "Y-m-d",
        dateFormat: "Y-m-d",
        mode: "range",
        appendTo: document.body,
        onReady: function(selectedDates, dateStr, instance) {
            var setButton = document.createElement('button');
            setButton.className = 'flatpickr-set-button'; // Assigning the class 'flatpickr-set-button'
            setButton.innerHTML = 'Ok';
            setButton.onclick = function() {
                instance.close();
            };
            instance.calendarContainer.querySelector('.flatpickr-time').appendChild(setButton);
        }
    });

    </script>
@endsection
