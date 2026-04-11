<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'Admin — ' . SITE_NAME ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  #sidebar { transition: transform 0.25s ease; }
  @media (max-width: 1023px) {
    #sidebar { transform: translateX(-100%); }
    #sidebar.open { transform: translateX(0); }
  }
</style>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-blue-900 text-white flex flex-col h-screen fixed top-0 left-0 z-30 overflow-y-auto">
  <div class="px-6 py-5 border-b border-blue-800 flex items-center justify-between">
    <div>
      <p class="text-xs text-blue-300 uppercase tracking-widest">Admin Panel</p>
      <p class="font-bold text-base mt-0.5 leading-tight"><?= SITE_NAME ?></p>
    </div>
    <button onclick="closeSidebar()" class="lg:hidden text-blue-300 hover:text-white p-1">
      <i class="fa-solid fa-xmark text-lg"></i>
    </button>
  </div>
  <nav class="flex-1 px-4 py-4 space-y-0.5 text-sm">
    <?php
    $current = basename($_SERVER['PHP_SELF']);
    $dir     = basename(dirname($_SERVER['PHP_SELF']));
    function navLink(string $href, string $icon, string $label, bool $active, string $badge = ''): string {
        $cls = $active ? 'bg-blue-700' : 'hover:bg-blue-800';
        $b   = $badge ? "<span class=\"ml-auto bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full\">{$badge}</span>" : '';
        return "<a href=\"$href\" class=\"flex items-center gap-3 px-4 py-2.5 rounded-lg $cls transition\" onclick=\"closeSidebar()\">
          <i class=\"fa-solid $icon w-4 text-center\"></i> $label $b</a>";
    }
    function navGroup(string $label): string {
        return "<p class=\"text-xs text-blue-400 uppercase tracking-widest px-4 pt-4 pb-1\">{$label}</p>";
    }

    $unreadCount = '';
    try {
        global $db;
        $uc = $db->contacts->countDocuments(['read' => false]);
        if ($uc > 0) $unreadCount = (string)$uc;
        $pendingComments = $db->comments->countDocuments(['approved' => false]);
        $pendingBadge = $pendingComments > 0 ? (string)$pendingComments : '';
    } catch(Exception $e) { $pendingBadge = ''; }

    echo navGroup('Main');
    echo navLink(SITE_URL.'/admin/',                   'fa-gauge',        'Dashboard',   $current==='index.php' && $dir==='admin');
    echo navGroup('Content');
    echo navLink(SITE_URL.'/admin/blogs/',             'fa-newspaper',    'Blogs',       $dir==='blogs');
    echo navLink(SITE_URL.'/admin/categories/',        'fa-tags',         'Categories',  $dir==='categories');
    echo navLink(SITE_URL.'/admin/comments/',          'fa-comments',     'Comments',    $dir==='comments', $pendingBadge);
    echo navLink(SITE_URL.'/admin/events/',            'fa-calendar-star','Events',      $dir==='events');
    echo navGroup('People');
    echo navLink(SITE_URL.'/admin/users/',             'fa-users',        'Users',       $dir==='users');
    echo navLink(SITE_URL.'/admin/admins/',            'fa-user-shield',  'Admins',      $dir==='admins');
    echo navGroup('Communication');
    echo navLink(SITE_URL.'/admin/messages/',          'fa-envelope',     'Messages',    $dir==='messages', $unreadCount);
    echo navGroup('System');
    echo navLink(SITE_URL.'/admin/activity/',          'fa-clock-rotate-left', 'Activity Log', $dir==='activity');
    echo navLink(SITE_URL.'/admin/settings/',          'fa-gear',         'Settings',    $dir==='settings');
    ?>
  </nav>
  <div class="px-4 py-4 border-t border-blue-800 space-y-1">
    <a href="<?= SITE_URL ?>/" target="_blank" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 transition text-sm text-blue-300">
      <i class="fa-solid fa-arrow-up-right-from-square w-4"></i> View Website
    </a>
    <a href="<?= SITE_URL ?>/admin/logout" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-red-700 transition text-sm">
      <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
    </a>
  </div>
</aside>

<!-- Main Wrapper -->
<div class="lg:ml-64 flex flex-col min-h-screen">

