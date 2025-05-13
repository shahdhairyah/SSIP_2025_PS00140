 // Toggle Sidebar on Mobile
 document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('active');
  });
  
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
          document.getElementById('sidebar').classList.remove('active');
        }
      }
    });
  });
  
  // Initialize Charts
  document.addEventListener('DOMContentLoaded', function() {
    // Department Performance Chart
    const departmentPerformanceCtx = document.getElementById('departmentPerformanceChart').getContext('2d');
    const departmentPerformanceChart = new Chart(departmentPerformanceCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
          {
            label: 'Labour',
            data: [65, 72, 68, 75, 82, 85],
            borderColor: '#3498db',
            backgroundColor: 'rgba(52, 152, 219, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'Skill Development',
            data: [54, 60, 67, 72, 78, 82],
            borderColor: '#2ecc71',
            backgroundColor: 'rgba(46, 204, 113, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'Employment',
            data: [42, 50, 58, 65, 70, 75],
            borderColor: '#e74c3c',
            backgroundColor: 'rgba(231, 76, 60, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'Industrial Relations',
            data: [60, 65, 62, 68, 75, 80],
            borderColor: '#f39c12',
            backgroundColor: 'rgba(243, 156, 18, 0.1)',
            tension: 0.4,
            fill: true
          },
          {
            label: 'Factories & Boilers',
            data: [58, 62, 65, 70, 75, 78],
            borderColor: '#9b59b6',
            backgroundColor: 'rgba(155, 89, 182, 0.1)',
            tension: 0.4,
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: false
          }
        },
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
    
    // Budget Allocation Chart
    const budgetAllocationCtx = document.getElementById('budgetAllocationChart').getContext('2d');
    const budgetAllocationChart = new Chart(budgetAllocationCtx, {
      type: 'doughnut',
      data: {
        labels: ['Labour', 'Skill Development', 'Employment', 'Industrial Relations', 'Factories & Boilers'],
        datasets: [{
          data: [25, 30, 20, 15, 10],
          backgroundColor: [
            '#3498db',
            '#2ecc71',
            '#e74c3c',
            '#f39c12',
            '#9b59b6'
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
    
    // Labour Welfare Chart
    if (document.getElementById('labourWelfareChart')) {
      const labourWelfareCtx = document.getElementById('labourWelfareChart').getContext('2d');
      const labourWelfareChart = new Chart(labourWelfareCtx, {
        type: 'bar',
        data: {
          labels: ['Scheme 1', 'Scheme 2', 'Scheme 3', 'Scheme 4', 'Scheme 5', 'Scheme 6'],
          datasets: [
            {
              label: 'Target',
              data: [1000, 1200, 800, 1500, 900, 1100],
              backgroundColor: 'rgba(52, 152, 219, 0.2)',
              borderColor: 'rgba(52, 152, 219, 1)',
              borderWidth: 1
            },
            {
              label: 'Achieved',
              data: [850, 1100, 720, 1250, 800, 950],
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
                text: 'Beneficiaries'
              }
            }
          }
        }
      });
    }
    
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
    
    // Dispute Resolution Chart
    if (document.getElementById('disputeResolutionChart')) {
      const disputeResolutionCtx = document.getElementById('disputeResolutionChart').getContext('2d');
      const disputeResolutionChart = new Chart(disputeResolutionCtx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'New Cases',
              data: [45, 38, 42, 35, 40, 42],
              backgroundColor: '#f39c12'
            },
            {
              label: 'Resolved Cases',
              data: [30, 35, 38, 32, 36, 38],
              backgroundColor: '#2ecc71'
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
                text: 'Number of Cases'
              }
            }
          }
        }
      });
    }
    
    // Industry Distribution Chart
    if (document.getElementById('industryDistributionChart')) {
      const industryDistributionCtx = document.getElementById('industryDistributionChart').getContext('2d');
      const industryDistributionChart = new Chart(industryDistributionCtx, {
        type: 'doughnut',
        data: {
          labels: ['Manufacturing', 'Textiles', 'Chemicals', 'Electronics', 'Food Processing', 'Others'],
          datasets: [{
            data: [30, 25, 15, 12, 10, 8],
            backgroundColor: [
              '#f39c12',
              '#3498db',
              '#e74c3c',
              '#2ecc71',
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
    
    // Safety Compliance Chart
    if (document.getElementById('safetyComplianceChart')) {
      const safetyComplianceCtx = document.getElementById('safetyComplianceChart').getContext('2d');
      const safetyComplianceChart = new Chart(safetyComplianceCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'Compliance Rate',
              data: [75, 78, 80, 82, 85, 86],
              borderColor: '#3498db',
              backgroundColor: 'rgba(52, 152, 219, 0.1)',
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
              max: 100,
              title: {
                display: true,
                text: 'Compliance Rate (%)'
              }
            }
          }
        }
      });
    }
    
    // Inspection Results Chart
    if (document.getElementById('inspectionResultsChart')) {
      const inspectionResultsCtx = document.getElementById('inspectionResultsChart').getContext('2d');
      const inspectionResultsChart = new Chart(inspectionResultsCtx, {
        type: 'pie',
        data: {
          labels: ['Compliant', 'Minor Issues', 'Major Issues', 'Non-Compliant'],
          datasets: [{
            data: [65, 20, 10, 5],
            backgroundColor: [
              '#2ecc71',
              '#f39c12',
              '#e67e22',
              '#e74c3c'
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
    
    // Project Budget Chart
    if (document.getElementById('projectBudgetChart')) {
      const projectBudgetCtx = document.getElementById('projectBudgetChart').getContext('2d');
      const projectBudgetChart = new Chart(projectBudgetCtx, {
        type: 'bar',
        data: {
          labels: ['Labour', 'Skill Dev.', 'Employment', 'Industrial', 'Factories'],
          datasets: [
            {
              label: 'Allocated Budget',
              data: [45, 38, 52, 40, 48],
              backgroundColor: 'rgba(52, 152, 219, 0.7)'
            },
            {
              label: 'Utilized Budget',
              data: [30, 25, 35, 20, 30],
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
    
    // Project Status Chart
    if (document.getElementById('projectStatusChart')) {
      const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
      const projectStatusChart = new Chart(projectStatusCtx, {
        type: 'doughnut',
        data: {
          labels: ['On Track', 'Delayed', 'At Risk', 'Completed'],
          datasets: [{
            data: [60, 20, 10, 10],
            backgroundColor: [
              '#2ecc71',
              '#f39c12',
              '#e74c3c',
              '#3498db'
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
    
    // Report Frequency Chart
    if (document.getElementById('reportFrequencyChart')) {
      const reportFrequencyCtx = document.getElementById('reportFrequencyChart').getContext('2d');
      const reportFrequencyChart = new Chart(reportFrequencyCtx, {
        type: 'bar',
        data: {
          labels: ['Monthly', 'Quarterly', 'Half-Yearly', 'Annual', 'Special'],
          datasets: [{
            label: 'Number of Reports',
            data: [25, 18, 12, 8, 15],
            backgroundColor: [
              '#3498db',
              '#2ecc71',
              '#f39c12',
              '#e74c3c',
              '#9b59b6'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Reports'
              }
            }
          }
        }
      });
    }
    
    // Reports by Department Chart
    if (document.getElementById('reportsByDepartmentChart')) {
      const reportsByDepartmentCtx = document.getElementById('reportsByDepartmentChart').getContext('2d');
      const reportsByDepartmentChart = new Chart(reportsByDepartmentCtx, {
        type: 'pie',
        data: {
          labels: ['Labour', 'Skill Development', 'Employment', 'Industrial Relations', 'Factories & Boilers'],
          datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
              '#3498db',
              '#2ecc71',
              '#e74c3c',
              '#f39c12',
              '#9b59b6'
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
    
    // Notification Categories Chart
    if (document.getElementById('notificationCategoriesChart')) {
      const notificationCategoriesCtx = document.getElementById('notificationCategoriesChart').getContext('2d');
      const notificationCategoriesChart = new Chart(notificationCategoriesCtx, {
        type: 'doughnut',
        data: {
          labels: ['System Updates', 'Reports', 'Meetings', 'Tasks', 'Alerts'],
          datasets: [{
            data: [25, 30, 15, 20, 10],
            backgroundColor: [
              '#3498db',
              '#2ecc71',
              '#f39c12',
              '#9b59b6',
              '#e74c3c'
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
  });
  
  // Set the first section as active by default
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('dashboard-section').classList.add('active');
  });