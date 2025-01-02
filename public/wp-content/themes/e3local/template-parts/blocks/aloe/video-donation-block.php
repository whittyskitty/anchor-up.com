<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}
/* id="<?=$id;?>" */

// Create class attribute allowing for custom "className" and "align" values.
$className = 'video-donation';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$video_background = get_field('video_background');
$above_donation_form_header = get_field('above_donation_form_header');
$video_header = get_field('video_header');
$video_text = get_field('video_text');
$donation_form_embed_code = get_field('donation_form_embed_code');

?>
<div class="hero--video-donate-form">
    <div class="hero--video-container" data-behavior="DonateVideoHero">
        <div class="absolute z-20 w-full h-full opacity-25 hero--video-overlay">
        </div>
        <div class="z-10 hero--video-wrapper">
            <!-- poster="https://cw-contentful-assets.imgix.net/https%3A%2F%2Fimages.ctfassets.net%2Fwvozpes63uc8%2F4AHCFRDETvMfLfwdeVuV10%2Fd3bcd5325b956f0eec6ea031b424149e%2Fhome-cycle-video-poster.jpg?ixlib=rails-4.1.0&amp;auto=format&amp;w=1920&amp;s=60142f7345a4b58eb4fee6b27d2f8fab"  -->
            <video autoplay="autoplay" loop="loop" muted="muted" src="<?=$video_background;?>">
            </video>
        </div>
    </div>
    <div class="hero-row flex items-center relative z-30 flex-wrap"> <!-- lg:flex lg:items-center -->
        <div class="hero--text w-2/5 py-20 md:py-5">
            <h1 class="hero--header balance-text mx-auto font-heading h20 text-3xl"><?=$video_header;?></h1> <!-- style="max-width: 384.578px;" -->
            <p class="hero--description balance-text p30"><?=$video_text;?></p>
            <!-- style="max-width: 508.797px;" -->
        </div>
        <div class="hero--donate-form flex justify-center w-3/5">
            <div class="w-full bg-white py-10">
                <h1 class="hero--header balance-text mx-auto font-heading h20 text-3xl"><?=$above_donation_form_header;?></h1>
                <div class="donation-form-desktop">
                    <div class="embedded-script">
                        <?=$donation_form_embed_code;?>
                    </div>
                </div>
                <!-- <script type="text/javascript" src="https://secure.lglforms.com/form_engine/s/t_LVau_VWMYvzPyTGLUBMA.js"></script> -->
                <!-- <noscript><a href="https://secure.lglforms.com/form_engine/s/t_LVau_VWMYvzPyTGLUBMA">Fill out my LGL Form!</a><br></noscript> -->
            </div>
        </div>
    </div>
</div>
<!-- <div class="donation-form-mobile">

</div> -->

<!-- <script>
$(document).ready(function() {
    $(window).on('resize',function(){
        if ($(window).width() <767) {   
            $(".embedded-script").appendTo(".donation-form-mobile");
        }
        else {  
            $(".embedded-script").appendTo(".donation-form-desktop");
        }
    })
});
</script> -->
<style>
    .hero-row {
        max-width: 1200px;
        margin:auto;
        padding: 0px 10px;
    }
    .hero--text {
        padding-left: 20px;
        padding-right: 20px;
        /* max-width: 980px; */
        position: relative;
        z-index: 2;
    }
    .hero--video-donate-form {
        text-align: center;
        position: relative;
        /* padding: 90px 20px 0; */
        background-color: var(--hero_bg_color)
    }
    .hero--video-donate-form {
        padding-top:20px;
        padding-bottom: 20px
    }
    @media(max-width:767px) {
        .hero--text, .hero--donate-form {
            width:100%;
        }
        /* .hero--donate-form {
            display:none;
        } */
    }
/* @media only screen and (min-width: 1025px) {
    .hero--video-donate-form {
        padding-top:20px;
        padding-bottom: 20px
    }
} */

/* .hero--video-donate-form:after {
    content: "";
    display: block;
    width: calc(100% + 40px);
    height: 0;
    padding-bottom: 50%;
    position: relative;
    margin-top: 60px;
    left: -20px;
    background-size: cover;
    background-image: var(--hero_image)
} */

/* @media only screen and (min-width: 1025px) {
    .hero--video-donate-form:after {
        display:none
    }
} */

/* .hero--video-donate-form .hero--video-container {
    display: none
} */

@media only screen and (min-width: 1025px) {
    .hero--video-donate-form .hero--video-container {
        display:block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden
    }
}

.hero--video-donate-form .hero--video-wrapper,.hero--video-donate-form video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%
}

.hero--video-donate-form video {
    -o-object-fit: cover;
    object-fit: cover
}

.hero--video-donate-form .hero--text {
    color: white;
    text-shadow: 2px 2px 2px black;
}

/* .hero--video-donate-form .hero--donate-form,.hero--video-donate-form .hero--text {
    position: relative;
    z-index: 5
}

.hero--video-donate-form .hero--donate-form {
    margin-top: 30px
} */

/* @media only screen and (min-width: 1025px) {
    .hero--video-donate-form .hero--donate-form {
        flex-shrink:0;
        margin-top: 0
    }
} */

.hero--video-donate-form .hero--donate-form .toggle-buttons a {
    background: #fff
}

.hero--video-donate-form .hero--donate-form .toggle-buttons a:not(.active):hover {
    background-color: hsla(0,0%,100%,.75)
}

.hero--video-overlay {
    background-color: var(--hero_bg_color)
}
</style>