<!-- Top Header -->
<header class="bg-white shadow px-4 sm:px-6 py-3 flex items-center justify-between sticky top-0 z-20 gap-3">
  <!-- Hamburger + Title -->
  <div class="flex items-center gap-3 min-w-0">
    <button onclick="openSidebar()" class="lg:hidden text-gray-500 hover:text-blue-700 p-1 flex-shrink-0">
      <i class="fa-solid fa-bars text-xl"></i>
    </button>
    <h1 class="text-base sm:text-lg font-bold text-gray-700 truncate"><?= $pageTitle ?? 'Dashboard' ?></h1>
  </div>

  <div class="flex items-center gap-3 flex-shrink-0">
    <!-- Bell Notification -->
    <a href="<?= SITE_URL ?>/admin/messages/" class="relative text-gray-400 hover:text-blue-700">
      <i class="fa-solid fa-bell text-xl"></i>
      <?php if (!empty($unreadCount)): ?>
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 rounded-full flex items-center justify-center"><?= $unreadCount ?></span>
      <?php endif; ?>
    </a>

    <!-- Admin Profile Dropdown -->
    <?php
      $adminData = $db->admins->findOne(['_id' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])]);
    ?>
    <div class="relative" id="adminDropdownWrap">
      <button id="adminDropdownBtn"
        class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-2.5 py-1.5 rounded-xl transition focus:outline-none">
        <?php if (!empty($adminData['photo'])): ?>
          <img src="<?= sanitize($adminData['photo']) ?>" class="w-8 h-8 rounded-full object-cover border-2 border-blue-300 flex-shrink-0">
        <?php else: ?>
          <div class="w-8 h-8 rounded-full bg-blue-700 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
            <?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?>
          </div>
        <?php endif; ?>
        <div class="text-left hidden sm:block">
          <p class="text-sm font-semibold text-gray-700 leading-tight"><?= sanitize($_SESSION['admin_username'] ?? 'Admin') ?></p>
          <p class="text-xs text-gray-400 leading-tight">Administrator</p>
        </div>
        <i class="fa-solid fa-chevron-down text-xs text-gray-400 ml-1 hidden sm:block"></i>
      </button>

      <!-- Dropdown Menu -->
      <div id="adminDropdownMenu"
        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">
        <div class="px-5 py-4 bg-blue-50 border-b border-gray-100 flex items-center gap-3">
          <?php if (!empty($adminData['photo'])): ?>
            <img src="<?= sanitize($adminData['photo']) ?>" class="w-12 h-12 rounded-full object-cover border-2 border-blue-200 flex-shrink-0">
          <?php else: ?>
            <div class="w-12 h-12 rounded-full bg-blue-700 text-white flex items-center justify-center text-xl font-bold flex-shrink-0">
              <?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?>
            </div>
          <?php endif; ?>
          <div class="min-w-0">
            <p class="font-bold text-gray-800 text-sm truncate"><?= sanitize($_SESSION['admin_username'] ?? 'Admin') ?></p>
            <p class="text-xs text-gray-400 truncate"><?= sanitize($adminData['email'] ?? '') ?></p>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-semibold mt-0.5 inline-block">Administrator</span>
          </div>
        </div>
        <div class="py-2">
          <a href="<?= SITE_URL ?>/admin/profile" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
            <i class="fa-solid fa-user w-4 text-blue-500"></i> My Profile
          </a>
          <a href="<?= SITE_URL ?>/admin/settings/" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
            <i class="fa-solid fa-gear w-4 text-gray-400"></i> Settings
          </a>
          <a href="<?= SITE_URL ?>/admin/admins/" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
            <i class="fa-solid fa-user-shield w-4 text-purple-500"></i> Manage Admins
          </a>
          <a href="<?= SITE_URL ?>/" target="_blank" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
            <i class="fa-solid fa-arrow-up-right-from-square w-4 text-green-500"></i> View Website
          </a>
          <a href="<?= SITE_URL ?>/admin/activity/" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
            <i class="fa-solid fa-clock-rotate-left w-4 text-yellow-500"></i> Activity Log
          </a>
        </div>
        <div class="border-t border-gray-100 py-2">
          <a href="<?= SITE_URL ?>/admin/logout" class="flex items-center gap-3 px-5 py-2.5 text-sm text-red-600 hover:bg-red-50 transition font-semibold">
            <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</header>

<main class="flex-1 p-4 sm:p-6 lg:p-8">

<script>
  function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.remove('hidden');
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.add('hidden');
  }
  const btn  = document.getElementById('adminDropdownBtn');
  const menu = document.getElementById('adminDropdownMenu');
  btn.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });
  document.addEventListener('click', () => menu.classList.add('hidden'));
  menu.addEventListener('click', (e) => e.stopPropagation());
</script>
