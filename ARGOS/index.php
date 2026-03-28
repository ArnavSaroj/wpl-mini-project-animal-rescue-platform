<?php 
session_start();
require_once './includes/db.php';

// Fetch 3 latest pets
$stmt = $pdo->query("SELECT * FROM pets ORDER BY id DESC LIMIT 3");
$pets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARGOS | Animal Rescue & Adoption</title>
    <link rel="stylesheet" href="./Styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar" id="navbar">
    <div class="container">

        <!-- FIXED LOGO LINK -->
        <a href="index.php" class="logo">ARGOS<span class="dot">.</span></a>

        <ul class="nav-links" id="navLinks">
            <li><a href="#about">Our Story</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="adopt.php">Adopt</a></li>
            <li><a href="#stats">Impact</a></li>
            <li><a href="#stories">Stories</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>

            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- USER LOGGED IN -->
                <li><a href="logout.php" class="btn-nav-cta">Logout</a></li>
            <?php else: ?>
                <!-- NOT LOGGED IN -->
                <li><a href="login.php" class="nav-login">Login</a></li>
                <li><a href="register.php" class="btn-nav-cta">Join Argos</a></li>
            <?php endif; ?>

        </ul>

        <div class="menu-icon" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</nav>

<header class="hero">
    <div class="hero-overlay">
        <div class="container">
            <h1>Waiting for a hero.</h1>
            <p>Inspired by the loyalty of Argos, we connect stray animals with the help they need and the homes they deserve.</p>
            <div class="hero-btns">
                <a href="report.php" class="btn-emergency">Report a Rescue</a>
                <a href="adopt.php" class="btn-outline">Browse Animals</a>
            </div>
        </div>
    </div>
</header>

<section class="services" id="services">
    <div class="container">
        <div class="section-header">
            <h2>Our Mission</h2>
            <div class="underline"></div>
        </div>
        <div class="service-grid">
            <div class="service-card">
                <div class="icon-box red"><i class="fas fa-ambulance"></i></div>
                <h3>Rescue Reporting</h3>
                <p>Found an injured animal? Use our digital system to pin the location and alert our team immediately.</p>
            </div>
            <div class="service-card">
                <div class="icon-box blue"><i class="fas fa-home"></i></div>
                <h3>Smart Adoption</h3>
                <p>Browse through profiles of vaccinated and rescued animals looking for their forever homes.</p>
            </div>
            <div class="service-card">
                <div class="icon-box orange"><i class="fa-solid fa-dog"></i></div>
                <h3>Loyalty & Care</h3>
                <p>We ensure every rescue case is tracked from the moment of reporting until successful rehabilitation.</p>
            </div>
        </div>
    </div>
</section>

    <section class="myth-section" id="about">
        <div class="container">
            <div class="myth-content">
                <div class="myth-text">
                    <h2>Why "Argos"?</h2>
                    <p>In the Odyssey, Argos was the faithful dog of Odysseus. He waited 20 years for his master's return, being the only one to recognize him. This <strong>spirit of unwavering loyalty</strong> is what drives our platform.</p>
                    <p>We believe every animal deserves a partner as loyal as Argos was to his master.</p>
                </div>
                <div class="myth-image">
                    <img src="https://images.unsplash.com/photo-1534361960057-19889db9621e?auto=format&fit=crop&w=600" alt="Loyal Dog">
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Section -->
        <section class="prog-section" id="">
        <div class="container">
            <h1 class="prog-text">How it works.</h1>
            <div class="prog-content">
                <div class="prog-cards">
                    <div class="icon-box-prog red"><i class="fas fa-file-medical"></i></div>
                    <h3>Report</h3>
                </div>
                <div class="prog-cards">
                    <div class="icon-box-prog orange"><i class="fas fa-truck-medical"></i></div>      
                    <h3>Rescue</h3> 
                </div>
                <div class="prog-cards">
                    <div class="icon-box-prog blue"><i class="fas fa-crutch"></i></div>
                    <h3>Rehab</h3>
                </div>
                <div class="prog-cards">
                    <div class="icon-box-prog green"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3>Adoption</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Adoption Section -->
    <section class="adopt-section" id="adopt">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Friends</h2>
                <p>They are waiting for someone like you to change their life.</p>
                <div class="underline"></div>
            </div>

            <div class="pet-grid">

            <?php if ($pets): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="pet-card">

                        <div class="pet-image">
                            <img src="<?= htmlspecialchars($pet['image']) ?>" alt="Pet">

                            <?php if ($pet['status'] === 'adopted'): ?>
                                <span class="badge special">Adopted</span>
                            <?php endif; ?>
                        </div>

                        <div class="pet-info">
                            <h3><?= htmlspecialchars($pet['name']) ?></h3>

                            <p>
                                <?= htmlspecialchars($pet['type']) ?> |
                                <?= $pet['age'] ?> Years
                            </p>

                            <a href="pet.php?id=<?= $pet['id'] ?>" class="btn-view">
                                View Profile
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <p style="text-align:center;">No pets available right now 🐾</p>
            <?php endif; ?>

            </div>
            
            <div class="view-all">
                <a href="adopt.php" class="btn-outline-dark">View All Adoptable Animals</a>
            </div>
        </div>
    </section>

    <!-- Impact Statistics -->
     <div id="stats" style="padding-bottom: 20px;"></div>
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h2 class="counter">150+</h2>
                    <p>Animals Rescued</p>
                </div>
                <div class="stat-item">
                    <h2 class="counter">45</h2>
                    <p>Active Volunteers</p>
                </div>
                <div class="stat-item">
                    <h2 class="counter">89</h2>
                    <p>Forever Homes</p>
                </div>
                <div class="stat-item">
                    <h2 class="counter">12</h2>
                    <p>Ongoing Rescues</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Happy Tails Section -->
    <section class="stories-section" id="stories">
        <div class="container">
            <div class="section-header">
                <h2>Happy Tails</h2>
                <div class="underline"></div>
            </div>
            
            <div class="story-slider">
                <button class="story-nav story-prev" aria-label="Previous story">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="story-card">
                    <div class="story-image">
                        <!-- Default image; will be replaced by stories.js -->
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?auto=format&fit=crop&w=800" alt="Happy pet story">
                    </div>
                    <div class="story-content">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <h3>Nala's First Soft Bed</h3>
                        <p>"Nala came to us scared and skinny. Thanks to Argos she now owns every couch cushion in the house and greets us with the happiest wiggle."</p>
                        <span class="adopter">- The Samadhiya Family</span>
                    </div>
                </div>

                <button class="story-nav story-next" aria-label="Next story">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-box">
                <h2>Join the Argos Community</h2>
                <p>Get updates on urgent rescue cases and adoption events.</p>
                <form id="newsletterForm" class="newsletter-form">
                    <input type="email" id="newsEmail" placeholder="Enter your email" required>
                    <button type="submit" class="btn-main">Subscribe</button>
                </form>
                <p id="formMessage" class="form-msg"></p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 ARGOS Animal Rescue Platform. Compassion via Technology.</p>
        </div>
    </footer>

    <script src="./Script/stories.js"></script>
    <script src="./Script/script.js"></script>

</body>
</html>

    