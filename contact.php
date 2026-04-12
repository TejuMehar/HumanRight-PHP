<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Contact — ' . SITE_NAME;

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name'] ?? '');
    $email   = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (!$name || !$email || !$message) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        $db->contacts->insertOne([
            'name'       => $name,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
            'read'       => false,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);
        $success = 'Your message has been sent. We\'ll be in touch soon.';
    }
}

include __DIR__ . '/includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="bg-navy text-white py-14 px-5 sm:px-8">
  <div class="max-w-6xl mx-auto">
    <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">Contact</p>
    <h1 class="font-serif text-4xl sm:text-5xl font-semibold leading-tight mb-3">
      We read every message.
    </h1>
    <p class="text-white/55 text-base max-w-xl">
      Whether you need legal help, want to partner with us, or just have a question — reach out. There's a real person on the other end. We usually reply within 48 hours.
    </p>
  </div>
</section>

<!-- WHAT PEOPLE CONTACT US ABOUT -->
<div class="bg-white border-b border-gray-200 py-5 px-5 sm:px-8">
  <div class="max-w-6xl mx-auto flex flex-wrap items-center gap-2">
    <span class="text-xs font-semibold text-gray-400 mr-1">People contact us about:</span>
    <?php foreach (['Legal aid requests','Research partnerships','Funding & grants','Volunteering','Media enquiries','Speaking invitations','General questions'] as $type): ?>
    <span class="bg-slate border border-gray-200 text-gray-600 text-xs px-3 py-1.5 rounded"><?= $type ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- CONTACT CONTENT -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-5 gap-12">

    <!-- Info -->
    <div class="lg:col-span-2 space-y-8 sr-l">
      <div>
        <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-ink mb-3">Get in touch</h2>
        <p class="text-gray-600 text-sm leading-relaxed">
          Fill in the form or email us directly. If you're in an urgent situation involving a rights violation, please say so in your message and we'll prioritise your case.
        </p>
      </div>

      <div class="space-y-5">
        <?php foreach ([
          ['fa-envelope',     'Email',        ADMIN_EMAIL,                                  'mailto:'.ADMIN_EMAIL],
          ['fa-linkedin',     'LinkedIn',     'Connect on LinkedIn',                         '#'],
          ['fa-location-dot', 'Where we work','Offices in Nairobi, London & Bogotá',         null],
        ] as [$icon,$label,$val,$url]): ?>
        <div class="flex items-start gap-4">
          <div class="w-9 h-9 bg-slate border border-gray-200 rounded flex items-center justify-center flex-shrink-0">
            <i class="fa-solid <?= $icon ?> text-navy text-sm"></i>
          </div>
          <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-0.5"><?= $label ?></p>
            <?php if ($url): ?>
              <a href="<?= $url ?>" class="text-ink text-sm font-semibold hover:text-blue transition-colors"><?= $val ?></a>
            <?php else: ?>
              <p class="text-ink text-sm font-semibold"><?= $val ?></p>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="bg-slate border border-gray-200 rounded-lg p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">We work on</p>
        <div class="flex flex-wrap gap-2">
          <?php foreach (['Gender Justice','Governance','Economic Rights','Refugee Rights','Civic Freedoms','Land Rights'] as $tag): ?>
          <span class="bg-white border border-gray-200 text-gray-600 text-xs px-3 py-1.5 rounded"><?= $tag ?></span>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Form -->
    <div class="lg:col-span-3 sr-r">
      <div class="bg-slate border border-gray-200 rounded-lg p-7 sm:p-8">

        <?php if ($success): ?>
          <div class="bg-blue/8 border border-blue/20 text-blue px-4 py-3 rounded mb-5 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> <?= $success ?>
          </div>
        <?php endif; ?>
        <?php if ($error): ?>
          <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded mb-5 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
          </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                Full Name <span class="text-red-500">*</span>
              </label>
              <input type="text" name="name" value="<?= sanitize($_POST['name'] ?? '') ?>" required
                class="w-full bg-white border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue transition">
            </div>
            <div>
              <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                Email <span class="text-red-500">*</span>
              </label>
              <input type="email" name="email" value="<?= sanitize($_POST['email'] ?? '') ?>" required
                class="w-full bg-white border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue transition">
            </div>
          </div>
          <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Subject</label>
            <input type="text" name="subject" value="<?= sanitize($_POST['subject'] ?? '') ?>"
              placeholder="e.g. Legal aid request, Research partnership..."
              class="w-full bg-white border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue transition">
          </div>
          <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
              Message <span class="text-red-500">*</span>
            </label>
            <textarea name="message" rows="6" required
              placeholder="Tell us what you need or how you'd like to work together..."
              class="w-full bg-white border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/20 focus:border-blue resize-none transition"><?= sanitize($_POST['message'] ?? '') ?></textarea>
          </div>
          <button type="submit"
            class="w-full bg-navy text-white font-semibold py-3.5 rounded hover:bg-blue transition-colors text-sm">
            Send Message
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
