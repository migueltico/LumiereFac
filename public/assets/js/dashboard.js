$(document).ready(function () {
    startChars = async function () {
        let data1 = await getMoreSalesPerMonth()
        let data2 = await getLastWeekSales()
        console.log(data1, data2)
        let ctx1 = document.getElementById("getMoreSalesPerMonth").getContext("2d");
        let ctx2 = document.getElementById("getLastWeekSales").getContext("2d");
        let columnsName = []




        let myChart1 = new Chart(ctx1, {
            type: "pie",
            data: {
                labels: [...data1.columns],
                datasets: [{
                    label: '',
                    data: [...data1.cantidad],
                    backgroundColor: [
                        `rgb(235, 52, 103,1)`,
                        `rgb(52, 160, 237,1)`,
                        `rgb(52, 237, 172,1)`,
                        `rgb(255, 218, 33,1)`,
                        `rgb(196, 69, 255,1)`, //5
                        `rgb(255, 69, 218,1)`,
                        `rgb(196, 110, 255,1)`,
                        `rgb(58, 80, 230,1)`,
                    ]
                }]
            },
            options: {

                fill: false,
                responsive: true,
                legend: {
                    position: 'bottom'

                },
                title: {
                    display: true,
                    text: '6 Productos con mayor ventas en los ultimos 30 dias corridos',
                    fontSize: 18
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }

            }
        });
        let myChart2 = new Chart(ctx2, {
            type: "bar",
            data: {
                labels: [...data2.columns],
                datasets: [{
                    label: '',
                    data: [...data2.cantidad],
                    backgroundColor: [
                        `rgb(235, 52, 103,1)`,
                        `rgb(52, 160, 237,1)`,
                        `rgb(52, 237, 172,1)`,
                        `rgb(196, 110, 255,1)`,
                        `rgb(255, 218, 33,1)`,
                        `rgb(255, 69, 218,1)`,
                        `rgb(196, 69, 255,1)`, 
                    ]
                }],
                minBarLength: 2,
            },
            options: {

                fill: false,
                responsive: true,
                legend: {
                    position: 'bottom'

                },
                title: {
                    display: true,
                    text: 'Ventas Diarias en Semana actual',
                    fontSize: 18
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0, // minimum will be 0, unless there is a lower value.
                            // OR //
                            beginAtZero: true // minimum value will be 0.
                        }
                    }]

                }

            }
        });
    }
    startChars()


})
async function getMoreSalesPerMonth() {
    let data = await fetch("/estadisticas/getMoreSalesPerMonth", {
        method: "POST"
    })
    let json = await data.json()
    return json
}
async function getLastWeekSales() {
    let data = await fetch("/estadisticas/getLastWeekSales", {
        method: "POST"
    })
    let json = await data.json()
    return json
}

function randColor() {
    return Math.floor(Math.random() * 255);
}