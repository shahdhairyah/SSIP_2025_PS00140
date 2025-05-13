// Initialize all charts
function initializeCharts(data) {
    // Performance Chart
    const performanceCtx = document.getElementById('performanceChart')?.getContext('2d');
    if (performanceCtx) {
        new Chart(performanceCtx, {
            type: 'line',
            data: {
                labels: data.performance.map(item => item.month),
                datasets: [{
                    label: 'Performance Score',
                    data: data.performance.map(item => item.value),
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Performance Score'
                        }
                    }
                }
            }
        });
    }

    // Welfare Projects Chart
    const welfareCtx = document.getElementById('welfareChart')?.getContext('2d');
    if (welfareCtx) {
        new Chart(welfareCtx, {
            type: 'bar',
            data: {
                labels: data.welfare.labels,
                datasets: [
                    {
                        label: 'Target',
                        data: data.welfare.target,
                        backgroundColor: 'rgba(52, 152, 219, 0.2)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Achieved',
                        data: data.welfare.achieved,
                        backgroundColor: 'rgba(46, 204, 113, 0.2)',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Beneficiaries'
                        }
                    }
                }
            }
        });
    }

    // Budget Utilization Chart
    const budgetCtx = document.getElementById('budgetChart')?.getContext('2d');
    if (budgetCtx) {
        new Chart(budgetCtx, {
            type: 'bar',
            data: {
                labels: data.budget.labels,
                datasets: [
                    {
                        label: 'Allocated Budget',
                        data: data.budget.allocated,
                        backgroundColor: 'rgba(52, 152, 219, 0.7)'
                    },
                    {
                        label: 'Utilized Budget',
                        data: data.budget.utilized,
                        backgroundColor: 'rgba(46, 204, 113, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Budget (in Lakhs ₹)'
                        }
                    }
                }
            }
        });
    }
}

// Initialize sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Sidebar
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Initialize charts with data from PHP
    const chartData = {
        performance: JSON.parse(document.getElementById('chartData')?.dataset.performance || '[]'),
        welfare: JSON.parse(document.getElementById('chartData')?.dataset.welfare || '{}'),
        budget: JSON.parse(document.getElementById('chartData')?.dataset.budget || '{}')
    };

    initializeCharts(chartData);
});