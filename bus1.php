<?php
session_start();
include("connect.php");
?>



<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Bus Tracking System - Search Buses
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>
  
  <style >

   body {
      font-family: 'Inter', sans-serif;
    }
  </style>
 </head>
 <body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
  <header class="bg-white shadow-md sticky top-0 z-50">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
    <a class="flex items-center space-x-2" href="index.html">
     <img alt="Bus Tracking System logo with a stylized bus icon in blue circle" class="h-10 w-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/550f35cc-e763-44a3-b0d4-ec518c6979d7.jpg" width="40"/>
     <span class="text-2xl font-semibold text-indigo-600">
      BusTrack
     </span>
    </a>
    <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
     <a class="hover:text-indigo-600 transition" href="#overview">
      Overview
     </a>
     <a class="hover:text-indigo-600 transition" href="#features">
      Features
     </a>
     <a class="hover:text-indigo-600 transition" href="#map">
      Live Map
     </a>
     
     <button id="search-toggle" class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600 flex items-center space-x-1">
      <i class="fas fa-search fa-lg"></i>
      <span class="hidden sm:inline">
       <a href=index_search.php>Search</a>
      </span>
     </button>
     <a class="hover:text-indigo-600 transition" href="logout.php">
      Logout
     </a>
    </nav>
    <button aria-label="Open menu" class="md:hidden text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600" id="mobile-menu-button">
     <i class="fas fa-bars fa-lg">
     </i>
    </button>
   </div>
   <nav aria-label="Mobile menu" class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
    <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#overview">
     Overview
    </a>
   
    <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#features">
     Features
    </a>
    <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#map">
     Live Map
    </a>
    
    <button id="mobile-search-toggle" class="w-full text-left px-4 py-3 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center space-x-2">
     <i class="fas fa-search fa-lg"></i>
     <span>
      <a href=index_search.php>  Search</a>
     </span>
    </button>
   </nav>
  
  </header>
  <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
   <!-- Hero Section -->
   <section class="text-center max-w-3xl mx-auto mb-20" id="overview">
   <div style="text-align:center; paddingg:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Welcome
            <?php
            if(isset($_SESSION['email'])){
                $email=$_SESSION['email'];
                $query=mysqli_query($conn,"SELECT login.* from `login` WHERE login.email='$email'");
                while($row=mysqli_fetch_array($query)){
                    echo $row['firstName'].''.$row['lastName'];
                }
            } 
            ?>
            :)
</p>
    <h2>TO</h2>
    <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-600 mb-4">           
     Real-Time Bus Tracking System
    </h1>
    <p class="text-lg sm:text-xl text-gray-700 mb-8">
     Track buses live, optimize routes, and improve commuter experience with BusTrack.
    </p>
    <img alt="Illustration of a city bus moving on a digital map with GPS signals and location pins" class="mx-auto rounded-lg shadow-lg" height="400" src="https://storage.googleapis.com/a1aa/image/5055c16a-ae88-4c6c-9b6b-1b77c2afe9ee.jpg" width="800"/>
   </section>
   <!-- Features Section -->
   <section class="mb-20" id="features">
    <h2 class="text-3xl font-semibold text-gray-900 mb-10 text-center">
     Features
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-bus text-indigo-600 text-5xl mb-4">
      </i>
     <h3 onclick="window.location.href='userselect.html'" class="text-xl font-semibold mb-2 cursor-pointer">
       Live Bus Tracking

     </h3>

      <p class="text-gray-600">
       View real-time locations of buses on an interactive map for accurate arrival times.
      </p>
     </div>
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-route text-indigo-600 text-5xl mb-4">
      </i>
      <h3 class="text-xl font-semibold mb-2">
       Route Optimization
      </h3>
      <p class="text-gray-600">
       Intelligent algorithms optimize bus routes to reduce delays and improve efficiency.
      </p>
     </div>
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-bell text-indigo-600 text-5xl mb-4">
      </i>
      <h3 class="text-xl font-semibold mb-2">
       Arrival Notifications
      </h3>
      <p class="text-gray-600">
       Get notified about bus arrivals and delays directly on your mobile device.
      </p>
     </div>
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-mobile-alt text-indigo-600 text-5xl mb-4">
      </i>
      <h3 class="text-xl font-semibold mb-2">
       Mobile App Support
      </h3>
      <p class="text-gray-600">
       Access bus tracking and schedules anytime, anywhere with our mobile-friendly app.
      </p>
     </div>
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-chart-bar text-indigo-600 text-5xl mb-4">
      </i>
      <h3 class="text-xl font-semibold mb-2">
       Analytics Dashboard
      </h3>
      <p class="text-gray-600">
       Monitor bus performance, ridership, and route efficiency with detailed analytics.
      </p>
     </div>
     <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
      <i class="fas fa-shield-alt text-indigo-600 text-5xl mb-4">
      </i>
      <h3 class="text-xl font-semibold mb-2">
       Secure &amp; Reliable
      </h3>
      <p class="text-gray-600">
       Our system ensures data privacy and reliable uptime for uninterrupted service.
      </p>
     </div>
    </div>
   </section>
   <!-- Live Map Section -->
   <section class="mb-20" id="map">
    <h2 class="text-3xl font-semibold text-gray-900 mb-10 text-center" href="index.html">
     Live Bus Map
    </h2>
    <div class="rounded-lg shadow-lg overflow-hidden">
    <center>   
    <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3911.123456789!2d79.0700!3d12.2264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52f0a123456789%3A0xabcdef123456789!2sTiruvannamalai%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1612345678901!5m2!1sen!2sin" 
    width="600" 
    height="450" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy">
    </iframe>
        </center>
    </div>
   </section>
  
  </main>
 

 </body>
</html>