<?php 
session_start();
if (!isset($_SESSION['user_id'])){
	header("Location: login.php");
}
# Database Connection File
include "db_conn.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/book-open-reader-solid (1).svg" />
    <title>About Us - BookHauler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php include "header.html"; ?>

        <main>
            <section id="about" class="mt-5">
                <div class="about-content">
                    <h1>About BookHauler</h1>
                    <p>Welcome to BookHauler, your ultimate destination for discovering and indulging in a vast collection of captivating books. We are passionate about literature and committed to providing an exceptional reading experience for book enthusiasts worldwide.</p>
                    <p>At BookHauler, we believe in the power of books to inspire, educate, and entertain. Our mission is to connect readers with their favorite authors, genres, and stories, fostering a vibrant community of book lovers.</p>
                    <p>With a curated selection of classic novels, contemporary bestsellers, and niche titles, BookHauler offers something for every reader. Whether you're seeking literary classics, thrilling mysteries, or heartwarming romances, we've got you covered.</p>
                    <p>Join us on our journey to celebrate the written word, share meaningful stories, and ignite a lifelong passion for reading. Happy reading!</p>
                </div>
            </section>
            <section id="mission" class="mt-5">
                <h2 class="mb-4">Our Mission</h2>
                <p>Our mission at BookHauler is to foster a thriving literary community by offering a diverse selection of books that cater to every reader's interests and preferences. We aim to inspire a love for reading, spark intellectual curiosity, and promote lifelong learning through the power of literature.</p>
            </section>

            <section id="offer" class="mt-5">
                <h2 class="mb-4">What We Offer</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Extensive Book Collection:</strong> Dive into our extensive library featuring a wide range of genres, including fiction, non-fiction, mystery, romance, science fiction, fantasy, self-help, and more.</li>
                    <li class="list-group-item"><strong>Author Spotlight:</strong> Discover talented authors and explore their captivating stories.</li>
                    <li class="list-group-item"><strong>User-Friendly Experience:</strong> Enjoy seamless navigation, intuitive search features, and personalized recommendations.</li>
                    <!-- <li class="list-group-item"><strong>Community Engagement:</strong> Join a vibrant community of book enthusiasts.</li> -->
                </ul>
            </section>

            <section id="team" class="mt-5">
                <h2 class="mb-4">Meet Our Developers</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 12rem;">
                            <img src="img/img3.jpg" alt="Kshitij Mahale" class="card-img-top img-fluid" style="max-width: 9rem; height: auto; margin-top: 1rem; margin-bottom: -1.3rem">
                            <div class="card-body">
                                <h3 class="card-title">Kshitij Mahale</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 12rem;">
                            <img src="img/img3.jpg" alt="Om Kumbharde" class="card-img-top img-fluid" style="max-width: 9rem; height: auto; margin-top: 1rem; margin-bottom: -1.3rem">
                            <div class="card-body">
                                <h3 class="card-title">Om Kumbharde</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <footer class="mt-3 py-1 bg-light text-dark text-center">
            <p><b>&copy; 2024 BookHauler. All rights reserved.</b></p>
        </footer>

    </div>
</body>
</html>
