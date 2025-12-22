# LCB Hero Banner REST API Implementation Guide

## Overview

This document provides instructions for implementing the LCB (Local Christian Bookstore) Hero Banner API endpoint on the remote site (Shop The Word / Local Christian Bookstore). The endpoint retrieves active promotion hero banners based on date ranges stored in the Anchor Up WordPress site.

## API Endpoint Details

### Base URLs
- **Local/Development**: `https://anchor-up-new.test/wp-json/stw/v1/lcb-hero-banner`
- **Production**: `https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner`

### Endpoint Information
- **Method**: `GET`
- **Authentication**: None required (public endpoint)
- **Content-Type**: `application/json`

## Request Parameters

### Optional Parameters

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `date` | string | Optional date for testing (format: `Y-m-d`). If omitted, uses current date. | `2024-06-15` |

## Response Format

### Success Response (Active Promotion Found)

```json
{
  "success": true,
  "banner_url": "https://www.anchor-up.com/wp-content/uploads/2024/01/promotion-banner.jpg",
  "start_date": "2024-01-01",
  "end_date": "2024-12-31",
  "check_date": "2024-06-15"
}
```

### Success Response (No Active Promotion, Default Banner Found)

```json
{
  "success": true,
  "banner_url": "https://www.anchor-up.com/wp-content/uploads/default-banner.jpg",
  "start_date": null,
  "end_date": null,
  "check_date": "2024-06-15",
  "message": "Using default banner (no active promotion found)."
}
```

### Success Response (No Banner Found)

```json
{
  "success": true,
  "banner_url": null,
  "start_date": null,
  "end_date": null,
  "check_date": "2024-06-15",
  "message": "No active promotion banner or default banner found for the specified date."
}
```

### Error Response

```json
{
  "code": "invalid_date",
  "message": "Invalid date format. Use Y-m-d format.",
  "data": {
    "status": 400
  }
}
```

## Implementation Examples

### JavaScript/Fetch Example

```javascript
/**
 * Fetch the active LCB hero banner from Anchor Up API
 * @param {string} testDate - Optional date for testing (format: Y-m-d)
 * @returns {Promise<Object>} API response with banner data
 */
async function getLCBHeroBanner(testDate = null) {
    const baseUrl = 'https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner';
    const url = testDate ? `${baseUrl}?date=${testDate}` : baseUrl;
    
    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching LCB hero banner:', error);
        return {
            success: false,
            banner_url: null,
            error: error.message
        };
    }
}

// Usage
getLCBHeroBanner().then(data => {
    if (data.success && data.banner_url) {
        // Update hero banner image
        const heroBanner = document.getElementById('lcb-hero-banner');
        if (heroBanner) {
            heroBanner.src = data.banner_url;
            heroBanner.alt = 'Active Promotion Banner';
        }
    } else {
        // Handle no banner found (use default or hide banner)
        console.log('No active banner found:', data.message);
    }
});
```

### jQuery Example

```javascript
/**
 * Fetch the active LCB hero banner using jQuery
 */
function loadLCBHeroBanner(testDate = null) {
    const baseUrl = 'https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner';
    const url = testDate ? `${baseUrl}?date=${testDate}` : baseUrl;
    
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success && data.banner_url) {
                // Update hero banner image
                $('#lcb-hero-banner').attr('src', data.banner_url);
                $('#lcb-hero-banner').attr('alt', 'Active Promotion Banner');
                
                // Optional: Show banner container if hidden
                $('#lcb-hero-banner-container').show();
            } else {
                // Handle no banner found
                console.log('No active banner found:', data.message);
                // Optionally hide banner container
                $('#lcb-hero-banner-container').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching LCB hero banner:', error);
            // Fallback to default banner or hide
            $('#lcb-hero-banner-container').hide();
        }
    });
}

// Usage on page load
$(document).ready(function() {
    loadLCBHeroBanner();
});
```

### PHP Example

```php
<?php
/**
 * Fetch the active LCB hero banner from Anchor Up API
 * 
 * @param string|null $testDate Optional date for testing (format: Y-m-d)
 * @return array|false API response data or false on error
 */
function get_lcb_hero_banner($testDate = null) {
    $baseUrl = 'https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner';
    $url = $testDate ? $baseUrl . '?date=' . urlencode($testDate) : $baseUrl;
    
    $response = wp_remote_get($url, array(
        'timeout' => 10,
        'sslverify' => true,
    ));
    
    if (is_wp_error($response)) {
        error_log('LCB Hero Banner API Error: ' . $response->get_error_message());
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('LCB Hero Banner API: Invalid JSON response');
        return false;
    }
    
    return $data;
}

// Usage
$bannerData = get_lcb_hero_banner();

if ($bannerData && $bannerData['success'] && !empty($bannerData['banner_url'])) {
    $bannerUrl = esc_url($bannerData['banner_url']);
    ?>
    <div id="lcb-hero-banner-container">
        <img src="<?php echo $bannerUrl; ?>" 
             alt="Active Promotion Banner" 
             id="lcb-hero-banner"
             class="hero-banner-image">
    </div>
    <?php
} else {
    // Handle no banner found - use default or hide
    ?>
    <!-- Default banner or no banner display -->
    <?php
}
?>
```

