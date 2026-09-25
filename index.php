<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>معهد الدلتا العالي لنظم المعلومات الإدارية والمحاسبية بالمنصورة</title>
<link rel="icon" href="https://www.dhic.edu.eg/layout/images/logo.png">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        delta: {
          50:'#f0f9ff',100:'#e0f2fe',200:'#bae6fd',300:'#7dd3fc',400:'#38bdf8',
          500:'#0284c7',600:'#0369a1',700:'#075985',800:'#0c4a6e',900:'#0a324d'
        }
      },
      fontFamily: { cairo: ['Cairo','sans-serif'] }
    }
  }
}
</script>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between selection:bg-delta-200">

<header class="bg-white border-b border-delta-100 shadow-sm sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 py-3">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-4 cursor-pointer" onclick="app.switchTab('home')">
        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-md border border-delta-100 overflow-hidden">
          <img src="https://www.dhic.edu.eg/layout/images/logo.png" alt="شعار المعهد" class="w-full h-full object-contain p-1">
        </div>
        <div>
          <h1 class="text-base sm:text-xl font-black text-delta-900 leading-tight">معهد الدلتا العالي</h1>
          <p class="text-xs sm:text-sm font-semibold text-delta-600">لنظم المعلومات الإدارية والمحاسبية بالمنصورة</p>
        </div>
      </div>

      <div id="main-nav-tabs" class="hidden sm:flex items-center gap-1.5 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 text-xs font-bold">
        <button onclick="app.switchTab('home')" id="nav-tab-home" class="px-3.5 py-2 rounded-xl transition"><i class="fa-solid fa-house ml-1.5"></i> الرئيسية والمواد</button>
        <button onclick="app.switchTab('announcements')" id="nav-tab-announcements" class="px-3.5 py-2 rounded-xl transition"><i class="fa-solid fa-bullhorn ml-1.5"></i> الإعلانات</button>
        <button onclick="app.switchTab('direct_messages')" id="nav-tab-direct_messages" class="px-3.5 py-2 rounded-xl transition"><i class="fa-solid fa-paper-plane ml-1.5"></i> تواصل دكتور</button>
        <button onclick="app.switchTab('admin_panel')" id="nav-tab-admin" class="hidden px-3.5 py-2 rounded-xl transition text-amber-700 hover:bg-amber-50"><i class="fa-solid fa-user-shield ml-1.5"></i> الإدارة الفائقة</button>
      </div>

      <div class="flex items-center gap-2.5 w-full lg:w-auto justify-end">
        <!-- 🔔 جرس الإشعارات -->
        <div id="notif-bell" class="relative hidden">
          <button onclick="app.toggleNotifPanel()" class="relative w-10 h-10 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center transition">
            <i class="fa-solid fa-bell text-lg"></i>
            <span id="notif-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
          </button>

          <!-- 📋 لوحة الإشعارات -->
          <div id="notif-panel" class="hidden absolute left-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 max-h-[500px] overflow-hidden flex flex-col">
            <div class="p-4 border-b border-slate-200 flex items-center justify-between bg-gradient-to-l from-delta-600 to-delta-700 text-white rounded-t-2xl">
              <h3 class="font-black text-sm"><i class="fa-solid fa-bell ml-1"></i> الإشعارات</h3>
              <button onclick="app.markAllNotifRead()" class="text-[10px] bg-white/20 hover:bg-white/30 px-2 py-1 rounded-lg font-bold transition">تعليم الكل كمقروء</button>
            </div>
            <div id="notif-list" class="overflow-y-auto custom-scrollbar flex-grow"></div>
          </div>
        </div>

        <div id="nav-user-container"></div>
      </div>
    </div>

    <div class="sm:hidden flex items-center justify-around mt-3 pt-2 border-t border-slate-100 text-[11px] font-bold">
      <button onclick="app.switchTab('home')" id="mob-tab-home" class="py-1.5 px-2 rounded-lg"><i class="fa-solid fa-house"></i> المواد</button>
      <button onclick="app.switchTab('announcements')" id="mob-tab-announcements" class="py-1.5 px-2 rounded-lg"><i class="fa-solid fa-bullhorn"></i> الإعلانات</button>
      <button onclick="app.switchTab('direct_messages')" id="mob-tab-direct_messages" class="py-1.5 px-2 rounded-lg"><i class="fa-solid fa-paper-plane"></i> تواصل</button>
      <button onclick="app.switchTab('admin_panel')" id="mob-tab-admin" class="hidden py-1.5 px-2 rounded-lg text-amber-700"><i class="fa-solid fa-user-shield"></i> الإدارة</button>
    </div>
  </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full">
  <div id="welcome-banner" class="mb-6 bg-gradient-to-r from-delta-800 via-delta-700 to-sky-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
    <div class="absolute -left-10 -bottom-10 opacity-10 pointer-events-none"><i class="fa-solid fa-university text-[220px]"></i></div>
    <div class="relative z-10 max-w-3xl flex flex-col md:flex-row md:items-center gap-6">
      <div class="w-24 h-24 bg-white rounded-2xl p-2 shadow-xl flex-shrink-0">
        <img src="https://www.dhic.edu.eg/layout/images/logo.png" alt="شعار المعهد" class="w-full h-full object-contain">
      </div>
      <div>
        <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">منظومة التواصل والأكاديميا الرسمية 🎓</span>
        <h2 class="text-xl sm:text-3xl font-extrabold mb-2 mt-2">أهلاً بك في منصة معهد الدلتا العالي بالمنصورة</h2>
        <p class="text-delta-100 text-xs sm:text-sm">تواصل مباشر بين الطلاب وأعضاء هيئة التدريس، ومتابعة المحاضرات والإعلانات أولاً بأول.</p>
      </div>
    </div>
  </div>
  <div id="main-view" class="transition-all duration-300 min-h-[50vh]"></div>
