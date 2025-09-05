<div class="tab-pane fade show active" id="navs-pills-justified-tab1"
                                        role="tabpanel">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <button type="button"
                                                    onclick="loadChartData({{$floors_previous_id}})"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-left"></i></button>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5 class="mb-0">มิเตอร์น้ำ{{ $rooms[0]->floor->name }}</h5>
                                            </div>
                                            <div class="col-sm-2 text-end">
                                                <button type="button"
                                                    onclick="loadChartData({{$floors_next_id}})"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-right"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach ($rooms as $room)
                                                <div class="col-sm-6">
                                                    <div class="card mb-3">
                                                        <div class="card-header d-flex justify-content-between">
                                                            <div class="card-title mb-0">
                                                                <h4 class="mb-0">{{ $room->name }}</h4>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="chart{{$room->id}}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <script>
                                                    var options = {
                                                        series: [{
                                                            data: @json($room->months['water'])
                                                        }],
                                                        chart: {
                                                            height: 400,
                                                            type: 'line',
                                                            parentHeightOffset: 0,
                                                            zoom: {
                                                                enabled: false
                                                            },
                                                            toolbar: {
                                                                show: false
                                                            }
                                                        },
                                                        dataLabels: {
                                                            enabled: false
                                                        },
                                                        stroke: {
                                                            curve: 'straight'
                                                        },
                                                        colors: ['#00BAD1'],
                                                        grid: {
                                                            borderColor: '#ececed',
                                                            xaxis: {
                                                                lines: {
                                                                    show: true
                                                                }
                                                            },
                                                            padding: {
                                                                top: -20
                                                            }
                                                        },
                                                        xaxis: {
                                                            categories: @json($months),
                                                            axisBorder: {
                                                                show: false
                                                            },
                                                            axisTicks: {
                                                                show: false
                                                            },
                                                            labels: {
                                                                style: {
                                                                    colors: '#444050',
                                                                    fontSize: '13px',
                                                                    fontFamily: 'IBM Plex sans thai, sans-serif',
                                                                }
                                                            }
                                                        },
                                                        yaxis: {
                                                            labels: {
                                                                style: {
                                                                    colors: '#444050',
                                                                    fontSize: '13px',
                                                                    fontFamily: 'IBM Plex sans thai, sans-serif',
                                                                }
                                                            }
                                                        }
                                                    };

                                                    var chart = new ApexCharts(document.querySelector("#chart{{$room->id}}"), options);
                                                    chart.render();
                                                </script>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-justified-tab2" role="tabpanel">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <button type="button"
                                                    onclick="loadChartData({{$floors_previous_id}})"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-left"></i></button>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5 class="mb-0">มิเตอร์ไฟฟ้า{{ $rooms[0]->floor->name }}</h5>
                                            </div>
                                            <div class="col-sm-2 text-end">
                                                <button type="button"
                                                    onclick="loadChartData({{$floors_next_id}})"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-right"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach ($rooms as $room)
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">{{ $room->name }}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chartE{{$room->id}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                                <script>
                                                    var options = {
                                                        series: [{
                                                            data: @json($room->months['elect'])
                                                        }],
                                                        chart: {
                                                            height: 400,
                                                            type: 'line',
                                                            parentHeightOffset: 0,
                                                            zoom: {
                                                                enabled: false
                                                            },
                                                            toolbar: {
                                                                show: false
                                                            }
                                                        },
                                                        dataLabels: {
                                                            enabled: false
                                                        },
                                                        stroke: {
                                                            curve: 'straight'
                                                        },
                                                        colors: ['#FF4C51'],
                                                        grid: {
                                                            borderColor: '#ececed',
                                                            xaxis: {
                                                                lines: {
                                                                    show: true
                                                                }
                                                            },
                                                            padding: {
                                                                top: -20
                                                            }
                                                        },
                                                        xaxis: {
                                                            categories: @json($months),
                                                            axisBorder: {
                                                                show: false
                                                            },
                                                            axisTicks: {
                                                                show: false
                                                            },
                                                            labels: {
                                                                style: {
                                                                    colors: '#444050',
                                                                    fontSize: '13px',
                                                                    fontFamily: 'IBM Plex sans thai, sans-serif',
                                                                }
                                                            }
                                                        },
                                                        yaxis: {
                                                            labels: {
                                                                style: {
                                                                    colors: '#444050',
                                                                    fontSize: '13px',
                                                                    fontFamily: 'IBM Plex sans thai, sans-serif',
                                                                }
                                                            }
                                                        }
                                                    };

                                                    var chart = new ApexCharts(document.querySelector("#chartE{{$room->id}}"), options);
                                                    chart.render();
                                                </script>
                                            @endforeach
                                        </div>
                                    </div>

                                        
                                        