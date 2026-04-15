</main>
<?php include __DIR__ . '/event-popup.php'; ?>

<footer class="mt-auto reveal bg-[#0F243C] text-white border-t border-white/10">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 py-12 sm:py-14">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 sm:gap-8">

      <div class="md:col-span-2 lg:col-span-2 sr-l">
        <a href="<?= SITE_URL ?>/" class="inline-flex items-center gap-3 mb-4">
          <div class="w-9 h-9 border border-white/20 rounded-lg flex items-center justify-center flex-shrink-0 bg-white/5">
            <i class="fa-solid fa-scale-balanced text-white text-xs"></i>
          </div>
          <div>
            <span class="font-serif font-semibold text-white text-base leading-none block"><?= SITE_NAME ?></span>
            <span class="text-[10px] text-white/45 tracking-[0.16em] uppercase leading-none block mt-1">Est. 2009</span>
          </div>
        </a>

        <p class="text-white/70 text-sm leading-relaxed max-w-md mb-5">
          Human rights advocacy, legal support, and policy research for communities facing discrimination, displacement, and injustice.
        </p>

        <p class="text-xs text-white/50 uppercase tracking-[0.14em]">Nairobi - London - Bogota</p>

        <div class="mt-5 flex items-center gap-2.5">
          <?php foreach ([['fa-twitter','#'],['fa-linkedin','#'],['fa-facebook','#'],['fa-instagram','#']] as [$icon,$url]): ?>
            <a href="<?= $url ?>" class="w-8 h-8 rounded border border-white/20 flex items-center justify-center text-white/60 hover:text-white hover:border-white/50 transition text-xs">
              <i class="fa-brands <?= $icon ?>"></i>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="sr" style="transition-delay:70ms">
        <p class="text-xs font-semibold text-white/45 uppercase tracking-[0.16em] mb-4">Navigate</p>
        <ul class="space-y-2.5 text-sm text-white/75">
          <?php foreach ([['Home',SITE_URL.'/'],['About',SITE_URL.'/about'],['Insights',SITE_URL.'/blog'],['Contact',SITE_URL.'/contact']] as [$l,$u]): ?>
            <li><a href="<?= $u ?>" class="hover:text-white transition-colors"><?= $l ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="sr" style="transition-delay:130ms">
        <p class="text-xs font-semibold text-white/45 uppercase tracking-[0.16em] mb-4">Focus Areas</p>
        <ul class="space-y-2.5 text-sm text-white/70">
          <?php foreach (['Gender Justice','Governance','Economic Rights','Refugee Rights','Civic Freedoms'] as $a): ?>
            <li><?= $a ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="mt-8 pt-5 border-t border-white/12 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs text-white/45">
      <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
      <p>Registered NGO</p>
    </div>
  </div>
</footer>
</body>
</html>
