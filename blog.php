<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Insights — ' . SITE_NAME;

$search   = sanitize($_GET['search'] ?? '');
$category = sanitize($_GET['category'] ?? '');
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = 9;
$skip     = ($page - 1) * $perPage;

$filter = ['published' => true];
if ($search)   $filter['title']    = ['$regex' => $search, '$options' => 'i'];
if ($category) $filter['category'] = $category;

$total      = $db->blogs->countDocuments($filter);
$blogs      = $db->blogs->find($filter, ['sort' => ['created_at' => -1], 'limit' => $perPage, 'skip' => $skip])->toArray();
$categories = $db->blogs->distinct('category', ['published' => true]);
$pages      = (int)ceil($total / $perPage);
$featured   = (!$search && !$category && $page === 1 && !empty($blogs)) ? array_shift($blogs) : null;

include __DIR__ . '/includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="bg-navy text-white py-14 px-5 sm:px-8">
  <div class="max-w-6xl mx-auto">
    <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">Research & Insights</p>
    <h1 class="font-serif text-4xl sm:text-5xl font-semibold leading-tight">
      Field reports, analysis,<br>and policy research.
    </h1>
  </div>
</section>

<!-- FILTER BAR -->
<div class="bg-white border-b border-gray-200 sticky top-16 z-30">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 py-3">
    <form method="GET" class="flex flex-wrap items-center gap-2">
      <div class="relative">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" name="search" value="<?= $search ?>" placeholder="Search articles..."
          class="pl-8 pr-4 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue w-48 sm:w-56">
      </div>
      <div class="flex flex-wrap gap-1.5">
        <a href="<?= SITE_URL ?>/blog" class="px-3 py-1.5 rounded text-xs font-semibold transition <?= !$category ? 'bg-navy text-white' : 'bg-slate text-gray-600 hover:bg-gray-200 border border-gray-200' ?>">All</a>
        <?php foreach ($categories as $cat): ?>
        <a href="?category=<?= urlencode($cat) ?><?= $search ? '&search='.urlencode($search) : '' ?>"
          class="px-3 py-1.5 rounded text-xs font-semibold transition <?= $category === $cat ? 'bg-navy text-white' : 'bg-slate text-gray-600 hover:bg-gray-200 border border-gray-200' ?>">
          <?= sanitize($cat) ?>
        </a>
        <?php endforeach; ?>
      </div>
      <?php if ($search): ?>
        <button class="bg-navy text-white px-4 py-1.5 rounded text-xs font-semibold hover:bg-blue transition">Search</button>
        <a href="<?= SITE_URL ?>/blog<?= $category ? '?category='.urlencode($category) : '' ?>" class="text-gray-400 hover:text-gray-600 text-xs font-semibold">✕ Clear</a>
      <?php endif; ?>
    </form>
  </div>
</div>

<div class="max-w-6xl mx-auto px-5 sm:px-8 py-12">

  <?php if (empty($blogs) && !$featured): ?>
    <div class="text-center py-20">
      <p class="font-serif text-2xl text-ink mb-2">No articles found.</p>
      <a href="<?= SITE_URL ?>/blog" class="text-blue text-sm font-semibold hover:underline">Clear filters</a>
    </div>

  <?php else: ?>

    <!-- FEATURED -->
    <?php if ($featured): ?>
    <article class="group grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-14 pb-14 border-b border-gray-200 sr">
      <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($featured['slug']) ?>"
        class="block rounded-lg overflow-hidden aspect-[16/10] bg-slate border border-gray-200">
        <?php if (!empty($featured['image'])): ?>
          <img src="<?= SITE_URL ?>/assets/images/<?= sanitize($featured['image']) ?>"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            alt="<?= sanitize($featured['title']) ?>">
        <?php else: ?>
          <div class="w-full h-full flex items-center justify-center bg-slate">
            <i class="fa-solid fa-newspaper text-4xl text-gray-300"></i>
          </div>
        <?php endif; ?>
      </a>
      <div>
        <div class="flex items-center gap-3 mb-3">
          <span class="text-blue text-xs font-semibold"><?= sanitize($featured['category'] ?? 'General') ?></span>
          <span class="bg-red text-white text-[10px] font-semibold px-2 py-0.5 rounded">Featured</span>
        </div>
        <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-ink leading-tight mb-3 group-hover:text-blue transition-colors">
          <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($featured['slug']) ?>"><?= sanitize($featured['title']) ?></a>
        </h2>
        <p class="text-gray-600 leading-relaxed text-sm mb-5"><?= sanitize(substr($featured['excerpt'] ?? '', 0, 200)) ?>...</p>
        <div class="flex items-center justify-between">
          <span class="text-gray-400 text-sm"><?= date('F d, Y', $featured['created_at']->toDateTime()->getTimestamp()) ?></span>
          <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($featured['slug']) ?>"
            class="bg-navy text-white text-sm font-semibold px-5 py-2.5 rounded hover:bg-blue transition-colors">
            Read article →
          </a>
        </div>
      </div>
    </article>
    <?php endif; ?>

    <!-- GRID -->
    <?php if (!empty($blogs)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($blogs as $i=>$blog): ?>
      <article class="group flex flex-col border border-gray-200 rounded-lg overflow-hidden card-hover sr" style="transition-delay:<?= ($i%3)*60 ?>ms">
        <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>"
          class="block aspect-[16/10] bg-slate overflow-hidden flex-shrink-0">
          <?php if (!empty($blog['image'])): ?>
            <img src="<?= SITE_URL ?>/assets/images/<?= sanitize($blog['image']) ?>"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              alt="<?= sanitize($blog['title']) ?>" loading="lazy">
          <?php else: ?>
            <div class="w-full h-full flex items-center justify-center bg-slate">
              <i class="fa-solid fa-newspaper text-3xl text-gray-300"></i>
            </div>
          <?php endif; ?>
        </a>
        <div class="p-5 flex flex-col flex-1 bg-white">
          <div class="flex items-center gap-2 mb-2">
            <a href="?category=<?= urlencode($blog['category'] ?? '') ?>" class="text-blue text-xs font-semibold hover:underline">
              <?= sanitize($blog['category'] ?? 'General') ?>
            </a>
            <span class="text-gray-400 text-xs">· <?= date('M d, Y', $blog['created_at']->toDateTime()->getTimestamp()) ?></span>
          </div>
          <h2 class="font-serif text-lg font-semibold text-ink leading-snug mb-2 group-hover:text-blue transition-colors flex-1">
            <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>"><?= sanitize($blog['title']) ?></a>
          </h2>
          <p class="text-gray-500 text-sm leading-relaxed mb-4"><?= sanitize(substr($blog['excerpt'] ?? '', 0, 100)) ?>...</p>
          <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>"
            class="text-blue text-sm font-semibold hover:underline mt-auto">Read →</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- PAGINATION -->
    <?php if ($pages > 1): ?>
    <div class="flex justify-center items-center gap-2 mt-12">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>"
          class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-600 hover:border-navy hover:text-navy transition">← Prev</a>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $pages; $i++): ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>"
          class="w-9 h-9 flex items-center justify-center rounded text-sm font-semibold transition <?= $i === $page ? 'bg-navy text-white' : 'border border-gray-300 text-gray-600 hover:border-navy hover:text-navy' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>
      <?php if ($page < $pages): ?>
        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>"
          class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-600 hover:border-navy hover:text-navy transition">Next →</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
