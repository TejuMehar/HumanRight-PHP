<?php
require_once __DIR__ . '/includes/init.php';

$slug = sanitize($_GET['slug'] ?? '');
if (!$slug) { header('Location: ' . SITE_URL . '/blog'); exit; }

$blog = $db->blogs->findOne(['slug' => $slug, 'published' => true]);
if (!$blog) { header('Location: ' . SITE_URL . '/blog'); exit; }

$blogId = (string)$blog['_id'];
$pageTitle = sanitize($blog['title']) . ' — ' . SITE_NAME;

$commentError = $commentSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isLoggedIn()) {
    $body = trim($_POST['comment'] ?? '');
    if (strlen($body) < 3) {
        $commentError = 'Comment is too short.';
    } else {
        $db->comments->insertOne([
            'blog_id'    => $blogId,
            'user_id'    => $_SESSION['user_id'],
            'username'   => $_SESSION['username'],
            'body'       => htmlspecialchars($body, ENT_QUOTES, 'UTF-8'),
            'approved'   => false,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);
        $commentSuccess = 'Comment submitted and awaiting approval.';
    }
}

$comments = $db->comments->find(['blog_id' => $blogId, 'approved' => true], ['sort' => ['created_at' => -1]])->toArray();
$related  = $db->blogs->find(['published' => true, 'category' => $blog['category'] ?? '', '_id' => ['$ne' => $blog['_id']]], ['sort' => ['created_at' => -1], 'limit' => 3])->toArray();
$readTime = max(1, (int)(str_word_count(strip_tags($blog['content'])) / 200));

include __DIR__ . '/includes/header.php';
?>

<!-- ARTICLE HEADER -->
<div class="bg-slate border-b border-gray-200 reveal">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
      <a href="<?= SITE_URL ?>/" class="hover:text-blue transition-colors">Home</a>
      <span>/</span>
      <a href="<?= SITE_URL ?>/blog" class="hover:text-blue transition-colors">Insights</a>
      <span>/</span>
      <span class="text-gray-600 truncate max-w-[200px]"><?= sanitize($blog['title']) ?></span>
    </nav>

    <!-- Meta -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
      <a href="<?= SITE_URL ?>/blog?category=<?= urlencode($blog['category'] ?? '') ?>"
        class="text-blue text-xs font-semibold hover:underline"><?= sanitize($blog['category'] ?? 'General') ?></a>
      <span class="text-gray-300">·</span>
      <span class="text-gray-500 text-sm"><?= date('F d, Y', $blog['created_at']->toDateTime()->getTimestamp()) ?></span>
      <span class="text-gray-300">·</span>
      <span class="text-gray-500 text-sm"><?= $readTime ?> min read</span>
    </div>

    <!-- Title -->
    <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-semibold text-ink leading-tight mb-5 max-w-4xl">
      <?= sanitize($blog['title']) ?>
    </h1>

    <?php if (!empty($blog['excerpt'])): ?>
    <p class="text-gray-600 text-lg leading-relaxed border-l-4 border-blue pl-4 max-w-2xl">
      <?= sanitize($blog['excerpt']) ?>
    </p>
    <?php endif; ?>
  </div>
</div>

<!-- FEATURED IMAGE -->
<?php if (!empty($blog['image'])): ?>
<div class="max-w-6xl mx-auto px-5 sm:px-8 py-8 reveal">
  <img src="<?= SITE_URL ?>/assets/images/<?= sanitize($blog['image']) ?>"
    class="w-full rounded-lg object-cover max-h-[480px] border border-gray-200"
    alt="<?= sanitize($blog['title']) ?>">
</div>
<?php endif; ?>

<!-- BODY + SIDEBAR -->
<div class="max-w-6xl mx-auto px-5 sm:px-8 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_240px] gap-10 lg:gap-12 items-start">

    <!-- Article body -->
    <div>
      <div class="prose-body"><?= $blog['content'] ?></div>

      <!-- Tags + Share -->
      <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
          <span class="text-xs text-gray-400 font-semibold">Category:</span>
          <a href="<?= SITE_URL ?>/blog?category=<?= urlencode($blog['category'] ?? '') ?>"
            class="text-blue text-xs font-semibold hover:underline"><?= sanitize($blog['category'] ?? 'General') ?></a>
        </div>
        <div class="flex items-center gap-2">
          <span class="text-xs text-gray-400 font-semibold">Share:</span>
          <?php foreach ([
            ['fa-twitter',  'https://twitter.com/intent/tweet?text='.urlencode($blog['title']).'&url='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
            ['fa-linkedin', 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
            ['fa-facebook', 'https://www.facebook.com/sharer/sharer.php?u='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
          ] as [$icon,$url]): ?>
          <a href="<?= $url ?>" target="_blank" rel="noopener"
            class="w-8 h-8 border border-gray-300 rounded flex items-center justify-center text-gray-500 hover:bg-navy hover:text-white hover:border-navy transition text-xs">
            <i class="fa-brands <?= $icon ?>"></i>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="hidden lg:block space-y-5 sticky top-24">
      <div class="bg-slate border border-gray-200 rounded-lg p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Article Info</p>
        <div class="space-y-3 text-sm text-gray-600">
          <div class="flex items-center gap-2">
            <i class="fa-regular fa-calendar text-blue w-4 text-xs"></i>
            <span><?= date('F d, Y', $blog['created_at']->toDateTime()->getTimestamp()) ?></span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-regular fa-clock text-blue w-4 text-xs"></i>
            <span><?= $readTime ?> min read</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-tag text-blue w-4 text-xs"></i>
            <a href="<?= SITE_URL ?>/blog?category=<?= urlencode($blog['category'] ?? '') ?>" class="text-blue hover:underline"><?= sanitize($blog['category'] ?? 'General') ?></a>
          </div>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-comments text-blue w-4 text-xs"></i>
            <span><?= count($comments) ?> comment<?= count($comments) !== 1 ? 's' : '' ?></span>
          </div>
        </div>
      </div>

      <div class="bg-slate border border-gray-200 rounded-lg p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Share</p>
        <div class="flex gap-2">
          <?php foreach ([
            ['fa-twitter',  'https://twitter.com/intent/tweet?text='.urlencode($blog['title']).'&url='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
            ['fa-linkedin', 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
            ['fa-facebook', 'https://www.facebook.com/sharer/sharer.php?u='.urlencode(SITE_URL.'/single-blog?slug='.$blog['slug'])],
          ] as [$icon,$url]): ?>
          <a href="<?= $url ?>" target="_blank" rel="noopener"
            class="flex-1 flex items-center justify-center py-2 border border-gray-300 rounded text-gray-500 hover:bg-navy hover:text-white hover:border-navy transition text-xs">
            <i class="fa-brands <?= $icon ?>"></i>
          </a>
          <?php endforeach; ?>
        </div>
      </div>

      <a href="<?= SITE_URL ?>/blog" class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue transition font-medium">
        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Insights
      </a>
    </aside>
  </div>
</div>


<!-- RELATED -->
<?php if (!empty($related)): ?>
<section class="bg-slate border-t border-gray-200 py-14 px-5 sm:px-8 reveal">
  <div class="max-w-6xl mx-auto">
    <h2 class="font-serif text-2xl font-semibold text-ink mb-8">Related Articles</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($related as $r): ?>
      <article class="group bg-white border border-gray-200 rounded-lg overflow-hidden card-hover">
        <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($r['slug']) ?>" class="block aspect-[16/9] bg-slate overflow-hidden">
          <?php if (!empty($r['image'])): ?>
            <img src="<?= SITE_URL ?>/assets/images/<?= sanitize($r['image']) ?>"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              alt="<?= sanitize($r['title']) ?>" loading="lazy">
          <?php else: ?>
            <div class="w-full h-full flex items-center justify-center bg-slate">
              <i class="fa-solid fa-newspaper text-3xl text-gray-300"></i>
            </div>
          <?php endif; ?>
        </a>
        <div class="p-5">
          <span class="text-blue text-xs font-semibold"><?= sanitize($r['category'] ?? 'General') ?></span>
          <h3 class="font-serif text-lg font-semibold text-ink mt-1 mb-2 leading-snug group-hover:text-blue transition-colors">
            <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($r['slug']) ?>"><?= sanitize($r['title']) ?></a>
          </h3>
          <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($r['slug']) ?>" class="text-blue text-xs font-semibold hover:underline">Read →</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>


<!-- COMMENTS -->
<section class="py-14 px-5 sm:px-8 bg-white border-t border-gray-200 reveal">
  <div class="max-w-3xl mx-auto">
    <h2 class="font-serif text-2xl font-semibold text-ink mb-8">
      Comments <span class="text-gray-400 font-sans font-normal text-base">(<?= count($comments) ?>)</span>
    </h2>

    <?php if ($commentSuccess): ?>
      <div class="bg-blue/8 border border-blue/20 text-blue px-4 py-3 rounded mb-5 text-sm"><?= $commentSuccess ?></div>
    <?php endif; ?>
    <?php if ($commentError): ?>
      <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-5 text-sm"><?= $commentError ?></div>
    <?php endif; ?>

    <?php if (isLoggedIn()): ?>
    <form method="POST" class="mb-10 bg-slate border border-gray-200 rounded-lg p-5">
      <p class="text-sm font-semibold text-ink mb-3">Leave a comment</p>
      <textarea name="comment" rows="4" placeholder="Share your thoughts..."
        class="w-full border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue resize-none bg-white"></textarea>
      <div class="flex items-center justify-between mt-3">
        <p class="text-xs text-gray-400">Reviewed before publishing.</p>
        <button class="bg-navy text-white px-5 py-2 rounded text-sm font-semibold hover:bg-blue transition-colors">Post Comment</button>
      </div>
    </form>
    <?php else: ?>
    <div class="bg-slate border border-gray-200 rounded-lg p-5 mb-10 text-center">
      <p class="text-gray-500 text-sm">
        <a href="<?= SITE_URL ?>/auth/login" class="text-blue font-semibold hover:underline">Sign in</a> to leave a comment.
      </p>
    </div>
    <?php endif; ?>

    <?php if (empty($comments)): ?>
      <p class="text-gray-400 text-sm text-center py-8">No comments yet.</p>
    <?php else: ?>
    <div class="space-y-4">
      <?php foreach ($comments as $c): ?>
      <div class="flex gap-4">
        <div class="w-9 h-9 rounded-full bg-navy text-white flex items-center justify-center font-semibold text-sm flex-shrink-0 mt-0.5">
          <?= strtoupper(substr($c['username'], 0, 1)) ?>
        </div>
        <div class="flex-1 bg-slate border border-gray-200 rounded-lg px-4 py-3">
          <div class="flex items-center gap-3 mb-1">
            <p class="font-semibold text-ink text-sm"><?= sanitize($c['username']) ?></p>
            <p class="text-gray-400 text-xs"><?= date('M d, Y', $c['created_at']->toDateTime()->getTimestamp()) ?></p>
          </div>
          <p class="text-gray-600 text-sm leading-relaxed"><?= $c['body'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
