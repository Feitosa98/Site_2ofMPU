    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col" style="text-align: left;">
                    <div class="footer-logo">
                        <i class="fa-solid fa-scale-balanced" style="color: var(--secondary);"></i> 2º Ofício
                    </div>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Compromisso com a verdade, segurança e eficácia dos atos jurídicos. Servindo a população de Manacapuru com excelência.</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com/cartorio2oficiomanacapuru/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Links Rápidos</h4>
                    <ul>
                        <li><a href="/#inicio">Início</a></li>
                        <li><a href="/#servicos">Atribuições</a></li>
                        <li><a href="/#missao">Missão e Valores</a></li>
                        <li><a href="/#contato">Contato</a></li>
                        <li><a href="https://cidadao.portalseloam.com.br/#/" target="_blank">Portal do Selo (AM)</a></li>
                        <li style="margin-top: 15px;"><a href="admin/login" style="opacity: 0.7;"><i class="fa-solid fa-lock" style="font-size: 0.8rem; margin-right: 5px;"></i>Portal Administrativo</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Serviços</h4>
                    <ul>
                        <li><a href="imoveis">Registro de Imóveis</a></li>
                        <li><a href="rcpn">Registro Civil</a></li>
                        <li><a href="rtdpj">Pessoas Jurídicas</a></li>
                        <li><a href="rtdpj">Títulos e Documentos</a></li>
                        <li><a href="https://ridigital.org.br/" target="_blank" rel="noopener noreferrer">Solicitar Certidão (ONR)</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright" style="display: flex; flex-direction: column; gap: 8px;">
                <span>&copy; 2026 Cartório 2º Ofício de Manacapuru. Todos os direitos reservados.</span>
                <span style="font-size: 0.85rem; color: #64748b;">Desenvolvido por <a href="https://feitosasolucoes.com.br/" target="_blank" style="color: #cbd5e1; font-weight: 500; text-decoration: none;">Feitosa Soluções em Informática</a></span>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button & Menu -->
    <div class="whatsapp-container">
        <div class="whatsapp-menu" id="whatsappMenu">
            <div class="whatsapp-menu-header">Qual setor deseja falar?</div>
            <a href="https://wa.me/5592985366100" target="_blank" class="whatsapp-link">
                <i class="fa-brands fa-whatsapp"></i>
                <div class="wa-text">
                    <strong>RCPN</strong>
                    <span>(92) 98536-6100</span>
                </div>
            </a>
            <a href="https://wa.me/5592984254805" target="_blank" class="whatsapp-link">
                <i class="fa-brands fa-whatsapp"></i>
                <div class="wa-text">
                    <strong>RI e TDPJ</strong>
                    <span>(92) 98425-4805</span>
                </div>
            </a>
        </div>
        <div class="whatsapp-tooltip">Precisa de ajuda?</div>
        <!-- Utilizando o ícone SVG mais nítido para a "bola do WhatsApp" -->
        <button class="whatsapp-float pulse-anim" id="whatsappBtn" aria-label="Fale conosco no WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 32px; height: 32px; fill: white;"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157.1zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
        </button>
    </div>
    <script>
        function toggleWhatsappMenu(e) {
            e.preventDefault();
            document.getElementById('whatsappMenu').classList.toggle('active');
            document.querySelector('.whatsapp-tooltip').style.opacity = '0';
        }

        document.getElementById('whatsappBtn').addEventListener('click', toggleWhatsappMenu);

        const openWhatsappMenuBtn = document.getElementById('openWhatsappMenuBtn');
        if (openWhatsappMenuBtn) {
            openWhatsappMenuBtn.addEventListener('click', toggleWhatsappMenu);
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.whatsapp-container') && !e.target.closest('#openWhatsappMenuBtn')) {
                const wMenu = document.getElementById('whatsappMenu');
                if(wMenu) wMenu.classList.remove('active');
            }
        });
        
        // Tooltip logic
        setTimeout(() => {
            const tooltip = document.querySelector('.whatsapp-tooltip');
            if(tooltip) tooltip.classList.add('show');
            setTimeout(() => {
                if(tooltip) tooltip.classList.remove('show');
            }, 6000);
        }, 3000);
    </script>
    <script src="script.js" defer></script>
    <?= $extra_js ?? '' ?>
</body>
</html>
