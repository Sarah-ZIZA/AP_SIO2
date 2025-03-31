document.addEventListener("DOMContentLoaded", function () {
  // Récupérer les patients (Bar Chart)
  fetch("ajax_data.php?ajax=patients")
    .then((response) => response.json())
    .then((data) => {
      console.log("Données reçues (Patients):", data);
      const ctx = document.getElementById("myBarChart").getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: data.labels,
          datasets: [
            {
              label: "Nombre de patients",
              data: data.patients,
              backgroundColor: [
                "rgba(255, 99, 132, 0.6)",
                "rgba(54, 162, 235, 0.6)",
                "rgba(255, 206, 86, 0.6)",
                "rgba(75, 192, 192, 0.6)",
                "rgba(153, 102, 255, 0.6)",
                "rgba(255, 159, 64, 0.6)",
              ],
              borderColor: [
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)",
              ],
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: { y: { beginAtZero: true } },
        },
      });
    })
    .catch((error) => console.error("Erreur (Patients) :", error));

  // Récupérer les hospitalisations (Doughnut Chart)
  fetch("ajax_data.php?ajax=hospitalisations")
    .then((response) => response.json())
    .then((data) => {
      console.log("Données reçues (Hospitalisations):", data);
      const ctx = document.getElementById("myDoughnutChart").getContext("2d");
      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: data.labels,
          datasets: [
            {
              label: "Chirurgie ambulatoire",
              data: data.chirurgie,
              backgroundColor: "#36A2EB",
            },
            {
              label: "Hospitalisation Nuit",
              data: data.nuit,
              backgroundColor: "#FF6384",
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: "top" },
            title: {
              display: true,
              text: "Répartition des Hospitalisations par Mois",
            },
          },
        },
      });
    })
    .catch((error) => console.error("Erreur (Hospitalisations) :", error));
});
