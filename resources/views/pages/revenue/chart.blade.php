@php
    $completed = $impoundings_count->whereNotNull('release_date')->count();
    $progress = $impoundings_count->count() -  $impoundings_count->whereNotNull('release_date')->count() ;
@endphp
<script>
    "use strict";

    ! function(NioApp, $) {
        "use strict";

        var orderStatistics = {
            labels: ["Released Vehicles", "Impounded Vehicles"],
            dataUnit: 'People',
            legend: false,
            datasets: [{
                borderColor: "#fff",
                background: ["#1EE0AC", "#E85347"],
                data: [{{ $completed }}, {{ $progress }}]
            }]
        };

        function ecommerceDoughnutS1(selector, set_data) {
            var $selector = selector ? $(selector) : $('.ecommerce-doughnut-s1');
            $selector.each(function() {
                var $self = $(this),
                    _self_id = $self.attr('id'),
                    _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        backgroundColor: _get_data.datasets[i].background,
                        borderWidth: 2,
                        borderColor: _get_data.datasets[i].borderColor,
                        hoverBorderColor: _get_data.datasets[i].borderColor,
                        data: _get_data.datasets[i].data
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        rotation: -1.5,
                        cutoutPercentage: 70,
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][
                                        tooltipItem['index']
                                    ] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#1c2b46',
                            titleFontSize: 13,
                            titleFontColor: '#fff',
                            titleMarginBottom: 6,
                            bodyFontColor: '#fff',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: false
                        }
                    }
                });
            });
        } // init chart


        NioApp.coms.docReady.push(function() {
            ecommerceDoughnutS1();
        });
    }(NioApp, jQuery);
</script>
