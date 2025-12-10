<?php
/**
 * Template Name: Anchor Up Promotion Archive
 * Modern Archive Template for displaying Anchor Up Promotions
 */

// Promotions are allowed on this site - no access checks needed

get_header();

// Get current date for comparison
$today = date('Ymd');
$today_timestamp = strtotime($today);

// First, get current promotion (active now)
$current_args = array(
    'post_type' => 'anchor-up-promotion',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'promotion_start_date',
            'value' => $today,
            'compare' => '<=',
        ),
        array(
            'key' => 'promotion_end_date',
            'value' => $today,
            'compare' => '>=',
        ),
    ),
    'orderby' => 'meta_value',
    'meta_key' => 'promotion_start_date',
    'order' => 'DESC',
);

$current_query = new WP_Query($current_args);
$current_promotion = $current_query->have_posts() ? $current_query->posts[0] : null;

// If no current promotion, get the next upcoming one
$upcoming_promotion = null;
$next_upcoming_promotion = null;

if (!$current_promotion) {
    $upcoming_args = array(
        'post_type' => 'anchor-up-promotion',
        'posts_per_page' => 2, // Get 2 in case we need to show one as highlight and one as banner
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'promotion_start_date',
                'value' => $today,
                'compare' => '>',
            ),
        ),
        'orderby' => 'meta_value',
        'meta_key' => 'promotion_start_date',
        'order' => 'ASC',
    );
    
    $upcoming_query = new WP_Query($upcoming_args);
    if ($upcoming_query->have_posts()) {
        $upcoming_posts = $upcoming_query->posts;
        $upcoming_promotion = $upcoming_posts[0];
        if (isset($upcoming_posts[1])) {
            $next_upcoming_promotion = $upcoming_posts[1];
        }
    }
}
?>

