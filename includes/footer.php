</main>
<?php include __DIR__ . '/event-popup.php'; ?>

<footer class="bg-navy text-white mt-auto">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

    <!-- Brand -->
    <div class="sm:col-span-2">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 bg-white/15 rounded flex items-center justify-center flex-shrink-0">
          <i class="fa-solid fa-scale-balanced text-white text-xs"></i>
        </div>
        <div>
          <span class="font-serif font-semibold text-white text-base leading-none block"><?= SITE_NAME ?></span>
          <span class="text-[9px] text-white/40 tracking-widest uppercase leading-none block mt-0.5">Est. 2009</span>
        </div>
      </div>
      <p class="text-white/50 text-sm leading-relaxed max-w-xs mb-5">
        Working alongside communities facing discrimination, displacement, and injustice — in 40+ countries since 2009.
      </p>
      <div class="flex gap-3">
        <?php foreach ([['fa-twitter','#'],['fa-linkedin','#'],['fa-facebook','#'],['fa-instagram','#']] as [$icon,$url]): ?>
        <a href="<?= $url ?>" class="w-8 h-8 rounded border border-white/20 flex items-center justify-center text-white/50 hover:text-white hover:border-white/50 transition text-xs">
          <i class="fa-brands <?= $icon ?>"></i>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Links -->
    <div>
      <p class="text-xs font-semibold text-white/30 uppercase tracking-widest mb-4">Pages</p>
      <ul class="space-y-2.5 text-sm text-white/55">
        <?php foreach ([['Home',SITE_URL.'/'],['About',SITE_URL.'/about'],['Insights',SITE_URL.'/blog'],['Contact',SITE_URL.'/contact']] as [$l,$u]): ?>
        <li><a href="<?= $u ?>" class="hover:text-white transition-colors"><?= $l ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Focus areas -->
    <div>
      <p class="text-xs font-semibold text-white/30 uppercase tracking-widest mb-4">Our Work</p>
      <ul class="space-y-2.5 text-sm text-white/55">
        <?php foreach (['Gender Justice','Governance & Accountability','Economic Justice','Refugee Rights','Civic Freedoms'] as $a): ?>
        <li><?= $a ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <div class="border-t border-white/10 max-w-6xl mx-auto px-5 sm:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/30">
    <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
    <p>Registered NGO · Nairobi · London · Bogotá</p>
  </div>
</footer>

<script>
  document.getElementById('menuBtn')?.addEventListener('click', () => document.getElementById('mobileMenu').classList.toggle('hidden'));
</script>
</body>
</html>
