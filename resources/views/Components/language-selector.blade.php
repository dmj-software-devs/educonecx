<div class="language-selector-container">
    <div class="language-dropdown">
        <button class="language-toggle" id="languageToggle">
            <span class="current-flag" id="currentFlag">🇺🇸</span>
            <span class="current-language" id="currentLanguage">English</span>
            <i class="fas fa-chevron-down"></i>
        </button>
        
        <div class="language-menu" id="languageMenu">
            <div class="language-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search languages..." id="languageSearch">
            </div>
            
            <div class="language-list" id="languageList">
                <!-- Languages will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
.language-selector-container {
    position: relative;
    display: inline-block;
}

.language-dropdown {
    position: relative;
}

.language-toggle {
    background: var(--white);
    border: 1px solid var(--gray-light);
    border-radius: var(--border-radius-full);
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: var(--transition);
    min-width: 120px;
}

.language-toggle:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-sm);
}

.language-toggle .current-flag {
    font-size: 1.2rem;
}

.language-toggle .current-language {
    font-weight: 500;
    color: var(--dark);
    flex: 1;
}

.language-toggle i {
    color: var(--gray);
    font-size: 0.8rem;
    transition: transform 0.3s;
}

.language-dropdown.active .language-toggle i {
    transform: rotate(180deg);
}

.language-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 280px;
    background: var(--white);
    border-radius: var(--border-radius-md);
    box-shadow: var(--shadow-lg);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: var(--transition);
    z-index: 1000;
    border: 1px solid var(--gray-light);
    overflow: hidden;
}

.language-dropdown.active .language-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.language-search {
    padding: 12px;
    border-bottom: 1px solid var(--gray-light);
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--light);
}

.language-search i {
    color: var(--gray);
    font-size: 0.9rem;
}

.language-search input {
    border: none;
    background: transparent;
    width: 100%;
    outline: none;
    font-size: 0.9rem;
}

.language-search input::placeholder {
    color: var(--gray);
}

.language-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 8px;
}

.language-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: var(--border-radius-sm);
    cursor: pointer;
    transition: var(--transition);
}

.language-item:hover {
    background: var(--light);
}

.language-item.active {
    background: rgba(67, 97, 238, 0.1);
    color: var(--primary);
}

.language-item .flag {
    font-size: 1.2rem;
}

.language-item .language-name {
    flex: 1;
    font-weight: 500;
}

.language-item .native-name {
    color: var(--gray);
    font-size: 0.85rem;
}

.language-item i {
    color: var(--primary);
    opacity: 0;
    transition: var(--transition);
}

.language-item.active i {
    opacity: 1;
}

/* Dark mode support */
.dark-mode .language-toggle {
    background: var(--dark-light);
    border-color: var(--dark);
    color: var(--white);
}

.dark-mode .language-menu {
    background: var(--dark-light);
    border-color: var(--dark);
}

.dark-mode .language-search {
    background: var(--dark);
    border-bottom-color: var(--dark-light);
}

.dark-mode .language-item:hover {
    background: var(--dark);
}

/* Responsive */
@media (max-width: 768px) {
    .language-toggle {
        padding: 6px 12px;
        min-width: 100px;
    }
    
    .language-toggle .current-language {
        font-size: 0.85rem;
    }
    
    .language-menu {
        width: 250px;
        right: -50px;
    }
}

@media (max-width: 576px) {
    .language-menu {
        position: fixed;
        top: auto;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        max-height: 80vh;
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        transform: translateY(100%);
    }
    
    .language-dropdown.active .language-menu {
        transform: translateY(0);
    }
    
    .language-list {
        max-height: 60vh;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Language data
    const languages = {
        'en': { name: 'English', flag: '🇺🇸', native: 'English' },
        'es': { name: 'Spanish', flag: '🇪🇸', native: 'Español' },
        'fr': { name: 'French', flag: '🇫🇷', native: 'Français' },
        'de': { name: 'German', flag: '🇩🇪', native: 'Deutsch' },
        'it': { name: 'Italian', flag: '🇮🇹', native: 'Italiano' },
        'pt': { name: 'Portuguese', flag: '🇵🇹', native: 'Português' },
        'nl': { name: 'Dutch', flag: '🇳🇱', native: 'Nederlands' },
        'pl': { name: 'Polish', flag: '🇵🇱', native: 'Polski' },
        'ru': { name: 'Russian', flag: '🇷🇺', native: 'Русский' },
        'ja': { name: 'Japanese', flag: '🇯🇵', native: '日本語' },
        'zh': { name: 'Chinese', flag: '🇨🇳', native: '中文' }
    };

    let currentLanguage = 'en';
    
    // Fetch current language from server
    fetch('{{ route("language.current") }}')
        .then(response => response.json())
        .then(data => {
            currentLanguage = data.current;
            updateLanguageDisplay(currentLanguage, data.info);
            populateLanguageList(currentLanguage);
        })
        .catch(error => {
            console.error('Error fetching language:', error);
            // Fallback to English
            populateLanguageList('en');
        });

    // Toggle dropdown
    const toggle = document.getElementById('languageToggle');
    const dropdown = document.querySelector('.language-dropdown');
    
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Search functionality
    const searchInput = document.getElementById('languageSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterLanguages(this.value);
        });
    }

    // Populate language list
    function populateLanguageList(activeLang) {
        const list = document.getElementById('languageList');
        if (!list) return;
        
        list.innerHTML = '';
        
        Object.entries(languages).forEach(([code, lang]) => {
            const item = document.createElement('div');
            item.className = `language-item ${code === activeLang ? 'active' : ''}`;
            item.dataset.lang = code;
            
            item.innerHTML = `
                <span class="flag">${lang.flag}</span>
                <span class="language-name">${lang.name}</span>
                <span class="native-name">${lang.native}</span>
                ${code === activeLang ? '<i class="fas fa-check"></i>' : ''}
            `;
            
            item.addEventListener('click', function() {
                switchLanguage(code);
            });
            
            list.appendChild(item);
        });
    }

    // Filter languages based on search
    function filterLanguages(searchTerm) {
        const items = document.querySelectorAll('.language-item');
        const term = searchTerm.toLowerCase();
        
        items.forEach(item => {
            const name = item.querySelector('.language-name').textContent.toLowerCase();
            const native = item.querySelector('.native-name').textContent.toLowerCase();
            
            if (name.includes(term) || native.includes(term)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Switch language
    function switchLanguage(lang) {
        // Show loading indicator
        const toggle = document.getElementById('languageToggle');
        const originalText = toggle.innerHTML;
        toggle.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        toggle.disabled = true;
        
        // Redirect to language switch route
        window.location.href = `{{ url("language") }}/${lang}`;
    }

    // Update language display
    function updateLanguageDisplay(code, info) {
        const flagEl = document.getElementById('currentFlag');
        const langEl = document.getElementById('currentLanguage');
        
        if (flagEl) flagEl.textContent = info.flag;
        if (langEl) langEl.textContent = info.native;
    }
});
</script>