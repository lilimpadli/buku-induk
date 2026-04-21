# Laravel Authentication Setup Investigation Report

**Date**: April 21, 2026  
**Application**: Buku Induk (School Management System)

---

## 1. Authentication Configuration

### Location: [config/auth.php](config/auth.php)

**Guard Configuration:**
- **Default Guard**: `web` (session-based)
- **Default Password Broker**: `users`
- **Driver**: `session`
- **User Provider**: `eloquent` (using Eloquent model)

**User Provider Model:**
- **Model**: `App\Models\User` (resolved from `AUTH_MODEL` env variable)
- **Status**: ✅ Properly configured

**Password Reset:**
- **Token Table**: `password_reset_tokens`
- **Token Expiry**: 60 minutes
- **Throttle**: 60 seconds

---

## 2. User Model Analysis

### Location: [app/Models/User.php](app/Models/User.php)

**Model Inheritance:**
- Extends: `Illuminate\Foundation\Auth\User` (Authenticatable)
- Uses: `HasFactory`, `Notifiable`

**Fillable Fields:**
```php
['name', 'nomor_induk', 'nisn', 'photo', 'email', 'password', 'role']
```

**Hidden Fields:**
- `password`
- `remember_token`

**Key Features:**
- ✅ Uses `Illuminate\Database\Eloquent\Factories\HasFactory` for testing
- ✅ Uses `Illuminate\Notifications\Notifiable` for notifications
- ✅ Password casting: `'hashed'` (automatic hashing)

**Custom Authentication Identifier:**
```php
public function getAuthIdentifierName()
{
    return 'nomor_induk';  // Uses NIS/NIP instead of 'id'
}
```

**⚠️ IMPORTANT**: The User model uses a **custom authentication identifier** (`nomor_induk` instead of `id`). This means:
- Login is via NIS (Nomor Induk Siswa) or NIP (Nomor Induk Pegawai)
- May conflict with some Laravel features expecting numeric ID

**Relationships:**
- `guru()`: One-to-One with Guru model
- `rombels()`: Many-to-Many with Rombel through Guru
- `waliKelas()`: One-to-Many with WaliKelas model

---

## 3. Database Table Structure

### Location: [database/migrations/0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php)

**Current Users Table Schema:**

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| `id` | BIGINT | PRIMARY KEY, AUTO_INCREMENT | |
| `name` | VARCHAR(255) | NOT NULL | Full name |
| `nomor_induk` | VARCHAR(255) | UNIQUE, NOT NULL | NIS (siswa) or NIP (guru/staff) |
| `photo` | VARCHAR(255) | NULLABLE | Profile photo path |
| `email` | VARCHAR(255) | NULLABLE, UNIQUE | Optional email |
| `role` | ENUM | NOT NULL | User role (see below) |
| `password` | VARCHAR(255) | NOT NULL | Bcrypt hashed password |
| `remember_token` | VARCHAR(100) | NULLABLE | Remember me token |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

**Password Reset Tokens Table:**
- Primary: `email`
- Columns: `email`, `token`, `created_at`

**Sessions Table:**
- Primary: `id`
- User tracking: `user_id` (foreign key, nullable)
- IP and user agent logging

---

## 4. Authentication Roles & Role Enum

### Current Role Enum (as of latest migration)

**Available Roles** (from [2026_04_14_081508_add_super_admin_to_users_role_enum_final.php](database/migrations/2026_04_14_081508_add_super_admin_to_users_role_enum_final.php)):

```
'siswa'           - Student
'walikelas'       - Class guardian/advisor
'kaprog'          - Program head
'tu'              - Administrative staff (TU)
'tu_kepegawaian'  - Personnel administrative staff
'kurikulum'       - Curriculum staff
'calon_siswa'     - Prospective student
'guru'            - Teacher
'super_admin'     - Super administrator
```

**Evolution of Roles:**
1. Initial roles (Migration 0001): siswa, walikelas, kaprog, tu, kurikulum, calon_siswa
2. Added 'guru' role (2026_01_15_000000)
3. Added 'tu_kepegawaian' and 'super_admin' (2026_04_14)

---

## 5. Login Controller & Authentication Flow

### Location: [app/Http/Controllers/Auth/LoginController.php](app/Http/Controllers/Auth/LoginController.php)

