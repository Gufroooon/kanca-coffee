# Kanca Coffee - Replace Emojis with Lucide Icons (All Pages)

Goal: Replace ALL remaining emojis/symbols/arrows with Lucide icons across every page (not just home), using the existing Lucide icon system.

## Steps

- [ ] 1. layouts/admin.blade.php: collapse toggle arrows (◀ ▶) -> Lucide chevron-left/right
- [ ] 2. layouts/staff.blade.php: theme (🌙 ☀️), flash (✅ ⚠️✕) -> Lucide moon/sun/check-circle/alert-triangle/x
- [ ] 3. home.blade.php: testimonial star (★) -> Lucide star
- [ ] 4. about.blade.php: mission (🎯) vision (🌟) -> Lucide target/sparkles
- [ ] 5. contact.blade.php: info cards, tabs, feedback options, rating stars -> Lucide icons
- [ ] 6. community/index.blade.php: speaker (🎙️), location (📍), date (📅) -> Lucide mic/map-pin/calendar
- [ ] 7. community/show.blade.php: back arrow, speaker, location, close (✕) -> Lucide icons
- [ ] 8. menu/index.blade.php: category tabs, favorite heart, rating, close -> Lucide icons
- [ ] 9. menu/qr.blade.php: category icons, footer coffee -> Lucide icons
- [ ] 10. user/dashboard.blade.php: pass (🎟️), date (📅), phone (📱), heart, arrows -> Lucide icons
- [ ] 11. staff/dashboard.blade.php: clock in (🟢), clock out (🔴), checklist (✓) -> Lucide icons
- [ ] 12. admin/dashboard.blade.php: metric + action icons -> Lucide icons
- [ ] 13. admin/events/index.blade.php: location icon -> Lucide map-pin
- [ ] 14. admin/events/participants.blade.php: back arrow -> Lucide arrow-left
- [ ] 15. admin/menus/index.blade.php: rating star -> Lucide star
- [ ] 16. database/seeders/CategorySeeder.php: category icons -> Lucide icon names
- [ ] 17. Update menu views to render category icons via Lucide (slug mapping)
- [ ] 18. Re-seed categories (php artisan db:seed --class=CategorySeeder)
- [ ] 19. Build assets (npm run build)

