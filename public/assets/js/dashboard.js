$(document).ready(function () {
    startChars = async function () {
        let data = await getMoreSalesPerMonth()
        console.log(data)
        let ctx = document.getElementById("myChart").getContext("2d");
        let columnsName = []




        let myChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: [...data.columns],
                datasets: [{
                    label: '',
                    data: [...data.cantidad],
                    backgroundColor: [
                        `rgb(235, 52, 103,1)`,
                        `rgb(52, 160, 237,1)`,
                        `rgb(52, 237, 172,1)`,
                        `rgb(255, 218, 33,1)`,
                        `rgb(196, 69, 255,1)`,//5
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

function randColor() {
    return Math.floor(Math.random() * 255);
}