<?php include_once('../components/header.php'); ?>
<?php
require_once '../config.php';

// Fetch menu items based on category
$sqlmainDishes = "SELECT * FROM Menu WHERE item_category = 'Main Dishes' ORDER BY item_type; ";
$resultmainDishes = mysqli_query($link, $sqlmainDishes);
$mainDishes = mysqli_fetch_all($resultmainDishes, MYSQLI_ASSOC);

$sqldrinks = "SELECT * FROM Menu WHERE item_category = 'Drinks' ORDER BY item_type; ";
$resultdrinks = mysqli_query($link, $sqldrinks);
$drinks = mysqli_fetch_all($resultdrinks, MYSQLI_ASSOC);

$sqlsides = "SELECT * FROM Menu WHERE item_category = 'Side Dishes' ORDER BY item_type; ";
$resultsides = mysqli_query($link, $sqlsides);
$sides = mysqli_fetch_all($resultsides, MYSQLI_ASSOC);

// Close the database connection after all queries
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flavorscape - Authentic Indian Restaurant in Chennai</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      .container {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
}

.projects-header h1 {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 1.5rem;
}

.menu-category {
  display: block;
  margin: 1rem auto;
  padding: 0.5rem;
  font-size: 1.2rem;
  text-align: center;
  max-width: 200px;
}

.menu-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center; /* Centers the grid */
  padding-top: 1rem;
}

.menu-category-content {
  display: none; /* Initially hide all categories */
  flex-basis: 200px; /* Width for each column */
  max-height: 500px; /* Limit height */
  overflow: auto; /* Allow scrolling if too many items */
}

.menu-category-content.active {
  display: flex; /* Show the active category */
  flex-direction: column; /* Stack items vertically */
}
.menu-category-content h2 {
  text-align: center;
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 1rem;
}

.menu-card {
  background-color: #fff;
  padding: 1rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s, background-color 0.3s;
  width: 200px;
}

.menu-card {
  margin-bottom: 1rem; /* Adds space between items */
}
.menu-card:hover {
  transform: scale(1.05);
  background-color: #f9f9f9;
}

.menu-card strong {
  font-size: 1.1rem;
  color: #333;
}

.menu-card span {
  font-size: 1rem;
  color: #888;
}

.menu-card i {
  font-size: 0.9rem;
  color: #555;
}

.mainDishes .menu-card {
  background-color: #ffebcc;
}

.sideDishes .menu-card {
  background-color: #d0f0c0;
}

