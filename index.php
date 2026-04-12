<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'Home — ' . SITE_NAME;
$blogs = $db->blogs->find(['published'=>true],['sort'=>['created_at'=>-1],'limit'=>3])->toArray();
include __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="bg-warm border-b border-gray-200">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 sm:py-20">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

      <!-- Left -->
      <div class="space-y-6">
        <p class="text-blue text-sm font-semibold tracking-wide uppercase">Working in 40+ countries since 2009</p>

        <h1 class="font-serif text-ink text-4xl sm:text-5xl leading-tight font-semibold">
          When rights are violated,<br>
          someone has to show up.
        </h1>

        <p class="text-gray-600 text-base leading-relaxed max-w-md">
          We work alongside communities facing discrimination, displacement, and injustice — providing legal support, policy advocacy, and research that holds governments accountable.
        </p>

        <div class="flex flex-wrap gap-3 pt-1">
          <a href="<?= SITE_URL ?>/blog" class="bg-navy text-white text-sm font-semibold px-6 py-3 rounded hover:bg-blue transition-colors">
            Read Our Research
          </a>
          <a href="<?= SITE_URL ?>/contact" class="border border-gray-300 text-ink text-sm font-semibold px-6 py-3 rounded hover:border-navy hover:text-navy transition-colors">
            Get Involved
          </a>
        </div>

      </div>

      <!-- Right: image -->
      <div class="sr-r">
        <div class="rounded-lg overflow-hidden aspect-[4/3] border border-gray-200 shadow-sm">
          <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&q=80&auto=format&fit=crop"
            alt="Activists marching for human rights"
            class="w-full h-full object-cover" loading="eager">
        </div>
        <div class="grid grid-cols-2 gap-3 mt-3">
          <div class="bg-white border border-gray-200 rounded p-3">
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Current Focus</p>
            <p class="text-sm font-semibold text-ink">Civic Space & Freedoms</p>
          </div>
          <div class="bg-white border border-gray-200 rounded p-3">
            <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Active Region</p>
            <p class="text-sm font-semibold text-ink">Sub-Saharan Africa</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- MARQUEE -->
<div class="bg-navy text-white py-2.5 overflow-hidden border-b border-navy">
  <div class="flex gap-10 whitespace-nowrap" style="animation:marquee 30s linear infinite">
    <?php foreach (array_fill(0,4,['Gender Justice','·','Civic Freedoms','·','Economic Rights','·','Refugee Rights','·','Land Rights','·','Free Press','·']) as $set): foreach($set as $item): ?>
    <span class="text-[11px] font-semibold tracking-widest uppercase text-white/70"><?= $item ?></span>
    <?php endforeach; endforeach; ?>
  </div>
</div>