### React/Next.js Example

```jsx
import { useState, useEffect } from 'react';

/**
 * React component for LCB Hero Banner
 */
export default function LCBHeroBanner({ testDate = null }) {
    const [bannerData, setBannerData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    
    useEffect(() => {
        const fetchBanner = async () => {
            try {
                const baseUrl = 'https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner';
                const url = testDate ? `${baseUrl}?date=${testDate}` : baseUrl;
                
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                setBannerData(data);
            } catch (err) {
                setError(err.message);
                console.error('Error fetching LCB hero banner:', err);
            } finally {
                setLoading(false);
            }
        };
        
        fetchBanner();
    }, [testDate]);
    
    if (loading) {
        return <div className="lcb-hero-banner-loading">Loading...</div>;
    }
    
    if (error) {
        return <div className="lcb-hero-banner-error">Error loading banner</div>;
    }
    
    if (bannerData?.success && bannerData?.banner_url) {
        return (
            <div id="lcb-hero-banner-container">
                <img 
                    src={bannerData.banner_url}
                    alt="Active Promotion Banner"
                    id="lcb-hero-banner"
                    className="hero-banner-image"
                />
            </div>
        );
    }
    
    // No banner found - return null or default banner
    return null;
}
```

## Implementation Checklist

- [ ] Choose implementation method (JavaScript, PHP, React, etc.)
- [ ] Add API endpoint URL to configuration (use production URL for live site)
- [ ] Implement fetch/request function with error handling
- [ ] Add banner image element to page template
- [ ] Handle loading states (optional but recommended)
- [ ] Handle error states (fallback to default banner or hide)
- [ ] Test with current date
- [ ] Test with future date (should return null if no promotion)
- [ ] Test with past date (should return null if no promotion)
- [ ] Test error handling (invalid date format, network errors)
- [ ] Add caching if needed (recommended: cache for 1 hour)
- [ ] Deploy to staging environment
- [ ] Test on staging
- [ ] Deploy to production

## Best Practices

### 1. Caching
Consider implementing client-side or server-side caching to reduce API calls:

```javascript
// Example: Cache for 1 hour
const CACHE_KEY = 'lcb_hero_banner';
const CACHE_DURATION = 60 * 60 * 1000; // 1 hour in milliseconds

function getCachedBanner() {
    const cached = localStorage.getItem(CACHE_KEY);
    if (cached) {
        const { data, timestamp } = JSON.parse(cached);
        if (Date.now() - timestamp < CACHE_DURATION) {
            return data;
        }
    }
    return null;
}

function setCachedBanner(data) {
    localStorage.setItem(CACHE_KEY, JSON.stringify({
        data: data,
        timestamp: Date.now()
    }));
}
```

### 2. Error Handling
Always implement proper error handling:

- Network errors
- Invalid responses
- Missing banner URLs
- Timeout handling

### 3. Fallback Behavior
Define what happens when no banner is found:

- Use default banner image
- Hide banner section
- Show placeholder
- Log for monitoring

### 4. Performance
- Use lazy loading for banner images
- Implement request debouncing if calling on multiple pages
- Consider server-side rendering for initial page load

### 5. Testing
Test various scenarios:

- Current date with active promotion
- Current date without active promotion
- Future date
- Past date
- Invalid date format
- Network failures

## Date Range Logic

The API checks promotions using the following date range logic:

1. **Start Date**: Uses `marketing_to_anchor_up_stores_start_date` if available, otherwise falls back to `promotion_start_date`
2. **End Date**: Always uses `promotion_end_date`
3. **Date Comparison**: Checks if the requested date (or current date) falls within the range (inclusive)
4. **Priority**: Returns the first matching promotion found (ordered by marketing start date, most recent first)

## Response Field Descriptions

| Field | Type | Description |
|-------|------|-------------|
| `success` | boolean | Always `true` for successful requests |
| `banner_url` | string\|null | URL of the banner image, or `null` if no banner found |
| `start_date` | string\|null | Start date of the active promotion (format: Y-m-d), or `null` |
| `end_date` | string\|null | End date of the active promotion (format: Y-m-d), or `null` |
| `check_date` | string | The date that was checked (format: Y-m-d) |
| `message` | string | Optional message explaining the response (only present when no active promotion found) |

## Troubleshooting

### Issue: Banner not updating
- **Solution**: Check if caching is implemented and clear cache
- **Solution**: Verify the date range of the promotion in WordPress admin
- **Solution**: Check browser console for API errors

### Issue: CORS errors
- **Solution**: The endpoint is public and should not have CORS issues. If encountered, contact the Anchor Up development team.

### Issue: Slow response times
- **Solution**: Implement caching (recommended: 1 hour)
- **Solution**: Use server-side fetching instead of client-side if possible

### Issue: Invalid date format error
- **Solution**: Ensure date parameter uses `Y-m-d` format (e.g., `2024-06-15`)

## Support

For issues or questions regarding this API:
- **Development Team**: Contact Anchor Up development team
- **API Documentation**: This document
- **WordPress Admin**: Check promotion settings in Anchor Up WordPress admin panel

## Version History

- **v1.0** (2024-01-XX): Initial implementation
  - Basic endpoint with date range checking
  - Support for default banner fallback
  - Optional date parameter for testing

