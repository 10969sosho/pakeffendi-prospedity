# AGENTS.md — SOP Kerja AI untuk Project PROSPEDITY

## Cara Bekerja

1. **Baca dokumentasi dulu** sebelum membuat perubahan apapun.
   - Urutan: `PROJECT_CONTEXT.md` → `ARCHITECTURE.md` → `BUSINESS_RULES.md` → `CODING_STANDARDS.md` → `DATABASE.md` → `API_REFERENCE.md` → `CHANGELOG.md`
   - Jika tidak ada dokumentasi, tanya user sebelum membuat asumsi.

2. **Jangan pernah membuat pola baru** yang tidak ada di dokumentasi.
   - Jika dokumentasi menyebut "Service Layer Minimal", jangan buat Repository Pattern.
   - Jika dokumentasi menyebut "Pure server-side rendering", jangan usul API endpoint.
   - Ikuti arsitektur yang sudah ada.

3. **Batasan Perubahan**
   - Jangan ubah struktur folder tanpa konfirmasi.
   - Jangan tambah dependency tanpa diskusi.
   - Jangan ubah mekanisme auth / middleware tanpa alasan jelas.
   - Jangan refactor code yang tidak terkait task.

4. **Sebelum nulis kode**, pahami dulu:
   - Model apa yang terlibat?
   - Migration sudah ada atau perlu baru?
   - Controller apa yang perlu diubah?
   - Route sudah ada?
   - View yang mana?
   - Business rules apa yang berlaku?

5. **Workflow Analisa**
   - Ada masalah → cek dokumentasi → cek kode terkait → usul solusi → konfirmasi → implementasi
   - Jika ada konflik antara kode dan dokumentasi, tanya user.
   - Jika ada business rule yang tidak tercatat di dokumentasi, catat dan tanya user.

6. **Laravel Specific Rules**
   - Gunakan `$fillable` bukan `$guarded`.
   - Gunakan route model binding via `getRouteKeyName()`.
   - Boot events (`creating`, `updating`) untuk auto-generate fields.
   - View composer untuk data global, bukan query di view.

7. **Update Dokumentasi**
   - Jika membuat fitur baru yang signifikan, update docs/ yang relevan.
   - Catat keputusan penting di `CHANGELOG.md`.
   - Update `AGENTS.md` hanya jika SOP kerja berubah.

8. **Komunikasi**
   - Jawab dalam bahasa yang sama dengan user.
   - Jika arahan user tidak jelas, tanya — jangan asumsi.
   - Jika perubahan bersifat besar, breakdown dan tanya dulu.
