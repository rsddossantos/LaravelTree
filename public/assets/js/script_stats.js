let Grafico = document.getElementById('rel').getContext('2d');
let chart = new Chart(Grafico, {
    type: 'bar',
    data: {
        labels: date,
        datasets: [{
            label: 'Qtde. de Acessos - Últimos 30 dias',
            data: qtde,
            backgroundColor: "#3b5998"
        }]
    }
});