<div class="min-h-screen">
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16 px-4 pt-24">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h1 class="text-4xl md:text-6xl font-bold">Anchor-Up Promotions</h1>
            </div>
            <p class="text-xl md:text-2xl text-blue-100 mb-6">Browse all available promotions and campaigns</p>
            
            <!-- Description Section -->
            <div class="max-w-3xl mx-auto mt-8">
                <p class="text-lg text-blue-50 leading-relaxed">
                    Anchor-Up Promotions are exciting marketing campaigns designed to help Christian bookstores drive traffic, increase sales, and engage with their local communities. Each promotion includes digital assets, promotional materials, and support resources to help stores maximize their participation and results.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Highlighted Current/Upcoming Promotion Section -->
        <?php if ($current_promotion || $upcoming_promotion) { 
            $highlight_promo = $current_promotion ? $current_promotion : $upcoming_promotion;
            $highlight_id = $highlight_promo->ID;
            $highlight_start = get_field('promotion_start_date', $highlight_id);
            $highlight_end = get_field('promotion_end_date', $highlight_id);
            $highlight_image = get_field('promotion_header_image', $highlight_id);
            $highlight_title = get_the_title($highlight_id);
            $highlight_description = get_field('promotion_description', $highlight_id);
            $is_current = (bool)$current_promotion;
        ?>
            <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-2xl overflow-hidden mb-8 border-4 border-blue-400">
                <div class="p-8 md:p-12 text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <span class="text-sm font-bold">
                                <?php echo $is_current ? '🔥 ACTIVE NOW' : '⏰ UPCOMING'; ?>
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-3xl md:text-4xl font-bold mb-4"><?php echo esc_html($highlight_title); ?></h2>
                            <?php if ($highlight_description) { 
                                $description_text = strip_tags($highlight_description);
                                $description_words = wp_trim_words($description_text, 25, '...');
                            ?>
                                <p class="text-blue-100 mb-6 line-clamp-3">
                                    <?php echo esc_html($description_words); ?>
                                </p>
                            <?php } ?>
                            <div class="flex flex-wrap gap-4 mb-6">
                                <?php if ($highlight_start) { ?>
                                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                                        <span class="text-sm font-semibold">🚀 Start: <?php echo esc_html($highlight_start); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($highlight_end) { ?>
                                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                                        <span class="text-sm font-semibold">🏁 End: <?php echo esc_html($highlight_end); ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="flex flex-wrap gap-4">
                                <a href="<?php echo get_permalink($highlight_id); ?>" 
                                   class="inline-flex items-center gap-2 bg-white text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl">
                                    View Promotion Details
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <a href=/anchor-up-website-registration/"" 
                                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Want to join the In & Out Store Promotions? Click here
                                </a>
                            </div>
                        </div>
                        <?php if ($highlight_image) { ?>
                            <div class="rounded-xl overflow-hidden shadow-2xl">
                                <img src="<?php echo esc_url($highlight_image); ?>" 
                                     alt="<?php echo esc_attr($highlight_title); ?>" 
                                     class="w-full h-64 object-cover">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Next Upcoming Promotion Banner (if exists and first one is upcoming) -->
            <?php if ($next_upcoming_promotion && !$is_current) { 
                $next_id = $next_upcoming_promotion->ID;
                $next_start = get_field('promotion_start_date', $next_id);
                $next_title = get_the_title($next_id);
            ?>
                <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-6 mb-8">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-yellow-400 rounded-full p-3">
                                <svg class="w-6 h-6 text-yellow-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">Future Promotion</h3>
                                <p class="text-gray-700 font-semibold"><?php echo esc_html($next_title); ?></p>
                                <?php if ($next_start) { ?>
                                    <p class="text-sm text-gray-600">Starts: <?php echo esc_html($next_start); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-yellow-200 rounded-lg">
                            <span class="text-yellow-900 font-semibold">Coming Soon</span>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Call to Action for Current/Upcoming Promotion -->
            <?php if ($current_promotion || $upcoming_promotion) { ?>
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-lg p-6 mb-8 border-2 border-green-200">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-green-500 rounded-full p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1">Want to join the In & Out Store Promotions?</h3>
                                <p class="text-gray-700">Register now to participate in exciting promotional campaigns!</p>
                            </div>
                        </div>
                        <a href="/anchor-up-website-registration" 
                           class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl whitespace-nowrap">
                            Register Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <!-- No Upcoming Promotions Message -->
            <div class="bg-white rounded-2xl shadow-xl p-12 mb-8 border border-gray-200 text-center">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">No Upcoming Promotions</h2>
                <p class="text-xl text-gray-600 mb-2">Check back soon for new promotions!</p>
                <p class="text-lg text-gray-500 mb-8">Take a look at our past promotions below.</p>
            </div>

            <!-- Call to Action for Registration (when no promotions) -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl shadow-lg p-6 mb-8 border-2 border-green-200">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-500 rounded-full p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Want to join the In & Out Store Promotions?</h3>
                            <p class="text-gray-700">Register now to participate in exciting promotional campaigns!</p>
                        </div>
                    </div>
                    <a href="/anchor-up-promotion-registration" 
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition-all shadow-lg hover:shadow-xl whitespace-nowrap">
                        Register Now
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        <?php } ?>

        <?php
        $per_page = 12;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? $_REQUEST['sort_by'] : 'promotion_start_date';
        $sort_order = isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : 'DESC';

        // Build query args - exclude the highlighted promotion
        $exclude_ids = array();
        if ($current_promotion) {
            $exclude_ids[] = $current_promotion->ID;
        } elseif ($upcoming_promotion) {
            $exclude_ids[] = $upcoming_promotion->ID;
            if ($next_upcoming_promotion) {
                $exclude_ids[] = $next_upcoming_promotion->ID;
            }
        }

        $args = array(
            'post_type' => 'anchor-up-promotion',
            'posts_per_page' => $per_page,
            'paged' => $paged,
            'post_status' => 'publish',
            'post__not_in' => $exclude_ids,
            'meta_query' => array(
                array(
                    'key' => $sort_by,
                    'compare' => 'EXISTS',
                ),
            ),
            'orderby' => 'meta_value',
            'meta_key' => $sort_by,
            'order' => $sort_order,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            // Sort/Filter Controls
            ?>
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">All Promotions</h2>
                        <form method="get" class="flex flex-wrap gap-3">
                            <select name="sort_by" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="promotion_start_date" <?php selected($sort_by, 'promotion_start_date'); ?>>Start Date</option>
                                <option value="promotion_end_date" <?php selected($sort_by, 'promotion_end_date'); ?>>End Date</option>
                            </select>
                            <select name="sort_order" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="DESC" <?php selected($sort_order, 'DESC'); ?>>Newest First</option>
                                <option value="ASC" <?php selected($sort_order, 'ASC'); ?>>Oldest First</option>
                            </select>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                                Apply
                            </button>
                        </form>
                    </div>
                    <div class="text-sm text-gray-600">
                        Showing <?php echo $query->found_posts; ?> promotion<?php echo $query->found_posts != 1 ? 's' : ''; ?>
                    </div>
                </div>
            </div>

            <!-- Promotions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $promo = get_post();
                    
                    // Try to load partial template
                    $partial_path = get_template_directory() . '/template-parts/anchor-up-promotions/single-anchor-up-promotion-archive-view.php';
                    if (file_exists($partial_path)) {
                        include($partial_path);
                    } else {
                        // Fallback: display basic post info
                        ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <?php if (get_field('promotion_start_date')) { ?>
                                        <div class="flex items-center gap-2">
                                            <span>📅</span>
                                            <span>Start: <?php echo esc_html(get_field('promotion_start_date')); ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (get_field('promotion_end_date')) { ?>
                                        <div class="flex items-center gap-2">
                                            <span>🏁</span>
                                            <span>End: <?php echo esc_html(get_field('promotion_end_date')); ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" 
                                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                    View Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <!-- Pagination -->
            <?php
            if ($query->max_num_pages > 1) {
                ?>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex justify-center items-center gap-2">
                        <?php
                        $big = 999999999;
                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, $paged),
                            'total' => $query->max_num_pages,
                            'prev_text' => '<span class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">← Previous</span>',
                            'next_text' => '<span class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">Next →</span>',
                            'type' => 'list',
                        ));
                        ?>
                    </div>
                </div>
                <style>
                    .page-numbers {
                        display: flex;
                        gap: 0.5rem;
                        list-style: none;
                        padding: 0;
                        margin: 0;
                        flex-wrap: wrap;
                        justify-content: center;
                    }
                    .page-numbers li {
                        margin: 0;
                    }
                    .page-numbers a,
                    .page-numbers span {
                        display: inline-block;
                        padding: 0.5rem 1rem;
                        border-radius: 0.5rem;
                        text-decoration: none;
                        font-weight: 600;
                        transition: all 0.2s;
                    }
                    .page-numbers a {
                        background-color: #e5e7eb;
                        color: #374151;
                    }
                    .page-numbers a:hover {
                        background-color: #2563eb;
                        color: white;
                    }
                    .page-numbers .current {
                        background-color: #2563eb;
                        color: white;
                    }
                </style>
                <?php
            }
            ?>
        <?php
            wp_reset_postdata();
        } else {
            ?>
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-200">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No More Promotions</h2>
                <p class="text-gray-600">All promotions are displayed above.</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<!-- First Time Visitor Popup -->
<div id="anchor-up-welcome-popup" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Welcome to Anchor-Up Promotions!</h2>
                <button id="close-popup" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="prose prose-lg max-w-none mb-6">
                <p class="text-gray-700 leading-relaxed mb-4">
                    <strong>For each promotion you need a Store ID.</strong>
                </p>
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                    <p class="text-gray-700 mb-2">
                        <strong>If you already registered,</strong> reach out to <a href="mailto:nick.peters@anchordistributors.com" class="text-blue-600 hover:text-blue-800 font-semibold">nick.peters@anchordistributors.com</a> for your ID.
                    </p>
                </div>
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <p class="text-gray-700 mb-4">
                        <strong>Don't have a store ID?</strong> Register for the program now!
                    </p>
                    <a href="/anchor-up-website-registration" 
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg">
                        Register Now
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="dont-show-again" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="text-sm text-gray-600">Don't show this again</span>
                </label>
                <button id="close-popup-btn" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                    Got it!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('anchor-up-welcome-popup');
    const closeBtn = document.getElementById('close-popup');
    const closeBtnBottom = document.getElementById('close-popup-btn');
    const dontShowAgain = document.getElementById('dont-show-again');
    
    // Check if user has seen the popup before (cookie session)
    const hasSeenPopup = sessionStorage.getItem('anchor-up-popup-seen');
    
    if (!hasSeenPopup) {
        // Show popup after a short delay
        setTimeout(function() {
            popup.classList.remove('hidden');
            popup.classList.add('flex');
        }, 1000);
    }
    
    function closePopup() {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        
        // Set session storage to remember they've seen it
        if (dontShowAgain.checked) {
            sessionStorage.setItem('anchor-up-popup-seen', 'true');
        } else {
            // Still set it for this session, but they can see it again next session
            sessionStorage.setItem('anchor-up-popup-seen', 'true');
        }
    }
    
    closeBtn.addEventListener('click', closePopup);
    closeBtnBottom.addEventListener('click', closePopup);
    
    // Close on outside click
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            closePopup();
        }
    });
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !popup.classList.contains('hidden')) {
            closePopup();
        }
    });
});
</script>

<style>
#anchor-up-welcome-popup {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

#anchor-up-welcome-popup > div {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<?php
get_footer();
?>
