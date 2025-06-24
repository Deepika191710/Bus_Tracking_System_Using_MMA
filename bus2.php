<?php
session_start();
include("connect.php");
?>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Bus Tracking System - Search Buses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet"/>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        #map {
            height: 450px; /* Set the height of the map */
            width: 100%; /* Set the width of the map */
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            // The location of Tiruvannamalai
            const tiruvannamalai = { lat: 12.22, lng: 79.07 };
            // The map, centered at Tiruvannamalai
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: tiruvannamalai,
            });
            // The marker, positioned at Tiruvannamalai
            const marker = new google.maps.Marker({
                position: tiruvannamalai,
                map: map,
                title: "Tiruvannamalai, Tamil Nadu, India"
            });
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a class="flex items-center space-x-2" href="index.html">
            <img alt="Bus Tracking System logo" class="h-10 w-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/550f35cc-e763-44a3-b0d4-ec518c6979d7.jpg" width="40"/>
            <span class="text-2xl font-semibold text-indigo-600">BusTrack</span>
        </a>
        <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
            <a class="hover:text-indigo-600 transition" href="#overview">Overview</a>
            <a class="hover:text-indigo-600 transition" href="#features">Features</a>
            <a class="hover:text-indigo-600 transition" href="#map">Live Map</a>
            <button id="search-toggle" class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600 flex items-center space-x-1">
                <i class="fas fa-search fa-lg"></i>
                <span class="hidden sm:inline"><a href=index.html>Search</a></span>
            </button>
            <a class="hover:text-indigo-600 transition" href="logout.php">Logout</a>
        </nav>
        <button aria-label="Open menu" class="md:hidden text-gray-700 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600" id="mobile-menu-button">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </div>
    <nav aria-label="Mobile menu" class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
        <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#overview">Overview</a>
        <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#features">Features</a>
        <a class="block px-4 py-3 border-b border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition" href="#map">Live Map</a>
        <button id="mobile-search-toggle" class="w-full