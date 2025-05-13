  // Navigation
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
      if (this.getAttribute('data-section')) {
        e.preventDefault();
        
        // Remove active class from all nav links
        document.querySelectorAll('.nav-link').forEach(navLink => {
          navLink.classList.remove('active');
        });
        
        // Add active class to clicked link
        this.classList.add('active');
        
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(section => {
          section.classList.remove('active');
        });
        
        // Show the selected section
        const sectionId = this.getAttribute('data-section') + '-section';
        document.getElementById(sectionId).classList.add('active');
        document.getElementById(sectionId).classList.add('fade-in');
        
        // Close sidebar on mobile after navigation
        if (window.innerWidth < 768) {
          document.getElementById('sidebar1').classList.remove('active');
        }
      }
    });
  });
  
    
    // Employment Trends Chart
    if (document.getElementById('employmentTrendsChart')) {
      const employmentTrendsCtx = document.getElementById('employmentTrendsChart').getContext('2d');
      const employmentTrendsChart = new Chart(employmentTrendsCtx, {
        type: 'line',
        data: {
          labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
          datasets: [
            {
              label: 'Job Seekers',
              data: [35000, 38000, 42000, 45000, 48000, 52000],
              borderColor: '#e74c3c',
              backgroundColor: 'rgba(231, 76, 60, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Placements',
              data: [20000, 22000, 25000, 28000, 32000, 35000],
              borderColor: '#2ecc71',
              backgroundColor: 'rgba(46, 204, 113, 0.1)',
              tension: 0.4,
              fill: true
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
                text: 'Number of People'
              }
            }
          }
        }
      });
    }
    
    // Job Sectors Chart
    if (document.getElementById('jobSectorsChart')) {
      const jobSectorsCtx = document.getElementById('jobSectorsChart').getContext('2d');
      const jobSectorsChart = new Chart(jobSectorsCtx, {
        type: 'pie',
        data: {
          labels: ['IT & Software', 'Manufacturing', 'Healthcare', 'Education', 'Retail', 'Others'],
          datasets: [{
            data: [35, 25, 15, 10, 8, 7],
            backgroundColor: [
              '#3498db',
              '#2ecc71',
              '#e74c3c',
              '#f39c12',
              '#9b59b6',
              '#34495e'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    }
  
  // Set the first section as active by default
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('dashboard-section').classList.add('active');
  });