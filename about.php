<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'About Us — ' . SITE_NAME;
include __DIR__ . '/includes/header.php';
?>

<!-- PAGE HEADER -->
<section class="bg-navy text-white py-16 px-5 sm:px-8">
  <div class="max-w-6xl mx-auto">
    <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">About Us</p>
    <h1 class="font-serif text-4xl sm:text-5xl font-semibold leading-tight mb-4">
      We started with one case.<br>We never stopped.
    </h1>
    <p class="text-white/60 text-base leading-relaxed max-w-2xl">
      Founded in 2009 by a small group of lawyers and community organisers, we've grown into a team of 80+ staff and volunteers working across four continents.
    </p>
  </div>
</section>


<!-- OUR STORY -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
    <div class="sr-l">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-4">Our Story</p>
      <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-ink leading-tight mb-5">
        Built from the ground up, not the top down.
      </h2>
      <div class="space-y-4 text-gray-600 text-sm sm:text-base leading-relaxed">
        <p>We didn't start with a strategy document or a five-year plan. We started because a community in rural Kenya was being evicted from land their families had farmed for generations, and no one was helping them fight back.</p>
        <p>That case took three years. We lost twice before we won. But we won — and the community kept their land. That experience shaped everything about how we work: slow, careful, community-led, and in it for the long haul.</p>
        <p>Today we work on gender justice, civic freedoms, economic rights, and refugee protection. The issues are different. The approach is the same.</p>
      </div>
    </div>
    <div class="sr-r space-y-4">
      <div class="bg-slate border border-gray-200 rounded-lg p-6">
        <h3 class="font-serif text-xl font-semibold text-ink mb-2">What we're working toward</h3>
        <p class="text-gray-600 text-sm leading-relaxed">A world where no one needs an organisation like ours — because rights are protected, institutions are accountable, and communities have the power to defend themselves.</p>
      </div>
      <div class="bg-slate border border-gray-200 rounded-lg p-6">
        <h3 class="font-serif text-xl font-semibold text-ink mb-2">How we actually work</h3>
        <p class="text-gray-600 text-sm leading-relaxed">We don't fly in, run a workshop, and leave. We hire locally, build relationships over years, and measure success by what communities can do without us — not by how many reports we publish.</p>
      </div>
    </div>
  </div>
</section>


<!-- VALUES -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-slate border-y border-gray-200">
  <div class="max-w-6xl mx-auto">
    <div class="mb-10 sr">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">How We Work</p>
      <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-ink leading-tight">
        A few things we actually believe in.
      </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <?php foreach ([
        ['Equity over equality',         'Treating everyone the same ignores the fact that some people start from a much harder place. We try to address that gap, not paper over it.'],
        ['Nothing about us without us',  'Every programme we run is designed with the people it\'s meant to serve. If they\'re not in the room, we\'re not in the room.'],
        ['Radical transparency',         'We publish our financials, our failures, and our methodology. If we can\'t explain what we\'re doing and why, we probably shouldn\'t be doing it.'],
        ['Accountability goes both ways', 'We hold governments accountable. We also hold ourselves accountable — to our funders, our partners, and most importantly, the communities we serve.'],
      ] as $i=>[$title,$desc]): ?>
      <div class="bg-white border border-gray-200 rounded-lg p-6 sr" style="transition-delay:<?= $i*70 ?>ms">
        <h3 class="font-serif text-lg font-semibold text-ink mb-2"><?= $title ?></h3>
        <p class="text-gray-600 text-sm leading-relaxed"><?= $desc ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- TRACK RECORD -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white">
  <div class="max-w-6xl mx-auto">
    <div class="mb-10 sr">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">Track Record</p>
      <h2 class="font-serif text-3xl sm:text-4xl font-semibold text-ink leading-tight">
        Some of what we've actually done.
      </h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php foreach ([
        ['Legal Victories',
         'Won landmark cases on land rights in Kenya, Uganda, and Colombia. Secured asylum for over 1,200 individuals facing persecution. Challenged unlawful detention practices in three countries.'],
        ['Community Programmes',
         'Trained 4,000+ community paralegals across Sub-Saharan Africa and South Asia. Ran 200+ legal aid clinics in underserved areas. Supported 150 grassroots organisations to register and operate legally.'],
        ['Policy Change',
         'Contributed to legislative reforms in 12 countries. Submitted evidence to UN treaty bodies 30+ times. Co-authored reports cited in parliamentary debates and court judgments.'],
      ] as $i=>[$title,$desc]): ?>
      <div class="border border-gray-200 rounded-lg p-6 sr" style="transition-delay:<?= $i*80 ?>ms">
        <h3 class="font-serif text-xl font-semibold text-ink mb-3"><?= $title ?></h3>
        <p class="text-gray-600 text-sm leading-relaxed"><?= $desc ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- PHILOSOPHY -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-navy text-white">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-start sr">
    <div>
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-4">Our Approach</p>
      <h2 class="font-serif text-3xl sm:text-4xl font-semibold leading-tight mb-5">
        We don't believe in saviour organisations.
      </h2>
      <p class="text-white/60 leading-relaxed text-sm mb-4">
        The most effective human rights work happens when communities lead it. Our job is to provide resources, expertise, and solidarity — not to take over.
      </p>
      <p class="text-white/60 leading-relaxed text-sm">
        That means sometimes stepping back. It means funding local organisations instead of expanding our own. It means celebrating when a community no longer needs us.
      </p>
    </div>
    <div class="space-y-3">
      <?php foreach ([
        ['Local leadership first',   'Every programme is led by people from the community it serves. We provide support, not direction.'],
        ['Evidence, not assumptions','We research before we act. We document what works and what doesn\'t — and we publish both.'],
        ['Long-term commitment',     'We don\'t do short-term projects. If we can\'t commit to at least three years, we don\'t start.'],
      ] as [$title,$desc]): ?>
      <div class="border border-white/15 rounded-lg p-5">
        <h4 class="font-semibold text-white text-sm mb-1"><?= $title ?></h4>
        <p class="text-white/50 text-sm leading-relaxed"><?= $desc ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- CTA -->
<section class="py-14 px-5 sm:px-8 bg-white border-t border-gray-200">
  <div class="max-w-2xl mx-auto text-center sr">
    <h2 class="font-serif text-3xl font-semibold text-ink mb-3">Want to work with us?</h2>
    <p class="text-gray-500 text-sm mb-6">We're always looking for partners, researchers, funders, and volunteers who share our values. Drop us a message — we read everything.</p>
    <a href="<?= SITE_URL ?>/contact" class="inline-flex items-center gap-2 bg-navy text-white font-semibold px-7 py-3 rounded hover:bg-blue transition-colors text-sm">
      Get in Touch <i class="fa-solid fa-arrow-right text-xs"></i>
    </a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
