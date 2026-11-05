            </div>
        </div>
    </div>
    
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around md:hidden pb-safe z-50">
        <a href="<?= base_url('Dashboard') ?>" class="bottom-nav-item <?= ($active_page==='dashboard')?'active':'' ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg><span class="mt-1">Beranda</span></a>
        <a href="<?= base_url('Laporan') ?>" class="bottom-nav-item <?= ($active_page==='laporan')?'active':'' ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/></svg><span class="mt-1">Laporan</span></a>
        <a href="<?= base_url('Chat') ?>" class="bottom-nav-item <?= ($active_page==='chat')?'active':'' ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg><span class="mt-1">Chat</span></a>
        <a href="<?= base_url('Profil') ?>" class="bottom-nav-item <?= ($active_page==='profil')?'active':'' ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="mt-1">Profil</span></a>
    </nav>
</main>

<script>
// Auto-hide alerts after 4s
document.querySelectorAll('.fade-in').forEach(function(el){
    setTimeout(function(){ el.style.transition='opacity .5s'; el.style.opacity='0'; setTimeout(function(){ el.remove(); },500); }, 4000);
});
</script>
</body>
</html>
