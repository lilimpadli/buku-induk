# AI Coding Guidelines for Buku Induk School Management System

## Project Overview
This is a Laravel 12 application for Indonesian school management ("buku-induk" = student ledger). It manages student records, grades, attendance, and report cards with role-based access for students, teachers, and administrators.

## Architecture & Key Components

### Core Models & Relationships
- **DataSiswa**: Central student model with relationships to parents (Ayah/Ibu/Wali), Rombel (class), and academic records
- **NilaiRaport**: Grade records linked to MataPelajaran (subjects) and DataSiswa
- **User**: Authentication model using `nomor_induk` (not email) as login identifier
- **Rombel**: Class groupings with Jurusan (majors) and Kelas (grade levels)

### Role-Based Access Control
Routes use role middleware with prefixes:
- `siswa.*` - Student access
- `walikelas.*` - Class teacher access  
- `kaprog.*` - Program head access
- `tu.*` - Administrative staff access
- `kurikulum.*` - Curriculum access

### Controller Patterns
Controllers follow consistent patterns:
```php
private function getSiswaLogin() {
    $user = Auth::user();
    return DataSiswa::where('nis', $user->nomor_induk)->first();
}
```
Always load relationships: `$siswa->load(['ayah', 'ibu', 'wali', 'nilaiRaports.mapel'])`

## Critical Workflows

### PDF Report Generation
Uses `barryvdh/laravel-dompdf` for rapor (report cards):
```php
use Barryvdh\DomPDF\Facade\Pdf;
$pdf = Pdf::loadView('siswa.raport-pdf', compact('siswa', 'nilaiRaports'));
return $pdf->download('raport.pdf');
```

### Authentication Flow
- Login via `nomor_induk` field
- Dashboard redirects based on `Auth::user()->role`
- Role middleware: `middleware('role:walikelas')`

### Grade Management
- NilaiRaport stores semester/year-specific grades
- Linked to MataPelajaran and DataSiswa
- Includes deskripsi (descriptive feedback)

## Development Commands

### Build & Assets
```bash
npm run dev      # Vite dev server with hot reload
npm run build    # Production build
```

### Database
```bash
php artisan migrate
php artisan db:seed
php artisan tinker
```

### Testing
```bash
php artisan test
vendor/bin/phpunit
```

## Project-Specific Conventions

### Model Relationships
Always use explicit foreign key names:
```php
public function nilaiRaports() {
    return $this->hasMany(NilaiRaport::class, 'siswa_id');
}
```

### Route Organization
Routes grouped by role with prefixes and middleware:
```php
Route::prefix('walikelas')
    ->name('walikelas.')
    ->middleware('role:walikelas')
    ->group(function () {
        // routes here
    });
```

### View Naming
Views follow controller prefixes: `siswa/data-diri.blade.php`, `walikelas/dashboard.blade.php`

### Data Validation
Use Indonesian field names in forms but English in database columns

## Common Integration Points

### External Dependencies
- **PDF Generation**: barryvdh/laravel-dompdf for report exports
- **Database**: doctrine/dbal for schema operations
- **Frontend**: TailwindCSS via Vite for styling

### File Storage
Student photos stored in `storage/app/public/foto_siswa/` with symlinked access

### API Patterns
No REST API - all server-side rendered with Blade templates and form submissions

## Key Files to Reference

### Configuration
- `config/auth.php` - Custom auth identifier (`nomor_induk`)
- `routes/web.php` - Role-based routing structure
- `vite.config.js` - Asset compilation setup

### Models
- `app/Models/DataSiswa.php` - Central student model
- `app/Models/NilaiRaport.php` - Grade records
- `app/Models/User.php` - Authentication with custom identifier

### Controllers
- `app/Http/Controllers/SiswaController.php` - Student dashboard/data management
- `app/Http/Controllers/RaporController.php` - Report card generation

### Middleware
- `app/Http/Middleware/RoleMiddleware.php` - Role-based access control

## Testing Approach
- Feature tests for role-based access flows
- Unit tests for model relationships
- Use database transactions for test isolation
- Test PDF generation with mock data

## Deployment Notes
- Ensure `storage:link` for photo access
- Configure PDF font support for Indonesian characters
- Set up role-based user creation workflows</content>
<parameter name="filePath">c:\INOVINDO\buku-induk\.github\copilot-instructions.md