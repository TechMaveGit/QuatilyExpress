$(function() {
	"use strict";









    /* Bar-Chart1 */
    var ctx = document.getElementById("chartBar1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Cherry Blossom", "Simon Sais", "Manny Jah", "Florinda Carasco", "Ivan Notheridiya", "Willie Findit", "Addie Minstra", "Laura Biding", "Paul"],
            datasets: [{
                label: 'Delivery Ratio',
                data: [200, 450, 290, 367, 256, 543, 345, 290, 367],
                borderWidth: 2,
                backgroundColor: '#f4c32b',
                borderColor: '#f4c32b',
                borderWidth: 2.0,
                pointBackgroundColor: '#ffffff',

            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true
            },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        stepSize: 150,
                        color: "#79818b",
                    },
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                },
                x: {
                    barPercentage: 0.4,
                    barValueSpacing: 0,
                    barDatasetSpacing: 0,
                    barRadius: 0,
                    ticks: {
                        display: true,
                        color: "#79818b",
                    },
                    grid: {
                        display: false,
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                }
            },
            legend: {
                labels: {
                    fontColor: "#79818b"
                },
            },
        }
    });






    /* Area Chart*/
    var ctx = document.getElementById("chartArea");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [{
                label: "Data1",
                borderColor: "#6c5ffc",
                borderWidth: "3",
                lineTension:0.3,
                backgroundColor: "rgba(108, 95, 252, .1)",
                fill: true,
                data: [22, 44, 67, 43, 76, 45, 12]
            }, {
                label: "Data2",
                borderColor: "rgba(5, 195, 251 ,0.9)",
                borderWidth: "3",
                lineTension:0.3,
                backgroundColor: "rgba(5, 195, 251, 0.7)",
                pointHighlightStroke: "rgba(5, 195, 251 ,1)",
                fill: true,
                data: [16, 32, 18, 26, 42, 33, 44]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                x: {
                    ticks: {
                        color: "#79818b",
                    },
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                },
                yAxes: {
                    ticks: {
                        beginAtZero: true,
                        color: "#79818b",
                    },
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    },
                }
            },
            legend: {
                labels: {
                    color: "#79818b"
                },
            },
        }
    });

    /* Pie Chart*/
    var datapie = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
            data: [20, 20, 30, 5, 25],
            backgroundColor: ['#6c5ffc', '#05c3fb', '#09ad95', '#1170e4', '#e82646']
        }]
    };
    var optionpie = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false,
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };

    /* Doughbut Chart*/
    var ctx6 = document.getElementById('chartPie');
    var myPieChart6 = new Chart(ctx6, {
        type: 'doughnut',
        data: datapie,
        options: optionpie
    });

    /* Pie Chart*/
    var ctx7 = document.getElementById('chartDonut');
    var myPieChart7 = new Chart(ctx7, {
        type: 'pie',
        data: datapie,
        options: optionpie
    });

    /* Radar chart*/
    var ctx = document.getElementById("chartRadar");
    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [

                ["Eating", "Dinner"],
                ["Drinking", "Water"], "Sleeping", ["Designing", "Graphics"], "Coding", "Cycling", "Running",

            ],
            datasets: [{

                label: "Data1",
                data: [65, 59, 66, 45, 56, 55, 40],
                borderColor: "rgba(108, 95, 252, .8)",
                borderWidth: "1",
                backgroundColor: "rgba(108, 95, 252, .4)"
            }, {
                label: "Data2",
                data: [28, 12, 40, 19, 63, 27, 87],
                borderColor: "rgba(5, 195, 251,0.8)",
                borderWidth: "1",
                backgroundColor: "rgba(5, 195, 251,0.4)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scale: {
                angleLines: { color: '#79818b' },
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                },
                ticks: {
                    beginAtZero: true,
                    color: 'rgba(119, 119, 142, 0.2)'
                },
                pointLabels: {
                    color: '#79818b',
                },
            },

        }
    });

    /* polar chart */
    var ctx = document.getElementById("chartPolar");
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            datasets: [{
                data: [18, 15, 9, 6, 19],
                backgroundColor: ['#6c5ffc', '#05c3fb', '#09ad95', '#1170e4', '#e82646'],
                hoverBackgroundColor: ['#6c5ffc', '#05c3fb', '#09ad95', '#1170e4', '#e82646'],
                borderColor: 'transparent',
            }],
            labels: ["Data1", "Data2", "Data3", "Data4"]
        },
        options: {
            scale: {
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                labels: {
                    color: "#79818b"
                },
            },
        }
    });

});