.drinks .menu-card {
  background-color: #cce0ff;
}
    .hero h1 {
    font-size: 3.5rem;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Soft outline effect */
  }
  .hero p {
    font-size: 1.2rem;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5); /* Soft outline effect */
  }
    .navbar-brand { font-family: 'Georgia', serif; font-size: 1.8rem; }
    .hero { background-image: url('../image/pexels-karolina-grabowska-4199098.jpg'); background-size: cover;  background-position: center; background-repeat: no-repeat; color: white; height: 110vh; }
    .hero h1 { font-size: 3.5rem; }
    .hero p { font-size: 1.2rem; }
    .about, .menu, .contact { padding: 3rem 0; }
    .menu-item img { height: 200px; object-fit: cover; border-radius: 10px; }
    .footer { background: #222; color: #eee; padding: 2rem 0; }
  </style>
</head>
<body>


  <!-- Hero Section -->
  <section class="hero d-flex align-items-center justify-content-center text-center">
    <div class="container">
      <h1 >Welcome to Flavorscape</h1>
      <p>Experience the authentic taste of Indian cuisine right here in Chennai.</p>
      <a href="#projects" class="btn btn-primary btn-lg" >Explore Our Menu</a>
    </div>
  </section>
  <!-- About Section -->
  <section id="about" class="about bg-light">
    <div class="container text-center">
      <h2>About Us</h2>
      <p>Located in the heart of Chennai, Flavorscape brings you the authentic taste of India with a modern twist. Our chefs are dedicated to crafting delightful dishes that showcase the vibrant flavors and traditions of Indian cuisine.</p>
    </div>
  </section>

  <!-- Menu Section --> 
<section id="menu" class="menu">
    <div class="container text-center">
      <h2>Explore a diverse range of dishes that capture the essence of India.</h2>
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="menu-item">
            <img src="../image/Curry.jpg" alt="Indian Curry" class="img-fluid">
            <h4>Signature Curry</h4>
            <p>A rich and flavorful blend of spices for a true taste of India.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="menu-item">
            <img src="../image/Biriyani.jpg" alt="Biryani" class="img-fluid">
            <h4>Traditional Biryani</h4>
            <p>Slow-cooked basmati rice with marinated meat or vegetables.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="menu-item">
            <img src="../image/Tandoori.jpg" alt="Tandoori" class="img-fluid">
            <h4>Tandoori Delights</h4>
            <p>Marinated and char-grilled to perfection in our traditional tandoor.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
 
 <!-- menu Section -->
  <section id="projects">
  <div class="projects container">
    <div class="projects-header">
      <h1 class="section-title">Me<span>n</span>u</h1>
    </div>

    <select id="menu-category" class="menu-category" onchange="filterMenu()">
      <option value="all">ALL ITEMS</option>
      <option value="mainDishes">MAIN DISHES</option>
      <option value="sideDishes">SIDE DISHES</option>
      <option value="drinks">DRINKS</option>
    </select>

    <div id="menu-container" class="menu-grid">
      <!-- Main Dishes Section -->
      <div class="menu-category-content mainDishes">
        <h2>Main Dishes</h2>
        <?php foreach ($mainDishes as $item): ?>
          <div class="menu-card">
            <strong><?php echo $item['item_name']; ?></strong><br>
            <span>₹<?php echo $item['item_price']; ?></span><br>
            <i><?php echo $item['item_type']; ?></i>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Side Dishes Section -->
      <div class="menu-category-content sideDishes">
        <h2>Side Dishes</h2>
        <?php foreach ($sides as $item): ?>
          <div class="menu-card">
            <strong><?php echo $item['item_name']; ?></strong><br>
            <span>₹<?php echo $item['item_price']; ?></span><br>
            <i><?php echo $item['item_type']; ?></i>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Drinks Section -->
      <div class="menu-category-content drinks">
        <h2>Drinks</h2>
        <?php foreach ($drinks as $item): ?>
          <div class="menu-card">
            <strong><?php echo $item['item_name']; ?></strong><br>
            <span>₹<?php echo $item['item_price']; ?></span><br>
            <i><?php echo $item['item_type']; ?></i>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<script>
  function filterMenu() {
    const category = document.getElementById('menu-category').value;
    const categories = document.querySelectorAll('.menu-category-content');

    categories.forEach(cat => {
      // Remove active class from all
      cat.classList.remove('active');
      
      if (category === 'all') {
        cat.classList.add('active'); // Show all
      } else if (cat.classList.contains(category)) {
        cat.classList.add('active'); // Show selected category
      }
    });
  }
</script>


  <!-- End menu Section -->

  <!-- Contact Section -->
  <section id="contact" class="contact bg-light">
  <div class="container text-center">
    <h2>Contact Us</h2>
    <p>Have a question? Reach out to us or visit our Chennai location!</p>
    <div class="row mt-4">
      <div class="col-md-4 mx-auto">
        <a href="https://www.instagram.com/yourprofile" target="_blank">
          <img src="../image/instagram.png" alt="Instagram" class="img-fluid" style="width: 100px; height: auto;">
        </a>
        <p>Follow us on Instagram</p>
      </div>
      <div class="col-md-4 mx-auto">
        <img src="../image/whatsapp.png" alt="Phone" class="img-fluid" style="width: 100px; height: auto;">
        <p>Call us: +91 12345 67890</p>
      </div>
      <div class="col-md-4 mx-auto">
        <img src="../image/location.png" alt="Location" class="img-fluid" style="width: 100px; height: auto;">
        <p>Visit us: Chennai, Tamil Nadu</p>
      </div>
    </div>
  </div>
</section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
  <script>
window.embeddedChatbotConfig = {
chatbotId: "sc4Ovd5k5fa5XIOjguv1d",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="sc4Ovd5k5fa5XIOjguv1d"
domain="www.chatbase.co"
defer>
</script></script>
</body>
</html>

<?php 
include_once('../components/footer.php');
?>