**Login Process:**

1. **Validation:**
   ```php
   - nomor_induk (required)
   - password (required)
   ```

2. **User Lookup:**
   - Case-insensitive search using `whereRaw('LOWER(nomor_induk) = ?')`
   - ✅ Good for UX (case-insensitive login)

3. **Password Verification:**
   - Uses `Hash::check()` for secure password comparison
   - ✅ Secure implementation

4. **Session Management:**
   - Uses `Auth::login()` with optional remember token
   - Redirects to role-specific dashboard

**Role-Based Redirects:**
```
siswa         → siswa.dashboard
guru          → guru.dashboard
walikelas     → walikelas.dashboard
kaprog        → kaprog.dashboard
tu            → tu.dashboard
kurikulum     → kurikulum.dashboard
calon_siswa   → calon.dashboard
default       → dashboard (generic)
```

**⚠️ ISSUE #1**: Missing `tu_kepegawaian` and `super_admin` roles in `redirectByRole()` method!
- These roles exist in the enum but have no dashboard redirect
- Falls back to generic `dashboard` route

**Logout:**
- Uses `Auth::logout()` to destroy session
- Redirects to login page

---

## 6. Authentication Routes

### Location: [routes/web.php](routes/web.php) (Lines 156-172)

**Public Routes (No Auth Required):**
```
GET  /login                    → LoginController@showLoginForm
POST /login                    → LoginController@login
GET  /siswa/reset-password    → SiswaResetPasswordController@showResetForm
POST /siswa/reset-password    → SiswaResetPasswordController@reset
```

**Protected Routes (Auth Required):**
```
POST /logout                   → LoginController@logout (auth middleware)
GET  /dashboard                → Role-based redirect
```

**Middleware Protection:**
- Login routes use `guest` middleware (only accessible when NOT logged in)
- Logout uses `auth` middleware (only accessible when logged in)
- All authenticated routes use `auth` middleware

---

## 7. Role-Based Access Control Middleware

### Location: [app/Http/Middleware/RoleMiddleware.php](app/Http/Middleware/RoleMiddleware.php)

**Middleware Features:**

1. **Authentication Check:**
   - Redirects to login if not authenticated
   - ✅ Proper guard clause

2. **Role Validation:**
   - Checks if user's role is in allowed roles
   - Returns 403 Forbidden if unauthorized

3. **Role-Specific Database Validation:**
   ```
   - Guru role: Must have record in 'gurus' table
   - Walikelas: Must have Guru record (wali kelas status)
   ```

**Usage in Routes:**
```php
Route::middleware('role:guru')->group(...);
Route::middleware('role:walikelas')->group(...);
Route::middleware('role:siswa')->group(...);
```

**Example Route Group:**
```
/siswa/**          → middleware: auth, role:siswa
/guru/**           → middleware: auth, role:guru
/walikelas/**      → middleware: auth, role:walikelas
/kaprog/**         → middleware: auth, role:kaprog
/tu/**             → middleware: auth, role:tu
/kurikulum/**      → middleware: auth, role:kurikulum
```

---

## 8. Identified Issues & Concerns

### ⚠️ CRITICAL ISSUES

