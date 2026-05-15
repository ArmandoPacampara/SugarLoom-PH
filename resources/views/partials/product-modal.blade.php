<div class="product-modal" id="productModal" aria-hidden="true">
    <div class="product-modal__overlay" data-product-modal-close></div>
    <div class="product-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="productModalTitle">
        <button type="button" class="product-modal__close" data-product-modal-close aria-label="Close product details">&times;</button>
        <div class="product-modal__media">
            <img id="productModalImage" src="" alt="">
            <span class="product-modal__price" id="productModalPrice"></span>
        </div>
        <div class="product-modal__content">
            <p class="product-modal__eyebrow" id="productModalCategory"></p>
            <h2 id="productModalTitle"></h2>
            <p class="product-modal__description" id="productModalDescription"></p>
            <p class="product-modal__stock" id="productModalStock"></p>

            <div class="product-modal__quantity" aria-label="Quantity selector">
                <button type="button" data-product-qty-minus aria-label="Decrease quantity">-</button>
                <input type="number" id="productModalQuantity" value="1" min="1" inputmode="numeric">
                <button type="button" data-product-qty-plus aria-label="Increase quantity">+</button>
            </div>

            <button type="button" class="product-modal__add" id="productModalAdd">Add to Cart</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('productModal');
    if (!modal || modal.dataset.ready) {
        return;
    }

    modal.dataset.ready = 'true';

    var state = { productId: null, stock: 1 };
    var image = document.getElementById('productModalImage');
    var title = document.getElementById('productModalTitle');
    var description = document.getElementById('productModalDescription');
    var price = document.getElementById('productModalPrice');
    var category = document.getElementById('productModalCategory');
    var stock = document.getElementById('productModalStock');
    var quantity = document.getElementById('productModalQuantity');
    var addButton = document.getElementById('productModalAdd');

    function peso(value) {
        return 'PHP ' + Number(value || 0).toLocaleString('en-PH', { maximumFractionDigits: 0 });
    }

    function clampQuantity(value) {
        var parsed = parseInt(value, 10);
        if (Number.isNaN(parsed) || parsed < 1) {
            parsed = 1;
        }
        return Math.min(parsed, state.stock);
    }

    function setQuantity(value) {
        quantity.value = clampQuantity(value);
    }

    function openProductModal(button) {
        state.productId = button.dataset.productId;
        state.stock = Math.max(1, parseInt(button.dataset.productStock || '1', 10));

        image.src = button.dataset.productImage || '';
        image.alt = button.dataset.productName || 'Product image';
        title.textContent = button.dataset.productName || 'Product details';
        description.textContent = button.dataset.productDescription || 'Freshly prepared by SugarLoom PH.';
        price.textContent = peso(button.dataset.productPrice);
        category.textContent = (button.dataset.productCategory || 'Catalog item').replace(/^\w/, function(letter) {
            return letter.toUpperCase();
        });
        stock.textContent = state.stock + ' in stock';
        setQuantity(1);
        addButton.disabled = false;
        addButton.textContent = 'Add to Cart';

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        quantity.focus();
    }

    window.openProductModal = openProductModal;

    function closeProductModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    document.addEventListener('click', function(event) {
        var opener = event.target.closest('[data-product-modal]');
        if (opener && !opener.disabled) {
            event.preventDefault();
            openProductModal(opener);
            return;
        }

        if (event.target.closest('[data-product-modal-close]')) {
            closeProductModal();
        }
    });

    document.querySelector('[data-product-qty-minus]').addEventListener('click', function() {
        setQuantity(parseInt(quantity.value, 10) - 1);
    });

    document.querySelector('[data-product-qty-plus]').addEventListener('click', function() {
        setQuantity(parseInt(quantity.value, 10) + 1);
    });

    quantity.addEventListener('input', function() {
        setQuantity(quantity.value);
    });

    addButton.addEventListener('click', function() {
        if (!state.productId || typeof window.addToCart !== 'function') {
            return;
        }

        addButton.disabled = true;
        addButton.textContent = 'Adding...';

        window.addToCart(state.productId, parseInt(quantity.value, 10))
            .then(function(data) {
                if (data && data.success === false) {
                    addButton.disabled = false;
                    addButton.textContent = 'Add to Cart';
                    return;
                }

                addButton.textContent = 'Added';
                setTimeout(closeProductModal, 450);
            })
            .catch(function() {
                addButton.disabled = false;
                addButton.textContent = 'Add to Cart';
            });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeProductModal();
        }
    });
});
</script>
