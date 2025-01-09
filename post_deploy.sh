#!/bin/bash

# Navigate to your WordPress installation directory
cd /app

# Regenerate Elementor CSS and Data
wp elementor tools regenerate-css

# Optionally clear cache if you're using a caching plugin
wp cache flush

echo "Post-deployment tasks completed!"