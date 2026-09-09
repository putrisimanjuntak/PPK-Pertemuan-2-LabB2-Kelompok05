<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>JARA Advance To-Do List</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  <!-- SRS-001: Header Semantik -->
  <header class="app-header">
    <div class="logo-area">
      <h1>JARA To-Do List</h1>
    </div>
    <nav class="nav-area">
      <span class="badge-role">Workspace Programmer A</span>
    </nav>
  </header>

  <!-- SRS-001: Main Semantik dengan Form & List Task -->
  <main class="app-main">
    
    <!-- Area Form Tambah Tugas -->
    <section class="card form-panel">
      <h2>Tambah Tugas Baru</h2>
      <form id="taskForm" novalidate>
        
        <!-- SRS-004: Judul & Error Real-time -->
        <div class="form-group">
          <label for="taskTitle">Judul Tugas *</label>
          <input type="text" id="taskTitle" placeholder="Ketik minimal 3 karakter...">
          <span class="error-msg" id="titleError"></span>
        </div>

        <!-- SRS-003: Dropdown Proyek (Min 3 Opsi + Tambah Dinamis) -->
        <div class="form-group">
          <label for="taskProject">Proyek / Daftar *</label>
          <div class="input-inline-btn">
            <select id="taskProject">
              @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
              @endforeach
            </select>
            <button type="button" id="btnAddProject" class="btn-secondary" title="Tambah Proyek Baru">+ Proyek</button>
          </div>
        </div>

        <div class="form-row">
          <!-- SRS-004: 3 Opsi Prioritas -->
          <div class="form-group">
            <label for="taskPriority">Prioritas</label>
            <select id="taskPriority">
              <option value="low">Rendah</option>
              <option value="medium" selected>Sedang</option>
              <option value="high">Tinggi</option>
            </select>
          </div>

          <!-- SRS-004: Tenggat Waktu & Error Real-time -->
          <div class="form-group">
            <label for="taskDeadline">Tenggat Waktu</label>
            <input type="date" id="taskDeadline">
            <span class="error-msg" id="deadlineError"></span>
          </div>
        </div>

        <button type="submit" class="btn-primary" id="btnSubmit">Tambah Tugas</button>
      </form>
    </section>

    <!-- Area Daftar Tugas -->
    <section class="card list-panel">
      <div class="list-toolbar">
        <h2>Daftar Tugas</h2>
        
        <!-- SRS-005: Filter (Semua / Belum Selesai / Selesai) -->
        <div class="filter-wrapper">
          <button type="button" class="filter-tab active" data-filter="all">Semua</button>
          <button type="button" class="filter-tab" data-filter="pending">Belum Selesai</button>
          <button type="button" class="filter-tab" data-filter="completed">Selesai</button>
        </div>
      </div>

      <!-- Wadah Item Tugas -->
      <div id="taskListContainer" class="task-container"></div>
    </section>

  </main>

  <!-- SRS-001: Footer Semantik -->
  <footer class="app-footer">
    <p>&copy; 2026 JARA Advance To-Do List &bull; Programmer A</p>
  </footer>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>