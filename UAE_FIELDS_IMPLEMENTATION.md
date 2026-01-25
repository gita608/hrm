# UAE HRM Fields Implementation Summary

## Overview
This document summarizes all UAE-specific fields that have been added to the HRM system to comply with UAE labor law and HR requirements.

## Database Migrations Created

1. **2026_01_25_000001_add_uae_fields_to_users_table.php**
   - Adds UAE-specific fields to users/employees table

2. **2026_01_25_000002_add_uae_fields_to_candidates_table.php**
   - Adds UAE-specific fields to candidates table

3. **2026_01_25_000003_add_uae_fields_to_job_postings_table.php**
   - Adds UAE-specific fields to job postings table

4. **2026_01_25_000004_add_uae_fields_to_resignations_table.php**
   - Adds visa and labor card cancellation dates

5. **2026_01_25_000005_add_uae_fields_to_terminations_table.php**
   - Adds visa and labor card cancellation dates

6. **2026_01_25_000006_add_uae_fields_to_trainings_table.php**
   - Adds UAE labor law compliance flag

## UAE Fields Added by Module

### 1. Users/Employees Module

**Fields Added:**
- `emirates_id` (string, unique, nullable) - Emirates ID number
- `passport_number` (string, nullable) - Passport number
- `passport_expiry_date` (date, nullable) - Passport expiry date
- `nationality` (string, nullable) - Nationality
- `visa_type` (enum: employment, dependent, investor, student, tourist, other) - Type of visa
- `visa_number` (string, nullable) - Visa number
- `visa_expiry_date` (date, nullable) - Visa expiry date
- `labor_card_number` (string, nullable) - Labor card number
- `labor_card_expiry_date` (date, nullable) - Labor card expiry date
- `bank_name` (string, nullable) - Bank name (UAE banks)
- `iban` (string, nullable) - IBAN number (UAE format)
- `uae_emirate` (enum: Abu Dhabi, Dubai, Sharjah, Ajman, Umm Al Quwain, Ras Al Khaimah, Fujairah) - UAE Emirate
- `uae_city` (string, nullable) - UAE City
- `uae_area` (string, nullable) - UAE Area/Neighborhood
- `emergency_contact_name` (string, nullable) - Emergency contact name
- `emergency_contact_phone` (string, nullable) - Emergency contact phone

**Files Updated:**
- `app/Models/User.php` - Added fields to fillable array and casts
- `app/Http/Controllers/UserController.php` - Added validation rules
- `app/Http/Controllers/ProfileController.php` - Added validation rules
- `resources/views/pages/users/create.blade.php` - Added form fields
- `resources/views/pages/users/edit.blade.php` - Added form fields
- `resources/views/pages/profile/index.blade.php` - Should be updated to display/edit UAE fields

### 2. Candidates Module

**Fields Added:**
- `emirates_id` (string, nullable) - Emirates ID
- `passport_number` (string, nullable) - Passport number
- `nationality` (string, nullable) - Nationality
- `visa_status` (enum: valid, expired, not_required, pending) - Current visa status
- `current_location_emirate` (enum: Abu Dhabi, Dubai, Sharjah, Ajman, Umm Al Quwain, Ras Al Khaimah, Fujairah, Outside UAE) - Current location emirate
- `current_location_city` (string, nullable) - Current location city

**Files Updated:**
- `app/Models/Candidate.php` - Added fields to fillable array
- `app/Http/Controllers/CandidateController.php` - Added validation rules
- `resources/views/pages/candidates/create.blade.php` - Added form fields
- `resources/views/pages/candidates/edit.blade.php` - Added form fields

### 3. Job Postings Module

**Fields Added:**
- `uae_emirate` (enum: Abu Dhabi, Dubai, Sharjah, Ajman, Umm Al Quwain, Ras Al Khaimah, Fujairah) - Job location emirate
- `uae_city` (string, nullable) - Job location city
- `visa_sponsorship` (boolean, default: false) - Whether visa sponsorship is provided
- `work_permit_required` (boolean, default: false) - Whether work permit is required

**Files Updated:**
- `app/Models/JobPosting.php` - Added fields to fillable array and casts
- `app/Http/Controllers/JobPostingController.php` - Added validation rules
- `resources/views/pages/jobs/create.blade.php` - Added form fields
- `resources/views/pages/jobs/edit.blade.php` - Added form fields

### 4. Resignations Module

**Fields Added:**
- `visa_cancellation_date` (date, nullable) - Date visa was cancelled
- `labor_card_cancellation_date` (date, nullable) - Date labor card was cancelled

**Files Updated:**
- `app/Models/Resignation.php` - Added fields to fillable array and casts
- `app/Http/Controllers/ResignationController.php` - Added validation rules
- Views should be updated to include these fields

### 5. Terminations Module

**Fields Added:**
- `visa_cancellation_date` (date, nullable) - Date visa was cancelled
- `labor_card_cancellation_date` (date, nullable) - Date labor card was cancelled

**Files Updated:**
- `app/Models/Termination.php` - Added fields to fillable array and casts
- `app/Http/Controllers/TerminationController.php` - Added validation rules
- Views should be updated to include these fields

### 6. Training Module

**Fields Added:**
- `uae_labor_law_compliance` (boolean, default: false) - Flag for UAE labor law compliance training

**Files Updated:**
- `app/Models/Training.php` - Added field to fillable array and casts
- `app/Http/Controllers/TrainingController.php` - Added validation rules
- Views should be updated to include this field

## Next Steps

1. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

2. **Update Additional Views:**
   - Update `resources/views/pages/profile/index.blade.php` to include UAE fields
   - Update `resources/views/pages/users/show.blade.php` to display UAE fields
   - Update `resources/views/pages/candidates/show.blade.php` to display UAE fields
   - Update `resources/views/pages/jobs/show.blade.php` to display UAE fields
   - Update resignation and termination views to include cancellation dates
   - Update training views to include UAE compliance checkbox

3. **Testing:**
   - Test all forms with UAE field validation
   - Test data entry and retrieval
   - Verify date formatting and display

4. **Optional Enhancements:**
   - Add date expiry reminders/alerts for visas and labor cards
   - Add reports for visa/labor card expiry tracking
   - Add export functionality for UAE compliance reports

## Important Notes

- Emirates ID is set as unique in the users table (required for UAE compliance)
- All UAE-specific fields are nullable to allow gradual data entry
- Date fields use Laravel's date casting for proper formatting
- Enum fields use predefined values to ensure data consistency
- Boolean fields use checkboxes/switches in forms for better UX

## Compliance

These fields help ensure compliance with:
- UAE Labor Law requirements
- Ministry of Human Resources & Emiratisation (MOHRE) regulations
- Visa and work permit tracking requirements
- Employee documentation requirements
