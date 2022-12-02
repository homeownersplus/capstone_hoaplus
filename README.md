# Notes

## Notes

- check the database on `databases/pdocrud_nov_27.sql` for up to date database schema

## Changelog

### Bugfix 1 2022-12-02

- president role can now access manage admins
- remove unused excel reports
- fixed manage payments date filter to filter by `Date Due`
- fixed manage reservations date filter to reservation time start filter by `Reservation Start Time`
- user cancel reservation button now shows up properly
- user can now view their payment history
- renamed pdf report buttons to `Generate Report`
- ajusted magins of admin reservation table action buttons
- add member payment table generate pdf report

### Week 3 2022-11-27

- added more fields in `user` table
- added `logs` table
- added `user_family` table
- added `payments` table
- show last payment and next due payment in user profile
- added log when admin adds a member
- added log when admin confirms member payment
- auto calculate member due date
- add reservation restriction when overdue payment is above 300
- user can cancel reservation
- admins can view logs
- admins can confirm payments
- admins can search, paginate, and generate payment reports

### Week 2 2022-11-20

- fetch user details in user profile
- user profile pic on the top bar
- user name on the top bars
- user can change default profile picture
- add restriction on manage admins
- add `avatar`, `created_at`, `contact_number`, `phase_block_lot`, `barangay` on `user` table
- added role restriction on all pages
- added `reservations` table
- user can now reserve amenity
- user can view their reservation history
- reservation history pagination
- admin reservation table search
- admin reservation table filter
- admin reservation table generate report
- fix logout routes

### Week 1 2022-11-13

- added single login page for all accounts
- added post password confirmation
- added user "read more" pop up announcement
- added user info in amenity reservation
- added restriction on past dates in amenity reservation
- added restriction on past time in amenity reservation
- added restriction on end time to minimum 1 hour above start time in amenity reservation
