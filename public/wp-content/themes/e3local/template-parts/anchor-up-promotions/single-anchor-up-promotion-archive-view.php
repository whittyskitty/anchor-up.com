<?php
/**
 * Template part for displaying a single promotion in archive view
 * Modern card design
 * 
 * @var WP_Post $promo The promotion post object
 */

if (!isset($promo) || !$promo) {
    return;
}

$post_id = $promo->ID;
$promotion_start_date = get_field('promotion_start_date', $post_id);
$promotion_end_date = get_field('promotion_end_date', $post_id);
$promotion_header_image = get_field('promotion_header_image', $post_id);
$promotion_description = get_field('promotion_description', $post_id);
$anchor_up_featured_banner = get_field('anchor_up_featured_banner', $post_id);

// Determine if promotion is active, upcoming, or past
$today = strtotime(date('Ymd'));
$start_date = $promotion_start_date ? strtotime($promotion_start_date) : null;
$end_date = $promotion_end_date ? strtotime($promotion_end_date) : null;

$status = 'upcoming';
$status_color = 'bg-yellow-100 text-yellow-800 border-yellow-300';
$status_text = 'Upcoming';

if ($start_date && $end_date) {
    if ($today >= $start_date && $today <= $end_date) {
        $status = 'active';
        $status_color = 'bg-green-100 text-green-800 border-green-300';
        $status_text = 'Active Now';
    } elseif ($today > $end_date) {
        $status = 'past';
        $status_color = 'bg-gray-100 text-gray-800 border-gray-300';
        $status_text = 'Ended';
    }
}
?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
    <!-- Image Header -->
    <?php if ($promotion_header_image) { ?>
        <div class="relative h-48 overflow-hidden">
            <a href="<?php echo get_permalink($post_id); ?>">
                <img src="<?php echo esc_url($promotion_header_image); ?>" 
                     alt="<?php echo esc_attr(get_the_title($post_id)); ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </a>
            <!-- Status Badge -->
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold border <?php echo esc_attr($status_color); ?>">
                    <?php echo esc_html($status_text); ?>
                </span>
            </div>
        </div>
    <?php } elseif ($anchor_up_featured_banner) { ?>
        <div class="relative h-48 overflow-hidden">
            <a href="<?php echo get_permalink($post_id); ?>">
                <img src="<?php echo esc_url($anchor_up_featured_banner); ?>" 
                     alt="<?php echo esc_attr(get_the_title($post_id)); ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </a>
            <!-- Status Badge -->
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold border <?php echo esc_attr($status_color); ?>">
                    <?php echo esc_html($status_text); ?>
                </span>
            </div>
        </div>
    <?php } else { ?>
        <!-- Default gradient header if no image -->
        <div class="relative h-48 bg-gradient-to-br from-blue-500 to-purple-600">
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <!-- Status Badge -->
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold border <?php echo esc_attr($status_color); ?>">
                    <?php echo esc_html($status_text); ?>
                </span>
            </div>
        </div>
    <?php } ?>

    <!-- Content -->
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
            <a href="<?php echo get_permalink($post_id); ?>">
                <?php echo get_the_title($post_id); ?>
            </a>
        </h3>

        <?php if ($promotion_description) { ?>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                <?php echo wp_trim_words(strip_tags($promotion_description), 20); ?>
            </p>
        <?php } ?>

        <!-- Date Information -->
        <div class="space-y-2 mb-4">
            <?php if ($promotion_start_date) { ?>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="text-green-600">🚀</span>
                    <span><strong>Start Date:</strong> <?php echo esc_html($promotion_start_date); ?></span>
                </div>
            <?php } ?>
            <?php if ($promotion_end_date) { ?>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span class="text-orange-600">🏁</span>
                    <span><strong>End Date:</strong> <?php echo esc_html($promotion_end_date); ?></span>
                </div>
            <?php } ?>
        </div>

        <!-- Action Button -->
        <a href="<?php echo get_permalink($post_id); ?>" 
           class="inline-flex items-center justify-center gap-2 w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-all shadow-md hover:shadow-lg group/btn">
            <span>View Promotion</span>
            <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>
