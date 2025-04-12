<div x-data="{
        categories: {{ json_encode($this->categories) }},
        init() {
            this.createChart();
        },
        createChart() {
            if (window.categoryChart) window.categoryChart.destroy();
            
            const labels = Object.keys(this.categories);
            const data = Object.values(this.categories);
            
            window.categoryChart = new Chart(this.$refs.chartCanvas, {
                type: 'bar',
                data: { 
                    labels: labels,
                    datasets: [{
                        label: 'Total Assigned',
                        data: data,
                        backgroundColor: '#1D77FF'
                    }]
                },
                options: { 

                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Total Assigned: ${context.raw}`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Most Assigned Category',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        }
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: { 
                                precision: 0,
                                stepSize: 1 
                            } 
                        } 
                    } 
                }
            });
        }
    }">





    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">


        <div class="bg-white p-4 rounded-md shadow-md col-span-12 lg:col-span-3">
            <canvas x-ref="chartCanvas" class="w-full" style="height: 300px;"></canvas>
        </div>

        <div class="bg-white p-4 rounded-md shadow-md col-span-12 lg:col-span-9">
            @include('components.reports.completed')
        </div>
    </div>

</div>