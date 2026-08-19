<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student ID Studio Pro | Salvacion NHS</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                        },
                        dark: {
                            bg: '#0a0a0a',
                            card: '#161615',
                            border: '#2e2e2b',
                            hover: '#262624'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
            color: #ededec;
        }
        /* Custom Scrollbar for Student List */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }
        ::-webkit-scrollbar-thumb {
            background: #2e2e2b;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #40403c;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-dark-bg text-[#EDEDEC] antialiased">

    <!-- Top Navigation Bar -->
    <header class="w-full border-b border-dark-border bg-dark-card/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-brand-600 flex items-center justify-center font-bold text-white shadow-lg shadow-brand-600/30">
                    SN
                </div>
                <div>
                    <h1 class="text-sm font-semibold tracking-wide flex items-center gap-2">
                        Salvacion National High School
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-500 border border-brand-500/20">
                            Studio Pro
                        </span>
                    </h1>
                    <p class="text-xs text-[#A1A09A]">Automated Student ID Generation System</p>
                </div>
            </div>

            <div class="flex items-center gap-3 text-sm">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 border border-dark-border hover:border-brand-500/50 rounded-lg text-xs font-medium transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-dark-border hover:border-brand-500/50 rounded-lg text-xs font-medium transition-all">
                            Log in
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Main Studio Split View -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8 flex flex-col lg:flex-row gap-6">

        <!-- Left Control Panel (Directory & Search) -->
        <section class="w-full lg:w-5/12 bg-dark-card border border-dark-border rounded-2xl p-5 flex flex-col gap-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-dark-border">
                <h2 class="text-sm font-semibold text-white tracking-wide">Student Directory</h2>
                <span id="recordCount" class="text-xs text-[#A1A09A]">0 Records</span>
            </div>

            <!-- Filter Controls -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2 relative">
                    <input type="text" id="searchInput" placeholder="Search name or LRN..." 
                        class="w-full pl-9 pr-4 py-2 bg-dark-bg border border-dark-border rounded-xl text-xs text-white placeholder-[#706f6c] focus:outline-none focus:border-brand-500 transition-colors">
                    <svg class="w-4 h-4 absolute left-3 top-2.5 text-[#706f6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <select id="gradeFilter" class="w-full px-3 py-2 bg-dark-bg border border-dark-border rounded-xl text-xs text-white focus:outline-none focus:border-brand-500 transition-colors">
                    <option value="">All Grades</option>
                    <option value="7">Grade 7</option>
                    <option value="8">Grade 8</option>
                    <option value="9">Grade 9</option>
                    <option value="10">Grade 10</option>
                    <option value="11">Grade 11</option>
                    <option value="12">Grade 12</option>
                </select>
            </div>

            <!-- Scrollable Student Records List -->
            <div id="studentList" class="flex-1 min-h-[300px] max-h-[420px] overflow-y-auto flex flex-col gap-2 pr-1">
                <div class="flex flex-col items-center justify-center h-full py-12 text-center text-[#706f6c]">
                    <svg class="w-8 h-8 mb-2 animate-spin text-brand-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-xs">Fetching database from Google Sheets...</p>
                </div>
            </div>

            <!-- Selected Student Summary Card -->
            <div id="selectedStudentCard" class="mt-auto border border-dark-border bg-dark-bg rounded-xl p-3.5 hidden">
                <div class="flex items-center gap-3">
                    <img id="summaryPhoto" src="{{ asset('images/ID-Temp.png') }}" class="w-10 h-10 rounded-full object-cover border border-dark-border bg-dark-card" alt="Student Photo">
                    <div class="overflow-hidden flex-1">
                        <h4 id="summaryName" class="text-xs font-semibold text-white truncate">Select a Student</h4>
                        <p id="summaryDetails" class="text-[11px] text-[#A1A09A]">LRN: - | Grade -</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Right Preview & Rendering Canvas Panel -->
        <section class="w-full lg:w-7/12 bg-dark-card border border-dark-border rounded-2xl p-5 flex flex-col items-center justify-between shadow-xl min-h-[550px] relative">
            <div class="w-full flex items-center justify-between pb-3 border-b border-dark-border mb-4">
                <h2 class="text-sm font-semibold text-white tracking-wide">Live Canvas Preview</h2>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs text-[#A1A09A]">Ready</span>
                </div>
            </div>

            <!-- Scalable ID Card Canvas Container -->
            <div class="flex-1 w-full flex items-center justify-center p-2 relative min-h-[400px]">
                <div id="canvasWrapper" class="relative max-w-[340px] w-full aspect-[638/1011] bg-dark-bg rounded-xl border border-dark-border shadow-2xl overflow-hidden flex items-center justify-center">
                    
                    <!-- Empty State Placeholder -->
                    <div id="emptyCanvasState" class="flex flex-col items-center justify-center p-6 text-center text-[#706f6c]">
                        <svg class="w-12 h-12 mb-3 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs font-medium">No Student Selected</p>
                        <p class="text-[11px] mt-1 text-[#52524e]">Click any student record on the left panel to render their official ID card.</p>
                    </div>

                    <!-- Hidden HTML5 Canvas where drawing happens -->
                    <canvas id="idCanvas" width="638" height="1011" class="hidden w-full h-full object-contain rounded-lg"></canvas>
                </div>
            </div>

            <!-- Control Action Buttons -->
            <div class="w-full pt-4 border-t border-dark-border flex items-center justify-end gap-3 mt-4">
                <button id="downloadBtn" disabled 
                    class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 disabled:opacity-40 disabled:hover:bg-brand-600 text-white rounded-xl text-xs font-semibold transition-all shadow-lg shadow-brand-600/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Digital ID (.PNG)
                </button>
            </div>
        </section>

    </main>

    <!-- App State & Canvas Renderer Engine Script -->
<script>
    const API_URL = "/api/students";
    const TEMPLATE_SRC = "{{ asset('images/ID-Temp.png') }}";

    let allStudents = [];
    let selectedStudent = null;
    let templateImage = new Image();
    let isTemplateLoaded = false;

    // Load ID Background Template
    templateImage.src = TEMPLATE_SRC;
    templateImage.onload = () => { 
        isTemplateLoaded = true; 
        if (selectedStudent) {
            drawCanvas(selectedStudent);
        }
    };
    templateImage.onerror = () => { 
        console.warn("ID Template failed to load from: " + TEMPLATE_SRC); 
    };

    document.addEventListener('DOMContentLoaded', () => {
        fetchStudentData();
        document.getElementById('searchInput').addEventListener('input', filterStudents);
        document.getElementById('gradeFilter').addEventListener('change', filterStudents);
        document.getElementById('downloadBtn').addEventListener('click', downloadIDCard);
    });

    // Flexible helper to read keys regardless of Google Sheet column header casing
    function getField(obj, possibleKeys, fallback = '') {
        if (!obj) return fallback;
        for (let key of possibleKeys) {
            const foundKey = Object.keys(obj).find(k => k.trim().toLowerCase() === key.toLowerCase());
            if (foundKey && obj[foundKey] !== undefined && obj[foundKey] !== null && obj[foundKey] !== '') {
                return String(obj[foundKey]).trim();
            }
        }
        return fallback;
    }

    // Standardized Student Data Extractor
    function parseStudent(student) {
        const firstName = getField(student, ['firstName', 'first_name', 'first name', 'given name']);
        const lastName = getField(student, ['lastName', 'last_name', 'last name', 'surname']);
        
        let fullName = getField(student, ['name', 'full name', 'fullname', 'student name']);
        if (!fullName && (firstName || lastName)) {
            fullName = `${firstName} ${lastName}`.trim();
        }

        return {
            raw: student,
            name: fullName || 'UNKNOWN NAME',
            lrn: getField(student, ['lrn', 'lrn #', 'learner reference number', 'id', 'student id'], 'N/A'),
            grade: getField(student, ['grade', 'grade level', 'gradelevel', 'year level'], 'N/A'),
            section: getField(student, ['section', 'track', 'strand'], ''),
            photoUrl: getField(student, ['photoUrl', 'photo url', 'photo', 'image', 'picture', 'avatar'])
        };
    }

    // Fetch Records from Proxy API
    async function fetchStudentData() {
        const listContainer = document.getElementById('studentList');
        try {
            const response = await fetch(API_URL);
            const data = await response.json();
            
            const rawList = Array.isArray(data) ? data : (data.students || data.data || []);
            allStudents = rawList.map(parseStudent);
            
            document.getElementById('recordCount').textContent = `${allStudents.length} Records`;
            renderStudentList(allStudents);
        } catch (error) {
            console.error("API Error:", error);
            listContainer.innerHTML = `
                <div class="py-8 text-center text-rose-500 text-xs">
                    Failed to fetch student database.
                </div>
            `;
        }
    }

    // Render Student List in Sidebar
    function renderStudentList(students) {
        const listContainer = document.getElementById('studentList');
        listContainer.innerHTML = '';

        if (students.length === 0) {
            listContainer.innerHTML = `<p class="text-xs text-[#706f6c] text-center py-8">No matching records found.</p>`;
            return;
        }

        students.forEach((student) => {
            const card = document.createElement('div');
            card.className = `p-3 rounded-xl border border-dark-border bg-dark-bg hover:bg-dark-hover hover:border-brand-500/30 cursor-pointer transition-all flex items-center justify-between group`;
            
            card.innerHTML = `
                <div class="overflow-hidden pr-2">
                    <h3 class="text-xs font-medium text-white group-hover:text-brand-500 transition-colors truncate">${student.name}</h3>
                    <p class="text-[11px] text-[#A1A09A]">LRN: ${student.lrn} • Gr. ${student.grade} ${student.section}</p>
                </div>
                <svg class="w-4 h-4 text-[#706f6c] group-hover:text-brand-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            `;

            card.addEventListener('click', () => selectStudent(student, card));
            listContainer.appendChild(card);
        });
    }

    // Filter Logic
    function filterStudents() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const selectedGrade = document.getElementById('gradeFilter').value;

        const filtered = allStudents.filter(student => {
            const matchesQuery = student.name.toLowerCase().includes(query) || student.lrn.toLowerCase().includes(query);
            const matchesGrade = selectedGrade === '' || String(student.grade) === String(selectedGrade);
            return matchesQuery && matchesGrade;
        });

        renderStudentList(filtered);
    }

    // Select Student and Render
    function selectStudent(student, cardElement) {
        selectedStudent = student;

        document.querySelectorAll('#studentList > div').forEach(el => el.classList.remove('border-brand-500', 'bg-dark-hover'));
        if (cardElement) cardElement.classList.add('border-brand-500', 'bg-dark-hover');

        document.getElementById('summaryName').textContent = student.name;
        document.getElementById('summaryDetails').textContent = `LRN: ${student.lrn} | Grade ${student.grade}`;
        document.getElementById('selectedStudentCard').classList.remove('hidden');

        drawCanvas(student);
    }

    // Convert Google Drive Links to Direct Image URLs
    function formatDriveUrl(url) {
        if (!url) return '';
        if (url.includes('drive.google.com')) {
            const idMatch = url.match(/[-\w]{25,}/);
            if (idMatch) return `https://lh3.googleusercontent.com/d/${idMatch[0]}`;
        }
        return url;
    }

    // Canvas Rendering Engine
    function drawCanvas(student) {
        const canvas = document.getElementById('idCanvas');
        const ctx = canvas.getContext('2d');
        const emptyState = document.getElementById('emptyCanvasState');
        const downloadBtn = document.getElementById('downloadBtn');

        emptyState.classList.add('hidden');
        canvas.classList.remove('hidden');

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // 1. Draw Background Template
        if (isTemplateLoaded) {
            ctx.drawImage(templateImage, 0, 0, canvas.width, canvas.height);
        } else {
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        // 2. Draw Photo & Text
        const photoUrl = formatDriveUrl(student.photoUrl);
        if (photoUrl) {
            const photoImg = new Image();
            photoImg.crossOrigin = "anonymous";
            photoImg.src = photoUrl;

            photoImg.onload = () => {
                renderPhotoAndText(ctx, canvas, photoImg, student);
                downloadBtn.disabled = false;
            };

            photoImg.onerror = () => {
                renderPhotoAndText(ctx, canvas, null, student);
                downloadBtn.disabled = false;
            };
        } else {
            renderPhotoAndText(ctx, canvas, null, student);
            downloadBtn.disabled = false;
        }
    }

    function renderPhotoAndText(ctx, canvas, photoImg, student) {
        if (photoImg) {
            const photoX = 194; 
            const photoY = 220;
            const photoWidth = 250;
            const photoHeight = 250;

            ctx.save();
            ctx.beginPath();
            ctx.rect(photoX, photoY, photoWidth, photoHeight);
            ctx.clip();
            ctx.drawImage(photoImg, photoX, photoY, photoWidth, photoHeight);
            ctx.restore();
        }

        drawTextOverlay(ctx, student);
    }

    // Typography Overlay
    function drawTextOverlay(ctx, student) {
        const width = ctx.canvas.width;
        const name = student.name.toUpperCase();
        const lrn = student.lrn;
        const gradeSection = `GRADE ${student.grade} - ${student.section}`.toUpperCase();

        ctx.textAlign = 'center';

        // Student Name
        ctx.fillStyle = '#0a0a0a';
        ctx.font = 'bold 30px "Inter", sans-serif';
        ctx.fillText(name, width / 2, 530);

        // Grade & Section
        ctx.fillStyle = '#be123c';
        ctx.font = '600 25px "Inter", sans-serif';
        ctx.fillText(gradeSection, width / 2, 670);

        // LRN
        ctx.fillStyle = '#262626';
        ctx.font = '500 20px "Inter", sans-serif';
        ctx.fillText(`LRN: ${lrn}`, width / 2, 605);
    }

    // Export Canvas Image
    function downloadIDCard() {
        if (!selectedStudent) return;
        const canvas = document.getElementById('idCanvas');
        const link = document.createElement('a');
        link.download = `SNHS_ID_${selectedStudent.lrn}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
</script>
</body>
</html>