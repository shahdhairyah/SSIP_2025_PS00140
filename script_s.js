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
  

    
    // Skill Enrollment Chart
    if (document.getElementById('skillEnrollmentChart')) {
      const skillEnrollmentCtx = document.getElementById('skillEnrollmentChart').getContext('2d');
      const skillEnrollmentChart = new Chart(skillEnrollmentCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'IT & Software',
              data: [1200, 1350, 1500, 1650, 1800, 2000],
              borderColor: '#2ecc71',
              backgroundColor: 'rgba(46, 204, 113, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Manufacturing',
              data: [800, 850, 900, 950, 1000, 1050],
              borderColor: '#3498db',
              backgroundColor: 'rgba(52, 152, 219, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Healthcare',
              data: [600, 650, 700, 750, 800, 850],
              borderColor: '#e74c3c',
              backgroundColor: 'rgba(231, 76, 60, 0.1)',
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
                text: 'Number of Trainees'
              }
            }
          }
        }
      });
    }

  
  // Set the first section as active by default
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('dashboard-section').classList.add('active');
  });