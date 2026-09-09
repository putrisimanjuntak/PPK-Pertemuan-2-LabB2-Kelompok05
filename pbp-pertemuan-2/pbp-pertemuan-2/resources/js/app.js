document.addEventListener("DOMContentLoaded", () => {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";

  const STORAGE_KEY = "jara_advance_tasks";
  let tasks = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  let currentFilter = "all";

  const taskForm = document.getElementById("taskForm");
  const taskTitle = document.getElementById("taskTitle");
  const taskProject = document.getElementById("taskProject");
  const taskPriority = document.getElementById("taskPriority");
  const taskDeadline = document.getElementById("taskDeadline");
  const titleError = document.getElementById("titleError");
  const deadlineError = document.getElementById("deadlineError");
  const taskListContainer = document.getElementById("taskListContainer");
  const btnAddProject = document.getElementById("btnAddProject");
  const filterTabs = document.querySelectorAll(".filter-tab");

  const priorityLabels = { low: "Rendah", medium: "Sedang", high: "Tinggi" };

  // Persistensi ke LocalStorage (SRS-003 & SRS-005)
  function saveToLocalStorage() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(tasks));
  }

  // Helper API Fetch
  async function apiFetch(url, method = "GET", body = null) {
    try {
      const options = {
        method,
        headers: {
          "X-CSRF-TOKEN": csrfToken,
          "Accept": "application/json",
          "Content-Type": "application/json"
        }
      };
      if (body) options.body = JSON.stringify(body);
      const res = await fetch(url, options);
      return await res.json();
    } catch (e) {
      return null;
    }
  }

  // SRS-004: Validasi Real-time Judul
  function validateTitle() {
    const val = taskTitle.value.trim();
    if (!val) {
      titleError.textContent = "Judul tugas tidak boleh kosong.";
      return false;
    }
    if (val.length < 3) {
      titleError.textContent = "Judul tugas minimal 3 karakter.";
      return false;
    }
    titleError.textContent = "";
    return true;
  }

  // SRS-004: Validasi Real-time Tenggat Waktu
  function validateDeadline() {
    const val = taskDeadline.value;
    if (!val) {
      deadlineError.textContent = "";
      return true;
    }
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const [y, m, d] = val.split("-").map(Number);
    const selected = new Date(y, m - 1, d);

    if (selected < today) {
      deadlineError.textContent = "Tenggat waktu tidak boleh tanggal yang sudah lewat.";
      return false;
    }
    deadlineError.textContent = "";
    return true;
  }

  taskTitle.addEventListener("input", validateTitle);
  taskDeadline.addEventListener("change", validateDeadline);

  // SRS-003: Tambah Proyek Dinamis
  if (btnAddProject) {
    btnAddProject.addEventListener("click", async () => {
      const name = prompt("Masukkan nama proyek / daftar baru:");
      if (name && name.trim()) {
        const cleanName = name.trim();
        const res = await apiFetch("/api/projects", "POST", { name: cleanName });
        const opt = document.createElement("option");
        opt.value = res && res.id ? res.id : cleanName;
        opt.textContent = cleanName;
        taskProject.appendChild(opt);
        taskProject.value = opt.value;
      }
    });
  }

  // SRS-003 & SRS-005: Render DOM via createElement murni
  function renderTasks() {
    taskListContainer.innerHTML = "";

    const filtered = tasks.filter((t) => {
      const isDone = (t.status === "done" || t.isCompleted === true);
      if (currentFilter === "completed") return isDone;
      if (currentFilter === "pending") return !isDone;
      return true;
    });

    if (filtered.length === 0) {
      const empty = document.createElement("p");
      empty.textContent = "Belum ada tugas pada kategori ini.";
      empty.style.textAlign = "center";
      empty.style.color = "var(--text-muted)";
      empty.style.padding = "1.5rem 0";
      taskListContainer.appendChild(empty);
      return;
    }

    filtered.forEach((task) => {
      const item = document.createElement("div");
      item.className = "task-item";

      const left = document.createElement("div");
      left.className = "task-left";

      // SRS-005: Checkbox Toggle Status
      const isDone = (task.status === "done" || task.isCompleted === true);
      const checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.className = "task-checkbox";
      checkbox.checked = isDone;
      checkbox.addEventListener("change", async () => {
        const newStatus = checkbox.checked ? "done" : "todo";
        task.status = newStatus;
        task.isCompleted = checkbox.checked;
        saveToLocalStorage(); // Sinkronisasi local
        renderTasks();

        if (task.id && typeof task.id === "number") {
          await apiFetch(`/api/tasks/${task.id}/toggle`, "PATCH");
        }
      });

      // SRS-005: Efek Teks Coret (Strikethrough)
      const titleSpan = document.createElement("span");
      titleSpan.className = `task-title ${isDone ? "completed" : ""}`;
      titleSpan.textContent = task.title;

      left.appendChild(checkbox);
      left.appendChild(titleSpan);

      const right = document.createElement("div");
      right.className = "task-right";

      // Badge Proyek
      const projBadge = document.createElement("span");
      projBadge.className = "badge badge-proj";
      projBadge.textContent = task.project ? (task.project.name || task.project) : "Umum";

      // SRS-004: Indikator Warna Prioritas
      const prioVal = task.priority || "medium";
      const prioBadge = document.createElement("span");
      prioBadge.className = `badge badge-prio-${prioVal}`;
      prioBadge.textContent = priorityLabels[prioVal] || prioVal;

      right.appendChild(projBadge);
      right.appendChild(prioBadge);

      const dateVal = task.due_date || task.deadline;
      if (dateVal) {
        const dateSpan = document.createElement("span");
        dateSpan.className = "task-date";
        dateSpan.textContent = dateVal;
        right.appendChild(dateSpan);
      }

      // Tombol Hapus
      const btnDel = document.createElement("button");
      btnDel.type = "button";
      btnDel.className = "btn-delete";
      btnDel.textContent = "×";
      btnDel.addEventListener("click", async () => {
        tasks = tasks.filter((t) => t.id !== task.id);
        saveToLocalStorage();
        renderTasks();

        if (task.id && typeof task.id === "number") {
          await apiFetch(`/api/tasks/${task.id}`, "DELETE");
        }
      });

      right.appendChild(btnDel);

      item.appendChild(left);
      item.appendChild(right);
      taskListContainer.appendChild(item);
    });
  }

  // SRS-003: Tambah Tugas Baru
  taskForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!validateTitle() || !validateDeadline()) return;

    const selectedOption = taskProject.options[taskProject.selectedIndex];
    const projectText = selectedOption ? selectedOption.text : "Umum";

    const payload = {
      title: taskTitle.value.trim(),
      project_id: taskProject.value,
      priority: taskPriority.value,
      due_date: taskDeadline.value || null
    };

    const res = await apiFetch("/api/tasks", "POST", payload);

    const newTask = (res && res.id) ? res : {
      id: "local_" + Date.now(),
      title: payload.title,
      project: { name: projectText },
      priority: payload.priority,
      due_date: payload.due_date,
      status: "todo",
      isCompleted: false
    };

    tasks.unshift(newTask);
    saveToLocalStorage();
    renderTasks();

    taskTitle.value = "";
    taskDeadline.value = "";
    taskPriority.value = "medium";
  });

  // SRS-005: Event Filter Tampilan
  filterTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      filterTabs.forEach((t) => t.classList.remove("active"));
      tab.classList.add("active");
      currentFilter = tab.getAttribute("data-filter");
      renderTasks();
    });
  });

  // Inisialisasi Data (Database + LocalStorage)
  async function init() {
    const dbTasks = await apiFetch("/api/tasks");
    if (Array.isArray(dbTasks) && dbTasks.length > 0) {
      tasks = dbTasks;
      saveToLocalStorage();
    }
    renderTasks();
  }

  init();
});