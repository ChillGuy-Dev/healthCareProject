document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    const progressCtx = document.getElementById('progressChart').getContext('2d');
    
    const progressChart = new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
            datasets: [
                {
                    label: 'Cân nặng (kg)',
                    data: [68.5, 67.8, 67.2, 66.1, 65.2],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Tỷ lệ mỡ (%)',
                    data: [22.5, 21.8, 20.4, 19.2, 18.3],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    // Form Validation
    const measurementForm = document.getElementById('measurementForm');
    if (measurementForm) {
        measurementForm.addEventListener('submit', function(e) {
            const height = parseFloat(document.getElementById('height').value);
            const weight = parseFloat(document.getElementById('weight').value);
            
            if (height <= 0 || weight <= 0) {
                e.preventDefault();
                alert('Vui lòng nhập giá trị hợp lệ cho chiều cao và cân nặng');
                return false;
            }
        });
    }
});