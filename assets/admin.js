feather.replace();

// Viser én sektion ad gangen
function showSection(sectionId) {
    document.querySelectorAll('section').forEach((section) => section.classList.add('hidden'));
    document.getElementById(sectionId).classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function confirmDelete(type, id) {
    const deleteLink = document.querySelector('#deleteModal a');
    deleteLink.onclick = function(e) {
        const url = deleteLink.getAttribute("data-delete-url");
        window.location.href = url + "?type=" + encodeURIComponent(type) + "&id=" + encodeURIComponent(id);
    }
    // deleteLink.href = `<?php echo generateUrl("admin-delete") ?>?type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}`;
    openModal('deleteModal');
}

// Åbn/Luk modaler
// Finder modalens indre boks
function getModalBox(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return null;

    // Prøv først at finde .modal-box
    let box = modal.querySelector('.modal-box');
    if (box) return box;

    // Fallback: første mørke container med rounded
    const candidates = modal.querySelectorAll('div');
    for (const c of candidates) {
    const hasDark = c.className && (c.className.includes('bg-[#1a1a1a]') || c.className.includes('bg-gray-900'));
    const looksLikeBox = c.className && c.className.includes('rounded');
    if (hasDark && looksLikeBox) return c;
    }
    return modal.querySelector('div');
}

// Giver mørk styling til alle inputs/selects/textarea i containeren
function applyFieldStyles(container) {
    if (!container) return;
    container.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(el => {
    if (el.tagName === 'SELECT') el.classList.add('rb-select');
    else if (el.tagName === 'TEXTAREA') el.classList.add('rb-textarea');
    else el.classList.add('rb-input');
    });
}

// Åbn modal → viser + pink ring + mørk styling
function openModal(id, sender) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('hidden');

    const box = getModalBox(id);
    if (box) {
    box.classList.add('rb-modal-ring');
    applyFieldStyles(box);
    }

    // Behold din egen prefill-logik
    if (sender) {
    const row = sender.closest('tr');
    if (row && box) {
        row.querySelectorAll('[data-form-field]').forEach(field => {
        const name = field.getAttribute('data-form-field');
        const target = box.querySelector(`[name="${name}"]`);
        if (target) target.value = field.textContent.trim();
        });
    }
    }
}

// Luk modal → skjul + fjern pink ring
function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');

    const box = getModalBox(id);
    if (box) box.classList.remove('rb-modal-ring');
}

// Standardvisning
showSection('movies');