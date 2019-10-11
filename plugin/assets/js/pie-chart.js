if ($('#donutchart').length) {
    var ctx = document.getElementById("donutchart").getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',
        // The data for our dataset
        data: {
            labels: ["tesing-purpose-used", "tesing-purpose-used-1", "tesing-purpose-use-2", "tesing-purpose-used-3"],
            datasets: [{
                backgroundColor: [
                    "#8919FE",
                    "#12C498",
                    "#F8CB3F",
                    "#E36D68"
                ],
                borderColor: '#fff',
                data: [810, 410, 260, 150],
            }]
        },
        // Configuration options go here
        options: {
            legend: {
                display: true
            },
            animation: {
                easing: "easeInOutBack"
            }
        }
	});
}