</main>

<footer class="bg-white border-t border-delta-100 mt-12 py-8 text-slate-600">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-delta-50/70 border border-delta-100 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-2 text-delta-800 font-bold">
          <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm"><i class="fa-brands fa-facebook-f"></i></div>
          <span class="text-sm">إدارة الدعم الأكاديمي</span>
        </div>
        <p class="text-xs text-slate-500 mb-4">معهد الدلتا العالي نظم للحاسبات بالمنصورة - التواصل المباشر</p>
        <a href="https://www.facebook.com/share/g/1MKBprx4Xu/" target="_blank" class="inline-flex items-center justify-center gap-2 bg-delta-600 hover:bg-delta-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl"><span>اضغط هنا</span><i class="fa-solid fa-arrow-left text-[10px]"></i></a>
      </div>
      <div class="bg-delta-50/70 border border-delta-100 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-2 text-delta-800 font-bold">
          <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm"><i class="fa-brands fa-facebook-f"></i></div>
          <span class="text-sm">شئون ورعاية الطلاب</span>
        </div>
        <p class="text-xs text-slate-500 mb-4">شئون ورعاية الطلاب - الدلتا نظم المعلومات الإدارية والمحاسبية</p>
        <a href="https://www.facebook.com/share/g/1CELDTqVbf/" target="_blank" class="inline-flex items-center justify-center gap-2 bg-delta-600 hover:bg-delta-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl"><span>اضغط هنا</span><i class="fa-solid fa-arrow-left text-[10px]"></i></a>
      </div>
    </div>
    <div class="flex items-center justify-center gap-3 mb-3">
      <img src="https://www.dhic.edu.eg/layout/images/logo.png" alt="الشعار" class="h-10">
      <span class="text-xs font-bold text-delta-800">معهد الدلتا العالي</span>
    </div>
    <div class="border-t border-slate-100 pt-4 text-center text-xs text-slate-400">جميع الحقوق محفوظة &copy; 2026 معهد الدلتا العالي</div>
  </div>
</footer>