<!-- WHAT WE DO -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

    <div class="sr-l">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-4">What We Do</p>
      <h2 class="font-serif text-3xl sm:text-4xl text-ink font-semibold leading-tight mb-5">
        We don't just document violations. We fight to end them.
      </h2>
      <p class="text-gray-600 leading-relaxed mb-5 text-sm sm:text-base">
        Since 2009, our teams have worked in conflict zones, courtrooms, and community halls — wherever rights are under threat. We combine legal expertise, field research, and grassroots partnerships to create change that lasts.
      </p>
      <p class="text-gray-600 leading-relaxed mb-8 text-sm sm:text-base">
        Our approach is simple: listen first, act together. We don't parachute in with ready-made solutions. We build long-term relationships with the communities we serve and follow their lead.
      </p>
      <div class="space-y-3">
        <?php foreach ([
          ['Legal Aid & Casework',     'Direct legal support for individuals and communities whose rights have been violated.'],
          ['Policy & Advocacy',        'Engaging governments, UN bodies, and regional institutions to change laws and practices.'],
          ['Research & Documentation', 'Rigorous field research that puts evidence behind advocacy and holds power to account.'],
          ['Community Training',       'Building local capacity so communities can defend their own rights long after we leave.'],
        ] as [$title,$desc]): ?>
        <div class="flex gap-3 py-3 border-b border-gray-100">
          <div class="w-1.5 h-1.5 rounded-full bg-blue mt-2 flex-shrink-0"></div>
          <div>
            <p class="font-semibold text-ink text-sm"><?= $title ?></p>
            <p class="text-gray-500 text-sm mt-0.5"><?= $desc ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="sr-r">
      <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg overflow-hidden aspect-[3/4] col-span-1">
          <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600&q=80&auto=format&fit=crop"
            alt="Human rights march" class="w-full h-full object-cover">
        </div>
        <div class="grid grid-rows-2 gap-3">
          <div class="rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1607748862156-7c548e7e98f4?w=500&q=80&auto=format&fit=crop"
              alt="Women's rights" class="w-full h-full object-cover aspect-square">
          </div>
          <div class="rounded-lg overflow-hidden">
            <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=500&q=80&auto=format&fit=crop"
              alt="Community meeting" class="w-full h-full object-cover aspect-square">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- FOCUS AREAS -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-slate border-y border-gray-200">
  <div class="max-w-6xl mx-auto">
    <div class="mb-10 sr">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">Our Focus Areas</p>
      <h2 class="font-serif text-3xl sm:text-4xl text-ink font-semibold leading-tight">
        Rights don't exist in isolation.<br>Neither does our work.
      </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sr">
      <?php foreach ([
        ['Gender Justice',
         'One in three women globally experiences violence. We work with survivors, train local advocates, and push for legal reform — from domestic violence laws to equal inheritance rights.',
         SITE_URL.'/blog?category=Gender+Justice'],
        ['Governance & Accountability',
         'Corruption kills. When public funds are stolen, hospitals go unstaffed and schools go unbuilt. We track abuses, support whistleblowers, and demand transparent governance.',
         SITE_URL.'/blog?category=Governance'],
        ['Economic Justice',
         'Land grabs, wage theft, and exploitative supply chains strip communities of their livelihoods. We document abuses and advocate for policies that put people before profit.',
         SITE_URL.'/blog?category=Economic+Justice'],
        ['Refugee & Displacement Rights',
         'Over 100 million people are forcibly displaced. We provide legal aid at borders, challenge unlawful deportations, and advocate for durable solutions — not just temporary camps.',
         SITE_URL.'/blog?category=Refugee+Rights'],
      ] as [$title,$desc,$url]): ?>
      <div class="bg-white border border-gray-200 rounded-lg p-6 card-hover">
        <h3 class="font-serif text-xl font-semibold text-ink mb-2"><?= $title ?></h3>
        <p class="text-gray-600 text-sm leading-relaxed mb-4"><?= $desc ?></p>
        <a href="<?= $url ?>" class="text-blue text-sm font-semibold hover:underline inline-flex items-center gap-1">
          Read more <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- IMPACT -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-navy text-white">
  <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    <div class="sr-l">
      <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-4">By the Numbers</p>
      <h2 class="font-serif text-3xl sm:text-4xl font-semibold leading-tight mb-5">
        Fifteen years of showing up where it matters most.
      </h2>
      <p class="text-white/60 leading-relaxed text-sm mb-7">
        These aren't just statistics. Each number represents a family that got legal help, a community that won back its land, a law that changed because someone refused to stay silent.
      </p>
      <a href="<?= SITE_URL ?>/contact" class="inline-flex items-center gap-2 bg-white text-navy text-sm font-semibold px-6 py-3 rounded hover:bg-blue hover:text-white transition-colors">
        Work With Us <i class="fa-solid fa-arrow-right text-xs"></i>
      </a>
    </div>

    <div class="grid grid-cols-2 gap-4 sr-r">
      <?php foreach ([
        ['15+',  'Years on the ground',  'fa-clock'],
        ['40+',  'Countries',            'fa-globe'],
        ['200+', 'Programs & cases',     'fa-folder-open'],
        ['50K+', 'People supported',     'fa-people-group'],
      ] as [$n,$l,$icon]): ?>
      <div class="border border-white/15 rounded-lg p-6">
        <i class="fa-solid <?= $icon ?> text-white/40 text-lg mb-3 block"></i>
        <p class="font-serif text-3xl font-semibold text-white"><?= $n ?></p>
        <p class="text-white/50 text-sm mt-1"><?= $l ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- LATEST ARTICLES -->
