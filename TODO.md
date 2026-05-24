# TODO

## 1) Fix supplier/coordinator “home” behavior
- Identify where “Home” button routes for supplier and coordinator UIs.
- Ensure tapping “Home” opens the supplier/coordinator feed (not the generic Homepage).

## 2) Feed side panel / navigation
- Ensure FEED pages (Supplier/FEED.php and coordinator equivalent) include the left sidebar so users can choose Dashboard, Feed, Bookings, etc.
- Ensure sidebar is visible on FEED screen (not hidden by layout/CSS).

## 3) Remove/avoid “homepage” entry point
- Remove “Home” tab/route inside the supplier/coordinator UI (or redirect it to FEED).
- If needed, update any top-nav/header button labeled “Home” to link to FEED.

## 4) Test
- Login as supplier and coordinator.
- Verify landing page + FEED screen has sidebar and “home” goes to feed.

