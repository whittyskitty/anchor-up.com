# LCB Hero Banner API - Quick Start Guide

## API Endpoint

**Production URL**: `https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner`  
**Development URL**: `https://anchor-up-new.test/wp-json/stw/v1/lcb-hero-banner`

**Method**: `GET` (No authentication required)

## Quick Implementation

### JavaScript Example

```javascript
// Fetch active hero banner
fetch('https://www.anchor-up.com/wp-json/stw/v1/lcb-hero-banner')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.banner_url) {
            // Update your hero banner image
            document.getElementById('hero-banner').src = data.banner_url;
        }
    })
    .catch(error => console.error('Error:', error));
```

### Response Format

**Success with banner:**
```json
{
  "success": true,
  "banner_url": "https://www.anchor-up.com/wp-content/uploads/banner.jpg",
  "start_date": "2024-01-01",
  "end_date": "2024-12-31",
  "check_date": "2024-06-15"
}
```

**No active banner:**
```json
{
  "success": true,
  "banner_url": null,
  "start_date": null,
  "end_date": null,
  "check_date": "2024-06-15",
  "message": "No active promotion banner found."
}
```

## Optional Parameters

- `?date=2024-06-15` - Test with a specific date (format: Y-m-d)

## What It Does

1. Checks all published Anchor Up promotions
2. Finds promotions where current date falls between start and end dates
3. Returns the hero banner URL for the active promotion
4. Falls back to default banner if no active promotion
5. Returns `null` if no banner available

## Implementation Checklist

- [ ] Add fetch/request to get banner from API
- [ ] Update hero banner image element with returned URL
- [ ] Handle case when `banner_url` is `null` (use default or hide)
- [ ] Add error handling for network failures
- [ ] Test on staging before production

## Full Documentation

See `LCB_HERO_BANNER_API_IMPLEMENTATION.md` for complete documentation with examples in multiple languages (JavaScript, jQuery, PHP, React).

