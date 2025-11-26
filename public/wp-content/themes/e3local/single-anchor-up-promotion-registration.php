<?php
/**
 * Template Name: Single Anchor Up Promotion Registration
 * Template for displaying the Anchor Up Promotion Registration form
 */

get_header();
?>

<style>
/* Add borders to all Gravity Forms inputs */
.gform_wrapper input[type="text"],
.gform_wrapper input[type="email"],
.gform_wrapper input[type="tel"],
.gform_wrapper input[type="number"],
.gform_wrapper input[type="url"],
.gform_wrapper input[type="password"],
.gform_wrapper input[type="date"],
.gform_wrapper input[type="time"],
.gform_wrapper textarea,
.gform_wrapper select {
    border: 1px solid #d1d5db !important;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
}

.gform_wrapper input[type="text"]:focus,
.gform_wrapper input[type="email"]:focus,
.gform_wrapper input[type="tel"]:focus,
.gform_wrapper input[type="number"]:focus,
.gform_wrapper input[type="url"]:focus,
.gform_wrapper input[type="password"]:focus,
.gform_wrapper input[type="date"]:focus,
.gform_wrapper input[type="time"]:focus,
.gform_wrapper textarea:focus,
.gform_wrapper select:focus {
    border-color: #3b82f6 !important;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Style Gravity Forms submit buttons */
.gform_wrapper input[type="submit"],
.gform_wrapper button[type="submit"],
.gform_wrapper .gform_button,
.gform_wrapper .button {
    background: linear-gradient(to right, #2563eb, #1d4ed8) !important;
    color: #ffffff !important;
    border: none !important;
    padding: 0.75rem 2rem !important;
    font-size: 1rem !important;
    font-weight: 600 !important;
    border-radius: 0.5rem !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}

.gform_wrapper input[type="submit"]:hover,
.gform_wrapper button[type="submit"]:hover,
.gform_wrapper .gform_button:hover,
.gform_wrapper .button:hover {
    background: linear-gradient(to right, #1d4ed8, #1e40af) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
}

.gform_wrapper input[type="submit"]:active,
.gform_wrapper button[type="submit"]:active,
.gform_wrapper .gform_button:active,
.gform_wrapper .button:active {
    transform: translateY(0) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
}
</style>

<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-24 md:py-32">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Anchor Up Promotion Registration</h1>
            <p class="text-xl text-blue-100">Register for Anchor Up Promotions</p>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center space-x-2 text-sm" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>" 
                   class="text-gray-500 hover:text-blue-600 transition-colors">
                    Home
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="<?php echo esc_url(get_post_type_archive_link('anchor-up-promotion')); ?>" 
                   class="text-gray-500 hover:text-blue-600 transition-colors">
                    Anchor-Up Promotions
                </a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium" aria-current="page">
                    Promotion Registration
                </span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Form Section -->
            <div class="bg-white rounded-lg shadow-lg p-8 md:p-12">
                <?php
                // Get form ID by name
                if (class_exists('RGFormsModel')) {
                    $form_id = RGFormsModel::get_form_id("Anchor Up - Register");
                    
                    if ($form_id) {
                        // Display the form
                        gravity_form($form_id, true, true, false, null, true);
                    } else {
                        echo '<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">';
                        echo '<p class="text-yellow-800">Form "Anchor Up - Register" not found. Please ensure the form exists in Gravity Forms.</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="bg-red-50 border border-red-200 rounded-lg p-6">';
                    echo '<p class="text-red-800">Gravity Forms plugin is not active. Please activate it to display the registration form.</p>';
                    echo '</div>';
                }
                ?>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Need Help?</h2>
                <p class="text-gray-700 mb-4">
                    If you need assistance with registration or have questions about Anchor Up Promotions, please contact us:
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Email: <a href="mailto:nick.peters@anchordistributors.com" class="text-blue-600 hover:text-blue-800">nick.peters@anchordistributors.com</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>

