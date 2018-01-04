<canvas id="myChart" width="100%" height="40%"></canvas>

<script>

$(function () {
   var ctx = document.getElementById("myChart").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'line',
       data: {
           labels: [{{ implode(',', $label) }}],
           datasets: [{
               label: '皇冠',
               data: [{{ implode(',', $crown) }}],
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
               ],
               borderColor: [
                   'rgba(255,99,132,1)',
               ],
               borderWidth: 1
           }, {
               label: '星星',
               data: [{{ implode(',', $stars) }}],
               backgroundColor: [
                   'rgba(54, 162, 235, 0.2)',
               ],
               borderColor: [
                   'rgba(54, 162, 235, 1)',
               ],
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           }
       }
   }); 
});
</script>
