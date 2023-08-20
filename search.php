<?php
// Include database connection and initialize session if needed
include('connect.php');

if (isset($_GET["query"])) {
    $searchTerm = $_GET["query"];
    
    // Perform a database query to search for jobs
    $sql = "SELECT * FROM Jobs WHERE Job_Title LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $jobId = $row["Job_ID"];
            $jobTitle = $row["Job_Title"];
            $jobimg = $row["Job_Image"];
            $jobcuntry = $row["Job_country"];
            
            echo "<div class='row'>";

                echo "<a  href='apply.php?job_id=$jobId' >";

                    echo "<div class='col-3'>";
                        echo "<img src='$jobimg' alt='Job Image' style='width: 50px; height: 50px; border-radius: 50%;'>";
                    echo "</div>";

                    echo "<div class='col-5'>";
                        echo "<a href='apply.php?job_id=$jobId' class='search-result'>$jobTitle</a>";
                    echo "</div>";

                    echo "<div class='col-4'>";
                        echo "<a href='apply.php?job_id=$jobId' class='search-result-cuntry'>In : $jobcuntry</a>";
                    echo "</div>";
                echo "</a>";

            echo "</div>";
        }
    } else {
        echo "No results found.";
    }
}
?>