<?php if ($blogs): ?>
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white">
  <div class="max-w-6xl mx-auto">
    <div class="flex items-end justify-between mb-10 sr">
      <div>
        <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-2">From Our Team</p>
        <h2 class="font-serif text-3xl sm:text-4xl text-ink font-semibold">Latest Research & Field Reports</h2>
      </div>
      <a href="<?= SITE_URL ?>/blog" class="text-sm font-semibold text-navy hover:text-blue transition-colors hidden sm:block">
        All articles →
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php foreach ($blogs as $i=>$blog): ?>
      <article class="group flex flex-col border border-gray-200 rounded-lg overflow-hidden card-hover sr" style="transition-delay:<?= $i*80 ?>ms">
        <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>" class="block aspect-[16/10] bg-slate overflow-hidden flex-shrink-0">
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
          <div class="flex items-center gap-2 mb-3">
            <span class="text-blue text-xs font-semibold"><?= sanitize($blog['category'] ?? 'General') ?></span>
            <span class="text-gray-400 text-xs">· <?= date('M d, Y', $blog['created_at']->toDateTime()->getTimestamp()) ?></span>
          </div>
          <h3 class="font-serif text-lg font-semibold text-ink mb-2 leading-snug group-hover:text-blue transition-colors flex-1">
            <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>"><?= sanitize($blog['title']) ?></a>
          </h3>
          <p class="text-gray-500 text-sm leading-relaxed mb-4"><?= sanitize(substr($blog['excerpt']??'',0,100)) ?>...</p>
          <a href="<?= SITE_URL ?>/single-blog?slug=<?= sanitize($blog['slug']) ?>"
            class="text-blue text-sm font-semibold hover:underline mt-auto">
            Read article →
          </a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="mt-6 sm:hidden text-center">
      <a href="<?= SITE_URL ?>/blog" class="text-sm font-semibold text-navy hover:text-blue">All articles →</a>
    </div>
  </div>
</section>
<?php endif; ?>


<!-- PULL QUOTE -->
<section class="relative py-20 px-5 sm:px-8 overflow-hidden">
  <div class="absolute inset-0">
    <img src="https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=1800&q=80&auto=format&fit=crop"
      alt="" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-navy/80"></div>
  </div>
  <div class="relative max-w-3xl mx-auto text-center sr">
    <p class="text-white/40 text-4xl font-serif mb-5">"</p>
    <blockquote class="font-serif text-xl sm:text-2xl text-white leading-relaxed font-medium">
      Human rights are not a privilege conferred by government. They are every human being's entitlement by virtue of their humanity.
    </blockquote>
    <p class="text-white/50 text-sm mt-6">— Mother Teresa</p>
  </div>
</section>


<!-- NEWSLETTER -->
<section class="py-16 sm:py-20 px-5 sm:px-8 bg-white border-t border-gray-200">
  <div class="max-w-xl mx-auto text-center sr">
    <p class="text-blue text-sm font-semibold tracking-wide uppercase mb-3">Stay in the Loop</p>
    <h2 class="font-serif text-3xl text-ink font-semibold mb-3">Get our monthly briefing</h2>
    <p class="text-gray-500 text-sm leading-relaxed mb-7">
      Field updates, new research, and advocacy alerts. One email a month. No filler.
    </p>
    <form class="flex flex-col sm:flex-row gap-3" onsubmit="return false;">
      <input type="email" placeholder="your@email.com"
        class="flex-1 border border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue/30 focus:border-blue">
      <button class="bg-navy text-white font-semibold px-6 py-3 rounded hover:bg-blue transition-colors text-sm whitespace-nowrap">
        Subscribe
      </button>
    </form>
    <p class="text-gray-400 text-xs mt-3">No spam. Unsubscribe any time.</p>
  </div>
</section>


<!-- CTA -->
<section class="py-14 px-5 sm:px-8 bg-slate border-t border-gray-200">
  <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 sr">
    <div>
      <h2 class="font-serif text-2xl sm:text-3xl text-ink font-semibold mb-1">
        Have a case, a story, or a partnership in mind?
      </h2>
      <p class="text-gray-500 text-sm">We respond to every message. Usually within 48 hours.</p>
    </div>
    <a href="<?= SITE_URL ?>/contact" class="flex-shrink-0 bg-navy text-white font-semibold px-7 py-3 rounded hover:bg-blue transition-colors text-sm">
      Contact Us
    </a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
