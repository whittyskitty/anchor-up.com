# Quick Guide: Creating a New Anchor Up Promotion

## Step-by-Step Process

1. **Go to WordPress Admin** → `Anchor-Up Promotions` → `Add New`
2. **Enter Promotion Title** (e.g., "Brave Books Test")
3. **Fill Required Fields** (marked with red asterisk)
4. **Add Optional Content**
5. **Publish**

---

## ✅ REQUIRED FIELDS

### 1. **Marketing to Anchor Up Stores Start Date** ⚠️ REQUIRED
   - When the banner appears on Anchor-up.com
   - Usually weeks/months before promotion starts
   - **Purpose**: Stores see upcoming promotions and can register early

### 2. **Promotion Header Image** ⚠️ REQUIRED
   - **Format**: JPG or PNG only
   - **Ideal Size**: 1800 × 920 pixels
   - **File Size**: Max 500kb (ideally 200kb)
   - **Used**: Hero banner on single promotion page

### 3. **Promotion Description** ⚠️ REQUIRED
   - Rich text editor (WYSIWYG)
   - Appears under "About this Promotion" header
   - **Keep it concise** - archive page truncates to a few lines

### 4. **Promotion Start Date** ⚠️ REQUIRED
   - When the promotion officially begins
   - **Validation**: Must be before End Date
   - **Used for**: Sorting, highlighting current/upcoming promotions

### 5. **Promotion End Date** ⚠️ REQUIRED
   - When the promotion officially ends
   - **Validation**: Must be after Start Date
   - **Used for**: Sorting, highlighting current/upcoming promotions

---

## 📋 IMPORTANT FIELDS (Highly Recommended)

### **Setup Video Demonstration**
   - YouTube URL (NOT embed code)
   - Example: `https://www.youtube.com/watch?v=VIDEO_ID`
   - Shows stores how to set up the promotion

### **What's In the Box**
   - Rich text description of promotional materials
   - Helps stores understand what they'll receive

### **Understanding File**
   - PDF or document file
   - Additional documentation for stores

### **Agreement Form Selection**
   - Select a Gravity Form
   - Stores must complete this to participate

### **Digital Assets** (Repeater Field)
   - Add multiple digital marketing assets
   - **For each asset, include:**
     - **Digital Channel**: Instagram, Facebook, Email, Website Homepage, Radio Spot, Video Spot
     - **Digital File**: The actual file (image, PDF, etc.)
     - **Suggested Text**: Copy for social media posts
     - **Date To Share**: When stores should post
     - **Date to Remove**: (Only for "Website Homepage" channel)
     - **Is this a form?**: Check if it's a form submission
     - **Description**: What the asset is for
     - **Digital File Name Override**: Custom display name

---

## 🎨 OPTIONAL FIELDS

### **Anchor-Up.com Promotion Featured Banner**
   - Banner image for Anchor-Up.com homepage
   - **Also add**: `Anchor-Up.com Promotion Featured Link` (URL)

### **Anchor Up Homepage Featured Video**
   - YouTube URL for homepage video

### **Local Christian Bookstore.com Fields**
   - `Local Christian Find a Bookstore Near Me Promotional Text`
   - `Local Christian Bookstore Long Text Under Find Store Buttons`
   - `Local Christian Bookstore.com Hero Banner During Promotion Period`
     - **Ideal Size**: 1800 × 920 pixels
     - **Max Size**: 500kb (ideally 200kb)

---

## ⚠️ THINGS TO WATCH OUT FOR

### 1. **Date Validation**
   - ❌ **Start Date must be BEFORE End Date**
   - ❌ **Cannot overlap with existing promotions**
   - System will show error if dates overlap

### 2. **Image Requirements**
   - **Header Image**: JPG/PNG only, max 500kb
   - **Hero Banner**: 1800 × 920 ideal size
   - Large files will slow down page load

### 3. **YouTube URLs**
   - ✅ Use: `https://www.youtube.com/watch?v=VIDEO_ID`
   - ❌ Don't use: Embed code or shortened URLs
   - System automatically converts to iframe

### 4. **Post Title**
   - Make it descriptive and clear
   - Example: "Brave Books Test" or "Summer Reading Challenge 2025"
   - Used in breadcrumbs, archive page, admin list

### 5. **Archive Page Display**
   - **Current/Upcoming Promotions**: Shown at top, highlighted
   - **Past Promotions**: Shown below
   - **No Upcoming**: Shows "No upcoming promotions" message
   - Description is truncated to a few lines

### 6. **Admin List Sorting**
   - Defaults to **Promotion Start Date** (most upcoming first)
   - Columns show: Title, Promotion Start Date, Promotion End Date

### 7. **Store Submissions**
   - Stores submit via ACF form on single promotion page
   - Form requires: **Store ID** and **Store Name** (auto-populated if logged in)
   - Submission creates `promo-submission` post type

### 8. **Digital Assets**
   - **Website Homepage** assets require "Date to Remove"
   - Use "Is this a form?" checkbox for form submissions
   - Add "Date To Share" for social media scheduling

---

## 📝 QUICK CHECKLIST

Before publishing, verify:

- [ ] Marketing Start Date is set (required)
- [ ] Promotion Header Image uploaded (JPG/PNG, <500kb)
- [ ] Promotion Description filled (required)
- [ ] Promotion Start Date set (required)
- [ ] Promotion End Date set (required)
- [ ] Start Date is before End Date
- [ ] No date overlap with existing promotions
- [ ] Setup Video URL added (if applicable)
- [ ] Digital Assets added (if applicable)
- [ ] Agreement Form selected (if required)
- [ ] Post title is clear and descriptive

---

## 🔍 WHERE TO FIND PROMOTIONS

- **Frontend Archive**: `/anchor-up-promotions/`
- **Single Promotion**: `/anchor-up-promotions/{slug}/`
- **Admin List**: `/wp-admin/edit.php?post_type=anchor-up-promotion`
- **Store Submissions**: `/wp-admin/edit.php?post_type=promo-submission`

---

## 💡 PRO TIPS

1. **Create promotions early**: Set Marketing Start Date weeks in advance so stores can prepare
2. **Test images**: Check how header images look on mobile devices
3. **Keep descriptions short**: Archive page truncates long descriptions
4. **Use clear file names**: Digital assets should have descriptive names
5. **Add all digital assets upfront**: Don't forget Instagram, Facebook, Email versions
6. **Set share dates**: Help stores know when to post on social media
7. **Check for overlaps**: System validates, but double-check manually

---

## 🆘 TROUBLESHOOTING

**Error: "Start date must be before end date"**
- Check that Promotion Start Date is earlier than Promotion End Date

**Error: "Date range overlaps with existing entries"**
- Check other promotions in admin list
- Adjust dates to avoid overlap

**Images not displaying**
- Check file format (JPG/PNG only for header)
- Verify file size is under 500kb
- Ensure image URL is accessible

**YouTube video not embedding**
- Use full YouTube URL, not embed code
- Format: `https://www.youtube.com/watch?v=VIDEO_ID`

**Digital assets not showing**
- Verify "Digital Channel" is selected
- Check that "Digital File" is uploaded
- Ensure dates are set correctly

