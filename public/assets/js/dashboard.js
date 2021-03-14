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
                        `rgb(235, 52, 103,0.8)`,
                        `rgb(52, 160, 237,0.8)`,
                        `rgb(52, 237, 172,0.8)`,
                        `rgb(255, 218, 33,0.8)`,
                        `rgb(196, 69, 255,0.8)`,
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
                    text: 'Producto con mayor ventas en los ultimos 30 dias',
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