<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

requireUser();



?>
    
    
    
    
    <link rel="stylesheet" href="css/networks.css">
<div class="container-fluid">
  <div class="row">
    <div class="col bg-success">
      

 <button class="btn1" onclick="showInfo()">Show System Info</button>
<div class="info-card" id="infoCard">
    <h2>🔎 Your System Information</h2>
    <div class="info-item"><b>Browser:</b> <span id="browser"></span></div>
    <div class="info-item"><b>Platform:</b> <span id="platform"></span></div>
    <div class="info-item"><b>Language:</b> <span id="language"></span></div>
    <div class="info-item"><b>Online Status:</b> <span id="online"></span></div>
    <div class="info-item"><b>Screen Size:</b> <span id="screen"></span></div>
    <div class="info-item"><b>Network Connection:</b> <span id="network"></span></div>
  </div>












    </div>
    <div class="col bg-warning">Chart
 <div class="chart-card">
    <div class="chart-header">
      <h2>Website Traffic</h2>
      <button id="refresh" style="background:#6ee7b7;color:#111;padding:8px 12px;border:none;border-radius:8px;cursor:pointer;">
        Refresh Data
      </button>
    </div>

    <canvas id="myChart"></canvas>

    <div class="chart-footer">
      Last updated: <span id="lastUpdated">just now</span>
    </div>
  </div>
  </div>
    <div class="col bg-success">
      
<p>About this project</p>

<ul>
  <li>-manipuleaza date dintr-o baza de date construita in php cu mysql</li>

  <li>se utilizeaza html,css ca structura a infertei a acestui aplicatii</li>
  <li>se foloseste jquery si javascript pentru o interfata mai dinamica si mai usor de utilizat de catre utilizator</li>

</ul>

<h3>Ce face acest proiect?</h3>
<p>
   <p>1. Se construieste o baza de date in care datele sunt manipulate de acesta interfata a aplicatie web.</p>
    <p> 2. Se face inserari ,actualizari si stergere  dintr-o baza de date</p>
    <p> 3. Se afiseaza datele pe interfata in care are button de adaguare ,editare si stergere din baza resepctiva</p>
    <p> 4. Este folosit Jquery ca paginare a dateleor care sunt afisate pe pagina.</p>
    <p> 5.Query(interogari)-Pe acesta interfata se ruleaza interogari din baza date si pot face probleme de tip "select * form table";</p>

</p>


    </div>
  </div>


  <div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
</div>
<p>
    <a href="index.php?page=logout" class="btn btn-danger">Sign Out of Your Account</a>
</p>

 
<div class="box-container">
                <div class="box box1">
                    <div class="text">
                        <h2 >60.5k</h2>
                        <h2 class="topic">Article Views</h2>
                    </div>

                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png"
                        alt="Views" />
                </div>

                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading">150</h2>
                        <h2 class="topic">Likes</h2>
                    </div>

                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185030/14.png" alt="likes" />
                </div>

                <div class="box box3">
                    <div class="text">
                        <h2 class="topic-heading">320</h2>
                        <h2 class="topic">Comments</h2>
                    </div>

                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(32).png"
                        alt="comments" />
                </div>

                <div class="box box4">
                    <div class="text">
                        <h2 class="topic-heading">70</h2>
                        <h2 class="topic">Published</h2>
                    </div>

                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png"
                        alt="published" />
                </div>
            </div>

 <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Recent Articles</h1>
                    <button class="view">View All</button>
                </div>

                <div class="report-body">
                    <div class="report-topic-heading">
                        <h3 class="t-op">Article</h3>
                        <h3 class="t-op">Views</h3>
                        <h3 class="t-op">Comments</h3>
                        <h3 class="t-op">Status</h3>
                    </div>

                    <div class="items">
                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 73</h3>
                            <h3 class="t-op-nextlvl">2.9k</h3>
                            <h3 class="t-op-nextlvl">210</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 72</h3>
                            <h3 class="t-op-nextlvl">1.5k</h3>
                            <h3 class="t-op-nextlvl">360</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 71</h3>
                            <h3 class="t-op-nextlvl">1.1k</h3>
                            <h3 class="t-op-nextlvl">150</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 70</h3>
                            <h3 class="t-op-nextlvl">1.2k</h3>
                            <h3 class="t-op-nextlvl">420</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 69</h3>
                            <h3 class="t-op-nextlvl">2.6k</h3>
                            <h3 class="t-op-nextlvl">190</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 68</h3>
                            <h3 class="t-op-nextlvl">1.9k</h3>
                            <h3 class="t-op-nextlvl">390</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 67</h3>
                            <h3 class="t-op-nextlvl">1.2k</h3>
                            <h3 class="t-op-nextlvl">580</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 66</h3>
                            <h3 class="t-op-nextlvl">3.6k</h3>
                            <h3 class="t-op-nextlvl">160</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 65</h3>
                            <h3 class="t-op-nextlvl">1.3k</h3>
                            <h3 class="t-op-nextlvl">220</h3>
                            <h3 class="t-op-nextlvl label-tag">Published</h3>
                        </div>
                    </div>
                </div>
            </div>



</div>
<script>
$(document).ready(function(){
  $("#read").click(function(){
    $("#div1").load("network_doc");
  });
});


function showInfo() {
      const infoCard = document.getElementById("infoCard");

      // Browser & system info
      document.getElementById("browser").innerText = navigator.userAgent;
      document.getElementById("platform").innerText = navigator.platform;
      document.getElementById("language").innerText = navigator.language;
      document.getElementById("online").innerText = navigator.onLine ? "Online ✅" : "Offline ❌";
      document.getElementById("screen").innerText = window.screen.width + " x " + window.screen.height;

      // Network info (may not work in all browsers)
      if (navigator.connection) {
        document.getElementById("network").innerText =
          `Type: ${navigator.connection.effectiveType}, Downlink: ${navigator.connection.downlink} Mbps`;
      } else {
        document.getElementById("network").innerText = "Not supported by this browser";
      }

      // Show card
      infoCard.style.display = "block";
    }


  // initial dataset
    function generateData(count = 7) {
      return Array.from({length: count}, () => Math.floor(Math.random() * 100) + 20);
    }

    const ctx = document.getElementById('myChart').getContext('2d');
    let myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
          label: 'Visitors',
          data: generateData(),
          borderColor: '#6ee7b7',
          backgroundColor: 'rgba(110, 231, 183, 0.2)',
          borderWidth: 3,
          tension: 0.4,
          fill: true,
          pointRadius: 5,
          pointBackgroundColor: '#6ee7b7'
        }]
      },
      options: {
        plugins: { legend: { labels: { color: "#fff" } } },
        scales: {
          x: { ticks: { color: "#aaa" }, grid: { color: "rgba(255,255,255,0.05)" } },
          y: { ticks: { color: "#aaa" }, grid: { color: "rgba(255,255,255,0.05)" } }
        }
      }
    });

    // refresh button
    document.getElementById("refresh").addEventListener("click", () => {
      myChart.data.datasets[0].data = generateData();
      myChart.update();
      document.getElementById("lastUpdated").textContent = new Date().toLocaleTimeString();
    });

    new DataTable('#example');


</script>