<!-- Auth Modal -->
<div id="auth-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-delta-100 relative my-8 max-h-[90vh] overflow-y-auto custom-scrollbar">
    <button onclick="app.closeAuthModal()" class="absolute top-5 left-5 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
    <div class="text-center mb-5">
      <div class="w-16 h-16 bg-white rounded-2xl mx-auto flex items-center justify-center mb-3 shadow-md border border-delta-100 overflow-hidden">
        <img src="https://www.dhic.edu.eg/layout/images/logo.png" class="w-full h-full object-contain p-1">
      </div>
      <h3 class="text-xl font-black text-slate-800">بوابة الدخول للمنظومة</h3>
      <p class="text-xs text-slate-500 mt-1">سجل دخولك أو أنشئ حساباً جديداً</p>
    </div>
    <div class="grid grid-cols-2 gap-1 bg-slate-100 p-1 rounded-2xl mb-5">
      <button type="button" onclick="app.setAuthMode('login')" id="mode-tab-login" class="py-2 text-xs font-bold rounded-xl transition">تسجيل الدخول</button>
      <button type="button" onclick="app.setAuthMode('signup')" id="mode-tab-signup" class="py-2 text-xs font-bold rounded-xl transition">إنشاء حساب جديد ✨</button>
    </div>
    <div id="role-selector-tabs" class="grid grid-cols-3 gap-1 bg-slate-100 p-1.5 rounded-2xl mb-5">
      <button type="button" onclick="app.setAuthRole('student')" id="role-tab-student" class="py-2 text-xs font-bold rounded-xl transition">👨‍🎓 طالب</button>
      <button type="button" onclick="app.setAuthRole('doctor')" id="role-tab-doctor" class="py-2 text-xs font-bold rounded-xl transition">👨‍🏫 دكتور</button>
      <button type="button" onclick="app.setAuthRole('staff')" id="role-tab-staff" class="py-2 text-xs font-bold rounded-xl transition">👔 شئون ورعاية</button>
    </div>
    <form onsubmit="app.handleAuthSubmit(event)" class="space-y-3.5">
      <div id="field-name-container" class="hidden">
        <label class="block text-xs font-bold text-slate-700 mb-1">الاسم الكامل</label>
        <input type="text" id="auth-name" placeholder="أدخل اسمك" class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-delta-500 focus:outline-none">
      </div>
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">البريد الإلكتروني</label>
        <input type="email" id="auth-email" required placeholder="example@delta.edu.eg" class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-delta-500 focus:outline-none">
      </div>
      <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">كلمة المرور</label>
        <input type="password" id="auth-password" required placeholder="••••••••" class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-delta-500 focus:outline-none">
      </div>
      <div id="field-division-container" class="hidden">
        <label class="block text-xs font-bold text-slate-700 mb-1">الفرقة الدراسية</label>
        <select id="auth-division" class="w-full px-3 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-delta-500 focus:outline-none font-semibold">
          <option value="div-1">الفرقة الأولى</option>
          <option value="div-2">الفرقة الثانية</option>
          <option value="div-3-mis">الفرقة الثالثة (نظم)</option>
          <option value="div-3-acc">الفرقة الثالثة (محاسبة)</option>
          <option value="div-4-mis">الفرقة الرابعة (نظم)</option>
          <option value="div-4-acc">الفرقة الرابعة (محاسبة)</option>
        </select>
      </div>
      <div id="auth-error" class="hidden text-xs text-red-600 bg-red-50 p-2.5 rounded-xl border border-red-100 font-semibold"></div>
      <button type="submit" id="auth-submit-btn" class="w-full bg-delta-600 hover:bg-delta-700 text-white font-bold py-3 rounded-xl shadow-md text-xs">تسجيل الدخول</button>
    </form>
  </div>
</div>

<!-- Generic Modal -->
<div id="generic-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-delta-100 relative max-h-[90vh] overflow-y-auto custom-scrollbar">
    <button onclick="app.closeGenericModal()" class="absolute top-5 left-5 text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
    <div id="generic-modal-body"></div>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all pointer-events-none">
  <div class="bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 border border-slate-700">
    <i id="toast-icon" class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
    <span id="toast-message" class="text-xs font-bold"></span>
  </div>
</div>

<script src="assets/js/app.js"></script>
</body>
</html>