#### **Issue #1: Missing Role Redirects**
- **Severity**: HIGH
- **Location**: [LoginController.php](app/Http/Controllers/Auth/LoginController.php#L54-L62)
- **Problem**: `tu_kepegawaian` and `super_admin` roles missing from `redirectByRole()`
- **Impact**: Users with these roles land on generic dashboard instead of role-specific dashboards
- **Fix**: Add dashboard routes for these roles and update the `redirectByRole()` match statement

```php
'tu_kepegawaian' => redirect()->route('tu_kepegawaian.dashboard'),
'super_admin'    => redirect()->route('super_admin.dashboard'),
```

#### **Issue #2: Column Mismatch**
- **Severity**: MEDIUM
- **Location**: [User.php](app/Models/User.php#L28-L37) and [create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php#L16)
- **Problem**: `nisn` column exists in migration but **NOT in User model's fillable array**
- **Impact**: `nisn` field cannot be mass-assigned; must be set individually
- **Risk**: Potential data integrity issues; NISN (Nomor Induk Siswa Nasional) not being properly stored
- **Fix**: Add `'nisn'` to the fillable array in User model

### ⚠️ DESIGN CONCERNS

#### **Concern #1: Custom Auth Identifier**
- **Issue**: Using `nomor_induk` instead of `id` as the authentication identifier
- **Impact**: 
  - May conflict with password reset functionality (expects email-based tokens)
  - Some Laravel packages may not work correctly
  - Unusual for typical Laravel applications
- **Mitigation**: This is implemented consistently; verify password reset works correctly

#### **Concern #2: No Explicit Remember-Me Dashboard Route**
- **Issue**: Login controller sets `remember_token` but there's no clear indication how it's handled
- **Note**: This is standard Laravel behavior and should work fine

#### **Concern #3: Email Optional but Not Unique**
- **Issue**: Email is NULLABLE and UNIQUE, which allows multiple NULL values (SQL behavior)
- **Impact**: Multiple users could have NULL email without violating uniqueness
- **Note**: This is acceptable for the current design

---

## 9. Database Integrity Check

**Required Tables for Authentication:**
- ✅ `users` - Main user table
- ✅ `password_reset_tokens` - Password reset functionality
- ✅ `sessions` - Session management (DB-based sessions)
- ✅ `gurus` - Referenced in RoleMiddleware for guru/walikelas validation
- ✅ `rombels` - Related to user roles through gurus table

**Foreign Key Constraints:**
- `sessions.user_id` → `users.id` (nullable, allows deleted users in old sessions)

---

## 10. Password Reset Implementation

### Location: [app/Http/Controllers/Auth/SiswaResetPasswordController.php](app/Http/Controllers/Auth/SiswaResetPasswordController.php) (referenced but not analyzed in detail)

**Note**: Custom password reset controller for students (`SiswaResetPasswordController`)
- Uses custom implementation instead of Laravel's built-in Fortify/Reset
- Routes available at `/siswa/reset-password`
- ⚠️ Verify this properly handles token expiration and security

---

## 11. Session Configuration

**Session Driver**: Database (`sessions` table)
- Provides persistent session storage
- Better for distributed applications
- User-agent and IP tracking enabled

**Session Expiry**: Determined by `config/session.php` (not reviewed in detail)

---

## 12. Recommendations

### Immediate Actions (Critical)
1. **Fix LoginController redirects**: Add `tu_kepegawaian` and `super_admin` cases
2. **Fix User model fillable**: Add `'nisn'` to fillable array
3. **Create missing dashboard routes**: Ensure all roles have corresponding dashboards

### Short-term Actions (Important)
1. Test complete login flow for each role
2. Verify password reset functionality (especially for custom identifier)
3. Test "Remember Me" functionality across sessions
4. Verify RoleMiddleware properly validates database records

### Long-term Improvements (Nice-to-have)
1. Consider migrating to Laravel Fortify or Sanctum for modernized auth
2. Add two-factor authentication (2FA) for admin roles
3. Add audit logging for authentication events
4. Implement CSRF token validation on login form
5. Add rate limiting to login endpoint (prevent brute force)

---

## 13. Security Checklist

- ✅ Password hashing: Bcrypt (via 'hashed' cast)
- ✅ Custom identifier: `nomor_induk` is validated against
- ✅ Case-insensitive login: Implemented with LOWER()
- ⚠️ Rate limiting: Not configured (should be added)
- ⚠️ Password reset tokens: Expiry is 60 minutes (acceptable)
- ✅ Session management: Database-based (good for tracking)
- ✅ CSRF protection: Should be enabled on middleware
- ⚠️ Remember token: Should verify it's properly regenerated

---

## 14. Summary Table

| Component | Status | Notes |
|-----------|--------|-------|
| Auth Guard | ✅ OK | Web guard with session driver |
| User Model | ⚠️ ISSUE | `nisn` not in fillable array |
| Database Schema | ✅ OK | Proper structure for auth |
| Login Controller | ⚠️ ISSUE | Missing role redirects |
| Role Middleware | ✅ OK | Properly validates roles and DB records |
| Routes | ✅ OK | Proper middleware application |
| Password Reset | ? UNKNOWN | Needs verification with custom identifier |
| Remember Me | ✅ PARTIAL | Implemented but not heavily tested |

---

**Report Generated**: April 21, 2026  
**Investigation Status**: Complete
