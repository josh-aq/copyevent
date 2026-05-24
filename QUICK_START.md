# 🚀 Quick Start Guide - New Features

## For Testing the AI Recommendation Engine

### Step 1: Login as Client
- URL: `http://localhost/CapCopy-Eventintel-main/auth/login.php`
- Username: `client`
- Password: `password`

### Step 2: Create an Event (Optional, but recommended for best results)
- Click "Create Event"
- Add event details (Title, Type, Date, Budget, Guest Count)
- Save event

### Step 3: Access Recommendations
- From Homepage, click "Recommendations" button
- OR go to: `http://localhost/CapCopy-Eventintel-main/userui/html/recommendation.php`

### Step 4: Generate Timeline
1. **Select Event** from dropdown (shows your events)
   - Auto-fills: Event Type, Budget, Guest Count
2. **Check Service Boxes** (Venue, Catering, Host, etc.)
3. **Click "Generate Timeline & Recommendations"**
4. **View Results:**
   - 📅 Event timeline with specific times
   - 💰 Budget breakdown
   - 🎯 Service recommendations
   - 💡 AI tips (if OpenAI API configured)
5. **Click "Regenerate"** for different suggestions

---

## For Testing Role-Based Profiles

### Client Profile
- Click profile icon → "Profile"
- See: Account info, Statistics
- Logout button at bottom

### Supplier Profile
1. Login as Supplier:
   - Username: `supplier`
   - Password: `password`
2. Click profile icon
3. View: Business info, Services count, Bookings, Rating

### Event Coordinator Profile
1. Login as Coordinator:
   - Username: `coordinator`  
   - Password: `password`
2. Click profile icon
3. View: Coordinator info, Events managed, Active clients, Rating

---

## Event Timeline Examples

### Wedding
- 8:00 AM - Guest Arrival & Registration
- 9:00 AM - Ceremony Starts
- 10:00 AM - Reception & Cocktail Hour
- 11:30 AM - Grand Entrance & First Dance
- 12:00 PM - **Lunch Service** ← Main meal time
- 6:00 PM - Farewell & Send-off

### Birthday Party
- 2:00 PM - Guest Arrival
- 2:30 PM - Icebreaker Activities
- 3:30 PM - Snack Break
- 4:00 PM - Main Entertainment (DJ/Dancing)
- 5:00 PM - **Dinner Service** ← Main meal time
- 6:00 PM - Birthday Cake & Singing
- 7:30 PM - Dessert & Closing

### Corporate Event
- 8:00 AM - Registration & Breakfast
- 9:00 AM - Opening Remarks
- 9:30 AM - Keynote Speech
- 10:30 AM - Break & Networking
- 11:00 AM - Breakout Sessions
- 12:00 PM - **Lunch** ← Main meal time
- 1:00 PM - Awards & Recognition
- 2:00 PM - Team Building

---

## Budget Allocation Example

**Wedding with 100 guests, ₱500,000 budget:**

```
Selected Services:
□ Venue
□ Catering
☑ Host (checked)
☑ Photographer (checked)
☑ Sounds & Lights (checked)
```

**Recommendation Output:**
- 🏛️ Venue Rental: ₱150,000 (30% of budget)
- 🍽️ Catering: ₱175,000 (35% of budget) = ₱1,750 per person
- 🎤 Host/MC: ₱40,000 (8% of budget)
- 📸 Photography: ₱50,000 (10% of budget)
- 🎵 Sounds & Lights: ₱40,000 (8% of budget)
- 💰 Total: ₱455,000 (9% contingency buffer)

---

## All Headers Now Have Logout Button

### Client Dashboard
```
EventIntel | Home | Create Event | Your Events | Recommendations | Newsfeed | 👤 | 🔐 Logout
```

### Supplier Dashboard
```
EventIntel | Dashboard | My Services | Bookings | Reviews | 👤 | 🔐 Logout
```

### Coordinator Dashboard
```
EventIntel | Dashboard | My Clients | My Events | Messages | 👤 | 🔐 Logout
```

---

## Testing Checklist

- [ ] Can see all my events in dropdown
- [ ] Timeline generates with correct times
- [ ] Budget shows per-person cost
- [ ] Services get budget allocation
- [ ] Regenerate button works
- [ ] Logout button appears in all headers
- [ ] Supplier profile displays correctly
- [ ] Coordinator profile displays correctly
- [ ] Newsfeed posts work
- [ ] Can like posts

---

## Troubleshooting

**Problem**: No events in dropdown
- **Solution**: Create an event first in "Create Event"

**Problem**: Timeline not showing
- **Solution**: Select services before clicking Generate

**Problem**: AI tips not showing
- **Solution**: OpenAI API is optional, built-in templates work fine

**Problem**: Can't access coordinator pages
- **Solution**: Make sure logged in as coordinator, not client

---

## Demo Data

All demo accounts already created with password: `password`

| Account | Role | Username | Password |
|---------|------|----------|----------|
| Admin | Admin | `admin` | `password` |
| Client | Client | `client` | `password` |
| Supplier | Supplier | `supplier` | `password` |
| Coordinator | Coordinator | `coordinator` | `password` |

---

**Enjoy your new EventIntel features! 🎉**
