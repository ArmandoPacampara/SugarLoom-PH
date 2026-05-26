<div id="confirmationModal" class="confirmation-modal">
    <div class="confirmation-modal__overlay"></div>
    <div class="confirmation-modal__dialog">
        <div class="confirmation-modal__header">
            <h3 id="confirmationModalTitle">Confirm Action</h3>
            <button type="button" class="confirmation-modal__close" onclick="closeConfirmationModal()">×</button>
        </div>
        <div class="confirmation-modal__body">
            <p id="confirmationModalMessage">Are you sure you want to proceed with this action?</p>
        </div>
        <div class="confirmation-modal__footer">
            <button type="button" class="btn-confirm-cancel" onclick="closeConfirmationModal()">Cancel</button>
            <button type="button" id="confirmationModalConfirmBtn" class="btn-confirm-proceed">Confirm</button>
        </div>
    </div>
</div>

<style>
    .confirmation-modal {
        position: fixed;
        inset: 0;
        z-index: 20000;
        display: none;
        place-items: center;
        padding: 1.5rem;
    }

    .confirmation-modal.is-open {
        display: grid;
    }

    .confirmation-modal__overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .confirmation-modal__dialog {
        position: relative;
        background: white;
        border-radius: 20px;
        width: min(450px, 100%);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        animation: modalIn 0.3s ease-out;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .confirmation-modal__header {
        padding: 20px 24px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .confirmation-modal__header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #1f2937;
    }

    .confirmation-modal__close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #9ca3af;
    }

    .confirmation-modal__body {
        padding: 24px;
        color: #4b5563;
        line-height: 1.5;
    }

    .confirmation-modal__footer {
        padding: 16px 24px;
        background: #f9fafb;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-confirm-cancel {
        padding: 10px 20px;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm-proceed {
        padding: 10px 24px;
        border-radius: 999px;
        border: none;
        background: #fb7185;
        color: white;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(251, 113, 133, 0.2);
    }

    .btn-confirm-proceed:hover {
        background: #e11d48;
    }
</style>

<script>
    let confirmationCallback = null;

    function openConfirmationModal(title, message, onConfirm) {
        document.getElementById('confirmationModalTitle').textContent = title;
        document.getElementById('confirmationModalMessage').textContent = message;
        confirmationCallback = onConfirm;
        document.getElementById('confirmationModal').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmationModal() {
        document.getElementById('confirmationModal').classList.remove('is-open');
        document.body.style.overflow = '';
        confirmationCallback = null;
    }

    document.getElementById('confirmationModalConfirmBtn').addEventListener('click', function() {
        if (confirmationCallback) {
            confirmationCallback();
        }
        closeConfirmationModal();
    });

    // Close on overlay click
    document.querySelector('.confirmation-modal__overlay').addEventListener('click', closeConfirmationModal);
</script>
